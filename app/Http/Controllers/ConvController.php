<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conv;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;
use Illuminate\Http\Request;
use Sentinel;
use Illuminate\Support\Facades\Input;
use stdClass;
use TBMsg;
use Session;

class ConvController extends Controller
{

    public function __construct()
    {
        $this->middleware('sentinel.auth');
    }

     /**
     * Display a list of current user's conversations.
     *
     * @param  none
     * @return View
     */
    public function index()
    {
        $convs = TBMsg::getUserConversations(Sentinel::getUser()->id);
        $participants = [];
        $finalParticipants = [];
        foreach ($convs as $conv) {
            $participants = $this->getUniqueParticipants($participants, $conv->getAllParticipants());
            $conv->participant = User::getParticipants($participants);
        }
        return view('convs.index', ['convs' => $convs]);
    }

    /**
     * Display a list of public conversations
     *
     * @param  none
     * @return View
     */
    public function getPublicConvs()
    {
        $convs = Conv::getPublicConvs();

        return view('convs.public', ['convs' => $convs]);
    }
    /**
     * Show a conversation between users.
     *
     * @param  integer  $id
     * @return View
     */
    public function show($id)
    {
        $conv = TBMsg::getConversationMessages($id, Sentinel::getUser()->id);

        if (count($conv->getNumOfParticipants()) == 0) {
            return redirect(route('convs.index'));
        }
        $history = [];
        $messages = $conv->getAllMessages();
        foreach ($messages as $message) {
            $msg = new stdClass();

            $msg->content = $message->getContent();
            $msg->senderId = $message->getSender();
            $msg->status = $message->getStatus();
            $msg->created = $message->getCreated();
            TBMsg::markMessageAsRead($message->getId(), Sentinel::getUser()->id);
            array_push($history, $msg);
        }

        $conv = Conv::find($id);

        return view('convs.show', ['messages' => $history, 'conv'=>$conv]);
    }

    public function addMessage(Request $request, $id)
    {
        $conv = TBMsg::addMessageToConversation($id, Sentinel::getUser()->id, $request->input('message'));
        if (Sentinel::inRole('user')) {
            Conv::setConvAttribute($id, 'public', $request->has('public'));
        }
        return redirect(route('convs.show', ['id' => $id]));
    }

     /**
     * Create conversation between users.
     *
     * @param  None
     * @return View
     */
    public function create()
    {
        $inactiveConvs = Conv::whereDoesntHave('messages')->get();

        foreach ($inactiveConvs as $index => $inactiveConv) {
            $inactiveConv->delete();
        }

        $experts = User::listExpertsFromLastWeek()->toArray();
        $experts = array_map([$this,"getUserId"], $experts);
        array_unshift($experts, Sentinel::getUser()->id);
        $conv = TBMsg::createConversation(
            $experts
        );
        // return $conv;
        return redirect(route('convs.show', ['id' => $conv['convId']]));
    }

    /**
     * Close a conversation and forward it or not.
     *
     * @param  Request $request, integer $id
     * @return Response|Redirect
     */
    public function close(Request $request, $id)
    {
        if (Sentinel::inRole('user')) {
            Conv::setConvAttribute($id, 'satisfied', $request->input('satisfied'));
            if ($request->input('satisfied')) {
                Conv::setConvAttribute($id, 'closed', 1);
                return redirect(route('home'));
            } else {
                Session::put('expert', $request->input('expertId'));
                Session::put('conv', $id);
                Conv::setConvAttribute($id, 'further', 1);
                return redirect(route('forms.create'));
            }
        }
    }

     /**
     * Return user id.
     *
     * @param  App/Models/User  $user
     * @return Integer id
     */
    protected function getUserId($user)
    {
        return $user['id'];
    }

     /**
     * Filter and return unique particpants.
     *
     * @param  Array $uniqueParticipants, Array $aParticipant
     * @return View
     */
    protected function getUniqueParticipants($aUniqueParticipant, $aPartcipant)
    {
        $aUniqueParticipant = array_merge($aUniqueParticipant, $aPartcipant);
        //making sure each user appears only once
        $aUniqueParticipant = array_unique($aUniqueParticipant);

        return $aUniqueParticipant;
    }
}
