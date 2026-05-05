<?php

namespace App\Http\Controllers\tiendaPrimera;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\DetallePaquete;
use App\Models\OrdenServicio;
use App\Models\Control;
use App\Models\Articulo;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\DetalleVentaPaquete;
use App\Models\Ajuste;
use App\Models\Pago;
use App\Models\CXCobrar;
use App\Models\ArqueoCaja;
use App\Models\MiEmpresa;
use App\Models\Combo;
use App\Models\Cliente;
use App\Models\DetalleCombo;
use App\Models\Tienda;
use App\Models\User;
use App\Http\Controllers\BitacoraController;
use DB;
use DateTime;

use \NumberFormatter;
//use NumeroALetras;  //llamando la clase 
use NumberToLetter;
//use NumeroALetras;
use Luecano\NumeroALetras\NumeroALetras;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
//use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;

use Illuminate\Support\Str;
use Carbon\Carbon;


class VentaController1 extends BitacoraController
{
    public function index(Request $request){
        $buscar = $request->buscar;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        $id_tienda = $request->id_tienda;
        //dd($buscar);
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->leftjoin('mesa', function($join){
                $join->orOn('venta.id_mesa','=','mesa.id');
            })
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_mesa','venta.usuario','mesa.nombre as mesa','venta.id_tienda')
            ->whereDate('venta.fecha', ">=", $fecha_inicio)
            ->whereDate('venta.fecha', "<=", $fecha_fin)
            ->where('venta.id_tienda',$id_tienda)
            ->orderBy('venta.id','desc')->paginate(15);
        }
        else{
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->leftjoin('mesa', function($join){
                $join->orOn('venta.id_mesa','=','mesa.id');
            })
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_mesa','venta.usuario','mesa.nombre as mesa','venta.id_tienda')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->whereDate('venta.fecha', ">=", $fecha_inicio)
            ->whereDate('venta.fecha', "<=", $fecha_fin)
            ->where('venta.id_tienda',$id_tienda)
            ->orderBy('venta.id','desc')->paginate(15);            
        }
        return $obj;
    }
    public function ProductosVendido(Request $request){

        // $id_usuario = \Auth::user()->id;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        // $buscar = $request->buscar;
       
        $a=DB::select("SELECT articulo.nombre as producto,Sum(detalle_venta.cantidad) as cantidad,tienda_articulo.stock,
         articulo.costo_venta,sum(venta.total) as total ,articulo.id_tipo_producto as tipo_producto
        FROM  detalle_venta INNER JOIN tienda_articulo
        on detalle_venta.id_tienda_articulo=tienda_articulo.id 
        INNER JOIN articulo 
        ON tienda_articulo.id_articulo=articulo.id
        INNER JOIN venta
        ON detalle_venta.id_venta=venta.id
        WHERE venta.fecha>='$fecha_inicio' and venta.fecha<='$fecha_fin' and venta.estado!='Anulado'
        GROUP BY articulo.nombre");
         $obj7 = json_decode(json_encode($a), true);

        //  dd($obj7);
       
        //  $b=DB::select("SELECT sum(venta.total) as Total
        //  FROM venta
        //  WHERE venta.fecha BETWEEN '$fecha_inicio' and '$fecha_fin' and venta.estado!='Anulado'");
        //  $obj8 = json_decode(json_encode($b), true);
    
         return $obj7;

    }
    public function totalCobrado(Request $request){
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_tienda = $request->id_tienda;

        if($buscar==''){
            $objeto=DB::select("SELECT SUM(venta.total) total from venta,cliente 
            where venta.id_cliente=cliente.id AND venta.estado='Cobrado'  
            AND venta.fecha>='$fecha_inicio' AND venta.fecha<='$fecha_fin' AND venta.id_tienda='$id_tienda'");
 
        }
        else{
            $objeto=DB::select("SELECT SUM(venta.total) total from venta,cliente 
            where venta.id_cliente=cliente.id AND venta.estado='Cobrado'  
            AND venta.fecha>='$fecha_inicio' AND venta.fecha<='$fecha_fin'
            and $criterio LIKE '%$buscar%' AND venta.id_tienda='$id_tienda'");

            // $obj=DB::select("SELECT c.id,c.nombre as cliente, c.matricula, c.telefono,SUM(g.monto) as monto, SUM(g.saldo) as saldo_cliente, v.id_tienda, v.tipo_venta FROM cliente c, pago g, venta v, users u
            // where v.id_cliente=c.id and g.id_venta=v.id AND v.estado!='Anulado' AND g.id_tipo_pago=2 AND v.id_tienda = '$id_tienda' AND v.tipo_venta BETWEEN 'Venta Cotizacion'  AND '$tipo_producto' AND v.id_usuario=u.id AND u.id = '$id_usuario' and c.nombre LIKE '%$buscar%'
            // GROUP by c.nombre,c.id,c.telefono");
        }
        $objeto1=(object) $objeto[0];
        //dd($objeto1);
        return $objeto1;
    }
    public function totalCobrado1(Request $request){
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
       
        $a=DB::select("SELECT SUM(venta.total) total from venta,cliente 
        where venta.id_cliente=cliente.id AND venta.estado='Cobrado'AND 
            venta.fecha>='$fecha_inicio' AND venta.fecha<='$fecha_fin'");
        $objeto1=(object) $a[0];

        return  $objeto1;
    }
    public function totalPrecuenta(Request $request){
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id_tienda = $request->id_tienda;


        if($buscar==''){
            $objeto=DB::select("SELECT SUM(venta.total) total from venta,cliente 
            where venta.id_cliente=cliente.id AND venta.estado='Registrado'  
            AND venta.fecha>='$fecha_inicio' AND venta.fecha<='$fecha_fin' AND venta.id_tienda='$id_tienda'");
        }
        else{
            $objeto=DB::select("SELECT SUM(venta.total) total from venta,cliente 
            where venta.id_cliente=cliente.id AND venta.estado='Registrado'  
            AND venta.fecha>='$fecha_inicio' AND venta.fecha<='$fecha_fin'
            and $criterio LIKE '%$buscar%'  AND venta.id_tienda='$id_tienda'");
        }
        $objeto1=(object) $objeto[0];
        return $objeto1;

    }
    public function ventaMesero(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->join('mesa','venta.id_mesa','=','mesa.id')
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_mesa','mesa.nombre as mesa')
            ->where('venta.id_tienda','=',2)
            ->where('venta.estado','=','Registrado')
            ->where('users.id','=',\Auth::user()->id)
            ->orderBy('venta.id','desc')->get();
        }
        else{
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->join('mesa','venta.id_mesa','=','mesa.id')
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_mesa','mesa.nombre as mesa')
            //->where($criterio, 'like', '%'.$buscar.'%')
            ->where('venta.id_tienda','=',2)
            ->where('venta.estado','=','Registrado')
            ->where('users.id','=',\Auth::user()->id)
            ->orderBy('venta.id','desc')->get();            
        }
        return $obj;
    }

    public function indexMesero(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->join('mesa','venta.id_mesa','=','mesa.id')
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_mesa','mesa.nombre as mesa')
            ->where('venta.id_tienda','=',1)
            ->where('venta.estado','=','Registrado')
            ->where('users.id','=',\Auth::user()->id)
            ->orderBy('venta.id','desc')->paginate(15);
        }
        else{
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->join('mesa','venta.id_mesa','=','mesa.id')
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_mesa','mesa.nombre as mesa')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->where('venta.id_tienda','=',1)
            ->where('venta.estado','=','Registrado')
            ->where('users.id','=',\Auth::user()->id)
            ->orderBy('venta.id','desc')->paginate(15);            
        }
        return $obj;
    }

    public function indexServicio(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_orden_servicio')
            ->where('venta.tipo_venta','=','Venta Servicio')
            ->where('venta.id_tienda','=',1)
            ->where('users.id','=',\Auth::user()->id)
            ->orderBy('venta.id','desc')->paginate(15);
        }
        else{
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_orden_servicio')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->where('venta.tipo_venta','=','Venta Servicio')
            ->where('venta.id_tienda','=',1)
            ->where('users.id','=',\Auth::user()->id)
            ->orderBy('venta.id','desc')->paginate(15);            
        }
        return $obj;
    }
    public function indexControl(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_orden_servicio')
            ->where('venta.tipo_venta','=','Venta Control Vacuna')
            ->where('venta.id_tienda','=',1)
            ->where('users.id','=',\Auth::user()->id)
            ->orderBy('venta.id','desc')->paginate(15);
        }
        else{
            $obj= Venta::join('users','venta.id_usuario','=','users.id')
            ->join('cliente','venta.id_cliente','=','cliente.id')
            ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
            ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
            ->join('tienda','venta.id_tienda','=','tienda.id')
            ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento','venta.tipo_venta',
            'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP','forma_pago.nombre as formaP',
            'tienda.id as tienda_id','tienda.nombre as tienda','venta.id_orden_servicio')
            ->where($criterio, 'like', '%'.$buscar.'%')
            ->where('venta.tipo_venta','=','Venta Control Vacuna')
            ->where('venta.id_tienda','=',1)
            ->where('users.id','=',\Auth::user()->id)
            ->orderBy('venta.id','desc')->paginate(15);            
        }
        return $obj;
    }
    
    private function actualizarCaja($id_usuario,$monto){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->increment('arqueo_caja.registro_venta', $monto);
    }
    private function actualizarCajaContado($id_usuario,$monto){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->increment('arqueo_caja.total_efectivo', $monto);
    }
    private function actualizarCajaDeposito($id_usuario,$monto){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->increment('arqueo_caja.total_deposito', $monto);
    }

    private function descontarCaja($monto,$id_usuario){
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->decrement('arqueo_caja.registro_venta', $monto);
    }

    private function actualizarStock($id_producto,$cantVenta,$id_tienda){
        DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$id_producto)
        ->where('tienda_articulo.id_tienda','=',$id_tienda)
        ->decrement('stock', $cantVenta);
    }
    private function actualizarStock2($id_producto,$cantVenta){
        DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$id_producto)
        ->decrement('stock', $cantVenta);
    }
    public function guardar(Request $request){
        try{
            //dd($request->id_tienda);
                DB::beginTransaction();
                $registro_venta = $request->total;
                //$descuento = $request->descuento * $request->sub_total/100;
                $total = $request->sub_total - $request->descuento;
                $id_usuario=\Auth::user()->id;
                $id_tienda=\Auth::user()->id_tienda;
                $objdate = new DateTime();
                $fechaactual= $objdate->format('Y-m-d');
                $year = $objdate->format('y');
                $id_cliente = $request->id_cliente;
                //dd($id_cliente);
                if($id_cliente==0){
                    $buscar_cliente = DB::select("SELECT id FROM cliente WHERE cliente.nombre = '$request->cliente'");
                    //$buscar_cliente = Cliente::select('id')->where('cliente.nombre', '=', $request->cliente)->get();

                    if($buscar_cliente == []){
                        $cliente= new Cliente();
                        $cliente->nombre=$request->cliente;
                        $cliente->matricula=0;
                        $cliente->telefono=0;
                        $cliente->direccion='';
                        $cliente->descripcion='';
                        $cliente->descuento=0;
                        $cliente->estado=1;
                        $cliente->save();

                        $var2=DB::select("SELECT  MAX(id) as id_cliente from cliente");
                        //dd($var2);
                        $id_cliente=$var2[0]->id_cliente;
                    } else {
                        $id_cliente = $buscar_cliente[0]->id;
                    }
                }
                $venta = new Venta();
                $venta->fecha=$request->fecha;
                //tipo venta 0 venta directa ,1 venta mesero
                $venta->tipo_venta=$request->tipo_venta;
                $venta->control=0;
                $venta->estado='Registrado';
                $venta->observacion=$request->observacion == '' ? '.' : $request->observacion;
                $venta->sub_total=$request->sub_total;
                $venta->descuento=$request->descuento;
                $venta->total=$total;
                $venta->usuario=$request->usuario;
                $venta->anulado='';
                $venta->imprimir=0;
                $venta->id_cliente=$id_cliente;
                $venta->id_tipo_pago=$request->id_tipo_pago;
                $venta->tipo_venta=$request->tipo_venta;
                if($id_tienda == 100){
                $venta->id_tienda=$request->id_tienda;
                }else
                {
                    $venta->id_tienda=$id_tienda;
                }
                if($request->id_tipo_pago == 1) {
                    $venta->id_forma_pago=$request->id_forma_pago;
                }else if ($request->id_tipo_pago == 2) {
                    $venta->id_forma_pago=$request->id_forma_pago;
                } else {
                    //
                }
                $venta->id_mesa = $request->id_mesa == '' ? 0 : $request->id_mesa;
                $venta->id_usuario=$id_usuario;
                $venta->save();  

                // if($request->id_tipo_pago == 1) {
                //     $pago = new Pago();
                //     $pago->id = $venta->id;
                //     $pago->fecha = $request->fecha;
                //     $pago->fecha_final = $request->fecha_final;
                //     $pago->monto = $request->total;
                //     $pago->descripcion = "";
                //     $pago->id_tipo_pago = $request->id_tipo_pago;
                //     $pago->id_venta = $venta->id;
                //     $pago->save();  

                //     $this->actualizarCaja($registro_venta,$id_usuario);
                    
                // } else if($request->id_tipo_pago == 2) {
    
                //     $pago = new Pago();
                //     $pago->id = $venta->id;
                //     $pago->fecha = $request->fecha;
                //     $pago->fecha_final = $request->fecha_final;
                //     $pago->monto = $request->total;
                //     $pago->descripcion = $request->descripcion = "";
                //     $pago->id_tipo_pago = $request->id_tipo_pago;
                //     $pago->id_venta = $venta->id;
                //     $pago->save(); 

                //     $cxcobrar = new CXCobrar();
                //     $cxcobrar->fecha = $request->fecha;
                //     //$cxcobrar->anticipo = $request->anticipo;
                //     $cxcobrar->monto_total = $request->monto_total;
                //     $cxcobrar->descripcion = $request->descripcion_pago;
                //     $cxcobrar->saldo = $request->monto_total;
                //     $cxcobrar->id_pago = $venta->id;
                //     $cxcobrar->save(); 
    
                // } else {
                //     //
                // }

                $correlativo = $this->correlativoControl();
    
                $control = new control();
                $control->tabla = $request->tabla = "Producto";
                $control->codigo = $request->codigo = 'VP'.strval($correlativo + 1).$year;
                $control->fecha = $fechaactual;
                $control->save();

                $arrayDetalleCombo = $request->arrayDetalleCombo;
                // dd($arrayDetalleCombo);
                foreach($arrayDetalleCombo as $ep=>$stock){
                    if($stock['id_tipo_producto'] == 3){
                        if($id_tienda == 100){
                            $this->actualizarStock($stock['id_producto'],$stock['cantidad'],$request->id_tienda);  
                        }else
                        {
                            $this->actualizarStock($stock['id_producto'],$stock['cantidad'],$id_tienda);  
                        }  
                    }
                    $id_producto = $stock['id_producto'];
                    $tienda_articulo=DB::select("SELECT ta.stock
                    FROM tienda_articulo ta
                    WHERE ta.id = '$id_producto'");
        
                    $ajuste = new Ajuste();
                    $ajuste->stock=$stock['cantidad'];
                    $ajuste->costo_compra=0;
                    $ajuste->stock_anterior=$tienda_articulo[0]->stock + $stock['cantidad'];
                    $ajuste->stock_actual=$tienda_articulo[0]->stock;
                    $ajuste->costo_venta=$stock['precio'];
                    $ajuste->observacion='';
                    $ajuste->id_articulo=$stock['id_producto'];
                    $ajuste->id_motivo_ajuste=8;
                    $ajuste->save();
                }
                // $arrayDetalleProductoSimple = $request->arrayDetalleProductoSimple;
                // foreach($arrayDetalleProductoSimple as $ep=>$simp){
                //     $this->actualizarStock($simp['id_producto'],$simp['cantidad']);
                //     $id_producto = $simp['id_producto'];
                //     $tienda_articulo=DB::select("SELECT ta.stock
                //     FROM tienda_articulo ta
                //     WHERE ta.id = '$id_producto'");
        
                //     $ajuste = new Ajuste();
                //     $ajuste->stock=$simp['cantidad'];
                //     $ajuste->costo_compra=0;
                //     $ajuste->stock_anterior=$tienda_articulo[0]->stock + $simp['cantidad'];
                //     $ajuste->stock_actual=$tienda_articulo[0]->stock;
                //     $ajuste->costo_venta=$simp['precio'];
                //     $ajuste->observacion='';
                //     $ajuste->id_articulo=$simp['id_producto'];
                //     $ajuste->id_motivo_ajuste=8;
                //     $ajuste->save();
                // }

                // $arrayDetalleProductoElaborado = $request->arrayDetalleProductoElaborado;
                // foreach($arrayDetalleProductoElaborado as $ep=>$elab){
                //     $this->actualizarStock($elab['id_producto'],$elab['cantidad']);
                //     $id_producto = $elab['id_producto'];
                //     $tienda_articulo=DB::select("SELECT ta.stock
                //     FROM tienda_articulo ta
                //     WHERE ta.id = '$id_producto'");
        
                //     $ajuste = new Ajuste();
                //     $ajuste->stock=$elab['cantidad'];
                //     $ajuste->costo_compra=0;
                //     $ajuste->stock_anterior=$tienda_articulo[0]->stock + $elab['cantidad'];
                //     $ajuste->stock_actual=$tienda_articulo[0]->stock;
                //     $ajuste->costo_venta=$elab['precio'];
                //     $ajuste->observacion='';
                //     $ajuste->id_articulo=$elab['id_producto'];
                //     $ajuste->id_motivo_ajuste=8;
                //     $ajuste->save();
                // }
    
                $detalles = $request->detalle;
                $costo_pago = $request->costo_pago;
                foreach($detalles as $ep=>$det){
                    $obj = new DetalleVenta();
                    $obj->id_venta= $venta->id;
                    // if($request->tipo_venta=="Venta Directa"){
                    //     $obj->id_producto= $det['id_tienda_articulo'];
                    // }else{
                    //     $obj->id_producto=0;
                    // }
                    $obj->id_tienda_articulo= $det['id_tienda_articulo'];
                    $obj->cantidad= $det['cantidad'];
                    $obj->descripcion= empty($det['descripcion'])?'':$det['descripcion'];
                    $obj->costo_venta= $det['costo_venta'];
                    $obj->sub_total= $det['sub_total'];
                    $obj->id_usuario=$id_usuario;

                    $obj->save();
                    
                    if($det['id_tipo_producto'] == 2)
                    {
                        $id_producto = $det['id_tienda_articulo'];
                        $tienda_articulo=DB::select("SELECT ta.stock
                        FROM tienda_articulo ta
                        WHERE ta.id = '$id_producto'");
            
                        $ajuste = new Ajuste();
                        $ajuste->stock=$det['cantidad'];
                        $ajuste->costo_compra=0;
                        $ajuste->stock_anterior=0;
                        $ajuste->stock_actual=0;
                        $ajuste->costo_venta=$det['costo_venta'];
                        $ajuste->observacion='';
                        $ajuste->id_articulo=$det['id_tienda_articulo'];
                        $ajuste->id_motivo_ajuste=8;
                        $ajuste->save();
                        
                    }

                    if($det['id_tipo_producto'] == 3)
                    {
                        if($id_tienda == 100){
                            $this->actualizarStock($det['id_articulo'],$det['cantidad'],$request->id_tienda);  
                        }else
                        {
                            $this->actualizarStock($det['id_articulo'],$det['cantidad'],$id_tienda);  
                        }
                        $id_producto = $det['id_tienda_articulo'];
                        $tienda_articulo=DB::select("SELECT ta.stock
                        FROM tienda_articulo ta
                        WHERE ta.id = '$id_producto'");
            
                        $ajuste = new Ajuste();
                        $ajuste->stock=$det['cantidad'];
                        $ajuste->costo_compra=0;
                        $ajuste->stock_anterior=$tienda_articulo[0]->stock + $det['cantidad'];
                        $ajuste->stock_actual=$tienda_articulo[0]->stock;
                        $ajuste->costo_venta=$det['costo_venta'];
                        $ajuste->observacion='';
                        $ajuste->id_articulo=$det['id_articulo'];
                        $ajuste->id_motivo_ajuste=8;
                        $ajuste->save();
                    }

                }

                $datos = [
                    'tabla' => 'venta',
                    'codigo_tabla' => $venta->id,
                    'transaccion' => 'guardar',
                ];
                $this->guardarBitacora($datos);   
                
                $affected = DB::table('mesa')
                ->where('id', $request->id_mesa)
                ->update(['estado' => 0]); 
            
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    
    public function guardarDirecta(Request $request){
        //dd($request);
        try{
            //dd($request->id_tienda);
                //dd($request);
                //decrement
                DB::beginTransaction();
                $registro_venta = $request->total;
                $registro_venta_efectivo = $request->total_efectivo;
                $registro_venta_deposito = $request->total_deposito;
                $id_usuario=\Auth::user()->id;
                $id_tienda=\Auth::user()->id_tienda;
                $objdate = new DateTime();
                $fechaactual= $objdate->format('Y-m-d');
                $year = $objdate->format('y');
                $id_cliente = $request->id_cliente;
                //dd($id_cliente);
                if($id_cliente==0){
                    $buscar_cliente = DB::select("SELECT id FROM cliente WHERE cliente.nombre = '$request->cliente'");
                    //$buscar_cliente = Cliente::select('id')->where('cliente.nombre', '=', $request->cliente)->get();

                    if($buscar_cliente == []){
                        $cliente= new Cliente();
                        $cliente->nombre=$request->cliente;
                        $cliente->matricula=0;
                        $cliente->telefono=0;
                        $cliente->direccion='';
                        $cliente->descripcion='';
                        $cliente->descuento=1;
                        $cliente->estado=1;
                        $cliente->save();

                        $var2=DB::select("SELECT  MAX(id) as id_cliente from cliente");
                        //dd($var2);
                        $id_cliente=$var2[0]->id_cliente;
                    } else {
                        $id_cliente = $buscar_cliente[0]->id;
                    }
                }
                $venta = new Venta();
                $venta->fecha=$request->fecha;
                //tipo venta 0 venta directa ,1 venta mesero
                $venta->tipo_venta=1;
                $venta->control=0;
                $venta->estado='Cobrado';
                $venta->observacion=$request->observacion == '' ? '.' : $request->observacion;
                $venta->sub_total=$request->sub_total;
                $venta->descuento=empty($request->descuento)?0:$request->descuento;
                $venta->total=$request->total;
                $venta->usuario=$request->usuario;
                $venta->anulado='';
                $venta->imprimir=0;
                $venta->id_cliente=$id_cliente;
                $venta->id_tipo_pago=$request->id_tipo_pago;
                if($id_tienda == 100){
                $venta->id_tienda=$request->id_tienda;
                }else
                {
                    $venta->id_tienda=$id_tienda;
                }
                if($request->id_forma_pago == 6){
                    $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                    $venta->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;
                }else if($request->id_forma_pago == 2  || $request->id_forma_pago == 7 || $request->id_forma_pago == 9)
                {
                    $venta->total_efectivo =$request->total;
                    $venta->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;
    
                }else if($request->id_forma_pago == 3)
                {
                    $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                    $venta->total_deposito =$request->total;
                    
                }else if($request->id_forma_pago == 4 || $request->id_forma_pago == 8 || $request->id_forma_pago == 10  || $request->id_forma_pago == 11)
                {
                    $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                    $venta->total_deposito =$request->total;
    
                }else if($request->id_forma_pago == 5)
                {
                    $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                    $venta->total_deposito =$request->total;
                }else
                {
                    //
                }
                if($request->id_tipo_pago == 1) {
                    $venta->id_forma_pago=$request->id_forma_pago;
                }else if ($request->id_tipo_pago == 2) {
                    $venta->id_forma_pago=$request->id_forma_pago;
                } else {
                    //
                }
                // $venta->id_mesa = $request->id_mesa == '' ? 0 : $request->id_mesa;
                $venta->id_usuario=$id_usuario;
                $venta->efectivo=($request->id_forma_pago==2 || $request->id_forma_pago==6)?$request->efectivo:0;
                $venta->cambio=$request->cambio;
                $venta->save();  

                if($request->id_tipo_pago == 1) {
                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->total;
                    $pago->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    $pago->save();  

                    // $this->actualizarCaja($registro_venta,$id_usuario);
                    if($request->id_forma_pago == 2 || $request->id_forma_pago == 7 || $request->id_forma_pago == 9){
                        $this->actualizarCaja($id_usuario,$registro_venta);
                         $this->actualizarCajaContado($id_usuario,$registro_venta);
                        }
                        if($request->id_forma_pago == 3 || $request->id_forma_pago == 4 || $request->id_forma_pago == 5 || $request->id_forma_pago == 11){
                            $this->actualizarCaja($id_usuario,$registro_venta);
                            $this->actualizarCajaDeposito($id_usuario,$registro_venta);
                        }
                        if($request->id_forma_pago == 6){
                            $this->actualizarCaja($id_usuario,$registro_venta_efectivo);
                            $this->actualizarCajaContado($id_usuario,$registro_venta_efectivo);
                            $this->actualizarCaja($id_usuario,$registro_venta_deposito);
                            $this->actualizarCajaDeposito($id_usuario,$registro_venta_deposito);
                        }
                        if($request->id_forma_pago == 8){
                            $this->actualizarCaja($id_usuario,$registro_venta);
                            $this->actualizarCajaPedido($id_usuario,$registro_venta);
                        }
                        if($request->id_forma_pago == 10){
                            $this->actualizarCaja($id_usuario,$registro_venta);
                            $this->actualizarCajaYummy($id_usuario,$registro_venta);
                        }
                    
                } else if($request->id_tipo_pago == 2) {
    
                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->total;
                    $pago->descripcion = $request->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    $pago->save(); 

                    $cxcobrar = new CXCobrar();
                    $cxcobrar->fecha = $request->fecha;
                    //$cxcobrar->anticipo = $request->anticipo;
                    $cxcobrar->monto_total = $request->monto_total;
                    $cxcobrar->descripcion = $request->descripcion_pago;
                    $cxcobrar->saldo = $request->monto_total;
                    $cxcobrar->id_pago = $venta->id;
                    $cxcobrar->save(); 
    
                } else {
                    //
                }

                $correlativo = $this->correlativoControl();
    
                $control = new control();
                $control->tabla = $request->tabla = "Producto";
                $control->codigo = $request->codigo = 'VP'.strval($correlativo + 1).$year;
                $control->fecha = $fechaactual;
                $control->save();

                $arrayDetalleCombo = $request->arrayDetalleCombo;
                
                //dd($arrayDetalleCombo);
                foreach($arrayDetalleCombo as $ep=>$stock){
                    if($stock['id_tipo_producto'] == 3){
                        if($id_tienda == 100){
                            $this->actualizarStock($stock['id_producto'],$stock['cantidad'],$request->id_tienda);  
                        }else
                        {
                            $this->actualizarStock($stock['id_producto'],$stock['cantidad'],$request->id_tienda);  
                        }
                    }
                    $id_producto = $stock['id_producto'];
                    $tienda_articulo=DB::select("SELECT ta.stock
                    FROM tienda_articulo ta
                    WHERE ta.id = '$id_producto'");
        
                    $ajuste = new Ajuste();
                    $ajuste->stock=$stock['cantidad'];
                    $ajuste->costo_compra=0;
                    $ajuste->stock_anterior=$tienda_articulo[0]->stock + $stock['cantidad'];
                    $ajuste->stock_actual=$tienda_articulo[0]->stock;
                    $ajuste->costo_venta=$stock['precio'];
                    $ajuste->observacion='';

                    $ajuste->id_articulo=$stock['id_producto'];
                    $ajuste->id_motivo_ajuste=8;
                    $ajuste->save();
                }
                // $arrayDetalleProductoSimple = $request->arrayDetalleProductoSimple;
                // foreach($arrayDetalleProductoSimple as $ep=>$simp){
                //     $this->actualizarStock($simp['id_producto'],$simp['cantidad']);
                //     $id_producto = $simp['id_producto'];
                //     $tienda_articulo=DB::select("SELECT ta.stock
                //     FROM tienda_articulo ta
                //     WHERE ta.id = '$id_producto'");
        
                //     $ajuste = new Ajuste();
                //     $ajuste->stock=$simp['cantidad'];
                //     $ajuste->costo_compra=0;
                //     $ajuste->stock_anterior=$tienda_articulo[0]->stock + $simp['cantidad'];
                //     $ajuste->stock_actual=$tienda_articulo[0]->stock;
                //     $ajuste->costo_venta=$simp['precio'];
                //     $ajuste->observacion='';
                //     $ajuste->id_articulo=$simp['id_producto'];
                //     $ajuste->id_motivo_ajuste=8;
                //     $ajuste->save();
                // }

                // $arrayDetalleProductoElaborado = $request->arrayDetalleProductoElaborado;
                // foreach($arrayDetalleProductoElaborado as $ep=>$elab){
                //     $this->actualizarStock($elab['id_producto'],$elab['cantidad']);
                //     $id_producto = $elab['id_producto'];
                //     $tienda_articulo=DB::select("SELECT ta.stock
                //     FROM tienda_articulo ta
                //     WHERE ta.id = '$id_producto'");
        
                //     $ajuste = new Ajuste();
                //     $ajuste->stock=$elab['cantidad'];
                //     $ajuste->costo_compra=0;
                //     $ajuste->stock_anterior=$tienda_articulo[0]->stock + $elab['cantidad'];
                //     $ajuste->stock_actual=$tienda_articulo[0]->stock;
                //     $ajuste->costo_venta=$elab['precio'];
                //     $ajuste->observacion='';
                //     $ajuste->id_articulo=$elab['id_producto'];
                //     $ajuste->id_motivo_ajuste=8;
                //     $ajuste->save();
                // }
    
                $detalles = $request->detalle;
                //dd($detalles);
                $costo_pago = $request->costo_pago;
                foreach($detalles as $ep=>$det){
                    $obj = new DetalleVenta();
                    $obj->id_venta= $venta->id;
                    // if($request->tipo_venta=="Venta Directa"){
                    //     $obj->id_producto= $det['id_tienda_articulo'];
                    // }else{
                    //     $obj->id_producto=0;
                    // }
                    
                    $obj->id_tienda_articulo= $det['id_tienda_articulo'];
                    $obj->cantidad= $det['cantidad'];
                    $obj->descripcion= $det['descripcion'];
                    $obj->costo_venta= $det['costo_venta'];
                    $obj->sub_total= $det['costo_venta']*$det['cantidad'];
                    $obj->id_usuario=$id_usuario;
                    $obj->save();

               
                    if($det['id_tipo_producto'] == 2)
                    {
                        $id_producto = $det['id_tienda_articulo'];
                        $tienda_articulo=DB::select("SELECT ta.stock
                        FROM tienda_articulo ta
                        WHERE ta.id = '$id_producto'");
            
                        $ajuste = new Ajuste();
                        $ajuste->stock=$det['cantidad'];
                        $ajuste->costo_compra=0;
                        $ajuste->stock_anterior=0;
                        $ajuste->stock_actual=0;
                        $ajuste->costo_venta=$det['costo_venta'];
                        $ajuste->observacion='';
                        $ajuste->id_articulo=$det['id_articulo'];
                        $ajuste->id_motivo_ajuste=8;
                        $ajuste->save();
                        
                    }

                    if($det['id_tipo_producto'] == 3)
                    {
                        if($id_tienda == 100){
                            $this->actualizarStock($det['id_articulo'],$det['cantidad'],$request->id_tienda);  
                        }else
                        {
                            $this->actualizarStock($det['id_articulo'],$det['cantidad'],$request->id_tienda);  
                        }
                        $id_producto = $det['id_tienda_articulo'];
                        $tienda_articulo=DB::select("SELECT ta.stock
                        FROM tienda_articulo ta
                        WHERE ta.id = '$id_producto'");
            
                        $ajuste = new Ajuste();
                        $ajuste->stock=$det['cantidad'];
                        $ajuste->costo_compra=0;
                        $ajuste->stock_anterior=$tienda_articulo[0]->stock + $det['cantidad'];
                        $ajuste->stock_actual=$tienda_articulo[0]->stock;
                        $ajuste->costo_venta=$det['costo_venta'];
                        $ajuste->observacion='';
                        $ajuste->id_articulo=$det['id_articulo'];
                        $ajuste->id_motivo_ajuste=8;
                        $ajuste->save();
                    }


                }
                //$this->ventaTicket($request);

                $datos = [
                    'tabla' => 'venta',
                    'codigo_tabla' => $venta->id,
                    'transaccion' => 'guardar',
                ];
                $this->guardarBitacora($datos);   
                
                $affected = DB::table('mesa')
                ->where('id', $request->id_mesa)
                ->update(['estado' => 0]); 

                //aqui deberias retornar la info a imprimir
                  // obtenemos la data a imprimir
                  DB::commit();

                // $detalleVenta = DetalleVenta::where('id_venta', $venta->id)->get();
                // $json = $venta->toJson() . '|' . $detalleVenta->toJson();

                // // data base 64 lista para transmitir
                // $b64 = base64_encode($json);

                //     return response()->json([
                //         'info' => $b64, 200
                //     ]);
           
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function eliminarDetalle(Request $request){

        //dd($request->id_tipo_producto);
        $affected = DB::table('detalle_venta')
        ->where('id', $request->id_detalle_venta)
        ->update(['eliminado' => '0']); 

       // dd($request->id_tipo_producto);
        $detalles = DetalleVenta::join('tienda_articulo','detalle_venta.id_tienda_articulo','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->select('detalle_venta.id_venta as Id_Venta','detalle_venta.id_tienda_articulo as Id_Producto','detalle_venta.cantidad as Cantidad','articulo.id_tipo_producto')
        ->where('detalle_venta.id',$request->id_detalle_venta)->get();
        //dd($detalles);
        //dd($request->id_tipo_producto);
        if($request->id_tipo_producto == 2){
        foreach($detalles as $ep=>$det){
            DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->Id_Producto)
            ->increment('stock', $det->Cantidad);

            $tienda_articulo=DB::select("SELECT ta.stock
            FROM tienda_articulo ta
            WHERE ta.id = '$det->Id_Producto'");
            $ajuste = new Ajuste();
            $ajuste->stock=$det->Cantidad;
            $ajuste->costo_compra=0;
            $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det->Cantidad;
            $ajuste->stock_actual=$tienda_articulo[0]->stock;
            $ajuste->costo_venta=0;
            $ajuste->observacion='';
            $ajuste->id_articulo=$det->Id_Producto;
            $ajuste->id_motivo_ajuste=9;
            $ajuste->save();
            }
        }
        if($request->id_tipo_producto == 3){
        foreach($detalles as $ep=>$det){
            DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->Id_Producto)
            ->increment('stock', $det->Cantidad);

            $tienda_articulo=DB::select("SELECT ta.stock
            FROM tienda_articulo ta
            WHERE ta.id = '$det->Id_Producto'");
            $ajuste = new Ajuste();
            $ajuste->stock=$det->Cantidad;
            $ajuste->costo_compra=0;
            $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det->Cantidad;
            $ajuste->stock_actual=$tienda_articulo[0]->stock;
            $ajuste->costo_venta=0;
            $ajuste->observacion='';
            $ajuste->id_articulo=$det->Id_Producto;
            $ajuste->id_motivo_ajuste=9;
            $ajuste->save();
            }
        }
        if($request->id_tipo_producto == 5){
            foreach($detalles as $ep=>$det2){
                    //dd($det2->id_tipo_producto);
              
                    $Combo = Combo::select('id as id_combo')
                    ->where('id_articulo','=',$det2->Id_Producto)
                    ->where('estado','=',1)
                    ->get();
                    //dd($Combo);
                    foreach($Combo as $ep=>$det3){
                       // dd($det2->Cantidad);
                        $detallesCombo = DetalleCombo::join('articulo','detalle_combo.id_articulo','=','articulo.id')
                        ->select(DB::raw('detalle_combo.cantidad * '.$det2->Cantidad.' as Cantidad'),'detalle_combo.id_articulo','articulo.id_tipo_producto')
                        ->where('detalle_combo.id_combo','=',$det3->id_combo)
                        ->where('detalle_combo.estado','=',1)->get();
                       // dd($detallesCombo);
                    }
                    foreach($detallesCombo as $ep=>$det4){
                            if($det4->id_tipo_producto == 2 || $det4->id_tipo_producto == 3){
                                DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det4->id_articulo)
                                ->increment('stock', $det4->Cantidad);

                                $tienda_articulo=DB::select("SELECT ta.stock
                                FROM tienda_articulo ta
                                WHERE ta.id = '$det4->id_articulo'"); 

                                $ajuste = new Ajuste();
                                $ajuste->stock=$det4->Cantidad;
                                $ajuste->costo_compra=0;
                                $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det4->Cantidad;
                                $ajuste->stock_actual=$tienda_articulo[0]->stock;
                                $ajuste->costo_venta=0;
                                $ajuste->observacion='';
                                $ajuste->id_articulo=$det4->id_articulo;
                                $ajuste->id_motivo_ajuste=9;
                                $ajuste->save();
                            }
                    }
            }
        }
        

        $affected = DB::table('venta')
        ->where('id', $request->id_venta)
        ->update(['total' => $request->sub_total-$request->descuento,'sub_total' => $request->sub_total,'descuento' => $request->descuento]);
        

    }
    public function obtenerCabecera(Request $request){
        
        $id=$request->id; 
        $obj= Venta::join('proveedor','compra.id_proveedor','=','proveedor.id')
        ->select('compra.id','compra.fecha','compra.descripcion','compra.total','proveedor.nombre as proveedor')
        ->where('compra.id','=',$id)
        ->get();

        return $obj;
    }

    public function detalleVenta(Request $request){
        
        $id=$request->id; 
        $obj= detalleVenta::join('tienda_articulo','detalle_venta.id_tienda_articulo','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('categoria','articulo.id_categoria','=','categoria.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_venta.id_venta','detalle_venta.costo_venta','articulo.nombre as articulo','articulo.id_categoria',
        'categoria.nombre as categoria','detalle_venta.cantidad','detalle_venta.sub_total','tienda.nombre as tienda','tienda_articulo.stock','tienda.id as id_tienda')
        ->where('detalle_venta.id_venta','=',$id)
        ->where('detalle_venta.eliminado','=',1)
        ->orderBy('detalle_venta.id','asc')
        ->get();
        return $obj;
    }
    
    public function anular(Request $request){
        $id = $request->id;
        $id_mesa = $request->id_mesa;
        //dd($id_mesa);
        $detalles = DetalleVenta::join('tienda_articulo','detalle_venta.id_tienda_articulo','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->select('detalle_venta.id_venta as Id_Venta','detalle_venta.id_tienda_articulo as Id_Producto','detalle_venta.cantidad as Cantidad','articulo.id_tipo_producto')
        ->where('detalle_venta.eliminado','=',1)
        ->where('detalle_venta.id_venta',$request->id)
        ->get();
        //dd($detalles);
        foreach($detalles as $ep=>$det){
            if($det->id_tipo_producto == 2){
                DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->Id_Producto)
                ->increment('stock', $det->Cantidad);
                $tienda_articulo=DB::select("SELECT ta.stock
                FROM tienda_articulo ta
                WHERE ta.id = '$det->Id_Producto'");
    
                $ajuste = new Ajuste();
                $ajuste->stock=$det->Cantidad;
                $ajuste->costo_compra=0;
                $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det->Cantidad;
                $ajuste->stock_actual=$tienda_articulo[0]->stock;
                $ajuste->costo_venta=0;
                $ajuste->observacion='';
                $ajuste->id_articulo=$det->Id_Producto;
                $ajuste->id_motivo_ajuste=9;
                $ajuste->save();
            }
            if($det->id_tipo_producto == 3){
                DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->Id_Producto)
                ->increment('stock', $det->Cantidad);

                $tienda_articulo=DB::select("SELECT ta.stock
                FROM tienda_articulo ta
                WHERE ta.id = '$det->Id_Producto'");
    
                $ajuste = new Ajuste();
                $ajuste->stock=$det->Cantidad;
                $ajuste->costo_compra=0;
                $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det->Cantidad;
                $ajuste->stock_actual=$tienda_articulo[0]->stock;
                $ajuste->costo_venta=0;
                $ajuste->observacion='';
                $ajuste->id_articulo=$det->Id_Producto;
                $ajuste->id_motivo_ajuste=9;
                $ajuste->save();
            }
        }

            foreach($detalles as $ep=>$det2){
                if($det2->id_tipo_producto == 5){
                    $Combo = Combo::select('id as id_combo')
                    ->where('id_articulo','=',$det2->Id_Producto)
                    ->where('estado','=',1)
                    ->get();
                    foreach($Combo as $ep=>$det3){
                        $detallesCombo = DetalleCombo::join('articulo','detalle_combo.id_articulo','=','articulo.id')
                        ->select(DB::raw('detalle_combo.cantidad * '.$det2->Cantidad.' as Cantidad'),'detalle_combo.id_articulo','articulo.id_tipo_producto')
                        ->where('detalle_combo.id_combo','=',$det3->id_combo)
                        ->where('detalle_combo.estado','=',1)->get();
                    }
                    foreach($detallesCombo as $ep=>$det4){
                            if($det4->id_tipo_producto == 2 || $det4->id_tipo_producto == 3){
                                DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det4->id_articulo)
                                ->increment('stock', $det4->Cantidad);
                            }
                            $tienda_articulo=DB::select("SELECT ta.stock
                            FROM tienda_articulo ta
                            WHERE ta.id = '$det4->id_articulo'");
                
                            $ajuste = new Ajuste();
                            $ajuste->stock=$det4->Cantidad;
                            $ajuste->costo_compra=0;
                            $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det4->Cantidad;
                            $ajuste->stock_actual=$tienda_articulo[0]->stock;
                            $ajuste->costo_venta=0;
                            $ajuste->observacion='';
                            $ajuste->id_articulo=$det4->id_articulo;
                            $ajuste->id_motivo_ajuste=9;
                            $ajuste->save();
                    }
                }  
            }

        $obj = Venta::findOrFail($request->id);
        $obj->estado = 'Anulado';
        $obj->anulado = 'Anulado';
        $obj->save();

        $affected = DB::table('mesa')
        ->where('id', $id_mesa)
        ->update(['estado' => '1']); 

        $datos = [
            'tabla' => 'venta',
            'codigo_tabla' => $obj->id,
            'transaccion' => 'Anular Venta',
        ];
        $this->guardarBitacora($datos); 


    }

    private function descontarCajaContado($monto,$id_usuario){
        // DD($monto,$id_usuario);
         DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
         ->where('arqueo_caja.estado','=','Abierta')
         ->decrement('arqueo_caja.total_efectivo', $monto);
     }
    private function descontarCajaContadoDeposito($monto,$id_usuario){
        //DD($id_usuario);
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->decrement('arqueo_caja.total_deposito', $monto);
    }
    private function descontarCajaDeposito($monto,$id_usuario){
        //DD($id_usuario);
        DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$id_usuario)
        ->where('arqueo_caja.estado','=','Abierta')
        ->decrement('arqueo_caja.registro_venta', $monto);
    }

    public function anularVentaD(Request $request){

        try{
            DB::beginTransaction();

            $id = $request->id;
            $id_mesa = $request->id_mesa;
            //DD($id);
            
            $registro_venta = DB::select("SELECT id, total, id_tipo_pago,id_forma_pago,total_efectivo,total_deposito,id_usuario FROM venta WHERE venta.id = $request->id");
            $usuario_ultima_caja_abierta = DB::table('users')->join('arqueo_caja', 'arqueo_caja.id_usuario', '=', 'users.id')
            ->select('users.name', 'users.id')->where('arqueo_caja.estado', '=', 'Abierta')
            ->first();

            //dd($usuario_ultima_caja_abierta);
            //dd($registro_venta);
            /*DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$registro_venta[0]->id_usuario)
            ->where('arqueo_caja.estado','=','Abierta')
            ->decrement('arqueo_caja.pago_parcial', $registro_venta[0]->monto_pago_parcial);*/
    
            $total = $registro_venta[0]->total;
            $total_efectivo = $registro_venta[0]->total_efectivo;
            $total_deposito = $registro_venta[0]->total_deposito;
            //dd($total_deposito);
            $forma_pago = $registro_venta[0]->id_forma_pago;
            //dd($forma_pago);

            $id_usuario_v = $usuario_ultima_caja_abierta->id; 
            //DD($id_usuario_v);
            $tipo_pago = $registro_venta[0]->id_tipo_pago;
            $id_usuario=$request->id_usuario;
            $objdate = new DateTime();
            $fechaactual= $objdate->format('Y-m-d');
            $hora= $objdate->format('H:i:s');
    
            if($tipo_pago == "1"){
                if($forma_pago ==2){
                    $this->descontarCaja($total,$id_usuario_v);
                    $this->descontarCajaContado($total,$id_usuario_v);// no tengo
                }
                if($forma_pago ==3 || $forma_pago ==4 || $forma_pago ==5 || $forma_pago ==7){
                    $this->descontarCaja($total,$id_usuario_v);
                    $this->descontarCajaContadoDeposito($total,$id_usuario_v);// no tengo
                }
                if($forma_pago ==6){
                    //dd($forma_pago);
                    $this->descontarCaja($total_efectivo,$id_usuario_v);
                    $this->descontarCajaContado($total_efectivo,$id_usuario_v);
    
                    $this->descontarCajaDeposito($total_deposito,$id_usuario_v);//no tengo
                    $this->descontarCajaContadoDeposito($total_deposito,$id_usuario_v);
                }
    
              
            }/*else if ($tipo_pago == "2"){
                $total_monto_credito= 0;
                $registro_venta_pago = DB::select("SELECT id, id_venta FROM pago WHERE id_venta = $request->id");
                $id_pago = $registro_venta_pago[0]->id;
                $registro_venta_credito = DB::select("SELECT id, id_pago, amortizacion,id_forma_pago FROM c_x_cobrar WHERE c_x_cobrar.id_pago = $id_pago");
                //$id_forma_pago = $registro_venta_credito[0]->id_forma_pago;
                foreach($registro_venta_credito as $credito){
                    $total_monto_credito = $total_monto_credito + floatval($credito->amortizacion);
                    //dd($credito->id_forma_pago);
                    if($credito->id_forma_pago == 2){
                        $this->descontarCajaCredito($credito->amortizacion,$id_usuario);
                    }
                    if($credito->id_forma_pago == 3 || $credito->id_forma_pago == 4 || $credito->id_forma_pago == 5){
                        $this->descontarCajaCreditoDeposito($credito->amortizacion,$id_usuario);
                    }
                }
                $this->descontarCaja($total_monto_credito,$id_usuario);
    
            }*/
    
    
    
    
    
            $detalles = DetalleVenta::join('tienda_articulo','detalle_venta.id_tienda_articulo','=','tienda_articulo.id')
            ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->select('detalle_venta.id_venta as Id_Venta','detalle_venta.id_tienda_articulo as Id_Producto', 'articulo.id as Id_Articulo','detalle_venta.cantidad as Cantidad','articulo.id_tipo_producto')
            ->where('detalle_venta.eliminado','=',1)
            ->where('detalle_venta.id_venta',$request->id)
            ->get();
            //dd($detalles);
            foreach($detalles as $ep=>$det){
                if($det->id_tipo_producto == 2){
                    // DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->Id_Producto)
                    // ->increment('stock', $det->Cantidad);
                    /*$tienda_articulo=DB::select("SELECT ta.stock
                    FROM tienda_articulo ta
                    WHERE ta.id = '$det->Id_Producto'");
        
                    $ajuste = new Ajuste();
                    $ajuste->stock=$det->Cantidad;
                    $ajuste->costo_compra=0;
                    $ajuste->stock_anterior=0;
                    $ajuste->stock_actual=0;
                    $ajuste->costo_venta=0;
                    $ajuste->observacion='';
                    $ajuste->id_articulo=$det->Id_Producto;
                    $ajuste->id_motivo_ajuste=9;
                    $ajuste->save();*/
    
                    /*DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->Id_Producto)
                    ->increment('stock', $det->Cantidad);
    
                    $tienda_articulo=DB::select("SELECT ta.stock
                    FROM tienda_articulo ta
                    WHERE ta.id = '$det->Id_Producto'");
        
                    $ajuste = new Ajuste();
                    $ajuste->stock=$det->Cantidad;
                    $ajuste->costo_compra=0;
                    $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det->Cantidad;
                    $ajuste->stock_actual=$tienda_articulo[0]->stock;
                    $ajuste->costo_venta=0;
                    $ajuste->observacion='';
                    $ajuste->id_articulo=$det->Id_Producto;
                    $ajuste->id_motivo_ajuste=9;
                    $ajuste->save();*/
    
                }
                if($det->id_tipo_producto == 3){
                    DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->Id_Articulo)
                    ->increment('stock', $det->Cantidad);
    
                    $tienda_articulo=DB::select("SELECT ta.stock
                    FROM tienda_articulo ta
                    WHERE ta.id = '$det->Id_Producto'");
        
                    $ajuste = new Ajuste();
                    $ajuste->stock=$det->Cantidad;
                    $ajuste->costo_compra=0;
                    $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det->Cantidad;
                    $ajuste->stock_actual=$tienda_articulo[0]->stock;
                    $ajuste->costo_venta=0;
                    $ajuste->observacion='';
                    $ajuste->id_articulo=$det->Id_Articulo;
                    $ajuste->id_motivo_ajuste=9;
                    $ajuste->save();
                }
            }
    
                foreach($detalles as $ep=>$det2){
                    //dd($detalles);
                    if($det2->id_tipo_producto == 5){
                        $Combo = Combo::select('id as id_combo')
                        ->where('id_articulo','=',$det2->Id_Articulo)
                        ->where('estado','=',1)
                        ->get();
                        foreach($Combo as $ep=>$det3){
                            $detallesCombo = DetalleCombo::join('articulo','detalle_combo.id_articulo','=','articulo.id')
                            ->select(DB::raw('detalle_combo.cantidad * '.$det2->Cantidad.' as Cantidad'),'detalle_combo.id_articulo','articulo.id_tipo_producto')
                            ->where('detalle_combo.id_combo','=',$det3->id_combo)
                            ->where('detalle_combo.estado','=',1)->get();
                        }
                        //dd($detallesCombo);

                        foreach($detallesCombo as $ep=>$det4){
                                //if($det4->id_tipo_producto == 3 || $det4->id_tipo_producto == 2){
                                if($det4->id_tipo_producto == 3){
    
                                    DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det4->id_articulo)
                                    ->increment('stock', $det4->Cantidad);
                                }
                                $tienda_articulo=DB::select("SELECT ta.stock
                                FROM tienda_articulo ta
                                WHERE ta.id = '$det4->id_articulo'");
                    
                                $ajuste = new Ajuste();
                                $ajuste->stock=$det4->Cantidad;
                                $ajuste->costo_compra=0;
                                $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det4->Cantidad;
                                $ajuste->stock_actual=$tienda_articulo[0]->stock;
                                $ajuste->costo_venta=0;
                                $ajuste->observacion='';
                                $ajuste->id_articulo=$det4->id_articulo;
                                $ajuste->id_motivo_ajuste=9;
                                $ajuste->save();
                        }
                    }  
                }
    
            $obj = Venta::findOrFail($request->id);
            $obj->estado = 'Anulado';
            $obj->anulado = 'Anulado';
            $obj->save();
    
            // $affected = DB::table('mesa')
            // ->where('id', $id_mesa)
            // ->update(['estado' => '1']); 
    
            $datos = [
                'tabla' => 'venta',
                'codigo_tabla' => $obj->id,
                'transaccion' => 'Anular Venta',
            ];
            $this->guardarBitacora($datos); 
    
    
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
      
    }

    public function anular2(Request $request){
        //$id = $request->id;
       
        try{
            DB::beginTransaction();

            $id_mesa = $request->id_mesa;

            $auxventa = DB::table('venta as v')
            ->join('mesa','v.id_mesa','=','mesa.id')
            ->join('cliente as c','v.id_cliente','=','c.id')
            ->select('v.id', 'v.total')
            ->where('v.id_mesa','=',$id_mesa)
            ->orderBy('v.id','desc')
            ->first();

            

            $id=$auxventa->id;
            // Descuento para monto parcial
            //$registro_venta = DB::select("SELECT id, total, id_tipo_pago,id_forma_pago,total_efectivo,total_deposito,id_usuario, monto_pago_parcial FROM venta WHERE venta.id = $id");

            /*DB::table('arqueo_caja')->where('arqueo_caja.id_usuario','=',$registro_venta[0]->id_usuario)
            ->where('arqueo_caja.estado','=','Abierta')
            ->decrement('arqueo_caja.pago_parcial', $registro_venta[0]->monto_pago_parcial);*/

            //dd($id_mesa);
            $detalles = DetalleVenta::join('tienda_articulo','detalle_venta.id_tienda_articulo','=','tienda_articulo.id')
            ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
            ->select('detalle_venta.id_venta as Id_Venta','detalle_venta.id_tienda_articulo as Id_Producto', 'articulo.id as Id_Articulo','detalle_venta.cantidad as Cantidad','articulo.id_tipo_producto')
            ->where('detalle_venta.eliminado','=',1)
            ->where('detalle_venta.id_venta',$id)
            ->get();
            //dd($detalles);
            foreach($detalles as $ep=>$det){
                /*if($det->id_tipo_producto == 2){
                    DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->Id_Producto)
                    ->increment('stock', $det->Cantidad);
                    $tienda_articulo=DB::select("SELECT ta.stock
                    FROM tienda_articulo ta
                    WHERE ta.id = '$det->Id_Producto'");
        
                    $ajuste = new Ajuste();
                    $ajuste->stock=$det->Cantidad;
                    $ajuste->costo_compra=0;
                    $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det->Cantidad;
                    $ajuste->stock_actual=$tienda_articulo[0]->stock;
                    $ajuste->costo_venta=0;
                    $ajuste->observacion='';
                    $ajuste->id_articulo=$det->Id_Producto;
                    $ajuste->id_motivo_ajuste=9;
                    $ajuste->save();
                }*/
                if($det->id_tipo_producto == 3){
                    DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->Id_Articulo)
                    ->increment('stock', $det->Cantidad);

                    $tienda_articulo=DB::select("SELECT ta.stock
                    FROM tienda_articulo ta
                    WHERE ta.id = '$det->Id_Producto'");
        
                    $ajuste = new Ajuste();
                    $ajuste->stock=$det->Cantidad;
                    $ajuste->costo_compra=0;
                    $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det->Cantidad;
                    $ajuste->stock_actual=$tienda_articulo[0]->stock;
                    $ajuste->costo_venta=0;
                    $ajuste->observacion='';
                    $ajuste->id_articulo=$det->Id_Articulo;
                    $ajuste->id_motivo_ajuste=9;
                    $ajuste->save();
                }
            }
            //dd($detalles);
            foreach($detalles as $ep=>$det2){
                if($det2->id_tipo_producto == 5){
                    $Combo = Combo::select('id as id_combo')
                    ->where('id_articulo','=',$det2->Id_Articulo)
                    ->where('estado','=',1)
                    ->get();
                    foreach($Combo as $ep=>$det3){
                        $detallesCombo = DetalleCombo::join('articulo','detalle_combo.id_articulo','=','articulo.id')
                        ->select(DB::raw('detalle_combo.cantidad * '.$det2->Cantidad.' as Cantidad'),'detalle_combo.id_articulo','articulo.id_tipo_producto')
                        ->where('detalle_combo.id_combo','=',$det3->id_combo)
                        ->where('detalle_combo.estado','=',1)->get();
                    }
                    foreach($detallesCombo as $ep=>$det4){
                            if($det4->id_tipo_producto == 3){
                                DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det4->id_articulo)
                                ->increment('stock', $det4->Cantidad);
                            }
                            $tienda_articulo=DB::select("SELECT ta.stock
                            FROM tienda_articulo ta
                            WHERE ta.id = '$det4->id_articulo'");
                
                            $ajuste = new Ajuste();
                            $ajuste->stock=$det4->Cantidad;
                            $ajuste->costo_compra=0;
                            $ajuste->stock_anterior=$tienda_articulo[0]->stock - $det4->Cantidad;
                            $ajuste->stock_actual=$tienda_articulo[0]->stock;
                            $ajuste->costo_venta=0;
                            $ajuste->observacion='';
                            $ajuste->id_articulo=$det4->id_articulo;
                            $ajuste->id_motivo_ajuste=9;
                            $ajuste->save();
                    }
                }  
            }

            $obj = Venta::findOrFail($id);
            $obj->estado = 'Anulado';
            $obj->anulado = 'Anulado';
            $obj->save();

            $affected = DB::table('mesa')
            ->where('id', $id_mesa)
            ->update(['estado' => '1']); 

            $datos = [
                'tabla' => 'venta',
                'codigo_tabla' => $obj->id,
                'transaccion' => 'Anular Venta',
            ];
            $this->guardarBitacora($datos); 

            
            
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
        
    }

    public function cantidadRegistros(){
        $mayor = DB::table('control')->count();
        return $mayor;
    }

    private function correlativoControl(){
       $mayor = DB::table('control')->where('control.tabla','=','Venta')->count();
        return $mayor;
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

    public function pdfVentasGeneral(Request $request){

        $id = $request->id;
        $foto = $request->foto;
        $empresa_nombre = $request->empresa_nombre;
        
        $venta= Venta::join('users','venta.id_usuario','=','users.id')
        ->join('cliente','venta.id_cliente','=','cliente.id')
        ->join('tipo_pago','venta.id_tipo_pago','=','tipo_pago.id')
        ->join('forma_pago','venta.id_forma_pago','=','forma_pago.id')
        ->join('tienda','venta.id_tienda','=','tienda.id')
        ->select('venta.id','venta.fecha','venta.sub_total','venta.descuento',
        'venta.total','venta.estado','users.name','cliente.nombre as cliente','cliente.descuento as id_descuento','tipo_pago.nombre as tipoP','forma_pago.nombre as formaP',
        'tienda.cod_tienda','tienda.nombre as tienda','tienda.direccion as tienda_direccion','tienda.cod_almacen')
        ->where('venta.id',$id)
        ->orderBy('venta.id','desc')->get();

        $detalleVenta= detalleVenta::join('tienda_articulo','detalle_venta.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_venta.id_venta','detalle_venta.costo_venta','articulo.costo_unitario as costo_unitario','articulo.costo_mayorista as costo_mayorista','articulo.costo_preferencial as costo_preferencial','articulo.nombre as articulo','detalle_venta.cantidad','detalle_venta.sub_total','tienda.nombre as tienda')
        ->where('detalle_venta.id_venta','=',$id)
        ->get();

        $usuario = \Auth::user()->name;
        $objdate = new DateTime();
        $fecha_impresion=$objdate->format('d/m/Y');
        $cliente=$venta[0]->cliente;
        $fecha=$venta[0]->fecha;
        $tipo_pago=$venta[0]->tipoP;
        $forma_pago=$venta[0]->formaP;
        $id_descuento=$venta[0]->id_descuento;
        $detalles=$detalleVenta;
        $total=$venta[0]->total;
        $descuento=$venta[0]->descuento;
        $sub_total=$venta[0]->sub_total;

        $tienda=$venta[0]->tienda;
        if($venta[0]->id_descuento == 1) {
            $descuento_pago= 'Precio Unitario';
        } else if ($venta[0]->id_descuento == 2) {
            $descuento_pago= 'Precio Mayorista';
        } else if ($venta[0]->id_descuento == 3) {
            $descuento_pago=  'Precio Preferencial';
        } else {}

        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.venta.venta-general', [
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
            'foto'=>$foto,
            'fecha_impresion'=>$fecha_impresion,
            'usuario'=>$usuario,
            'empresa_nombre'=>$empresa_nombre,

            'tienda'=>$tienda
        ]);
        return $pdf->stream('Ventas.pdf');
    }

    //Venta Mesero
    public function cabeceraVentaModificar(Request $request){
        //$id_venta = $request->id_venta;
        $id_mesa = $request->id_mesa;
        //dd($id_mesa);
        $venta = DB::table('venta as v')
        ->join('mesa','v.id_mesa','=','mesa.id')
        ->join('cliente as c','v.id_cliente','=','c.id')
        ->select('v.id as Id_Venta','c.nombre as cliente','c.descuento','v.total as monto','mesa.nombre as Mesa','v.id_mesa as NMesa','v.id_cliente')
        // ->select('v.id_venta as Id_Venta','c.nombre as cliente','v.total as monto','v.correlativo as nro','mesa.nombre as Mesa','v.Descripcion as usuario','v.id_mesa as NMesa')
        //->where('v.Id_Venta','=',$id_venta)
        ->where('v.id_mesa','=',$id_mesa)
        ->orderBy('v.id','desc')
        ->first();
        //dd($venta);
        return $venta;
    }

    public function cabeceraVentaModificar2(Request $request){
        //$id_venta = $request->id_venta;
        //$id_mesa = $request->id_mesa;
        //dd($id_mesa);
        $venta = DB::table('venta as v')
        ->join('mesa','v.id_mesa','=','mesa.id')
        ->join('cliente as c','v.id_cliente','=','c.id')
        ->select('v.id as Id_Venta','c.nombre as cliente','c.descuento','v.total as monto','mesa.nombre as Mesa','v.id_mesa as NMesa','v.id_cliente')
        // ->select('v.id_venta as Id_Venta','c.nombre as cliente','v.total as monto','v.correlativo as nro','mesa.nombre as Mesa','v.Descripcion as usuario','v.id_mesa as NMesa')
        ->where('v.id','=',$request->id_venta)
        ->first();
        
       
        //dd($venta);
        return $venta;
    }
    public function ActEstado(Request $request){
        //$ = $request->id_venta;   
        $affected = DB::table('detalle_venta')
        ->where('id_venta', $request->id_venta)
        ->update(['estado' => 0]); 
       
    }
    public function detalleVentaM(Request $request){
        $id_venta = $request->id_venta;
        //dd($id_venta);
        $venta = DB::table('detalle_venta as dv')
        ->join('tienda_articulo as t','dv.id_tienda_articulo','=','t.id')
        ->join('articulo as p','t.id_articulo','=','p.id')
        ->select('dv.id_tienda_articulo as id_producto','p.nombre as producto','dv.cantidad',
        'dv.costo_venta as precio','dv.sub_total as preciov','t.stock','dv.estado', 'dv.descripcion','p.id_tipo_producto',
        'dv.id as id_detalle_venta','dv.estado as eliminado','p.contenido_presentacion as cantidad_presentacion','p.id_producto_compuesto','dv.id_venta')
        ->where('dv.id_venta','=',$id_venta)
        ->where('dv.eliminado','=',1)
        //->where('dv.estado','=',0)
        //->where('dv.estado','=',1)
        ->get();
        return $venta;
    }
    public function modificar(Request $request){
        try{
            DB::beginTransaction();

            //dd($request->id_tienda);
            $id_usuario=\Auth::user()->id;
            $descuento = $request->descuento * $request->sub_total/100;
            $id_tienda=\Auth::user()->id_tienda;


              $arrayDetalleCombo = $request->arrayDetalleCombo;
              // dd($arrayDetalleCombo);
              foreach($arrayDetalleCombo as $ep=>$stock){
                  if($stock['id_tipo_producto'] == 3){
                    if($id_tienda == 100){
                        $this->actualizarStock2($stock['id_producto'],$stock['cantidad']);  
                    }else
                    {
                        $this->actualizarStock2($stock['id_producto'],$stock['cantidad']);  
                    }  
                  }
                  $id_producto = $stock['id_producto'];
                  $tienda_articulo=DB::select("SELECT ta.stock
                  FROM tienda_articulo ta
                  WHERE ta.id = '$id_producto'");
      
                  $ajuste = new Ajuste();
                  $ajuste->stock=$stock['cantidad'];
                  $ajuste->costo_compra=0;
                  $ajuste->stock_anterior=$tienda_articulo[0]->stock + $stock['cantidad'];
                  $ajuste->stock_actual=$tienda_articulo[0]->stock;
                  $ajuste->costo_venta=$stock['precio'];
                  $ajuste->observacion='';
                  $ajuste->id_articulo=$stock['id_producto'];
                  $ajuste->id_motivo_ajuste=8;
                  $ajuste->save();
              }
            //   $arrayDetalleProductoSimple = $request->arrayDetalleProductoSimple;
            //   //dd($arrayDetalleProductoSimple);
            //   foreach($arrayDetalleProductoSimple as $ep=>$simp){
            //           $this->actualizarStock($simp['id_producto'],$simp['cantidad']);
            //           $id_producto = $simp['id_producto'];
            //           $tienda_articulo=DB::select("SELECT ta.stock
            //           FROM tienda_articulo ta
            //           WHERE ta.id = '$id_producto'");
          
            //           $ajuste = new Ajuste();
            //           $ajuste->stock=$simp['cantidad'];
            //           $ajuste->costo_compra=0;
            //           $ajuste->stock_anterior=$tienda_articulo[0]->stock + $simp['cantidad'];
            //           $ajuste->stock_actual=$tienda_articulo[0]->stock;
            //           $ajuste->costo_venta=$simp['precio'];
            //           $ajuste->observacion='';
            //           $ajuste->id_articulo=$simp['id_producto'];
            //           $ajuste->id_motivo_ajuste=8;
            //           $ajuste->save();

            //     }
            //     $arrayDetalleProductoElaborado = $request->arrayDetalleProductoElaborado;
            //     foreach($arrayDetalleProductoElaborado as $ep=>$elab){
            //         $this->actualizarStock($elab['id_producto'],$elab['cantidad']);
            //         $id_producto = $elab['id_producto'];
            //         $tienda_articulo=DB::select("SELECT ta.stock
            //         FROM tienda_articulo ta
            //         WHERE ta.id = '$id_producto'");
        
            //         $ajuste = new Ajuste();
            //         $ajuste->stock=$elab['cantidad'];
            //         $ajuste->costo_compra=0;
            //         $ajuste->stock_anterior=$tienda_articulo[0]->stock + $elab['cantidad'];
            //         $ajuste->stock_actual=$tienda_articulo[0]->stock;
            //         $ajuste->costo_venta=$elab['precio'];
            //         $ajuste->observacion='';
            //         $ajuste->id_articulo=$elab['id_producto'];
            //         $ajuste->id_motivo_ajuste=8;
            //         $ajuste->save();
            //     }

            $detalles = $request->detalle;
            foreach($detalles as $ep=>$det){  
                if ($det['Estado'] == 1) {
                $detall = DB::table('detalle_venta')->where('id_venta',$request->Id_Venta)->where('id_tienda_articulo',$det['id_tienda_articulo'])->first();
                    $obj = new DetalleVenta();
                    $obj->id_venta= $request->Id_Venta;
                    $obj->id_tienda_articulo= $det['id_tienda_articulo'];
                    $obj->cantidad= $det['cantidad'];
                    $obj->descripcion= empty($det['descripcion'])?'':$det['descripcion'];
                    //$obj->descripcion= $det['descripcion'];
                    $obj->costo_venta= $det['precio'];
                    $obj->sub_total= $det['cantidad']*$det['precio'];
                    $obj->id_usuario=$id_usuario;
                    $obj->save();

                    if($det['id_tipo_producto'] == 2)
                    {
                        //$this->actualizarStock($det['id_tienda_articulo'],$det['cantidad']);
                        $id_producto = $det['id_tienda_articulo'];
                        $tienda_articulo=DB::select("SELECT ta.stock
                        FROM tienda_articulo ta
                        WHERE ta.id = '$id_producto'");
            
                        $ajuste = new Ajuste();
                        $ajuste->stock=$det['cantidad'];
                        $ajuste->costo_compra=0;
                        $ajuste->stock_anterior=0;
                        $ajuste->stock_actual=0;
                        $ajuste->costo_venta=$det['costo_venta'];
                        $ajuste->observacion='';
                        $ajuste->id_articulo=$det['id_tienda_articulo'];
                        $ajuste->id_motivo_ajuste=8;
                        $ajuste->save();
                    }

                    if($det['id_tipo_producto'] == 3)
                    {
                        $this->actualizarStock2($det['id_tienda_articulo'],$det['cantidad']);
                        $id_producto = $det['id_tienda_articulo'];
                        $tienda_articulo=DB::select("SELECT ta.stock
                        FROM tienda_articulo ta
                        WHERE ta.id = '$id_producto'");
            
                        $ajuste = new Ajuste();
                        $ajuste->stock=$det['cantidad'];
                        $ajuste->costo_compra=0;
                        $ajuste->stock_anterior=$tienda_articulo[0]->stock + $det['cantidad'];
                        $ajuste->stock_actual=$tienda_articulo[0]->stock;
                        $ajuste->costo_venta=$det['costo_venta'];
                        $ajuste->observacion='';
                        $ajuste->id_articulo=$det['id_tienda_articulo'];
                        $ajuste->id_motivo_ajuste=8;
                        $ajuste->save();
                    }

                }
                else{  
                }

            }
            //dd($request->total,$request->sub_total,$request->descuento);
            if($request->observacion == ''){
                $affected = DB::table('venta')
                ->where('id', $request->Id_Venta)
                ->update(['total' => $request->total,'sub_total' => $request->sub_total,'descuento' => $descuento,'observacion' => '.']);
            }else
            {
                $affected = DB::table('venta')
                ->where('id', $request->Id_Venta)
                ->update(['total' => $request->total,'sub_total' => $request->sub_total,'descuento' => $descuento,'observacion' => $request->observacion]);
            }

            $affected = DB::table('venta')
            ->where('id', $request->Id_Venta)
            ->update(['imprimir' => 0]); 
            
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function contrasena(Request $request){
       
        $objeto=DB::select("SELECT nombre as Contrasena from contrasena");
        $objeto1=(object) $objeto[0];
        return $objeto1;

    }

    public function cobrarMesa(Request $request){
        try{
            DB::beginTransaction();

            //dd($request->efectivo,$request->cambio);
            //dd($request->descuento);
            $registro_venta = $request->total;
            $registro_venta_efectivo = $request->total_efectivo;
            $registro_venta_deposito = $request->total_deposito;
            $id_usuario=\Auth::user()->id;
            $objdate = new DateTime();
            $fechaactual= $objdate->format('Y-m-d');
            $hora= $objdate->format('H:i:s');

            $id_cliente = $request->id_cliente;
            //dd($id_cliente);
            if($id_cliente==0){
                $buscar_cliente = DB::select("SELECT id FROM cliente WHERE cliente.nombre = '$request->cliente'");
                //$buscar_cliente = Cliente::select('id')->where('cliente.nombre', '=', $request->cliente)->get();

                if($buscar_cliente == []){
                    $cliente= new Cliente();
                    $cliente->nombre=$request->cliente;
                    $cliente->matricula=0;
                    $cliente->telefono=0;
                    $cliente->direccion='';
                    $cliente->descripcion='';
                    $cliente->descuento=1;
                    $cliente->estado=1;
                    $cliente->save();

                    $var2=DB::select("SELECT  MAX(id) as id_cliente from cliente");
                    //dd($var2);
                    $id_cliente=$var2[0]->id_cliente;
                } else {
                    $id_cliente = $buscar_cliente[0]->id;
                }
            }
            
            $venta= Venta::findOrFail($request->id);
            $venta->id_tipo_pago=$request->id_tipo_pago;
            $venta->id_cliente=$id_cliente;
            $venta->efectivo=$request->efectivo;
            $venta->cambio=$request->cambio;
            $venta->estado='Cobrado';
            $venta->tipo_venta=1;
            if($request->id_forma_pago == 6){
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;
            }else if($request->id_forma_pago == 2)
            {
                $venta->total_efectivo =$request->total;
                $venta->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;

            }else if($request->id_forma_pago == 3)
            {
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito =$request->total;
                
            }else if($request->id_forma_pago == 4)
            {
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito =$request->total;

            }else if($request->id_forma_pago == 5)
            {
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito =$request->total;
            }else
            {
                //
            }
            if($request->id_tipo_pago == 1) {
                $venta->id_forma_pago=$request->id_forma_pago;
            }else if ($request->id_tipo_pago == 2) {
                $venta->id_forma_pago=$request->id_forma_pago;
            } else {
                //
            }
            $venta->save();

                if($request->id_tipo_pago == 1) {
                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->total;
                    $pago->saldo = $request->total;
                    $pago->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    //dd($request->total);
                    $pago->save();  
                    if($request->id_forma_pago == 2){
                    $this->actualizarCaja($id_usuario,$registro_venta);
                     $this->actualizarCajaContado($id_usuario,$registro_venta);
                    }
                    if($request->id_forma_pago == 3 || $request->id_forma_pago == 4 || $request->id_forma_pago == 5){
                        $this->actualizarCaja($id_usuario,$registro_venta);
                        $this->actualizarCajaDeposito($id_usuario,$registro_venta);
                    }
                    if($request->id_forma_pago == 6){
                        $this->actualizarCaja($id_usuario,$registro_venta_efectivo);
                        $this->actualizarCajaContado($id_usuario,$registro_venta_efectivo);
                        $this->actualizarCaja($id_usuario,$registro_venta_deposito);
                        $this->actualizarCajaDeposito($id_usuario,$registro_venta_deposito);
                    }

                } else if($request->id_tipo_pago == 2) {

                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->total;
                    $pago->saldo = $request->total;
                    $pago->descripcion = $request->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    $pago->save(); 

                    $cxcobrar = new CXCobrar();
                    $cxcobrar->fecha = $request->fecha;
                    $cxcobrar->monto_total = $request->monto_total;
                    $cxcobrar->descripcion = $request->descripcion_pago;
                    $cxcobrar->saldo = $request->monto_total;
                    $cxcobrar->id_pago = $venta->id;
                    $cxcobrar->id_forma_pago = 0;
                    $cxcobrar->save(); 

                } else {
                    //
                }
                $affected = DB::table('mesa')
                ->where('id', $request->id_mesa)
                ->update(['estado' => 1]); 

                // if($id_cliente==0){

                //     $affected = DB::table('venta')
                //     ->where('id', $request->id)
                //     ->update(['total' => $request->total,'sub_total' => $request->sub_total,'descuento' => 0]);
                // }else
                // {
                    $affected = DB::table('venta')
                    ->where('id', $request->id)
                    ->update(['total' => $request->total,'sub_total' => $request->sub_total,'descuento' => $request->descuento]);
                // }

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function cobrarMesaMesero(Request $request){
        try{
            DB::beginTransaction();

            //dd($request->efectivo,$request->cambio);
            //dd($request->descuento);
            $registro_venta = $request->total;
            $registro_venta_efectivo = $request->total_efectivo;
            $registro_venta_deposito = $request->total_deposito;

            $usuario_caja_abierta=DB::table('users')
            ->join('arqueo_caja', 'arqueo_caja.id_usuario', '=', 'users.id')
            ->select('users.id')
            ->where('arqueo_caja.estado', '=', 'Abierta')
            ->first();


            //$id_usuario=\Auth::user()->id;
            $id_usuario=$usuario_caja_abierta->id;
            $objdate = new DateTime();
            $fechaactual= $objdate->format('Y-m-d');
            $hora= $objdate->format('H:i:s');

            $id_cliente = $request->id_cliente;
            //dd($id_cliente);
            if($id_cliente==0){
                $buscar_cliente = DB::select("SELECT id FROM cliente WHERE cliente.nombre = '$request->cliente'");
                //$buscar_cliente = Cliente::select('id')->where('cliente.nombre', '=', $request->cliente)->get();

                if($buscar_cliente == []){
                    $cliente= new Cliente();
                    $cliente->nombre=$request->cliente;
                    $cliente->matricula=0;
                    $cliente->telefono=0;
                    $cliente->direccion='';
                    $cliente->descripcion='';
                    $cliente->descuento=1;
                    $cliente->estado=1;
                    $cliente->save();

                    $var2=DB::select("SELECT  MAX(id) as id_cliente from cliente");
                    //dd($var2);
                    $id_cliente=$var2[0]->id_cliente;
                } else {
                    $id_cliente = $buscar_cliente[0]->id;
                }
            }
            
            $venta= Venta::findOrFail($request->id);
            $venta->id_tipo_pago=$request->id_tipo_pago;
            $venta->id_cliente=$id_cliente;
            $venta->efectivo=$request->efectivo;
            $venta->cambio=$request->cambio;
            $venta->estado='Cobrado';
            $venta->tipo_venta=1;
            if($request->id_forma_pago == 6){
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;
            }else if($request->id_forma_pago == 2)
            {
                $venta->total_efectivo =$request->total;
                $venta->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;

            }else if($request->id_forma_pago == 3)
            {
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito =$request->total;
                
            }else if($request->id_forma_pago == 4)
            {
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito =$request->total;

            }else if($request->id_forma_pago == 5)
            {
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito =$request->total;
            }else
            {
                //
            }
            if($request->id_tipo_pago == 1) {
                $venta->id_forma_pago=$request->id_forma_pago;
            }else if ($request->id_tipo_pago == 2) {
                $venta->id_forma_pago=$request->id_forma_pago;
            } else {
                //
            }
            $venta->save();

                if($request->id_tipo_pago == 1) {
                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->total;
                    $pago->saldo = $request->total;
                    $pago->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    //dd($request->total);
                    $pago->save();  
                    if($request->id_forma_pago == 2){
                    $this->actualizarCaja($id_usuario,$registro_venta);
                     $this->actualizarCajaContado($id_usuario,$registro_venta);
                    }
                    if($request->id_forma_pago == 3 || $request->id_forma_pago == 4 || $request->id_forma_pago == 5){
                        $this->actualizarCaja($id_usuario,$registro_venta);
                        $this->actualizarCajaDeposito($id_usuario,$registro_venta);
                    }
                    if($request->id_forma_pago == 6){
                        $this->actualizarCaja($id_usuario,$registro_venta_efectivo);
                        $this->actualizarCajaContado($id_usuario,$registro_venta_efectivo);
                        $this->actualizarCaja($id_usuario,$registro_venta_deposito);
                        $this->actualizarCajaDeposito($id_usuario,$registro_venta_deposito);
                    }

                } else if($request->id_tipo_pago == 2) {

                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->total;
                    $pago->saldo = $request->total;
                    $pago->descripcion = $request->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    $pago->save(); 

                    $cxcobrar = new CXCobrar();
                    $cxcobrar->fecha = $request->fecha;
                    $cxcobrar->monto_total = $request->monto_total;
                    $cxcobrar->descripcion = $request->descripcion_pago;
                    $cxcobrar->saldo = $request->monto_total;
                    $cxcobrar->id_pago = $venta->id;
                    $cxcobrar->id_forma_pago = 0;
                    $cxcobrar->save(); 

                } else {
                    //
                }
                $affected = DB::table('mesa')
                ->where('id', $request->id_mesa)
                ->update(['estado' => 1]); 

                // if($id_cliente==0){

                //     $affected = DB::table('venta')
                //     ->where('id', $request->id)
                //     ->update(['total' => $request->total,'sub_total' => $request->sub_total,'descuento' => 0]);
                // }else
                // {
                    $affected = DB::table('venta')
                    ->where('id', $request->id)
                    ->update(['total' => $request->total,'sub_total' => $request->sub_total,'descuento' => $request->descuento]);
                // }

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    

    public function cobrarMesa2(Request $request){
        try{
            DB::beginTransaction();

            //dd($request->efectivo,$request->cambio);
            //dd($request->descuento);
            $registro_venta = $request->total;
            $registro_venta_efectivo = $request->total_efectivo;
            $registro_venta_deposito = $request->total_deposito;
            $id_usuario=\Auth::user()->id;
            $objdate = new DateTime();
            $fechaactual= $objdate->format('Y-m-d');
            $hora= $objdate->format('H:i:s');

            $id_cliente = $request->id_cliente;
            //dd($id_cliente);
            if($id_cliente==0){
                $buscar_cliente = DB::select("SELECT id FROM cliente WHERE cliente.nombre = '$request->cliente'");
                //$buscar_cliente = Cliente::select('id')->where('cliente.nombre', '=', $request->cliente)->get();

                if($buscar_cliente == []){
                    $cliente= new Cliente();
                    $cliente->nombre=$request->cliente;
                    $cliente->matricula=0;
                    $cliente->telefono=0;
                    $cliente->direccion='';
                    $cliente->descripcion='';
                    $cliente->descuento=1;
                    $cliente->estado=1;
                    $cliente->save();

                    $var2=DB::select("SELECT  MAX(id) as id_cliente from cliente");
                    //dd($var2);
                    $id_cliente=$var2[0]->id_cliente;
                } else {
                    $id_cliente = $buscar_cliente[0]->id;
                }
            }
            
            //$venta= Venta::findOrFail($request->id);
            $venta = DB::table('venta as v')
            ->join('mesa','v.id_mesa','=','mesa.id')
            ->join('cliente as c','v.id_cliente','=','c.id')
            ->select('v.id', 'v.total')
            ->where('v.id_mesa','=',$request->id)
            ->orderBy('v.id','desc')
            ->first();

            $venta->id_tipo_pago=$request->id_tipo_pago;
            $venta->id_cliente=$id_cliente;
            $venta->efectivo=$request->efectivo;
            $venta->cambio=$request->cambio;
            $venta->estado='Cobrado';
            $venta->tipo_venta=1;
            if($request->id_forma_pago == 6){
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;
            }else if($request->id_forma_pago == 2)
            {
                $venta->total_efectivo =$request->total;
                $venta->total_deposito = $request->total_deposito == '' ? '0' : $request->total_deposito;

            }else if($request->id_forma_pago == 3)
            {
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito =$request->total;
                
            }else if($request->id_forma_pago == 4)
            {
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito =$request->total;

            }else if($request->id_forma_pago == 5)
            {
                $venta->total_efectivo = $request->total_efectivo == '' ? '0' : $request->total_efectivo;
                $venta->total_deposito =$request->total;
            }else
            {
                //
            }
            if($request->id_tipo_pago == 1) {
                $venta->id_forma_pago=$request->id_forma_pago;
            }else if ($request->id_tipo_pago == 2) {
                $venta->id_forma_pago=$request->id_forma_pago;
            } else {
                //
            }
            $venta->save();

                if($request->id_tipo_pago == 1) {
                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->total;
                    $pago->saldo = $request->total;
                    $pago->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    //dd($request->total);
                    $pago->save();  
                    if($request->id_forma_pago == 2){
                    $this->actualizarCaja($id_usuario,$registro_venta);
                     $this->actualizarCajaContado($id_usuario,$registro_venta);
                    }
                    if($request->id_forma_pago == 3 || $request->id_forma_pago == 4 || $request->id_forma_pago == 5){
                        $this->actualizarCaja($id_usuario,$registro_venta);
                        $this->actualizarCajaDeposito($id_usuario,$registro_venta);
                    }
                    if($request->id_forma_pago == 6){
                        $this->actualizarCaja($id_usuario,$registro_venta_efectivo);
                        $this->actualizarCajaContado($id_usuario,$registro_venta_efectivo);
                        $this->actualizarCaja($id_usuario,$registro_venta_deposito);
                        $this->actualizarCajaDeposito($id_usuario,$registro_venta_deposito);
                    }

                } else if($request->id_tipo_pago == 2) {

                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->total;
                    $pago->saldo = $request->total;
                    $pago->descripcion = $request->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    $pago->save(); 

                    $cxcobrar = new CXCobrar();
                    $cxcobrar->fecha = $request->fecha;
                    $cxcobrar->monto_total = $request->monto_total;
                    $cxcobrar->descripcion = $request->descripcion_pago;
                    $cxcobrar->saldo = $request->monto_total;
                    $cxcobrar->id_pago = $venta->id;
                    $cxcobrar->id_forma_pago = 0;
                    $cxcobrar->save(); 

                } else {
                    //
                }
                $affected = DB::table('mesa')
                ->where('id', $request->id_mesa)
                ->update(['estado' => 1]); 

                // if($id_cliente==0){

                //     $affected = DB::table('venta')
                //     ->where('id', $request->id)
                //     ->update(['total' => $request->total,'sub_total' => $request->sub_total,'descuento' => 0]);
                // }else
                // {
                    $affected = DB::table('venta')
                    ->where('id', $request->id)
                    ->update(['total' => $request->total,'sub_total' => $request->sub_total,'descuento' => $request->descuento]);
                // }

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function mostrarDetalle2(Request $request){
        //$id = $request->id;
        //dd($id);
        $var2=DB::select("SELECT  MAX(id) as venta from venta");
        $id_venta=$var2[0]->venta;
        //dd($id_venta);
        
        $venta = DB::table('venta as v')
        ->join('cliente as c','v.id_cliente','=','c.id')
        ->join('mesa as m','v.id_mesa','=','m.id')
        ->select('v.id','v.usuario as vendedor','v.total','v.descuento','c.nombre as nmcliente','m.nombre as NMesa','v.fecha as Fecha','v.anulado as Anulado','v.estado','v.efectivo','v.cambio')
        ->where('v.id','=',$id_venta)
        ->get();
        
        $detalle_venta = DB::table('detalle_venta as dv')
        ->join('tienda_articulo as t','dv.id_tienda_articulo','=','t.id_articulo')
        ->join('articulo as p','t.id_articulo','=','p.id')
        ->select('dv.id_tienda_articulo as id_producto','p.nombre as producto','dv.cantidad as cantidad',
        'dv.costo_venta as precio','dv.sub_total','t.stock','dv.costo_venta')
        ->where('dv.id_venta','=',$id_venta)
        ->get();
 
        $mi_empresa= MiEmpresa::select('nombre','nit','representante','direccion','telefono'
        ,'localidad')
        ->get();
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;

        $cliente=$venta[0]->nmcliente;
        $mesa=$venta[0]->NMesa;
        $id=$venta[0]->id;
        $efectivo=$venta[0]->efectivo;
        $cambio=$venta[0]->cambio;
        $total=$venta[0]->total;
        $estado=$venta[0]->estado;
        $descuento=$venta[0]->descuento;
        $fecha=$venta[0]->Fecha;
        $vendedor=$venta[0]->vendedor;
        $anulado=$venta[0]->Anulado;
        //$TotalN=$venta[0]->tot;
        $detalles=$detalle_venta;

        $formatter = new NumeroALetras();
        $total_palabra= $formatter->toInvoice($total, 2, 'bs');


        $fileName = 'ticket_venta.pdf';
        $data = [
            'id' => $id,
            'nombre_empresa' => $nombre_empresa,
            'total' => $total,
            'efectivo' => $efectivo,
            'cambio' => $cambio,
            'estado' => $estado,
            'descuento' => $descuento,
            'total_palabra' => $total_palabra,
            //'codigo' => $codigo,
            'fecha' => $fecha,
            //'nro' => $nro,
            //'descripcion' => $descripcion,
            'anulado' => $anulado,
            //  'TotalN' => $TotalN,
            'direccion_empresa' => $direccion_empresa,
            'telefono_empresa' => $telefono_empresa,
            'cliente' => $cliente,
            'mesa' => $mesa,
            'vendedor' => $vendedor,
            'detalles' => $detalles,
        ];

        $mpdf = new \Mpdf\Mpdf([
            'tempDir'=>storage_path('tempdir'),
            'utf-8', 
            'format' => [70, 150],
            'margin_top' => -1,
            'margin_left' => 2,
            'margin_right' => 4,
            'margin_bottom' => 5,
        ]);
        $html = \View::make('pdf.ticket.ticket_venta',$data);
        $html = $html->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }
    public function mostrarDetalle(Request $request){
        $id = $request->id;
        

        $var2 = DB::table('venta')
        ->where('id', $id)
        ->update(['imprimir' => 1]);  
        

        
        $venta = DB::table('venta as v')
        ->join('cliente as c','v.id_cliente','=','c.id')
        ->join('mesa as m','v.id_mesa','=','m.id')
        ->select('v.id','v.usuario as vendedor','v.total','c.nombre as nmcliente','m.nombre as NMesa','v.fecha as Fecha','v.anulado as Anulado','v.observacion')
        ->where('v.id','=',$id)
        ->get();
        
        $detalle_venta = DB::table('detalle_venta as dv')
        ->join('tienda_articulo as t','dv.id_tienda_articulo','=','t.id_articulo')
        ->join('articulo as p','t.id_articulo','=','p.id')
        ->select('dv.id_tienda_articulo as id_producto','p.nombre as producto','dv.cantidad as cantidad',
        'dv.costo_venta as precio','dv.sub_total as preciov','t.stock')
        ->where('dv.estado','=',1)
        ->where('dv.id_venta','=',$id)
        ->get();
        //dd($detalle_venta);



        $mi_empresa= MiEmpresa::select('nombre','nit','representante','direccion','telefono'
        ,'Localidad')
        ->get();


        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;

        $cliente=$venta[0]->nmcliente;
        $mesa=$venta[0]->NMesa;
        $id=$venta[0]->id;
        $total=$venta[0]->total;
        $observacion=$venta[0]->observacion;
        $fecha=$venta[0]->Fecha;
        $vendedor=$venta[0]->vendedor;
        $anulado=$venta[0]->Anulado;
        //$TotalN=$venta[0]->tot;
        $detalles=$detalle_venta;

        


        $fileName = 'ticket_venta.pdf';
        $data = [
            'id' => $id,
            'nombre_empresa' => $nombre_empresa,
            'total' => $total,
            'observacion' => $observacion,
            'fecha' => $fecha,
            'anulado' => $anulado,
            'direccion_empresa' => $direccion_empresa,
            'telefono_empresa' => $telefono_empresa,
            'cliente' => $cliente,
            'mesa' => $mesa,
            'vendedor' => $vendedor,
            'detalles' => $detalles,
        ];

        $mpdf = new \Mpdf\Mpdf([
            'tempDir'=>storage_path('tempdir'),
            'utf-8', 
            'format' => [70, 45],
            'margin_top' =>0,
            'margin_left' => 2,
            'margin_right' => 2,
            'margin_bottom' => 0,
        ]);
        $html = \View::make('pdf.ticket.ticket_preventa',$data);
        $html = $html->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }
    public function imprimirVenta(Request $request){
        $id = $request->id;
        //dd($request->id);
        $var2 = DB::table('venta')
        ->where('id', $id)
        ->update(['imprimir' => 1]);  
    }
    public function pdfPreVenta(Request $request){
        $id = $request->id;
        //$id_tienda = $request->id_tienda;
        //dd($id_tienda);
        $venta = DB::table('venta as v')
        ->join('cliente as c','v.id_cliente','=','c.id')
        ->join('mesa as m','v.id_mesa','=','m.id')
        ->select('v.id','v.usuario as vendedor','v.total','v.descuento','c.nombre as nmcliente','m.nombre as NMesa','v.fecha as Fecha','v.anulado as Anulado','v.estado','v.efectivo','v.cambio')
        ->where('v.id','=',$id)
        //->where('v.id_tienda','=',$id_tienda)
        ->get();
        //dd($venta, $id);
        
        // $detalle_venta = DB::table('detalle_venta as dv')
        // ->join('tienda_articulo as t','dv.id_tienda_articulo','=','t.id_articulo')
        // ->join('articulo as p','t.id_articulo','=','p.id')
        // ->select('dv.id_venta','p.nombre as producto','dv.cantidad as cantidad',
        // 'dv.costo_venta as precio','dv.sub_total','t.stock')
        // ->where('dv.id_venta','=',6)
        // ->where('dv.eliminado','=',1)
        // ->orderBy('dv.id','asc')
        // ->get();

        $detalle_venta= DetalleVenta::join('tienda_articulo','detalle_venta.id_tienda_articulo','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('categoria','articulo.id_categoria','=','categoria.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_venta.id_venta','articulo.nombre as producto','detalle_venta.cantidad',
        'detalle_venta.sub_total','tienda_articulo.stock','detalle_venta.costo_venta','detalle_venta.costo_venta as precio')
        ->where('detalle_venta.id_venta','=',$id)
        ->where('detalle_venta.eliminado','=',1)
        ->orderBy('detalle_venta.id','asc')
        ->get();
        //dd($venta);

        // join('tienda_articulo','detalle_venta.id_tienda_articulo','=','tienda_articulo.id')
        // ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        // ->join('categoria','articulo.id_categoria','=','categoria.id')
        // ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        // ->select('detalle_venta.id_venta','detalle_venta.costo_venta','articulo.nombre as articulo','articulo.id_categoria',
        // 'categoria.nombre as categoria','detalle_venta.cantidad','detalle_venta.sub_total','tienda.nombre as tienda','tienda_articulo.stock','tienda.id as id_tienda')
        // ->where('detalle_venta.id_venta','=',$id)
        // ->where('detalle_venta.eliminado','=',1)
        // ->orderBy('detalle_venta.id','asc')
        // ->get();
        //dd($detalle_venta);



        $mi_empresa= MiEmpresa::select('nombre','nit','representante','direccion','telefono'
        ,'localidad')
        ->get();
        // $mi_empresa= Tienda::select('tienda.nombre','tienda.direccion','tienda.telefono'
        // ,'tienda.foto')
        // ->where('id','=',$id_tienda)
        // ->get();




        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;

        $cliente=$venta[0]->nmcliente;
        $mesa=$venta[0]->NMesa;
        $id=$venta[0]->id;
        $efectivo=$venta[0]->efectivo;
        $cambio=$venta[0]->cambio;
        $total=$venta[0]->total;
        $estado=$venta[0]->estado;
        $descuento=$venta[0]->descuento;
        $fecha=$venta[0]->Fecha;
        $vendedor=$venta[0]->vendedor;
        $anulado=$venta[0]->Anulado;
        //$TotalN=$venta[0]->tot;
        $detalles=$detalle_venta;
        //dd($detalles);
        $formatter = new NumeroALetras();
        $total_palabra= $formatter->toInvoice($total, 2, 'bs');


        $fileName = 'ticket_venta.pdf';
        $data = [
            'id' => $id,
            'nombre_empresa' => $nombre_empresa,
            'total' => $total,
            'efectivo' => $efectivo,
            'cambio' => $cambio,
            'estado' => $estado,
            'descuento' => $descuento,
            'total_palabra' => $total_palabra,
            //'codigo' => $codigo,
            'fecha' => $fecha,
            //'nro' => $nro,
            //'descripcion' => $descripcion,
            'anulado' => $anulado,
            //  'TotalN' => $TotalN,
            'direccion_empresa' => $direccion_empresa,
            'telefono_empresa' => $telefono_empresa,
            'cliente' => $cliente,
            'mesa' => $mesa,
            'vendedor' => $vendedor,
            'detalles' => $detalles,
        ];

        $mpdf = new \Mpdf\Mpdf([
            'tempDir'=>storage_path('tempdir'),
            'utf-8', 
            'format' => [70, 150],
            'margin_top' => -1,
            'margin_left' => 2,
            'margin_right' => 4,
            'margin_bottom' => 5,
        ]);
        $html = \View::make('pdf.ticket.ticket_venta',$data);
        $html = $html->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }
    public function pdfPreCuenta(Request $request){

       // dd($id_venta);
       $auxventa = DB::table('venta as v')
            ->join('mesa','v.id_mesa','=','mesa.id')
            ->join('cliente as c','v.id_cliente','=','c.id')
            ->select('v.id', 'v.total')
            ->where('v.id_mesa','=',$request->id_mesa)
            ->orderBy('v.id','desc')
            ->first();
        
        $id= $auxventa->id;

        // FUNCIONES PARA IMPRIMIR 
        $auxventa->imprimir=1;// actualiza campo imprimir
        $nombre_maquina=gethostbyaddr($_SERVER['REMOTE_ADDR']);


        $venta = DB::table('venta as v')
        ->join('cliente as c','v.id_cliente','=','c.id')
        ->join('mesa as m','v.id_mesa','=','m.id')
        ->select('v.id','v.usuario as vendedor','v.total','v.descuento','c.nombre as nmcliente','m.nombre as NMesa',
        'v.fecha as Fecha','v.anulado as Anulado','v.estado','v.efectivo','v.cambio')
        ->where('v.id','=',$id)
        ->get();
        
        $detalle_venta= DetalleVenta::join('tienda_articulo','detalle_venta.id_tienda_articulo','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('categoria','articulo.id_categoria','=','categoria.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_venta.id_venta','articulo.nombre as producto','detalle_venta.cantidad',
        'detalle_venta.sub_total','tienda_articulo.stock','detalle_venta.costo_venta','detalle_venta.costo_venta as precio')
        ->where('detalle_venta.id_venta','=',$id)
        ->where('detalle_venta.eliminado','=',1)
        ->orderBy('detalle_venta.id','asc')
        ->get();
        //dd($detalle_venta);

        $mi_empresa= MiEmpresa::select('nombre','nit','representante','direccion','telefono'
        ,'localidad')
        ->get();


        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;

        $cliente=$venta[0]->nmcliente;
        $mesa=$venta[0]->NMesa;
        //$id=$venta[0]->id;
        $efectivo=$venta[0]->efectivo;
        $cambio=$venta[0]->cambio;
        $total=$venta[0]->total;
        $estado=$venta[0]->estado;
        $descuento=$venta[0]->descuento;
        $fecha=$venta[0]->Fecha;
        $vendedor=$venta[0]->vendedor;
        $anulado=$venta[0]->Anulado;
        //$TotalN=$venta[0]->tot;
        $detalles=$detalle_venta;

        $formatter = new NumeroALetras();
        $total_palabra= $formatter->toInvoice($total, 2, 'bs');


        $fileName = 'ticket_venta.pdf';
        $data = [
            'id' => $id,
            'nombre_empresa' => $nombre_empresa,
            'total' => $total,
            'efectivo' => $efectivo,
            'cambio' => $cambio,
            'estado' => $estado,
            'descuento' => $descuento,
            'total_palabra' => $total_palabra,
            //'codigo' => $codigo,
            'fecha' => $fecha,
            //'nro' => $nro,
            //'descripcion' => $descripcion,
            'anulado' => $anulado,
            //  'TotalN' => $TotalN,
            'direccion_empresa' => $direccion_empresa,
            'telefono_empresa' => $telefono_empresa,
            'cliente' => $cliente,
            'mesa' => $mesa,
            'vendedor' => $vendedor,
            'detalles' => $detalles,
        ];

        $mpdf = new \Mpdf\Mpdf([
            'tempDir'=>storage_path('tempdir'),
            'utf-8', 
            'format' => [70, 150],
            'margin_top' => -1,
            'margin_left' => 2,
            'margin_right' => 4,
            'margin_bottom' => 5,
        ]);
        $html = \View::make('pdf.ticket.ticket_venta',$data);
        $html = $html->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }

    public function pdfPreVenta2(Request $request){

        $var2=DB::select("SELECT  MAX(id) as venta from venta");
        $id=$var2[0]->venta;

       // dd($id_venta);
        $venta = DB::table('venta as v')
        ->join('cliente as c','v.id_cliente','=','c.id')
        ->join('mesa as m','v.id_mesa','=','m.id')
        ->select('v.id','v.usuario as vendedor','v.total','v.descuento','c.nombre as nmcliente','m.nombre as NMesa',
        'v.fecha as Fecha','v.anulado as Anulado','v.estado','v.efectivo','v.cambio')
        ->where('v.id','=',$id)
        ->get();
        
        $detalle_venta= DetalleVenta::join('tienda_articulo','detalle_venta.id_tienda_articulo','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->join('categoria','articulo.id_categoria','=','categoria.id')
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_venta.id_venta','articulo.nombre as producto','detalle_venta.cantidad',
        'detalle_venta.sub_total','tienda_articulo.stock','detalle_venta.costo_venta','detalle_venta.costo_venta as precio')
        ->where('detalle_venta.id_venta','=',$id)
        ->where('detalle_venta.eliminado','=',1)
        ->orderBy('detalle_venta.id','asc')
        ->get();
        //dd($detalle_venta);

        $mi_empresa= MiEmpresa::select('nombre','nit','representante','direccion','telefono'
        ,'localidad')
        ->get();


        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;

        $cliente=$venta[0]->nmcliente;
        $mesa=$venta[0]->NMesa;
        //$id=$venta[0]->id;
        $efectivo=$venta[0]->efectivo;
        $cambio=$venta[0]->cambio;
        $total=$venta[0]->total;
        $estado=$venta[0]->estado;
        $descuento=$venta[0]->descuento;
        $fecha=$venta[0]->Fecha;
        $vendedor=$venta[0]->vendedor;
        $anulado=$venta[0]->Anulado;
        //$TotalN=$venta[0]->tot;
        $detalles=$detalle_venta;

        $formatter = new NumeroALetras();
        $total_palabra= $formatter->toInvoice($total, 2, 'bs');


        $fileName = 'ticket_venta.pdf';
        $data = [
            'id' => $id,
            'nombre_empresa' => $nombre_empresa,
            'total' => $total,
            'efectivo' => $efectivo,
            'cambio' => $cambio,
            'estado' => $estado,
            'descuento' => $descuento,
            'total_palabra' => $total_palabra,
            //'codigo' => $codigo,
            'fecha' => $fecha,
            //'nro' => $nro,
            //'descripcion' => $descripcion,
            'anulado' => $anulado,
            //  'TotalN' => $TotalN,
            'direccion_empresa' => $direccion_empresa,
            'telefono_empresa' => $telefono_empresa,
            'cliente' => $cliente,
            'mesa' => $mesa,
            'vendedor' => $vendedor,
            'detalles' => $detalles,
        ];

        $mpdf = new \Mpdf\Mpdf([
            'tempDir'=>storage_path('tempdir'),
            'utf-8', 
            'format' => [70, 150],
            'margin_top' => -1,
            'margin_left' => 2,
            'margin_right' => 4,
            'margin_bottom' => 5,
        ]);
        $html = \View::make('pdf.ticket.ticket_venta',$data);
        $html = $html->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

    }



















    public function index4(Request $request){
        $obj=DB::select(" SELECT  ifnull(correlativo+1,0) as Correlativo from control_correlativo where estado=0");
        return $obj;     
    }
    public function index6(Request $request){

        $obj=DB::select("SELECT estado,id from control_correlativo ORDER BY id desc LIMIT 1");
        
        return $obj;
    }
    public function preVenta(Request $request){
        $id_usuario = $request->id_usuario;
        //dd($id_usuario);
        $venta = DB::table('venta as v')
        // ->join('detalle_venta as dv','v.id','=','dv.id_venta')
        ->select('v.id','v.correlativo as nro','v.usuario as vendedor','v.eliminado as Eliminado','v.total','v.cliente as nmcliente','v.anulado as Anulado')
        // ->where('v.estado','=',0)
        ->where('v.tipo_venta','Venta Mesero')
        ->where('v.id_usuario','=',$id_usuario)
        ->groupBy('v.id','v.correlativo','v.usuario','v.total','v.cliente','v.anulado','v.eliminado')
        ->orderBy('v.id', 'desc')
        ->get();
        return $venta;
    }
    public function guardarMesero(Request $request){
        try{
                DB::beginTransaction();
                $registro_venta = $request->monto;
                DB::table('control_correlativo')->where('estado','=',0)->increment('correlativo', 1);
                $correlativo = DB::table('control_correlativo as c')->select('c.correlativo as nro')->where('c.estado','=',0)->first();

               // dd($correlativo);
                //dd($registro_venta);
                $id_usuario=\Auth::user()->id;
                //dd($registro_venta, $id_usuario, $request->id_tipo_pago);

                $venta = new Venta();
                $venta->fecha=$request->fecha;
                $venta->sub_total=$request->monto;
                $venta->descuento=0;
                $venta->total=$request->monto;
                $venta->estado=$request->estado;
                $venta->id_tipo_pago=$request->id_tipo_pago;
                $venta->tipo_venta=$request->tipo_venta;
                $venta->cliente = $request->cliente == '' ? 'S/N' : $request->cliente;
                $venta->control=0;
                $venta->usuario=$request->usuario;
                //dd($request->usuario);
                $venta->anulado='';
                $venta->correlativo=$correlativo->nro;
                $venta->imprimir=0;
                $venta->eliminado=0;
                $venta->id_orden_servicio=$request->id_servicio ? $request->id_servicio : null;
                $venta->id_cliente=$request->id_cliente ? $request->id_cliente : null;
                $venta->id_tienda=1;
                if($request->id_tipo_pago == 1) {
                    $venta->id_forma_pago=$request->id_forma_pago;
                }else if ($request->id_tipo_pago == 2) {
                    $venta->id_forma_pago=$request->id_forma_pago;
                } else {
                    //
                }
                //$venta->id_pago=$pago->id;
                $venta->id_usuario=$id_usuario;
                $venta->save();
                //AGREGAR CODIGO DE VENTA
                
                $correlativo = 0;
                $objdate = new DateTime();
                $fechaactual= $objdate->format('Y-m-d');
                $year = $objdate->format('y');
                $correlativo = $this->correlativoControl();
                $control = new control();
                $control->tabla = $request->tabla = "Venta";
                $control->id_tabla = $venta->id;
                $control->codigo = $request->codigo = 'VP-'.strval($correlativo + 1);
                $control->fecha = $fechaactual;
                $control->save();

                
                if($request->id_tipo_pago == 1) {
                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->monto;
                    $pago->saldo = $request->monto;
                    $pago->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    $pago->save();  
                    
                    $this->actualizarCaja($id_usuario,$registro_venta);
                    
            
                } else if($request->id_tipo_pago == 2) {
                    
                    $pago = new Pago();
                    $pago->id = $venta->id;
                    $pago->fecha = $request->fecha;
                    $pago->fecha_final = $request->fecha_final;
                    $pago->monto = $request->monto;
                    $pago->saldo = $request->monto;
                    $pago->descripcion = $request->descripcion = "";
                    $pago->id_tipo_pago = $request->id_tipo_pago;
                    $pago->id_venta = $venta->id;
                    $pago->save(); 
                    
                    $cxcobrar = new CXCobrar();
                    $cxcobrar->fecha = $request->fecha;
                    $cxcobrar->monto_total = $request->monto_total;
                    $cxcobrar->descripcion = $request->descripcion_pago;
                    $cxcobrar->saldo = $request->monto_total;
                    $cxcobrar->id_pago = $venta->id;
                    $cxcobrar->save(); 
                    
                } else {
                    //
                }
                // dd($venta);
                
                $detalles = $request->detalle;
                //dd($detalles);
                $costo_pago = $request->costo_pago;
                
                $stock_producto_paquetes = $request->stock_producto_paquete;
                //dd($request->stock_producto_paquete);
                foreach($stock_producto_paquetes as $ep=>$stock){
                    if($stock['tipo_producto']=='Producto Venta'){
                        $this->actualizarStock($stock['id_articulo'],$stock['cantidad']);
                    }
                }

                foreach($detalles as $ep=>$det){

                    if($det['producto_venta']=='Venta Producto'){
                        $obj = new DetalleVenta();
                        $obj->id_venta= $venta->id;
                        $obj->id_producto= $det['id_tienda_articulo'];
                        $obj->cantidad= $det['cantidad'];

                        $obj->costo_venta= $det['costo_venta'];
                        // if($request->tipo_venta=='Venta Directa') {
                        //     if($request->id_costo_pago == 1) {
                        //         $obj->costo_venta= $det['precio'];
                        //     } else if ($request->id_costo_pago == 2) {
                        //         $obj->costo_venta= $det['costo_mayorista'];
                        //     } else if ($request->id_costo_pago == 3) {
                        //         $obj->costo_venta= $det['costo_preferencial'];
                        //     } else {}
                        // } else {
                        //     $obj->costo_venta= $det['costo_venta'];
                        // }

                        //Ajuste por Venta tienda 1
                        if($request->tipo_venta=='Venta Directa'){
                            $ajuste = new Ajuste();
                            $ajuste->stock=$det['cantidad'];
                            $ajuste->costo_compra=0;
                            $ajuste->costo_unitario=$det['costo_unitario'];
                            $ajuste->costo_mayorista=0;
                            $ajuste->costo_preferencial=0;
                            $ajuste->stock_anterior=$det['stock'];
                            $ajuste->stock_actual=$det['stock']-$det['cantidad'];
                            if($request->tipo_venta=='Venta Directa') {
                                if($request->id_costo_pago == 1) {
                                    $ajuste->costo_venta= $det['costo_unitario'];
                                } else if ($request->id_costo_pago == 2) {
                                    $ajuste->costo_venta= 0;
                                } else if ($request->id_costo_pago == 3) {
                                    $ajuste->costo_venta= 0;
                                } else {}
                            } else {
                                $ajuste->costo_venta= $det['costo_venta'];
                            }
                            $ajuste->observacion=$request->descripcion;
                            $ajuste->id_articulo=$det['id_articulo'];
                            $ajuste->id_motivo_ajuste=7;
                            $ajuste->save();
                        } else {
                            //
                        }
                        $obj->sub_total= $det['cantidad']*$det['precio'];
                        $obj->save();
                        if($request->tipo_venta=='Venta Directa'){
                            $this->actualizarStock($det['id_articulo'],$det['cantidad']);
                        } else {
                            //
                        }

                    }else{
                        //modelo
                        $obj = new DetalleVentaPaquete();
                        $obj->id_venta= $venta->id;
                        $obj->id_paquete= $det['id_paquete'];
                        $obj->cantidad= $det['cantidad'];      
                        $obj->costo_venta= $det['precio'];
                        $obj->sub_total= $det['cantidad']*$det['precio'];
                        $obj->save();
                    }
                }


                if($request->tipo_venta == 'Venta Servicio') {
                    $affected = DB::table('orden_servicio')
                    ->where('id', $request->id_servicio)
                    ->update([
                        'estado' => 'Entregado',
                    ]); 
                }else{
                    //
                }

    
                $datos = [
                    'tabla' => 'venta',
                    'codigo_tabla' => $venta->id,
                    'transaccion' => 'guardar tienda 1',
                ];
                $this->guardarBitacora($datos);   
                
            
            
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function cabeceraVenta(Request $request){
        $id_venta = $request->id_venta;
        //dd($id_venta);
        $venta = DB::table('venta as v')
        ->join('cliente as c','v.id_cliente','=','c.id')
        ->select('c.nombre as cliente','v.total as monto')
        ->where('v.id','=',$id_venta)
        ->first();
        return $venta;
    }
    public function detalleVentaMesero(Request $request){
        $id_venta = $request->id_venta;
        $venta = DB::table('detalle_venta as dv')
        ->join('articulo as p','dv.id_producto','=','p.id')
        ->select('dv.id_producto','p.nombre as producto','dv.cantidad',
        'dv.costo_venta as precio','dv.sub_total as preciov')
        ->where('dv.id_venta','=',$id_venta)
        ->get();
        return $venta;
    }
    public function ActImpresion(Request $request){
        $id = $request->id_venta;   
        $affected = DB::table('venta')
        ->where('id', $id)
        ->update(['imprimir' => 1]);  
    }
    // public function contrasena(Request $request){
       
    //     $objeto=DB::select("SELECT nombre  from contrasena");
    //     $objeto1=(object) $objeto[0];
    //     return $objeto1;

    // }
    public function AnularVenta(Request $request){
        $id = $request->id;
        $affected = DB::table('venta')
        ->where('id', $id)
        ->update(['anulado' => 'Anulado']);
        
        $affected = DB::table('venta')
        ->where('id', $id)
        ->update(['eliminado' => '1']); 

        $detalles = DetalleVenta::select('id_venta','id_producto','cantidad')
        ->where('detalle_venta.id_venta',$request->id)->get();
        foreach($detalles as $ep=>$det){
            DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det->id_producto)
            //->where('combo','=',0)
            ->increment('stock', $det->cantidad);
            //dd($det->id_producto);
        }







        $detalles = DetalleVentaPaquete::join('paquetes','detalle_venta_paquete.id_paquete','=','paquetes.id')
        ->join('detalle_paquete','paquetes.id','=','detalle_paquete.id_paquete')
        ->select('detalle_venta_paquete.id_venta','detalle_paquete.id_producto','detalle_venta_paquete.cantidad','detalle_venta_paquete.id')
        ->where('detalle_venta_paquete.id_venta',$request->id)->get();
        //dd($detalles);
        // foreach($detalles as $ep=>$det2){
        //     DB::table('Producto')->where('Producto.Id_Producto','=',$det->Id_Producto)
        //     ->where('combo','=',1);
            
        //     //->increment('Stock', $det->Cantidad);
        // }º
        foreach($detalles as $ep=>$det2){
            // $detallesCombo = DetalleCombo::select(DB::raw('detalle.Cantidad *'.$det2->Cantidad.'as Cantidad'),'DetalleCombo.Id_Producto')->where('DetalleCombo.Id_Combo','=',$det2->Id_Producto)->where('DetalleCombo.Eliminado','=',0)->get();
            $detallesCombo = DetalleVentaPaquete::join('paquetes','detalle_venta_paquete.id_paquete','=','paquetes.id')
            ->join('detalle_paquete','paquetes.id','=','detalle_paquete.id_paquete')
            ->select(DB::raw('detalle_paquete.cantidad *'.$det2->cantidad.' as Cantidad'),'detalle_paquete.id_producto')
            ->where('detalle_venta_paquete.id','=',$det2->id)
            ->where('detalle_paquete.id_producto','=',$det2->id_producto)
            ->get();
            foreach($detallesCombo as $ep=>$det3){
                DB::table('tienda_articulo')->where('tienda_articulo.id_articulo','=',$det3->id_producto)
                ->increment('stock', $det3->Cantidad);
            }

           //dd($det3->Cantidad);

        }
        //dd($detalles);
    }
    public function ventaId(Request $request){
        $id_usuario = $request->id_usuario;
        //dd($id_usuario);
        $objeto=DB::select("SELECT sum(total) as total from venta where id_usuario = $id_usuario and id_tipo_pago='1'and Estado=0 and Eliminado=0");
        $objeto1=(object) $objeto[0];
        return $objeto1;

    }
    public function ventaIdCredito(Request $request){
        $id_usuario = $request->id_usuario;
        //dd($id_usuario);
        $objeto=DB::select("SELECT SUM(total) total from venta where id_usuario = $id_usuario and id_tipo_pago='2' and Estado=0 and Eliminado=0");
        $objeto1=(object) $objeto[0];
        return $objeto1;

    }

    public function porcentajeGananciaMesero(Request $request){

        $usuario = User::join('personal', 'users.id_personal', '=', 'personal.id')
        ->select('users.id', 'users.name', 'personal.nombre', 'personal.porcentaje')
        ->where('users.id', '=', \Auth::user()->id)->first();
        //dd($usuario);
        $id_usuario=\Auth::user()->id;
        $porcentaje=$usuario->porcentaje;
        
        
        //$fechaActual = DB::select('SELECT now() as fecha_actual')[0]->fecha_actual;
        //dd($fechaActual);

        $a=DB::select("SELECT Sum(venta.total) as total_monto_venta
        FROM  venta INNER JOIN users
        on venta.id_usuario=users.id 
        WHERE venta.id_usuario='$id_usuario' and venta.control=0 and venta.control_mesero=0 and venta.estado='Cobrado'
        GROUP BY venta.total, venta.id");

        $a_efectivo=DB::select("SELECT Sum(venta.total_efectivo) as total_monto_venta_efectivo
        FROM  venta INNER JOIN users
        on venta.id_usuario=users.id 
        WHERE venta.id_usuario='$id_usuario' and venta.control=0 and venta.control_mesero=0 and venta.estado='Cobrado'
        GROUP BY venta.total, venta.id");
        
        $a_deposito=DB::select("SELECT Sum(venta.total_deposito) as total_monto_venta_deposito
        FROM  venta INNER JOIN users
        on venta.id_usuario=users.id 
        WHERE venta.id_usuario='$id_usuario' and venta.control=0 and venta.control_mesero=0 and venta.estado='Cobrado'
        GROUP BY venta.total, venta.id");
        
        $a_eliminado=DB::select("SELECT Sum(venta.total) as total_monto_venta_eliminado
        FROM  venta INNER JOIN users
        on venta.id_usuario=users.id 
        WHERE venta.id_usuario='$id_usuario' and venta.control=0 and venta.control_mesero=0 and venta.estado='Anulado'
        GROUP BY venta.total, venta.id");

        $a_registrado=DB::select("SELECT Sum(venta.total) as total_monto_venta_registrado
        FROM  venta INNER JOIN users
        on venta.id_usuario=users.id 
        WHERE venta.id_usuario='$id_usuario' and venta.control=0 and venta.control_mesero=0 and venta.estado='Registrado'
        GROUP BY venta.total, venta.id");

        $monto_total = 0;
        $monto_total_efectivo = 0;
        $monto_total_deposito = 0;
        $monto_total_anulado = 0;
        $monto_total_registrado = 0;
      
        foreach($a as $registro){
            $monto_total=$monto_total+$registro->total_monto_venta;
        }

        foreach($a_efectivo as $registro){
            $monto_total_efectivo=$monto_total_efectivo+$registro->total_monto_venta_efectivo;
        }

        foreach($a_deposito as $registro){
            $monto_total_deposito=$monto_total_deposito+$registro->total_monto_venta_deposito;
        }

        foreach($a_eliminado as $registro){
            $monto_total_anulado=$monto_total_anulado+$registro->total_monto_venta_eliminado;
        }

        foreach($a_registrado as $registro){
            $monto_total_registrado=$monto_total_registrado+$registro->total_monto_venta_registrado;
        }

        if($porcentaje==0){
            $monto_porcentaje=0;
        }else{
            $monto_porcentaje = $monto_total*($porcentaje/100);
        }
        return [
            'monto_porcentaje'=>$monto_porcentaje, 
            'monto_total_ventas'=>$monto_total, 
            'monto_total_efectivo'=>$monto_total_efectivo,
            'monto_total_deposito'=>$monto_total_deposito,
            'monto_total_anulado'=>$monto_total_anulado,
            'monto_total_registrado'=>$monto_total_registrado

        ];

    }

    public function ticket($request)
    {
        $nombreImpresora = "TM-U220";

        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);

        $impresora->setTextSize(2, 2);
        $impresora->text("Imprimiendo\n");
        $impresora->text("ticket\n");
        $impresora->text("desde\n");
        $impresora->text("Laravel\n");
        $impresora->setTextSize(1, 1);
        $impresora->text("hola");
        $impresora->feed(5);
        $impresora->close();
    }

    public function ventaTicket($request)
    {
        //dd($request);
        $var2=DB::select("SELECT  MAX(id) as venta from venta");
        $id=$var2[0]->venta;

        $nombreImpresora = "TM-U220";

        $year = Carbon::now()->format('Y');
        $connector = new WindowsPrintConnector($nombreImpresora);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_A);
        $printer->setDoubleStrike(true);
        $printer->text("{$request->cliente} \n");
        $printer->setDoubleStrike(false);
        $printer->setFont(Printer::FONT_C);
        // $printer->text("{$request->documento} \n");
        // $printer->text("{$request->usuario} \n");
        // $printer->text("{$request->telefono} \n");
        $printer->feed(1);
        $printer->setDoubleStrike(true);
        $printer->text("TICKET DE VENTA\n");
        $printer->text("{$id} \n");
        $printer->setDoubleStrike(false);
        $printer->feed(1);
        $printer->setEmphasis(true);
        $printer->text($this->lines(47));
        $printer->setEmphasis(false);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setDoubleStrike(true);

        $printer->text("Cliente: ");
        $printer->setDoubleStrike(false);
        $printer->text("{$request->cliente} \n");
        //dd($request->cliente);
        $printer->text($this->lines(47));
        $printer->setEmphasis(false);
        $printer->setDoubleStrike(true);
        $printer->text("Fecha: ");
        $printer->setDoubleStrike(false);
        $printer->text("{$request->fecha} \n");

        $printer->feed(1);
        $printer->setEmphasis(true);
        $printer->text($this->addSpaces('Cant.', 8) . $this->addSpaces('Descripcion', 18) . $this->addSpaces('P.Unit', 10) . $this->addSpaces('Sub Total', 10) . "\n");
        $printer->text($this->lines(47));
        $printer->setEmphasis(false);
        foreach ($request->detalle as $item) {

            $cant = number_format(floatval($item['cantidad']));
            $cant = str_split($cant, 8);
            foreach ($cant as $k => $l) {
                $l = trim($l);
                $cant[$k] = $this->addSpaces($l, 8);
            }

            $descripcion = str_split($item['articulo'], 18);
            foreach ($descripcion as $k => $l) {
                $l = trim($l);
                $descripcion[$k] = $this->addSpaces($l, 18);
            }

            $price = number_format(floatval($item['costo_unitario']), 2);
            $price = str_split($price, 10);
            foreach ($price as $k => $l) {
                $l = trim($l);
                $price[$k] = $this->addSpaces($l, 10);
            }
            $total = str_split(number_format(floatval($item['sub_total']), 2), 10);
            foreach ($total as $k => $l) {
                $l = trim($l);
                $total[$k] = $this->addSpaces($l, 10);
            }
            $counter = 0;
            $temp = [];
            $temp[] = count($cant);
            $temp[] = count($descripcion);
            $temp[] = count($price);
            $temp[] = count($total);
            $counter = max($temp);
            for ($i = 0; $i < $counter; $i++) {
                $line = '';
                if (isset($cant[$i])) {
                    $line .= (" " . $cant[$i]);
                }
                if (isset($descripcion[$i])) {
                    $line .= ($descripcion[$i]);
                }
                if (isset($price[$i])) {
                    $line .= ($price[$i]);
                }
                if (isset($total[$i])) {
                    $line .= ($total[$i]);
                }
                $printer->text($line . "\n");

            }
        }

        $printer->text($this->lines(47));
        $printer->feed(1);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_A);
        $printer->setDoubleStrike(true);
        $total = number_format(floatval($request->total), 2);
        $printer->text("Total:  {$request->total}\n");
        $printer->feed(1);
        $efectivo = number_format(floatval($request->efectivo), 2);
        $printer->text("Efectivo:  {$request->efectivo}\n");
        $cambio = number_format(floatval($request->cambio), 2);
        $printer->text("Cambio:  {$request->cambio}\n");
        $printer->feed(1);
        $printer->setDoubleStrike(false);
        $printer->feed(1);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_C);
        $printer->text("Gracias por su preferencia \n");
        $printer->feed(1);

        $printer->pulse();
        $printer->cut();
        $printer->close();
        return $request->name;
    }
    public function lines(int $lgn)
    {
        $asteriscos = Str::padRight("-", $lgn, " -");
        return "{$asteriscos}\n";
    }
    function addSpaces($string = '', $valid_string_length = 0)
    {
        if (strlen($string) < $valid_string_length) {
            $spaces = $valid_string_length - strlen($string);
            for ($index1 = 1; $index1 <= $spaces; $index1++) {
                $string = $string . ' ';
            }
        }

        return $string;
    }
}

