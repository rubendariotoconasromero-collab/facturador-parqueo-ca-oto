<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    use HasFactory;
    protected $table = 'tipo_producto';
    protected $fillable = [ 
        'id',
        'nombre',
        'descripcion',
        'estado'
    ];
    public $timestamps = false;
}
