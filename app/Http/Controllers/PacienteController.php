<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Animal;
use App\Models\Cliente;
use App\Http\Requests\PacienteRequest;
use App\Models\Control;
use DB;
use DateTime;

class PacienteController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Paciente::join('cliente','paciente.id_cliente','=','cliente.id')
            ->join('animal','paciente.id_animal','=','animal.id')
            ->select('paciente.id','paciente.nombre as mascota','paciente.especie','paciente.edad','paciente.color','paciente.raza','paciente.sexo','paciente.id_cliente','paciente.id_animal'
            ,'paciente.peso','paciente.cirugias','paciente.enfermedades','animal.nombre as animal','cliente.nombre as cliente','paciente.estado')
            //->where('animal.estado', 1)
            ->orderBy('paciente.id','desc')->paginate(15);
        }
        else{
            $obj= Paciente::join('cliente','paciente.id_cliente','=','cliente.id')
            ->join('animal','paciente.id_animal','=','animal.id')
            ->select('paciente.id','paciente.nombre as mascota','paciente.especie','paciente.edad','paciente.color','paciente.raza','paciente.sexo','paciente.id_cliente','paciente.id_animal'
            ,'paciente.peso','paciente.cirugias','paciente.enfermedades','animal.nombre as animal','cliente.nombre as cliente','paciente.estado')
            //->where('animal.estado', 1)
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('paciente.id','desc')->paginate(15);            
        }
        return $obj;
    }
    public function guardar(PacienteRequest $request){
        try{
            if (Paciente::where('nombre', $request->nombre)->first()){
                return ['error'=>0];
            }
            else{

                DB::beginTransaction();
                $obj = new Paciente();
                $obj->nombre=$request->nombre;
                $obj->especie=$request->especie;
                $obj->edad=$request->edad;
                $obj->color=$request->color;
                $obj->raza=$request->raza;
                $obj->sexo=$request->sexo;
                $obj->peso=$request->peso;
                $obj->cirugias=$request->cirugias;
                $obj->enfermedades=$request->enfermedades;
                $obj->estado=$request->estado;
                $obj->id_cliente=$request->id_cliente;
                $obj->id_animal=$request->id_animal;
                $obj->save();
            }
            $datos = [
                'tabla' => 'paciente',
                'codigo_tabla' => $obj->id,
                'transaccion' => 'guardar',
            ];
            $this->guardarBitacora($datos);

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function modificar(PacienteRequest $request){
        if (Paciente::where('nombre', $request->nombre)
            ->where('id_cliente', $request->id_cliente)
            ->where('id','!=', $request->id)
            ->first()){
            return ['error'=>0];
        } else {
            //dd($request->id);
            $obj= Paciente::findOrFail($request->id);
            $obj->nombre=$request->nombre;
            $obj->especie=$request->especie;
            $obj->edad=$request->edad;
            $obj->color=$request->color;
            $obj->raza=$request->raza;
            $obj->sexo=$request->sexo;
            $obj->peso=$request->peso;
            $obj->cirugias=$request->cirugias;
            $obj->enfermedades=$request->enfermedades;
            $obj->estado=$request->estado;
            $obj->id_cliente=$request->id_cliente;
            $obj->id_animal=$request->id_animal;
            $obj->save();


            $datos = [
                'tabla' => 'paciente',
                'codigo_tabla' => $obj->id,
                'transaccion' => 'modificar',
            ];
            $this->guardarBitacora($datos);

            
        }
    }
    public function desactivar(Request $request){
        $obj = Paciente::findOrFail($request->id);
        $obj->estado = '0';
        $obj->save();

        $datos = [
            'tabla' => 'paciente',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'desactivar',
        ];
        $this->guardarBitacora($datos);
    }
    public function activar(Request $request){
        $obj = Paciente::findOrFail($request->id);
        $obj->estado = '1';
        $obj->save();

        $datos = [
            'tabla' => 'paciente',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'activar',
        ];
        $this->guardarBitacora($datos);
    }
    public function cantidadRegistros(){
        $cantidad = DB::table('paciente')->count();
        $data=['nro' =>$cantidad];
        return $data;
    }
    public function selectPaciente(){  
        $obj = Paciente::join('animal','paciente.id_animal','=','animal.id')
        ->select('paciente.id', 'paciente.nombre', 'paciente.id_animal','paciente.edad','animal.nombre as animal','paciente.id_cliente')->orderBy('paciente.id','desc')->get(); 
        return $obj;
    }
}
