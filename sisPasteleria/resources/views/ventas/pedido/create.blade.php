@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Nuevo Pedido</h3>
		@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
				<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>

		{!! Form::open(array('url'=>'ventas/pedido','method'=>'POST','autocomplete'=>'off'))!!}
		{{Form::token()}}
		<div class="row">

			 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="fecha_entrega">Fecha Entrega</label>
			     <input type="date" name="fecha_entrega"  value="{{old('fecha_entrega')}}" class="form-control" >			
		        </div>
			</div>

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="cliente">Cliente</label>
			      <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
			      	 @foreach ($clientes as $cliente)
			      		<option value="{{$cliente->idcliente}}">{{$cliente->nombre}}</option>
			      	 @endforeach
			      </select>		
		        </div>
			</div>

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="anticipo">Anticipo</label>
			     <input type="number" name="anticipo"  value="{{old('anticipo')}}" class="form-control" >			
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
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				 	<div class="form-group">
				 		<label>Producto</label>
				 		 <select name="pidproducto" class="form-control selectpicker" id="pidproducto" data-live-search="true">
				 		 	@foreach ($productos as $producto)
				 		 	<option value="{{$producto->idproducto}}_{{$producto->precio}}">{{$producto->producto}}</option>
				 		 	@endforeach
				 		 	
				 		 </select>				 		
				 	</div>
				 </div>

				 <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				 	<div class="form-group">
				 		<label for="cantidad">Cantidad</label>
				 		<input type="number" name="pcantidad" id="pcantidad" class="form-control">
				 	</div>
				 </div>
				 <!--<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				 	<div class="form-group">
				 		<label for="stock">Stock</label>
				 		<input type="number" disabled name="pstock" id="pstock" class="form-control" placeholder="Stock">
				 	</div>-->
				 
				 <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				 	<div class="form-group">
				 		<label for="precio">Precio</label>
				 		<input type="number" disabled name="pprecio" id="pprecio" class="form-control" placeholder="Precio">
				 	</div>
				 </div>

				 <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
				 	<div class="form-group">
				 		<button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
				 	</div>
				 </div>


				 <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				 	<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
				 		<thead style="background-color:#A9D0F5">
				 			<th>Opciones</th>
				 			<th>Producto</th>
				 			<th>Cantidad</th>
				 			<th>Precio</th>
				 			<th>Subtotal</th>
				 		</thead>
				 		<tfoot>
				 			<th>TOTAL</th>
				 			<th></th>
				 			<th></th>
				 			<th></th>
				 			<th>
				 				<h4 id="total">Bs/. 0.00</h4><input type="hidden" name="total" id="total">
				 			</th>
				 		</tfoot>
				 		<tbody>
				 			
				 		</tbody>
				 	</table>
				 </div>
			</div>
			
		</div>

  		    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
			  <div class="form-group">
			  		<input name="_token" value="{{csrf_token()}}" type="hidden"></input>
			      <button class="btn btn-primary" type="submit">Guardar</button>
			       <a class="btn btn-danger" href="{{route('pedido.index')}}">Cancelar</a>		
			  </div>
	        </div> 
	</div>
		

		{{Form::close()}}
@push('scripts')
	<script >
		$(document).ready(function(){
			$('#bt_add').click(function(){
				agregar();
			});
		});
		var cont=0;
		total=0;
		subtotal=[];
		$("#guardar").hide()
		$("#pidproducto").change(mostrarValores);

		function mostrarValores(){
			datosProducto=document.getElementById('pidproducto').value.split('_');
			$("#pprecio").val(datosProducto[1]);
			//$("#pstock").val(datosProducto[1]);
		}

		function agregar() {
			datosProducto=document.getElementById('pidproducto').value.split('_');

			idproducto=datosProducto[0];
			producto=$("#pidproducto option:selected").text();
			cantidad=$("#pcantidad").val();
			//stock=$("#pstock").val(datosProducto[1]);
			precio=$("#pprecio").val();
			

			if (idproducto!="" && cantidad!="" && cantidad>0 && precio !="") {
				//if (stock>=cantidad) {
					subtotal[cont]=(cantidad*precio);
					total=total+subtotal[cont];
                  var fila='<tr class="selected" id="fila"'+cont+'><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')">X</button></td><td><input type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precio[]" value="'+precio+'"></td><td>'+subtotal[cont]+'</td></tr>';
			
					cont++;
					limpiar();

				$("#total").html("Bs/. " + total);
				$("#totalventa").val(total);
				evaluar();
				$('#detalles').append(fila);
				/*}else{
					alert('La cantidad a vender supera el stock');
				}*/
			}

			else{
				alert("Error al ingresar el detalle de la Venta, revise los datos del producto");
			}
		}

		function limpiar(){
			$("#pcantidad").val("");
			$("#pprecio").val("");
		}
		function evaluar(){
			if (total >0) {
				$("#guardar").show();
			}
			else{
				$("#guardar").hide();
			}
		}

		function eliminar(index){
			total=total-subtotal[index];
			$("#total").html("Bs/." + total);
			$("#totalventa").val(total);
			$("#fila").remove(index);
			evaluar();
		}
	</script>

@endpush

@endsection
                                                                                                                                               