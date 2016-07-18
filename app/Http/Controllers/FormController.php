<?php

namespace App\Http\Controllers;

use Sentinel;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Conv;
use App\Models\User;
use Session;

class FormController extends Controller
{
   
    public function __construct()
    {
        // Middleware
        $this->middleware('sentinel.auth');
    }

    /**
     * Display a listing of the forms.
     *
     * @return View
     */
    public function index()
    {
        if (Sentinel::inRole('expert')) {
            $forms = Form::where('expert_id', Sentinel::getUser()->id)->get();
        } else if (Sentinel::inRole('administrateur')) {
            $forms = Form::all();
        } else  if(Sentinel::inRole('user')){
            $forms = Form::where('user_id', Sentinel::getUser()->id)->get();
        }
        return view('forms.index')->with('forms', $forms);
    }

    /**
     * Show the form for creating a new form.
     *
     * @return View
     */
    public function create()
    {
        if (is_null(Session::get('expert'))) {
            return redirect()->route('convs.index');
        }
        $user = User::find(Sentinel::getUser()->id)->load(['convs'=>function ($query) {
            $query->where('satisfied', 0)->where('closed', 0)->where('further', 1);
        }]);
        if (count($user->convs) == 0) {
            return redirect()->route('convs.index');
        } 
        return view('forms.create');
    }

    /**
     * Store a newly created form in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return View
     */
    public function store(Request $request)
    {
        Form::store($request);
        return redirect()->route('home');
    }

    /**
     * Display the specified form.
     *
     * @param  integer $id
     * @return View
     */
    public function show($id)
    {
        $form = Form::find($id);

        return view('forms.show')->with('form', $form);
    }

    /**
     * Display a list of doctors
     *
     * @param  integer  $id
     * @return View
     */
    public function doctors($id)
    {
        $doctors = null;
        $form = Form::find($id);
        if (!$form) {
            return redirect()->route('home');
        }
        if (Sentinel::inRole('users')) {
            $doctors = User::listDoctors(unserialize($form->doctors));
        } else {
            $doctors =  User::listDoctors();
        }
        return view('forms.doctors', ['doctors'=> $doctors,'formId'=>$id]);
    }

    public function addDoctors(Request $request, $id)
    {
        dd($request->input('doctors'));
        Form::addDoctors(serialize($request->input('doctors')), $id);
        return redirect()->back();
    }

    public function chooseDoctor(Request $request, $id)
    {
        Form::chooseDoctors($request->input('doctor'), $id);
        return redirect()->back();
    }

    public function listForms()
    {
        $forms = Form::getUserForm();
        return view('forms.list')->with('forms', $forms);
    }

    public function addPatient(Request $request, $id)
    {
        Form::addPatient($request->input('validation'), $id);
        return redirect()->back();
    }

    public function noteDoctor(Request $request, $id)
    {
        Form::noteDoctor($request->input('note'), $id);
        return redirect()->back();
    }
}
