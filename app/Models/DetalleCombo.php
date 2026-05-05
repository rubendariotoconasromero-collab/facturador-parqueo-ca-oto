<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCombo extends Model
{
    use HasFactory;
    protected $table = 'detalle_combo';
    protected $fillable = [ 
        'id',
        'id_combo',
        'id_articulo',
        'cantidad',
        'estado'
    ];
    public $timestamps = false;
}
