<?php

namespace App\Http\Controllers;

use App\Models\MiEmpresa;
use App\Models\ArqueoCaja;
use App\Models\PagoMesero;
use Illuminate\Http\Request;
use DB;
use DateTime;

class ArqueoCajaController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;       
        if ($buscar==''){
            $arqueo = DB::table('arqueo_caja as a')
            ->join('users as u', 'a.id_usuario', '=', 'u.id')
            ->select('a.id','a.fecha_apertura','a.fecha_cierre','a.apertura','a.registro_venta as ingreso','a.estado','a.gastos','a.total','a.registro_compra','a.saldo_sistema','a.saldo_efectivo','a.diferencia','a.id_usuario',DB::raw('a.registro_compra + a.gastos + a.gastos_deposito as egreso'),DB::raw('a.apertura + a.registro_venta - a.registro_compra- a.gastos as total_efectivo'),'a.doscientos','a.cien','a.cincuenta','a.veinte','a.diez','a.cinco','a.dos','a.uno','a.cerocinco','a.ceroveinte','a.ceroveinte','a.cien_dolar','u.name')
            ->orderBy('a.id', 'desc')->paginate(15);

        }
        else{
            $arqueo = DB::table('arqueo_caja as a')
            ->join('users as u', 'a.id_usuario', '=', 'u.id')
            ->select('a.id','a.fecha_apertura','a.fecha_cierre','a.apertura','a.registro_venta as ingreso','a.estado','a.gastos','a.total','a.registro_compra','a.saldo_sistema','a.saldo_efectivo','a.diferencia','a.id_usuario',DB::raw('a.registro_compra + a.gastos + a.gastos_deposito  as egreso'),DB::raw('a.apertura + a.registro_venta - a.registro_compra- a.gastos as total_efectivo'),'a.doscientos','a.cien','a.cincuenta','a.veinte','a.diez','a.cinco','a.dos','a.uno','a.cerocinco','a.ceroveinte','a.ceroveinte','a.cien_dolar','u.name')
            ->where(''.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('a.id', 'desc')->paginate(15);
        }
        return $arqueo;
    }

    public function indexArqueo(Request $request){
        $id_usuario = \Auth::user()->id;
            $caja=DB::select("SELECT a.id as id, a.fecha_apertura, a.fecha_cierre, a.apertura,
            (a.registro_venta)as ingreso, (a.registro_compra)+(a.gastos)+(a.gastos_deposito)  as egreso
            ,((a.apertura)+(a.registro_venta))-((a.registro_compra)+(a.gastos)+(a.gastos_deposito)) as total_efectivo,
            u.name as name, a.estado
            from arqueo_caja a, users u
            where a.id_usuario=u.id and u.id=$id_usuario and a.estado='Abierta'");
        return $caja;
    }

    public function index2(Request $request){
        $id_usuario = \Auth::user()->id;
            $caja=DB::select("SELECT a.id as id,a.apertura as apertura,a.registro_venta as registro_venta,
            a.gastos as gastos,a.registro_compra as registro_compra,a.gastos_deposito,a.total_efectivo,a.total_deposito,
            a.total_efectivo_compra,a.total_deposito_compra, a.pago_mesero, a.total_credito_compra,a.total_credito_deposito_compra,a.total_credito,a.total_credito_deposito
            from arqueo_caja a, users u
            where a.id_usuario=u.id and u.id=$id_usuario and a.estado='Abierta'");
        return $caja;
    }

    public function guardar(Request $request){
        
        $caja= new ArqueoCaja();
        
        $objdate = new DateTime();
        $fecha_apertura=$objdate;

        $caja->fecha_apertura=$fecha_apertura;
        $caja->apertura=$request->apertura;
        $caja->estado="Abierta";
        $caja->id_usuario=\Auth::user()->id;
        $caja->save();

        
        $datos = [
            'tabla' => 'caja',
            'codigo_tabla' => $caja->id,
            'transaccion' => 'apertura',
        ];
        $this->guardarBitacora($datos);
    }

    public function modificar(Request $request){
        $objdate = new DateTime();
        $fecha_cierre=$objdate;

        $caja= ArqueoCaja::findOrFail($request->id);
        $caja->fecha_cierre=$fecha_cierre;
        $caja->doscientos=$request->doscientos;
        $caja->cien=$request->cien;
        $caja->cincuenta=$request->cincuenta;
        $caja->veinte=$request->veinte;
        $caja->diez=$request->diez;
        $caja->cinco=$request->cinco;
        $caja->dos=$request->dos;
        $caja->uno=$request->uno;
        $caja->cerocinco=$request->cerocinco;
        $caja->ceroveinte=$request->ceroveinte;
        $caja->cien_dolar=$request->cien_dolar;
        // $caja->registro_venta=$request->registro_venta;
        // $caja->apertura=$request->apertura;
        $caja->total=$request->total;
        // $caja->gastos=$request->gastos;
        // $caja->registro_compra=$request->registro_compra;
        $caja->saldo_sistema=$request->saldo_sistema;
        $caja->saldo_efectivo=$request->saldo_efectivo;
        $caja->diferencia=$request->diferencia;
        $caja->estado='Cerrada';
        $caja->id_usuario=\Auth::user()->id;
        $caja->save();

        $datos = [
            'tabla' => 'caja',
            'codigo_tabla' => $caja->id,
            'transaccion' => 'arqueo de caja',
        ];
        $this->guardarBitacora($datos);
    }

    public function cantidadRegistros(){
        $cantidad = DB::table('mi_empresa')->count();

        $data=['nro' =>$cantidad];
        return $data;
    }

    public function estadoArqueoCaja(){
        $id_usuario=\Auth::user()->id;
        $id_grupo=\Auth::user()->id_grupo;
        //$estado_caja = DB::table('arqueo_caja')->select('estado')->where('id_usuario','=',$id_usuario)->where('estado','=','Abierta')->get();
        if($id_grupo!=3){
            $estado_caja = DB::table('arqueo_caja')
            ->join('users', 'arqueo_caja.id_usuario', '=', 'users.id')
            ->select('arqueo_caja.estado')
            ->where('arqueo_caja.estado','=','Abierta')
            ->where('users.id',$id_usuario)
            ->get();
        }
        else{
            if($id_grupo==3){
                $estado_caja = DB::table('arqueo_caja')
                ->join('users', 'arqueo_caja.id_usuario', '=', 'users.id')
                ->select('arqueo_caja.estado')
                ->where('arqueo_caja.estado','=','Abierta')
                ->get();
            }
        }

        //dd($estado_caja->count());
        if($estado_caja->isEmpty()){
            //$obj=['estado_caja' =>'Sin Caja'];
            $data=(object) ['estado'=>'Cerrada'];
        } else {
            //$obj=['estado_caja' =>$estado_caja];
            $data=(object) $estado_caja[0];
        }
        return $data;
    }
    public function estadoArqueoCajaMesero(){
        $id_usuario=\Auth::user()->id;
        $estado_caja = DB::table('arqueo_caja')->select('estado')->where('estado','=','Abierta')->get();
        if($estado_caja->isEmpty()){
            //$obj=['estado_caja' =>'Sin Caja'];
            $data=(object) ['estado'=>'Cerrada'];
        } else {
            //$obj=['estado_caja' =>$estado_caja];
            $data=(object) $estado_caja[0];
        }
        return $data;
    }

    public function actualizarVentasAlCerrarCaja(Request $request){
        DB::beginTransaction();
        try {
            
            DB::table('venta')
            ->join('users', 'venta.id_usuario', '=', 'users.id')
            ->where('venta.control', 0)
            ->update(['venta.control' => $request->id_caja]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error'=>$e->getMessage()];
        }
    }

    public function listaMeserosPagar(Request $request){
        DB::beginTransaction();
        try {
            
            $id_usuario=\Auth::user()->id;

            /*$ultimaCajaUsuario=DB::table('arqueo_caja')
            ->join('users', 'arqueo_caja.id_usuario', '=','users.id')
            ->select('arqueo_caja.id')
            ->where('users.id', $id_usuario)
            ->orderBy('arqueo_caja.id','desc')
            ->first();*/

            /*$listaMeserosVentas=DB::table('venta')
            ->join('users', 'venta.id_usuario', '=','users.id')
            ->join('personal', 'personal.id', '=','users.id_personal')
            ->select('users.id as id_usuario', 'venta.estado','personal.id as id_personal', 'personal.nombre', DB::raw('SUM(venta.total) as total_ventas'), DB::raw('SUM(venta.total*(personal.porcentaje/100)) as total_comision'))
            // ->where('venta.control', $ultimaCajaUsuario->id)
            ->where('venta.control_mesero', 0)
            ->where('users.id_grupo', 3)
            ->groupBy('personal.nombre')
            ->where('venta.estado', '!=', 'Registrado')
            ->get();*/

            $listaMeserosVentas = DB::table('venta')
            ->join('users', 'venta.id_usuario', '=', 'users.id')
            ->join('personal', 'personal.id', '=', 'users.id_personal')
            ->select('users.id as id_usuario', 'venta.estado', 'personal.id as id_personal', 'personal.nombre', DB::raw('SUM(venta.total) as total_ventas'), DB::raw('SUM(venta.total*(personal.porcentaje/100)) as total_comision'))
            ->where('venta.control_mesero', 0)
            ->where('users.id_grupo', 3)
            ->whereNotIn('users.id', function ($query) {
                $query->select('users.id')
                      ->from('users')
                      ->join('venta', 'venta.id_usuario', '=', 'users.id')
                      ->where('venta.estado', '=', 'Registrado')
                      ->where('users.id_grupo', 3);
            })
            ->groupBy('personal.nombre')
            ->get();

            return $listaMeserosVentas;
            //dd($listaMeserosVentas);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error'=>$e->getMessage()];
        }
        
    }

    public function pagarMesero(Request $request){
        DB::beginTransaction();
        try {
            
            $id_usuario=\Auth::user()->id;
            $pago_mesero = new PagoMesero();
            $pago_mesero->total_venta=$request->total_ventas;
            $pago_mesero->comision=$request->comision;
            $pago_mesero->fecha=$request->fecha;
            $pago_mesero->id_usuario=$request->id_usuario;
            $pago_mesero->save();

            DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
            ->where('arqueo_caja.estado','=','Abierta')
            ->increment('arqueo_caja.pago_mesero', $request->comision);

            DB::table('venta')
            ->join('users', 'venta.id_usuario', '=', 'users.id')
            ->where('venta.control_mesero', 0)
            ->where('users.id', $request->id_usuario)
            ->update(['venta.control_mesero' => 1]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error'=>$e->getMessage()];
        }
    }

    public function pagarListaMeseros(Request $request){
        DB::beginTransaction();
        try {
            $detalle = $request->detalle;
            foreach($detalle as $ep=>$det){
                $id_usuario=\Auth::user()->id;
                $pago_mesero = new PagoMesero();
                $pago_mesero->total_venta=$det['total_venta'];
                $pago_mesero->comision=$det['total_comision'];
                $pago_mesero->fecha=$request->fecha;
                $pago_mesero->id_usuario=$det['id_usuario'];
                $pago_mesero->save();

                DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
                ->where('arqueo_caja.estado','=','Abierta')
                ->increment('arqueo_caja.pago_mesero', $det['total_comision']);

                DB::table('venta')
                ->join('users', 'venta.id_usuario', '=', 'users.id')
                ->where('venta.control_mesero', 0)
                ->where('users.id', $det['id_usuario'])
                ->update(['venta.control_mesero' => 1]);
            }
            //dd($request->detalle);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error'=>$e->getMessage()];
        }
    }

    public function historialPagoMeseros(Request $request){
        /*$listaMeserosVentas=DB::table('venta')
            ->join('users', 'venta.id_usuario', '=','users.id')
            ->join('personal', 'personal.id', '=','users.id_personal')
            ->join('pago_mesero', 'pago_mesero.id_usuario', '=', 'users.id')
            ->select('personal.nombre', 'users.name', 'pago_mesero.fecha', 'pago_mesero.comision', 'pago_mesero.total_venta')
            ->where('venta.control_mesero','!=', 0)
            ->where('users.id_grupo', 3)
            ->groupBy('personal.nombre')
            ->where('venta.estado', '!=', 'Registrado')
            ->get();*/
            if($request->buscar==''){
                $listaMeserosVentas=DB::table('pago_mesero')
                ->join('users', 'pago_mesero.id_usuario', '=', 'users.id')
                ->join('personal', 'personal.id', '=','users.id_personal')
                ->select('personal.nombre', 'users.name', 'pago_mesero.fecha', 'pago_mesero.comision', 'pago_mesero.total_venta')
                ->where('users.id_grupo', 3)
                ->whereDate('pago_mesero.fecha','>=', $request->fecha_inicio)
                ->whereDate('pago_mesero.fecha','<=', $request->fecha_final)
      
                ->get();
            }else{
                $listaMeserosVentas=DB::table('pago_mesero')
                ->join('users', 'pago_mesero.id_usuario', '=', 'users.id')
                ->join('personal', 'personal.id', '=','users.id_personal')
                ->select('personal.nombre', 'users.name', 'pago_mesero.fecha', 'pago_mesero.comision', 'pago_mesero.total_venta')
                ->where('users.id_grupo', 3)
                ->whereDate('pago_mesero.fecha','>=', $request->fecha_inicio)
                ->whereDate('pago_mesero.fecha','<=', $request->fecha_final)
                ->where(''.$request->criterio, 'like', '%'.$request->buscar.'%')
                ->get();
            }
            return $listaMeserosVentas;
    }

    public function cantidadCajasAbierta(){
        
        $cantidad_abiertas = DB::table('arqueo_caja')
        ->select(DB::raw('COUNT(*) as cantidad'))
        ->where('arqueo_caja.estado', '=', 'Abierta')
        ->get();
        return ['cantidad_abiertas'=> $cantidad_abiertas[0]->cantidad];
    }

    public function verificarSoloUnaCajaAbierta(){
        $cantidad_cajas_abiertas=DB::table('arqueo_caja')->where('arqueo_caja.estado', 'Abierta')->count();
        return ['cantidad_cajas_abiertas'=>$cantidad_cajas_abiertas];
    }
}
