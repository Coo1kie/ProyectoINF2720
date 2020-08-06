<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
     protected $table='detalle_pedido';
    protected $primaryKey="iddetalle_pedido";

    public $timestamps=false;
    protected $fillable=[
    	'idpedido',
    	'idproducto',
    	'cantidad'
    ];

    protected $guarded=[

    ];
}
