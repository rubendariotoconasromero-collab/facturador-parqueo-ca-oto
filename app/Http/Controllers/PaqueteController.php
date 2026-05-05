<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\DetallePaquete;
use App\Models\DetalleVentaPaquete;
use App\Models\Control;
use App\Models\Articulo;
use App\Http\Controllers\BitacoraController;
use DB;
use DateTime;
use Illuminate\Support\Facades\File;

class PaqueteController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Paquete::select('id','nombre','estado','precio','foto')
            ->orderBy('id','desc')->paginate(15);
        }
        else{
            $obj= Paquete::select('id','nombre','estado','precio','foto')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('id','desc')->paginate(15);            
        }
        return $obj;
    }
    private function actualizarStock($id_producto,$cantVenta){
        DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$id_producto)
        ->where('tienda_articulo.id_tienda','=',1)
        ->decrement('stock', $cantVenta);
    }
    public function guardar(Request $request){
        try{
               
                DB::beginTransaction();

                $paquete = new Paquete();
                $paquete->nombre=$request->nombre;
                $paquete->precio=$request->precio;
                if($request->foto==null){
                    $paquete->foto ='defecto.png';
                }
                else{
                    $explode=explode(',',$request->foto);
                    $decoded=\base64_decode($explode[1]);
                    if(str_contains($explode[0],'jpeg')){
                        $extension='jpg';
                    }
                    else{
                        $extension='png';
                    }
                    $fileName = \str_random().'.'.$extension;
                    $path= 'img/producto'.'/'.$fileName;
                    \file_put_contents($path,$decoded);
                    $paquete->foto=$fileName;   
                }
                $paquete->estado=$request->estado;
                $paquete->save();  
    
                $objdate = new DateTime();
                $fechaactual= $objdate->format('Y-m-d');
                $year = $objdate->format('y');
                $correlativo = $this->correlativoControl();
    
                $control = new control();
                $control->tabla = $request->tabla = "Paquete";
                $control->codigo = $request->codigo = 'PQ-'.strval($correlativo + 1);
                $control->fecha = $fechaactual;
                $control->save();
    
                $detalles = $request->detalle;
                $costo_pago = $request->costo_pago;
                foreach($detalles as $ep=>$det){
                    $obj = new DetallePaquete();
                    $obj->id_paquete= $paquete->id;
                    $obj->id_producto= $det['id_tienda_articulo'];
                    $obj->cantidad= $det['cantidad'];
                    $obj->eliminado= 0;
                    $obj->save();
                        
                    //$this->actualizarStock($det['id_articulo'],$det['cantidad']);

                }

                // $ajuste = new Ajuste();
                // $ajuste->stock=$det['cantidad'];
                // $ajuste->costo_compra=0;
                // if($request->id_costo_pago == 1) {
                //     $ajuste->costo_venta= $det['costo_unitario'];
                // } else if ($request->id_costo_pago == 2) {
                //     $ajuste->costo_venta= $det['costo_mayorista'];
                // } else if ($request->id_costo_pago == 3) {
                //     $ajuste->costo_venta= $det['costo_preferencial'];
                // } else {}
                // $ajuste->observacion=$request->descripcion;
                // $ajuste->id_articulo=$det['id_articulo'];
                // $ajuste->id_motivo_ajuste=6;
                // $ajuste->save();
    
                $datos = [
                    'tabla' => 'paquete',
                    'codigo_tabla' => $paquete->id,
                    'transaccion' => 'guardar paquete',
                ];
                $this->guardarBitacora($datos);   

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function modificar(Request $request){
               
        //dd($request->imagenActual);
        //var_dump($request->imagenActual);
                $paquete = Paquete::findOrFail($request->id);
                $paquete->nombre=$request->nombre;
                $paquete->precio=$request->precio;
                if($request->foto==null){
                    $paquete->foto ='defecto.png';
                }
                else{
                    if($request->imagenActual==$request->foto){
                        $paquete->foto =$request->imagenActual;
                    }
                    else{
                        $explode=explode(',',$request->foto);
                        $decoded=\base64_decode($explode[1]);
                        if(str_contains($explode[0],'jpeg')){
                            $extension='jpg';
                        }
                        else{
                            $extension='png';
                        }
                        $fileName = \str_random().'.'.$extension;
                        $path= 'img/producto'.'/'.$fileName;
                        \file_put_contents($path,$decoded);
                        $paquete->foto=$fileName;   
        
                        if($request->imagenActual!="defecto.png")
                        {
                            $this->delete($request->imagenActual);
                        }
                    }
                }
                $paquete->save();  
    
                $objdate = new DateTime();
                $fechaactual= $objdate->format('Y-m-d');
                $year = $objdate->format('y');
                $correlativo = $this->correlativoControl();
    
                $control = new control();
                $control->tabla = $request->tabla = "Paquete";
                $control->codigo = $request->codigo = 'PQ-'.strval($correlativo + 1);
                $control->fecha = $fechaactual;
                $control->save();

                $eliminar = DetallePaquete::where('detalle_paquete.id_paquete','=',$paquete->id);
                $eliminar->delete();
    
                $detalles = $request->detalle;
                $costo_pago = $request->costo_pago;
                foreach($detalles as $ep=>$det){
                    $obj = new DetallePaquete();
                    $obj->id_paquete= $paquete->id;
                    $obj->id_producto= $det['id_tienda_articulo'];
                    $obj->cantidad= $det['cantidad'];
                    $obj->eliminado= 0;
                    $obj->save();
                        
                    //$this->actualizarStock($det['id_articulo'],$det['cantidad']);

                }
    
                $datos = [
                    'tabla' => 'paquete',
                    'codigo_tabla' => $paquete->id,
                    'transaccion' => 'modificar paquete',
                ];
                $this->guardarBitacora($datos);   

    }   
    public function delete($nombre){
        $obj = File::delete('img/producto/'.$nombre);
    }
    public function obtenerCabecera(Request $request){
        
        $id=$request->id; 
        $obj= Venta::join('proveedor','compra.id_proveedor','=','proveedor.id')
        ->select('compra.id','compra.fecha','compra.descripcion','compra.total','proveedor.nombre as proveedor')
        ->where('compra.id','=',$id)
        ->get();

        return $obj;
    }
    public function detallePaquete(Request $request){

        $id=$request->id; 
        //dd($id);
        $obj= detallePaquete::join('tienda_articulo','detalle_paquete.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->leftjoin('categoria', function($join){
                $join->orOn('articulo.id_categoria','=','categoria.id');
            })
        ->select('detalle_paquete.id_paquete','detalle_paquete.id_producto as id_tienda_articulo','detalle_paquete.id_producto as id_articulo',
        'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.nombre as articulo',
        'detalle_paquete.cantidad','tienda_articulo.stock as stock','tienda.nombre as tienda','tienda.id as id_tienda','categoria.nombre as categoria','articulo.tipo_producto')
        ->where('detalle_paquete.id_paquete','=',$id)
        ->orderBy('categoria.nombre','asc')
        ->orderBy('articulo.nombre','asc')
        ->get();
        return $obj;
        
    }
    public function detalleVentaPaquete(Request $request){

        $id=$request->id; 
        $obj= DetalleVentaPaquete::join('venta','detalle_venta_paquete.id_venta','=','venta.id')
        ->join('paquetes','detalle_venta_paquete.id_paquete','=','paquetes.id')
        ->select('detalle_venta_paquete.id_paquete','detalle_venta_paquete.cantidad','detalle_venta_paquete.costo_venta','detalle_venta_paquete.id_paquete',
        'detalle_venta_paquete.costo_venta','detalle_venta_paquete.sub_total','paquetes.nombre as articulo')
        ->where('detalle_venta_paquete.id_venta','=',$id)
        ->orderBy('paquetes.nombre','asc')
        ->get();
        return $obj;
        
    }
    public function desactivar(Request $request){
        $paquete = Paquete::findOrFail($request->id);
        $paquete->estado = '0';
        $paquete->save();
    }
    public function activar(Request $request){
        $paquete = Paquete::findOrFail($request->id);
        $paquete->estado = '1';
        $paquete->save();
    }
    private function correlativoControl(){
        $mayor = DB::table('control')->where('control.tabla','=','Servicio')->count();
         return $mayor;
    }
    public function listarOrdenSinPaginate(Request $request){
        $buscar = $request->buscar;     
        if ($buscar==''){

            $obj= Paquete::select('id','nombre','precio as total')
            ->where('estado','=',1)
            ->orderBy('id', 'desc')->get();
        }
        else{
            $obj= Paquete::select('nombre','precio as total')
            ->where('paquetes.nombre' , 'like', '%'.$buscar.'%')->get();
        }
        return $obj;
    }
    public function listarSinPaginate(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Paquete::select('id','nombre','fecha_inicio','fecha_final','estado','total','descripcion','sub_total','descuento')
            ->orderBy('id','desc')->get();
        }
        else{
            $obj= Paquete::select('id','nombre','fecha_inicio','fecha_final','estado','total','descripcion','sub_total','descuento')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('articulo.id','desc')->get();            
        }
        return $obj;
    }
    public function pdfVentas(Request $request){

        $id = $request->id;
        $foto = $request->foto;
        
        $venta= Venta::join('users','venta.id_usuario','=','users.id')
        ->join('cliente','venta.id_cliente','=','cliente.id')
        ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
        ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
        ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento',
        'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP')
        ->where('venta.id',$id)
        ->orderBy('venta.id','desc')->get();

        $detalleVenta= detalleVenta::join('tienda_articulo','detalle_venta.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_venta.id_venta','detalle_venta.costo_venta','articulo.costo_unitario as costo_unitario','articulo.costo_mayorista as costo_mayorista','articulo.costo_preferencial as costo_preferencial','articulo.nombre as articulo','detalle_venta.cantidad','detalle_venta.sub_total','tienda.nombre as tienda')
        ->where('detalle_venta.id_venta','=',$id)
        ->get();

        $cliente=$venta[0]->cliente;
        $fecha=$venta[0]->fecha;
        $tipo_pago=$venta[0]->tipoP;
        $forma_pago=$venta[0]->formaP;
        $id_descuento=$venta[0]->id_descuento;
        $detalles=$detalleVenta;
        $total=$venta[0]->total;
        $descuento=$venta[0]->descuento;
        $sub_total=$venta[0]->sub_total;
        if($venta[0]->id_descuento == 1) {
            $descuento_pago= 'Precio Unitario';
        } else if ($venta[0]->id_descuento == 2) {
            $descuento_pago= 'Precio Mayorista';
        } else if ($venta[0]->id_descuento == 3) {
            $descuento_pago=  'Precio Preferencial';
        } else {}

        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.venta.venta', [
            'ventas'=>$venta,
            'fecha'=>$fecha,
            'cliente'=>$cliente,
            'tipo_pago'=>$tipo_pago,
            'forma_pago'=>$forma_pago,
            'descuento_pago'=>$descuento_pago,
            'id_descuento' =>$id_descuento,
            'detalles'=>$detalles,
            'total'=>$total,
            'descuento'=>$descuento,
            'sub_total'=>$sub_total,
            'foto'=>$foto
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfOrdenServiciosGeneral(Request $request){

        $id = $request->id;
        $foto = $request->foto;
        
        $orden_servicio= OrdenServicio::join('users','orden_servicio.id_usuario','=','users.id')
        ->join('cliente','orden_servicio.id_cliente','=','cliente.id')
        ->select('orden_servicio.id','orden_servicio.fecha','orden_servicio.sub_total','orden_servicio.descuento',
        'orden_servicio.total','orden_servicio.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento')
        ->where('orden_servicio.id',$id)
        ->orderBy('orden_servicio.id','desc')->get();

        $detalleOrdenServicio= detalleOrdenServicio::join('tienda_articulo','detalle_orden_servicio.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_orden_servicio.id_orden_servicio','articulo.costo_unitario as costo_unitario','articulo.costo_mayorista as costo_mayorista','articulo.costo_preferencial as costo_preferencial','articulo.nombre as articulo','detalle_orden_servicio.cantidad','detalle_orden_servicio.sub_total','tienda.nombre as tienda')
        ->where('detalle_orden_servicio.id_orden_servicio','=',$id)
        ->get();

        $usuario = \Auth::user()->name;
        $objdate = new DateTime();
        $fecha_impresion=$objdate->format('d/m/Y');
        $cliente=$orden_servicio[0]->cliente;
        $fecha=$orden_servicio[0]->fecha;
        $id_descuento=$orden_servicio[0]->id_descuento;
        $detalles=$detalleOrdenServicio;
        $total=$orden_servicio[0]->total;
        $descuento=$orden_servicio[0]->descuento;
        $sub_total=$orden_servicio[0]->sub_total;
        if($orden_servicio[0]->id_descuento == 1) {
            $descuento_pago= 'Precio Unitario';
        } else if ($orden_servicio[0]->id_descuento == 2) {
            $descuento_pago= 'Precio Mayorista';
        } else if ($orden_servicio[0]->id_descuento == 3) {
            $descuento_pago=  'Precio Preferencial';
        } else {}

        $cont=OrdenServicio::count();
        $pdf = \PDF::loadView('pdf.orden_servicio.orden-servicio-general', [
            'orden_servicios'=>$orden_servicio,
            'fecha'=>$fecha,
            'cliente'=>$cliente,
            'descuento_pago'=>$descuento_pago,
            'id_descuento' =>$id_descuento,
            'detalles'=>$detalles,
            'total'=>$total,
            'descuento'=>$descuento,
            'sub_total'=>$sub_total,
            'foto'=>$foto,
            'fecha_impresion'=>$fecha_impresion,
            'usuario'=>$usuario
        ]);
        return $pdf->stream('OrdenServicio.pdf');
    }
    public function listarPaquete(Request $request){
        //$id_categoria = $request->id_categoria;
        //dd($id_categoria);
        $data = Paquete::select('id','nombre as descripcion','precio','foto')
        // ->where('id_categoria','=',$id_categoria)
        ->where('estado','=',1)
        //->where('Producto.Combo', '=', 0)
        ->get();     
        return $data;


        return $obj;
    }
    public function listarDetalleCombo(Request $request){
        $id_combo = $request->id;
       // dd($id_combo);
        $data = DetallePaquete::join('tienda_articulo','detalle_paquete.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->select('articulo.id as Id_Producto','articulo.nombre as descripcion','articulo.costo_unitario as precio','articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','detalle_paquete.cantidad as Cantidad')
        ->where('detalle_paquete.id_paquete','=',$id_combo)
        ->get();     
        return $data;
    }
    public function detalleVentaPaqueteMesero(Request $request){

        $id=$request->id; 
        //dd($id);
    //     $obj= DetallePaquete::join('paquetes','detalle_paquete.id_paquete','=','paquetes.id')
    //     ->join('tienda_articulo','detalle_paquete.id_producto','=','tienda_articulo.id')
    //     ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
    //     ->select('detalle_paquete.id_paquete','detalle_paquete.cantidad','articulo.nombre as producto','tienda_articulo.stock','articulo.foto','articulo.eliminado')
    //     ->where('detalle_paquete.id_paquete','=',$id)
    //    // ->orderBy('paquetes.nombre','asc')
    //     ->get();


        $obj= DetalleVentaPaquete::join('venta','detalle_venta_paquete.id_venta','=','venta.id')
        ->join('paquetes','detalle_venta_paquete.id_paquete','=','paquetes.id')
        ->select('detalle_venta_paquete.id_paquete','detalle_venta_paquete.cantidad','detalle_venta_paquete.costo_venta as precio','detalle_venta_paquete.id_paquete',
        'detalle_venta_paquete.costo_venta','detalle_venta_paquete.sub_total as preciov','paquetes.nombre as producto')
        ->where('detalle_venta_paquete.id_venta','=',$id)
        ->orderBy('paquetes.nombre','asc')
        ->get();
        return $obj;
        
    }
}
