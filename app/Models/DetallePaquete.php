<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePaquete extends Model
{
    use HasFactory;
    protected $table = 'detalle_paquete';
    protected $fillable = [ 
        'id',
        'id_paquete',
        'id_producto',
        'cantidad',
        'eliminado',
    ];
    public $timestamps = false;
}
