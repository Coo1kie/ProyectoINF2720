ESTE CODIGO PERMITE MOSTRAR EN PANTALLA LA LISTA DE CLIENTES QUE EXISTEN EN LA BASE DE DATOSY SU ESTADO ES ACTIVO
MUESTRA LOS SIGUIENTES DATOS:
 nombre, estado, numerodedocumento


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
    

