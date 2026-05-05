(function(ns)
{
	ns.InvoiceListing = {
		template: `<div id="com-siat-invoice-listing">
		<div class="row">
			<div class="mb-3 col-sm-3">
				<label for="inputPassword" class="col-sm-3 col-form-label">Fecha</label>
				<div><input type="date" class="form-control" @change="getInvoices(1)" @input="fechaInicioParaString()" v-model=fecha_inicio_string>
				</div>
			</div>
			<div class="mb-3 col-sm-3">
				<label for="inputPassword"  class="col-sm-4 col-form-label">Fecha Final</label>
				<div><input type="date" @change="getInvoices(1)" @input="fechaFinParaString()" class="form-control" v-model="fecha_fin_string"></div>
			</div>
			<div class="mb-3 col-sm-6">
			
				<label for="inputPassword"  class="col-sm-4 col-form-label ms-2 ">Reportes</label>

				<div v-if="userData.rol=='administrador'" class="d-flex flex-row justify-items-end mb-2">
					<select @change="getInvoices(1)" v-model="id_usuario" class="form-control ms-2 mx-3">
						<option value="-1" disabled>Seleccione un usuario</option>
						<option value="0">Todo</option>
						<option v-for="item in items_usuarios" :key="item.id" v-text="item.name" :value="item.id">Seleccione un usuario</option>

					</select>
				</div>
				
				<div class="d-flex flex-row justify-items-end">

					<button @click="reporteFacturacion()" class="btn btn-info text-white ms-2">
						<i class="fa-solid fa-file-pdf"></i>
						Pagos General
					</button>
					<button @click="reporteFacturacionTarjeta()" class="btn btn-info text-white ms-2">
						<i class="fa-solid fa-file-pdf"></i>
						Pagos - Tarjeta
					</button>
					<button @click="reporteFacturacionDeposito()" class="btn btn-info text-white ms-2">
						<i class="fa-solid fa-file-pdf"></i>
						Pagos - Deposito
					</button>
				</div>

			</div>
			
		</div>
		<div class="row">
			<p>Total Facturas Emitidas Bs.:<strong>{{totalFacturas.toFixed(2)}}</strong></p>
		</div>
		<div class="row">
			<p>Total Facturas Anuladas Bs.:<strong>{{totalFacturasAnuladas.toFixed(2)}}</strong></p>
		</div>
			<div class="form-group mb-2">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Buscar factura..." v-model="keyword" v-on:keyup="search()"/>
					<select class="form-select" v-model="branch_code">
						<option value="-1">-- sucursal --</option>
						<option value="0">Sucursal Principal (0)</option>
						<option v-bind:value="b.code" v-for="b in branches">{{ b.name }}</option>
					</select>
					<div class="input-group-btn">
						<button type="button" class="btn btn-info text-white" v-on:click="search()"><i class="fa fa-search"></i></button>
					</div>
				</div>
			</div>
			<template v-if="items.length==0">
				<p class="text-info"><i>No existen facturas en este criterio de búsqueda</i></p>
			</template>
			<pager v-if="total_pages > 1" 
				v-bind:currentPage="current_page" 
				v-bind:totalPages="total_pages" 
				v-on:pager-change-page="changePage" 
				v-on:pager-previous-page="prevPage"
				v-on:pager-next-page="nextPage" />
			<div class="panel card border shadow" v-for="(invoice, index) in items" style="font-size:0.8rem;">
				<div class="card-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12 col-sm-7">
								<div class="mb-1">
									<span class="border rounded p-1 bg-info text-white">ID: {{ invoice.id }}</span>
									<span class="border rounded p-1 bg-info text-white">Factura Nro: {{ invoice.invoice_number }}</span>
									<span class="border rounded p-1 bg-secondary text-white" v-if="invoice.invoice_number_cafc">Nro. CAFC: {{ invoice.invoice_number_cafc }}</span>
									<span class="border rounded p-1 bg-warning btn-warning text-white" v-if="invoice.event_id">
										<b>Evento:</b> {{ invoice.event_id }}
									</span>
								</div>
								<div><b>Cliente:</b> {{ invoice.customer }}</div>
								<div>
									<b>Sucursal:</b> {{ invoice.codigo_sucursal }}
									|
									<b>Punto Venta:</b> {{ invoice.codigo_puntoventa }}
								</div>
								<div><b>Fecha emision:</b> {{ invoice.invoice_datetime }}</div>
								<div><b>CUF:</b> {{ invoice.cuf }}</div>
								<div><b>PLACA:</b> {{ invoice.imei }}</div>
								<div>
									<span class="label text-white p-1 rounded" 
										v-bind:class="{'label-success bg-success': invoice.status == 'ISSUED', 'label-warning bg-warning': invoice.status == 'ERROR', 'label-danger bg-danger': invoice.status == 'VOID'}">
										{{ getStatus(invoice.status) }}
									</span>
								</div>
							</div>
							<div class="col-12 col-sm-3">
								<div><b>Sector:</b> {{ invoice.codigo_documento_sector }}</div>
								<div><b>Impuesto:</b> {{ invoice.tax.toFixed(2) }}</div>
								<div><b>Total:</b> {{ invoice.total.toFixed(2) }}</div>
							</div>
							<div class="col-12 col-sm-2">
								<a v-bind:href="viewUrl(invoice)" target="_blank" class="btn btn-sm btn-warning text-white w-100 mb-1 btn-block">Imprimir</a>
								<a v-bind:href="viewUrl(invoice) + '?tpl=rollo'" target="_blank" class="btn btn-sm btn-warning text-white w-100 mb-1 btn-block">Imprimir Ticket</a>
								<template v-if="invoice.siat_id && invoice.siat_url">
									<a v-bind:href="invoice.siat_url" target="_blank" class="btn btn-sm btn-info text-white w-100 mb-1 btn-block">Siat Url</a>
								</template>
								<!--
								<a href="javascript:;" class="btn btn-sm btn-primary w-100 mb-1">Editar</a>
								-->
								<template v-if="invoice.status == 'ISSUED' && userData.rol=='administrador'">
									<a href="javascript:;" class="btn btn-sm btn-danger text-white w-100 mb-1 btn-block" v-on:click="anular(invoice, index)">Anular</a>
								</template>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mt-2 mb-2">
				<pager v-if="total_pages > 1" 
					v-bind:currentPage="current_page" 
					v-bind:totalPages="total_pages" 
					v-on:pager-change-page="changePage" 
					v-on:pager-previous-page="prevPage"
					v-on:pager-next-page="nextPage" />
			</div>
			<div ref="modalvoid" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Anular Factura</h5>
						</div>
						<div class="modal-body">
							<template v-if="currentInvoice">
								<siat-void-invoice ref="comvoid" v-bind:invoice="currentInvoice"
									v-on:void-success="onVoidSuccess" />
							</template>
						</div>
						<div class="modal-footer">
							<template v-if="!processingVoid">
								<button type="button" class="btn btn-danger" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-primary" v-on:click="submit($event)">Anular Factura</button>
							</template>
							<template v-else>
								<span class="spinner-border text-info" role="status">
								  <span class="visually-hidden">Loading...</span>
								</span>
								Procesando...
							</template>
						</div>
					</div>
				</div>
			</div>
		</div>`,
		
		components: {
			'pager': SBFramework.Components.ComPager,
			'siat-void-invoice': ns.VoidInvoice,
		},
		mixins: [SBFramework.Mixins.Common],
		data()
		{
			return {
				userData: window.userData,
				id_usuario:0,
				keyword: '',
				branch_code: '-1',
				branches: [],
				total_pages: 0,
				current_page: 0,
				statuses: {
					'ISSUED': 'Emitida',
					'ERROR': 'Error',
					'VOID': 'Anulada',
				},
				currentInvoice: null,
				items: [],
				itemsTodos: [],
				items_usuarios:[],
				modalVoid: null,
				processingVoid: false,
				service: new SBFramework.Services.ServiceInvoices(),
				fecha_inicio_string:'',
				fecha_fin_string:'',

				fecha_inicio:new Date(),
				fecha_fin:new Date(),
				total_monto_facturas:0,
			};	
		},
		computed: {
			totalFacturas() {// Emitidas
				if(this.keyword==''){
					return this.itemsTodos.reduce((accumulator, item) => {
						if (item.status=='ISSUED') {
						  return accumulator + item.total;
						} else {
						  return accumulator;
						}
					  }, 0);
				}else{
					return this.items.reduce((accumulator, item) => {
						if (item.status=='ISSUED') {
						  return accumulator + item.total;
						} else {
						  return accumulator;
						}
					  }, 0);
				}
			},
			/*totalFacturasAnuladas() {// Anuladas
				return this.items.reduce((accumulator, items) => accumulator + items.total, 0);
			}*/
			totalFacturasAnuladas() {
				if(this.keyword==''){
					return this.itemsTodos.reduce((accumulator, item) => {
					  if (item.status=='VOID') {
						return accumulator + item.total;
					  } else {
						return accumulator;
					  }
					}, 0);

				}else{
					return this.items.reduce((accumulator, item) => {
						if (item.status=='VOID') {
						  return accumulator + item.total;
						} else {
						  return accumulator;
						}
					  }, 0);
				}
			}
		},
		methods:
		{
			viewUrl(invoice)
			{
				return lt.baseurl + '/siat/facturas/'+ invoice.id  +'/view';
			},
			async searchUsuario(){
				let url="/usuarios/buscar";
				let me= this;
				let buscar='';
				await axios.get(url+"?buscar="+buscar).then(function(response){
					me.items_usuarios=response.data;
				})
				.catch(function (error){
					console.log(error);
				})
			},
			getUsuarioActual(){

			},
			reporteFacturacion(){
				Swal.fire({
					title:'Generando..........',
					showConfirmButton:false,
					// onBeforeOpen () {
					// 	Swal.showLoading ()
					// },
				});
				axios.get('/invoices/siat/v2/reporte_facturacion?fecha_inicio='+this.fecha_inicio_string+'&fecha_fin=' + this.fecha_fin_string+'&id_usuario=' + this.id_usuario, {responseType: 'blob'})
				.then(response => {
					var blob = new Blob([response.data], {type: 'application/pdf'});
					var downloadUrl = URL.createObjectURL(blob);
					window.open(downloadUrl, '_blank');
				})
				.catch(error => {
					//this.errorReport();
					console.log(error);
				})
				.finally(function(){
					Swal.close();
				})
			},
			reporteFacturacionTarjeta(){
				Swal.fire({
					title:'Generando..........',
					showConfirmButton:false,
					// onBeforeOpen () {
					// 	Swal.showLoading ()
					// },
				});
				axios.get('/invoices/siat/v2/reporte_facturacion_tarjeta?fecha_inicio='+this.fecha_inicio_string+'&fecha_fin=' + this.fecha_fin_string+'&id_usuario=' + this.id_usuario,{responseType: 'blob'})
				.then(response => {
					var blob = new Blob([response.data], {type: 'application/pdf'});
					var downloadUrl = URL.createObjectURL(blob);
					window.open(downloadUrl, '_blank');
				})
				.catch(error => {
					//this.errorReport();
					console.log(error);
				})
				.finally(function(){
					Swal.close();
				})
			},
			reporteFacturacionDeposito(){
				Swal.fire({
					title:'Generando..........',
					showConfirmButton:false,
					// onBeforeOpen () {
					// 	Swal.showLoading ()
					// },
				});
				axios.get('/invoices/siat/v2/reporte_facturacion_deposito?fecha_inicio='+this.fecha_inicio_string+'&fecha_fin=' + this.fecha_fin_string+'&id_usuario=' + this.id_usuario,{responseType: 'blob'})
				.then(response => {
					var blob = new Blob([response.data], {type: 'application/pdf'});
					var downloadUrl = URL.createObjectURL(blob);
					window.open(downloadUrl, '_blank');
				})
				.catch(error => {
					//this.errorReport();
					console.log(error);
				})
				.finally(function(){
					Swal.close();
				})
			},
			fechaInicioParaString(){
				this.fecha_inicio=new Date(this.fecha_inicio_string);
			},
			fechaFinParaString(){
				this.fecha_fin=new Date(this.fecha_fin_string);
			},
			changePage(page)
			{
				this.getInvoices(page);
				
			},
			
			prevPage(page)
			{
				this.getInvoices(page);
			},
			nextPage(page)
			{
				this.getInvoices(page);
			},
			async getInvoices(page)
			{
				const res = await this.service.obtenerFacturas(page, this.fecha_inicio_string, this.fecha_fin_string, this.id_usuario);
				this.items = res.data;
				this.itemsTodos = res.data2;
				this.current_page = page;
				this.total_pages = parseInt(res.headers.get("total-pages"));
				console.log(res.data);
				console.log(res.data2);
			},
			async getBranches()
			{
				const res = await this.service.obtenerSucursales();
				this.branches = res.data;
			},
			getStatus(status)
			{
				return this.statuses[status] || 'Desconocido';
			},
			anular(invoice, index)
			{
				this.currentInvoice = invoice;
				this.openModal(this.modalVoid);
			},
			async submit($event)
			{
				try
				{
					this.processingVoid = true;
					await this.$refs.comvoid.submit();
					this.processingVoid = false;
				}
				catch(e)
				{
					this.processingVoid = false;
				}
			},
			onVoidSuccess(xhr_res)
			{
				this.closeModal(this.modalVoid);
				this.currentInvoice = null;
				let invoice = this.items.find((inv) => inv.invoice_id == xhr_res.data.invoice_id );
				if( !invoice )
					return false;
				invoice = xhr_res.data;
				this.$root.$toast.ShowSuccess('La factura fue anulada correctamente');
				this.getInvoices();
			},
			async search()
			{
				
				try
				{
					if(this.keyword==''){
						this.getInvoices(1);
					}else{
						const res = await this.service.buscar(this.keyword, this.branch_code, this.fecha_inicio_string, this.fecha_fin_string, this.id_usuario);
						this.items = res.data;
						this.current_page 	= 1;
						this.total_pages	= 1;
					}
					
				}
				catch(e)
				{
					alert(e.error || e.message || 'Error desconocido');
				}
			}
		},
		async mounted()
		{
			const frame = (window.bootstrap || window.coreui);
			if( frame )
			{
				this.modalVoid = frame.Modal.getOrCreateInstance(this.$refs.modalvoid);
			}
			else
			{
				this.modalVoid = jQuery(this.$refs.modalvoid);
			}
			
			// this.id_usuario=(this.userData.rol!='administrador')? this.userData.id:0;
			this.id_usuario=this.userData.id;

			this.$root.$processing.show('Obteniendo datos...');
			await Promise.all([this.getInvoices(1), this.getBranches()]);
			this.$root.$processing.hide();

			const fecha = new Date();
			const year = fecha.getFullYear();
			const month = (fecha.getMonth() + 1).toString().padStart(2, '0');
			const day = fecha.getDate().toString().padStart(2, '0');
			this.fecha_inicio_string = `${year}-${month}-${day}`;
			this.fecha_fin_string = `${year}-${month}-${day}`;
			this.fecha_inicio=new Date(this.fecha_inicio_string);
			this.fecha_fin=new Date(this.fecha_fin_string);

		},
		async created()
		{
			
			this.searchUsuario();

		}
	};
	SBFramework.AppComponents = {
		'siat-invoice-listing': ns.InvoiceListing, 
	};
})(SBFramework.Components.Siat);