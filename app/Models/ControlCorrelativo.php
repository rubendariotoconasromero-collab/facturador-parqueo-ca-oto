<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCorrelativo extends Model
{
    use HasFactory;
    protected $table = 'control_correlativo';
    protected $fillable = [ 
        'id',
        'fecha',
        'fecha_final',
        'estado',
        'correlativo',
        'controlT'
        
    ];
    public $timestamps = false;
}
