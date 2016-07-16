@extends('Centaur::layout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    @if (Sentinel::check())
    <div class="AccueilMsg">
        <p>Bonjour {{ Sentinel::getUser()->email }} ! <span>Vous êtes connectés.</span></p>
    </div>
    @else
        <div class="AccueilMsg">
            <p>Bienvenue, <span>vous devez vous inscrire pour continuer.</span></p>
        </div>
    @endif

</div>
<div class="accueil"></div>
<div class="container">
    @include('Centaur::notifications')
    @yield('content')
</div>

<section>
    <p>Bienvenue sur <span>Vimolia</span></p>
    <p class="WelcomeMsg">Première web TV en France entièrement consacrée aux médecines complémentaires et alternatives</p>
    <br>
</section>

<div id="blocPresentation">
<br>
<div class="row skills">
  <div class="col-sm-6 col-md-2">
    <button type="button" class="btn btn-default btn-circle btn-xl"><i class="glyphicon glyphicon glyphicon-off"></i></button>
    <p>Inscription gratuite</p>
  </div>
  <div class="col-sm-6 col-md-2">
    <button type="button" class="btn btn-default btn-circle btn-xl"><i class="glyphicon glyphicon glyphicon-comment"></i></button>
    <p>Posez votre question</p>
  </div>
  <div class="col-sm-6 col-md-2">
    <button type="button" class="btn btn-default btn-circle btn-xl"><i class="glyphicon glyphicon glyphicon-user"></i></button>
    <p>Un expert répondra à votre question</p>
  </div>
  <div class="col-sm-6 col-md-2">
    <button type="button" class="btn btn-default btn-circle btn-xl"><i class="glyphicon glyphicon glyphicon-edit"></i></button>
    <p>Ajoutez plus de détails</p>
  </div>
  <div class="col-sm-6 col-md-2">
    <button type="button" class="btn btn-default btn-circle btn-xl"><i class="glyphicon glyphicon glyphicon-list"></i></button>
    <p>Liste de médecins</p>
  </div>
  <div class="col-sm-6 col-md-2">
    <button type="button" class="btn btn-default btn-circle btn-xl"><i class="glyphicon glyphicon glyphicon-send"></i></button>
    <p>Prenez rendez-vous avec votre médecin</p>
  </div>
</div>
<br><br><br>
<ul class="timeline">
        <li>
          <div class="timeline-badge"><i class="glyphicon glyphicon-off"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title"><i class="glyphicon glyphicon-chevron-right"></i> Inscription gratuite</h4>
            </div>
            <div class="timeline-body">
              <p>Pour accéder aux fonctionnalités du site web, vous devez vous inscrire.</p>
            </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-badge"><i class="glyphicon glyphicon-comment"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title"><i class="glyphicon glyphicon-chevron-right"></i> Posez votre question</h4>
            </div>
            <div class="timeline-body">
              <p>Une fois inscrit sur le site web, il est possible de poser une question.</p>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-badge"><i class="glyphicon glyphicon-user"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title"><i class="glyphicon glyphicon-chevron-right"></i> Un expert répondra à votre question</h4>
            </div>
            <div class="timeline-body">
              <p>Dès cet instant, un expert répondra à votre question.</p>
            </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-badge"><i class="glyphicon glyphicon-edit"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title"><i class="glyphicon glyphicon-chevron-right"></i> Ajoutez plus de détails</h4>
            </div>
            <div class="timeline-body">
              <p>Si la réponse ne vous convient pas, vous pouvez nous envoyer un formulaire plus détaillé.</p>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-badge"><i class="glyphicon glyphicon-list"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title"><i class="glyphicon glyphicon-chevron-right"></i> Liste de médecins</h4>
            </div>
            <div class="timeline-body">
              <p>Notre expert sélectionnera un panel de médecins en fonction du formulaire que vous aurez dressé.</p>
            </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-badge"><i class="glyphicon glyphicon-send"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title"><i class="glyphicon glyphicon-chevron-right"></i> Prenez rendez-vous avec votre médecin</h4>
            </div>
            <div class="timeline-body">
              <p>Choisissez votre médecin et prenez rendez-vous avec lui.</p>
            </div>
          </div>
        </li>
    </ul>
</div>
@stop