@extends('Centaur::layout')

@section('title', 'Register')

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Inscription</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('route' => ['auth.register.attempt'],'files' => true)) }}
                <fieldset>
                    <div class="form-group {{ ($errors->has('avatar_user')) ? 'has-error' : '' }}">
                        <label for="avatar_user">Avatar :</label>
                        {!! Form::file('avatar_user', ['id'=>'avatar_user']) !!}
                        {!! ($errors->has('avatar_user') ? $errors->first('avatar_user', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="E-mail" name="email" type="text" value="{{ old('email') }}">
                        {!! ($errors->has('email') ? $errors->first('email', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group  {{ ($errors->has('password')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="Mot de passe" name="password" type="password">
                        {!! ($errors->has('password') ? $errors->first('password', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group  {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="Confirmation du mot de passe" name="password_confirmation" type="password">
                        {!! ($errors->has('password_confirmation') ? $errors->first('password_confirmation', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('first_name')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="Prénom" name="first_name" type="text" value="{{ old('first_name')}}"/>
                        {!! ($errors->has('first_name') ? $errors->first('first_name', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="Nom" name="last_name" type="text" value="{{ old('last_name') }}"/>
                        {!! ($errors->has('last_name') ? $errors->first('last_name', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('address')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="Adresse" name="address" type="text" value="{{ old('address') }}"/>
                        {!! ($errors->has('address') ? $errors->first('address', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('zip_code')) ? 'has-error' : '' }}">
                        {{ Form::text('zip_code',old('zip_code'),['placeholder'=>'Code Postal','class'=>'form-control'])}}
                        {!! ($errors->has('zip_code') ? $errors->first('address', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('city')) ? 'has-error' : '' }}">
                        {{ Form::text('city',old('city'),['placeholder'=>'Ville','class'=>'form-control'])}}
                        {!! ($errors->has('city') ? $errors->first('city', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('date_of_birth')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="Date de naissance" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}"/>
                        {!! ($errors->has('date_of_birth') ? $errors->first('date_of_birth', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('phone_number')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="Numéro de téléphone" name="phone_number" type="text" value="{{ old('phone_number') }}"/>
                        {!! ($errors->has('phone_number') ? $errors->first('phone_number', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="S'inscrire">
                </fieldset>
                {{ Form::close() }}
            </div>
        </div>
        
    {!! link_to(route('auth.doctor.register.form'),'s\'inscrire en tant que médecin') !!}
    </div>
</div>
@stop