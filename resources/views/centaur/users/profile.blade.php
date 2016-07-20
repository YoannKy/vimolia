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
<div class="row">
        <div class="starter-template">
            <h1>Mon profil</h1>
            <p class="lead">Consulter vos informations</p>
        </div>
        <div id="patricien">
            <ul class="nav nav-tabs">
                <li role="presentation"><a href="#">Mes conversations <span class="badge">3</span></a></li>
                <li role="presentation"><a href="#">Historique <span class="badge">4</span></a></li>
            </ul>
            <br>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <center>
                            <h3>{{$user->first_name}} {{$user->last_name}}</h3>
                            <img src="/images/photo.png" alt="photo praticien">
                            <div class="caption">
                                <p>Spécialité</p>
                                <p>
                                    <!--<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                                    <span>(50)</span>-->
                                    Note :{{$note}}
                                </p>
                            </div>
                        </center>
                    </div>
                </div>
                <div class="col-sm-6 col-md-8">
                    <div class="jumbotron thumbnail">
                        <h2>Mes informations personnelles</h2>
                        <p><i>Je me situe au : 5 rue du Cabinet</i></p>
                        <p>Compétence 1 : </p>
                        <p>Compétence 2 : </p>
                    </div>
                </div>
            </div>

        </div>
@if ($isFind && !$isNoted))
<p>Notez le praticien :</p>
{{ Form::open(array('route' => ['forms.doctors.note',$user->id])) }}
{{Form::number('note', '')}}
<input type="submit" name="validation" value="valider">
{{ Form::close()}}
@endif
@stop