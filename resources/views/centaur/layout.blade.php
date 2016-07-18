<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>@yield('title')</title>

        <!-- Bootstrap - Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    
        <link href="/css/style.css" rel="stylesheet">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
 
          <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/fr.js"></script>
        <!-- Latest compiled and minified Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--<a class="navbar-brand" href="/">Vimolia</a>-->
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="navbar navbar-custom     navbar-fixed-top">
                    <div class="container">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                @if (Sentinel::check() && Sentinel::inRole('administrateur'))
                                    <li class="{{ Request::is('users*') ? 'active' : '' }}"><a href="{{ route('users.index') }}">Utilisateurs</a></li>
                                    <li class="{{ Request::is('roles*') ? 'active' : '' }}"><a href="{{ route('roles.index') }}">Roles</a></li>
                                    <li class="{{ Request::is('forms*') ? 'active' : '' }}"><a href="{{ route('forms.index') }}">Roles</a></li>
                                @elseif(Sentinel::check())
                                     <li><a href="{{ route('convs.index') }}">Messages({{$unread}})</a></li>
                                     <li><a href="{{ route('convs.public') }}">Questions publiques</a></li>
                                     @if(Sentinel::inRole('user'))
                                     <li><a href="{{ route('convs.create') }}">Poser une question</a></li>
                                     <li><a href="{{ route('forms.list') }}">Formulaires</a></li>
                                     @elseif(Sentinel::inRole('expert'))
                                     <li><a href="{{ route('forms.index') }}">Demandes avec un practicien</a></li>
                                     @endif
                                @endif
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                @if (Sentinel::check())
                                    <li><p class="navbar-text">{{ Sentinel::getUser()->email }}</p></li>
                                    <li><a href="{{ route('auth.logout') }}">Déconnexion</a></li>
                                @else
                                    <li><a href="{{ route('auth.login.form') }}">Connexion</a></li>
                                    <li><a href="{{ route('auth.register.form') }}">Inscription</a></li>
                                @endif
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </nav>
        <div class="container">
            @include('Centaur::notifications')
            @yield('content')
        </div>

        <!-- Restfulizer.js - A tool for simulating put,patch and delete requests -->
        <script src="{{ asset('restfulizer.js') }}"></script>
    </body>
</html>