<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    protected $table = 'articulo';
    protected $fillable = [
        'id',
        'cod_producto',
        'cod_proveedor',
        'cod_veterinaria',
        'nombre_comercial',
        'nombre_generico',
        'presentacion',
        'contenido_unidad',
        'costo_compra',
        'costo_venta',
        'stock_minimo',
        'descripcion',
        'tipo_producto',
        'combo',
        'receta',
        'fecha_vencimiento',
        'estado',
        'menu_dia',
        'id_categoria',
        'id_unidad',
        'id_proveedor',
    ];    
    public $timestamps = false;
}
