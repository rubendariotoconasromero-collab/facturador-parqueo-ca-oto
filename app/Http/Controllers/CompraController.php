<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Articulo;
use App\Models\TiendaArticulo;
use App\Models\Ajuste;
use App\Models\Control;
use App\Models\ArqueoCaja;
use App\Models\PagoCompra;
use App\Models\CXpagar;
use App\Models\MiEmpresa;
use DB;
use DateTime;

class CompraController extends BitacoraController
{

    public function index(Request $request){
        $id_tienda = $request->id_tienda;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Compra::join('users','compra.id_usuario','=','users.id')
            ->join('proveedor','compra.id_proveedor','=','proveedor.id')
            ->join('forma_pago','compra.id_forma_pago','=','forma_pago.id')
            ->join('tipo_pago','compra.id_tipo_pago','=','tipo_pago.id')
            ->select('compra.id','compra.fecha','compra.descripcion','compra.sub_total','compra.descuento',
            'compra.total','compra.estado','users.name','proveedor.nombre as proveedor','forma_pago.nombre as formaP','tipo_pago.nombre as tipo','compra.id_tienda')
            ->where('compra.id_tienda',$id_tienda)
            ->orderBy('compra.id','desc')
            ->paginate(15);
        }
        else{
            $obj= Compra::join('users','compra.id_usuario','=','users.id')
            ->join('proveedor','compra.id_proveedor','=','proveedor.id')
            ->join('forma_pago','compra.id_forma_pago','=','forma_pago.id')
            ->join('tipo_pago','compra.id_tipo_pago','=','tipo_pago.id')
            ->select('compra.id','compra.fecha','compra.descripcion','compra.sub_total','compra.descuento',
            'compra.total','compra.estado','users.name','proveedor.nombre as proveedor','forma_pago.nombre as formaP','tipo_pago.nombre as tipo','compra.id_tienda')
            ->where('compra.id_tienda',$id_tienda)
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('compra.id','desc')
            ->paginate(15);
        }
        return $obj;
    }

    private function actualizarStock($id_producto,$cantVenta,$id_tienda){
        DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$id_producto)
        ->where('tienda_articulo.id_tienda','=',$id_tienda)
        ->increment('stock', $cantVenta);
    }

    private function actualizarCaja($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->increment('arqueo_caja.registro_compra', $monto);
    }

    private function descontarCaja($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->decrement('arqueo_caja.registro_compra', $monto);
    }
    private function descontarCajaDeposito($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->decrement('arqueo_caja.registro_compra', $monto);
    }
    private function descontarCajaContado($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->decrement('arqueo_caja.total_efectivo_compra', $monto);
    }
    private function descontarCajaContadoDeposito($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->decrement('arqueo_caja.total_deposito_compra', $monto);
    }

    private function actualizarCajaEfectivo($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->increment('arqueo_caja.total_efectivo_compra', $monto);
    }

    private function actualizarCajaDeposito($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->increment('arqueo_caja.total_deposito_compra', $monto);
    }

    public function guardar(Request $request){
        try{
            $id_tienda=\Auth::user()->id_tienda;

            DB::beginTransaction();
            $registro_compra = $request->total;
            $id=\Auth::user()->id;
            //dd($request->id_tipo_pago);
            $compra = new Compra();
            $compra->fecha=$request->fecha;
            $compra->descripcion=$request->descripcion;
            $compra->sub_total=$request->sub_total;
            $compra->descuento=empty($compra->descuento)?0:$request->descuento;
            $compra->total=$request->total;
            $compra->estado='Registrado';
            $compra->id_proveedor=$request->id_proveedor;
            $compra->id_tipo_pago=$request->id_tipo_pago;
            if($request->id_tipo_pago == 1) {
                $compra->id_forma_pago=$request->id_forma_pago;
            }else if ($request->id_tipo_pago == 2) {
                $compra->id_forma_pago=$request->id_forma_pago;
            } else {
                //
            }
            $compra->id_usuario=\Auth::user()->id;
            

            if($request->id_tipo_pago == 1) {
                $pago = new PagoCompra();
                $pago->id = $compra->id;
                $pago->fecha = $request->fecha;
                $pago->fecha_final = $request->fecha_final;
                $pago->monto = $request->total;
                $pago->saldo = $request->total;
                $pago->descripcion = "";
                $pago->id_tipo_pago = $request->id_tipo_pago;
                $pago->id_compra = $compra->id;
                $pago->save();

                //$this->actualizarCaja($registro_venta,$id_usuario);

            } else if($request->id_tipo_pago == 2) {

                $pago = new PagoCompra();
                $pago->id = $compra->id;
                $pago->fecha = $request->fecha;
                $pago->fecha_final = $request->fecha_final;
                $pago->monto = $request->total;
                $pago->saldo = $request->total;
                $pago->descripcion = $request->descripcion = "";
                $pago->id_tipo_pago = $request->id_tipo_pago;
                $pago->id_compra = $compra->id;
                $pago->save();

                $cxcobrar = new CXPagar();
                $cxcobrar->fecha = $request->fecha;
                //$cxcobrar->anticipo = $request->anticipo;
                $cxcobrar->monto_total = $request->monto_total;
                $cxcobrar->descripcion = $request->descripcion_pago;
                $cxcobrar->saldo = $request->monto_total;
                $cxcobrar->id_pago = $compra->id;
                $cxcobrar->id_forma_pago = $request->id_forma_pago;
                $cxcobrar->save();

            } else {
                //
            }

            $objdate = new DateTime();
            $fechaactual= $objdate->format('Y-m-d');
            $year = $objdate->format('y');
            $correlativo = $this->correlativoControl();

            $control = new control();
            $control->tabla = $request->tabla = "Compra";
            $control->codigo = $request->codigo = 'C'.strval($correlativo + 1).$year;
            $control->fecha = $fechaactual;
            $control->save();

            $detalles = $request->detalle;
            foreach($detalles as $ep=>$det){
                //$id_producto = $det['id_tienda_articulo'];
                $obj = new DetalleCompra();
                $obj->id_compra= $compra->id;
                $obj->id_producto= $det['id_tienda_articulo'];
                $obj->cantidad= $det['cantidad'];
                $obj->costo_compra= $det['costo_compra'];
                $obj->sub_total= $det['sub_total'];
                $obj->save();
                $this->actualizarStock($det['id_articulo'],$det['cantidad'],$det['id_tienda']);

                $articulo = Articulo::findOrFail($det['id_articulo']);
                $articulo->costo_compra=$det['costo_compra'];
                $articulo->save();

                $tienda_articulo=DB::select("SELECT ta.stock
                FROM tienda_articulo ta
                WHERE ta.id = '$obj->id_producto'");
                // $tienda_articulo = TiendaArticulo::where('id_tienda','=',1)
                //                     ->where('id_articulo','=',$det['id_tienda_articulo']);
                //dd($obj->id_producto,$tienda_articulo);

                $ajuste = new Ajuste();
                $ajuste->stock=$det['cantidad'];
                $ajuste->costo_compra=$det['costo_compra'];
                $ajuste->costo_unitario=$articulo->costo_unitario;
                $ajuste->costo_mayorista=$articulo->costo_mayorista;
                $ajuste->costo_preferencial=$articulo->costo_preferencial;
                $ajuste->stock_anterior=$tienda_articulo[0]->stock-$det['cantidad'];
                $ajuste->stock_actual=$tienda_articulo[0]->stock;
                $ajuste->costo_venta=0;
                $ajuste->observacion=$request->descripcion;
                $ajuste->id_articulo=$det['id_articulo'];
                $ajuste->id_motivo_ajuste=6;
                $ajuste->save();

            }

            $this->actualizarCaja($registro_compra,$id);

            $datos = [
                'tabla' => 'compra',
                'codigo_tabla' => $compra->id,
                'transaccion' => 'guardar',
            ];
            $this->guardarBitacora($datos);

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarContado(Request $request){
        try{
            $id_tienda=\Auth::user()->id_tienda;

            DB::beginTransaction();
            $registro_compra = $request->total;
            $id=\Auth::user()->id;
            //dd($request->id_tipo_pago);
            $compra = new Compra();
            $compra->fecha=$request->fecha;
            $compra->descripcion=$request->descripcion;
            $compra->sub_total=$request->sub_total;
            $compra->descuento=empty($compra->descuento)?0:$request->descuento;
            $compra->total=$request->total;
            $compra->estado='Registrado';
            $compra->id_proveedor=$request->id_proveedor;
            $compra->id_tipo_pago=$request->id_tipo_pago;
            $compra->id_forma_pago=$request->id_forma_pago;

            $compra->id_tipo_pago=$request->id_tipo_pago;
            $compra->id_forma_pago=$request->id_forma_pago;

            if($request->id_forma_pago == 6){
                $compra->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $compra->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;
                $this->actualizarCaja($registro_compra,$id);
                $this->actualizarCajaEfectivo($compra->total_efectivo,$id);

                $this->actualizarCajaDeposito($compra->total_deposito,$id);
            }else if($request->id_forma_pago == 2)
            {
                $compra->total_efectivo =$request->total;
                $compra->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;
                $this->actualizarCaja($registro_compra,$id);
                $this->actualizarCajaEfectivo($compra->total_efectivo,$id);

            }else if($request->id_forma_pago == 3)
            {
                $compra->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $compra->total_deposito =$request->total;
                $this->actualizarCaja($registro_compra,$id);
                $this->actualizarCajaDeposito($compra->total_deposito,$id);

            }else if($request->id_forma_pago == 4)
            {
                $compra->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $compra->total_deposito =$request->total;
                $this->actualizarCaja($registro_compra,$id);
                $this->actualizarCajaDeposito($compra->total_deposito,$id);

            }else if($request->id_forma_pago == 5)
            {
                $compra->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $compra->total_deposito =$request->total;
                $this->actualizarCaja($registro_compra,$id);
                $this->actualizarCajaDeposito($compra->total_deposito,$id);
            }else
            {
                //
            }


            $compra->id_usuario=\Auth::user()->id;
            if($id_tienda == 100){
                $compra->id_tienda=$request->id_tienda;
            }else{
                $compra->id_tienda=$id_tienda;
            }
            $compra->save();

            if($request->id_tipo_pago == 1) {
                $pago = new PagoCompra();
                $pago->id = $compra->id;
                $pago->fecha = $request->fecha;
                $pago->fecha_final = $request->fecha_final;
                $pago->monto = $request->total;
                $pago->saldo = $request->total;
                $pago->descripcion = "";
                $pago->id_tipo_pago = $request->id_tipo_pago;
                $pago->id_compra = $compra->id;
                $pago->save();
            }else if($request->id_tipo_pago == 2) {

                $pago = new PagoCompra();
                $pago->id = $compra->id;
                $pago->fecha = $request->fecha;
                $pago->fecha_final = $request->fecha_final;
                $pago->monto = $request->total;
                $pago->saldo = $request->total;
                $pago->descripcion = $request->descripcion = "";
                $pago->id_tipo_pago = $request->id_tipo_pago;
                $pago->id_compra = $compra->id;
                $pago->save();

                $cxcobrar = new CXPagar();
                $cxcobrar->fecha = $request->fecha;
                //$cxcobrar->anticipo = $request->anticipo;
                $cxcobrar->monto_total = $request->monto_total;
                $cxcobrar->descripcion = $request->descripcion_pago;
                $cxcobrar->saldo = $request->monto_total;
                $cxcobrar->id_pago = $compra->id;
                $cxcobrar->id_forma_pago = 0;
                $cxcobrar->save();

            } else {
                //
            }

            $objdate = new DateTime();
            $fechaactual= $objdate->format('Y-m-d');
            $year = $objdate->format('y');
            $correlativo = $this->correlativoControl();

            $control = new control();
            $control->tabla = $request->tabla = "Compra";
            $control->codigo = $request->codigo = 'C'.strval($correlativo + 1).$year;
            $control->fecha = $fechaactual;
            $control->save();

            $detalles = $request->detalle;
            foreach($detalles as $ep=>$det){
                //$id_producto = $det['id_tienda_articulo'];
                $obj = new DetalleCompra();
                $obj->id_compra= $compra->id;
                $obj->id_producto= $det['id_tienda_articulo'];
            
                $obj->cantidad= $det['cantidad'];
                $obj->costo_compra= $det['costo_compra'];
                $obj->sub_total= $det['sub_total'];
                $obj->save();
                $this->actualizarStock($det['id_articulo'],$det['cantidad'],$det['id_tienda']);

                $articulo = Articulo::findOrFail($det['id_articulo']);
                $articulo->costo_compra=$det['costo_compra'];
                $articulo->save();

                $tienda_articulo=DB::select("SELECT ta.stock
                FROM tienda_articulo ta
                WHERE ta.id = '$obj->id_producto'");

                $ajuste = new Ajuste();
                $ajuste->stock=$det['cantidad'];
                $ajuste->costo_compra=$det['costo_compra'];
                $ajuste->costo_venta=0;
                $ajuste->stock_anterior=$tienda_articulo[0]->stock-$det['cantidad'];
                $ajuste->stock_actual=$tienda_articulo[0]->stock;
                $ajuste->costo_venta=0;
                $ajuste->observacion=$request->descripcion;
                $ajuste->id_articulo=$det['id_articulo'];
                $ajuste->id_motivo_ajuste=6;
                $ajuste->save();

            }


            $datos = [
                'tabla' => 'compra',
                'codigo_tabla' => $compra->id,
                'transaccion' => 'guardar',
            ];
            $this->guardarBitacora($datos);

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function obtenerCabecera(Request $request){

        $id=$request->id;
        $obj= Compra::join('proveedor','compra.id_proveedor','=','proveedor.id')
        ->select('compra.id','compra.fecha','compra.descripcion','compra.total','proveedor.nombre as proveedor')
        ->where('compra.id','=',$id)
        ->get();

        return $obj;
    }

    public function detalleCompra(Request $request){

        $id=$request->id;
        $obj= detalleCompra::join('tienda_articulo','detalle_compra.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->leftjoin('categoria', function($join){
            $join->orOn('articulo.id_categoria','=','categoria.id');
        })
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_compra.id_compra','detalle_compra.costo_compra','detalle_compra.id_compra','detalle_compra.cantidad',
        'detalle_compra.sub_total','articulo.nombre as articulo','tienda.nombre as tienda','categoria.nombre as categoria')
        ->where('detalle_compra.id_compra','=',$id)
        ->get();
        return $obj;
    }

    public function anular(Request $request){
        $registro_compra = DB::select("SELECT id, total,total_efectivo,total_deposito,id_tipo_pago,id_forma_pago FROM compra WHERE compra.id = $request->id");
        $total = $registro_compra[0]->total;
        $total_efectivo = $registro_compra[0]->total_efectivo;
        $total_deposito = $registro_compra[0]->total_deposito;
        $tipo_pago = $registro_compra[0]->id_tipo_pago;
        $forma_pago = $registro_compra[0]->id_forma_pago;
        $id_usuario=\Auth::user()->id;
        $obj = Compra::findOrFail($request->id);
        $obj->estado = 'Anulado';
        $obj->save();

        $detalles = DetalleCompra::select('id_compra','id_producto','cantidad','costo_compra')
        ->where('detalle_compra.id_compra',$request->id)->get();
        foreach($detalles as $ep=>$det){
            DB::table('tienda_articulo')->where('tienda_articulo.id','=',$det->id_producto)
            ->decrement('stock', $det->cantidad);

            $tienda_articulo=DB::select("SELECT ta.stock
            FROM tienda_articulo ta
            WHERE ta.id = '$det->id_producto'");

            $ajuste = new Ajuste();
            $ajuste->stock=$det->cantidad;
            $ajuste->costo_compra=$det->costo_compra;
            $ajuste->stock_anterior=$tienda_articulo[0]->stock + $det->cantidad;
            $ajuste->stock_actual=$tienda_articulo[0]->stock;
            $ajuste->costo_venta=0;
            $ajuste->observacion=$request->descripcion;
            $ajuste->id_articulo=$det->id_producto;
            $ajuste->id_motivo_ajuste=7;
            $ajuste->save();
        }
        if($tipo_pago == "1"){
            if($forma_pago == 2){
                $this->descontarCaja($total,$id_usuario);
                $this->descontarCajaContado($total,$id_usuario);                
            }
            if($forma_pago ==3 || $forma_pago ==4 || $forma_pago ==5){
                $this->descontarCaja($total,$id_usuario);
                $this->descontarCajaContadoDeposito($total,$id_usuario);
            }
            if($forma_pago ==6){
                //dd($forma_pago);
                $this->descontarCaja($total_efectivo,$id_usuario);
                $this->descontarCajaContado($total_efectivo,$id_usuario);

                $this->descontarCajaDeposito($total_deposito,$id_usuario);
                $this->descontarCajaContadoDeposito($total_deposito,$id_usuario);
            }
        }
        //$this->descontarCaja($total,$id_usuario);

    }

    private function correlativoControl(){
        $mayor = DB::table('control')->where('control.tabla','=','Compra')->count();
         return $mayor;
    }



    public function pdfComprasGeneral(Request $request){

        $id = $request->id;
        $foto = $request->foto;

        $compra= Compra::join('users','compra.id_usuario','=','users.id')
        ->join('proveedor','compra.id_proveedor','=','proveedor.id')
        ->join('forma_pago','compra.id_forma_pago','=','forma_pago.id')
        ->join('tipo_pago','compra.id_tipo_pago','=','tipo_pago.id')
        ->select('compra.id','compra.fecha','compra.sub_total','compra.descuento',
        'compra.total','compra.estado','users.name','proveedor.nombre as proveedor','forma_pago.nombre as formaP','tipo_pago.nombre as tipo','compra.total_efectivo','compra.total_deposito')
        ->where('compra.id',$id)
        ->orderBy('compra.id','desc')->get();

        $detalleCompra= detalleCompra::join('tienda_articulo','detalle_compra.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_compra.id_compra','detalle_compra.costo_compra',
        'articulo.nombre as articulo','detalle_compra.cantidad','detalle_compra.sub_total','tienda.nombre as tienda')
        ->where('detalle_compra.id_compra','=',$id)
        ->get();

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $usuario = \Auth::user()->name;
        $objdate = new DateTime();
        $fecha_impresion=$objdate->format('d/m/Y');
        $proveedor=$compra[0]->proveedor;
        $fecha=$compra[0]->fecha;
        $forma_pago=$compra[0]->formaP;
        $tipo_pago=$compra[0]->tipo;
        $detalles=$detalleCompra;
        $total=$compra[0]->total;
        $descuento=$compra[0]->descuento;
        $sub_total=$compra[0]->sub_total;
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $foto_empresa=$mi_empresa[0]->foto;
        $total_efectivo=$compra[0]->total_efectivo;
        $total_deposito=$compra[0]->total_deposito;

        $cont=Compra::count();
        $pdf = \PDF::loadView('pdf.compra.compra-general', [
            'id'=>$id,
            'tipo_pago'=>$tipo_pago,
            'compras'=>$compra,
            'fecha'=>$fecha,
            'proveedor'=>$proveedor,
            'forma_pago'=>$forma_pago,
            'detalles'=>$detalles,
            'total'=>$total,
            'descuento'=>$descuento,
            'sub_total'=>$sub_total,
            'foto'=>$foto,
            'fecha_impresion'=>$fecha_impresion,
            'usuario'=>$usuario,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'foto_empresa'=>$foto_empresa,
            'total_efectivo'=>$total_efectivo,
            'total_deposito'=>$total_deposito,
        ]);
        return $pdf->setPaper('letter', 'portrait')->stream('Compras.pdf');
    }

    public function pdfComprasGeneral2(Request $request){

        $var2=DB::select("SELECT  MAX(id) as compra from compra");
        $id=$var2[0]->compra;

        $foto = $request->foto;

        $compra= Compra::join('users','compra.id_usuario','=','users.id')
        ->join('proveedor','compra.id_proveedor','=','proveedor.id')
        ->join('forma_pago','compra.id_forma_pago','=','forma_pago.id')
        ->select('compra.id','compra.fecha','compra.sub_total','compra.descuento',
        'compra.total','compra.estado','users.name','proveedor.nombre as proveedor','forma_pago.nombre as formaP')
        ->where('compra.id',$id)
        ->orderBy('compra.id','desc')->get();

        $detalleCompra= detalleCompra::join('tienda_articulo','detalle_compra.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_compra.id_compra','detalle_compra.costo_compra','articulo.costo_unitario as costo_unitario','articulo.costo_mayorista as costo_mayorista','articulo.costo_preferencial as costo_preferencial','articulo.nombre as articulo','detalle_compra.cantidad','detalle_compra.sub_total','tienda.nombre as tienda')
        ->where('detalle_compra.id_compra','=',$id)
        ->get();

        $usuario = \Auth::user()->name;
        $objdate = new DateTime();
        $fecha_impresion=$objdate->format('d/m/Y');
        $proveedor=$compra[0]->proveedor;
        $fecha=$compra[0]->fecha;
        $forma_pago=$compra[0]->formaP;
        $detalles=$detalleCompra;
        $total=$compra[0]->total;
        $descuento=$compra[0]->descuento;
        $sub_total=$compra[0]->sub_total;

        $cont=Compra::count();
        $pdf = \PDF::loadView('pdf.compra.compra-general', [
            'compras'=>$compra,
            'fecha'=>$fecha,
            'proveedor'=>$proveedor,
            'forma_pago'=>$forma_pago,
            'detalles'=>$detalles,
            'total'=>$total,
            'descuento'=>$descuento,
            'sub_total'=>$sub_total,
            'foto'=>$foto,
            'fecha_impresion'=>$fecha_impresion,
            'usuario'=>$usuario
        ]);
        return $pdf->setPaper('letter', 'portrait')->stream('Compras.pdf');
    }

    public function montoT(){
        //$compra=compra::sum('compra.total');
        $compra=compra::select(DB::raw('SUM(compra.total) as total'))->where('compra.estado','!=','Anulado')->get();
        return $compra;
    }

}
