@extends('Centaur::layout')
@section('title', 'liste des demandes')

@section('content')

<h2>Formulaire avec le détail</h2>
<div class="formulaireDetails">
	<p><span>Prénom :</span> {{$form->first_name}}</p>
	<p><span>Nom :</span> {{$form->last_name}}</p>
	<p><span>Age :</span> {{$form->age}}</p>
	<p><span>Ville :</span> {{$form->town}}</p>
	<p><span>Symptôme :</span> {{$form->symptom}}</p>
	<p><span>Information :</span> {{$form->info}}</p>
</div>
<br><br>
<h2>Mise en relation</h2>
@if(Sentinel::inRole('expert'))
	<button type="button" class="bouton">{!! link_to(route('forms.doctors.list',$form->id), 'Mettre en relation') !!}</button>
@endif
@stop