<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ajuste;
use App\Models\MotivoAjuste;
use App\Http\Requests\AjusteRequest;
use DB;

class AjusteController extends BitacoraController
{
    public function guardarAjuste($datos=[])
    {
        
        $obj = new Ajuste();
        $obj->stock = $datos['stock'];
        $obj->costo_compra = $datos['costo_compra'];
        $obj->costo_venta = $datos['costo_venta'];
        $obj->observacion = $datos['observacion'];
        $obj->id_articulo = $datos['id_articulo'];
        $obj->id_motivo_ajuste = $datos['id_motivo_ajuste'];
        $obj->save();

    }

    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Ajuste::join('articulo','ajuste.id_articulo','=','articulo.id')
            ->join('motivo_ajuste','ajuste.id_motivo_ajuste','=','motivo_ajuste.id')
            ->join('categoria','categoria.id','=','articulo.id_categoria')
            ->select('ajuste.id','ajuste.id_articulo','ajuste.id_motivo_ajuste','motivo_ajuste.nombre as motivo_ajuste','ajuste.costo_compra','ajuste.costo_venta',
            'ajuste.observacion','articulo.nombre as articulo',
            'articulo.id_categoria','categoria.nombre as categoria',DB::raw('ajuste.stock / articulo.contenido_presentacion as stock')
            ,DB::raw('ajuste.stock_anterior / articulo.contenido_presentacion as stock_anterior'),DB::raw('ajuste.stock_actual / articulo.contenido_presentacion as stock_actual'))
            ->orderBy('ajuste.id','desc')->paginate(15);    
        }
        else{
            $obj= Ajuste::join('articulo','ajuste.id_articulo','=','articulo.id')
            ->join('motivo_ajuste','ajuste.id_motivo_ajuste','=','motivo_ajuste.id')
            ->join('categoria','categoria.id','=','articulo.id_categoria')
            ->select('ajuste.id','ajuste.id_articulo','ajuste.id_motivo_ajuste','motivo_ajuste.nombre as motivo_ajuste','ajuste.costo_compra','ajuste.costo_venta',
            'ajuste.observacion','articulo.nombre as articulo',
            'articulo.id_categoria','categoria.nombre as categoria',DB::raw('ajuste.stock / articulo.contenido_presentacion as stock')
            ,DB::raw('ajuste.stock_anterior / articulo.contenido_presentacion as stock_anterior'),DB::raw('ajuste.stock_actual / articulo.contenido_presentacion as stock_actual'))
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('ajuste.id','desc')->paginate(15);            
        }
        return $obj;
    }

    public function guardar(Request $request){
        try{
            DB::beginTransaction();
            $detalles = $request->detalle;
            //dd($request->detalle);
            foreach($detalles as $ep=>$det){
                $obj = new Ajuste();
                $obj->stock=($det['stock']*$det['contenido_presentacion']);
                $obj->costo_compra=$det['costo_compra'];
                $obj->costo_venta=$det['costo_venta'] ? $det['costo_venta'] : 0;
                $obj->observacion=$det['observacion'];
                $obj->id_articulo=$det['id_articulo'];
                $obj->stock_anterior=$det['saldoStock'];
                if($request->id_motivo_ajuste == 1) {
                    $obj->stock_actual=($det['stock']*$det['contenido_presentacion']);
                }else if($request->id_motivo_ajuste == 2){
                    $obj->stock_actual=($det['stock']*$det['contenido_presentacion']) + $det['saldoStock'];
                }else if($request->id_motivo_ajuste == 3){
                    $obj->stock_actual=$det['saldoStock']-($det['stock']*$det['contenido_presentacion']);      
                    //dd($obj->stock_actual);      
                }else{
                    $obj->stock_actual=$det['saldoStock'];
                }
                $obj->id_motivo_ajuste=$request->id_motivo_ajuste;
                $obj->save();
                if( $obj->id_motivo_ajuste == 1){
                    $affected = DB::table('tienda_articulo')
                    ->where('id_tienda',$det['id_tienda'])
                    ->where('id_articulo', $obj->id_articulo)
                    ->update(['stock' => $obj->stock]); 
                }else {
                    if( $obj->id_motivo_ajuste == 2){ 
                        DB::table('tienda_articulo')->where('tienda_articulo.id_tienda',$det['id_tienda'])->where('tienda_articulo.id_articulo','=',$det['id_articulo'])->increment('stock', $obj->stock);
                    }else 
                    {                
                    if( $obj->id_motivo_ajuste == 3){
                        DB::table('tienda_articulo')->where('tienda_articulo.id_tienda',$det['id_tienda'])->where('tienda_articulo.id_articulo','=',$det['id_articulo'])->decrement('stock',  $obj->stock);
                    }else 
                    {
                        if( $obj->id_motivo_ajuste == 4){
                            $affected = DB::table('articulo')
                            ->where('id', $det['id_articulo'])
                            ->update(['costo_compra' => $det['costo_compra']]); 
                            //DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det['id_articulo'])->decrement('stock', 'tienda_articulo.stock'-$det['stock']);
                        }else 
                        {
                            if( $obj->id_motivo_ajuste == 5){
                                $affected = DB::table('articulo')
                                ->where('id', $det['id_articulo'])
                                ->update(['costo_venta' => $det['costo_venta']]); 
                            }else 
                            {
                                //
                                //
                            }
                        }
                    }
                }
            }
        }
            $datos = [
                'tabla' => 'ajuste',
                'codigo_tabla' => $obj->id,
                'transaccion' => 'guardar',
            ];
            $this->guardarBitacora($datos);
            
            DB::commit();
            return[
                'id'=>$obj->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function selectMotivo(){  
        $obj = MotivoAjuste::select('id', 'nombre')->whereIn('id',[1,2,3])->orderBy('motivo_ajuste.id','asc')->get(); 
        return $obj;
    }

    public function cantidadRegistros(){
        $cantidad = DB::table('ajuste')->count();

        $data=['nro' =>$cantidad];
        return $data;
    }
}
