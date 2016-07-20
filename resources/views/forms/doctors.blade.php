@extends('Centaur::layout')
@section('title', 'Liste des médecins')

@section('content')
@if(Sentinel::inRole('expert','administrateur'))
	<h2>Liste des médecins</h2>
	<div class="listeMedecin">
		<div class="row">
		{{ Form::open(array('route' => ['forms.doctors.add',$formId])) }}
		
		@foreach($doctors as $index => $doctor)
			<div class="col-sm-6 col-md-4">
				<center>
					<div class="thumbnail">
						
						
						<div class="caption">
							<h3>{{$doctor->first_name}} {{$doctor->last_name}}</h3>
							<img src="/images/photo.png" alt="..."><br><br>
							<p>
								{{ Form::label('doc_'.$doctor->id, 'Proposer ce médecin')}}
				    			{{Form::checkbox('doctors[]',$doctor->id,false,array('id'=>'doc_'.$doctor->id))}}
				    		</p>
						</div>
					</div>
				</center>
			</div>
		@endforeach
		</div>
		<div class="validationChoixMedecin">
			{{ Form::submit('valider')}}
			{{ Form::close()}}
		</div>
	</div>
@else

<h2>Liste des médecins proposés par l'expert</h2>
<p class="sous-titre">
	Vous pouvez prendre contact avec un des médecins proposés puis sélectionner celui avec lequel vous avez pris le rendez-vous.
</p>

{{ Form::open(array('route' => ['forms.doctors.choose',$formId])) }}
<div class="panel panel-default">
  <table class="table">
  <thead>
      <tr>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Choix</th>
      </tr>
    </thead>
    <tbody>
    
	@foreach($doctors as $index => $doctor)
      <tr>
        <td>{{$doctor->first_name}}</td>
        <td>{{$doctor->last_name}}</td>
        <td>{{ Form::radio('doctor', $doctor->id )}}</td>
      </tr>
	@endforeach
		
	</tbody>
  </table>
</div>
{{ Form::submit('Valider')}}
{{ Form::close()}}
@endif
@stop