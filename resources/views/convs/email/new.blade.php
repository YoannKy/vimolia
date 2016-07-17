<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Hello</h2>

		<p><b>Compte:</b> {{ $email }}</p>
		<p>Vous avez reçu un nouveau message sur la plateforme vimomlia, sujet du message: {{$subject}} <a href="{{ route('convs.show', urlencode($convId)) }}">cliquez ici.</a></p>
		<p>Ou bien rendez vous à cette adresse: <br /> {!! route('convs.show', urlencode($convId)) !!} </p>
		<p>Merci!</p>
	</body>
</html>