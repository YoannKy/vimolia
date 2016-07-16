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
        <h2>Sujet : {{$conv->title}}  </h2>
        <p class="sous-titre">Répondez à la question du patient</p>
        <br><br><br>
    @else
        <h2>Posez votre question</h2>
        <p class="sous-titre">Un expert y répondra dans les plus brefs délais</p>
        <br>
    @endif
    @if(empty($messages) || (Sentinel::inRole('expert')) && count($messages) < 2)
        {{ Form::open(array('route' => ['convs.addMessage',$conv->id])) }}
            @if(count($messages) == 0) 
                <div class="form-group">
                <br><br>
                {{Form::label('title', 'Titre de ma question :')}}
                {{Form::text('title',null,array('class'=>'form-control','required'=>'required','id'=>'title'))}}
                </div>
            @endif
            {{Form::label('message', 'Ma réponse :')}}
            {{Form::textarea('message',null,array('class'=>'form-control',   'required'=>'required','id'=>'message'))}}     
            <br>      
            {{Form::hidden('id_conv', $conv->id)}}
            @if(Sentinel::inRole('expert')) 
                {{Form::label('default', 'Réponse par défaut')}}
                {{Form::checkbox('default', 'true') }}
                <select style="width:100%;" name="video" id="video"></select>     
                <script type="text/javascript">
                    $(function(){
                        (function() {
                            var prevMessage = $('#message').val(); 
                            $('#default').on('change',function(){
                                if($(this).is(':checked')){
                                    prevMessage = $('#message').val(); 
                                    $('#message').val("Bonjour , nous avons bien pris connaissance de votre demande , nous vous conseillons d'aller voir la video ci-jointe , si cela ne vous aide pas revenez vers nous.");
                                } else {
                                    $('#message').val(prevMessage);

                                }
                            });

                            var page = "";

                            $("#video").on('change',function(){
                                page = "";
                            })
                            $("#video").select2({
                                language: "fr",
                                ajax: {
                                    url: "https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=UCDg53Em9AHmMlpdlL9j7svw&maxResults=50&key={{$key}}",
                                    dataType: 'json',
                                    delay: 350,
                                    data: function (params) {
                                        if(page === "") {
                                            return {
                                                q : params.term
                                            }    
                                        } else {
                                            return {
                                                q : params.term, 
                                                pageToken : page
                                            }
                                        }
                                    },
                                    processResults: function (data, params) {
                                        page = data.nextPageToken || "";
                                        params.page = params.page || 1;

                                        data.items.forEach(function (item) {
                                            item.id = item.id.videoId;
                                            item.text = item.snippet.title;
                                        });
                                        return {
                                            results: data.items,
                                            pagination: {
                                              more: ( data.nextPageToken !== null && data.items.length > 1  )
                                            }
                                        };
                                    },
                                    cache: false
                                },
                                escapeMarkup: function (markup) { return markup; },
                                minimumInputLength: 3,
                                templateResult: videoFormatResult,
                                templateSelection: videoFormatSelection 
                            }); 

                            function videoFormatResult(video) {
                                if (video.loading) return video.text;
                                var markup = '<div class="clearfix">' +
                                                '<div class="col-sm-5">' +
                                                    '<img src="' + video.snippet.thumbnails.default.url + '" style="max-width: 100%" />' +
                                                '</div>' +
                                            '<div clas="col-sm-10">' +
                                            '<div class="clearfix">' +
                                                '<div class="col-sm-6">' + video.snippet.title + '</div>'+
                                            '</div>';
                                markup += '</div>';
                                return markup;
                            }

                           function videoFormatSelection(video) {
                              return video.snippet.title || video.text;
                           }
 
                       })();
                    });   
                </script>
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
                <p class="reponse">Votre réponse est:>
            @else
               <p class="question">Votre question est :
            @endif
            {{$message->content}}</p>
            <p class="date">Publiée le : 
            {{$message->created}}</p>

        @else
            @if(Sentinel::inRole('expert'))
            <br>
            <div class="expertReponse">
                <p class="reponse">Rappel de la question du patient :
            @else
                <?php
                if (is_null($expertId)) {
                    $expertId = $message->senderId;
                }
                ?>
                La réponse de l'expert est :
            @endif
            {{$message->content}}</p>
            <p class="date">Publiée le : {{$message->created}}</p>
            </div>
            @if($conv->video != null)
                Une vidéo à été postée pour cette question/réponse :
                <a href="https://youtube.com/watch?v={{$conv->video}}" target="_blank">la vidéo</a>
            @endif
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
@stop