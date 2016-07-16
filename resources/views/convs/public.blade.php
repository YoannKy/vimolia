@extends('Centaur::layout')
@section('title', 'Liste des questions publiques')

@section('content')
<h2>Liste des questions publiques</h2>
<div class="list-group">
@foreach($convs as $index => $conv)
   <div class=" list-group-item">
    Sujet: {{ $conv->title }}
  	<br>
    <a class="lien" href="{{route('convs.show',$conv->id)}}">Voir la question</a>
    </div>
@endforeach
</div>
@stop
