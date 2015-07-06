<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
	<h2>Redefinir senha</h2>

	<div>
		Para redefinir a senha complete o formulário neste link: {{ url('password/reset',
		[$token]) }}.<br /> Atenção ele irá expirar em {{
		config('auth.reminder.expire', 60) }} minutos.
	</div>
</body>
</html>
