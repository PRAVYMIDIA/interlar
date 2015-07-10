<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
	<h2>Resposta de contato</h2>

	<div>
                {{ $mensagem }}
                <br><br>
		Att. <strong>{{ $nome }}</strong> 
                <hr>
                <strong>Mensagem recebida:</strong>
                <br>
                {{ $mensagem_recebida }}
	</div>
</body>
</html>
