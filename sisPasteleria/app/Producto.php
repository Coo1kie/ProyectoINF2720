<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='producto';
    protected $primaryKey="idproducto";

    public $timestamps=false;
    protected $fillable=[
    	'idcategoria',
    	'nombre',
    	'stock',
    	'descripcion',
    	//'imagen',
    	'estado',
    	'precio'
    ];

    protected $guarded=[

    ];
}
