@extends('Centaur::layout')
@section('title', 'Liste des questions publiques')

@section('content')
<h2>Liste des questions publiques</h2>
<div class="list-group">
@foreach($convs as $index => $conv)
   <div class=" list-group-item">
   		<div class="sujet">
		    <p class="sujetPose">
		    	<span>Sujet:</span> 
		    	{{ $conv->title }}
		    </p>
		  	<br>
		    <button type="button" class="bouton">
		    	<a href="{{route('convs.show',$conv->id)}}">Voir la question</a>
		    </button>
		</div>
    </div>
@endforeach
</div>
@stop
