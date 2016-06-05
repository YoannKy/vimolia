@extends('Centaur::layout')
@section('title', 'Mes formulaires de prises de contact')

@section('content')
@foreach($forms as $index => $form)
{!! link_to(route('forms.show',$form->id),'voir ce formulaire') !!}
{!! link_to(route('forms.doctors.list',$form->id),'voir les médecins proposés') !!}
@endforeach 
@stop