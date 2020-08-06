<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
       protected $table='venta';
    protected $primaryKey="idventa";

    public $timestamps=false;
    protected $fillable=[
    	'idcliente',
    	'fecha_hora',
    	'totalventa',
    	'estado'
    ];

    protected $guarded=[

    ];
}
