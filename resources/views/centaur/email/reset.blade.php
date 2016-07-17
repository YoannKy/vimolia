<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Reinitialiser votre mot de passe</h2>

		<p>Pour changer votre mot de passe, <a href="{{ route('auth.password.reset.form', urlencode($code)) }}">Cliquez ici.</a></p>
		<p>Ou bien rendez vous à cette adresse: <br /> {!! route('auth.password.reset.form', urlencode($code)) !!} </p>
		<p>Merci!</p>
	</body>
</html>