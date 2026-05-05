<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;
use DB;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // // public function listarFormulario(){
    // //     $obj = formulario::all();
    // //     return $obj;
    // // }

    public function listarFormulario(Request $request){
        $buscar = $request->buscar;
        if ($buscar==''){
            $formulario = Formulario::orderBy('formularios.id', 'asc')
            ->get();
        }
        else{
            $formulario = Formulario::where('formularios.nombre', 'like', '%'.$buscar.'%')
            ->orderBy('formularios.id', 'asc')
            ->get();
        }
        return $formulario;
    }

    public function formulario(){

        $formulario_permiso = [];

        $formulario = Formulario::orderBy('formularios.id', 'asc')->get();
        $imagenes = $this->imagenes();
        $frm_form = $this->frm_formulario();

        foreach($formulario as $ep=>$form){

            $permiso = $this->permiso($form->id);

            foreach($imagenes as $ep=>$imagen){
                if($imagen->id == $form->id){
                    $form->imagen = $imagen->imagen;
                }
            }

            foreach($frm_form as $ep=>$frm){
                if($frm->id == $form->id){
                    $form->frm_formulario = $frm->frm;
                }
            }

            if($permiso == 1){
                if($form->id != 1){
                    $form->permiso = $permiso;
                    array_push($formulario_permiso, $form);
                }
            }
        }

        return $formulario_permiso;
    }

    public function permiso($id_formulario){
        $id_usuario = \Auth::user()->id;
        $data = DB::select('call permisoUsuario(?, ?)',array($id_usuario, $id_formulario));
        return $data[0]->form;
    }

    public function imagenes(){
        $imagenes = DB::select("SELECT id,imagen FROM imagenes");
        return $imagenes;
    }

    public function frm_formulario(){
        $imagenes = DB::select("SELECT id,frm FROM frm_formulario");
        return $imagenes;
    }

}
