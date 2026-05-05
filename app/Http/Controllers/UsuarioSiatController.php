<?php

namespace App\Http\Controllers;
use App\Modules\Siat\Settings;
use Illuminate\Http\Request;
use DB;

class UsuarioSiatController extends Controller
{
    //
    public function guardarUsuario(Request $request){
        //dd($request->codigo_sistema);
        if(DB::table('users')->where('users.codigo_sistema', $request->codigo_sistema)->count()>0){
            //dd(DB::table('users')->where('users.codigo_sistema', $request->codigo_sistema)->count());
            return ['error'=>0];
        }
        DB::beginTransaction();
        try{
            if($request->accion==0){
                DB::table('users')->insert([
                    'codigo_sistema'=>$request->codigo_sistema,
                    'name'=>$request->nombre,
                    'email'=>$request->correo,
                    'password'=>bcrypt($request->password),
                    'rol'=>$request->rol,
                ]);
            }else{
                DB::table('users')->where('users.id', $request->id_usuario)->update([
                    'codigo_sistema'=>$request->codigo_sistema,
                    'name'=>$request->nombre,
                    'email'=>$request->correo,
                    'password'=>bcrypt($request->password),
                    'rol'=>$request->rol,
                ]);
            }
            DB::commit();
        }catch(Exception $e){

            DB::rollback();
        }
    }

    public function buscarUsuario(Request $request){
        $buscar = $request->buscar;
        $usuarios = DB::table('users')->where('users.name', 'like', '%'.$buscar.'%')->get();
        return $usuarios;
    }

    public function activar(Request $request){
        DB::beginTransaction();
        try{
            
                DB::table('users')->where('users.id', $request->id_usuario)->update([
                    'estado'=> 1
                ]);
          
            DB::commit();
        }catch(Exception $e){

            DB::rollback();
        }
    }

    public function desactivar(Request $request){
        DB::beginTransaction();
        try{
            
                DB::table('users')->where('users.id', $request->id_usuario)->update([
                    'estado'=> 0
                ]);
          
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }

   
}
