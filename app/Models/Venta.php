<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'venta';
    protected $fillable = [ 
        'id',
        'fecha',
        'tipo_venta',
        'control',
        'sub_total',
        'descuento',
        'total',
        'usuario',
        'imprimir',
        'id_tipo_pago',
        'id_forma_pago',
        'id_usuario',
        'id_tienda',
        'id_cliente',
        'id_mesa',
        'estado',
         
    ];
    public $timestamps = false;
}
