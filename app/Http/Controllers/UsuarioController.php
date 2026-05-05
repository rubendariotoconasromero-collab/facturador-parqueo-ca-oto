<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetalleForm;
use App\Models\UsuarioPermiso;
use App\Http\Requests\UsuarioRequest;
use DB;

class UsuarioController extends BitacoraController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $nroPag = $request->pag;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $usuario = User::join('personal','users.id_personal','=','personal.id')
            ->join('grupo','users.id_grupo','=','grupo.id')
            ->select('users.id','users.name','users.matricula','users.email','users.id_personal','users.id_grupo','users.estado',
            'personal.nombre as personal','grupo.nombre as grupo','users.id_tienda')
            ->where('users.id','!=',1)
            ->where('grupo.estado','=',1)
            ->orderBy('users.id', 'desc')->paginate($nroPag);
        }
        else{
            $usuario = User::join('personal','users.id_personal','=','personal.id')
            ->join('grupo','users.id_grupo','=','grupo.id')
            ->select('users.id','users.name','users.matricula','users.email','users.id_personal','users.id_grupo','users.estado',
            'personal.nombre as personal','grupo.nombre as grupo','users.id_tienda')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->where('users.id','!=',1)
            ->where('grupo.estado','=',1)
            ->orderBy('users.id', 'desc')->paginate($nroPag);
        }
        return $usuario;
    }

    public function listarGrupoUsuario(Request $request){
        $id = $request->id;
        $obj = User::select('users.id','users.name as nombre','users.estado','users.id_grupo')
        ->where('users.id_grupo', '=', $id)
        ->orderBy('users.id', 'desc')->get();
        return $obj;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request){
        // if (User::where('matricula', $request->matricula)->first()){
        //     return ['error'=>0];
        // } else {
            if (User::where('name', $request->nombre)->first()){
                return ['error'=>1];
            } 
            else{
                /*if($request->id_tienda==0){
                    return ['error'=>2];
                }
                else{*/
                    if($request->id_personal==0){
                        return ['error'=>3];
                    }else{
                        if($request->id_grupo==0){
                            return ['error'=>4];
                        }else{
                            if($request->password==""){
                                return ['error'=>5];
                            }
                            else {
                                try{
                                    DB::beginTransaction();
                                    $user= new User();
                                    $user->name=$request->nombre;
                                    $user->matricula=$request->matricula;
                                    $user->email=$request->email;
                                    $user->password=bcrypt($request->password);
                                    $user->id_grupo=$request->id_grupo;
                                    $user->id_personal=$request->id_personal;
                                    $user->id_tienda=2;// por defecto tienda 2
                                    $user->estado=$request->estado;
                                    $user->save();
                
                                    $detalle_permiso = $request->detalle;
                                    foreach($detalle_permiso as $ep=>$det){
                                        $obj = new UsuarioPermiso();
                                        $obj->id_usuario = $user->id;
                                        $obj->id_permiso = $det['id'];
                                        $obj->save();
                                    }
                
                                    $datos = [
                                        'tabla' => 'users',
                                        'codigo_tabla' => $user->id,
                                        'transaccion' => 'guardar',
                                    ];
                                    $this->guardarBitacora($datos);
                
                                    DB::commit();
                                } catch (Exception $e){
                                    DB::rollBack();
                                }
                            }
                        }
                    }
                //}
            }
        //}
    }

    public function modificar(UsuarioRequest $request){
        if (User::where('name', $request->nombre)
            ->where('id','!=', $request->id)
            ->first()){
            return ['error'=>1];
        } else {
            try{
                DB::beginTransaction();
                $user= User::findOrFail($request->id);

                $user->name=$request->nombre;
                $user->matricula=$request->matricula;
                $user->email=$request->email;
                $user->password=bcrypt($request->password);
                $user->id_grupo=$request->id_grupo;
                $user->id_personal=$request->id_personal;
                $user->id_tienda=2;// por defecto tienda 2
                $user->estado=$request->estado;
                $user->save();

                // if($request->id_grupo != $request->id_grupo_cambio){
                //     $obj = UsuarioPermiso::where('usuario_permisos.id_usuario','=',$request->id);
                //     $obj->delete();
                // }

                $formularios=DetalleForm::join('permiso_forms', 'detalle_forms.id_permiso_form', '=', 'permiso_forms.id')
                ->join('formularios', 'detalle_forms.id_formulario', '=', 'formularios.id')
                ->join('grupo', 'permiso_forms.id_grupo', '=', 'grupo.id')
                ->select('formularios.nombre', 'formularios.id')
                ->where('grupo.id', $user->id_grupo)->get();

                 UsuarioPermiso::select('id_usuario', 'id_permiso')
                ->where('id_usuario', $user->id)
                ->delete();
                
    
                
                foreach($formularios as $ep1=>$formulario){
                    $usuario_permiso = new UsuarioPermiso();
                    $usuario_permiso->id_usuario=$user->id;
                    $usuario_permiso->id_permiso=$formulario['id'];
                    $usuario_permiso->save();
                } 

                $datos = [
                    'tabla' => 'users',
                    'codigo_tabla' => $user->id,
                    'transaccion' => 'modificar',
                ];
                $this->guardarBitacora($datos);

                DB::commit();
            } catch (Exception $e){
                DB::rollBack();
            }
        }
    }

    public function desactivar(Request $request){
        $obj = User::findOrFail($request->id);
        $obj->estado = '0';
        $obj->save();

        $datos = [
            'tabla' => 'usuario',
            'codigo_tabla' => $request->id,
            'transaccion' => 'desactivar',
        ];
        $this->guardarBitacora($datos);
    }

    public function activar(Request $request){
        $obj = User::findOrFail($request->id);
        $obj->estado = '1';
        $obj->save();

        $datos = [
            'tabla' => 'usuario',
            'codigo_tabla' => $request->id,
            'transaccion' => 'activar',
        ];
        $this->guardarBitacora($datos);
    }

    public function maximoId(){
        $maximoID = \DB::table('users')->where('id', \DB::raw("(select max(`id`) from users)"))->get();
        return $maximoID;

    }

    public function usuarioId(){
        $id = \Auth::user()->id;
        $objeto=DB::select("SELECT u.id, u.name, p.nombre as personal FROM users as u , personal as p WHERE u.id_personal = p.id and u.id = $id");
       
        $objeto1=(object) $objeto[0];
        return $objeto1;
    }
    public function usuarioNombre(){
        $id = \Auth::user()->id;
        $objeto=DB::select("SELECT users.id, personal.porcentaje, users.name as usuario FROM users INNER JOIN personal on users.id_personal=personal.id  WHERE  users.id = $id");

        /*$a=DB::select("SELECT Sum(venta.total) as total_monto_venta
        FROM  venta INNER JOIN users
        on venta.id_usuario=users.id 
        WHERE venta.id_usuario='$id_usuario' and day(venta.fecha)=day('$fechaActual') and venta.estado!='Anulado'
        GROUP BY venta.total, venta.id");*/


        $objeto1=(object) $objeto[0];
        return $objeto1;
    }

    public function listar(Request $request){
        $nroPag = $request->pag;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $obj = User::join('grupo','users.id_grupo','=','grupo.id')
            ->join('cargo','users.id_cargo','=','cargo.id')
            ->select('users.id','users.name','users.password','users.email','users.id_grupo','users.estado','users.id_cargo','grupo.nombre as grupo')
            ->orderBy('users.id', 'desc')->paginate($nroPag);
        }
        else{
            $obj = User::join('grupo','users.id_grupo','=','grupo.id')
            ->join('cargo','users.id_cargo','=','cargo.id')
            ->select('users.id','users.name','users.password','users.email','users.id_grupo','users.estado','users.id_cargo','grupo.nombre as grupo')
            ->where('users.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('users.id', 'desc')->paginate($nroPag);
        }
        return $obj;
    }
    public function montoUsuario(){
        $venta=User::select(DB::raw('COUNT(users.id) as usuario'))->where('users.id_grupo','=','1')->where('users.estado','=','1')->where('users.id_personal','>','1')->get();
        //dd($venta);
        return $venta;
    }
    public function montoCajeros(){
        $venta=User::select(DB::raw('COUNT(users.id) as usuario'))->where('users.id_grupo','=','2')->where('users.estado','=','1')->get();
        //dd($venta);
        return $venta;
    }

    public function PersonalId(){
        $id = \Auth::user()->id_personal;
        $objeto=DB::select("SELECT u.id,u.id_personal, p.nombre as personal FROM users as u , personal as p WHERE u.id_personal = p.id and u.id_personal =$id");

        $objeto1=(object) $objeto[0];
        return $objeto1;
    }
    public function selectPersonalU(){
        $obj = User::join('grupo','users.id_grupo','=','grupo.id')
        ->join('personal','users.id_personal','=','personal.id')
        ->select('personal.id', 'personal.nombre')
        ->where('personal.estado', 1)
        ->where('personal.id','!=',1)
        ->where('grupo.id','=',3)
        ->orderBy('personal.id','desc')->get();
        return $obj;
    }


//     'SELECT personal.nombre as personal
//         FROM users,grupo,personal
// WHERE users.id_grupo=grupo.id and users.id_personal=personal.id and grupo.id=3'

function permiso(Request $request){
    $id_formulario = $request->id;
    $id_usuario = \Auth::user()->id;
    $data = DB::select('call permisoUsuario(?, ?)',array($id_usuario, $id_formulario));
    return $data[0]->form;
}
public function usuario(){
    $id = \Auth::user()->id;
    $objeto=DB::table('users')->select('users.name','users.id','users.id_personal','users.id_grupo','users.id_tienda','users.estado')->where('users.id','=',$id)->get();

    $objeto1=(object) $objeto[0];
    return $objeto1;

    //return $objeto;
}
public function selectUsuario(){  
    $obj = User::select('id', 'name as nombre')->where('estado',1)->where('id_grupo','=',1)->orderBy('users.id','asc')->get(); 
    // $obj = User::select('id', 'name as nombre')->where('estado',1)->where('id','!=',1)->orderBy('users.id','asc')->get(); 
    return $obj;
}
public function selectMesero(){  
    $obj = User::select('id', 'name as nombre')->where('estado',1)->where('id_grupo','!=',1)->orderBy('users.id','asc')->get(); 
    // $obj = User::select('id', 'name as nombre')->where('estado',1)->where('id','!=',1)->orderBy('users.id','asc')->get(); 
    return $obj;
}

public function capturarNombre(){
    $nombre=gethostbyaddr($_SERVER['REMOTE_ADDR']);
    echo $nombre;
    return 0;
}


}
