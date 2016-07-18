@extends('Centaur::layout')
@section('title', 'liste des patients')

@section('content')
<ul>
@foreach($patients as $index => $patient)
	<li>{{$patient->first_name}} {{$patient->last_name}}</li>
@if($patient->isValidate == null)
{{ Form::open(array('route' => ['forms.patients.add',$patient->formId])) }}
		{{ Form::hidden('patient', $patient->id) }}
		<input type="submit" name="validation" value="valider">
		<input type="submit" name="validation" value="refuser">
{{ Form::close()}}
@endif
@endforeach
</ul>
@stop