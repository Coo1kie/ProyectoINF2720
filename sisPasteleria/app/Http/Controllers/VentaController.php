<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\VentaFormRequest;
use App\Venta;
use App\DetalleVenta;
//use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    //video 27
      public function __construct()
    {
       $this->middleware('auth');
    }
    public function index(Request $request)
    {
    	if($request)
    	{
    		$query=trim($request->get('searchText'));
    		$ventas=DB::table('venta as v')
    		->leftjoin ('cliente as c','v.idcliente','=','c.idcliente') 
    		->leftjoin ('detalle_venta as dv','v.idventa','=','dv.idventa')
    		->select ('v.idventa','v.fecha_hora','c.nombre','v.estado','v.totalventa') 
    		->where('v.idventa','LIKE','%'.$query.'%')
    		->orderBy('v.idventa','asc')
    		->groupBy('v.idventa','v.fecha_hora','c.nombre','v.estado','v.totalventa')//se aumenta esta linea para que no se registrara doble
    		->paginate(7);
    		return view ('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
    	}
    } 
    public function create()
    {
    	$clientes=DB::table('cliente')->get();
    	$productos=DB::table('producto as pr')
    	->select ('pr.nombre as producto','pr.idproducto','pr.stock','pr.precio')
    	->where('pr.estado','=','Activo')
    	->where('pr.stock','>','0')
      ->groupBy('producto','pr.idproducto','pr.stock','pr.precio') //se aumento esta linea, ya que en index sin el groupby se registraba doble
    	->get();
    	return view("ventas.venta.create",["clientes"=>$clientes,"productos"=>$productos]);
    }
    public function store(VentaFormRequest $request)
    {
        try {
          DB::beginTransaction();
           $venta=new Venta;
           $venta->idcliente=$request->get('idcliente');
           $venta->totalventa=$request->get('totalventa');
           $mytime=Carbon::now('America/La_Paz'); 
           $venta->fecha_hora=$mytime->toDateTimeString();
           $venta->estado='Activo';
           $venta->save();
    
           $idproducto=$request->get('idproducto');
           $cantidad=$request->get('cantidad');
           $precio=$request->get('precio');
           $cont=0;
           while($cont < count($idproducto))
           {
               $detalle=new DetalleVenta();
               $detalle->idventa=$venta->idventa;
               $detalle->idproducto=$idproducto[$cont];
               $detalle->cantidad=$cantidad[$cont];
               //$detalle->precio=$precio[$cont];
               $detalle->save();
               $cont=$cont+1;
            }

           DB::commit();
          
        } catch (Exception $e) {
          DB::rollback();
        }
       	   

      
       return Redirect::to('ventas/venta');
    }
    public function show($id)
    {
         $venta=DB::table('venta as v')
    		->join ('cliente as c','c.idcliente','=','v.idcliente') 
    		->join ('detalle_venta as dv','dv.idventa','=','v.idventa')
    		->select ('v.idventa','v.fecha_hora','c.nombre','v.estado','v.totalventa') 
    		->where('v.idventa','=',$id)
    		->first();
    		$detalles=DB::table('detalle_venta as dv')
    		->join ('producto as pr','pr.idproducto','=','dv.idproducto')    		
    		->select ('pr.nombre as producto','pr.precio','dv.cantidad') 
    		->where('dv.idventa','=',$id)
    		->get();
    		return view("ventas.venta.show",["venta"=>$venta,"detalles"=>$detalles]);
    }
    public function destroy($id)
    {
    	$venta=Venta::findOrFail($id);
    	$venta->estado='Cancelado';
    	$venta->update();
    	return Redirect::to('ventas/venta');
    }
}
