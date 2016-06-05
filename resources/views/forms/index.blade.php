@extends('Centaur::layout')
@section('title', 'liste des demandes')

@section('content')
<h2>Liste de demande de prises de contact avec un pracitcien</h2>
@foreach($forms as $index => $form)
    <a class="lien" href="{{route('forms.show',$form->id)}}">
        Voir le formulaire
    </a>
@endforeach
@stop
