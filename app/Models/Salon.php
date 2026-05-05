<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;
    protected $table = 'salon';
    protected $fillable = [ 
        'id',
        'nombre',
        'estado',
        'foto'
    ];
    public $timestamps = false;
}
