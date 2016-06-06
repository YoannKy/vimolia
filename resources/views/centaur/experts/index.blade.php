@extends('Centaur::layout')
@section('title', 'liste des experts')

@section('content')

@foreach($experts as $index => $expert)
	{{$expert->first_name}}
	{!! link_to(route('convs.create',$expert->id),'contacter') !!}
	<br>
@endforeach

@stop