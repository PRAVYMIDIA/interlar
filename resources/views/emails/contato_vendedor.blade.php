<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
	<h2>Interesse em produto - {{ $produto }}</h2>

	<div>Olá, seguem os dados do visitante que ficou interessado no produto:<br><br>
		Nome:     <strong>{{ $nome }}</strong> <br>
        Celular:  <strong>{{ $celular }}</strong> <br>
        E-mail:   <strong>{{ $email }}</strong> <br>
        Mensagem: <strong>{{ $mensagem }}</strong> <br>
        Produto:  <strong>{{ $produto }}</strong> <br>
        @if(isset($loja))
        Loja:     <strong>{{ $loja }}</strong> <br>
        @endif
	</div>
</body>
</html>
