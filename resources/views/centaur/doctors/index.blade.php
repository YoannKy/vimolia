@extends('Centaur::layout')
@section('title', 'liste des praticiens')

@section('content')

<h2>Liste des praticiens</h2>
<div class="panel panel-default">
  <table class="table">
  <thead>
      <tr>
        <th>#</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Métier</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
    @foreach($doctors as $index => $doctor)
      @if($conv->satisfied)
      <tr>
        <td>{{$index}}</td>
        <td>{{$doctor->first_name}}</td>
        <td>{{$doctor->last_name}}</td>
        <td>{{$doctor->address}}</td>
        <td>{{$doctor->profession}}</td>
        <td>note</td>
      </tr>
      @if(Sentinel::inRole('expert'))
			{!! link_to(route('convs.create',$doctor->id),'Contacter') !!}
		@endif
@endforeach
    </tbody>
  </table>
</div>
@stop