<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteRelacionador;
use DB;


class ClienteRelacionadorController extends BitacoraController
{
    public function cliente(Request $request){
        
        $buscar = $request->filtro;
        $data = ClienteRelacionador::join('personal','cliente_relacionador.id_personal','=','personal.id')
        ->select('cliente_relacionador.id as Id_Cliente','cliente_relacionador.id_personal as Id_Personal','cliente_relacionador.nombre as Cliente','personal.Nombre','cliente_relacionador.fecha as Fecha','cliente_relacionador.cantidad as Cantidad','cliente_relacionador.estado as Estado','cliente_relacionador.asistencia as Asistencia')
        ->where('cliente_relacionador.estado','=',0)
        ->where('cliente_relacionador.eliminado','=',0)
        ->where('cliente_relacionador.nombre', 'like', '%'.$buscar.'%')
        ->get();     
        return $data;
    }
    public function index(Request $request){
        
        $buscar = $request->filtro;
        $data = ClienteRelacionador::join('personal','cliente_relacionador.id_personal','=','personal.id')
        ->select('cliente_relacionador.id','cliente_relacionador.id_personal','cliente_relacionador.nombre as Cliente'
        ,'personal.nombre','cliente_relacionador.fecha','cliente_relacionador.cantidad','cliente_relacionador.estado'
        ,'cliente_relacionador.asistencia','cliente_relacionador.eliminado')
         ->where('cliente_relacionador.estado','=',0)
        // ->where('cliente_relacionador.eliminado','=',0)
        ->where('cliente_relacionador.nombre', 'like', '%'.$buscar.'%')
        ->get();     
        return $data;
    }
    public function index_relacionador(Request $request){
        
        $buscar = $request->filtro;
        $id_personal = $request->id_personal;  
        // dd($id_personal);
        $data = ClienteRelacionador::join('personal','cliente_relacionador.id_personal','=','personal.id')
        ->select('cliente_relacionador.id','cliente_relacionador.id_personal','cliente_relacionador.nombre as Cliente'
        ,'personal.nombre','cliente_relacionador.fecha','cliente_relacionador.cantidad','cliente_relacionador.estado'
        ,'cliente_relacionador.asistencia','cliente_relacionador.eliminado')
        ->where('cliente_relacionador.estado','=',0)
        ->where('cliente_relacionador.id_personal','=',$id_personal)
        // ->where('cliente_relacionador.eliminado','=',0)
        ->where('cliente_relacionador.nombre', 'like', '%'.$buscar.'%')
        ->get();     
        return $data;
    }
    public function guardar(Request $request){

        $cliente_relacionador= new ClienteRelacionador();
        $cliente_relacionador->nombre=$request->nombre;
        $cliente_relacionador->fecha=$request->fecha;
        $cliente_relacionador->cantidad=$request->cantidad;
        $cliente_relacionador->asistencia=$request->asistencia;
        $cliente_relacionador->estado=$request->estado;
        $cliente_relacionador->eliminado=$request->eliminado;
        $cliente_relacionador->id_personal=$request->id_personal;
        $cliente_relacionador->save();
        
        $datos = [
            'tabla' => 'cliente relacionador',
            'codigo_tabla' => $cliente_relacionador->id,
            'transaccion' => 'guardar',
        ];
        $this->guardarBitacora($datos);
    }
    public function modificar(Request $request){

            $obj= ClienteRelacionador::findOrFail($request->id);
            $obj->nombre=$request->nombre;
            $obj->fecha=$request->fecha;
            $obj->cantidad=$request->cantidad;
            $obj->id_personal=$request->id_personal;
            $obj->save();
     
                $datos = [
                    'tabla' => 'cliente relacionador',
                    'codigo_tabla' => $obj->id,
                    'transaccion' => 'modificar',
                ];
                $this->guardarBitacora($datos);

    }
    public function desactivar(Request $request){
        $cliente = ClienteRelacionador::findOrFail($request->id);
        $cliente->eliminado = '0';
        $cliente->save();
    }
    public function activar(Request $request){
        $categoria = ClienteRelacionador::findOrFail($request->id);
        $categoria->eliminado = '1';
        $categoria->save();
    }
    public function ventaId(Request $request){
        $id_usuario = $request->id_usuario;
        //dd($id_usuario);
        $objeto=DB::select("SELECT sum(total) as total from VentaSit where Id_Usuario = $id_usuario and FormaPago='Contado'and Estado=0 and Eliminado=0" );
        $objeto1=(object) $objeto[0];
        return $objeto1;

    }
    public function contador(Request $request){
        $id_usuario = $request->id_usuario;
        //dd($id_usuario);
        $objeto=DB::select("SELECT COUNT(id) as registro from cliente_relacionador where estado=0 AND eliminado=0" );
        $objeto1=(object) $objeto[0];
        return $objeto1;

    }
    public function contador2(Request $request){
        $id_personal = $request->id_personal;
        //dd($id_personal);
        $objeto=DB::select("SELECT COUNT(id) as registro from cliente_relacionador where estado=0 AND eliminado=0 AND id_personal=$id_personal" );
        $objeto1=(object) $objeto[0];
        return $objeto1;

    }
    public function Cantidad(Request $request){
        $id = $request->Id_Cliente;
        //dd($id);
        $cantidad = $request->Cantidad;
        //dd($cantidad);
        $correlativo = ClienteRelacionador::select('cliente_relacionador.cantidad')
        ->where('cliente_relacionador.id','=',$id)
        ->first();  

        $correlativo2 = (object)json_decode(json_encode($correlativo),true);
        //dd($correlativo2);
        $total = ((int)$correlativo2->cantidad)+$cantidad;
        // $affected = DB::table('ClienteRelacionador')
        // ->where('Id_Cliente', $id)
        // ->update(['Asistencia' => '1']);
        
        $affected = DB::table('cliente_relacionador')
        ->where('id', $id)
        ->update(['cantidad' => $total]);
        
    }
    public function Cantidad1(Request $request){
        $id = $request->Id_Cliente;
        $cantidad = $request->Cantidad;
      
        $correlativo = ClienteRelacionador::select('cliente_relacionador.cantidad')
        ->where('cliente_relacionador.id','=',$id)
        ->first();  

        $correlativo2 = (object)json_decode(json_encode($correlativo),true);
        $total = ((int)$correlativo2->cantidad)-$cantidad;

        $affected = DB::table('cliente_relacionador')
        ->where('id', $id)
        ->update(['cantidad' => $total]);
        
    }
    public function CantidadCliente(Request $request){
        $objeto=DB::select("SELECT sum(cantidad) as total from cliente_relacionador where estado=0 and eliminado=0" );
        $objeto1=(object) $objeto[0];
        return $objeto1;

    }
    public function Mesa(Request $request){
        $id = $request->Id_Cliente;
 
        $affected = DB::table('cliente_relacionador')
        ->where('id', $id)
        ->update(['asistencia' => 1]);
        
    }
    public function Mesa2(Request $request){
        $id = $request->Id_Cliente;
 
        $affected = DB::table('cliente_relacionador')
        ->where('id', $id)
        ->update(['asistencia' => 0]);
        
    }
    
    
}
