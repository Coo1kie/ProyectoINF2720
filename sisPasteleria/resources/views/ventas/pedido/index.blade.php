@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Pedidos<a href="pedido/create"><button class="btn btn-success">Nuevo</button></a></h3>
		@include('ventas.pedido.search')
	</div>
</div>	
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Fecha Encargo</th>
					<th>Fecha Entrega</th>
					<th>Cliente</th>
					<th>Anticipo</th>
					<th>Total</th>
					<th>Estado</th>		
					<th>Opciones</th>
				</thead>

				@foreach($pedidos as $pe )
				  <tr>
				  	<td>{{$pe->idpedido}}</td>
				  	<td>{{$pe->fecha_encargo}}</td>
				  	<td>{{$pe->fecha_entrega}}</td>
				  	<td>{{$pe->nombre}}</td>
				  	<td>{{$pe->anticipo}}</td>
				  	<td>{{$pe->total}}</td>
				  	<td>{{$pe->estado}}</td>			   
				  	

				  	<td>
		               <a href="{{URL::action('PedidoController@show',$pe->idpedido)}}"><button class="btn btn-primary">Detalles</button></a>
				  		<a href="" data-target="#modal-delete-{{$pe->idpedido}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
				  	   
				  	</td>
				  </tr>
				  @include('ventas.pedido.modal')
				@endforeach
			</table>
		</div>

		{{$pedidos->render()}}
		
	</div>
</div>
@endsection
