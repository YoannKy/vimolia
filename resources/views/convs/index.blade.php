@extends('Centaur::layout')
@section('title', 'Liste des conversations')

@section('content')
<h2>Liste de vos conversations</h2>
@foreach($convs as $index => $conv)
    Sujet : {{ $conv->title }}
    {{$conv->participant->first_name}}
    <br>
    {{$conv->participant->last_name}}
    <a class="lien" href="{{route('convs.show',$conv->getId())}}">
        @if(Sentinel::inRole('expert'))
            Répondre à la question du patient
        @else      
           Voir la question que j'ai posé
        @endif
    </a>
@endforeach
@stop
