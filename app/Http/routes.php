<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


    // Home
    Route::get('/', ['as' => 'home', 'uses' => function () {
        return view('centaur.dashboard');
    }]);

   // Authorization
    Route::get('/login', ['as' => 'auth.login.form', 'uses' => 'Auth\SessionController@getLogin']);
    Route::post('/login', ['as' => 'auth.login.attempt', 'uses' => 'Auth\SessionController@postLogin']);
     
     // Registration
    Route::get('register', ['as' => 'auth.register.form', 'uses' => 'Auth\RegistrationController@getRegister']);
    Route::post('register', ['as' => 'auth.register.attempt', 'uses' => 'Auth\RegistrationController@postRegister']);
    Route::get('registerchoice', ['as' => 'auth.register.choose', 'uses' => 'Auth\RegistrationController@getRegisterChoice']); 

    // Doctor's registration
    Route::get('register/doctor', ['as' => 'auth.doctor.register.form', 'uses' => 'Auth\RegistrationController@getDoctorRegister']);
    Route::post('register/doctor', ['as' => 'auth.doctor.register.attempt', 'uses' => 'Auth\RegistrationController@postDoctorRegister']);

     // Activation
    Route::get('activate/{code}', ['as' => 'auth.activation.attempt', 'uses' => 'Auth\RegistrationController@getActivate']);
    Route::get('resend', ['as' => 'auth.activation.request', 'uses' => 'Auth\RegistrationController@getResend']);
    Route::post('resend', ['as' => 'auth.activation.resend', 'uses' => 'Auth\RegistrationController@postResend']);


    Route::group(['middleware' => ['web']], function () {

        // Authorization
        Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'Auth\SessionController@getLogout']);
       
        // Password Reset
        Route::get('password/reset/{code}', ['as' => 'auth.password.reset.form', 'uses' => 'Auth\PasswordController@getReset']);
        Route::post('password/reset/{code}', ['as' => 'auth.password.reset.attempt', 'uses' => 'Auth\PasswordController@postReset']);
        Route::get('password/reset', ['as' => 'auth.password.request.form', 'uses' => 'Auth\PasswordController@getRequest']);
        Route::post('password/reset', ['as' => 'auth.password.request.attempt', 'uses' => 'Auth\PasswordController@postRequest']);

        // Users
        Route::resource('users', 'UserController');
        Route::get('profile/{id}', ['as' => 'users.profile', 'uses' => 'UserController@profile']);
        // Roles
        Route::resource('roles', 'RoleController');

        // Convs
        Route::get('convs', ['as' => 'convs.index', 'uses' => 'ConvController@index']);
       
        Route::get('convs/public', ['as' => 'convs.public', 'uses' => 'ConvController@getPublicConvs']);

        Route::get('convs/{id}', ['as' => 'convs.show', 'uses' => 'ConvController@show'])->where('id', '[0-9]+');

        Route::post('convs/{id}/add', ['as' => 'convs.addMessage', 'uses' => 'ConvController@addMessage']);

        Route::get('experts', ['as' => 'experts.index', 'uses' => 'UserController@experts']);

        Route::get('convs/create/{id_user?}', ['as' => 'convs.create', 'uses' => 'ConvController@create']);
        
        Route::post('convs/{id}/close', ['as' => 'convs.close', 'uses' => 'ConvController@close']);

        Route::get('forms/list', ['as' => 'forms.list', 'uses' => 'FormController@listForms']);
        
        Route::resource('forms', 'FormController');

        Route::get('forms{id}/doctors', ['as' => 'forms.doctors.list', 'uses' => 'FormController@doctors']);
        
        Route::post('forms/{id}/addDoctors', ['as' => 'forms.doctors.add', 'uses' => 'FormController@addDoctors']);

        Route::post('forms/{id}/chooseDoctor', ['as' => 'forms.doctors.choose', 'uses' => 'FormController@chooseDoctor']);

        Route::post('forms/{id}/note', ['as' => 'forms.doctors.note', 'uses' => 'FormController@noteDoctor']);

        Route::post('patients/{id}/addPatient', ['as' => 'forms.patients.add', 'uses' => 'FormController@addPatient']);

        Route::get('patients', ['as' => 'users.patients', 'uses' => 'UserController@patients']);

        Route::get('doctors/list', ['as' => 'users.doctor.list', 'uses' => 'UserController@doctors']);

        Route::get('experts/list', ['as' => 'users.expert.list', 'uses' => 'UserController@experts']);

    });
