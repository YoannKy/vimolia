@extends('Centaur::layout')
@section('title', 'liste des praticiens')

@section('content')

@foreach($doctors as $index => $doctor)
	{{$doctor->first_name}}
	@if(Sentinel::inRole('expert'))
		{!! link_to(route('convs.create',$doctor->id),'contacter') !!}
	@endif
	<br>
@endforeach

@stop