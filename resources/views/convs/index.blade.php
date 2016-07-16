@extends('Centaur::layout')
@section('title', 'Liste des conversations')

@section('content')
<h2>Liste de vos conversations</h2>
<div class="list-group">
@foreach($convs as $index => $conv)
   <div class="conversation list-group-item @if($conv->satisfied) list-group-item-success @endif">
    Sujet : {{ $conv->title }}
    <br>
    De : {{$conv->participant->first_name}} {{$conv->participant->last_name}}
    <br>
    @if($conv->satisfied)
    Statut : Répondu
    @else 
    Statut : En attente
    @endif
    <br><br>
    <a class="lien" href="{{route('convs.show',$conv->getId())}}">
        @if(Sentinel::inRole('expert'))
            <button type="button" class="bouton">Répondre à la question du patient</button>
        @else      
            <button type="button" class="bouton">Voir la question que j'ai posé</button>
        @endif
    </a>
    </div>
    <br>
@endforeach
</div>
@stop
