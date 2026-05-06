<?php
namespace App\Modules\Siat\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use App\Modules\Siat\Entities\Invoice;
use App\Modules\Siat\Entities\Batch;
use App\Modules\Siat\Models\InvoiceModel;
use App\Contact;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modules\Siat\Resources\ResourceInvoice;
use App\Modules\Siat\Classes\ExceptionInvalidNit;
use App\Product;
use App\Modules\Siat\Resources\ResourceProduct;
use App\Modules\Siat\Settings;
use Illuminate\Database\Eloquent\Builder;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use App\Modules\Siat\Models\SiatModel;



class ApiInvoicesController extends Controller
{
	/**
	 * @var InvoiceModel
	 */
	protected	$invoicesModel;
	/*
	public function __construct(InvoiceModel $model)
	{
		$this->invoicesModel = $model;
	}
	*/
	protected function fillInvoice(array $data)
	{
		$user = auth()->user();
		$invoice = new Invoice();
		$invoice->fill($data);
		if( isset($data['monto_giftcard']) )
			$invoice->giftcard_amount = (float)$data['monto_giftcard'];
		$invoice->codigo_puntoventa = $data['punto_venta'];
		if( isset($data['data']['excepcion']) )
			$invoice->excepcion = $data['data']['excepcion'];
		if( isset($data['data']['nro_factura']) )
			$invoice->invoice_number_cafc = (int)$data['data']['nro_factura'];
		if( isset($data['invoice_date_time']) )
		{
			$invoice->invoice_datetime = date('Y-m-d H:i:s', strtotime($data['invoice_date_time']));
		}
		if( !$invoice->invoice_datetime )
			$invoice->invoice_datetime = date('Y-m-d H:i:s');
		
		$invoice->saveItems($data['items']);
		$invoice->user_id = $user ? $user->id : -1;
		
		return $invoice;
	}
	public function create(InvoiceModel $model)
	{
		$user = auth()->user();
		try
		{
			$data = request()->json()->all();
			$invoice = $this->fillInvoice($data);
			
			if( in_array($invoice->codigo_documento_sector, [23]) )
			{
				if( !isset($data['data']['cantidad']) || (int)$data['data']['cantidad'] <= 0 )
					throw new Exception('Debe especificar la cantidad de facturas a generar');
				if($invoice->total > 1000 )
					throw new Exception('El monto maximo de factura prevalorada es de 1000');
				$result = null;
				DB::beginTransaction();
				if( (int)$data['data']['cantidad'] > 1 )
				{
					$batch = new Batch();
					$batch->codigo_sucursal 		= $invoice->codigo_sucursal;
					$batch->codigo_puntoventa 		= $invoice->codigo_puntoventa;
					$batch->codigo_documento_sector = $invoice->codigo_documento_sector;
					$batch->tipo_factura_documento	= $invoice->tipo_factura_documento;
					$batch->cantidad				= (int)$data['data']['cantidad'];
					$batch->estado					= Batch::STATUS_PROCESSING;
					$batch->save();
					$invoices = [];
					for($i = 0; $i < (int)$data['data']['cantidad']; $i++)
					{
						$invoice->batch_id = $batch->id;
						$model->create($invoice);
						$invoices[] = $invoice;
						$invoice 	= $this->fillInvoice($data);
						$invoice->batch_id = $batch->id;
					}
					$model->sendMassiveBatch($batch);
					$result = new ResourceInvoice($batch->invoices()->first());
				}
				else 
				{
					$model->create($invoice);
					$result = new ResourceInvoice($invoice);
				}
				DB::commit();

				//inicio
				$datosFactura = DB::table('mb_invoices')->select('id','customer_id', 'codigo_sucursal', 'codigo_puntoventa', 
				'codigo_documento_sector', 'tipo_emision', 'tipo_factura_documento', 'tipo_documento_identidad',
				'codigo_metodo_pago', 'codigo_moneda', 'nit_emisor', 'customer', 'nit_ruc_nif', 'complemento', 
				DB::raw('CAST(subtotal AS DECIMAL(10, 2)) AS subtotal'), 
				DB::raw('CAST(discount AS DECIMAL(10, 2)) AS discount'), 
				DB::raw('CAST(total AS DECIMAL(10, 2)) AS total'), 
				DB::raw('CAST(giftcard_amount AS DECIMAL(10, 2)) AS giftcard_amount'), 
				'invoice_number', 'cuf', 'invoice_datetime', 'leyenda',
				'ambiente')->where('mb_invoices.id', $invoice->id)->first();

				$detallesFactura=DB::table('mb_invoice_items')
				->join('mb_invoices', 'mb_invoices.id', '=', 'mb_invoice_items.invoice_id')
				->select('product_code', 'product_name', 'quantity', 'price', 
				'mb_invoice_items.subtotal', 'mb_invoice_items.discount', 'mb_invoice_items.total', 'mb_invoice_items.imei')
				->where('mb_invoice_items.invoice_id', $invoice->id)
				->get();

				$model=new SiatModel(); 
				$config = $model->getConfig();
				$cufd = $model->getCufd($config, null, $invoice->codigo_sucursal, $invoice->codigo_puntoventa);
				$arrayDetallesEmpresa=[
					'nro_puntoventa'=>$invoice->codigo_puntoventa,
					'telefono'=>$config->telefono,
					'direccion'=>$cufd->direccion,
					'ciudad'=>$config->ciudad,
					'razon_social'=>$config->razonSocial,
				];
				$detallesEmpresa = (object) $arrayDetallesEmpresa;
				// data base 64 lista para transmitir
				$json = '['.json_encode($datosFactura, JSON_UNESCAPED_UNICODE) . ']|[' . json_encode($detallesEmpresa, JSON_UNESCAPED_UNICODE) . ']|' . json_encode($detallesFactura, JSON_UNESCAPED_UNICODE);

				$b64 = base64_encode($json);
				// return response(['code' => 200, 'data' => $result])->header('Content-Type', 'application/json');
				return response(['code' => 200, 'data' => $b64, 'id' => $invoice->id])->header('Content-Type', 'application/json');
				//fin
				//return response(['code' => 200, 'data' => $result])->header('Content-Type', 'application/json');
			}
			else
			{
				DB::beginTransaction();
				$model->create($invoice);
				DB::commit();
				//inicio
				$datosFactura = DB::table('mb_invoices')->select('id','customer_id', 'codigo_sucursal', 'codigo_puntoventa', 
				'codigo_documento_sector', 'tipo_emision', 'tipo_factura_documento', 'tipo_documento_identidad',
				'codigo_metodo_pago', 'codigo_moneda', 'nit_emisor', 'customer', 'nit_ruc_nif', 'complemento', 
				DB::raw('CAST(subtotal AS DECIMAL(10, 2)) AS subtotal'), 
				DB::raw('CAST(discount AS DECIMAL(10, 2)) AS discount'), 
				DB::raw('CAST(total AS DECIMAL(10, 2)) AS total'), 
				DB::raw('CAST(giftcard_amount AS DECIMAL(10, 2)) AS giftcard_amount'), 
				'invoice_number', 'cuf', 'invoice_datetime', 'leyenda',
				'ambiente')->where('mb_invoices.id', $invoice->id)->first();

				$detallesFactura=DB::table('mb_invoice_items')
				->join('mb_invoices', 'mb_invoices.id', '=', 'mb_invoice_items.invoice_id')
				->select('product_code', 'product_name', 'quantity', 'price', 
				'mb_invoice_items.subtotal', 'mb_invoice_items.discount', 'mb_invoice_items.total','mb_invoice_items.imei')
				->where('mb_invoice_items.invoice_id', $invoice->id)
				->get();

				$model=new SiatModel(); 
				$config = $model->getConfig();
				$cufd = $model->getCufd($config, null, $invoice->codigo_sucursal, $invoice->codigo_puntoventa);
				$arrayDetallesEmpresa=[
					'nro_puntoventa'=>$invoice->codigo_puntoventa,
					'telefono'=>$config->telefono,
					'direccion'=>$cufd->direccion,
					'ciudad'=>$config->ciudad,
					'razon_social'=>$config->razonSocial,
				];
				$detallesEmpresa = (object) $arrayDetallesEmpresa;

				// data base 64 lista para transmitir
				//$json=$datosFactura->toJson() . '|' . $detallesEmpresa->toJson() . '|' . $detallesFactura->toJson();
				$json = '['.json_encode($datosFactura, JSON_UNESCAPED_UNICODE) . ']|[' . json_encode($detallesEmpresa, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ']|' . json_encode($detallesFactura, JSON_UNESCAPED_UNICODE);

				$b64 = base64_encode($json);
				// return response(['data' => new ResourceInvoice($invoice)])->header('Content-Type', 'application/json');
				return response(['code' => 200, 'data' => $b64, 'id' => $invoice->id])->header('Content-Type', 'application/json');
				//fin
				//return response(['data' => new ResourceInvoice($invoice)])->header('Content-Type', 'application/json');
			}
		}
		catch (ExceptionInvalidNit $e)
		{
			DB::rollBack();
			return response(['error' => $e->getMessage(), 'response' => 'error_nit'], 500)->header('Content-Type', 'application/json');
		}
		catch(Exception $e)
		{
			DB::rollBack();
			//print_r($e->getTrace());
			return response(['error' => $e->getMessage()], 500)->header('Content-Type', 'application/json');	
		}
	}
	public function read()
	{
		
	}
	public function readAll()
	{
		$user = auth()->user();
		try
		{
			$limit	= 25;
			$page 	= (int)request()->get('page');
			$startDate 	= request()->get('fecha_inicio');
			$endDate 	= request()->get('fecha_fin');

			$id_usuario 	= request()->get('id_usuario');

			$offset = ($page <= 1) ? 0 : (($page - 1) * $limit);
			if($id_usuario==0){
				$count	= Invoice::whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				//->where('user_id', $id_usuario)
				->count();
			}else{
				$count	= Invoice::whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('user_id', $id_usuario)
				->count();
			}
			$total_pages = ceil($count / $limit);
			/*$items 	= Invoice::orderBy('id', 'desc')->offset($offset)->limit($limit)
			->whereBetween('invoice_datetime', [
				\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
				\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
			])
			->where('user_id', $id_usuario)
			->get();*/
			if($id_usuario==0){
				$items 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')->offset($offset)->limit($limit)
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				//->where('user_id', $id_usuario)
				->get();
			}else{
				$items 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')->offset($offset)->limit($limit)
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('user_id', $id_usuario)
				->get();
			}

			/*$itemsTodos 	= Invoice::orderBy('id', 'desc')
			->whereBetween('invoice_datetime', [
				\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
				\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
			])
			->where('user_id', $id_usuario)
			->get();*/
			if($id_usuario==0){
				$itemsTodos 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				//->where('user_id', $id_usuario)
				->get();
			}else{
				$itemsTodos 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('user_id', $id_usuario)
				->get();
			}


			$invoices = [];
			foreach($items as $item)
			{
				$invoices[] = new ResourceInvoice($item);
			}
			$invoicesTodos = [];
			foreach($itemsTodos as $item2)
			{
				$invoicesTodos[] = new ResourceInvoice($item2);
			}
			return response(['data' => $invoices, 'data2' => $invoicesTodos])
				->header('Content-Type', 'application/json')
				->header('Total-Pages', $total_pages);
		}
		catch(Exception $e)
		{
			return response(['error' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
		}
	}
	public function anular(int $id, InvoiceModel $model)
	{
		$user = auth()->user();
		try
		{
			$invoice = Invoice::find($id);
			if( !$invoice )
				throw new Exception('La factura no existe');
			$model->void($invoice, (object)request()->json()->all());
			
			return response(['data' => $invoice])
				->header('Content-Type', 'application/json');
		}
		catch(Exception $e)
		{
			return response(['error' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
		}
	}
	public function search()
	{
		$keyword 	= request()->get('keyword');
		$startDate 	= request()->get('fecha_inicio');
		$endDate 	= request()->get('fecha_fin');
		$sucursal 	= (int)request()->get('sucursal', -1);
		$id_usuario = request()->get('id_usuario');
		// $query 		= Invoice::where('id', '>', 0);

		$query 		= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
		->select('mb_invoices.*', 'mb_invoice_items.imei')
		->where('mb_invoices.id', '>', 0);

		if( !empty($keyword) )
		{
			if($id_usuario==0){
				$query->where(function(Builder $builder) use($keyword, $startDate, $endDate, $id_usuario)
				{
						$builder->where(function ($query) use ($keyword, $startDate, $endDate) {
							$query->where('invoice_number', 'like', '%' . $keyword . '%')
								->orWhere('customer', 'like', '%' . $keyword . '%')
								->orWhere('nit_ruc_nif', 'like', '%' . $keyword . '%');
						})
						->whereBetween('invoice_datetime', [
							\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
							\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
						]);
	
				});
			}else{
				$query->where(function(Builder $builder) use($keyword, $startDate, $endDate, $id_usuario)
				{
						$builder->where('user_id', $id_usuario)->where(function ($query) use ($keyword, $startDate, $endDate) {
							$query->where('invoice_number', 'like', '%' . $keyword . '%')
								->orWhere('customer', 'like', '%' . $keyword . '%')
								->orWhere('nit_ruc_nif', 'like', '%' . $keyword . '%');
						})
						->whereBetween('invoice_datetime', [
							\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
							\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
						]);
	
				});
			}
			
		}
		
		
		if( $sucursal >= 0 )
			$query->where('codigo_sucursal', $sucursal);
		
		$query->limit(25);
		//$sql = str_replace(array('?'), array('\'%s\''), $query->toSql());
		//$sql = vsprintf($sql, $query->getBindings());
		//die($sql);
		$invoices = $query->get();
		$items = [];
		foreach($invoices as $inv)
		{
			$items[] = new ResourceInvoice($inv);
		}
		return response(['data' => $items])->header('Content-Type', 'application/json');
	}
	public function searchProduct()
	{
		$keyword 	= request()->get('keyword');
		$limit		= (int)request()->get('limit', 25);
		$items = [];
		if( Settings::getInstance()->isUltimatePOS() )
		{
			$products = \App\Product::where('sku', 'like', '%' . $keyword . '%')
				->orWhere('name', 'like', '%' . $keyword . '%')
				->limit($limit)->get();
		}
		else
		{
			$products = \App\Modules\Siat\Entities\Product::where('code', 'like', '%' . $keyword . '%')
				->orWhere('name', 'like', '%' . $keyword . '%')
				->limit($limit)->get();
		}
		
		foreach($products as $prod)
		{
			$items[] = new ResourceProduct($prod);
		}
		return response(['data' => $items])
			->header('Content-Type', 'application/json');
	}
	public function sendMassiveBatch(int $id)
	{
		try
		{
			$batch = Batch::find($id);
			if( !$batch )
				throw new Exception('El lote de facturas no existe');
			$this->invoicesModel->sendMassiveBatch($batch);
			return response(['data' => $batch])->header('Content-Type', 'application/json');
		}
		catch(Exception $e)
		{
			return response(['error' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
		}
	}
	/*public function readAllReporte()
	{
		set_time_limit(6000);
		$user = auth()->user();
		try
		{
			$limit	= 25;
			$page 	= (int)request()->get('page');
			$startDate 	= request()->get('fecha_inicio');
			$endDate 	= request()->get('fecha_fin');
			$offset = ($page <= 1) ? 0 : (($page - 1) * $limit);
			$count	= Invoice::whereBetween('invoice_datetime', [
				\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
				\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
			])->count();
			$total_pages = ceil($count / $limit);
			$items 	= Invoice::orderBy('id', 'desc')
			->whereBetween('invoice_datetime', [
				\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
				\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
			])->get();
			$itemsTodos 	= Invoice::orderBy('id', 'desc')
			->whereBetween('invoice_datetime', [
				\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
				\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
			])->get();

			$invoices = [];
			$total_facturado = 0;
			$total_anuladas=0;
			foreach($items as $item)
			{
				
				$invoices[] = new ResourceInvoice($item);
				if($item->status=="ISSUED"){
					$total_facturado = $total_facturado+$item->total;
				}else{
					if($item->status=="VOID"){
						$total_anuladas = $total_facturado+$item->total;
					}
				}

			}
			$invoicesTodos = [];
			foreach($itemsTodos as $item2)
			{
				//$total_facturado = $total_facturado+$item2->total;

				$invoicesTodos[] = new ResourceInvoice($item2);
			}
			// return response(['data' => $invoices, 'data2' => $invoicesTodos])
			// 	->header('Content-Type', 'application/json')
			// 	->header('Total-Pages', $total_pages);

			$pdf = \PDF::loadView('pdf.reportes.factura.factura', [

			
				'fecha_inicio'=>$startDate,
				'fecha_fin'=>$endDate,
				'total_facturado'=>$total_facturado,
				'total_anuladas'=>$total_anuladas,
				'items'=>$items,
				
			]);
			
			//return $pdf->stream('Compra.pdf');
			return $pdf->setPaper('letter', 'portrait')->stream('Factura.pdf');
			// $pdfContent = '<h1>Contenido del PDF</h1>'; // Reemplaza esto con el contenido real que deseas incluir en el PDF

			// return response($pdfContent, 200, [
			// 	'Content-Type' => 'application/pdf',
			// 	'Content-Disposition' => 'inline; filename="archivo.pdf"',
			// ]);

		}
		catch(Exception $e)
		{
			return response(['error' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
		}
	}*/
	public function readAllReporte()
	{
		set_time_limit(6000);
		$user = auth()->user();
		try
		{
			$limit	= 25;
			$page 	= (int)request()->get('page');
			$startDate 	= request()->get('fecha_inicio');
			$endDate 	= request()->get('fecha_fin');

			$id_usuario 	= request()->get('id_usuario');


			$offset = ($page <= 1) ? 0 : (($page - 1) * $limit);

			$count	= Invoice::whereBetween('invoice_datetime', [
				\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
				\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
			])
			->count();

			$total_pages = ceil($count / $limit);
			$nombre_usuario = "";
			if($id_usuario==0){
				$items 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				//->where('user_id', $id_usuario)
				->get();
	
				$itemsTodos 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				//->where('user_id', $id_usuario)
				->get();
			}else{
				$items 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('user_id', $id_usuario)
				->get();
	
				$itemsTodos 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('user_id', $id_usuario)
				->get();

				$nombre_usuario = DB::table('users')
				->select('name')
				->where('users.id', $id_usuario)
				->first()->name;
			}
			

			$invoices = [];
			$total_facturado = 0;
			$total_anuladas=0;
			foreach($items as $item)
			{
				
				$invoices[] = new ResourceInvoice($item);
				if($item->status=="ISSUED"){
					$total_facturado = $total_facturado+$item->total;
				}else{
					if($item->status=="VOID"){
						$total_anuladas = $total_anuladas+$item->total;
					}
				}

			}
			$invoicesTodos = [];
			foreach($itemsTodos as $item2)
			{
				//$total_facturado = $total_facturado+$item2->total;

				$invoicesTodos[] = new ResourceInvoice($item2);
			}
	
			
			$options = new Options();
			$options->set('isRemoteEnabled', true);
	
			$dompdf = new Dompdf($options);
			$fecha_inicio = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $startDate)->format('d-m-Y');
			$fecha_fin = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $endDate)->format('d-m-Y');
			$view = view('pdf.reportes.factura.factura', [
				'fecha_inicio' => $fecha_inicio,
				'fecha_fin' => $fecha_fin,
				'total_facturado' => $total_facturado,
				'total_anuladas' => $total_anuladas,
				'items' => $items,
				'nombre_usuario' => ($nombre_usuario=="")?"Todos":$nombre_usuario,
			]);
	
			$html = $view->render();
	
			$dompdf->loadHtml($html);
			$dompdf->setPaper('letter', 'portrait');
			$dompdf->render();
	
			return $dompdf->stream('Factura.pdf');

		}
		catch(Exception $e)
		{
			return response(['error' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
		}
	}
	public function readAllReporteTarjeta()
	{
		set_time_limit(6000);
		$user = auth()->user();
		try
		{
			$limit	= 25;
			$page 	= (int)request()->get('page');
			$startDate 	= request()->get('fecha_inicio');
			$endDate 	= request()->get('fecha_fin');

			$id_usuario 	= request()->get('id_usuario');

			$offset = ($page <= 1) ? 0 : (($page - 1) * $limit);
			$count	= Invoice::whereBetween('invoice_datetime', [
				\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
				\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
			])->count();
			$total_pages = ceil($count / $limit);

			$nombre_usuario = "";

			if($id_usuario==0){
				$items 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('codigo_metodo_pago', 2)
				->get();
				$itemsTodos 	= Invoice::orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])->get();
			}else{
				$items 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('codigo_metodo_pago', 2)
				->where('user_id', $id_usuario)
				->get();
				$itemsTodos 	= Invoice::orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('user_id', $id_usuario)
				->get();

				$nombre_usuario = DB::table('users')
				->select('name')
				->where('users.id', $id_usuario)
				->first()->name;
			}
			

			$invoices = [];
			$total_facturado = 0;
			$total_anuladas=0;
			foreach($items as $item)
			{
				
				$invoices[] = new ResourceInvoice($item);
				if($item->status=="ISSUED" && $item->codigo_metodo_pago==2){
					$total_facturado = $total_facturado+$item->total;
				}else{
					if($item->status=="VOID" && $item->codigo_metodo_pago==2){
						$total_anuladas = $total_anuladas+$item->total;
					}
				}

			}
			$invoicesTodos = [];
			foreach($itemsTodos as $item2)
			{
				//$total_facturado = $total_facturado+$item2->total;

				$invoicesTodos[] = new ResourceInvoice($item2);
			}
	
			
			$options = new Options();
			$options->set('isRemoteEnabled', true);
	
			$dompdf = new Dompdf($options);
			$fecha_inicio = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $startDate)->format('d-m-Y');
			$fecha_fin = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $endDate)->format('d-m-Y');
			$view = view('pdf.reportes.factura.factura_tarjeta', [
				'fecha_inicio' => $fecha_inicio,
				'fecha_fin' => $fecha_fin,
				'total_facturado' => $total_facturado,
				'total_anuladas' => $total_anuladas,
				'items' => $items,
				'nombre_usuario' => ($nombre_usuario=="")?"Todos":$nombre_usuario,

			]);
	
			$html = $view->render();
	
			$dompdf->loadHtml($html);
			$dompdf->setPaper('letter', 'portrait');
			$dompdf->render();
	
			return $dompdf->stream('Factura.pdf');

		}
		catch(Exception $e)
		{
			return response(['error' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
		}
	}
	public function readAllReporteDeposito()
	{
		set_time_limit(6000);
		$user = auth()->user();
		try
		{
			$limit	= 25;
			$page 	= (int)request()->get('page');
			$startDate 	= request()->get('fecha_inicio');
			$endDate 	= request()->get('fecha_fin');
			$id_usuario = request()->get('id_usuario');
			$offset = ($page <= 1) ? 0 : (($page - 1) * $limit);
			$count	= Invoice::whereBetween('invoice_datetime', [
				\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
				\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
			])->count();
			$total_pages = ceil($count / $limit);
			$nombre_usuario = "";

			if($id_usuario==0){
				$items 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->whereNotIn('codigo_metodo_pago', [1,2])
				->get();
				$itemsTodos 	= Invoice::orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])->get();
			}else{
				$items 	= Invoice::join('mb_invoice_items', 'mb_invoice_items.invoice_id', '=', 'mb_invoices.id')
				->select('mb_invoices.*', 'mb_invoice_items.imei')
				->orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('user_id', $id_usuario)
				->whereNotIn('codigo_metodo_pago', [1,2])
				->get();

				$itemsTodos 	= Invoice::orderBy('id', 'desc')
				->whereBetween('invoice_datetime', [
					\Illuminate\Support\Carbon::parse($startDate)->startOfDay(),
					\Illuminate\Support\Carbon::parse($endDate)->endOfDay()
				])
				->where('user_id', $id_usuario)
				->get();

				$nombre_usuario = DB::table('users')
				->select('name')
				->where('users.id', $id_usuario)
				->first()->name;
			}
			

			$invoices = [];
			$total_facturado = 0;
			$total_anuladas=0;
			foreach($items as $item)
			{
				
				$invoices[] = new ResourceInvoice($item);
				if($item->status=="ISSUED" && $item->codigo_metodo_pago!=2 && $item->codigo_metodo_pago!=1){
					$total_facturado = $total_facturado+$item->total;
				}else{
					if($item->status=="VOID" && $item->codigo_metodo_pago!=2 && $item->codigo_metodo_pago!=1){
						$total_anuladas = $total_anuladas+$item->total;
					}
				}

			}
			$invoicesTodos = [];
			foreach($itemsTodos as $item2)
			{
				//$total_facturado = $total_facturado+$item2->total;

				$invoicesTodos[] = new ResourceInvoice($item2);
			}
	
			
			$options = new Options();
			$options->set('isRemoteEnabled', true);
	
			$dompdf = new Dompdf($options);
			$fecha_inicio = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $startDate)->format('d-m-Y');
			$fecha_fin = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $endDate)->format('d-m-Y');
			$view = view('pdf.reportes.factura.factura_deposito', [
				'fecha_inicio' => $fecha_inicio,
				'fecha_fin' => $fecha_fin,
				'total_facturado' => $total_facturado,
				'total_anuladas' => $total_anuladas,
				'items' => $items,
				'nombre_usuario' => ($nombre_usuario=="")?"Todos":$nombre_usuario,

			]);
	
			$html = $view->render();
	
			$dompdf->loadHtml($html);
			$dompdf->setPaper('letter', 'portrait');
			$dompdf->render();
	
			return $dompdf->stream('Factura.pdf');

		}
		catch(Exception $e)
		{
			return response(['error' => $e->getMessage()], 500)->header('Content-Type', 'application/json');
		}
	}

	public function enviarComandas(){
		//inicio
		$id = request()->get('id');
		$datosFactura = DB::table('mb_invoices')->select('id','customer_id', 'codigo_sucursal', 'codigo_puntoventa', 
		'codigo_documento_sector', 'tipo_emision', 'tipo_factura_documento', 'tipo_documento_identidad',
		'codigo_metodo_pago', 'codigo_moneda', 'nit_emisor', 'customer', 'nit_ruc_nif', 'complemento', 
		DB::raw('CAST(subtotal AS DECIMAL(10, 2)) AS subtotal'), 
		DB::raw('CAST(discount AS DECIMAL(10, 2)) AS discount'), 
		DB::raw('CAST(total AS DECIMAL(10, 2)) AS total'), 
		DB::raw('CAST(giftcard_amount AS DECIMAL(10, 2)) AS giftcard_amount'), 
		'invoice_number', 'cuf', 'invoice_datetime', 'leyenda',
		'ambiente')->where('mb_invoices.id', $id)->first();

		$detallesFactura=DB::table('mb_invoice_items')
		->join('mb_invoices', 'mb_invoices.id', '=', 'mb_invoice_items.invoice_id')
		->select('product_code', 'product_name', 'quantity', 'price', 
		'mb_invoice_items.subtotal', 'mb_invoice_items.discount', 'mb_invoice_items.total','mb_invoice_items.imei')
		->where('mb_invoice_items.invoice_id', $id)
		->get();

		$model=new SiatModel(); 
		$config = $model->getConfig();
		$cufd = $model->getCufd($config, null, $datosFactura->codigo_sucursal, $datosFactura->codigo_puntoventa);
		$arrayDetallesEmpresa=[
			'nro_puntoventa'=>$datosFactura->codigo_puntoventa,
			'telefono'=>$config->telefono,
			'direccion'=>$cufd->direccion,
			'ciudad'=>$config->ciudad,
			'razon_social'=>$config->razonSocial,
		];
		$detallesEmpresa = (object) $arrayDetallesEmpresa;

		// data base 64 lista para transmitir
		$json = '['.json_encode($datosFactura, JSON_UNESCAPED_UNICODE) . ']|[' . json_encode($detallesEmpresa, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ']|' . json_encode($detallesFactura, JSON_UNESCAPED_UNICODE);

		$b64 = base64_encode($json);
		// return response(['data' => new ResourceInvoice($invoice)])->header('Content-Type', 'application/json');
		return response(['data' => $b64, 200])->header('Content-Type', 'application/json');
	}
}
