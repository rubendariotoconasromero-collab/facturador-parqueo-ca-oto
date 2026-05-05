<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrasena extends Model
{
    use HasFactory;
    protected $table = 'contrasena';
    protected $fillable = [ 
        'id',
        'nombre'
    ];
    public $timestamps = false;
}
