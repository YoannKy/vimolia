@extends('Centaur::layout')
@section('title', 'liste des demandes')

@section('content')
{{$form->first_name}}
{{$form->last_name}}
{{$form->age}}
{{$form->town}}
{{$form->symptom}}
{{$form->info}}
@if(Sentinel::inRole('experts'))
	{!! link_to(route('forms.doctors.list',$form->id), 'mettre en relation') !!}
@endif
@stop