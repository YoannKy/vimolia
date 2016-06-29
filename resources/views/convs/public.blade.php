@extends('Centaur::layout')
@section('title', 'Liste des questions publiques')

@section('content')
<h2>Liste des questions publiques</h2>
@foreach($convs as $index => $conv)
    <a class="lien" href="{{route('convs.show',$conv->id)}}">
    Sujet : {{ $conv->title }}
        Voir la question
    </a>
@endforeach
@stop
