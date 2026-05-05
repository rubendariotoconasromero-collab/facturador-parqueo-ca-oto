<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Ajuste;
use App\Models\TipoProducto;
use App\Models\TiendaArticulo;
use App\Models\Combo;
use App\Http\Requests\ArticuloRequest;
use App\Models\Control;
use DB;
use DateTime;
use Illuminate\Support\Facades\File;

class ArticuloController extends BitacoraController
{
    public function index(Request $request){
        $id_tienda = $request->id_tienda;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('tipo_producto','articulo.id_tipo_producto','=','tipo_producto.id')
            ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id','articulo.cod_ean','articulo.nombre','articulo.costo_venta','articulo.costo_compra'
            ,'articulo.observacion','articulo.id_categoria','articulo.menu_dia','tipo_producto.id as id_tipo_producto','articulo.id_producto_compuesto',
            'categoria.nombre as categoria','articulo.estado','articulo.foto','tipo_producto.nombre as tipo','articulo.impresion',
            'articulo.contenido_presentacion','articulo.stock_minimo',DB::raw('tienda_articulo.stock / articulo.contenido_presentacion as stock_actual'),'articulo.id_tienda','articulo.id_proveedor','articulo.id_unidad')
            ->where('categoria.estado', 1)
            //->where('articulo.id_tienda', $id_tienda)
            ->orderBy('articulo.id','desc')
            ->GroupBY('articulo.id')
            ->paginate(15);
        }
        else{
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('tipo_producto','articulo.id_tipo_producto','=','tipo_producto.id')
            ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id','articulo.cod_ean','articulo.nombre','articulo.costo_venta','articulo.costo_compra'
            ,'articulo.observacion','articulo.id_categoria','articulo.menu_dia','tipo_producto.id as id_tipo_producto','articulo.id_producto_compuesto',
            'categoria.nombre as categoria','articulo.estado','articulo.foto','tipo_producto.nombre as tipo','articulo.impresion',
            'articulo.contenido_presentacion','articulo.stock_minimo',DB::raw('tienda_articulo.stock / articulo.contenido_presentacion as stock_actual'),'articulo.id_tienda','articulo.id_proveedor','articulo.id_unidad')
            ->where('categoria.estado', 1)
            ->where($criterio, 'like', '%'.$buscar.'%')
            //->where('articulo.id_tienda', $id_tienda)
            ->orderBy('articulo.id','desc')
            ->GroupBY('articulo.id')
            ->paginate(15);            
        }
        return $obj;
    }
    public function index1(Request $request){

            $nombre = $request->nombre;
            if($nombre==''){
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('unidad_medida','articulo.id_unidad','=','unidad_medida.id')
            ->join('tipo_producto','articulo.id_tipo_producto','=','tipo_producto.id')
            ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id','articulo.cod_ean','articulo.nombre','articulo.costo_venta','articulo.costo_compra'
            ,'articulo.observacion','articulo.id_categoria','unidad_medida.id as id_unidad','articulo.menu_dia','tipo_producto.id as id_tipo_producto','articulo.id_producto_compuesto',
            'categoria.nombre as categoria','articulo.estado','articulo.foto','unidad_medida.nombre as unidad','tipo_producto.nombre as tipo','articulo.impresion',
            'articulo.contenido_presentacion','articulo.stock_minimo',DB::raw('tienda_articulo.stock / articulo.contenido_presentacion as stock_actual'))
            // ->where('articulo.tipo', 'Bebidas')
            // ->where('articulo.nombre','=',$nombre)
            ->where('articulo.menu_dia', 0)
            ->orderBy('articulo.id','desc')->get();
            }else{
                $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
                ->join('unidad_medida','articulo.id_unidad','=','unidad_medida.id')
                ->join('tipo_producto','articulo.id_tipo_producto','=','tipo_producto.id')
                ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
                ->select('articulo.id','articulo.cod_ean','articulo.nombre','articulo.costo_venta','articulo.costo_compra'
                ,'articulo.observacion','articulo.id_categoria','unidad_medida.id as id_unidad','articulo.menu_dia','tipo_producto.id as id_tipo_producto','articulo.id_producto_compuesto',
                'categoria.nombre as categoria','articulo.estado','articulo.foto','unidad_medida.nombre as unidad','tipo_producto.nombre as tipo','articulo.impresion',
                'articulo.contenido_presentacion','articulo.stock_minimo',DB::raw('tienda_articulo.stock / articulo.contenido_presentacion as stock_actual'))
                // ->where('articulo.tipo', 'Bebidas')
                // ->where('articulo.nombre','=',$nombre)
                ->where('articulo.nombre', 'like', '%'.$nombre.'%')
                ->where('articulo.menu_dia', 0)
                ->orderBy('articulo.id','desc')->get();
            }
        return $obj;
    }
    public function index3(Request $request){
       
        $nombre1 = $request->nombre1;
            if($nombre1==''){
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('unidad_medida','articulo.id_unidad','=','unidad_medida.id')
            ->join('tipo_producto','articulo.id_tipo_producto','=','tipo_producto.id')
            ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id','articulo.cod_ean','articulo.nombre','articulo.costo_venta','articulo.costo_compra'
            ,'articulo.observacion','articulo.id_categoria','unidad_medida.id as id_unidad','articulo.menu_dia','tipo_producto.id as id_tipo_producto','articulo.id_producto_compuesto',
            'categoria.nombre as categoria','articulo.estado','articulo.foto','unidad_medida.nombre as unidad','tipo_producto.nombre as tipo','articulo.impresion',
            'articulo.contenido_presentacion','articulo.stock_minimo',DB::raw('tienda_articulo.stock / articulo.contenido_presentacion as stock_actual'))
            // ->where('articulo.tipo', 'Bebidas')
            // ->where('articulo.nombre','=',$nombre)
            ->where('articulo.menu_dia','!=', 0)
            ->orderBy('articulo.id','desc')->get();
            }else{
                $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
                ->join('unidad_medida','articulo.id_unidad','=','unidad_medida.id')
                ->join('tipo_producto','articulo.id_tipo_producto','=','tipo_producto.id')
                ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
                ->select('articulo.id','articulo.cod_ean','articulo.nombre','articulo.costo_venta','articulo.costo_compra'
                ,'articulo.observacion','articulo.id_categoria','unidad_medida.id as id_unidad','articulo.menu_dia','tipo_producto.id as id_tipo_producto','articulo.id_producto_compuesto',
                'categoria.nombre as categoria','articulo.estado','articulo.foto','unidad_medida.nombre as unidad','tipo_producto.nombre as tipo','articulo.impresion',
                'articulo.contenido_presentacion','articulo.stock_minimo',DB::raw('tienda_articulo.stock / articulo.contenido_presentacion as stock_actual'))
                // ->where('articulo.tipo', 'Bebidas')
                // ->where('articulo.nombre','=',$nombre)
                ->where('articulo.nombre', 'like', '%'.$nombre1.'%')
                ->where('articulo.menu_dia','!=',0)
                ->orderBy('articulo.id','desc')->get();
            }
   
             return $obj;
        }
    // public function indexComida(Request $request){
    //     $buscar = $request->buscar;
    //     $criterio = $request->criterio;
    //     if($buscar==''){
    //         $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
    //         ->select('articulo.id','articulo.cod_ean','articulo.nombre','articulo.costo_unitario','articulo.costo_compra'
    //         ,'articulo.costo_mayorista','articulo.costo_preferencial','articulo.observacion','articulo.id_categoria',
    //         'categoria.nombre as categoria','articulo.estado','articulo.foto','articulo.tipo')
    //         ->where('articulo.tipo_producto', 'Producto Venta')
    //         ->where('articulo.tipo', 'Comidas')
    //         ->where('categoria.estado', 1)
    //         ->orderBy('articulo.id','desc')->paginate(15);
    //     }
    //     else{
    //         $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
    //         ->select('articulo.id','articulo.cod_ean','articulo.nombre','articulo.costo_unitario','articulo.costo_compra'
    //         ,'articulo.costo_mayorista','articulo.costo_preferencial','articulo.observacion','articulo.id_categoria',
    //         'categoria.nombre as categoria','articulo.estado','articulo.foto','articulo.tipo')
    //         ->where('articulo.tipo_producto', 'Producto Venta')
    //         ->where('articulo.tipo', 'Comidas')
    //         ->where('categoria.estado', 1)
    //         ->where($criterio, 'like', '%'.$buscar.'%')
    //         ->orderBy('articulo.id','desc')->paginate(15);            
    //     }
    //     return $obj;
    // }
    public function listarSinPaginate(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
             ->join('tienda_articulo','articulo.id','=','tienda_articulo.id')
            ->select('articulo.id','articulo.cod_producto','articulo.cod_proveedor','articulo.cod_ean','articulo.nombre_comercial','articulo.marca','articulo.costo_compra'
            ,'articulo.costo_unitario','articulo.costo_mayorista','articulo.menu_dia','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','tienda_articulo.id_articulo')
            ->orderBy('articulo.id','desc')->get();
        }
        else{
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('tienda_articulo','articulo.id','=','tienda_articulo.id')
            ->select('articulo.id','articulo.cod_producto','articulo.cod_proveedor','articulo.cod_ean','articulo.nombre_comercial','articulo.marca','articulo.costo_compra'
            ,'articulo.costo_unitario','articulo.costo_mayorista','articulo.menu_dia','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','tienda_articulo.id_articulo')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('articulo.id','desc')->get();            
        }
        return $obj;
    }
    public function index2(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id','articulo.cod_producto','articulo.cod_proveedor','articulo.nombre_comercial','articulo.nombre_generico','articulo.costo_unitario'
            ,'articulo.costo_mayorista','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','categoria.nombre as categoria')
            ->where('articulo.tipo_producto', 'Producto Servicio')
            ->where('categoria.estado', 1)
            ->orderBy('articulo.id','desc')->paginate(15);
        }
        else{
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id','articulo.cod_producto','articulo.cod_proveedor','articulo.nombre_comercial','articulo.nombre_generico','articulo.costo_unitario'
            ,'articulo.costo_mayorista','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','categoria.nombre as categoria')
            ->where('articulo.tipo_producto', 'Producto Servicio')
            ->where('categoria.estado', 1)
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('articulo.id','desc')->paginate(15);            
        }
        return $obj;
    }
    public function listarSinPaginate2(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
             ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id as id_articulo','articulo.cod_producto','articulo.cod_proveedor','articulo.cod_ean','articulo.nombre_comercial as articulo','articulo.marca','articulo.costo_compra'
            ,'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','tienda_articulo.id_articulo','tienda_articulo.stock','tienda_articulo.id as id_tienda_articulo')
            ->where('tienda_articulo.id_tienda','=',1 )
            ->orderBy('articulo.id','desc')->get();
        }
        else{
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id as id_articulo','articulo.cod_producto','articulo.cod_proveedor','articulo.cod_ean','articulo.nombre_comercial as articulo','articulo.marca','articulo.costo_compra'
            ,'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','tienda_articulo.id_articulo','tienda_articulo.stock','tienda_articulo.id as id_tienda_articulo')
            ->where('tienda_articulo.id_tienda','!=',1)
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('articulo.id','desc')->get();            
        }
        return $obj;
    }
    public function listarSinPaginate2Producto(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
             ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id as id_articulo','articulo.cod_producto','articulo.cod_proveedor','articulo.cod_ean','articulo.nombre','articulo.marca','articulo.costo_compra'
            ,'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','tienda_articulo.id_articulo','tienda_articulo.stock','tienda_articulo.id as id_tienda_articulo')
            ->where('tienda_articulo.id_tienda','=',1 )
            ->where('articulo.tipo_producto','=','Producto Venta')
            ->orderBy('articulo.id','desc')->get();
        }
        else{
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id as id_articulo','articulo.cod_producto','articulo.cod_proveedor','articulo.cod_ean','articulo.nombre','articulo.marca','articulo.costo_compra'
            ,'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','tienda_articulo.id_articulo','tienda_articulo.stock','tienda_articulo.id as id_tienda_articulo')
            ->where('tienda_articulo.id_tienda','=',1)
            ->where('articulo.tipo_producto','=','Producto Venta')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('articulo.id','desc')->get();            
        }
        return $obj;
    }
    public function listarSinPaginate2Servicio(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
             ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id as id_articulo','articulo.cod_producto','articulo.cod_proveedor','articulo.cod_ean','articulo.nombre','articulo.marca','articulo.costo_compra'
            ,'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','tienda_articulo.id_articulo','tienda_articulo.stock','tienda_articulo.id as id_tienda_articulo')
            ->where('tienda_articulo.id_tienda','=',1 )
            ->where('articulo.tipo_producto','=','Producto Servicio')
            ->orderBy('articulo.id','desc')->get();
        }
        else{
            $obj= Articulo::join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('tienda_articulo','articulo.id','=','tienda_articulo.id_articulo')
            ->select('articulo.id as id_articulo','articulo.cod_producto','articulo.cod_proveedor','articulo.cod_ean','articulo.nombre','articulo.marca','articulo.costo_compra'
            ,'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.stock_minimo','articulo.tipo_producto','articulo.descripcion','articulo.id_categoria',
            'categoria.nombre as categoria','articulo.estado','tienda_articulo.id_articulo','tienda_articulo.stock','tienda_articulo.id as id_tienda_articulo')
            ->where('tienda_articulo.id_tienda','=',1)
            ->where('articulo.tipo_producto','=','Producto Servicio')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('articulo.id','desc')->get();            
        }
        return $obj;
    }
    public function guardar(Request $request){
        // try{

        /*if (Articulo::where('nombre', $request->nombre)
            ->where('id_categoria', $request->id_categoria)->first()){
            return ['error'=>0];
        }
        else{
                $id_tienda=\Auth::user()->id_tienda;
                $correlativo = DB::table('articulo')->select()->max('id');

                DB::beginTransaction();
                $obj = new Articulo();
                $obj->nombre=$request->nombre;
                $obj->cod_ean=$request->cod_ean;
                $obj->contenido_presentacion = $request->contenido_presentacion == '' || $request->contenido_presentacion == '0'  ? '1' : $request->contenido_presentacion;
                $obj->costo_compra=empty($request->costo_compra)?0:$request->costo_compra;
                $obj->costo_venta=empty($request->costo_venta)?0:$request->costo_venta;                
                $obj->estado=$request->estado;
                $obj->impresion=0;        
                $obj->stock_minimo=$request->stock_minimo;
                if($id_tienda == 100){
                    $obj->id_tienda=$request->id_tienda;
                }else{
                    $obj->id_tienda=$id_tienda;
                }
                $obj->receta=0;
                if($request->id_tipo_producto==5)
                {
                    $obj->combo=1;
                }
                $obj->id_categoria=$request->id_categoria;
                $obj->id_proveedor=$request->id_proveedor;
                //$obj->id_unidad=$request->id_unidad;
                $obj->id_unidad = $request->id_unidad == '' ? '1' : $request->id_unidad;
                $obj->id_tipo_producto=$request->id_tipo_producto;
                $obj->id_producto_compuesto = $request->id_producto_compuesto == '' ? '0' : $request->id_producto_compuesto;
                $obj->observacion=$request->descripcion;
                if($request->foto==null){
                    $obj->foto ='defecto.png';
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
                    $obj->foto=$fileName;   
                }
                $obj->save();

                //AGREGAR CODIGO DE VENTA

                if($request->tipo_producto == 'Producto Venta') {
                    $correlativo = 0;
                    $objdate = new DateTime();
                    $fechaactual= $objdate->format('Y-m-d');
                    $year = $objdate->format('y');
                    $correlativo = $this->correlativoControlProducto();
                    $control = new control();
                    $control->tabla = "articulo producto";
                    $control->id_tabla = $obj->id;
                    $control->codigo = $request->codigo = 'P-'.strval($correlativo + 1);
                    $control->fecha = $fechaactual;
                    $control->save();
                } else {
                    $correlativo = 0;
                    $objdate = new DateTime();
                    $fechaactual= $objdate->format('Y-m-d');
                    $year = $objdate->format('y');
                    $correlativo = $this->correlativoControlServicio();
                    $control = new control();
                    $control->tabla = $request->tabla = "articulo servicio";
                    $control->id_tabla = $obj->id;
                    $control->codigo = $request->codigo = 'S-'.strval($correlativo + 1);
                    $control->fecha = $fechaactual;
                    $control->save();
                }

            }


            
            if($id_tienda ==100){
                if($request->id_tienda == 1){
                    $Almacen = new TiendaArticulo();
                    $Almacen->id_articulo=$obj->id;
                    $Almacen->id_tienda=1;
                    $Almacen->stock=($request->contenido_presentacion*$request->stock);
                    // $Almacen->stock=0;
                    $Almacen->save();
                }
                if($request->id_tienda == 2){
                    $Almacen = new TiendaArticulo();
                    $Almacen->id_articulo=$obj->id;
                    $Almacen->id_tienda=2;
                    $Almacen->stock=($request->contenido_presentacion*$request->stock);
                    // $Almacen->stock=0;
                    $Almacen->save();
                }
                if($request->id_tienda == 3){
                    $Almacen = new TiendaArticulo();
                    $Almacen->id_articulo=$obj->id;
                    $Almacen->id_tienda=3;
                    $Almacen->stock=($request->contenido_presentacion*$request->stock);
                    // $Almacen->stock=0;
                    $Almacen->save();
                }
                if($request->id_tipo_producto!=5)
                {
                    $ajuste = new Ajuste();
                    $ajuste->stock=$Almacen->stock;
                    $ajuste->costo_compra=$obj->costo_compra;
                    $ajuste->costo_venta=$obj->costo_venta;
                    $ajuste->stock_anterior=0;
                    $ajuste->stock_actual=$Almacen->stock;
                    $ajuste->observacion=$request->descripcion;
                    $ajuste->id_articulo=$obj->id;
                    $ajuste->id_motivo_ajuste=1;
                    $ajuste->save();
                }
            }elseif($id_tienda ==1)
            {
                $Almacen = new TiendaArticulo();
                $Almacen->id_articulo=$obj->id;
                $Almacen->id_tienda=1;
                $Almacen->stock=($request->contenido_presentacion*$request->stock);
                // $Almacen->stock=0;
                $Almacen->save();
            }elseif($id_tienda ==2)
            {
                $Almacen = new TiendaArticulo();
                $Almacen->id_articulo=$obj->id;
                $Almacen->id_tienda=2;
                $Almacen->stock=($request->contenido_presentacion*$request->stock);
                // $Almacen->stock=0;
                $Almacen->save();
            }elseif($id_tienda ==3)
            {
                $Almacen = new TiendaArticulo();
                $Almacen->id_articulo=$obj->id;
                $Almacen->id_tienda=3;
                $Almacen->stock=($request->contenido_presentacion*$request->stock);
                // $Almacen->stock=0;
                $Almacen->save();
            }else
            {
                //
            }
                $datos = [
                    'tabla' => 'articulo',
                    'codigo_tabla' => $obj->id,
                    'transaccion' => 'guardar venta',
                ];
                $this->guardarBitacora($datos);
    
                $datos = [
                    'tabla' => 'almacen',
                    'codigo_tabla' => $Almacen->id,
                    'transaccion' => 'guardar venta',
                ];
                $this->guardarBitacora($datos);


            DB::commit();*/
        // } catch (Exception $e){
        //     DB::rollBack();
        // }

        $correlativo = DB::table('articulo')->select()->max('id');

        DB::beginTransaction();
        $obj = new Articulo();
        $obj->nombre=$request->nombre;
        $obj->cod_ean=$request->cod_ean;
        $obj->contenido_presentacion = $request->contenido_presentacion == '' || $request->contenido_presentacion == '0'  ? '1' : $request->contenido_presentacion;
        $obj->costo_compra=empty($request->costo_compra)?0:$request->costo_compra;
        $obj->costo_venta=empty($request->costo_venta)?0:$request->costo_venta;                
        $obj->estado=$request->estado;
        if($request->id_tipo_producto==2 || $request->id_tipo_producto==5){
            $obj->id_tienda=2;
        }else{
            $obj->id_tienda=1;
        }
        $obj->impresion=0;
        
        if(empty($request->stock_minimo)){
            $obj->stock_minimo=0;
        }else{
            $obj->stock_minimo=$request->stock_minimo;
        }   

        $obj->id_categoria=$request->id_categoria;
        $obj->receta=0;
        if($request->id_tipo_producto==5)
        {
            $obj->combo=1;
        }
        $obj->id_categoria=$request->id_categoria;
        //$obj->id_unidad=$request->id_unidad;
        $obj->id_unidad = $request->id_unidad == '' ? '1' : $request->id_unidad;
        $obj->id_tipo_producto=$request->id_tipo_producto;
        $obj->id_producto_compuesto = $request->id_producto_compuesto == '' ? '0' : $request->id_producto_compuesto;
        $obj->observacion=$request->descripcion;
        if($request->foto==null){
            $obj->foto ='defecto.png';
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
            $obj->foto=$fileName;   
        }
        $obj->save();

        //AGREGAR CODIGO DE VENTA

        if($request->tipo_producto == 'Producto Venta') {
            $correlativo = 0;
            $objdate = new DateTime();
            $fechaactual= $objdate->format('Y-m-d');
            $year = $objdate->format('y');
            $correlativo = $this->correlativoControlProducto();
            $control = new control();
            $control->tabla = "articulo producto";
            $control->id_tabla = $obj->id;
            $control->codigo = $request->codigo = 'P-'.strval($correlativo + 1);
            $control->fecha = $fechaactual;
            $control->save();
        } else {
            $correlativo = 0;
            $objdate = new DateTime();
            $fechaactual= $objdate->format('Y-m-d');
            $year = $objdate->format('y');
            $correlativo = $this->correlativoControlServicio();
            $control = new control();
            $control->tabla = $request->tabla = "articulo servicio";
            $control->id_tabla = $obj->id;
            $control->codigo = $request->codigo = 'S-'.strval($correlativo + 1);
            $control->fecha = $fechaactual;
            $control->save();
        }

    // }
    $Almacen = new TiendaArticulo();
    $Almacen->id_articulo=$obj->id;
    
    $Almacen->id_tienda=$obj->id_tienda;
    $Almacen->stock=($request->contenido_presentacion*$request->stock);
    // $Almacen->stock=0;
    $Almacen->save();
    if($request->id_tipo_producto!=5)
    {
        $ajuste = new Ajuste();
        $ajuste->stock=$Almacen->stock;
        $ajuste->costo_compra=$obj->costo_compra;
        $ajuste->costo_venta=$obj->costo_venta;
        $ajuste->stock_anterior=0;
        $ajuste->stock_actual=$Almacen->stock;
        $ajuste->observacion=$request->descripcion;
        $ajuste->id_articulo=$obj->id;
        $ajuste->id_motivo_ajuste=1;
        $ajuste->save();
    }

        $datos = [
            'tabla' => 'articulo',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'guardar venta',
        ];
        $this->guardarBitacora($datos);

        $datos = [
            'tabla' => 'almacen',
            'codigo_tabla' => $Almacen->id,
            'transaccion' => 'guardar venta',
        ];
        $this->guardarBitacora($datos);


    DB::commit();
    }
    public function guardarServicio(Request $request){
        try{
            if (Articulo::where('nombre_comercial', $request->nombre_comercial)
                ->where('id_categoria', $request->id_categoria)->first()){
                return ['error'=>0];
            }
            else{
                $correlativo = DB::table('articulo')->select()->max('id');

                DB::beginTransaction();
                $obj = new Articulo();
                $obj->cod_producto=$correlativo+1;
                $obj->nombre_comercial=$request->nombre_comercial;
                $obj->nombre_generico=$request->nombre_generico;
                $obj->costo_compra=$request->costo_compra;
                $obj->costo_unitario=$request->costo_unitario;
                $obj->costo_mayorista=0;
                $obj->costo_preferencial=0;
                $obj->stock_minimo=$request->stock_minimo;
                $obj->descripcion=$request->descripcion;
                $obj->tipo_producto=$request->tipo_producto;
                $obj->fecha_vencimiento=$request->fecha_vencimiento;
                $obj->estado=$request->estado;
                $obj->id_categoria=$request->id_categoria;
                //DD($obj);
                $obj->save();

                //AGREGAR CODIGO DE VENTA

                if($request->tipo_producto == 'Producto Venta') {
                    $correlativo = 0;
                    $objdate = new DateTime();
                    $fechaactual= $objdate->format('Y-m-d');
                    $year = $objdate->format('y');
                    $correlativo = $this->correlativoControlProducto();
                    $control = new control();
                    $control->tabla = "articulo producto";
                    $control->id_tabla = $obj->id;
                    $control->codigo = $request->codigo = 'P-'.strval($correlativo + 1);
                    $control->fecha = $fechaactual;
                    $control->save();
                } else {
                    $correlativo = 0;
                    $objdate = new DateTime();
                    $fechaactual= $objdate->format('Y-m-d');
                    $year = $objdate->format('y');
                    $correlativo = $this->correlativoControlServicio();
                    $control = new control();
                    $control->tabla = $request->tabla = "articulo servicio";
                    $control->id_tabla = $obj->id;
                    $control->codigo = $request->codigo = 'S-'.strval($correlativo + 1);
                    $control->fecha = $fechaactual;
                    $control->save();
                }

            }
            $Almacen = new TiendaArticulo();
            $Almacen->id_articulo=$obj->id;
            $Almacen->id_tienda=1;
            $Almacen->stock=0;
            $Almacen->save();

            if($request->tipo_producto == 'Producto Venta') {
                
                $datos = [
                    'tabla' => 'articulo',
                    'codigo_tabla' => $obj->id,
                    'transaccion' => 'guardar venta',
                ];
                $this->guardarBitacora($datos);
    
                $datos = [
                    'tabla' => 'almacen',
                    'codigo_tabla' => $Almacen->id,
                    'transaccion' => 'guardar venta',
                ];
                $this->guardarBitacora($datos);

            } else {

                $datos = [
                    'tabla' => 'articulo',
                    'codigo_tabla' => $obj->id,
                    'transaccion' => 'guardar servicio',
                ];
                $this->guardarBitacora($datos);
    
                $datos = [
                    'tabla' => 'almacen',
                    'codigo_tabla' => $Almacen->id,
                    'transaccion' => 'guardar servicio',
                ];
                $this->guardarBitacora($datos);

            }

            

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function modificar(Request $request){
        if($request->nombre==""){
            return ['error'=>1];
        }else{
            if (Articulo::where('nombre', $request->nombre)
                ->where('id_categoria', $request->id_categoria)
                ->where('id','!=', $request->id)
                ->first()){
                return ['error'=>0];
            } else {
                $obj= Articulo::findOrFail($request->id);
                $obj->nombre=$request->nombre;
                $obj->cod_ean=$request->cod_ean;
                $obj->contenido_presentacion=$request->contenido_presentacion;
                $obj->costo_compra=empty($request->costo_compra)?0:$request->costo_compra;
                $obj->costo_venta=$request->costo_venta;                
                $obj->observacion=$request->observacion;
                $obj->estado=$request->estado;
                $obj->impresion=$request->impresion;
                $obj->stock_minimo=$request->stock_minimo;
               
                $obj->id_categoria=$request->id_categoria;
                $obj->id_unidad=$request->id_unidad;
                $obj->id_tipo_producto=$request->id_tipo_producto;
                if($request->id_tipo_producto== 4)
                {
                    $obj->id_producto_compuesto = $request->id_producto_compuesto == '' ? '0' : $request->id_producto_compuesto;            
                }else{
                    $obj->id_producto_compuesto = 0;
                }
                if($request->id_tipo_producto == 1)
                {
                    $obj->impresion = 0;
                }
                $obj->observacion=$request->descripcion;
                if($request->foto==null){
                    $obj->foto ='defecto.png';
                }
                else{
                    if($request->imagenActual==$request->foto){
                        $obj->foto =$request->imagenActual;
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
                        $obj->foto=$fileName;  
                        
                        if($request->imagenActual!="defecto.png")
                        {
                            $this->delete($request->imagenActual);
                        }
                    }
                }
                $obj->save();
         
                    $datos = [
                        'tabla' => 'articulo',
                        'codigo_tabla' => $obj->id,
                        'transaccion' => 'modificar venta',
                    ];
                    $this->guardarBitacora($datos);
    
            }
        }
    }
    public function modificarMenu_Dia(Request $request){
        $obj= Articulo::findOrFail($request->id_articulo);
        $obj->menu_dia=1;
        $obj->save();
        // $affected = DB::table('articulo')
        //             ->where('id_articulo', $obj->id_articulo)
        //             ->update(['stock' => $det['stock']]);
    }
    public function modificarMenu_Dia2(Request $request){
        $obj= Articulo::findOrFail($request->id_articulo);
        $obj->menu_dia=0;
        $obj->save();
        // $affected = DB::table('articulo')
        //             ->where('id_articulo', $obj->id_articulo)
        //             ->update(['stock' => $det['stock']]);
    }
    
    public function delete($nombre){
        $obj = File::delete('img/producto/'.$nombre);
    }
    public function modificarServicio(ArticuloRequest $request){
        if (Articulo::where('nombre_comercial', $request->nombre_comercial)
            ->where('id_categoria', $request->id_categoria)
            ->where('id','!=', $request->id)
            ->first()){
            return ['error'=>0];
        } else {
            $obj= Articulo::findOrFail($request->id);
            $obj->nombre_comercial=$request->nombre_comercial;
            $obj->nombre_generico=$request->nombre_generico;
            $obj->costo_compra=$request->costo_compra;
            $obj->costo_unitario=$request->costo_unitario;
            $obj->costo_mayorista=0;
            $obj->costo_preferencial=0;
            $obj->stock_minimo=$request->stock_minimo;
            $obj->descripcion=$request->descripcion;
            $obj->tipo=$request->tipo;
            $obj->estado=$request->estado;
            $obj->id_categoria=$request->id_categoria;
            $obj->save();

            if($request->tipo_producto == 'Producto Venta') {
                    
                $datos = [
                    'tabla' => 'articulo',
                    'codigo_tabla' => $obj->id,
                    'transaccion' => 'modificar venta',
                ];
                $this->guardarBitacora($datos);

            } else {

                $datos = [
                    'tabla' => 'articulo',
                    'codigo_tabla' => $obj->id,
                    'transaccion' => 'modificar servicio',
                ];
                $this->guardarBitacora($datos);

            }
        }
    }
    public function desactivar(Request $request){
        $producto_paquete = Combo::join('articulo', 'combo.id_articulo', '=', 'articulo.id')
        ->join('tienda_articulo', 'tienda_articulo.id_articulo', '=', 'articulo.id')
        ->join('tienda', 'tienda_articulo.id_tienda', '=', 'tienda.id')
        ->select('combo.estado', 'combo.id')
        ->where('articulo.id', '=', $request->id)
        ->where('tienda.id', '=', 2)
        ->first();
        if($producto_paquete){
            //dd($producto_paquete->estado);
            //dd($producto_paquete->id);
            
            $combo = Combo::findOrFail($producto_paquete->id);
            $combo->estado=0;
            $combo->save();
        }

        $obj = Articulo::findOrFail($request->id);
        $obj->estado = '0';
        $obj->save();

        $datos = [
            'tabla' => 'articulo',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'desactivar',
        ];
        $this->guardarBitacora($datos);
    }
    public function activar(Request $request){

        $producto_paquete = Combo::join('articulo', 'combo.id_articulo', '=', 'articulo.id')
        ->join('tienda_articulo', 'tienda_articulo.id_articulo', '=', 'articulo.id')
        ->join('tienda', 'tienda_articulo.id_tienda', '=', 'tienda.id')
        ->select('combo.estado', 'combo.id')
        ->where('articulo.id', '=', $request->id)
        ->where('tienda.id', '=', 2)
        ->first();
        if($producto_paquete){
            //dd($producto_paquete->estado);
            //dd($producto_paquete->id);
            
            $combo = Combo::findOrFail($producto_paquete->id);
            $combo->estado=1;
            $combo->save();
        }

        $obj = Articulo::findOrFail($request->id);
        $obj->estado = '1';
        $obj->save();

        $datos = [
            'tabla' => 'articulo',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'activar',
        ];
        $this->guardarBitacora($datos);
    }
    public function cantidadRegistros(){
        $cantidad = DB::table('articulo')->count();
        $data=['nro' =>$cantidad];
        return $data;
    }
    public function cantidadRegistrosProductos(){
        $cantidad = DB::table('articulo')
        ->where('articulo.tipo','=','Producto Venta')
        ->count();
        $data=['nro' =>$cantidad];
        return $data;
    }
    public function cantidadRegistrosServicios(){
        $cantidad = DB::table('articulo')
        ->where('articulo.tipo','=','Producto Servicio')
        ->count();
        $data=['nro' =>$cantidad];
        return $data;
    }
    private function correlativoControlProducto(){
        $mayor = DB::table('control')->where('control.tabla','=','articulo producto')->count();
         return $mayor;
    }
    private function correlativoControlServicio(){
        $mayor = DB::table('control')->where('control.tabla','=','articulo servicio')->count();
         return $mayor;
    }
    public function listarProducto(Request $request){
        /*$id_tienda = $request->id_tienda;
        $id_categoria = $request->id_categoria;
        $buscar = $request->buscar;
        if($id_categoria==0)
        {
            $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('articulo.id  as Id_Producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
            'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
            'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
            ->whereIn('articulo.id_tipo_producto',[2,3,5])
            //->where('articulo.receta','=',0)
            ->where('articulo.estado','=',1)
            ->where('tienda.id',2)
            ->where('articulo.combo','=',0)
            ->get(); 
        }else
        {
            $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('articulo.id  as Id_Producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
            'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
            'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
            ->where('articulo.id_categoria','=',$id_categoria)
            ->whereIn('articulo.id_tipo_producto',[2,3,5])
            //->where('articulo.receta','=',0)
            ->where('articulo.estado','=',1)
            ->where('tienda.id',2)
            ->where('articulo.combo','=',0)
            ->get();    
        }*/

        $id_categoria = $request->id_categoria;
        $buscar = $request->buscar;

        if($id_categoria==0)
        {
            $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id  as Id_Producto','tienda_articulo.id as id_tienda_articulo','articulo.nombre as descripcion','articulo.costo_venta as precio',
            'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
            'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
            ->whereIn('articulo.id_tipo_producto',[2,3,5])
            ->where('articulo.estado','=',1)
            //->where('articulo.receta','=',0)
            ->where('tienda_articulo.id_tienda', '=', 2)
            ->where('articulo.combo','=',0)
            ->get(); 
        }else
        {
            $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id  as Id_Producto','tienda_articulo.id as id_tienda_articulo','articulo.nombre as descripcion','articulo.costo_venta as precio',
            'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
            'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
            ->where('articulo.id_categoria','=',$id_categoria)
            ->whereIn('articulo.id_tipo_producto',[2,3,5])
            ->where('articulo.estado','=',1)
            //->where('articulo.receta','=',0)
            
            ->where('tienda_articulo.id_tienda', '=', 2)
            ->where('articulo.combo','=',0)
            ->get();    
        }
 
        //dd($data);
        return $data; 
    }
    public function BuscarProducto(Request $request){
        $id_tienda = $request->id_tienda;
        $id_categoria = $request->id_categoria;
        $buscar = $request->buscar;
        if($id_categoria==0)
        {
            $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id  as Id_Producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
            'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
            'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
            //->where('articulo.id_categoria','=',$id_categoria)
            ->whereIn('articulo.id_tipo_producto',[2,3,5])
            ->where('articulo.receta','=',0)
            ->where('tienda_articulo.id_tienda',2)// defecto tienda 2
            ->where('articulo.combo','=',0)
            ->where('articulo.estado','=',1)
            ->where('articulo.nombre', 'like', '%'.$buscar.'%')
            ->get();  
 
        }else
        {
            $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id  as Id_Producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
            'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
            'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
            ->where('articulo.id_categoria','=',$id_categoria)
            ->whereIn('articulo.id_tipo_producto',[2,3,5])
            ->where('articulo.receta','=',0)
            ->where('tienda_articulo.id_tienda',2) // defecto tienda 2
            ->where('articulo.combo','=',0)
            ->where('articulo.estado','=',1)
            ->where('articulo.nombre', 'like', '%'.$buscar.'%')
            ->get();  
        }  
        return $data;
    }
    public function listarProducto1(Request $request){
        // $id_categoria = $request->id_categoria;
        //dd($id_categoria);
        //dd($id_categoria);
        $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('categoria','articulo.id_categoria','=','categoria.id')
        ->select('articulo.id  as Id_Producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
        'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
        'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
        // ->where('articulo.id_tipo_producto','!=',1)
        // ->where('articulo.id_categoria','=',$id_categoria)
        ->whereIn('articulo.id_tipo_producto',[2,3,5])
        ->where('articulo.estado','=',1)
        ->where('articulo.receta','=',0)
        ->where('articulo.combo','=',0)
        //->where('Producto.Combo', '=', 0)
        ->get();     
        return $data;


        return $obj;
    }
    public function listarProductoCompuesto(Request $request){
        $id_producto = $request->id_producto;
        //dd($id_producto);
        $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('categoria','articulo.id_categoria','=','categoria.id')
        ->select('articulo.id  as id_producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
        'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
        'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
        ->where('articulo.id','=', $id_producto)
        ->get();     
        return $data;
    }
    public function listarProductoSimple(Request $request){
        $id_producto = $request->id_producto;
        //dd($id_producto);
        $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('categoria','articulo.id_categoria','=','categoria.id')
        ->select('articulo.id  as id_producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
        'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
        'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
        ->where('articulo.id','=', $id_producto)
        ->get();     
        return $data;
    }
    public function listarProductoElaborado(Request $request){
        $id_producto = $request->id_producto;
        //dd($id_producto);
        $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('categoria','articulo.id_categoria','=','categoria.id')
        ->select('articulo.id  as id_producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
        'tienda_articulo.stock as stock','articulo.foto','articulo.id_categoria as Id_Categoria','articulo.estado',
        'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
        ->where('articulo.id','=', $id_producto)
        ->get();     
        return $data;
    }
    public function listarCategoryProducto(Request $request){
        $buscar = $request->filtro;
         $idcategoria = $request->id_categoria;
        if ($buscar==''){
            $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id as Id_Producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
            'articulo.foto','articulo.id_categoria as Id_Categoria','tienda_articulo.stock','articulo.estado',
            'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
            ->where('articulo.id_categoria','=',$idcategoria)
            ->where('articulo.id_tipo_producto','!=',1)
            ->whereIn('articulo.id_tipo_producto',[2,3,5])
            ->where('articulo.receta','=',0)
            ->where('articulo.combo','=',0)
            ->where('articulo.nombre', 'like', '%'.$buscar.'%')
            ->get();     
        }
        else{
            $data = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id as Id_Producto','articulo.nombre as descripcion','articulo.costo_venta as precio',
            'articulo.foto','articulo.id_categoria as Id_Categoria','tienda_articulo.stock','articulo.estado',
            'categoria.nombre as categoria','articulo.id_tipo_producto','articulo.contenido_presentacion','articulo.id_producto_compuesto')
            ->where('articulo.id_tipo_producto','!=',1)
            ->whereIn('articulo.id_tipo_producto',[2,3,5])
            ->where('articulo.receta','=',0)
            ->where('articulo.combo','=',0)
            ->where('articulo.nombre', 'like', '%'.$buscar.'%')
            ->get();     
        }
        return $data;
    }
    public function selectTipoProducto(){  
        $obj = TipoProducto::select('id', 'nombre')->where('tipo_producto.id','!=',4)->orderBy('tipo_producto.id','asc')->get(); 
        return $obj;
    }
    public function selectTipoProductoCompuesto(){  
        $obj = Articulo::select('id', 'nombre')->where('articulo.id_tipo_producto','=',3)->orderBy('articulo.id','asc')->get(); 
        return $obj;
    }
    public function selectTipoProductoCombo(){  
        $obj = Articulo::select('id', 'nombre')->where('articulo.id_tipo_producto','=',5)->orderBy('articulo.id','asc')->get(); 
        return $obj;
    }
    
}
