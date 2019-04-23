<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
</head>
<body>
	<h3>{{ $bodyMessage }}</h3>
	<div class="table-container">
		<a href="https://localhost:8000/verify?token='.{{$token}}'" target="_blank">Confirmar</a>
	</div>
</body>
</html>


