@extends('Centaur::layout')
@section('title', 'liste des praticiens')

@section('content')
	{{ Form::open(array('method' => 'GET' ,'route' => ['users.doctor.list'])) }}
			{{ Form::text('last_name', null,['placeholder'=>'Nom','class'=>'form-control'])}}
			{{ Form::text('city', null,['placeholder'=>'Ville','class'=>'form-control'])}}
			<div class="form-group">
				<select multiple="multiple" class="selectpicker" name="skill" id="disciplines">
					@foreach($skills as $skill)
						<option value="{{$skill['name']}}">{{$skill['name']}}</option>
					@endforeach
				</select>
			</div>
		<input class="btn btn-lg btn-primary btn-block" type="submit" value="rechercher">
	{{ Form::close() }}
<h2>Liste des praticiens</h2>
<div class="panel panel-default">
  <table class="table">
  <thead>
      <tr>
        <th>#</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Code postale</th>
        <th>Ville</th>
        <th>Métier</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
    @foreach($doctors as $index => $doctor)
      <tr>
        <td>{{$index}}</td>
        <td>{{$doctor->first_name}}</td>
        <td>{{$doctor->last_name}}</td>
        <td>{{$doctor->address}}</td>
        <td>{{$doctor->zip_code}}</td>
        <td>{{$doctor->city}}</td>
        <td>{{$doctor->profession}}</td>
        <td>{{$doctor::getNote($doctor->id)}}</td>
        <td>
          @if(Sentinel::inRole('expert'))
            {!! link_to(route('convs.create',$doctor->id),'Contacter') !!}
          @endif
        </td>
      </tr>
@endforeach
    </tbody>
  </table>
</div>
@stop