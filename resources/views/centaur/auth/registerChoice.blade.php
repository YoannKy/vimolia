@extends('Centaur::layout')

@section('title', 'Register')

@section('content')

<div class="row" style="text-align: center;">
    <div class="col-sm-6 col-md-6">
    <div class="thumbnail">
        <h3>Inscription en tant qu'utilisateur</h3>
        <img src="/images/photo.png" alt="image inscription utilisateur"><br>
        <button class="bouton"><a href="{{ route('auth.register.form') }}" role="button">Accéder</a></button>
        <br><br>
    </div>
  </div>

  <div class="col-sm-6 col-md-6">
    <div class="thumbnail">
        <h3>Inscription en tant que médecin</h3>
        <img src="/images/photo.png" alt="image inscription medecin"><br>
        <button class="bouton"><a href="#" role="button">Accéder</a></button>
        <br><br>
    </div>
  </div>
</div>
@stop