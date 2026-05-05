<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tienda;
use App\Models\TiendaArticulo;
use Illuminate\Support\Facades\File;
use DB;

class TiendaController extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $mi_empresa = Tienda::orderBy('tienda.id', 'desc')
            ->where('tienda.id','!=',1)->paginate(15);
        }
        else{
            $mi_empresa = Tienda::where('tienda.'.$criterio, 'like', '%'.$buscar.'%')
            ->where('tienda.id','!=',1)
            ->orderBy('tienda.id', 'desc')->paginate(15);
        }
        return $mi_empresa;
    }
    public function indexEmpresa(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $mi_empresa = Tienda::orderBy('tienda.id', 'desc')
            ->paginate(15);
        }
        else{
            $mi_empresa = Tienda::where('tienda.'.$criterio, 'like', '%'.$buscar.'%') 
            ->orderBy('tienda.id', 'desc')->paginate(15);
        }
        return $mi_empresa;
    }

    public function modificar(Request $request){
        $id_tienda = $request->id;
        $nombre_tienda = $request->nombre;
        $obj= Tienda::findOrFail($id_tienda);
        $obj->cod_tienda=$request->cod_tienda;
        $obj->cod_almacen=$request->cod_almacen;
        $obj->direccion=$request->direccion;
        $obj->telefono=$request->telefono;
        $obj->estado=$request->estado;
        $obj->nombre=$nombre_tienda;

        if($request->foto==null){
            $obj->foto ='logo.png';
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
                $path= 'img/mi_empresa'.'/'.$fileName;
                \file_put_contents($path,$decoded);
                $obj->foto=$fileName;
            }
        }
        $obj->save();

        $id_motivo_ajuste=0;
        if($id_tienda == 2) {
            $id_motivo_ajuste = 7;
        }else if($id_tienda == 3){
            $id_motivo_ajuste = 8;
        }else if($id_tienda == 4){
            $id_motivo_ajuste = 9;
        }else{
            //
        }

        $affected = DB::table('motivo_ajuste')
                ->where('id',$id_motivo_ajuste)
                ->update(['nombre' => 'Venta '.$nombre_tienda]);

        $datos = [
            'tabla' => 'tienda',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'modificar',
        ];
        $this->guardarBitacora($datos);
    }

    public function selectTienda(Request $request){
        $tienda = Tienda::select('id', 'nombre')->get();
        return $tienda;
    }

    public function selectTienda2(Request $request){
        $tienda1 = $request->id_tienda1;

        $tienda=DB::select("SELECT id, nombre FROM tienda WHERE tienda.id != 1 and tienda.id != $tienda1");
        return $tienda;
    }

    private function actualizarStock($id_producto,$cantVenta){
        DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$id_producto)
        ->where('tienda_articulo.id_tienda','=',1)
        ->decrement('stock', $cantVenta);
    }

    public function guardarArticulo(Request $request){
        try{
            DB::beginTransaction();
            $detalles = $request->detalle;
            $id_tienda = $request->id_tienda;


            foreach($detalles as $ep=>$det){
                $id_articulo = $det['id_articulo'];


                $tienda_articulo=DB::select("SELECT id, id_articulo, id_tienda,stock
                FROM tienda_articulo
                where id_articulo = $id_articulo and id_tienda = $id_tienda");

                //dd($tienda_articulo);
                if($tienda_articulo != []){
                    $tienda_articulo_stock = $tienda_articulo[0]->stock ;
                } else {
                    //
                }

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
                    $obj->id_tienda= $id_tienda;
                    $obj->stock= $det['stock'];
                    $obj->save();

                    $datos = [
                        'tabla' => 'tienda_articulo',
                        'codigo_tabla' => $obj->id,
                        'transaccion' => 'guardar',
                    ];
                    $this->guardarBitacora($datos);

                }
                $this->actualizarStock($det['id_articulo'],$det['stock']);


            }

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function detalleArticuloTienda(Request $request){
        $obj= TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->select('articulo.cod_producto','articulo.cod_proveedor','articulo.nombre','articulo.costo_compra',
        'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','tienda_articulo.stock',
        'tienda_articulo.id_articulo','tienda_articulo.id_tienda','articulo.tipo_producto')
        ->where('tienda_articulo.id_tienda','=',$request->id)
        ->get();
        return $obj;
    }

    public function detalleArticuloTiendaProducto(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $obj= TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id','articulo.nombre','articulo.costo_compra',
            'articulo.costo_venta','tienda_articulo.stock',
            'tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','categoria.nombre as categoria')
            ->where('tienda_articulo.id_tienda','=',$request->id)
            ->where('articulo.id_tipo_producto','=',3)
            ->orderBy('tienda_articulo.id', 'desc')
            ->get();
        } else {
            $obj= TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id','articulo.nombre','articulo.costo_compra',
            'articulo.costo_venta','tienda_articulo.stock',
            'tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','categoria.nombre as categoria')
            ->where('tienda_articulo.id_tienda','=',$request->id)
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->where('articulo.id_tipo_producto','=',3)
            ->orderBy('tienda_articulo.id', 'desc')
            ->get();

        }
        return $obj;
    }

    public function detalleArticuloTiendaServicio(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $obj= TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id','articulo.cod_producto','articulo.cod_proveedor','articulo.nombre','articulo.costo_compra',
            'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','tienda_articulo.stock',
            'tienda_articulo.id_articulo','tienda_articulo.id_tienda','articulo.tipo_producto','categoria.nombre as categoria')
            ->where('tienda_articulo.id_tienda','=',$request->id)
            ->where('articulo.tipo_producto','=','Producto Servicio')
            ->orderBy('tienda_articulo.id', 'desc')
            ->get();
        } else {
            $obj= TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('articulo.id','articulo.cod_producto','articulo.cod_proveedor','articulo.nombre','articulo.costo_compra',
            'articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','tienda_articulo.stock',
            'tienda_articulo.id_articulo','tienda_articulo.id_tienda','articulo.tipo_producto','categoria.nombre as categoria')
            ->where('tienda_articulo.id_tienda','=',$request->id)
            ->where('articulo.tipo_producto','=','Producto Servicio')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('tienda_articulo.id', 'desc')
            ->get();

        }
        return $obj;


    }


    public function inventario(Request $request){
        $buscar = $request->buscar;
        $id_tienda = $request->id_tienda;
        $criterio = $request->criterio;
        if($id_tienda==3)// significa que se esta haciendo una busqueda del inventario total
        {
            if ($buscar==''){
                $obj=DB::table('articulo')
                ->select('articulo.nombre', 'cod_ean', 'articulo.costo_compra', 'articulo.costo_venta', 'categoria.nombre as categoria', DB::raw('SUM(IF(tienda_articulo.id_tienda = 1, stock, 0)) AS tienda1_stock'), DB::raw('SUM(IF(tienda_articulo.id_tienda = 2, stock, 0)) AS tienda2_stock'))
                ->join('tienda_articulo', 'articulo.id', '=', 'tienda_articulo.id_articulo')
                ->join('categoria', 'categoria.id', '=', 'articulo.id_categoria')
                ->whereIn('tienda_articulo.id_tienda', [1, 2])
                ->groupBy('articulo.nombre')
                ->paginate(15);
            }
            else{
                
                $obj=DB::table('articulo')
                ->select('articulo.nombre', 'cod_ean', 'articulo.costo_compra', 'articulo.costo_venta', 'categoria.nombre as categoria', DB::raw('SUM(IF(tienda_articulo.id_tienda = 1, stock, 0)) AS tienda1_stock'), DB::raw('SUM(IF(tienda_articulo.id_tienda = 2, stock, 0)) AS tienda2_stock'))
                ->join('tienda_articulo', 'articulo.id', '=', 'tienda_articulo.id_articulo')
                ->join('categoria', 'categoria.id', '=', 'articulo.id_categoria')
                ->whereIn('tienda_articulo.id_tienda', [1, 2])
                ->where($criterio, 'like', '%'.$buscar.'%')
                ->groupBy('articulo.nombre')
                ->paginate(15);
            }
        }else{
            if ($buscar==''){
                $obj= TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('articulo.cod_ean','articulo.nombre','articulo.costo_compra','articulo.costo_venta','tienda_articulo.stock','categoria.nombre as categoria')
                ->where('tienda_articulo.id_tienda','=',$id_tienda)
                ->orderBy('tienda_articulo.id', 'desc')->paginate(15);
            }
            else{
                $obj= TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('articulo.cod_ean','articulo.nombre','articulo.costo_compra','articulo.costo_venta','tienda_articulo.stock','categoria.nombre as categoria')
                ->where('tienda_articulo.id_tienda','=',$id_tienda)
                ->where($criterio, 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->paginate(15);
            }
        }
        return $obj;
    }

    // public function listarSinPaginate(Request $request){
    //     $buscar = $request->buscar;
    //     $criterio = $request->criterio;
    //     $id_proveedor = $request->id_proveedor;
    //     //dd($id_proveedor);
    //     if ($buscar==''){

    //         $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
    //         ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
    //         ->join('categoria','articulo.id_categoria','=','categoria.id')
    //         ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock',
    //         'articulo.nombre as articulo','tienda.nombre as tienda',
    //         'articulo.costo_compra','articulo.tipo_producto','articulo.costo_unitario','articulo.costo_mayorista',
    //         'articulo.costo_preferencial','articulo.id_categoria','categoria.nombre as categoria')
    //         ->where('tienda_articulo.id_tienda',1)
    //         ->where('articulo.id_proveedor','=',$id_proveedor)
    //         ->where('articulo.tipo_producto', 'Producto Venta')
    //         ->orderBy('tienda_articulo.id', 'desc')->get();
    //     }
    //     else{
    //         $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
    //         ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
    //         ->join('categoria','articulo.id_categoria','=','categoria.id')
    //         ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda',
    //         'articulo.costo_compra','articulo.tipo_producto','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.id_categoria','categoria.nombre as categoria')
    //         ->where('tienda_articulo.id_tienda',1)
    //         ->where('articulo.tipo_producto', 'Producto Venta')
    //         ->where('articulo.id_proveedor','=',$id_proveedor)
    //         ->where($criterio, 'like', '%'.$buscar.'%')
    //         ->orderBy('tienda_articulo.id', 'desc')->get();
    //     }
    //     return $tienda_articulo;
    // }
    public function listarSinPaginate(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        //dd($id_proveedor);
        if ($buscar==''){

            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock',
            'articulo.nombre as articulo','tienda.nombre as tienda',
            'articulo.costo_compra','articulo.tipo_producto','articulo.costo_unitario','articulo.costo_mayorista',
            'articulo.costo_preferencial','articulo.id_categoria','categoria.nombre as categoria')
            ->where('tienda_articulo.id_tienda',1)
            ->where('articulo.tipo_producto', 'Producto Venta')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        else{
            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock',
            'articulo.nombre as articulo','tienda.nombre as tienda',
            'articulo.costo_compra','articulo.tipo_producto','articulo.costo_unitario','articulo.costo_mayorista',
            'articulo.costo_preferencial','articulo.id_categoria','categoria.nombre as categoria')
            ->where('tienda_articulo.id_tienda',1)
            ->where('articulo.tipo_producto', 'Producto Venta')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        return $tienda_articulo;
    }
    public function listarSinPaginateAjuste(Request $request){
        $id_tienda = $request->id_tienda;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        //dd($id_proveedor);
        if ($buscar==''){

            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock',
            'articulo.nombre as articulo','tienda.nombre as tienda',
            'articulo.costo_compra','articulo.costo_venta','articulo.id_categoria','categoria.nombre as categoria','articulo.contenido_presentacion','tienda_articulo.id_tienda')
            ->where('tienda_articulo.id_tienda',$id_tienda)
            ->whereIn('articulo.id_tipo_producto',[1,3])
            ->where('articulo.estado','=',1)
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        else{
            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda',
            'articulo.costo_compra','articulo.costo_venta','articulo.id_categoria','categoria.nombre as categoria','articulo.contenido_presentacion','tienda_articulo.id_tienda')
            ->where('tienda_articulo.id_tienda',$id_tienda)
            ->whereIn('articulo.id_tipo_producto',[1,3])
            ->where('articulo.estado','=',1)
            ->where('articulo.nombre', 'like', '%'.$buscar.'%')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        return $tienda_articulo;
    }

    public function listarSinPaginateP(Request $request){
        $buscar = $request->buscar;
        if ($buscar==''){

            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.tipo_producto')
            ->where('tienda_articulo.id_tienda',3)
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        else{
            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.tipo_producto')
            ->where('tienda_articulo.id_tienda',3)
            ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        return $tienda_articulo;
    }

    //Listar de orden servicio

    public function listarOrdenProducto(Request $request){
        $buscar = $request->buscar;
        if ($buscar==''){

            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
            ->where('tienda_articulo.id_tienda',3)
            ->where('articulo.tipo_producto','Producto Venta')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        else{
            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
            ->where('tienda_articulo.id_tienda',3)
            ->where('articulo.tipo_producto','Producto Venta')
            ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        return $tienda_articulo;
    }

    public function listarSinPaginate2(Request $request){
        $buscar = $request->buscar;
        if ($buscar==''){

            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
            ->where('tienda_articulo.id_tienda',3)
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        else{
            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
            ->where('tienda_articulo.id_tienda',3)
            ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        return $tienda_articulo;
    }

    public function listarOrdenServicio(Request $request){
        $buscar = $request->buscar;
        if ($buscar==''){

            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
            ->where('tienda_articulo.id_tienda',3)
            ->where('articulo.tipo_producto','Producto Servicio')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        else{
            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
            ->where('tienda_articulo.id_tienda',3)
            ->where('articulo.tipo_producto','Producto Servicio')
            ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        return $tienda_articulo;
    }







    //TIENDAS

        //TIENDA 1  -- id_tienda = 2

        public function listarSinPaginate2tienda1(Request $request){
            $buscar = $request->buscar;
            $criterio = $request->criterio;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_venta','articulo.id_categoria','categoria.nombre as categoria')
                ->where('tienda_articulo.id_tienda',1)
                // ->where('articulo.tipo_producto','Producto Venta')
                // ->where('articulo.eliminado', 1)
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_venta','articulo.id_categoria','categoria.nombre as categoria')
                // ->where('articulo.tipo_producto','Producto Venta')
                ->where('tienda_articulo.id_tienda',1)
                // ->where('articulo.eliminado', 1)
                ->where($criterio , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }
        public function listarSinPaginate2tienda4(Request $request){
           

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_venta','articulo.id_categoria','categoria.nombre as categoria')
                ->where('tienda_articulo.id_tienda',1)
                // ->where('articulo.tipo_producto','Producto Venta')
                // ->where('articulo.eliminado', 1)
                ->orderBy('tienda_articulo.id', 'desc')->get();
            return $tienda_articulo;
        }

        public function listarSinPaginateVacuna(Request $request){
            $buscar = $request->buscar;
            $criterio = $request->criterio;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.estado','articulo.id_categoria','categoria.nombre as categoria')
                ->where('tienda_articulo.id_tienda',1)
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('articulo.estado', 1)
                ->where('categoria.nombre','=','Vacunas')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.estado','articulo.id_categoria','categoria.nombre as categoria')
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('tienda_articulo.id_tienda',1)
                ->where('articulo.estado', 1)
                ->where('categoria.nombre','=','Vacunas')
                ->where($criterio , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }
        public function listarSinPaginateVacuna2(Request $request){
            $buscar = $request->buscar;
            $criterio = $request->criterio;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.estado','articulo.id_categoria','categoria.nombre as categoria')
                ->where('tienda_articulo.id_tienda',1)
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('articulo.estado', 1)
                ->where('categoria.nombre','=','Antiparasitario')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.estado','articulo.id_categoria','categoria.nombre as categoria')
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('tienda_articulo.id_tienda',1)
                ->where('articulo.estado', 1)
                ->where('categoria.nombre','=','Antiparasitario')
                ->where($criterio , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }

        public function listarOrdenProductoTienda1(Request $request){
            $buscar = $request->buscar;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','categoria.nombre as categoria',
                'tienda.nombre as tienda','articulo.costo_compra','articulo.costo_venta', 'articulo.id_tipo_producto', 'articulo.costo_venta as costo_unitario')
                ->where('tienda_articulo.id_tienda',2)
                ->where('articulo.estado', 1)
                ->whereIn('articulo.id_tipo_producto',[2,3])
                
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','categoria.nombre as categoria',
                'tienda.nombre as tienda','articulo.costo_compra','articulo.costo_venta')
                ->where('tienda_articulo.id_tienda',2)
                ->where('articulo.estado', 1)
                ->whereIn('articulo.id_tipo_producto',[2,3])
                ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
                
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }

        public function listarOrdenProductoTiendaCombo(Request $request){
            $buscar = $request->buscar;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                //->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','categoria.nombre as categoria',
                //'tienda.nombre as tienda','articulo.costo_compra','articulo.costo_venta','articulo.foto')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','categoria.nombre as categoria',
                'tienda.nombre as tienda','articulo.costo_compra','articulo.costo_venta','articulo.foto')
                ->where('tienda_articulo.id_tienda',2)
                ->where('articulo.estado', 1)
                ->where('articulo.id_tipo_producto','=', 5)
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','categoria.nombre as categoria',
                'tienda.nombre as tienda','articulo.costo_compra','articulo.costo_venta','articulo.foto')
                ->where('tienda_articulo.id_tienda',2)
                ->where('articulo.estado', 1)
                ->where('articulo.id_tipo_producto','=', 5)
                ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }

        public function listarOrdenServicioTienda1(Request $request){
            $buscar = $request->buscar;
        $buscar = $request->buscar;
            $buscar = $request->buscar;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','categoria.nombre as categoria',
                'articulo.nombre as articulo','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_venta')
                ->where('tienda_articulo.id_tienda',1)
                ->where('articulo.id_tipo_producto','=', 5)
                // ->where('articulo.tipo_producto','Producto Servicio')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','categoria.nombre as categoria',
                'articulo.nombre as articulo','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_venta')
                ->where('tienda_articulo.id_tienda',1)
                ->where('articulo.id_tipo_producto','=', 5)
                // ->where('articulo.tipo_producto','Producto Servicio')
                ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }


        //TIENDA 2  -- id_tienda = 3

        public function listarSinPaginate2tienda2(Request $request){
            $buscar = $request->buscar;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','articulo.marca','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.estado','articulo.id_categoria','categoria.nombre as categoria')
                ->where('tienda_articulo.id_tienda',3)
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('articulo.estado', 1)
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','articulo.marca','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.estado','articulo.id_categoria','categoria.nombre as categoria')
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('tienda_articulo.id_tienda',3)
                ->where('articulo.estado', 1)
                ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }

        public function listarOrdenProductoTienda2(Request $request){
            $buscar = $request->buscar;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','categoria.nombre as categoria',
                'articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.marca')
                ->where('tienda_articulo.id_tienda',3)
                ->where('articulo.estado', 1)
                ->where('articulo.tipo_producto','Producto Venta')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','categoria.nombre as categoria',
                'articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.marca')
                ->where('tienda_articulo.id_tienda',3)
                ->where('articulo.estado', 1)
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }

        public function listarOrdenServicioTienda2(Request $request){
            $buscar = $request->buscar;
        $buscar = $request->buscar;
            $buscar = $request->buscar;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','categoria.nombre as categoria',
                'articulo.nombre as articulo','articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
                ->where('tienda_articulo.id_tienda',3)
                ->where('articulo.tipo_producto','Producto Servicio')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','categoria.nombre as categoria',
                'articulo.nombre as articulo','articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
                ->where('tienda_articulo.id_tienda',3)
                ->where('articulo.tipo_producto','Producto Servicio')
                ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }


        //TIENDA 3  -- id_tienda = 4

        public function listarSinPaginate2tienda3(Request $request){
            $buscar = $request->buscar;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','articulo.marca','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.estado','articulo.id_categoria','categoria.nombre as categoria')
                ->where('tienda_articulo.id_tienda',4)
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('articulo.estado', 1)
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','articulo.marca','tienda.nombre as tienda',
                'articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.estado','articulo.id_categoria','categoria.nombre as categoria')
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('tienda_articulo.id_tienda',4)
                ->where('articulo.estado', 1)
                ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }

        public function listarOrdenProductoTienda3(Request $request){
            $buscar = $request->buscar;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','categoria.nombre as categoria',
                'articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.marca')
                ->where('tienda_articulo.id_tienda',4)
                ->where('articulo.estado', 1)
                ->where('articulo.tipo_producto','Producto Venta')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','articulo.nombre as articulo','categoria.nombre as categoria',
                'articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.marca')
                ->where('tienda_articulo.id_tienda',4)
                ->where('articulo.estado', 1)
                ->where('articulo.tipo_producto','Producto Venta')
                ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }

        public function listarOrdenServicioTienda3(Request $request){
            $buscar = $request->buscar;
        $buscar = $request->buscar;
            $buscar = $request->buscar;
            if ($buscar==''){

                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','categoria.nombre as categoria',
                'articulo.nombre as articulo','articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
                ->where('tienda_articulo.id_tienda',4)
                ->where('articulo.tipo_producto','Producto Servicio')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            else{
                $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
                ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
                ->join('categoria','articulo.id_categoria','=','categoria.id')
                ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock','categoria.nombre as categoria',
                'articulo.nombre as articulo','articulo.tipo_producto','tienda.nombre as tienda','articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial')
                ->where('tienda_articulo.id_tienda',4)
                ->where('articulo.tipo_producto','Producto Servicio')
                ->where('articulo.nombre' , 'like', '%'.$buscar.'%')
                ->orderBy('tienda_articulo.id', 'desc')->get();
            }
            return $tienda_articulo;
        }


    public function listarSinPaginateCompra(Request $request){
        $id_tienda = $request->id_tienda;
        // $id_proveedor = $request->id_proveedor;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        //dd($id_proveedor);
        if ($buscar==''){

            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock',
            'articulo.nombre as articulo','tienda.nombre as tienda',
            'articulo.costo_compra','articulo.id_tipo_producto','articulo.costo_venta','articulo.id_categoria','categoria.nombre as categoria')
            ->where('tienda_articulo.id_tienda',$id_tienda)
            // ->where('articulo.id_proveedor',$id_proveedor)
            ->whereIn('articulo.id_tipo_producto', [3])
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        else{
            $tienda_articulo = TiendaArticulo::join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
            ->join('categoria','articulo.id_categoria','=','categoria.id')
            ->select('tienda_articulo.id','tienda_articulo.id_articulo','tienda_articulo.id_tienda','tienda_articulo.stock',
            'articulo.nombre as articulo','tienda.nombre as tienda',
            'articulo.costo_compra','articulo.id_tipo_producto','articulo.costo_venta','articulo.id_categoria','categoria.nombre as categoria')
            ->where('tienda_articulo.id_tienda',$id_tienda)
            // ->where('articulo.id_proveedor',$id_proveedor)
            ->whereIn('articulo.id_tipo_producto', [3])
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->orderBy('tienda_articulo.id', 'desc')->get();
        }
        return $tienda_articulo;
    }

    public function delete($id){
        $obj = File::delete('img/logo/'.$id);
    }

    public function deleteTienda($id){
        $obj = File::delete('img/mi_empresa/'.$id);
    }

    public function selectTiendaSinAlmacen(Request $request){
        $tienda=DB::select("SELECT id, nombre FROM tienda");
        return $tienda;
    }
    public function selectTiendaSinAlmacen2(Request $request){
        $tienda=DB::select("SELECT id, nombre FROM tienda WHERE tienda.id !=3");
        return $tienda;
    }
}
