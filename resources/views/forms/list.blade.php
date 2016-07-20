@extends('Centaur::layout')
@section('title', 'Mes formulaires de prises de contact')

@section('content')

<h2>Liste de médecins proposés</h2>
<div class="panel panel-default">
  <table class="table">
  <thead>
      <tr>
        <th>Sujet</th>
        <th>Informations du formulaire</th>
        <th>Médecins proposés</th>
      </tr>
    </thead>
    <tbody>
    @foreach($forms as $index => $form)
      <tr>
        <td>{{$index+1}}</td>
        <td><button type="button" class="bouton">{!! link_to(route('forms.show',$form->id),'Voir le formulaire') !!}</button></td>
        <td><button type="button" class="bouton">{!! link_to(route('forms.doctors.list',$form->id),'Voir les médecins proposés') !!}</button></td>
      </tr>
	@endforeach 
	</tbody>
  </table>
</div>


@stop