<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use App\Http\Controllers\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\VentaFormRequest;
use App\Venta;
use View;

//use App\Http\Controllers\App;
use App;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class ReporteController extends Controller
{
      public function __construct()
      {
         $this->middleware('auth');
      }

      public function generar(){
      	$ventas=DB::table('venta as v')
      	->leftjoin ('cliente as c','v.idcliente','=','c.idcliente') 
      	->select('v.idventa','v.fecha_hora','c.nombre','v.totalventa')
      	->get();
      	//dd($ventas);
      	$view=View::make('reporte.pdf.reporte', compact('ventas'))->render();
      	$pdf=App::make('dompdf.wrapper');
      	$pdf->loadHTML($view);
        return $pdf->stream('reporte.pdf');
      	//return view('reporte/pdf/reporte');
      }
}
