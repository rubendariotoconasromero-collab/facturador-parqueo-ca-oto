<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Requests\CategoriaRequest;
use DB;
use Illuminate\Support\Facades\File;

class CategoriaController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;       
        if ($buscar==''){
            $categoria = Categoria::orderBy('categoria.id', 'desc')->paginate(15);
        }
        else{
            $categoria = Categoria::where('categoria.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('categoria.id', 'desc')->paginate(15);
        }
        return $categoria;
    }
    public function guardar(Request $request){

        if (Categoria::where('nombre', $request->nombre)->first()){
            return ['error'=>0];
        }else{
            if($request->nombre==""){
                return ['error'=>1];
            }else{
                $categoria= new Categoria();
                $categoria->nombre=$request->nombre;
                $categoria->descripcion=$request->descripcion;
                $categoria->estado=$request->estado;
                if($request->foto==null){
                    $categoria->foto ='defecto.png';
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
                    $categoria->foto=$fileName;   
                }
                $categoria->save();
            }
        }
       
        $datos = [
            'tabla' => 'categoria',
            'codigo_tabla' => $categoria->id,
            'transaccion' => 'guardar',
        ];
        $this->guardarBitacora($datos);
    }
    public function modificar(Request $request){

        if($request->nombre==""){
            return ['error'=>0];
        }else{
            $categoria= Categoria::findOrFail($request->id);
            $categoria->nombre=$request->nombre;
            $categoria->descripcion=$request->descripcion;
            $categoria->estado=$request->estado;
            if($request->foto==null){
                $categoria->foto ='defecto.png';
            }
            else{
                if($request->imagenActual==$request->foto){
                    $categoria->foto =$request->imagenActual;
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
                    $categoria->foto=$fileName;   
    
                    if($request->imagenActual!="defecto.png")
                    {
                        $this->delete($request->imagenActual);
                    }
                }
            }
            $categoria->save();
        }

        $datos = [
            'tabla' => 'categoria',
            'codigo_tabla' => $categoria->id,
            'transaccion' => 'modificar',
        ];
        $this->guardarBitacora($datos);
    }
    public function delete($nombre){
        $obj = File::delete('img/producto/'.$nombre);
    }
    public function desactivar(Request $request){
        $categoria = Categoria::findOrFail($request->id);
        $categoria->estado = '0';
        $categoria->save();
    }
    public function activar(Request $request){
        $categoria = Categoria::findOrFail($request->id);
        $categoria->estado = '1';
        $categoria->save();
    }
    public function selectCategoria(){  
        $obj = Categoria::select('id', 'nombre')->where('estado',1)->orderBy('categoria.id','asc')->get(); 
        return $obj;
    }
    public function cantidadRegistros(){
        $cantidad = DB::table('categoria')->count();
        $data=['nro' =>$cantidad];
        return $data;
    }
    public function index2(){
        $categoria = Categoria::select('id','nombre','foto')->where('estado','=',1)->where('id','!=',1)->whereNotIn('id', [0])->get();
        return $categoria;
    }
}
