<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ConvController;
use App\Models\Form;
use App\Models\Conv;
use Carbon\Carbon;
use Mail;
use Sentinel;
use TBMsg;
use App\Http\Requests;
use Centaur\AuthManager;
use App\Models\User;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;

class UserController extends Controller
{
    /** @var Cartalyst\Sentinel\Users\IlluminateUserRepository */
    protected $userRepository;

    /** @var Centaur\AuthManager */
    protected $authManager;

    protected $fillable = [
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
        'address',
        'date_of_birth',
        'phone_number',
    ];

    public function __construct(AuthManager $authManager)
    {
        // Middleware
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.access:users.create', ['only' => ['create', 'store']]);
        $this->middleware('sentinel.access:users.view', ['only' => ['index', 'show']]);
        $this->middleware('sentinel.access:users.update', ['only' => ['edit', 'update']]);
        $this->middleware('sentinel.access:users.destroy', ['only' => ['destroy']]);

        // Dependency Injection
        $this->userRepository = app()->make('sentinel.users');
        $this->authManager = $authManager;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->createModel()->paginate(15);

        return view('Centaur::users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = app()->make('sentinel.roles')->createModel()->all();

        return view('Centaur::users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form data
        $result = $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        // Assemble registration credentials
        $credentials = [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'address' => $request->get('address'),
            'date_of_birth' => $request->get('date_of_birth'),
            'phone_number' => $request->get('phone_number'),
            'email' => trim($request->get('email')),
            'password' => $request->get('password')
        ];
        $activate = (bool)$request->get('activate', false);

        // Attempt the registration
        $result = $this->authManager->register($credentials, $activate);

        if ($result->isFailure()) {
            return $result->dispatch;
        }

        // Do we need to send an activation email?
        if (!$activate) {
            $code = $result->activation->getCode();
            $email = $result->user->email;
            Mail::queue(
                'centaur.email.welcome',
                ['code' => $code, 'email' => $email],
                function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Votre compte à été crée');
                }
            );
        }

        // Assign User Roles
        foreach ($request->get('roles', []) as $slug => $id) {
            $role = Sentinel::findRoleBySlug($slug);
            if ($role) {
                $role->users()->attach($result->user);
            }
        }

        $result->setMessage("User {$request->get('email')} has been created.");
        return $result->dispatch(route('users.index'));
    }

    /**
     * Display the specified user.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // The user detail page has not been included for the sake of brevity.
        // Change this to point to the appropriate view for your project.
        return redirect()->route('users.index');
    }

    public function profile($id)
    {
        $user = Sentinel::getUser();
        $isFind = Form::isFind($id);
        $isNoted = Form::isNoted($id);
        $note = User::getNote($id);
        $convs = TBMsg::getUserConversations(Sentinel::getUser()->id);

        $participants = [];
        $finalParticipants = [];
        $convTmp = "";
        foreach ($convs as $index => $conv) {
            $convTmp = Conv::find($conv->getId());
            if($convTmp->public && $convTmp->satisfied) {
                $participants = $this->getUniqueParticipants($participants, $conv->getAllParticipants());
                $conv->participant = User::getParticipants($participants);
                $conv->title = $convTmp->title;
                $conv->satisfied = $convTmp->satisfied;
                $conv->further = $convTmp->further;
            } else {
                unset($convs[$index]);
            }
        }
        return view('Centaur::users.profile', ['user' => $user, 'isFind' => $isFind, 'isNoted' => $isNoted, 'note' => $note, 'convs' =>$convs]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Decode the user id
        // $id = $this->decode($hash);

        // Validate the form data
        $result = $this->validate($request, [
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'password' => 'confirmed|min:6',
        ]);

        // Assemble the updated attributes
        $attributes = [
            'email' => trim($request->get('email')),
            'first_name' => $request->get('first_name', null),
            'last_name' => $request->get('last_name', null)
        ];

        // Do we need to update the password as well?
        if ($request->has('password')) {
            $attributes['password'] = $request->get('password');
        }

        // Fetch the user object
        $user = $this->userRepository->findById($id);
        if (!$user) {
            if ($request->ajax()) {
                return response()->json("Invalid user.", 422);
            }
            session()->flash('error', 'Invalid user.');
            return redirect()->back()->withInput();
        }

        // Update the user
        $user = $this->userRepository->update($user, $attributes);

        // Update role assignments
        $roleIds = array_values($request->get('roles', []));
        $user->roles()->sync($roleIds);

        // All done
        if ($request->ajax()) {
            return response()->json(['user' => $user], 200);
        }

        session()->flash('success', "{$user->email} has been updated.");
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Fetch the user object
        //$id = $this->decode($hash);
        $user = $this->userRepository->findById($id);

        // Check to be sure user cannot delete himself
        if (Sentinel::getUser()->id == $user->id) {
            $message = "You cannot remove yourself!";

            if ($request->ajax()) {
                return response()->json($message, 422);
            }
            session()->flash('error', $message);
            return redirect()->route('users.index');
        }
        

        // Remove the user
        $user->delete();

        // All done
        $message = "{$user->email} has been removed.";
        if ($request->ajax()) {
            return response()->json([$message], 200);
        }

        session()->flash('success', $message);
        return redirect()->route('users.index');
    }

   /**
     * Get active experts (at least logged in 1 week ago)
     *
     * @param  none
     * @return \App\Model\User
     */
    public function doctors()
    {
        $doctors = User::listDoctors();

        return view('Centaur::doctors.index')
                ->with('doctors', $doctors);
    }

    public function experts()
    {
        $experts = User::listExperts();

        return view('Centaur::experts.index')
                ->with('experts', $experts);
    }

    public function patients()
    {
        $patients = User::listPatients();

        return view('patients.index')
            ->with(['patients' => $patients, 'toto' => Sentinel::getUser()->id]);
    }

    protected  function getUniqueParticipants($aUniqueParticipant, $aPartcipant)
    {
        $aUniqueParticipant = array_merge($aUniqueParticipant, $aPartcipant);
        //making sure each user appears only once
        $aUniqueParticipant = array_unique($aUniqueParticipant);

        return $aUniqueParticipant;
    }
}
