@extends('Centaur::layout')

@section('title', 'Edit User')

@section('content')
{{$user->last_name}}
{{$user->first_name}}
Note :{{$note}}
<h2>Liste de ses conversations</h2>
<div class="list-group">
@foreach($convs as $index => $conv)
   <div class="conversation list-group-item @if($conv->satisfied) list-group-item-success @elseif($conv->further) list-group-item-danger  @endif">
    Sujet : {{ $conv->title }}
    <br>
    Dernier message de : {{$conv->participant->first_name}} {{$conv->participant->last_name}}
    <br>
    Statut : Répondu
    <br><br>
    <a class="lien" href="{{route('convs.show',$conv->getId())}}">
        <button type="button" class="bouton">
        Voir la question posée
        </button>
    </a>
    </div>
    <br>
@endforeach
</div>
@if ($isFind && !$isNoted))
<p>Notez le practicien :</p>
{{ Form::open(array('route' => ['forms.doctors.note',$user->id])) }}
{{Form::number('note', '')}}
<input type="submit" name="validation" value="valider">
{{ Form::close()}}
@endif
@stop