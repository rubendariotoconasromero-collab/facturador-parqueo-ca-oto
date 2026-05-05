<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salon;
use App\Http\Requests\SalonRequest;

use DB;
use Illuminate\Support\Facades\File;


class SalonController extends BitacoraController
{
    public function index(Request $request){
        $id_tienda = $request->id_tienda;
        $buscar = $request->buscar;
        $criterio = $request->criterio;       
        if ($buscar==''){
            $salon = Salon::orderBy('salon.id', 'desc')
            ->where('salon.id_tienda',$id_tienda)
            ->paginate(15);
        }
        else{
            $salon = Salon::where('salon.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('salon.id', 'desc')
            ->where('salon.id_tienda',$id_tienda)
            ->paginate(15);
        }
        return $salon;
    }
    public function indexMesero(){
        $salon = Salon::select('id','nombre','foto')->whereNotIn('id', [0])->where('estado','=',1)->get();
        return $salon;
    }
    public function guardar(Request $request){
        if (Salon::where('nombre', $request->nombre)->first()){
            return ['error'=>0];
        }
        else{
            if($request->nombre==""){
                return ['error'=>1];
            }
            else{
                $id_tienda=\Auth::user()->id_tienda;
                $salon= new Salon();
                $salon->nombre=$request->nombre;
                $salon->estado=$request->estado;
                if($id_tienda == 100){
                    $salon->id_tienda=$request->id_tienda;
                }
                else{
                        $salon->id_tienda=$id_tienda;
                    }
                    if($request->foto==null){
                        $salon->foto ='salon.png';
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
                        $salon->foto=$fileName;   
                    }
                    $salon->save();
            }
        }
        $datos = [
            'tabla' => 'salon',
            'codigo_tabla' => $salon->id,
            'transaccion' => 'guardar',
        ];
        $this->guardarBitacora($datos);
    }
    public function modificar(Request $request){
        // if (Salon::where('nombre', $request->nombre)->first()){
        //     return ['error'=>0];
        // }
        // else{
            if($request->nombre==""){
                return ['error'=>0];
            }else{
                $id_tienda=\Auth::user()->id_tienda;
    
                $salon= Salon::findOrFail($request->id);
                $salon->nombre=$request->nombre;
                if($id_tienda == 100){
                    $salon->id_tienda=$request->id_tienda;
                }else{
                    $salon->id_tienda=$id_tienda;
                }
                $salon->estado=$request->estado;
                if($request->foto==null){
                    $salon->foto ='defecto.png';
                }
                else{
                    if($request->imagenActual==$request->foto){
                        $salon->foto =$request->imagenActual;
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
                        $salon->foto=$fileName;   
    
                        if($request->imagenActual!="defecto.png")
                        {
                            $this->delete($request->imagenActual);
                        }
                    }
                }
                $salon->save();
            // }
            }

        $datos = [
            'tabla' => 'salon',
            'codigo_tabla' => $salon->id,
            'transaccion' => 'modificar',
        ];
        $this->guardarBitacora($datos);
    }
    public function delete($nombre){
        $obj = File::delete('img/producto/'.$nombre);
    }
    public function desactivar(Request $request){
        $salon = Salon::findOrFail($request->id);
        $salon->estado = '0';
        $salon->save();
    }
    public function activar(Request $request){
        $salon = Salon::findOrFail($request->id);
        $salon->estado = '1';
        $salon->save();
    }
    public function selectSalon(){  
        $obj = Salon::select('id', 'nombre')->where('estado',1)
        ->orderBy('salon.id','asc')->get(); 
        return $obj;
    }
    public function selectSalonVenta(Request $request){  
        $id_tienda = $request->id_tienda;
        $obj = Salon::select('id', 'nombre','foto')
        ->where('estado',1)
        ->where('id_tienda',$id_tienda)
        ->orderBy('salon.id','asc')
        ->get(); 
        return $obj;
    }
    public function cantidadRegistros(){
        $cantidad = DB::table('salon')->count();
        $data=['nro' =>$cantidad];
        return $data;
    }
    public function index2(){
        $categoria = Salon::select('id','nombre','foto')->where('estado','=',1)->get();
        return $categoria;
    }
}
