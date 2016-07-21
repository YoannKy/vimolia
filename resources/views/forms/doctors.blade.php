@extends('Centaur::layout')
@section('title', 'Liste des médecins')

@section('content')
	<script type="text/javascript">
		$(document).ready(function() {
			$("#click").click(function() {
				$('.col-md-4').hide()
				$('.col-md-4').each(
						function()
						{
							if ($('#last_name').val() != "") {
								if(!$(this).hasClass($('#last_name').val())) {
									return true;
								}
							}

							if ($('#city').val() != "") {
								if(!$(this).hasClass($('#city').val())) {
									return true;
								}
							}

							if ($('select option:selected').text() != "") {
								if(!$(this).hasClass($('select option:selected').text())) {
									return true;
								}
							}
							$(this).show();
						}
				);
			});
		});

	</script>
@if(Sentinel::inRole('expert','administrateur'))
	<h2>Liste des médecins</h2>
	{{ Form::text('last_name', null,['id'=> 'last_name', 'placeholder'=>'Nom','class'=>'form-control'])}}
	{{ Form::text('city', null,['id'=> 'city', 'placeholder'=>'Ville','class'=>'form-control'])}}
	<div class="form-group">
		<select multiple="multiple" class="selectpicker" name="skill" id="disciplines">
			@foreach($skills as $skill)
				<option value="{{$skill['name']}}">{{$skill['name']}}</option>
			@endforeach
		</select>
	</div>
	<input class="btn btn-lg btn-primary btn-block"  id='click' type="submit" value="rechercher">
	<div class="listeMedecin">
		<div class="row">
		{{ Form::open(array('route' => ['forms.doctors.add',$formId])) }}
		
		@foreach($doctors as $index => $doctor)
			<div class="col-sm-6 col-md-4 {{$doctor->last_name}} {{$doctor->city}}
			@foreach($doctor->getSkills($doctor->id) as $skill)
				{{$skill->name}}
			@endforeach
			">
				<center>
					<div class="thumbnail">
						
						
						<div class="caption">
							<h3>{{$doctor->first_name}} {{$doctor->last_name}}</h3>
							@if($doctor->avatar)
								<img src="/images/avatar/{{$doctor->avatar}}" alt="..."><br><br>
							@else
								<img src="/images/avatar.png" alt="..."><br><br>
							@endif
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