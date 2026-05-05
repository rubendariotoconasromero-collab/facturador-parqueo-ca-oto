<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    protected $table = 'detalle_venta';
    protected $fillable = [ 
        'id',
        'id_venta',
        'id_producto',
        'cantidad',
        'descripcion',
        'costo_venta',
        'sub_total',
        'estado',
    ];
    public $timestamps = false;
}
