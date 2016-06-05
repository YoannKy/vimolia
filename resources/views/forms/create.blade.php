@extends('Centaur::layout')
@section('title', 'Demande de prise de contact')

@section('content')
{{ Form::open(array('route' => ['forms.store'])) }}
    {{ Form::label('fist_name', 'prénom')}}
    {{ Form::text('first_name',null,array('required'=>'required'))}}
    {{ Form::label('last_name', 'Nom')}}
    {{ Form::text('last_name',null,array('required'=>'required'))}}
    {{ Form::label('age', 'age')}}
    {{ Form::number('age',null,array('required'=>'required'))}}
    {{ Form::label('town', 'Ville')}}
    {{ Form::text('town',null,array('required'=>'required'))}}
    {{ Form::label('symptom', 'Symptomes')}}
    {{ Form::text('symptom',null,array('required'=>'required'))}}
    {{ Form::label('info', 'Informations complémentaires')}}
    {{ Form::text('info',null,array('required'=>'required'))}}
    {{ Form::submit('Envoyer le formulaire')}}
{{ Form::close() }}
@stop