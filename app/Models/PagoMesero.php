<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoMesero extends Model
{
    use HasFactory;
    protected $table = 'pago_mesero';
    protected $fillable = [ 
        'id',
        'total_venta',
        'comision',
        'id_usuario'
    ];
    public $timestamps = false;
}
