@extends('Centaur::layout')

@section('title', 'Edit User')

@section('content')

<div class="row">
        <div class="starter-template">
            <h1>Mon profil</h1>
            <p class="lead">Consulter vos informations</p>
        </div>
        <div id="praticien">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <center>
                            <h3>{{$user->first_name}} {{$user->last_name}}</h3>
                            <img src="/images/photo.png" alt="photo praticien">
                            <div class="caption">
                                <p>Métier : {{$user->profession}}</p>
                                <p>
                                    Note :{{$note}}
                                </p>
                            </div>
                        </center>
                    </div>
                </div>  
                <div class="col-sm-6 col-md-8">
                    <div class="jumbotron thumbnail">
                        <h2>Mes informations personnelles</h2>
                        <p><i>Je me situe au : {{$user->address}} {{$user->zip_code}} {{$user->city}}</i></p>
                        @foreach($user->getSkills($user->id) as $index => $skill)
                            <?php $index++; ?>
                            <p>Compétence {{$index}} : {{$skill->name}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2>Liste de mes conversations</h2>
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
<p>Notez le praticien :</p>
{{ Form::open(array('route' => ['forms.doctors.note',$user->id])) }}
{{Form::number('note', '')}}
<input type="submit" name="validation" value="valider">
{{ Form::close()}}
@endif
@stop