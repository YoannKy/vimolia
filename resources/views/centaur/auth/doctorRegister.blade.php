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
                    {{ Form::open(array('route' => ['auth.doctor.register.attempt'],'files' => true)) }}
                        <fieldset>
                            <div class="form-group {{ ($errors->has('avatar')) ? 'has-error' : '' }}">
                                <label for="avatar">Avatar :</label>
                                {!! Form::file('avatar_user', ['id'=>'avatar']) !!}
                                {!! ($errors->has('avatar_user') ? $errors->first('avatar_user', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                                {{ Form::text('email',old('email'),['placeholder'=>'E-mail','class'=>'form-control'])}}
                                {!! ($errors->has('email') ? $errors->first('email', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group  {{ ($errors->has('password')) ? 'has-error' : '' }}">
                                {{ Form::password('password', ['placeholder'=>'Mot de passe','class'=>'form-control'])}}
                                {!! ($errors->has('password') ? $errors->first('password', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group  {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                                {{ Form::password('password_confirmation', ['placeholder'=>'Confirmation du mot de passe','class'=>'form-control'])}}
                                {!! ($errors->has('password_confirmation') ? $errors->first('password_confirmation', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group {{ ($errors->has('first_name')) ? 'has-error' : '' }}">
                                {{ Form::text('first_name',old('first_name'),['placeholder'=>'Prénom','class'=>'form-control'])}}
                                {!! ($errors->has('first_name') ? $errors->first('first_name', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                                {{ Form::text('last_name',old('last_name'),['placeholder'=>'Nom','class'=>'form-control'])}}
                                {!! ($errors->has('last_name') ? $errors->first('last_name', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group {{ ($errors->has('address')) ? 'has-error' : '' }}">
                                {{ Form::text('address',old('address'),['placeholder'=>'Adresse','class'=>'form-control'])}}
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
                                {{ Form::date('date_of_birth',old('date_of_birth'),['placeholder'=>'Date de naissance','class'=>'form-control'])}}
                                {!! ($errors->has('date_of_birth') ? $errors->first('date_of_birth', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group {{ ($errors->has('phone_number')) ? 'has-error' : '' }}">
                                {{ Form::text('phone_number',old('phone_number'),['placeholder'=>'Numéro de téléphone','class'=>'form-control'])}}
                                {!! ($errors->has('phone_number') ? $errors->first('phone_number', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group {{ ($errors->has('degree')) ? 'has-error' : '' }}">
                                <label for="degree">Diplôme :</label>
                                {!! Form::file('degree', ['id'=>'degree']) !!}
                                {!! ($errors->has('degree') ? $errors->first('degree', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group {{ ($errors->has('profession')) ? 'has-error' : '' }}">
                                {{ Form::text('profession',old('profession'),['placeholder'=>'Profession','class'=>'form-control'])}}
                                {!! ($errors->has('profession') ? $errors->first('profession', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group {{ ($errors->has('siret')) ? 'has-error' : '' }}">
                                {{ Form::text('siret',old('siret'),['placeholder'=>'Siret','class'=>'form-control'])}}
                                {!! ($errors->has('siret') ? $errors->first('siret', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            <div class="form-group {{ ($errors->has('how_did_you_know')) ? 'has-error' : '' }}">
                                {{ Form::textarea('how_did_you_know', old('how_did_you_know'), ['placeholder'=>'Comment avez-vous connu le site ?', 'class' => 'form-control']) }}
                                {!! ($errors->has('how_did_you_know') ? $errors->first('how_did_you_know', '<p class="text-danger">:message</p>') : '') !!}
                            </div>
                            {{Form::label('disciplines', 'Disciplines :')}}
                            <div class="form-group">
                                <select multiple="multiple" class="selectpicker" name="skills[]" id="disciplines">
                                    @foreach($skills as $skill)
                                            <option value="{{$skill['id']}}">{{$skill['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input name="_token" value="{{ csrf_token() }}" type="hidden">
                            <input class="btn btn-lg btn-primary btn-block" type="submit" value="S'inscrire">
                        </fieldset>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop