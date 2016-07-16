@extends('Centaur::layout')
@section('title', 'Demande de prise de contact')

@section('content')
{{ Form::open(array('route' => ['forms.store'])) }}
    <div class="form-group">
    {{ Form::label('fist_name', 'prénom')}}
    {{ Form::text('first_name',null,array('required'=>'required', 'class'=>'form-control'))}}
    </div>
    <div class="form-group">
    {{ Form::label('last_name', 'Nom')}}
    {{ Form::text('last_name',null,array('required'=>'required','class'=>'form-control'))}}
    </div>
    <div class="form-group">
    {{ Form::label('age', 'age')}}
    {{ Form::number('age',null,array('required'=>'required','class'=>'form-control'))}}
    </div>
    <div class="form-group">
    {{ Form::label('town', 'Ville')}}
    {{ Form::text('town',null,array('required'=>'required','class'=>'form-control'))}}
    </div>
    <div class="form-group">
    {{ Form::label('symptom', 'Symptomes')}}
    {{ Form::text('symptom',null,array('required'=>'required','class'=>'form-control'))}}
    </div>
    <div class="form-group">
    {{ Form::label('info', 'Informations complémentaires')}}
    {{ Form::text('info',null,array('required'=>'required','class'=>'form-control'))}}
    </div>
    {{ Form::submit('Envoyer le formulaire')}}
{{ Form::close() }}
@stop