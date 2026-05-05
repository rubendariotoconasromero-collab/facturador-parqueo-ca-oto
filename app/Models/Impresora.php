<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impresora extends Model
{
    use HasFactory;
    protected $table = 'impresora';
    protected $fillable = [ 
        'id',
        'nombre',
        'observacion',
        'estado'
    ];
    public $timestamps = false;
}
