@extends('Centaur::layout')
@section('title', 'Liste des conversations')

@section('content')
<h2>Liste de vos conversations</h2>

<div class="panel panel-default">
  <table class="table">
  <thead>
      <tr>
        <th>Sujet</th>
        <th>Dernier message de :</th>
        <th>Statut</th>
        <th>Voir à la question / Répondre à la question</th>
      </tr>
    </thead>
    <tbody>
    @foreach($convs as $index => $conv)
      @if($conv->satisfied)
      <tr class="success">
        <td>{{ $conv->title }}</td>
        <td>{{$conv->participant->first_name}} {{$conv->participant->last_name}}</td>
        @if($conv->satisfied)
        <td>Répondu</td>
        @elseif ($conv->further)
        <td>Répondu mais non satisfait</td>
        @else
        <td>En attente</td>
        @endif
        @if(Sentinel::inRole('expert'))
        <td><a class="lien" href="{{route('convs.show',$conv->getId())}}"><button type="button" class="bouton">Répondre à la question du patient</button></a></td>
        @else
        <td><a class="lien" href="{{route('convs.show',$conv->getId())}}"><button type="button" class="bouton">Voir la question que j'ai posé</button></a></td>
        @endif
      </tr>
      @elseif($conv->further)
      <tr class="danger">
        <td>{{ $conv->title }}</td>
        <td>{{$conv->participant->first_name}} {{$conv->participant->last_name}}</td>
        @if($conv->satisfied)
        <td>Répondu</td>
        @elseif ($conv->further)
        <td>Répondu mais non satisfait</td>
        @else
        <td>En attente</td>
        @endif
        @if(Sentinel::inRole('expert'))
        <td><a class="lien" href="{{route('convs.show',$conv->getId())}}"><button type="button" class="bouton">Répondre à la question du patient</button></a></td>
        @else
        <td><a class="lien" href="{{route('convs.show',$conv->getId())}}"><button type="button" class="bouton">Voir la question que j'ai posé</button></a></td>
        @endif
      </tr>
      @endif
@endforeach
    </tbody>
  </table>
</div>
@stop
