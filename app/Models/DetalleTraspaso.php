<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTraspaso extends Model
{
    use HasFactory;
    protected $table = 'detalle_traspaso';
    protected $fillable = [ 
        'id',
        'id_producto',
        'id_traspaso',
        'cantidad',
    ];
    public $timestamps = false;
}
