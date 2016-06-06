@extends('Centaur::layout')
@section('title', 'liste des practiciens')

@section('content')

@foreach($doctors as $index => $doctor)
	{{$doctor->first_name}}
	{!! link_to(route('convs.create',$doctor->id),'contacter') !!}
	<br>
@endforeach

@stop