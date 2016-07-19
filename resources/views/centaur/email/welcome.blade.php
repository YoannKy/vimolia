<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Welcome</h2>

		<p><b>Account:</b> {{ $email }}</p>
		<p>Pour activer votre compte, <a href="{{ route('auth.activation.attempt', urlencode($code)) }}">cliquez ici.</a></p>
		<p>Ou bien rendez vous à cette adresse: <br /> {!! route('auth.activation.attempt', urlencode($code)) !!} </p>
		<p>Merci !</p>
	</body>
</html>