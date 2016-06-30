@extends('Centaur::layout')
@section('title', 'Liste des conversations')

@section('content')
<h2>Liste de vos conversations</h2>
<div class="list-group">
@foreach($convs as $index => $conv)
   <div class=" list-group-item @if($conv->satisfied) list-group-item-success @endif">
    Sujet: {{ $conv->title }}
    <br>
    De: {{$conv->participant->first_name}} {{$conv->participant->last_name}}
    <br>
    @if($conv->satisfied)
    Statut: Répondu
    @else 
    Statut: En attente
    @endif
    <br>
    <a class="lien" href="{{route('convs.show',$conv->getId())}}">
        @if(Sentinel::inRole('expert'))
            Répondre à la question du patient
        @else      
           Voir la question que j'ai posé
        @endif
    </a>
    </div>
@endforeach
</div>
@stop
