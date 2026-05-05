<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Personal;
use App\Models\User;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Articulo;
use App\Models\Ajuste;
use App\Models\MiEmpresa;
use App\Models\Browser;
use DB;
use App\Models\Orden;
use App\Models\DetalleOrden;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Proforma;
use App\Models\DetalleProforma;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\ArqueoCaja;
use App\Models\Gasto;
use App\Models\Pago;
use App\Models\PagoCompra;
use App\Models\traspaso;
use App\Models\DetalleTraspaso;

use App\Models\Tienda;

class ReporteController extends BitacoraController
{

    public function pdfPersonal(Request $request){

        $obj= Personal::select('personal.nombre','personal.direccion','personal.telefono')
        ->where('personal.estado','!=','0')
        ->where('personal.id','!=','1')
        ->get();

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE PERSONAL';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;
        $detalles=$obj;
        
        $cont=Personal::count();
        $pdf = \PDF::loadView('pdf.reportes.personal.personal', [
            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Personal.pdf');
    }

    public function pdfUsuario(Request $request){

        $title='LISTA DE USUARIOS';
        $obj= User::join('grupo','users.id_grupo','=','grupo.id')
        ->join('personal','users.id_personal','=','personal.id')
        ->select('users.name as nombre','users.matricula','users.email'
        ,'grupo.nombre as grupo','personal.nombre as personal')
        ->where('users.estado','!=','0')
        ->where('users.id','!=','1')
        ->get();

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE PERSONAL';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;
        $detalles=$obj;

        $detalles=$obj;
        
        $cont=User::count();
        $pdf = \PDF::loadView('pdf.reportes.usuario.usuario', [
            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Usuarios.pdf');
    }

    public function pdfCaja(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        
        $x = DB::table('arqueo_caja as a')
        ->join('users as u', 'a.id_usuario', '=', 'u.id')
        ->select('a.id','a.fecha_apertura','a.fecha_cierre','a.apertura','a.registro_venta as ingreso','a.estado','a.gastos','a.total',
        'a.registro_compra','a.saldo_sistema','a.saldo_efectivo','a.diferencia','a.id_usuario',DB::raw('a.registro_compra + a.gastos as egreso'),
        DB::raw('a.apertura + a.registro_venta - a.registro_compra - a.gastos as total_efectivo'),'a.doscientos','a.cien','a.cincuenta','a.veinte',
        'a.diez','a.cinco','a.dos','a.uno','a.cerocinco','a.ceroveinte','a.ceroveinte','a.cien_dolar','u.name')
        ->whereDate('a.fecha_apertura', ">=", $fecha_inicio)
        ->whereDate('a.fecha_apertura', "<=", $fecha_fin)
        ->orderBy('a.id', 'asc')->get();

        $obj = json_decode(json_encode($x), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE PERSONAL';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;
        $detalles=$obj;
        
        $cont=ArqueoCaja::count();
        $pdf = \PDF::loadView('pdf.reportes.arqueo.arqueo', [
            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Arqueo.pdf');
    }

    public function pdfProducto(Request $request){

        $x=DB::select("SELECT p.nombre, c.nombre as categoria, p.costo_compra, p.costo_venta, p.stock_minimo,ta.stock, ta.id_tienda, ta.id_articulo, t.nombre as tienda
        FROM tienda_articulo ta, articulo p, categoria c, tienda t
        WHERE p.estado!=0 and ta.id_tienda=t.id and ta.id_articulo=p.id and c.id=p.id_categoria AND p.id_tipo_producto != 5 ORDER BY p.nombre");

        $obj = json_decode(json_encode($x), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();


        $title='LISTA DE PRODUCTOS';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;
        

        $detalles=$obj;
        
        $cont=Articulo::count();
        $pdf = \PDF::loadView('pdf.reportes.producto.producto', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,
          
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Producto.pdf');
    }
    public function pdfProductoStock(Request $request){


        $x=DB::select("SELECT articulo.nombre as producto ,SUM(tienda_articulo.stock) as stock , articulo.costo_compra as compra , articulo.costo_venta as venta 
        FROM tienda_articulo,articulo,tienda
        WHERE tienda_articulo.id_articulo=articulo.id and tienda_articulo.id_tienda=tienda.id and articulo.estado!=0 AND articulo.id_tipo_producto != 5
        GROUP by articulo.nombre,articulo.costo_compra,articulo.costo_venta");
        $obj = json_decode(json_encode($x), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE PRODUCTOS';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;

        $detalles=$obj;
        $total = 0;
        $desc = 0;
        $total1 = 0;
        $desc2 = 0;
        $total1 = 0;
        foreach($detalles as $det)
        {
            $desc=$det['stock']*$det['compra'];
            $total=$total+$desc;

            $desc2= ($det['stock']*$det['venta']);
            $total1 = $total1+$desc2;

            $totalResultado = $total1 - $total;

        }
        $cont=Articulo::count();
        $pdf = \PDF::loadView('pdf.reportes.producto.producto_stock', [

            'title'=>$title,
            'foto_empresa'=>$foto_empresa,
            'detalles'=>$detalles,
            'total'=>$total,
            'total1'=>$total1,
            'totalResultado'=>$totalResultado,
            
        ]);
        //return $pdf->stream('Producto.pdf');
        return $pdf->setPaper('letter', 'portrait')->stream('Producto.pdf');

        
    }
    public function pdfProductoMinimo(Request $request){

        $x=DB::select("SELECT p.nombre,c.nombre as categoria, p.costo_compra,
        p.costo_venta,p.stock_minimo, ta.stock,ta.id_tienda, ta.id_articulo, t.nombre as tienda
        FROM tienda_articulo ta, articulo p, categoria c, tienda t
        WHERE p.estado!=0 AND p.id_tipo_producto != 5 and ta.id_tienda=t.id and ta.id_articulo=p.id and c.id=p.id_categoria and ta.stock<=p.stock_minimo");
        
        $obj = json_decode(json_encode($x), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE PRODUCTOS STOCK MINIMO';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;

        $detalles=$obj;
        // $total = 0;
        // $desc = 0;
        // $total1 = 0;
        // $desc2 = 0;
        // $total1 = 0;
        // foreach($detalles as $det)
        // {
        //     $desc=$det['stock_minimo']>=$det['stock'];
        //     $total=$desc;

        //     $desc2= ($det['stock']*$det['venta']);
        //     $total1 = $total1+$desc2;

        //     $totalResultado = $total1 - $total;

        // }
        
        $cont=Articulo::count();
        $pdf = \PDF::loadView('pdf.reportes.producto.producto_stock_minimo', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,

            'detalles'=>$detalles,
            
        ]);
        //return $pdf->stream('Producto.pdf');
        return $pdf->setPaper('letter', 'portrait')->stream('Producto.pdf');
    }
    public function pdfProductoGeneral(Request $request){

        $x=DB::select("SELECT p.nombre,p.cod_producto, p.cod_proveedor, c.nombre as categoria, p.tipo_producto, p.costo_unitario, p.costo_mayorista, p.costo_preferencial, p.stock_minimo, p.costo_compra, p.marca
        FROM articulo p, categoria c
        WHERE p.estado!=0 and c.id=p.id_categoria and tipo_producto='Producto Venta'");

        $obj = json_decode(json_encode($x), true);

        /* $obj2= producto::join('medida','producto.id_medida','=','medida.id')
        ->join('categoria','producto.id_categoria','=','categoria.id')
        ->join('proveedor','producto.id_proveedor','=','proveedor.id')
        ->join('presentacion','producto.id_presentacion','=','presentacion.id')
        ->join('tipo_producto','producto.id_tipo_producto','=','tipo_producto.id')
        ->join('lote','producto.id','=','lote.id_producto')
        ->select('producto.id','producto.nombre','producto.modelo','producto.stock','producto.stock_minimo','producto.pu','producto.marca',
        'producto.cod_ean','producto.cod_producto','producto.observacion','producto.foto','producto.estado','producto.id_medida','medida.nombre as medida',
        'producto.id_categoria','categoria.nombre as categoria','producto.id_proveedor','proveedor.nombre as proveedor',
        'producto.id_presentacion','presentacion.nombre as presentacion','producto.id_tipo_producto','tipo_producto.nombre as tipo_producto'
        ,'lote.id as id_lote','lote.costo_cif as costo_cif','lote.costo_fob as costo_fob','lote.tipo_cambio as tipo_cambio','lote.cantidad as cantidad')
        ->orderBy('producto.id','desc')->get(); */

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')
        ->get();

        $title='LISTA DE PRODUCTOS';
        $nombre_empresa=$mi_empresa[1]->nombre;
        $cod_empresa=$mi_empresa[1]->cod_tienda;
        $direccion_empresa=$mi_empresa[1]->direccion;
        $telefono_empresa=$mi_empresa[1]->telefono;
        $cod_almacen=$mi_empresa[1]->cod_almacen;
        $foto_empresa=$mi_empresa[1]->foto;

        $detalles=$obj;
        
        $cont=Articulo::count();
        $pdf = \PDF::loadView('pdf.reportes.producto.producto', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Producto.pdf');
    }

    public function pdfAlmacen(Request $request){

        $x=DB::select("SELECT p.nombre,p.cod_producto, p.cod_proveedor, c.nombre as categoria, p.tipo_producto, p.costo_unitario, p.costo_mayorista, p.costo_preferencial, p.stock_minimo, p.costo_compra, p.marca, SUM(ta.stock) as total_stock, ta.stock, ta.id_tienda, ta.id_articulo, t.nombre as tienda
        FROM tienda_articulo ta, articulo p, categoria c, tienda t
        WHERE p.estado!=0 and ta.id_tienda=t.id and ta.id_articulo=p.id and c.id=p.id_categoria and tipo_producto='Producto Venta' GROUP BY ta.id_articulo ORDER BY t.nombre");

        $obj = json_decode(json_encode($x), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')
        ->get();

        $title='LISTA DE PRODUCTOS GENERAL';
        $nombre_empresa=$mi_empresa[1]->nombre;
        $cod_empresa=$mi_empresa[1]->cod_tienda;
        $direccion_empresa=$mi_empresa[1]->direccion;
        $telefono_empresa=$mi_empresa[1]->telefono;
        $cod_almacen=$mi_empresa[1]->cod_almacen;
        $foto_empresa=$mi_empresa[1]->foto;

        $detalles=$obj;
        
        $cont=Articulo::count();
        $pdf = \PDF::loadView('pdf.reportes.almacen.almacen', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Producto.pdf');
    }


    public function pdfAjuste(Request $request){

        $obj= Ajuste::join('motivo_ajuste','ajuste.id_motivo_ajuste','=','motivo_ajuste.id')
        ->join('articulo','ajuste.id_articulo','=','articulo.id')
        ->leftjoin('categoria', function($join){
            $join->orOn('articulo.id_categoria','=','categoria.id');
        })
        ->select('ajuste.stock','ajuste.observacion','motivo_ajuste.nombre as motivo_ajuste','articulo.nombre as producto','articulo.marca','ajuste.stock','ajuste.stock_anterior',
        'articulo.costo_compra','ajuste.stock_actual','ajuste.costo_unitario','ajuste.costo_mayorista','ajuste.costo_preferencial','categoria.nombre as categoria')
        ->get();

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')
        ->get();

        $title='LISTA DE AJUSTES';
        $nombre_empresa=$mi_empresa[1]->nombre;
        $cod_empresa=$mi_empresa[1]->cod_tienda;
        $direccion_empresa=$mi_empresa[1]->direccion;
        $telefono_empresa=$mi_empresa[1]->telefono;
        $cod_almacen=$mi_empresa[1]->cod_almacen;
        $foto_empresa=$mi_empresa[1]->foto;


        $detalles=$obj;
        //dd($detalles);
        
        $cont=Ajuste::count();
        $pdf = \PDF::loadView('pdf.reportes.ajuste.ajuste', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Ajuste.pdf');
    }

    public function pdfGasto(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;

        $x=DB::select("SELECT g.fecha,g.monto,g.descripcion,m.nombre motivo_gasto ,g.id_forma_pago,g.efectivo,g.deposito,u.name as usuario,f.nombre as forma
        FROM gasto g, motivo_gasto m,forma_pago f,users u
        WHERE g.id_motivo_gasto=m.id  and g.id_forma_pago=f.id and g.id_usuario=u.id 
        AND g.fecha>='$fecha_inicio' AND g.fecha<='$fecha_fin'");
        $obj = json_decode(json_encode($x), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE GASTOS';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;
        // $id_forma_pago=$x[0]->id_forma_pago;
        $detalles=$obj;
        $total_general = 0;
        $total_deposito = 0;
        $total = 0;
        foreach($detalles as $det)
        {
            $total_general=$total_general+$det['efectivo'];
            $total_deposito=$total_deposito+$det['deposito'];
            $total=$total_deposito+$total_general;
            //$resul = $resul+$total_general;
        

        }
        //$title='LISTA DE ';
        $detalles=$obj;
        //dd($detalles);
        
        $cont=Gasto::count();
        $pdf = \PDF::loadView('pdf.reportes.gasto.gasto', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,
            //'empresa' =>$empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,
            'total_general'=>$total_general,
            'total_deposito'=>$total_deposito,
            'total'=>$total,
            
        ]);
        return $pdf->stream('Gasto.pdf');
    }

    public function pdfProveedor(Request $request){

        $obj= Proveedor::select('proveedor.id','proveedor.nombre','proveedor.nit','proveedor.contacto','proveedor.direccion','proveedor.telefono')
        ->where('proveedor.estado','!=','0')
        ->get();

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE PROVEEDORES';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;

        $detalles=$obj;
        //dd($detalles);
        
        $cont=Proveedor::count();
        $pdf = \PDF::loadView('pdf.reportes.proveedor.proveedor', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,

            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Proveedor.pdf');
    }

    public function pdfCompraGeneral(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 

        $x=DB::select("SELECT c.fecha,p.nombre proveedor,u.name usuario,c.sub_total,c.descuento,c.total, t.nombre as tipo,f.nombre as forma,c.total_efectivo,c.total_deposito
        FROM compra c, proveedor p, users u,tipo_pago t,forma_pago f
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id AND c.id_tipo_pago=t.id AND c.id_forma_pago=f.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj = json_decode(json_encode($x), true);

        $a=DB::select("SELECT SUM(c.total) as totalC
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj2 = json_decode(json_encode($a), true);

        //dd($obj);

        $b=DB::select("SELECT SUM(c.total) as totalCo
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin' AND c.id_tipo_pago=1");
        $obj3 = json_decode(json_encode($b), true);

        $c=DB::select("SELECT SUM(c.total) as totalCr
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin' AND c.id_tipo_pago=2");
        $obj4 = json_decode(json_encode($c), true);

        $d=DB::select("SELECT SUM(c.total_efectivo) as totalEf
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj5 = json_decode(json_encode($d), true);

        $e=DB::select("SELECT SUM(c.total_deposito) as totalDep
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj6 = json_decode(json_encode($e), true);


        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE COMPRAS';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;

        $detalles=$obj;
        $detalles2=$obj2;
        //dd($detalles2);
        $detalles3=$obj3;
        $detalles4=$obj4;
        $detalles5=$obj5;
        $detalles6=$obj6;
        
        //dd($detalles2,$detalles3,$detalles4,$detalles5,$detalles6);
        
        $cont=Compra::count();
        $pdf = \PDF::loadView('pdf.reportes.compra.compra_general', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
            'detalles3'=>$detalles3,
            'detalles4'=>$detalles4,
            'detalles5'=>$detalles5,
            'detalles6'=>$detalles6,

            
        ]);
        //return $pdf->stream('Compra.pdf');
        return $pdf->setPaper('letter', 'portrait')->stream('Compra.pdf');
    }

    public function pdfCompraDetallada(Request $request){

        
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 

        $x=DB::select("SELECT c.id,c.fecha,p.nombre proveedor,u.name usuario,c.sub_total,c.descuento,c.total,t.nombre as tipo,f.nombre as forma,c.total_efectivo,c.total_deposito
        FROM compra c, proveedor p, users u,tipo_pago t,forma_pago f
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id AND c.id_tipo_pago=t.id AND c.id_forma_pago=f.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj = json_decode(json_encode($x), true);
        $y= detalleCompra::join('tienda_articulo','detalle_compra.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->leftjoin('categoria', function($join){
            $join->orOn('articulo.id_categoria','=','categoria.id');
        })
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_compra.id_compra','detalle_compra.costo_compra as pu','detalle_compra.id_compra','detalle_compra.cantidad',
        'detalle_compra.sub_total','articulo.nombre as producto','tienda.nombre as tienda','categoria.nombre as categoria')
        ->get();
        $obj2 = json_decode(json_encode($y), true);

        $a=DB::select("SELECT SUM(c.total) as totalC
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin' ");
        $obj3 = json_decode(json_encode($a), true);

        $b=DB::select("SELECT SUM(c.total) as totalCo
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin' AND c.id_tipo_pago=1");
        $obj4 = json_decode(json_encode($b), true);

        $c=DB::select("SELECT SUM(c.total) as totalCr
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin' AND c.id_tipo_pago=2");
        $obj5 = json_decode(json_encode($c), true);

        $d=DB::select("SELECT SUM(c.total_efectivo) as totalEf
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj6 = json_decode(json_encode($d), true);

        $e=DB::select("SELECT SUM(c.total_deposito) as totalDep
        FROM compra c, proveedor p, users u
        WHERE c.estado!='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj7 = json_decode(json_encode($e), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE COMPRAS DETALLADA';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;


        $compra=$obj;
        $detalles=$obj2;

        $detalles2=$obj3;
        $detalles3=$obj4;
        $detalles4=$obj5;
        $detalles5=$obj6;
        $detalles6=$obj7;
        
        //dd($compra,$detalles);
        
        $cont=Compra::count();
        $pdf = \PDF::loadView('pdf.reportes.compra.compra_detallada', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'compra'=>$compra,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
            'detalles3'=>$detalles3,
            'detalles4'=>$detalles4,
            'detalles5'=>$detalles5,
            'detalles6'=>$detalles6,


            
        ]);
        //return $pdf->stream('Compra.pdf');
        return $pdf->setPaper('letter', 'portrait')->stream('Compra.pdf');
    }
    public function pdfCompraDetalladaAnuladas(Request $request){
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 

        $x=DB::select("SELECT c.id,c.fecha,p.nombre proveedor,u.name usuario,c.sub_total,c.descuento,c.total,t.nombre as tipo,f.nombre as forma,c.total_efectivo,c.total_deposito
        FROM compra c, proveedor p, users u,tipo_pago t,forma_pago f
        WHERE c.estado='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id AND c.id_tipo_pago=t.id AND c.id_forma_pago=f.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj = json_decode(json_encode($x), true);
        $y= detalleCompra::join('tienda_articulo','detalle_compra.id_producto','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->leftjoin('categoria', function($join){
            $join->orOn('articulo.id_categoria','=','categoria.id');
        })
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_compra.id_compra','detalle_compra.costo_compra as pu','detalle_compra.id_compra','detalle_compra.cantidad',
        'detalle_compra.sub_total','articulo.nombre as producto','tienda.nombre as tienda','categoria.nombre as categoria')
        ->get();
        $obj2 = json_decode(json_encode($y), true);

        $a=DB::select("SELECT SUM(c.total) as totalC
        FROM compra c, proveedor p, users u
        WHERE c.estado='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin' ");
        $obj3 = json_decode(json_encode($a), true);

        $d=DB::select("SELECT SUM(c.total_efectivo) as totalEf
        FROM compra c, proveedor p, users u
        WHERE c.estado='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj6 = json_decode(json_encode($d), true);

        $e=DB::select("SELECT SUM(c.total_deposito) as totalDep
        FROM compra c, proveedor p, users u
        WHERE c.estado='Anulado' AND c.id_proveedor=p.id AND c.id_usuario=u.id
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj7 = json_decode(json_encode($e), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE COMPRAS DETALLADA ANULADAS';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;


        $compra=$obj;
        $detalles=$obj2;

        $detalles2=$obj3;
        $detalles5=$obj6;
        $detalles6=$obj7;
        
        //dd($compra,$detalles);
        
        $cont=Compra::count();
        $pdf = \PDF::loadView('pdf.reportes.compra.compra_detallada_anuladas', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'compra'=>$compra,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
            'detalles5'=>$detalles5,
            'detalles6'=>$detalles6,


            
        ]);
        //return $pdf->stream('Compra.pdf');
        return $pdf->setPaper('letter', 'portrait')->stream('Compra.pdf');
    }

    public function pdfVentaGeneral(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;

        $x=DB::select("SELECT v.sub_total,v.descuento,v.total,c.nombre as cliente,t.nombre as tipo_pago,f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,v.total_efectivo,v.total_deposito,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj = json_decode(json_encode($x), true);

        $y=DB::select("SELECT SUM(v.total) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj1 = json_decode(json_encode($y), true);

        $a=DB::select("SELECT SUM(v.total) as totalC
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Cobrado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id 
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=1");
        $obj5 = json_decode(json_encode($a), true);

        $b=DB::select("SELECT SUM(v.total) as totalCr
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Cobrado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id 
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=2");
        $obj6 = json_decode(json_encode($b), true);

        $c=DB::select("SELECT SUM(v.total_efectivo) as totalEf
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj7 = json_decode(json_encode($c), true);

        $d=DB::select("SELECT SUM(v.total_deposito) as totalDep
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj8 = json_decode(json_encode($d), true);
        //dd($obj);



        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;
        // $tienda=$mi_empresa[0]->tienda;

        $detalles=$obj;
        $detalles2=$obj1;
        //dd($detalles);
        $detalles5=$obj5;
        //dd($detalles5);
        $detalles6=$obj6;
        $detalles7=$obj7;
        $detalles8=$obj8;

        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_general', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,
            'detalles2'=>$detalles2,

            'detalles5'=>$detalles5,
            'detalles6'=>$detalles6,
            'detalles7'=>$detalles7,
            'detalles8'=>$detalles8,
            
        ]);
        return $pdf->stream('Venta.pdf');
    }
    public function pdfVentaDetallada(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa,v.usuario
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj3 = json_decode(json_encode($z), true);

        $a=DB::select("SELECT SUM(v.total) as totalC
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Cobrado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id AND v.tipo_venta='$tipo_venta'
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=1");
        $obj5 = json_decode(json_encode($a), true);

        $b=DB::select("SELECT SUM(v.total) as totalCr
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Cobrado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id AND v.tipo_venta='$tipo_venta'
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=2");
        $obj6 = json_decode(json_encode($b), true);

        $c=DB::select("SELECT SUM(v.total_efectivo) as totalEf
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj7 = json_decode(json_encode($c), true);

        $d=DB::select("SELECT SUM(v.total_deposito) as totalDep
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj8 = json_decode(json_encode($d), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;
        $detalles5=$obj5;
        //dd($detalles5);
        $detalles6=$obj6;
        $detalles7=$obj7;
        $detalles8=$obj8;
        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
            'detalles5'=>$detalles5,
            'detalles6'=>$detalles6,
            'detalles7'=>$detalles7,
            'detalles8'=>$detalles8,
            
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaAnuladas(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Anulado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Anulado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj3 = json_decode(json_encode($z), true);

        $a=DB::select("SELECT SUM(v.total) as totalC
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Anulado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id AND v.tipo_venta='$tipo_venta'
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=1");
        $obj5 = json_decode(json_encode($a), true);

        $b=DB::select("SELECT SUM(v.total) as totalCr
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Anulado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id AND v.tipo_venta='$tipo_venta'
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=2");
        $obj6 = json_decode(json_encode($b), true);

        $c=DB::select("SELECT SUM(v.total_efectivo) as totalEf
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Anulado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj7 = json_decode(json_encode($c), true);

        $d=DB::select("SELECT SUM(v.total_deposito) as totalDep
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Anulado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'");
        $obj8 = json_decode(json_encode($d), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADA ANULADAS';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;
        $detalles5=$obj5;
        //dd($detalles5);
        $detalles6=$obj6;
        $detalles7=$obj7;
        $detalles8=$obj8;
        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
            'detalles5'=>$detalles5,
            'detalles6'=>$detalles6,
            'detalles7'=>$detalles7,
            'detalles8'=>$detalles8,
            
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaEfectivo(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=2");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total_efectivo) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=2");
        $obj3 = json_decode(json_encode($z), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO EFECTIVO';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;

        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_forma', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
 
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaTransferencia(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=3");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total_deposito) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=3");
        $obj3 = json_decode(json_encode($z), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO TRANSFERENCIA';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;

        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_forma', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
 
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaQr(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=4");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total_deposito) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=4");
        $obj3 = json_decode(json_encode($z), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO QR';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;

        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_forma', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
 
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaDeposito(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=5");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total_deposito) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=5");
        $obj3 = json_decode(json_encode($z), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO DEPOSITO';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;

        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_forma', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
 
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaMixta(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=6");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=6");
        $obj3 = json_decode(json_encode($z), true);


        $c=DB::select("SELECT SUM(v.total_efectivo) as totalEf
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'  AND v.id_forma_pago=6");
        $obj7 = json_decode(json_encode($c), true);

        $d=DB::select("SELECT SUM(v.total_deposito) as totalDep
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'  AND v.id_forma_pago=6");
        $obj8 = json_decode(json_encode($d), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO MIXTA';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;
        $detalles7=$obj7;
        $detalles8=$obj8;
        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_mixta', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
            'detalles7'=>$detalles7,
            'detalles8'=>$detalles8,
            
        ]);
        return $pdf->stream('Ventas.pdf');
    }

    //Usuario
    public function pdfVentaDetalladaUsuario(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;
        $id_usuario = $request->id_usuario;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa,v.usuario
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_usuario='$id_usuario'");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_usuario='$id_usuario'");
        $obj3 = json_decode(json_encode($z), true);

        $a=DB::select("SELECT SUM(v.total) as totalC
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Cobrado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id AND v.tipo_venta='$tipo_venta'
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=1");
        $obj5 = json_decode(json_encode($a), true);

        $b=DB::select("SELECT SUM(v.total) as totalCr
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Cobrado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id AND v.tipo_venta='$tipo_venta'
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=2");
        $obj6 = json_decode(json_encode($b), true);

        $c=DB::select("SELECT SUM(v.total_efectivo) as totalEf
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_usuario='$id_usuario'");
        $obj7 = json_decode(json_encode($c), true);

        $d=DB::select("SELECT SUM(v.total_deposito) as totalDep
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_usuario='$id_usuario'");
        $obj8 = json_decode(json_encode($d), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;
        $detalles5=$obj5;
        //dd($detalles5);
        $detalles6=$obj6;
        $detalles7=$obj7;
        $detalles8=$obj8;
        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
            'detalles5'=>$detalles5,
            'detalles6'=>$detalles6,
            'detalles7'=>$detalles7,
            'detalles8'=>$detalles8,
            
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaEfectivoUsuario(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;
        $id_usuario = $request->id_usuario;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=2 AND v.id_usuario='$id_usuario'");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total_efectivo) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=2 AND v.id_usuario='$id_usuario'");
        $obj3 = json_decode(json_encode($z), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO EFECTIVO';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;

        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_forma', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
 
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaTransferenciaUsuario(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;
        $id_usuario = $request->id_usuario;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=3 AND v.id_usuario='$id_usuario'");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total_efectivo) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=3 AND v.id_usuario='$id_usuario'");
        $obj3 = json_decode(json_encode($z), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO TRANSFERENCIA';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;

        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_forma', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
 
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaQrUsuario(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;
        $id_usuario = $request->id_usuario;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=4   AND v.id_usuario='$id_usuario'");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total_deposito) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=4   AND v.id_usuario='$id_usuario'");
        $obj3 = json_decode(json_encode($z), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO QR';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;

        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_forma', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
 
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaDepositoUsuario(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;
        $id_usuario = $request->id_usuario;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=5  AND v.id_usuario='$id_usuario'");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total_deposito) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=5  AND v.id_usuario='$id_usuario'");
        $obj3 = json_decode(json_encode($z), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO DEPOSITO';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;

        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_forma', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
 
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    public function pdfVentaDetalladaMixtaUsuario(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;
        $id_usuario = $request->id_usuario;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=6  AND v.id_usuario='$id_usuario'");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_forma_pago=6  AND v.id_usuario='$id_usuario'");
        $obj3 = json_decode(json_encode($z), true);


        $c=DB::select("SELECT SUM(v.total_efectivo) as totalEf
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'  AND v.id_forma_pago=6");
        $obj7 = json_decode(json_encode($c), true);

        $d=DB::select("SELECT SUM(v.total_deposito) as totalDep
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado' AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda'  AND v.id_forma_pago=6");
        $obj8 = json_decode(json_encode($d), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO MIXTA';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;
        $detalles7=$obj7;
        $detalles8=$obj8;
        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada_mixta', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
            'detalles7'=>$detalles7,
            'detalles8'=>$detalles8,
            
        ]);
        return $pdf->stream('Ventas.pdf');
    }
    //Usuario
    public function pdfVentaDetalladaMesero(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;
        $id_mesero = $request->id_mesero;

        $x=DB::select("SELECT v.id,v.fecha,v.sub_total,v.descuento,v.total,
        v.total_efectivo,v.total_deposito,c.nombre as cliente,t.nombre as tipo_pago,
        f.nombre as forma_pago, u.name as usuario, td.nombre as tienda,m.nombre as mesa,v.usuario
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_usuario='$id_mesero'");
        $obj = json_decode(json_encode($x), true);

        $z=DB::select("SELECT SUM(v.total) as totalV
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_usuario='$id_mesero'");
        $obj3 = json_decode(json_encode($z), true);

        $a=DB::select("SELECT SUM(v.total) as totalC
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Cobrado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id AND v.tipo_venta='$tipo_venta'
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=1");
        $obj5 = json_decode(json_encode($a), true);

        $b=DB::select("SELECT SUM(v.total) as totalCr
        FROM venta v, cliente c, tipo_pago t, forma_pago f, users u, tienda td
        WHERE v.estado='Cobrado' AND v.id_cliente=c.id AND v.id_tipo_pago=t.id AND v.id_forma_pago=f.id AND v.id_usuario=u.id AND v.id_tienda=td.id AND v.tipo_venta='$tipo_venta'
        AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_tipo_pago=2");
        $obj6 = json_decode(json_encode($b), true);

        $c=DB::select("SELECT SUM(v.total_efectivo) as totalEf
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_usuario='$id_mesero'");
        $obj7 = json_decode(json_encode($c), true);

        $d=DB::select("SELECT SUM(v.total_deposito) as totalDep
        FROM venta v INNER JOIN cliente c ON
        v.id_cliente=c.id INNER JOIN tipo_pago t ON
        v.id_tipo_pago=t.id INNER JOIN forma_pago f ON
        v.id_forma_pago=f.id INNER JOIN users u ON
        v.id_usuario=u.id INNER JOIN tienda td ON
        v.id_tienda=td.id LEFT JOIN mesa as m ON
        v.id_mesa= m.id
        WHERE v.estado='Cobrado'AND v.fecha>='$fecha_inicio' AND v.fecha<='$fecha_fin' AND td.id='$id_tienda' AND v.id_usuario='$id_mesero'");
        $obj8 = json_decode(json_encode($d), true);

        $y=DB::select("SELECT d.id_venta,d.cantidad,p.nombre producto, d.costo_venta, d.sub_total
        FROM detalle_venta d, tienda_articulo ta, articulo p
        WHERE d.id_tienda_articulo=ta.id AND ta.id_articulo=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE VENTAS DETALLADO';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $venta=$obj;
        $detalles=$obj2;
        $detalles2=$obj3;
        $detalles5=$obj5;
        //dd($detalles5);
        $detalles6=$obj6;
        $detalles7=$obj7;
        $detalles8=$obj8;
        //dd($venta,$detalles);
        
        $cont=Venta::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_detallada', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'venta'=>$venta,
            'detalles'=>$detalles,

            'detalles2'=>$detalles2,
            'detalles5'=>$detalles5,
            'detalles6'=>$detalles6,
            'detalles7'=>$detalles7,
            'detalles8'=>$detalles8,
            
        ]);
        return $pdf->stream('Ventas.pdf');
    }


    public function pdfPagoVenta(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        $tipo_venta = $request->tipo_venta;
        $id_tienda = $request->id_tienda;

        $y=DB::select("SELECT p.fecha, p.fecha_final,p.monto,p.saldo,p.id, c.nombre as cliente, t.nombre as tienda, p.id_tipo_pago, p.estado
        FROM pago p, venta v, cliente c, tienda t
        WHERE p.id_venta=v.id AND v.id_cliente=c.id AND v.id_tienda=t.id AND p.id_tipo_pago=2
        AND p.fecha>='$fecha_inicio' AND p.fecha<='$fecha_fin' AND p.estado=1 ");
        $obj2 = json_decode(json_encode($y), true);

        $x=DB::select("SELECT i.nombre cliente,c.fecha, c.amortizacion,c.saldo,id_pago,c.descripcion
        FROM c_x_cobrar c, pago p, venta v, cliente i
        WHERE c.id_pago=p.id AND p.id_venta=v.id AND v.id_cliente=i.id");
        $obj = json_decode(json_encode($x), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')->where('id','=',$id_tienda)
        ->get();

        $title='LISTADO DE PAGOS AL CRÉDITO';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $cod_empresa=$mi_empresa[0]->cod_tienda;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $cod_almacen=$mi_empresa[0]->cod_almacen;
        $foto_empresa=$mi_empresa[0]->foto;

        $detalles=$obj;
        $venta_pago=$obj2;
        
        $cont=Pago::count();
        $pdf = \PDF::loadView('pdf.reportes.venta.venta_pago', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'tipo_venta'=>$tipo_venta,
            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,
            'venta_pago'=>$venta_pago
            
        ]);
        return $pdf->stream('Pagos.pdf');
    }
    public function pdfCliente(Request $request){

        // $cli=DB::select("SELECT c.nombre_cliente as cliente,c.nombre_contrato as contacto,c.nit as nit,c.direccion as direccion,c.telefono_celular as celular,c.correo as correo
        // from cliente c
        // where  c.estado!=0 ");
        $cli= Cliente::select('cliente.nombre as cliente','cliente.direccion','cliente.telefono','cliente.descripcion','cliente.descuento')
        ->where('cliente.estado','!=','0')
        ->get();

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $title='LISTA DE PERSONAL';
        $nombre_empresa=$mi_empresa[0]->nombre;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $foto_empresa=$mi_empresa[0]->foto;

        $detalles=$cli;
        
        $cont=cliente::count();
        $pdf = \PDF::loadView('pdf.reportes.cliente.cliente', [
            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'foto_empresa'=>$foto_empresa,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Clientes.pdf');
    }
    public function pdfTraspasoGeneral(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 

        $x=DB::select("SELECT t.id, t.fecha, t.hora, ta1.nombre as tienda1, ta2.nombre as tienda2, u.name, t.glosa
        FROM traspasos t, tienda ta1, tienda ta2, users u
        WHERE t.estado!='0' AND t.id_tienda1=ta1.id AND t.id_tienda2=ta2.id AND t.id_usuario=u.id
        AND t.fecha>='$fecha_inicio' AND t.fecha<='$fecha_fin' GROUP BY t.id");

        $obj = json_decode(json_encode($x), true);

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')
        ->get();

        $title='LISTADO DE TRASPASO';
        $nombre_empresa=$mi_empresa[1]->nombre;
        $cod_empresa=$mi_empresa[1]->cod_tienda;
        $direccion_empresa=$mi_empresa[1]->direccion;
        $telefono_empresa=$mi_empresa[1]->telefono;
        $cod_almacen=$mi_empresa[1]->cod_almacen;
        $foto_empresa=$mi_empresa[1]->foto;

        $detalles=$obj;
        
        
        $cont=Compra::count();
        $pdf = \PDF::loadView('pdf.reportes.traspaso.traspaso_general', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Compra.pdf');
    }
    public function pdfTraspasoDetallado(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 

        $mi_empresa= tienda::select('tienda.nombre','tienda.cod_tienda','tienda.direccion','tienda.telefono','tienda.cod_almacen'
        ,'tienda.foto')
        ->get();

        $x=DB::select("SELECT t.id, t.fecha, t.hora, ta1.nombre as tienda1, ta2.nombre as tienda2, u.name, t.glosa
        FROM traspasos t, tienda ta1, tienda ta2, users u
        WHERE t.estado!='0' AND t.id_tienda1=ta1.id AND t.id_tienda2=ta2.id AND t.id_usuario=u.id
        AND t.fecha>='$fecha_inicio' AND t.fecha<='$fecha_fin' GROUP BY t.id");
        $obj = json_decode(json_encode($x), true);

        $y= detalleTraspaso::join('traspasos','detalle_traspasos.id_traspaso','=','traspasos.id')
        ->join('tienda_articulo','detalle_traspasos.id_tienda_articulo','=','tienda_articulo.id')
        ->join('articulo','tienda_articulo.id_articulo','=','articulo.id')
        ->leftjoin('categoria', function($join){
            $join->orOn('articulo.id_categoria','=','categoria.id');
        })
        ->join('tienda','tienda_articulo.id_tienda','=','tienda.id')
        ->select('detalle_traspasos.id_traspaso','detalle_traspasos.cantidad','detalle_traspasos.id_tienda_articulo',
        'articulo.cod_producto','articulo.cod_proveedor','articulo.cod_ean','articulo.nombre as producto','articulo.marca','categoria.nombre as categoria',
        'articulo.costo_compra','articulo.costo_unitario','articulo.costo_mayorista','articulo.costo_preferencial','articulo.nombre as articulo',
        'tienda.nombre as tienda','tienda.id as id_tienda','tienda_articulo.stock')
        ->get();
        $obj2 = json_decode(json_encode($y), true);

        $title='LISTADO DE TRASPASO DETALLADO';
        $nombre_empresa=$mi_empresa[1]->nombre;
        $cod_empresa=$mi_empresa[1]->cod_tienda;
        $direccion_empresa=$mi_empresa[1]->direccion;
        $telefono_empresa=$mi_empresa[1]->telefono;
        $cod_almacen=$mi_empresa[1]->cod_almacen;
        $foto_empresa=$mi_empresa[1]->foto;

        $traspaso=$obj;
        $detalles=$obj2;
        
        $cont=Traspaso::count();
        $pdf = \PDF::loadView('pdf.reportes.traspaso.traspaso_detallado', [

            'title'=>$title,
            'nombre_empresa'=>$nombre_empresa,
            'cod_empresa'=>$cod_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'cod_almacen'=>$cod_almacen,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,
            'traspaso'=>$traspaso
            
        ]);
        return $pdf->stream('Traspaso_Detallado.pdf');
    }

    //En desarrollo
    public function pdfClienteVenta(Request $request){

        $cliente=DB::select("SELECT c.nombre_cliente as nombre_cliente,Count(v.id) as cantidad_venta
        from cliente c, venta v 
        where v.id_cliente=c.id and c.estado!=0  group by c.nombre_cliente LIMIT 10");

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $nombre_empresa=$mi_empresa[0]->nombre;
        $nit_empresa=$mi_empresa[0]->nit;
        $representante_empresa=$mi_empresa[0]->representante;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $localidad_empresa=$mi_empresa[0]->localidad;
        $correo_empresa=$mi_empresa[0]->Correo;
        $sitio_web_empresa=$mi_empresa[0]->sitio_web;
        $foto_empresa=$mi_empresa[0]->foto;

        $nombre_cliente=$cliente[0]->nombre_cliente;
        $cantidad_venta=$cliente[0]->cantidad_venta;
        $cliente_todo=$cliente;
        

        $cont=cliente::count();
        $pdf = \PDF::loadView('pdf.cliente.cliente', [

            'nombre_empresa'=>$nombre_empresa,
            'nit_empresa'=>$nit_empresa,
            'representante_empresa'=>$representante_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'localidad_empresa'=>$localidad_empresa,
            'correo_empresa'=>$correo_empresa,
            'sitio_web_empresa'=>$sitio_web_empresa,
            'foto_empresa'=>$foto_empresa,

            'nombre_cliente'=>$nombre_cliente,
            'cantidad_venta'=>$cantidad_venta,
            'cliente_todo'=>$cliente_todo,
            
        ]);
        return $pdf->stream('Clientes.pdf');
    }

    public function pdfOrdenGeneral(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 

        $x=DB::select("SELECT o.codigo_orden,o.fecha,o.dias_credito,o.fecha_entrega,p.nombre proveedor,u.name usuario,t.nombre tipo_pago,o.sub_total,o.descuento,o.total 
        FROM orden o, proveedor p, tipo_pago t , users u
        WHERE o.estado!='Anulado' AND o.id_proveedor=p.id AND o.id_tipo_pago=t.id AND o.id_usuario=u.id 
        AND o.fecha>='$fecha_inicio' AND o.fecha<='$fecha_fin'");

        $obj = json_decode(json_encode($x), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $nombre_empresa=$mi_empresa[0]->nombre;
        $nit_empresa=$mi_empresa[0]->nit;
        $representante_empresa=$mi_empresa[0]->representante;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $localidad_empresa=$mi_empresa[0]->localidad;
        $correo_empresa=$mi_empresa[0]->Correo;
        $sitio_web_empresa=$mi_empresa[0]->sitio_web;
        $foto_empresa=$mi_empresa[0]->foto;

        $detalles=$obj;
        
        
        $cont=Orden::count();
        $pdf = \PDF::loadView('pdf.orden.orden_general', [

            'nombre_empresa'=>$nombre_empresa,
            'nit_empresa'=>$nit_empresa,
            'representante_empresa'=>$representante_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'localidad_empresa'=>$localidad_empresa,
            'correo_empresa'=>$correo_empresa,
            'sitio_web_empresa'=>$sitio_web_empresa,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Orden.pdf');
    }

    public function pdfProformaGeneral(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 

        $x=DB::select("SELECT p.codigo_proforma, p.dias_credito,p.fecha,p.fecha_venci,p.lugar_entrega,
        p.sub_total,p.descuento,p.total,c.nombre_cliente as cliente,t.nombre as tipo_pago, u.name as usuario
        FROM proforma p, cliente c, tipo_pago t, users u
        WHERE p.estado!='Anulado' AND p.id_cliente=c.id AND p.id_tipo_pago=t.id AND p.id_usuario=u.id
        AND p.fecha>='$fecha_inicio' AND p.fecha<='$fecha_fin'");

        $obj = json_decode(json_encode($x), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $nombre_empresa=$mi_empresa[0]->nombre;
        $nit_empresa=$mi_empresa[0]->nit;
        $representante_empresa=$mi_empresa[0]->representante;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $localidad_empresa=$mi_empresa[0]->localidad;
        $correo_empresa=$mi_empresa[0]->Correo;
        $sitio_web_empresa=$mi_empresa[0]->sitio_web;
        $foto_empresa=$mi_empresa[0]->foto;

        $detalles=$obj;

        $cont=Proforma::count();
        $pdf = \PDF::loadView('pdf.proforma.proforma_general', [

            'nombre_empresa'=>$nombre_empresa,
            'nit_empresa'=>$nit_empresa,
            'representante_empresa'=>$representante_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'localidad_empresa'=>$localidad_empresa,
            'correo_empresa'=>$correo_empresa,
            'sitio_web_empresa'=>$sitio_web_empresa,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Proforma.pdf');
    }

    public function pdfOrdenDetallada(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 

        $x=DB::select("SELECT o.id, o.codigo_orden,o.fecha,o.dias_credito,o.fecha_entrega,p.nombre proveedor,u.name usuario,t.nombre tipo_pago,o.sub_total,o.descuento,o.total 
        FROM orden o, proveedor p, tipo_pago t , users u
        WHERE o.estado!='Anulado' AND o.id_proveedor=p.id AND o.id_tipo_pago=t.id AND o.id_usuario=u.id 
        AND o.fecha>='$fecha_inicio' AND o.fecha<='$fecha_fin'");
        $obj = json_decode(json_encode($x), true);

        $y=DB::select("SELECT d.id_orden,d.cantidad,d.id_orden,p.nombre producto, d.pu, d.sub_total
        FROM detalle_orden d, producto p
        WHERE d.id_producto=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $nombre_empresa=$mi_empresa[0]->nombre;
        $nit_empresa=$mi_empresa[0]->nit;
        $representante_empresa=$mi_empresa[0]->representante;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $localidad_empresa=$mi_empresa[0]->localidad;
        $correo_empresa=$mi_empresa[0]->Correo;
        $sitio_web_empresa=$mi_empresa[0]->sitio_web;
        $foto_empresa=$mi_empresa[0]->foto;

        $orden=$obj;
        $detalles=$obj2;
        //dd($orden,$detalles);
        
        $cont=Orden::count();
        $pdf = \PDF::loadView('pdf.orden.orden_detallada', [

            'nombre_empresa'=>$nombre_empresa,
            'nit_empresa'=>$nit_empresa,
            'representante_empresa'=>$representante_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'localidad_empresa'=>$localidad_empresa,
            'correo_empresa'=>$correo_empresa,
            'sitio_web_empresa'=>$sitio_web_empresa,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'orden'=>$orden,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Orden.pdf');
    }

    public function pdfProformaDetallada(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin; 

        $x=DB::select("SELECT p.id, p.codigo_proforma, p.dias_credito,p.fecha,p.fecha_venci,p.lugar_entrega,
        p.sub_total,p.descuento,p.total,c.nombre_cliente as cliente,t.nombre as tipo_pago, u.name as usuario
        FROM proforma p, cliente c, tipo_pago t, users u
        WHERE p.estado!='Anulado' AND p.id_cliente=c.id AND p.id_tipo_pago=t.id AND p.id_usuario=u.id
        AND p.fecha>='$fecha_inicio' AND p.fecha<='$fecha_fin'");
        $obj = json_decode(json_encode($x), true);

        $y=DB::select("SELECT d.id_proforma,d.cantidad,p.nombre producto, d.pu, d.sub_total
        FROM detalle_proforma d, producto p
        WHERE d.id_producto=p.id");
        $obj2 = json_decode(json_encode($y), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $nombre_empresa=$mi_empresa[0]->nombre;
        $nit_empresa=$mi_empresa[0]->nit;
        $representante_empresa=$mi_empresa[0]->representante;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $localidad_empresa=$mi_empresa[0]->localidad;
        $correo_empresa=$mi_empresa[0]->Correo;
        $sitio_web_empresa=$mi_empresa[0]->sitio_web;
        $foto_empresa=$mi_empresa[0]->foto;

        $proforma=$obj;
        $detalles=$obj2;
        
        //dd($proforma,$detalles);
        
        $cont=Proforma::count();
        $pdf = \PDF::loadView('pdf.proforma.proforma_detallada', [

            'nombre_empresa'=>$nombre_empresa,
            'nit_empresa'=>$nit_empresa,
            'representante_empresa'=>$representante_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'localidad_empresa'=>$localidad_empresa,
            'correo_empresa'=>$correo_empresa,
            'sitio_web_empresa'=>$sitio_web_empresa,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'proforma'=>$proforma,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Proforma.pdf');
    }

    public function pdfPagoCompra(Request $request){

        // $obj= Gasto::join('motivo_gasto','gasto.id_motivo_gasto','=','motivo_gasto.id')
        // ->select('gasto.fecha','gasto.monto','gasto.descripcion'
        // ,'motivo_gasto.nombre as motivo_gasto')
        // ->get();
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;

        $x=DB::select("SELECT i.nombre proveedor,c.fecha, c.amortizacion,c.saldo 
        FROM cuota c, pago p, compra v, proveedor i
        WHERE c.id_pago=p.id AND p.id_compra=v.id AND v.id_proveedor=i.id AND c.amortizacion!=0
        AND c.fecha>='$fecha_inicio' AND c.fecha<='$fecha_fin'");
        $obj = json_decode(json_encode($x), true);

        $mi_empresa= MiEmpresa::select('mi_empresa.nombre','mi_empresa.nit','mi_empresa.representante','mi_empresa.direccion','mi_empresa.telefono'
        ,'mi_empresa.localidad','mi_empresa.Correo','mi_empresa.sitio_web','mi_empresa.foto')
        ->get();

        $nombre_empresa=$mi_empresa[0]->nombre;
        $nit_empresa=$mi_empresa[0]->nit;
        $representante_empresa=$mi_empresa[0]->representante;
        $direccion_empresa=$mi_empresa[0]->direccion;
        $telefono_empresa=$mi_empresa[0]->telefono;
        $localidad_empresa=$mi_empresa[0]->localidad;
        $correo_empresa=$mi_empresa[0]->Correo;
        $sitio_web_empresa=$mi_empresa[0]->sitio_web;
        $foto_empresa=$mi_empresa[0]->foto;


        $detalles=$obj;
        //dd($detalles);
        
        //$cont=PagoCompra::count();
        $pdf = \PDF::loadView('pdf.compra.compra_pago', [

            'nombre_empresa'=>$nombre_empresa,
            'nit_empresa'=>$nit_empresa,
            'representante_empresa'=>$representante_empresa,
            'direccion_empresa'=>$direccion_empresa,
            'telefono_empresa'=>$telefono_empresa,
            'localidad_empresa'=>$localidad_empresa,
            'correo_empresa'=>$correo_empresa,
            'sitio_web_empresa'=>$sitio_web_empresa,
            'foto_empresa'=>$foto_empresa,

            'fecha_inicio'=>$fecha_inicio,
            'fecha_fin'=>$fecha_fin,
            'detalles'=>$detalles,
            
        ]);
        return $pdf->stream('Pagos.pdf');
    }


}
