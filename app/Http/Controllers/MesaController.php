<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Http\Requests\MesaRequest;
use DB;
use Illuminate\Support\Facades\File;

class MesaController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;       
        if ($buscar==''){
            $mesa = Mesa::join('salon','mesa.id_salon','=','salon.id')
            ->select('mesa.id','mesa.nombre','mesa.estado','mesa.foto','salon.id as id_salon','salon.nombre as salon')
            ->where('mesa.id','!=',0)
            ->orderBy('mesa.id', 'desc')
            ->paginate(15);
        }
        else{
            $mesa = Mesa::join('salon','mesa.id_salon','=','salon.id')
            ->select('mesa.id','mesa.nombre','mesa.estado','mesa.foto','salon.id as id_salon','salon.nombre as salon')
            ->where('mesa.id','!=',0)
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('mesa.id', 'desc')->paginate(15);
        }
        return $mesa;
    }
    public function guardar(Request $request){
        if (Mesa::where('nombre', $request->nombre)->first()){
            return ['error'=>0];
        }
        else{

                DB::beginTransaction();
                $obj = new Mesa();
                $obj->nombre=$request->nombre;
                $obj->id_salon=$request->id_salon;
                $obj->estado=$request->estado;
                if($request->foto==null){
                    $obj->foto ='mesa.png';
                }
                else{
                    $explode=explode(',',$request->foto);
                    $decoded=\base64_decode($explode[1]);
                    if(str_contains($explode[0],'jpeg')){
                        $extension='jpg';
                    }
                    else{
                        $extension='png';
                    }
                    $fileName = \str_random().'.'.$extension;
                    $path= 'img/producto'.'/'.$fileName;
                    \file_put_contents($path,$decoded);
                    $obj->foto=$fileName;   
                }
                $obj->save();
            }
                $datos = [
                    'tabla' => 'salon',
                    'codigo_tabla' => $obj->id,
                    'transaccion' => 'guardar',
                ];
                $this->guardarBitacora($datos);

            DB::commit();

    }
    public function modificar(Request $request){
        //dd($request->id_salon,$request->nombre,$request->id);
        if (Mesa::where('nombre', $request->nombre)
            // ->where('id_salon', $request->id_salon)
            ->where('id','!=', $request->id)
            ->first()){
            return ['error'=>0];
        
        }else{
            if($request->nombre==""){
                return ['error'=>1];
            }
            else {
                $obj= Mesa::findOrFail($request->id);
                $obj->nombre=$request->nombre;
                $obj->id_salon=$request->id_salon;
                $obj->estado=$request->estado;
                if($request->foto==null){
                    $obj->foto ='mesa.png';
                }
                else{
                    if($request->imagenActual==$request->foto){
                        $obj->foto =$request->imagenActual;
                    }
                    else{
                        $explode=explode(',',$request->foto);
                        $decoded=\base64_decode($explode[1]);
                        if(str_contains($explode[0],'jpeg')){
                            $extension='jpg';
                        }
                        else{
                            $extension='png';
                        }
                        $fileName = \str_random().'.'.$extension;
                        $path= 'img/producto'.'/'.$fileName;
                        \file_put_contents($path,$decoded);
                        $obj->foto=$fileName;  
                        
                        if($request->imagenActual!="mesa.png")
                        {
                            $this->delete($request->imagenActual);
                        }
                    }
                }
                $obj->save();
         
                    $datos = [
                        'tabla' => 'mesa',
                        'codigo_tabla' => $obj->id,
                        'transaccion' => 'modificar',
                    ];
                    $this->guardarBitacora($datos);
            }
        } 
        
    }
    public function delete($nombre){
        $obj = File::delete('img/producto/'.$nombre);
    }
    public function desactivar(Request $request){
        $obj = Mesa::findOrFail($request->id);
        $obj->estado = '0';
        $obj->save();

        $datos = [
            'tabla' => 'mesa',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'desactivar',
        ];
        $this->guardarBitacora($datos);
    }
    public function activar(Request $request){
        $obj = Mesa::findOrFail($request->id);
        $obj->estado = '1';
        $obj->save();

        $datos = [
            'tabla' => 'mesa',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'activar',
        ];
        $this->guardarBitacora($datos);
    }
    public function cantidadRegistros(){
        $cantidad = DB::table('mesa')->where('mesa.id','!=',0)->count();
        $data=['nro' =>$cantidad];
        return $data;
    }
    public function index2(Request $request){
        //dd($request->id_salon);
        $id_salon = $request->id_salon;
        //dd($id_salon);
        $id_usuario=\Auth::user()->id;

        $usuario_grupo=DB::table('users')
        ->join('personal', 'users.id_personal', '=', 'personal.id')
        ->select('users.id_grupo')
        ->where('users.id', $id_usuario)
        ->first();
        //dd($usuario_grupo);

        if($usuario_grupo->id_grupo!=3){
            $categoria = Mesa::join('salon','mesa.id_salon','=','salon.id')
            ->select('mesa.id','mesa.nombre','mesa.foto','mesa.estado')
            ->where('mesa.id','!=',0)
            ->where('mesa.id_salon','=',$id_salon)
            ->orderBy('mesa.id','asc')
            ->get();
        }else{
            $libres = Mesa::join('salon','mesa.id_salon','=','salon.id')
            ->select('mesa.id','mesa.nombre','mesa.foto','mesa.estado')
            ->where('mesa.id','!=',0)
            ->where('mesa.id_salon','=',$id_salon)
            ->where('mesa.estado', '=', 1)
            ->orderBy('mesa.id', 'asc');
           
            
            $ocupadas=Mesa::join('salon','mesa.id_salon','=','salon.id')
            ->join('venta', 'venta.id_mesa', '=', 'mesa.id')
            ->select('mesa.id','mesa.nombre','mesa.foto','mesa.estado')
            ->where('mesa.id','!=',0)
            ->where('mesa.id_salon','=',$id_salon)
            ->where('mesa.estado', '=', 0)
            ->where('venta.id_usuario', $id_usuario)
            ->where('venta.estado','=', 'Registrado')
            ->orderBy('mesa.id', 'asc');

            $categoria = $libres->union($ocupadas)->get();
            //dd($categoria);

        }
        return $categoria;
    }
}
