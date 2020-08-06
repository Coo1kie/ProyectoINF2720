<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cliente;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ClienteFormRequest;
use DB;

class ClienteController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    	if($request)
    	{
    		$query=trim($request->get('searchText'));
    		$clientes=DB::table('cliente')
    		->where('nombre','LIKE','%'.$query.'%')
    		->where('estado','=','Activo')
    		->orwhere('num_documento','LIKE','%'.$query.'%')
    		->where('estado','=','Activo')
    		->orderBy('idcliente','asc')
    		->paginate(7);
    		return view('ventas.cliente.index',["clientes"=> $clientes,"searchText"=>$query]);
    	}
    }

    public function create()
    {
    	return view("ventas.cliente.create");
    }
    //alamacena el obj del modelo categoria en nuestra tabla categoria de la base de datos
    public function store(ClienteFormRequest $request)
    {
    	$cliente = new Cliente;
    	$cliente->nombre=$request->get('nombre');
    	$cliente->tipo_documento=$request->get('tipo_documento');
    	$cliente->num_documento=$request->get('num_documento');
		$cliente->direccion=$request->get('direccion');
		$cliente->telefono=$request->get('telefono');
		$cliente->estado='Activo';
		

    	$cliente->save();
    	return Redirect::to('ventas/cliente');
    }
    public function show($id)
    {
    	return view("ventas.cliente.show",["cliente"=>Cliente::findOrFail($id)]);

    }
    public function edit($id)
    {
    	return view("ventas.cliente.edit",["cliente"=>Cliente::findOrFail($id)]);
    }
    public function update(ClienteFormRequest $request, $id)
    {
    	$cliente=Cliente::findOrFail($id);
    	$cliente->nombre=$request->get('nombre');
    	$cliente->tipo_documento=$request->get('tipo_documento');
    	$cliente->num_documento=$request->get('num_documento');
		$cliente->direccion=$request->get('direccion');
		$cliente->telefono=$request->get('telefono');  

    	$cliente->update();
    	return Redirect::to('ventas/cliente');
    }
    public function destroy($id)
    {
    	$cliente=Cliente::findOrFail($id);
    	$cliente->estado='Inactivo';
    	$cliente->update();
    	return Redirect::to('ventas/cliente');
    }
}
