<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Traspaso;
use App\Models\DetalleTraspaso;
use App\Models\TiendaArticulo;
use App\Models\Tienda;
use App\Models\Ajuste;
use App\Models\MiEmpresa;
use DateTime;
use DB;
class TraspasoController extends BitacoraController
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;       
        if ($buscar==''){
            $traspaso = Traspaso::join('tienda as t1','traspaso.id_tienda1','=','t1.id')
            ->leftJoin('tienda as t2','traspaso.id_tienda2','=','t2.id')
            ->select('traspaso.id','traspaso.id_tienda1','traspaso.id_tienda2','traspaso.fecha',
            'traspaso.hora','traspaso.glosa','traspaso.estado','t1.nombre as tienda1','t2.nombre as tienda2')
            ->whereDate('traspaso.fecha', ">=", $request->fecha_inicio)
            ->whereDate('traspaso.fecha', "<=", $request->fecha_fin)
            ->orderBy('traspaso.id', 'desc')->paginate(15);
        }
        else{
            $traspaso = Traspaso::join('tienda as t1','traspaso.id_tienda1','=','t1.id')
            ->leftJoin('tienda as t2','traspaso.id_tienda2','=','t2.id')
            ->select('traspaso.id','traspaso.id_tienda1','traspaso.id_tienda2','traspaso.fecha',
            'traspaso.hora','traspaso.glosa','traspaso.estado','t1.nombre as tienda1','t2.nombre as tienda2')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->whereDate('traspaso.fecha', ">=", $request->fecha_inicio)
            ->whereDate('traspaso.fecha', "<=", $request->fecha_fin)
            ->orderBy('traspaso.id', 'desc')->paginate(15);
        }
        return $traspaso;
    }

    private function actualizarStockTienda1($id,$cantVenta){
        DB::table('tienda_articulo')->where('tienda_articulo.id','=',$id)
        ->decrement('stock', $cantVenta);
    }

    private function actualizarStockTienda2($id_producto,$cantVenta,$tienda2){
        // $obj= TiendaArticulo::->where('tienda_articulo.id_articulo',$id_producto)
        // ->where('tienda_articulo.id_tienda',$tienda2)
        DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$id_producto)
        ->where('tienda_articulo.id_tienda','=',1)
        ->increment('stock', $cantVenta);
    }

    

    public function guardar(Request $request){
        try{
            DB::beginTransaction();
            //dd($request->id_tienda2);
            $traspaso = new Traspaso();
            $traspaso->fecha=$request->fecha;
            $traspaso->hora=$request->hora;
            $traspaso->glosa=$request->glosa;
            $traspaso->id_tienda1=$request->id_tienda1;
            $traspaso->id_tienda2=$request->id_tienda2 != 100 ? $request->id_tienda2 : null ;
            $traspaso->id_usuario=\Auth::user()->id;
            $traspaso->save();

            $id_tienda1=$request->id_tienda1;
            $id_tienda2=$request->id_tienda2;
            

            $detalles = $request->detalle;
            foreach($detalles as $ep=>$det){
                $obj = new DetalleTraspaso();
                $obj->id_producto= $det['id'];
                $obj->id_traspaso= $traspaso->id;
                $obj->cantidad= $det['stock'];
                $obj->save();

                $this->actualizarStockTienda1($det['id'],$det['stock']);
                
                $id_articulo=$det['id_articulo'];
                $tienda_articulo=DB::select("SELECT id, id_articulo, id_tienda, stock FROM tienda_articulo WHERE id_articulo = $id_articulo and id_tienda = $id_tienda2");

                if($tienda_articulo != []){
                    $tienda_articulo_stock = $tienda_articulo[0]->stock ;
                } else {
                    //
                }
                //dd($request->tienda2);
                //Actualizando Stok Tienda 2
                if($request->id_tienda2 != 100) {
                    if($tienda_articulo != []) {
                        $tienda_articulo = TiendaArticulo::findOrFail($tienda_articulo[0]->id);
                        $tienda_articulo->stock = $tienda_articulo_stock + $det['stock'];
                        $tienda_articulo->save();

                        $datos = [
                            'tabla' => 'tienda_articulo',
                            'codigo_tabla' => $tienda_articulo->id,
                            'transaccion' => 'modificar',
                        ];
                        $this->guardarBitacora($datos);


                    }else{
                        $obj = new TiendaArticulo();
                        $obj->id_articulo= $id_articulo;
                        $obj->id_tienda= $id_tienda2;
                        $obj->stock= $det['stock'];
                        $obj->save();

                        $datos = [
                            'tabla' => 'tienda_articulo',
                            'codigo_tabla' => $obj->id,
                            'transaccion' => 'guardar',
                        ];
                        $this->guardarBitacora($datos);

                    }
                }

                // $obj = new Ajuste();
                // $obj->stock=$det['stock'];
                // $obj->costo_compra=0;
                // $obj->costo_venta=0;
                // $obj->observacion=0;
                // $obj->id_articulo=$det['id_articulo'];
                // $obj->stock_anterior=0;
                // //$obj->stock_anterior=$request->saldoStock;
                // if($request->id_tienda2 == 100){
                //     $obj->id_motivo_ajuste=7;
                // }else{
                //     if($request->id_tienda1 == "1") {
                //         $obj->id_motivo_ajuste=8;
                //     }else{
                //         if($request->tienda2 == "ALMACEN GENERAL"){
                //             $obj->id_motivo_ajuste=9;
                //         }else{
                //             $obj->id_motivo_ajuste=10;
                //         }
                //     }
                // }
                //     $obj->costo_unitario=0;
                //     $obj->save();
            }


            $datos = [
                'tabla' => 'traspaso',
                'codigo_tabla' => $traspaso->id,
                'transaccion' => 'guardar',
            ];
            $this->guardarBitacora($datos);
        
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function detalleTraspaso(Request $request){
        
        $id=$request->id; 
        $obj= DetalleTraspaso::join('traspaso','detalle_traspaso.id_traspaso','=','traspaso.id')
        ->join('tienda_articulo','detalle_traspaso.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->leftjoin('categoria', function($join){
            $join->orOn('articulo.id_categoria','=','categoria.id');
        })
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_traspaso.id_traspaso','detalle_traspaso.cantidad','detalle_traspaso.id_producto',
        'articulo.cod_ean','articulo.nombre','categoria.nombre as categoria',
        'articulo.costo_compra','articulo.costo_venta as costo_unitario','articulo.nombre as articulo',
        'tienda.nombre as tienda','tienda.id as id_tienda')
        ->where('detalle_traspaso.id_traspaso','=',$id)
        ->get();
        return $obj;
    }

    public function pdfTraspaso(Request $request){

        $id = $request->id;
        $foto = $request->foto;
        
        $traspaso = Traspaso::join('users','traspaso.id_usuario','=','users.id')
        ->join('tienda as t1','traspaso.id_tienda1','=','t1.id')
        ->join('tienda as t2','traspaso.id_tienda2','=','t2.id')
        ->select('traspaso.id','traspaso.fecha','traspaso.glosa','t1.nombre as tienda1','t2.nombre as tienda2',
        'users.name')
        ->where('traspaso.id',$id)
        ->orderBy('traspaso.id','desc')->get();

        $detalleCompra= detalleTraspaso::join('traspaso','detalle_traspaso.id_traspaso','=','traspaso.id')
        ->join('tienda_articulo','detalle_traspaso.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->leftjoin('categoria', function($join){
            $join->orOn('articulo.id_categoria','=','categoria.id');
        })
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_traspaso.id_traspaso','detalle_traspaso.cantidad','detalle_traspaso.id_producto',
        'articulo.cod_ean','articulo.nombre as producto','categoria.nombre as categoria',
        'articulo.costo_compra','articulo.costo_venta','articulo.nombre as articulo',
        'tienda.nombre as tienda','tienda.id as id_tienda')
        ->where('detalle_traspaso.id_traspaso','=',$id)
        ->get();

        $usuario = \Auth::user()->name;
        $objdate = new DateTime();
        $fecha_impresion=$objdate->format('d/m/Y');
        $tienda1=$traspaso[0]->tienda1;
        $fecha=$traspaso[0]->fecha;
        $tienda2=$traspaso[0]->tienda2;
        $usuario=$traspaso[0]->name;
        $total=$traspaso[0]->total;
        $detalles=$detalleCompra;

        $cont=Traspaso::count();
        $pdf = \PDF::loadView('pdf.traspaso.traspaso', [
            'id'=>$id,
            'traspaso'=>$traspaso,
            'fecha'=>$fecha,
            'tienda1'=>$tienda1,
            'tienda2'=>$tienda2,
            'detalles'=>$detalles,
            'total'=>$total,
            'foto'=>$foto,
            'fecha_impresion'=>$fecha_impresion,
            'usuario'=>$usuario
        ]);
        return $pdf->setPaper('letter', 'portrait')->stream('Compras.pdf');
    }
    public function pdfTraspaso2(Request $request){

        $var2=DB::select("SELECT  MAX(id) as traspaso from traspaso");
        $id=$var2[0]->traspaso;
        $foto = $request->foto;
        //$empresa_nombre = $request->empresa_nombre;

        $tienda= Tienda::select('tienda.estado')->get();
        $estado=$tienda[0]->estado;

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $traspaso = Traspaso::join('users','traspaso.id_usuario','=','users.id')
        ->join('tienda as t1','traspaso.id_tienda1','=','t1.id')
        ->join('tienda as t2','traspaso.id_tienda2','=','t2.id')
        ->select('traspaso.id','traspaso.fecha','traspaso.glosa','t1.nombre as tienda1','t2.nombre as tienda2',
        'users.name')
        ->where('traspaso.id',$id)
        ->orderBy('traspaso.id','desc')->get();

        $detalleCompra= detalleTraspaso::join('traspaso','detalle_traspaso.id_traspaso','=','traspaso.id')
        ->join('tienda_articulo','detalle_traspaso.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->leftjoin('categoria', function($join){
            $join->orOn('articulo.id_categoria','=','categoria.id');
        })
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_traspaso.id_traspaso','detalle_traspaso.cantidad','detalle_traspaso.id_producto',
        'articulo.cod_ean','articulo.nombre as producto','categoria.nombre as categoria',
        'articulo.costo_compra','articulo.costo_venta','articulo.nombre as articulo',
        'tienda.nombre as tienda','tienda.id as id_tienda')
        ->where('detalle_traspaso.id_traspaso','=',$id)
        ->get();

        $usuario = \Auth::user()->name;
        $objdate = new DateTime();
        $fecha_impresion=$objdate->format('d/m/Y');
        $tienda1=$traspaso[0]->tienda1;
        $fecha=$traspaso[0]->fecha;
        $tienda2=$traspaso[0]->tienda2;
        $usuario=$traspaso[0]->name;
        $total=$traspaso[0]->total;
        $id=$traspaso[0]->id;
        $foto_empresa=$mi_empresa[0]->foto;
        $detalles=$detalleCompra;

        $cont=Traspaso::count();
        $pdf = \PDF::loadView('pdf.traspaso.traspaso', [
            'id'=>$id,
            'traspaso'=>$traspaso,
            'fecha'=>$fecha,
            'tienda1'=>$tienda1,
            'tienda2'=>$tienda2,
            'detalles'=>$detalles,
            'total'=>$total,
            'foto'=>$foto,
            'fecha_impresion'=>$fecha_impresion,
            'usuario'=>$usuario,
            'estado'=>$estado,
            'foto_empresa'=>$foto_empresa,
        ]);
        return $pdf->setPaper('letter', 'portrait')->stream('Traspaso.pdf');
        //return $pdf->setPaper(array(0,0,306.00,396.00), 'portrait')->stream('Traspaso.pdf');
    }
}
