@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Editar Cliente: {{ $cliente->nombre}}</h3>
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

		{!! Form::model($cliente,['method'=>'PATCH','route'=>['cliente.update',$cliente->idcliente]])!!}
		 {{Form::token()}}
	       <div class="row">

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="nombre">Nombre</label>
			     <input type="text" name="nombre" required value="{{$cliente->nombre}}" class="form-control" placeholder="Nombre...">			
		        </div>
			</div>

			 	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="direccion">Direccion</label>
			     <input type="text" name="direccion"  value="{{$cliente->direccion}}" class="form-control" placeholder="Direccion...">			
		        </div>
			</div>
            
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
					<label>Documento</label>
					<select name="tipo_documento" class="form-control">
						@if ($cliente->tipo_documento=='CI')
						<option value="CI" selected >CI</option>
						<option value="NIT">NIT</option>
						<option value="PAS">PAS</option>
						@elseif ($cliente->tipo_documento=='NIT')
						<option value="CI">CI</option>
						<option value="NIT" selected>NIT</option>
						<option value="PAS">PAS</option>
						@else 
						<option value="CI">CI</option>
						<option value="NIT">NIT</option>
						<option value="PAS" selected>PAS</option>
						@endif
					</select>					
				</div>
			</div>

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="num_documento">Numero Documento</label>
			     <input type="text" name="num_documento"  value="{{$cliente->num_documento}}" class="form-control" placeholder="Numero de Documento...">			
		        </div>
			</div>

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="telefono">Telefono</label>
			     <input type="text" name="telefono" value="{{$cliente->telefono}}" class="form-control" placeholder="Telefono...">			
		        </div>
			</div>
			

  		    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			  <div class="form-group">

			      <button class="btn btn-primary" type="submit">Guardar</button>
			       <a class="btn btn-danger" href="{{route('cliente.index')}}">Cancelar</a>	
			  </div>
	        </div> 
	</div>
	
		{{Form::close()}}
		
@endsection