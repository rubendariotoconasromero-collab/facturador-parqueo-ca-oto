<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;
use DB;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

class ClienteController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;       
        if ($buscar==''){
            $cliente = Cliente::orderBy('cliente.id', 'desc')->where('cliente.id','!=',1)->paginate(15);
        }
        else{
            $cliente = Cliente::where('cliente.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('cliente.id', 'desc')->where('cliente.id','!=',1)->paginate(15);
        }
        return $cliente;
    }

    public function index_pago(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_tienda = $request->id_tienda;
        //$tipo_producto = $request->tipo_producto;
        $id_usuario = \Auth::user()->id;
        if($buscar==''){
            $obj=DB::select("SELECT c.id,c.nombre as cliente, c.matricula, c.telefono,SUM(g.monto) as monto, SUM(g.saldo) as saldo_cliente, v.id_tienda, v.tipo_venta 
            FROM cliente c, pago g, venta v, users u
            where v.id_cliente=c.id and g.id_venta=v.id AND v.estado!='Anulado' AND g.id_tipo_pago=2 AND v.id_tienda = '$id_tienda' 
            AND v.id_usuario=u.id  GROUP by c.nombre,c.id,c.telefono");   
        }
        else{
            $obj=DB::select("SELECT c.id,c.nombre as cliente, c.matricula, c.telefono,SUM(g.monto) as monto, SUM(g.saldo) as saldo_cliente, v.id_tienda, v.tipo_venta 
            FROM cliente c, pago g, venta v, users u
            where v.id_cliente=c.id and g.id_venta=v.id AND v.estado!='Anulado' AND g.id_tipo_pago=2 AND v.id_tienda = '$id_tienda' 
            AND v.id_usuario=u.id  and c.nombre LIKE '%$buscar%'
            GROUP by c.nombre,c.id,c.telefono");
        }
        return $obj;
    }

    public function guardar(ClienteRequest $request){
        if (Cliente::where('nombre', $request->nombre)->first()){
            return ['error'=>0];
        }else{
            /*if($request->descuento>100){
                return ['error'=>1];
            }
            else{*/
                $cliente= new Cliente();
                $cliente->nombre=$request->nombre;
                $cliente->matricula = $request->matricula == '' ? '0' : $request->matricula;
                $cliente->telefono = $request->telefono == '' ? '0' : $request->telefono;
                $cliente->direccion=$request->direccion;
                $cliente->descripcion=$request->descripcion;
                //$cliente->descuento=empty($request->descuento)?0:$request->descuento;
                $cliente->email=$request->email;
                $cliente->estado=$request->estado;
                $cliente->save();
            //}  
        }
            $datos = [
                'tabla' => 'cliente',
                'codigo_tabla' => $cliente->id,
                'transaccion' => 'guardar',
            ];
            $this->guardarBitacora($datos);
              
    }

    public function modificar(Request $request){

        if($request->nombre==""){
            return ['error'=>2];
        }
        else{
            /*if($request->descuento>100){
                return ['error'=>1];
            }else{*/
                if (Cliente::where('nombre', $request->nombre)->first()){
                    $client = Cliente::select('nombre', 'matricula')->where('nombre', $request->nombre)->first();
                    if($client->matricula!=$request->matricula){
                        return ['error'=>0];
                    }else{
                        $cliente= Cliente::findOrFail($request->id);
                        $cliente->nombre=$request->nombre;
                        $cliente->matricula=$request->matricula;
                        $cliente->telefono=$request->telefono;
                        $cliente->direccion=$request->direccion;
                        $cliente->descripcion=$request->descripcion;
                        //$cliente->descuento=empty($request->descuento)?0:$request->descuento;
                        $cliente->email=$request->email;
                        $cliente->estado=$request->estado;
                        $cliente->save();
                    }
                }else{
                    
                        
                    $cliente= Cliente::findOrFail($request->id);
                    $cliente->nombre=$request->nombre;
                    $cliente->matricula=$request->matricula;
                    $cliente->telefono=$request->telefono;
                    $cliente->direccion=$request->direccion;
                    $cliente->descripcion=$request->descripcion;
                    //$cliente->descuento=empty($request->descuento)?0:$request->descuento;
                    $cliente->email=$request->email;
                    $cliente->estado=$request->estado;
                    $cliente->save();
                        
                    
                    
                }
            //}
        }

        $datos = [
            'tabla' => 'cliente',
            'codigo_tabla' => $cliente->id,
            'transaccion' => 'modificar',
        ];
        $this->guardarBitacora($datos);
    }

    public function desactivar(Request $request){
        $cliente = Cliente::findOrFail($request->id);
        $cliente->estado = '0';
        $cliente->save();
    }

    public function activar(Request $request){
        $cliente = Cliente::findOrFail($request->id);
        $cliente->estado = '1';
        $cliente->save();
    }
    //seleccionar cliente por id
    public function selectCliente(){  
        $obj = Cliente::select('id', 'nombre', 'descuento','direccion')->orderBy('cliente.id','desc')->get(); 
        return $obj;
    }
    public function listarSinPaginate(Request $request){
        $buscar = $request->buscar;     
        if ($buscar==''){

            $cliente = Cliente::orderBy('cliente.id', 'desc')
            ->where('cliente.estado',1)->get();
        }
        else{
            $cliente = Cliente::orderBy('cliente.id', 'desc')
            ->where('cliente.estado',1)
            ->where('cliente.nombre' , 'like', '%'.$buscar.'%')->get();
        }
        return $cliente;
    }

    public function listarClienteId(Request $request){
        $id = $request->id_cliente;     
        $cliente = Cliente::orderBy('cliente.id', 'desc')->where('cliente.id' , 'like', '%'.$id.'%')->get();
        return $cliente;
    }

    public function cantidadRegistros(){
        $cantidad = DB::table('cliente')->where('cliente.id','!=',1)->count();

        $data=['nro' =>$cantidad];
        return $data;
    }

    public function pdfListarClientes(){
        $cliente= cliente::select('cliente.id','cliente.nombre','cliente.matricula','cliente.telefono',
            'cliente.descripcion','cliente.direccion')
            ->orderBy('cliente.nombre','desc')->get();
        $cont=cliente::count();
        $pdf = \PDF::loadView('pdf.venta.venta', ['clientes'=>$cliente, 'cont'=>$cont]);
        return $pdf->stream('clientes.pdf');
    }
    public function direccion(Request $request){
        $buscar = $request->buscar;
        $direccion=DB::select("SELECT direccion FROM cliente WHERE id=$buscar");
        return $direccion;
    }
    public function cliente_id(){
        $cliente_id = Cliente::select(DB::raw('MAX(id) as id'))->orderBy('cliente.id', 'desc')->first();
        return ['id_cliente'=>$cliente_id];
    }

    // public function prueba(Request $request)
    // {
        
    //     $id = $request->id;     
    //     $sale=Cliente::where('cliente.id',$id)
    //     ->get();

    //     $json = $sale->toJson();
    //     $cliente1 = base64_encode(gzdeflate($json));
    //     // codificas la data en base64
    //     $dataPrint = base64_encode($json);

    //     window.open("print://" + dataPrint);

    //     //ejecutalo haber
    // }

    public function prueba(Request $request)
    {
        $id = $request->id;
        $sale=Cliente::where('cliente.id',$id)
        ->get();
        $json = $sale->toJson();
        $dataPrint = base64_encode(gzdeflate($json));

        window.open("print://" + dataPrint);
     
    }   
}
