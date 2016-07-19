@extends('Centaur::layout')
@section('title', 'Liste des médecins')

@section('content')
@if(Sentinel::inRole('expert','administrateur'))
	<h2>Liste des médecins</h2>
	<div class="listeMedecin">
	{{ Form::open(array('route' => ['forms.doctors.add',$formId])) }}
	@foreach($doctors as $index => $doctor)
		<p>
			{{$doctor->first_name}}
			{{$doctor->last_name}}
		</p>
		<p>
			{{ Form::label('doc_'.$doctor->id, 'Proposer ce médecin')}}
		    {{Form::checkbox('doctors[]',$doctor->id,false,array('id'=>'doc_'.$doctor->id))}}
		</p>
	    <br>
	@endforeach
	{{ Form::submit('valider')}}
	{{ Form::close()}}
	</div>
@else
	<h2>Liste des médecins proposés par l'expert</h2>
	<p class="sous-titre">
		Vous pouvez prendre contact avec un des médecins proposés puis sélectionner celui avec lequel vous avez pris le rendez-vous.
	</p>

	<div class="listeMedecin">
	{{ Form::open(array('route' => ['forms.doctors.choose',$formId])) }}
	@foreach($doctors as $index => $doctor)
		<p>
			{{$doctor->first_name}}
			{{$doctor->last_name}}
			{{ Form::radio('doctor', $doctor->id )}}
		</p>
	@endforeach
		{{ Form::submit('valider')}}
	{{ Form::close()}}
	</div>
@endif
@stop