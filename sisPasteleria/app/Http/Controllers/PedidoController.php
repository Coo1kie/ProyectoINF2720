<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\PedidoFormRequest;
use App\Pedido;
use App\DetallePedido;
//use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class PedidoController extends Controller
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
    		$pedidos=DB::table('pedido as p')
    		->leftjoin ('cliente as c','p.idcliente','=','c.idcliente') 
    		->leftjoin ('detalle_pedido as dp','p.idpedido','=','dp.idpedido')
    		//->leftjoin ('producto as pr','pr.idproducto','=','dp.idproducto')
    		->select ('p.idpedido','p.fecha_encargo','p.fecha_entrega','c.nombre','p.anticipo','p.estado','p.total') 
    		->where('p.idpedido','LIKE','%'.$query.'%')
    		->orderBy('p.idpedido','asc')
    		->groupBy('p.idpedido','p.fecha_encargo','p.fecha_entrega','c.nombre','p.anticipo','p.estado','p.total')
    		->paginate(7);
    		return view ('ventas.pedido.index',["pedidos"=>$pedidos,"searchText"=>$query]);
    	}
    } 
    public function create()
    {
    	$clientes=DB::table('cliente')->get();
    	$productos=DB::table('producto as pr')
    	->select ('pr.nombre as producto','pr.idproducto','pr.precio')
    	->where('pr.estado','=','Activo')
      //->where('pr.stock','>','0')
      ->groupBy('producto','pr.idproducto','pr.precio')
    	->get();
    	return view("ventas.pedido.create",["clientes"=>$clientes,"productos"=>$productos]);
    }
    public function store(PedidoFormRequest $request)
    {
       //try{
       	   DB::beginTransaction();
       	   $pedido=new Pedido;
       	   $pedido->idcliente=$request->get('idcliente');
           $mytime=Carbon::now('America/La_Paz'); 
           $pedido->fecha_encargo=$mytime->toDateTimeString();

           $pedido->fecha_entrega=$request->toDateString(format);
           $pedido->total=$request->get('total');
       	   
       	   
           $pedido->anticipo=$request->get('anticipo');
       	   $pedido->estado='A';
           
       	   $pedido->save();
    
           $idproducto=$request->get('idproducto');
           $cantidad=$request->get('cantidad');
           $precio=$request->get('precio');
           $cont=0;
           while($cont < count($idproducto))
           {
               $detalle=new DetallePedido();
               $detalle->idpedido=$pedido->idpedido;
               $detalle->idproducto=$idproducto[$cont];
               $detalle->cantidad=$cantidad[$cont];
               //$detalle->precio=$precio[$cont];
               $detalle->save();
           	   $cont=$cont+1;
           }

       	   DB::commit();

      /* }catch(Exception $e)
       {
          DB::rollback();
          //return back()->withError($e->getMessage())->withInput();
       }*/
       return Redirect::to('ventas/pedido');
    }
    public function show($id)
    {
         $pedido=DB::table('pedido as p')
    		->join ('cliente as c','c.idcliente','=','p.idcliente') 
    		->join ('detalle_pedido as dp','dp.idpedido','=','p.idpedido')
    		->join ('producto as pr','pr.idproducto','=','dp.idproducto')
    		->select ('p.idpedido','p.fecha_encargo','p.fecha_entrega','c.nombre','p.anticipo','p.estado','p.total') 
    		->where('`p.idpedido','=',$id)
    		->first();
    		$detalles=DB::table('detalle_pedido as dp')
    		->join ('producto as pr','pr.idproducto','=','dp.idproducto')
    		
    		->select ('pr.nombre as producto','pr.precio','dp.cantidad') 
    		->where('dp.idpedido','=',$id)
    		->get();
    		return view("ventas.pedido.show",["pedido"=>$pedido,"detalles"=>$detalles]);
    }
    public function destroy($id)
    {
    	$pedido=Pedido::findOrFail($id);
    	$pedido->estado='Cancelado';
    	$pedido->update();
    	return Redirect::to('ventas/pedido');
    }

    /*public function compl($id){
        $pedido=Pedido::findOrFail($id);
      $pedido->estado='Completado';
      $pedido->update();
      return Redirect::to('ventas/pedido');
    }*/
}
