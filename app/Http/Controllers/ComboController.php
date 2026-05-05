<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Combo;
use App\Models\Articulo;
use App\Models\Tienda;
use App\Models\TiendaArticulo;
use App\Models\DetalleCombo;
use Illuminate\Support\Facades\File;
use DB;
use DateTime;

class ComboController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Combo::join('articulo','combo.id_articulo','=','articulo.id')
            ->select('combo.id','combo.id_articulo','combo.nombre','combo.estado','articulo.costo_venta as precio','articulo.foto', )
            ->orderBy('id','desc')->paginate(15);
        }
        else{
            $obj= Combo::join('articulo','combo.id_articulo','=','articulo.id')
            ->select('combo.id','combo.id_articulo','combo.nombre','combo.estado','articulo.costo_venta as precio','articulo.foto')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('id','desc')->paginate(15);            
        }
        return $obj;
    }
    public function guardar(Request $request){
        try{
               
                DB::beginTransaction();

                $combo = new Combo();
                $combo->nombre=$request->nombre;
                $combo->id_articulo=$request->id_articulo;
                $combo->id_tienda=2;
                $combo->estado=$request->estado;
                $combo->save();
                
                $obj= Articulo::findOrFail($request->id_articulo);
                $obj->costo_venta=$request->precio;                
                $obj->combo=0;                
                if($request->foto==null){
                    $obj->foto ='defecto.png';
                }
                else{
                    if($request->imagenActual==$request->foto){
                        $obj->foto =$request->imagenActual;
                    }
                    else{
                        //dd($request->foto);
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
                        $obj->foto=$fileName;  
                        
                        if($request->imagenActual!="defecto.png")
                        {
                            $this->delete($request->imagenActual);
                        }
                    }
                }
                $obj->save();
    
                $detalles = $request->detalle;
                $costo_pago = $request->costo_pago;
                foreach($detalles as $ep=>$det){
                    $obj = new DetalleCombo();
                    $obj->id_combo= $combo->id;
                    $obj->id_articulo= $det['id_articulo'];
                    $obj->cantidad= $det['cantidad'];
                    $obj->estado= 1;
                    $obj->save();
                }
                $datos = [
                    'tabla' => 'combo',
                    'codigo_tabla' => $combo->id,
                    'transaccion' => 'guardar combo',
                ];
                $this->guardarBitacora($datos);   

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function delete($nombre){
        $obj = File::delete('img/producto/'.$nombre);
    }
    public function combo(Request $request){
 
        $id_articulo = $request->id_articulo;
        //dd($id_articulo);
        $obj= Combo::join('articulo','combo.id_articulo','=','articulo.id')
        ->select('combo.id','combo.id_articulo','combo.nombre','combo.estado','articulo.costo_venta as precio','articulo.foto')
        ->where('combo.estado','=',1)
        ->where('combo.id_articulo','=',$id_articulo)
        ->get();
        return $obj;


    }
    public function detalleCombo(Request $request){

        $id=$request->id; 
        //dd($id);
        $obj= DetalleCombo::join('articulo','detalle_combo.id_articulo','=','articulo.id')
        ->join('combo','detalle_combo.id_combo','=','combo.id')
        ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
        ->select('detalle_combo.id_combo','detalle_combo.id as id_tienda_articulo','detalle_combo.id_articulo as id_articulo',
        'detalle_combo.cantidad','detalle_combo.estado','articulo.nombre as articulo','articulo.costo_venta as costo_unitario')
        ->where('detalle_combo.estado','=',1)
        ->where('detalle_combo.id_combo','=',$id)
        ->where('tienda_articulo.id_tienda', 2)
        ->orderBy('articulo.nombre','asc')
        ->get();
        return $obj;
        
    }
    public function detalleComboP(Request $request){
        $id=$request->id; 
        //$id=$request->id; 
        //dd($id);
        $obj= DetalleCombo::join('articulo','detalle_combo.id_articulo','=','articulo.id')
        //->join('combo','detalle_combo.id_combo','=','combo.id')
        ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
        ->select('detalle_combo.id_combo','detalle_combo.id as id_tienda_articulo','detalle_combo.id_articulo as id_articulo',
        'detalle_combo.cantidad','detalle_combo.estado','articulo.nombre as articulo','articulo.costo_venta as costo_unitario')
        ->where('detalle_combo.estado','=',1)
        ->where('detalle_combo.id_combo','=',$id)
        ->where('tienda_articulo.id_tienda', '=', 2)
        //->where('combo.id_tienda', '=', 2)
        ->orderBy('articulo.nombre','asc')
        
        ->get();
        return $obj;
        
        
    }
    public function modificar(Request $request){
        $articulo= Articulo::findOrFail($request->id_articulo);
        $articulo->costo_venta=$request->precio;                
        if($request->foto==null){
            $articulo->foto ='defecto.png';
        }
        else{
            if($request->imagenActual==$request->foto){
                $articulo->foto =$request->imagenActual;
            }
            else{
                //dd($request->foto);
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
                $articulo->foto=$fileName;  
                
                if($request->imagenActual!="defecto.png")
                {
                    $this->delete($request->imagenActual);
                }
            }
        }

            $eliminar = DetalleCombo::where('detalle_combo.id_combo','=',$request->id);
            $eliminar->delete();

            $detalles = $request->detalle;
            $costo_pago = $request->costo_pago;
            foreach($detalles as $ep=>$det){
                $obj = new DetalleCombo();
                $obj->id_combo= $request->id;
                $obj->id_articulo= $det['id_articulo'];
                $obj->cantidad= $det['cantidad'];
                $obj->estado= 1;
                $obj->save();
                
                //dd();
                
                $articulo->save();

            }
            

            $datos = [
                'tabla' => 'paquete',
                'codigo_tabla' => $request->id,
                'transaccion' => 'modificar paquete',
            ];
            $this->guardarBitacora($datos);   

    } 
    public function desactivar(Request $request){
        $paquete = Combo::findOrFail($request->id);
        $producto_paquete = Combo::join('articulo', 'combo.id_articulo', '=', 'articulo.id')
        ->join('tienda_articulo', 'tienda_articulo.id_articulo', '=', 'articulo.id')
        ->join('tienda', 'tienda_articulo.id_tienda', '=', 'tienda.id')
        ->select('articulo.estado', 'articulo.id')
        ->where('combo.id', '=', $request->id)
        ->where('tienda.id', '=', 2)
        ->first();
        //dd($producto_paquete->estado);
        //dd($producto_paquete->id);
        
        $producto = Articulo::findOrFail($producto_paquete->id);
        $producto->estado=0;
        $producto->save();
       
        $paquete->estado = '0';
        $paquete->save();
    }
    public function activar(Request $request){
        $producto_paquete = Combo::join('articulo', 'combo.id_articulo', '=', 'articulo.id')
        ->join('tienda_articulo', 'tienda_articulo.id_articulo', '=', 'articulo.id')
        ->join('tienda', 'tienda_articulo.id_tienda', '=', 'tienda.id')
        ->select('articulo.estado', 'articulo.id')
        ->where('combo.id', '=', $request->id)
        ->where('tienda.id', '=', 2)
        ->first();
        //dd($producto_paquete->estado);
        //dd($producto_paquete->id);
        
        $producto = Articulo::findOrFail($producto_paquete->id);
        $producto->estado=1;
        $producto->save();

        $paquete = Combo::findOrFail($request->id);
        $paquete->estado = '1';
        $paquete->save();
    }  

    public function index2(Request $request){
        $id = $request->id;
        //dd($id);
        $combo = Combo::select('id','nombre as Nombre','id_articulo as id_producto')
        ->whereNotIn('id', [0])
        ->where('estado','=',1)
        ->where('id_articulo','=',$id )
        ->get();

        return $combo;
    }

    /*public function detalleCombo2(Request $request){
        $id = $request->id;
        //dd($id);
        $combo = DB::table('detalle_combo as dv')
        ->join('articulo as p','dv.id_articulo','=','p.id')
        ->join('tienda_articulo as t','p.id','=','t.id_articulo')
       // ->join('Producto as p','dv.Id_Receta','=','r.Id_Receta')
        ->select('dv.id_combo','dv.id_articulo as id_producto','dv.cantidad',
        'p.costo_venta as precio','p.costo_venta as preciov','t.stock','p.foto','dv.estado','p.id_tipo_producto','p.id_producto_compuesto',
        'p.contenido_presentacion','p.nombre as articulo',DB::raw('COUNT(dv.id_combo) as cont'))
        ->where('dv.id_combo','=',$id)
        ->where('dv.estado','=','1')
        ->groupBy('dv.id_combo','dv.id_articulo','dv.cantidad',
        'p.costo_venta','p.costo_venta','t.stock','p.foto','dv.estado','p.id_tipo_producto','p.id_producto_compuesto',
        'p.contenido_presentacion','p.nombre')
        ->get();
        //dd($combo);
        return $combo;

        
    }*/
    public function detalleCombo2(Request $request){
        $id = $request->id;
        //dd($id);
        $combo = DB::table('detalle_combo as dv')
        ->join('tienda_articulo as t','dv.id_articulo','=','t.id_articulo')
        ->join('articulo as p','t.id_articulo','=','p.id')
       
       // ->join('Producto as p','dv.Id_Receta','=','r.Id_Receta')
        ->select('dv.id_combo','dv.id_articulo as id_producto','dv.cantidad',
        'p.costo_venta as precio','p.costo_venta as preciov','t.stock','p.foto','dv.estado',
        'p.id_tipo_producto','p.id_producto_compuesto', 't.id_tienda','t.id_articulo',
        'p.contenido_presentacion','p.nombre as articulo',DB::raw('COUNT(dv.id_combo) as cont'))
        ->where('dv.id_combo','=',$id)
        ->where('dv.estado','=','1')
        ->where('t.id_tienda', '=', '2')
        ->groupBy('dv.id_combo','dv.id_articulo','dv.cantidad',
        'p.costo_venta','p.costo_venta','t.stock','p.foto','dv.estado','p.id_tipo_producto',
        'p.contenido_presentacion','p.nombre', 't.id_tienda')
        ->get();
        //dd($id, $combo);
        return $combo;
    }
}
