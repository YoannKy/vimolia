@extends('Centaur::layout')
@section('title', 'Mes formulaires de prises de contact')

@section('content')
@foreach($forms as $index => $form)
<h2>Formulaire</h2>
<button type="button" class="bouton">{!! link_to(route('forms.show',$form->id),'Voir ce formulaire') !!}</button>
<br><br><br>

<h2>Listes des médecins proposés</h2>
<button type="button" class="bouton">{!! link_to(route('forms.doctors.list',$form->id),'Voir les médecins proposés') !!}</button>
@endforeach 
@stop