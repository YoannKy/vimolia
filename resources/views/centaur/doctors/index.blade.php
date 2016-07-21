@extends('Centaur::layout')
@section('title', 'liste des praticiens')

@section('content')
	{{ Form::open(array('method' => 'GET' ,'route' => ['users.doctor.list'])) }}
			{{ Form::text('last_name', null,['placeholder'=>'Nom','class'=>'form-control'])}}
			{{ Form::text('address', null,['placeholder'=>'localisation','class'=>'form-control'])}}
			<div class="form-group">
				<select multiple="multiple" class="selectpicker" name="skill" id="disciplines">
					@foreach($skills as $skill)
						<option value="{{$skill['name']}}">{{$skill['name']}}</option>
					@endforeach
				</select>
			</div>
		<input class="btn btn-lg btn-primary btn-block" type="submit" value="rechercher">
	{{ Form::close() }}
<div class="listeMedecin">
	<div class="row">
		@foreach($doctors as $index => $doctor)
			<div class="col-sm-6 col-md-4">
				<center>
					<div class="thumbnail">
						<div class="caption">
							<h3>{{$doctor->first_name}} {{$doctor->last_name}}</h3>
							<img src="/images/photo.png" alt="..."><br><br>
						</div>
						<li>
							<ul>Adresse :{{ $doctor->address  }}</ul>
							<ul>Note :{{ $doctor->getNote($doctor->id) }}</ul>
							<ul>Spécialités :</br>
							@foreach($doctor->skills($doctor->id) as $skill)
								{{$skill->name}}<br>
							@endforeach
							</ul>
						</li>
					</div>
				</center>
			@if(Sentinel::inRole('expert'))
				{!! link_to(route('convs.create',$doctor->id),'contacter') !!}
			@endif
			</div>
		@endforeach
	</div>
</div>
@stop