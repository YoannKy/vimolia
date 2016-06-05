@extends('Centaur::layout')
@section('title', 'Liste des médecins')

@section('content')
@if(Sentinel::inRole('experts','administrateur'))
	<h2>liste des médecins</h2>
	{{ Form::open(array('route' => ['forms.doctors.add',$formId])) }}
	@foreach($doctors as $index => $doctor)
		{{$doctor->first_name}}
		{{$doctor->last_name}}
		{{ Form::label('doc_'.$doctor->id, 'Proposer ce médecin')}}
	    {{Form::checkbox('doctors[]',$doctor->id,false,array('id'=>'doc_'.$doctor->id))}}
	    <br>
	@endforeach
	{{ Form::submit('valider')}}
	{{ Form::close()}}
@else
	<h2>Liste des médecins proposés par l'expert</h2>
	@foreach($doctors as $index => $doctor)	
		{{$doctor->first_name}}
		{{$doctor->last_name}}
		<br>
	@endforeach	
@endif
@stop