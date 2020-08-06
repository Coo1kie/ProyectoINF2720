<!DOCTYPE html>
	<html>
	 <title>Reporte Ventas</title>
	<head>
		<style >
			table{
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%;
				}
			td, th{
				border: 1px solid #dddddd;
				text-align: left;
				padding: 8px;
			}
			tr: nth-child(even){
				background-color:#dddddd;

			}
		</style>
	</head>
	<body>
		<h2>Reporte de Ventas</h2>
		<table>
			<tr>
				<th>ID</th>
				<th>Cliente</th>
				<th>Fecha Hora</th>
				<th>Total</th>
			</tr>
			@foreach($ventas as $ven)
			<tr>

				<td>{{$ven->idventa}}</td>
				<td>{{$ven->nombre}}</td>
				<td>{{$ven->fecha_hora}}</td>
				<td>{{$ven->totalventa}}</td>
			</tr>
			@endforeach
		</table>
	</body>
	</html>