<?php

namespace App\Http\Controllers\Auth;

use App\Models\Skill;
use Mail;
use Session;
use Sentinel;
use Activation;
use App\Http\Requests;
use Centaur\AuthManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class RegistrationController extends Controller
{
    /** @var Centaur\AuthManager */
    protected $authManager;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(AuthManager $authManager)
    {
        $this->middleware('sentinel.guest');
        $this->authManager = $authManager;
    }

    /**
     * Show the registration form
     * @return View
     */
    public function getRegister()
    {
        return view('Centaur::auth.register');
    }

    public function getRegisterChoice()
    {
        return view('Centaur::auth.registerChoice');
    }
    /**
     * Show the registration of doctor form
     * @return View
     */
    public function getDoctorRegister
    ()
    {
        $skills = Skill::all();
        return view('Centaur::auth.doctorRegister', ['skills' => $skills]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Response|Redirect
     */
    protected function postRegister(Request $request)
    {
        $result = $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|regex:/[0-9]{10}/',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'avatar' => 'mimes:jpeg,bmp,png,jpg',
        ]);


        $imageName = uniqid(). '.' .$request->file('avatar_user')->getClientOriginalExtension();

        $request->file('avatar_user')->move(
            base_path() . '/public/images/avatar/', $imageName
        );

        // Assemble registration credentials

        $credentials = [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'address' => $request->get('address'),
            'date_of_birth' => $request->get('date_of_birth'),
            'phone_number' => $request->get('phone_number'),
            'email' => trim($request->get('email')),
            'password' => $request->get('password'),
            'avatar' => $imageName
        ];

        // Attempt the registration
        $result = $this->authManager->register($credentials);

        if ($result->isFailure()) {
            return $result->dispatch();
        }

        // Send the activation email
        $code = $result->activation->getCode();
        $email = $result->user->email;

        $user = Sentinel::findById($result->user->id);
        $role = Sentinel::findRoleByName('User');
        $role->users()->attach($user);

        Mail::queue(
            'centaur.email.welcome',
            ['code' => $code, 'email' => $email],
            function ($message) use ($email) {
                $message->to($email)
                    ->subject('Your account has been created');
            }
        );

        // Ask the user to check their email for the activation link
        $result->setMessage('Registration complete.  Please check your email for activation instructions.');

        // There is no need to send the payload data to the end user
        $result->clearPayload();

        // Return the appropriate response
        return $result->dispatch(route('home'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Response|Redirect
     */
    protected function postDoctorRegister(Request $request)
    {
        $result = $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|regex:/[0-9]{10}/',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'avatar' => 'mimes:jpeg,bmp,png,jpg',
            'profession' => 'required',
            'siret' => 'required',
            'degree' => 'required',
            'how_did_you_know' => 'max:255'
        ]);

        $imageName = uniqid(). '.' .$request->file('avatar')->getClientOriginalExtension();

        $request->file('avatar')->move(
            base_path() . '/public/images/avatar/', $imageName
        );

        $degree = uniqid(). '.' .$request->file('degree')->getClientOriginalExtension();

        $request->file('degree')->move(
            base_path() . '/public/degree/', $degree
        );
        // Assemble registration credentials

        $credentials = [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'address' => $request->get('address'),
            'date_of_birth' => $request->get('date_of_birth'),
            'phone_number' => $request->get('phone_number'),
            'email' => trim($request->get('email')),
            'password' => $request->get('password'),
            'avatar' =>  $imageName,
            'profession' => $request->get('profession'),
            'siret' => $request->get('siret'),
            'degree' => $degree,
            'how_did_you_know' => $request->get('how_did_you_know'),
        ];

        // Attempt the registration
        $result = $this->authManager->register($credentials);

        if ($result->isFailure()) {
            Storage::Delete(base_path() . '/public/images/catalog/', $imageName);
            return $result->dispatch();
        }

        // Send the activation email
        $code = $result->activation->getCode();
        $email = $result->user->email;

        $user = Sentinel::findById($result->user->id);
        $role = Sentinel::findRoleByName('Praticien');
        $role->users()->attach($user);

        Mail::queue(
            'centaur.email.welcome',
            ['code' => $code, 'email' => $email],
            function ($message) use ($email) {
                $message->to($email)
                    ->subject('Your account has been created');
            }
        );

        // Ask the user to check their email for the activation link
        $result->setMessage('Registration complete.  Please check your email for activation instructions.');

        // There is no need to send the payload data to the end user
        $result->clearPayload();

        // Return the appropriate response
        return $result->dispatch(route('home'));
    }
    /**
     * Activate a user if they have provided the correct code
     * @param  string $code
     * @return Response|Redirect
     */
    public function getActivate(Request $request, $code)
    {
        // Attempt the registration
        $result = $this->authManager->activate($code);

        if ($result->isFailure()) {
            // Normally an exception would trigger a redirect()->back() However,
            // because they get here via direct link, back() will take them
            // to "/";  I would prefer they be sent to the login page.
            $result->setRedirectUrl(route('auth.login.form'));
            return $result->dispatch();
        }

        // Ask the user to check their email for the activation link
        $result->setMessage('Registration complete.  You may now log in.');

        // There is no need to send the payload data to the end user
        $result->clearPayload();

        // Return the appropriate response
        return $result->dispatch(route('home'));
    }

    /**
     * Show the Resend Activation form
     * @return View
     */
    public function getResend()
    {
        return view('Centaur::auth.resend');
    }

    /**
     * Handle a resend activation request
     * @return Response|Redirect
     */
    public function postResend(Request $request)
    {
        // Validate the form data
        $result = $this->validate($request, [
            'email' => 'required|email|max:255'
        ]);

        // Fetch the user in question
        $user = Sentinel::findUserByCredentials(['email' => $request->get('email')]);

        // Only send them an email if they have a valid, inactive account
        if (!Activation::completed($user)) {
            // Generate a new code
            $activation = Activation::create($user);

            // Send the email
            $code = $activation->getCode();
            $email = $user->email;
            Mail::queue(
                'auth.email.welcome',
                ['code' => $code, 'email' => $email],
                function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Account Activation Instructions');
                }
            );
        }

        $message = 'New instructions will be sent to that email address if it is associated with a inactive account.';

        if ($request->ajax()) {
            return response()->json(['message' => $message], 200);
        }

        Session::flash('success', $message);
        return redirect('/home');
    }
}
