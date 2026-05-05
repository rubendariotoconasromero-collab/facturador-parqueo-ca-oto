<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrasena;
use DB;

class ContrasenaController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;       
        if ($buscar==''){
            $contrasena = Contrasena::orderBy('contrasena.id', 'desc')->paginate(15);
        }
        else{
            $contrasena = Contrasena::where('contrasena.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('contrasena.id', 'desc')->paginate(15);
        }
        return $contrasena;
    }
    public function modificar(Request $request){
        $obj= Contrasena::findOrFail($request->id);
        $obj->nombre=$request->nombre;
        $obj->save();

        $datos = [
            'tabla' => 'contrasena',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'modificar',
        ];
        $this->guardarBitacora($datos);
    }
    public function cantidadRegistrosC(){
        $cantidad = DB::table('contrasena')->count();

        $data=['nro' =>$cantidad];
        return $data;
    }
}
