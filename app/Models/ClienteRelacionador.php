<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteRelacionador extends Model
{
    use HasFactory;
    protected $table = 'cliente_relacionador';
    protected $fillable = [ 
        'id',
        'nombre',
        'fecha',
        'cantidad',
        'asistencia',
        'estado',
        'eliminado',
        'id_personal'
    ];
    public $timestamps = false;
}
