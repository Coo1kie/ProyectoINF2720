@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Editar Producto: {{ $producto->nombre}}</h3>
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

		{!! Form::model($producto,['method'=>'PATCH','route'=>['producto.update',$producto->idproducto],'files'=>'true'])!!}
		 {{Form::token()}}
		
		<div class="row">

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="nombre">Nombre</label>
			     <input type="text" name="nombre" required value="{{$producto->nombre}}" class="form-control">
			    </div>
			</div>
            
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
					<label>Categoria</label>
					<select name="idcategoria" class="form-control">
						@foreach($categorias as $cat)
						@if($cat->idcategoria==$producto->idcategoria)
						<option value="{{$cat->idcategoria}}" selected>{{$cat->nombre}}</option>
						@else
						<option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
						@endif
						@endforeach
					</select>					
				</div>
			</div>

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="stock">Stock</label>
			     <input type="text" name="stock" required value="{{$producto->stock}}" class="form-control">			
		        </div>
			</div>

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="descripcion">Descripcion</label>
			     <input type="text" name="descripcion" value="{{$producto->descripcion}}" class="form-control" placeholder="Descripcion del Producto...">			
		        </div>
			</div>
			
			<!--<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="imagen">Imagen</label>
			     <input type="file" name="imagen" class="form-control">
			     @if(($producto->imagen)!="")
			     	<img src="{{asset('imagenes/productos/'.$producto->imagen)}}" height="=300px" width="300px">
			     @endif			
		        </div>
			</div>-->

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
			     <label for="precio">Precio</label>
			     <input type="text" name="precio" required value="{{$producto->precio}}" class="form-control">	
		        </div>
			</div>

  		    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			  <div class="form-group">

			      <button class="btn btn-primary" type="submit">Guardar</button>
			    <a class="btn btn-danger" href="{{route('producto.index')}}">Cancelar</a>	

			  </div>
	        </div>
	</div>

		{{Form::close()}}
		
@endsection