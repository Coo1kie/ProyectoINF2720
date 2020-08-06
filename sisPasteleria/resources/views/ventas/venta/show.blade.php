@extends ('layouts.admin')
@section ('contenido')
<div class="row">
			
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="cliente">Cliente</label>
			      <p>{{$venta->nombre}}</p>	
		        </div>
			</div>

			 <!--<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="fecha_entrega">Fecha</label>
			     <input type="text" name="anticipo"  value="{{old('fecha_hora')}}" class="form-control" >			
		        </div>
			</div>-->
            
	</div>
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				
				 <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				 	<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
				 		<thead style="background-color:#A9D0F5">
				 			<th>Producto</th>
				 			<th>Precio</th>
				 			<th>Cantidad</th>
				 			<th>Subtotal</th>
				 		</thead>
				 		<tfoot>
				 			<th>TOTAL</th>
				 			<th></th>
				 			<th></th>
				 			<th></th>
				 			<th>
				 				<h4 id="total">{{$venta->totalventa}}</h4><input type="hidden" name="totalventa" id="totalventa">
				 			</th>
				 		</tfoot>
				 		<tbody>
				 			@foreach($detalles as $det)
				 			<tr>
				 				<td>{{$det->producto}}</td>
				 				<td>{{$det->precio}}</td>
				 				<td>{{$det->cantidad}}</td>
				 				<td>{{$det->cantidad*$det->precio}}</td>
				 				
				 			</tr>
				 			@endforeach
				 		</tbody>
				 	</table>
				 </div>
			</div>
			
		</div>

  		   
	</div>
		
@endsection
                                                                                                                                               