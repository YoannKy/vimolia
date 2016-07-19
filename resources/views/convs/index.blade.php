@extends('Centaur::layout')
@section('title', 'Liste des conversations')

@section('content')
<h2>Liste de vos conversations</h2>
<div class="list-group">
@foreach($convs as $index => $conv)
   <div class="conversation list-group-item @if($conv->satisfied) list-group-item-success @elseif($conv->further) list-group-item-danger  @endif">
    Sujet : {{ $conv->title }}
    <br>
    @if($conv->messagesCount == 1)
    personne n'a encore répondu
    @endif
    <br>
    @if (Sentinel::inRole('user') || 
        Sentinel::inRole('expert') && 
        Sentinel::findById($conv->participant->id)->inRole('user'))
        @if($conv->satisfied)
        Statut : Répondu
        @elseif ($conv->further)
        Statut: Répondu mais non satisfait
        @else
        Statut : En attente
        @endif
    @endif
    <br><br>
    <a class="lien" href="{{route('convs.show',$conv->getId())}}">
        @if(Sentinel::inRole('expert') && $conv->messagesCount ==1)
            <button type="button" class="bouton">Répondre à la question du patient</button>
        @elseif(Sentinel::inRole('expert') && $conv->messagesCount ==2)
            <button type="button" class="bouton">Voir la question</button>
        @elseif(Sentinel::inRole('user'))
            <button type="button" class="bouton">Voir la question que j'ai posé</button>
        @elseif(Sentinel::inRole('praticien') || Sentinel::inRole('expert'))
                <button type="button" class="bouton">Voir la conversattion</button>
        
        @endif
    </a>
    </div>
    <br>
@endforeach
</div>
@stop
