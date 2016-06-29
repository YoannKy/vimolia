@extends('Centaur::layout')
@section('title', 'Messages')
@section('content')
@if((Sentinel::inRole('expert') && count($messages) ==0 )|| (Sentinel::inRole('practicien')))
    {{ Form::open(array('route' => ['convs.addMessage',$conv->id])) }}
        {{Form::text('message',null,array('required'=>'required'))}}
        {{Form::hidden('id_conv', $conv->id)}}
        {{Form::submit('Envoyer')}}
    {{ Form::close() }}
    @foreach($messages as $message)
        @if(Sentinel::getUser()->id == $message->senderId)
            @if(Sentinel::inRole('expert'))  
                Votre réponse est:
            @else
               Votre question est:
            @endif
            {{$message->content}}
            {{$message->created}}
        @else
            {{$message->content}}
            {{$message->created}}
        @endif
        <br>
    @endforeach
@else
    @if(Sentinel::inRole('expert'))
        <h2>Sujet: {{$conv->title}}  </h2>
        <span>répondez à la question du patient</span>    
    @else
        <h2>Posez votre question</h2>
        <span>Un expert y répondra dans les plus brefs délais</span>
    @endif
    @if(empty($messages) || (Sentinel::inRole('expert')) && count($messages) < 2)
        {{ Form::open(array('route' => ['convs.addMessage',$conv->id])) }}
            @if(count($messages) == 0) 
                {{Form::label('title', 'Titre de ma question')}}
                {{Form::text('title',null,array('required'=>'required','id'=>'title'))}}
            @endif
            {{Form::label('message', 'ma question')}}
            {{Form::textarea('message',null,array('required'=>'required','id'=>'message'))}}
            {{Form::hidden('id_conv', $conv->id)}}
            @if(Sentinel::inRole('expert')) 
                {{Form::label('default', 'Réponse par défaut')}}
                {{Form::checkbox('default', 'true') }}
                {{Form::submit('Je valide ma réponse')}}
            @else
                @if(Sentinel::inRole('user'))
                    {{ Form::label('public', 'Rendre ma question publique (uniquement si la réponse vous convient)  ')}}
                    {{Form::checkbox('public',true)}}
                @endif
                {{Form::submit('Je valide ma question')}}
            @endif
        {{ Form::close() }}
    @else
        @if(Sentinel::inRole('expert'))
        <h3>Merci d'avoir répondu !</h3>
        @else
        <h3>Merci d'avoir posée votre question !</h3>
        @endif
    @endif
    <?php $expertId = null; ?>
    @foreach($messages as $message)
        @if(Sentinel::getUser()->id == $message->senderId)
            @if(Sentinel::inRole('expert'))  
                Votre réponse est:
            @else
               Votre question est:
            @endif
            {{$message->content}}
            {{$message->created}}
        @else
            @if(Sentinel::inRole('expert'))
                Sa question est:
            @else
                <?php
                if (is_null($expertId)) {
                    $expertId = $message->senderId;
                }
                ?>
                La réponse de l'expert est:
            @endif
            {{$message->content}}
            {{$message->created}}
        @endif
        <br>
    @endforeach
    @if(Sentinel::inRole('user') && 
        count($messages)==2 &&
        $conv->closed == 0  && 
        ($conv->satisfied == 0   || $conv->further ==0 ))
        {{ Form::open(array('route' => ['convs.close',$conv->id])) }}
            {{Form::hidden('satisfied',0 )}}
            {{Form::hidden('expertId', $expertId)}}
            {{Form::submit('je souhaite plus de détails')}}
        {{ Form::close() }}

        {{ Form::open(array('route' => ['convs.close',$conv->id])) }}
            {{Form::hidden('satisfied',1 )}}
            {{Form::hidden('expertId', $expertId)}}
            {{Form::submit('cette réponse me convient')}}
        {{ Form::close() }}
    @endif
@endif
<script type="text/javascript">
    $(function(){
        (function() {
            var prevMessage = $('#message').val(); 
            $('#default').on('change',function(){
                if($(this).is(':checked')){
                    prevMessage = $('#message').val(); 
                    $('#message').val("Bonjour , nous avons bien pris connaissance de votre demande , nous vous conseillons d'aller voir la video : http://youtube.com , si cela ne vous aide pas revenez vers nous.");
                } else {
                    $('#message').val(prevMessage);

                }
            });
        })();
    });   
</script>
@stop