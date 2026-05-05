<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impresora;
use DB;

class ImpresoraController extends BitacoraController
{
    public function index(Request $request){
        $id_tienda = $request->id_tienda;
        $buscar = $request->buscar;
        $criterio = $request->criterio;       
        if ($buscar==''){
            $impresora = Impresora::orderBy('impresora.id', 'asc')
            ->where('id_tienda',$id_tienda)
            ->paginate(15);
        }
        else{
            $impresora = Impresora::where('impresora.'.$criterio, 'like', '%'.$buscar.'%')
            ->where('id_tienda',$id_tienda)
            ->orderBy('impresora.id', 'asc')
            ->paginate(15);
        }
        return $impresora;
    }

    public function guardar(Request $request){

            $impresora= new Impresora();
            $impresora->nombre=$request->nombre;
            $impresora->observacion=$request->observacion;
            $impresora->estado=$request->estado;
            $impresora->save();


        $datos = [
            'tabla' => 'impresora',
            'codigo_tabla' => $impresora->id,
            'transaccion' => 'guardar',
        ];
        $this->guardarBitacora($datos);
    }

    public function modificar(Request $request){
            $impresora= Impresora::findOrFail($request->id);
            $impresora->nombre=$request->nombre;
            $impresora->observacion=$request->observacion;
            $impresora->estado=$request->estado;
            $impresora->save();


        $datos = [
            'tabla' => 'impresora',
            'codigo_tabla' => $impresora->id,
            'transaccion' => 'modificar',
        ];
        $this->guardarBitacora($datos);

    }
    
    public function desactivar(Request $request){
        $impresora = Impresora::findOrFail($request->id);
        $impresora->estado = '0';
        $impresora->save();
    }

    public function activar(Request $request){
        $impresora = Impresora::findOrFail($request->id);
        $impresora->estado = '1';
        $impresora->save();
    }

    public function cantidadRegistros(){
        $cantidad = DB::table('impresora')->count();
        $data=['nro' =>$cantidad];
        return $data;
    }
}
