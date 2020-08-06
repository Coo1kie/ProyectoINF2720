<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use App\Http\Requests\ProductoFormRequest;
use App\Producto;
use DB;

class ProductoController extends Controller
{
	//video 11
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    	if($request)
    	{
    		$query=trim($request->get('searchText'));
    		$productos=DB::table('producto as p')
    		->join('categoria as c','p.idcategoria','=','c.idcategoria')
    		->select('p.idproducto','p.nombre','p.stock','c.nombre as categoria','p.descripcion','p.imagen','p.estado','p.precio')
            ->where('estado','=','Activo')
    		->where('p.nombre','LIKE','%'.$query.'%')
    		->orderBy('p.idproducto','asc')
    		->paginate(7);
    		return view('almacen.producto.index',["productos"=> $productos,"searchText"=>$query]);
    	}
    }

    public function create()
    {
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get();
    	return view("almacen.producto.create",["categorias"=>$categorias]);
    }
    //alamacena el obj del modelo categoria en nuestra tabla categoria de la base de datos
    public function store(ProductoFormRequest $request)
    {
    	$producto = new Producto;
    	$producto->idcategoria=$request->get('idcategoria');
    	$producto->nombre=$request->get('nombre');
    	$producto->stock=$request->get('stock');
    	$producto->descripcion=$request->get('descripcion');
    	$producto->estado='Activo';

        //Input::hashFile('imagen')
        
    	/*if($imagen = $request->Input::hashFile('imagen')){
    		$file=Input::file('imagen');
    		$file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
    		$file->imagen=$file->getClientOriginalName();
    	}*/
        $producto->precio=$request->get('precio');

    	$producto->save();
    	return Redirect::to('almacen/producto');
    }
    public function show($id)
    {
    	return view("almacen.producto.show",["producto"=>Producto::findOrFail($id)]);

    }
    public function edit($id)
    {
    	$producto=Producto::findOrFail($id);
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get();

    	return view("almacen.producto.edit",["producto"=>$producto,"categorias"=>$categorias]);
    }
    public function update(ProductoFormRequest $request, $id)
    {
        $producto=Producto::findOrFail($id);
    	$producto->idcategoria=$request->get('idcategoria');
    	$producto->nombre=$request->get('nombre');
    	$producto->stock=$request->get('stock');
    	$producto->descripcion=$request->get('descripcion');

    	/*if($imagen = $request->Input::hashFile('imagen')){
    		$file=Input::file('imagen');
    		$file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
    		$producto->imagen=$file->getClientOriginalName();
    	}*/
        $producto->precio=$request->get('precio');

    	$producto->update();
    	return Redirect::to('almacen/producto');
    }
    public function destroy($id)
    {
    	$producto=Producto::findOrFail($id);
    	$producto->estado='Inactivo';
    	$producto->update();
    	return Redirect::to('almacen/producto');
    }
}
