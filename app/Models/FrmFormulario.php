<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrmFormulario extends Model
{
    use HasFactory;
    protected $table = 'frm_formulario';
    protected $fillable = [ 
        'id',
        'frm'
    ];
    public $timestamps = false;
}
