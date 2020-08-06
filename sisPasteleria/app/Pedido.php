<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
     protected $table='pedido';
    protected $primaryKey="idpedido";

    public $timestamps=false;
    protected $fillable=[
    	'idcliente',
    	'anticipo',
    	'fecha_encargo',
    	'fecha_entrega',
    	'estado',
        'total'
    ];

    protected $guarded=[

    ];
}
