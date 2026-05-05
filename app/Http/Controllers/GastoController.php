<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gasto;
use App\Http\Requests\GastoRequest;
use App\Models\ArqueoCaja;
use DB;

class GastoController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_tienda = $request->id_tienda;
        $id_usuario=\Auth::user()->id;
        $id_tienda_condicion=\Auth::user()->id_tienda;
        if($id_tienda_condicion==100){

            if($buscar==''){
                $obj= Gasto::join('motivo_gasto','gasto.id_motivo_gasto','=','motivo_gasto.id')
                ->join('forma_pago','gasto.id_forma_pago','=','forma_pago.id')
                ->join('users','gasto.id_usuario','=','users.id')
                ->select('gasto.id','gasto.fecha','gasto.monto','gasto.descripcion','gasto.id_motivo_gasto',
                'motivo_gasto.nombre as motivo','gasto.id_forma_pago','gasto.efectivo','gasto.deposito','forma_pago.nombre as forma','users.name as usuario1','gasto.id_tienda')
                ->where('gasto.id_tienda',$id_tienda)
                ->orderBy('gasto.id','desc')->paginate(15);
            }
            else{
                $obj= Gasto::join('motivo_gasto','gasto.id_motivo_gasto','=','motivo_gasto.id')
                ->join('forma_pago','gasto.id_forma_pago','=','forma_pago.id')
                ->join('users','gasto.id_usuario','=','users.id')
                ->select('gasto.id','gasto.fecha','gasto.monto','gasto.descripcion','gasto.id_motivo_gasto',
                'motivo_gasto.nombre as motivo','gasto.id_forma_pago','gasto.efectivo','gasto.deposito','forma_pago.nombre as forma','users.name as usuario1','gasto.id_tienda')
                ->where($criterio, 'like', '%'.$buscar.'%')
                ->where('gasto.id_tienda',$id_tienda)
                ->orderBy('gasto.id','desc')->paginate(15);            
            }
        }else
        {
            if($buscar==''){
                $obj= Gasto::join('motivo_gasto','gasto.id_motivo_gasto','=','motivo_gasto.id')
                ->join('forma_pago','gasto.id_forma_pago','=','forma_pago.id')
                ->select('gasto.id','gasto.fecha','gasto.monto','gasto.descripcion','gasto.id_motivo_gasto',
                'motivo_gasto.nombre as motivo','gasto.id_forma_pago','gasto.efectivo','gasto.deposito','forma_pago.nombre as forma')
                ->where('gasto.id_usuario',$id_usuario)
                ->where('gasto.id_tienda',$id_tienda)
                ->orderBy('gasto.id','desc')->paginate(15);
            }
            else{
                $obj= Gasto::join('motivo_gasto','gasto.id_motivo_gasto','=','motivo_gasto.id')
                ->join('forma_pago','gasto.id_forma_pago','=','forma_pago.id')
                ->select('gasto.id','gasto.fecha','gasto.monto','gasto.descripcion','gasto.id_motivo_gasto',
                'motivo_gasto.nombre as motivo','gasto.id_forma_pago','gasto.efectivo','gasto.deposito','forma_pago.nombre as forma')
                ->where($criterio, 'like', '%'.$buscar.'%')
                ->where('gasto.id_usuario',$id_usuario)
                ->where('gasto.id_tienda',$id_tienda)
                ->orderBy('gasto.id','desc')->paginate(15);            
            }
        }
        return $obj;
    }

    private function actualizarCaja($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->increment('arqueo_caja.gastos', $monto);
    }
    private function actualizarCajaDeposito($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->increment('arqueo_caja.gastos_deposito', $monto);
    }

    private function descontarCaja($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->decrement('arqueo_caja.gastos', $monto);
    }
    private function descontarCajaDeposito($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->decrement('arqueo_caja.gastos_deposito', $monto);
    }

    public function guardar(GastoRequest $request){
        try{
            DB::beginTransaction();
            $monto = $request->monto;
            $efectivo = $request->efectivo;
            $deposito = $request->deposito;
            $id=\Auth::user()->id;
            $id_tienda=\Auth::user()->id_tienda;

            $obj = new Gasto();
            $obj->fecha=$request->fecha;
            $obj->monto=$request->monto;
            $obj->descripcion=$request->descripcion;
            $obj->id_motivo_gasto=$request->id_motivo_gasto;
            $obj->id_forma_pago=$request->id_forma_pago;
            if($id_tienda == 100){
                $obj->id_tienda=$request->id_tienda;
            }else
            {
                $obj->id_tienda=$id_tienda;
            }
            if($request->id_forma_pago == 6){
                $obj->efectivo=$request->efectivo;
                $obj->deposito=$request->deposito;
            }else if($request->id_forma_pago == 2)
            {
                $obj->efectivo =$request->monto;
                $obj->deposito = $request->deposito == '' ? '0' : $request->deposito;
    
            }else if($request->id_forma_pago == 3)
            {
                $obj->efectivo = $request->efectivo == '' ? '0' : $request->efectivo;
                $obj->deposito =$request->monto;
                
            }else if($request->id_forma_pago == 4)
            {
                $obj->efectivo = $request->efectivo == '' ? '0' : $request->efectivo;
                $obj->deposito =$request->monto;
    
            }else if($request->id_forma_pago == 5)
            {
                $obj->efectivo = $request->efectivo == '' ? '0' : $request->efectivo;
                $obj->deposito =$request->monto;
            }else
            {
                //
            }
            $obj->id_usuario=$id;
            $obj->save();
            
            $datos = [
                'tabla' => 'gasto',
                'codigo_tabla' => $obj->id,
                'transaccion' => 'guardar',
            ];
            $this->guardarBitacora($datos);
            if($request->id_forma_pago == 2){
                $this->actualizarCaja($monto,$id);
            }
            if($request->id_forma_pago == 3 || $request->id_forma_pago == 4 || $request->id_forma_pago == 5){
                $this->actualizarCajaDeposito($monto,$id);
            }
            if($request->id_forma_pago == 6)
            {
                $this->actualizarCaja($efectivo,$id);
                $this->actualizarCajaDeposito($deposito,$id);
            }

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function modificar(GastoRequest $request){
        $id_usuario = \Auth::user()->id;
        $id_tienda=\Auth::user()->id_tienda;

        $monto = $request->monto;
        $efectivo = $request->efectivo;
        $deposito = $request->deposito;
        $monto_aux = $request->monto_aux;
        $efectivo_aux = $request->efectivo_aux;
        $deposito_aux = $request->deposito_aux;
        $forma_pago = $request->id_forma_pago_aux;
        //dd($forma_pago);
        //dd($request->id_forma_pago);
        //dd($monto_aux,$efectivo_aux,$monto,$efectivo);
        $saldo = 0;
        $obj= Gasto::findOrFail($request->id);
        $obj->fecha=$request->fecha;
        $obj->monto=$request->monto;
        $obj->descripcion=$request->descripcion;
        $obj->id_motivo_gasto=$request->id_motivo_gasto;
        $obj->id_forma_pago=$request->id_forma_pago;
        if($id_tienda == 100){
            $obj->id_tienda=$request->id_tienda;
        }else
        {
            $obj->id_tienda=$id_tienda;
        }
        //dd($request->id_motivo_gasto);
        if($request->id_forma_pago == 6){
            $obj->efectivo=$request->efectivo;
            $obj->deposito=$request->deposito;
        }else if($request->id_forma_pago == 2)
        {
            $obj->efectivo =$request->monto;
            $obj->deposito = $request->deposito == '' ? '0' : $request->deposito;

        }else if($request->id_forma_pago == 3)
        {
            $obj->efectivo = $request->efectivo == '' ? '0' : $request->efectivo;
            $obj->deposito =$request->monto;
            
        }else if($request->id_forma_pago == 4)
        {
            $obj->efectivo = $request->efectivo == '' ? '0' : $request->efectivo;
            $obj->deposito =$request->monto;

        }else if($request->id_forma_pago == 5)
        {
            $obj->efectivo = $request->efectivo == '' ? '0' : $request->efectivo;
            $obj->deposito =$request->monto;
        }else
        {
            //
        }
        $obj->id_usuario=$id_usuario;
        $obj->save();


        $forma= $request->id_forma_pago;
        if($forma_pago == $forma){
            if($forma_pago == 2){
                $this->descontarCaja($monto_aux,$id_usuario);
                $this->actualizarCaja($monto,$id_usuario);
            }
            else
            {   
                if($forma == 3 || $forma == 4 || $forma == 5){
                    $this->descontarCajaDeposito($monto_aux,$id_usuario);
                    $this->actualizarCajaDeposito($monto,$id_usuario);
                }else
                {
                    // if($forma == 6){
                    //     $this->descontarCajaDeposito($deposito_aux,$id_usuario);
                    //     $this->descontarCaja($efectivo_aux,$id_usuario);
                        
                    //     $this->actualizarCajaDeposito($deposito,$id_usuario);
                    //     $this->actualizarCaja($efectivo,$id_usuario);
                    // }
                }
            }

                
       

        }else{
            if($forma == 2){
                $this->actualizarCaja($monto,$id_usuario);
                $this->descontarCajaDeposito($monto_aux,$id_usuario);
            }
            else
            {   
                if($forma == 2){
                $this->descontarCaja($monto_aux,$id_usuario);
                }
                if($forma_pago == 2){
                    if($forma == 3 || $forma == 4 || $forma == 5){
                        $this->descontarCaja($monto_aux,$id_usuario);
                        $this->actualizarCajaDeposito($monto,$id_usuario);
                    }else
                    {
                        //
                    }
                }
                if($forma_pago == 3){
                    if($forma == 4 || $forma == 5){
                        $this->descontarCajaDeposito($monto_aux,$id_usuario);
                        $this->actualizarCajaDeposito($monto,$id_usuario);
                    }else
                    {
                        //
                    }
                }
                if($forma_pago == 4){
                    if($forma == 3 || $forma == 5){
                        $this->descontarCajaDeposito($monto_aux,$id_usuario);
                        $this->actualizarCajaDeposito($monto,$id_usuario);
                    }else
                    {
                        //
                    }
                }
                if($forma_pago == 5){
                    if($forma == 3 || $forma == 4){
                        $this->descontarCajaDeposito($monto_aux,$id_usuario);
                        $this->actualizarCajaDeposito($monto,$id_usuario);
                    }else
                    {
                        //
                    }
                }
                // dd($forma_pago);
                // if($forma_pago == 6){
                //     // if($forma == 3 || $forma == 4){
                //     //     $this->descontarCajaDeposito($monto_aux,$id_usuario);
                //     //     $this->actualizarCajaDeposito($monto,$id_usuario);
                //     // }else
                //     // {
                //     //     //
                //     // }
                // }
                
                // $this->descontarCajaDeposito($monto_aux,$id_usuario);
                // $this->actualizarCaja($monto,$id_usuario);
            }
            
         }
        //  if($forma_pago == $forma){
        //     if($forma_pago == 3 || $forma_pago == 4 || $forma_pago == 5){
        //         $this->actualizarCajaDeposito($request->monto,$id_usuario);
        //         $this->descontarCajaDeposito($monto,$id_usuario);
        //     }

        // }else{
        //     if($request->id_forma_pago == 3 || $request->id_forma_pago == 4 || $request->id_forma_pago == 5){
        //         $this->actualizarCajaDeposito($request->monto,$id_usuario);
        //     }
        //     else
        //     {   //dd($monto);
        //          $this->descontarCajaDeposito($monto,$id_usuario);
        //     }
            
        //  }

        $datos = [
            'tabla' => 'gasto',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'modificar',
        ];
        $this->guardarBitacora($datos);

    }
    public function cantidadRegistros(){
        $cantidad = DB::table('gasto')->count();

        $data=['nro' =>$cantidad];
        return $data;
    }
}
