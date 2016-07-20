@extends('Centaur::layout')
@section('title', 'liste des praticiens')

@section('content')
	{{ Form::open(array('method' => 'GET' ,'route' => ['users.doctor.list'])) }}
			{{ Form::text('last_name', null,['placeholder'=>'Nom','class'=>'form-control'])}}
			<div class="form-group">
				<select multiple="multiple" class="selectpicker" name="skills[]" id="disciplines">
					@foreach($skills as $skill)
						<option value="{{$skill['id']}}">{{$skill['name']}}</option>
					@endforeach
				</select>
			</div>
		<input class="btn btn-lg btn-primary btn-block" type="submit" value="rechercher">
	{{ Form::close() }}
<div class="listeMedecin">
	<div class="row">
		@foreach($doctors as $index => $doctor)
			{{ var_dump($doctors) }}

		@endforeach
	</div>
</div>
@stop