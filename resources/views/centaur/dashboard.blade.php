@extends('Centaur::layout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    @if (Sentinel::check())
    <div class="jumbotron">
        <h1>Bonjour, {{ Sentinel::getUser()->email }}!</h1>
        <p>Vous êtes connectés.</p>
    </div>
    @else
        <div class="jumbotron">
            <h1>Bienvenue</h1>
            <p>Vous devez vous inscrire pour continuer.</p>
            <p><a class="btn btn-primary btn-lg" href="{{ route('auth.login.form') }}" role="button">Connexion</a></p>
        </div>
    @endif

</div>
@stop