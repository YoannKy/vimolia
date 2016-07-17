@extends('Centaur::layout')

@section('title', 'Edit User')

@section('content')
{{$user->last_name}}
{{$user->first_name}}
Note :{{$note}}
@if ($isFind && !$isNoted))
<p>Notez le practicien :</p>
{{ Form::open(array('route' => ['forms.doctors.note',$user->id])) }}
{{Form::number('note', '')}}
<input type="submit" name="validation" value="valider">
{{ Form::close()}}
@endif
@stop