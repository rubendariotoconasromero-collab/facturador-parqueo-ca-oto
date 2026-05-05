(function(ns)
{
	ns.InvoiceProducts = {
		template: `<div id="invoice-products-com" class="">
			
			<div class="card-header text-start text-white mb-3">
				<div class="col-6 col-sm-3"><button type="button" class="btn btn-info text-white" v-on:click="newProd()">Nuevo Producto</button></div>
			</div>
			<div class="form-group mb-2">
				<div class="input-group">
					<input v-on:keyup="search()" type="text" class="form-control" placeholder="Buscar producto..." v-model="keyword" v-on:keyup.enter="search()" />
					<div class="input-group-btn">
						<button type="button" class="btn btn-info text-white" v-on:click="search()"><i class="fa fa-search"></i></button>
					</div>
				</div>
			</div>
			<div class="mb-1">Total productos: {{ total_productos }}</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover" style='width:96%;margin-left: 2%;font-size: 0.7rem'>
					<thead style="background-color: #46546c">
						<tr>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Codigo</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Codigo SIN</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Nombre</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Precio</th>

							<th scope="col" class="text-white" style='font-size: 0.7rem'>Opciones</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(prod, pi) in products">
							<td style='font-size: 0.7rem'>{{prod.code }}</td>
							<td style='font-size: 0.7rem'>{{ prod.codigo_sin }}</td>
							<td style='font-size: 0.7rem'>{{prod.name}}</td>
							<td style='font-size: 0.7rem'>{{prod.price}}</td>

							<td style='font-size: 0.7rem'>
								<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
									aria-expanded="false" style='font-size: 0.7rem'>Accion</button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li><a class="dropdown-item" href="#"  v-on:click="eliminar(prod, pi)"><i
												class="fa fa-unlock text-danger"></i> Eliminar</a></li>
									<li><a class="dropdown-item" href="#" v-on:click="edit(prod, pi)"><i
												class="fa fa-pencil text-success"></i> Editar</a></li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<pager v-if="total_pages > 1" 
				v-bind:currentPage="current_page" 
				v-bind:totalPages="total_pages" 
				v-on:pager-change-page="changePage" 
				v-on:pager-previous-page="prevPage"
				v-on:pager-next-page="nextPage" />
			<div ref="modalprod" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header bg-info text-white">
						<h5>Información del Producto</h5>
						<button class="btn-close" type="button" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<template v-if="product">
								<invoice-product-form v-bind:product="product" 
									v-bind:productosSin="productosSin" 
									v-bind:unidadesMedida="unidadesMedida"
									v-bind:actividades="lista_actividades"
									v-on:product-saved="productSaved" />
							</template>
						</div>
					</div>
				</div>
			</div>
		</div>`,
		components: {
			'pager': SBFramework.Components.ComPager,
			'invoice-product-form': ns.ProductForm,
		},
		data()
		{
			return {
				keyword: '',
				total_productos: 0,
				total_pages: 0,
				current_page: 0,
				lista_actividades: [],
				unidadesMedida: [],
				productosSin: [],
				products: [],
				product: null,
				modalForm: null,
				serviceInvoices: new SBFramework.Services.ServiceInvoices(),
				service: new SBFramework.Services.ServiceProducts()
			};
		},
		methods: 
		{
			changePage(page)
			{
				this.getProducts(page);
			},
			prevPage(page)
			{
				this.getProducts(page);
			},
			nextPage(page)
			{
				this.getProducts(page);
			},
			async getUnidadesMedida()
			{
				const res = await this.serviceInvoices.obtenerUnidadesMedida();
				this.unidadesMedida = res.data.RespuestaListaParametricas.listaCodigos;	
			},
			async getProductosSin()
			{
				const res = await this.serviceInvoices.obtenerProductosServicios();
				this.productosSin = res.data.RespuestaListaProductos.listaCodigos;
			},
			async getListaActividades()
			{
				const res = await this.serviceInvoices.obtenerActividades();
				this.lista_actividades = Array.isArray(res.data.RespuestaListaActividades.listaActividades) ?
					res.data.RespuestaListaActividades.listaActividades : [res.data.RespuestaListaActividades.listaActividades];
			},
			async getProducts(page)
			{
				page = page || 1;
				const res = await this.service.readAll(page);
				this.products = res.data;
				this.current_page = page;
				this.total_pages = parseInt(res.headers.get("total-pages"));
				this.total_productos = res.total_products;
			},
			openProductModal()
			{
				if( this.modalForm.modal )
				{
					this.modalForm.modal('show');
					return true;
				}
				this.modalForm.show();			
			},
			closeProductModal()
			{
				if( this.modalForm.hide )
				{
					this.modalForm.modal('hide');
					return true;
				}
				this.modalForm.hide();
			},
			newProd()
			{
				this.product = {codigo_actividad: '',codigo_sin: '', unidad_medida: ''};
				this.openProductModal();
			},
			productSaved()
			{
				this.product = null;
				//this.modalForm.hide();
				this.closeProductModal();
				this.getProducts();
			},
			edit(prod, index)
			{
				this.product = prod;
				//this.modalForm.show();
				this.openProductModal();
			},
			eliminar(prod, index){
				Swal.fire({
					title: '¿Estás seguro?',
					text: 'Esta acción no se puede deshacer',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Sí, estoy seguro',
					cancelButtonText: 'Cancelar'
				  }).then((result) => {
					if (result.isConfirmed) {
					  // Aquí se ejecuta la acción si el usuario confirma
					  this.remove(prod, index);
					  
					}
				  })
			},
			async remove(prod, index)
			{
				// if( !confirm('Esta seguro de borrar el producto?\nLa accion no se puede deshacer.') )
				// 	return false;
				try
				{
					this.$root.$processing.show('Guardando producto...');
					const res = await this.service.remove(prod.id);
					//this.products.splice(index, 1);
					this.getProducts(this.current_page);
					this.$root.$processing.hide();
					//this.$root.$toast.ShowSuccess('Producto borrado!!!');
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Operación exitosa...',
						showConfirmButton: false,
						timer: 1500
					}); 
				}
				catch(e)
				{
					this.$root.$processing.hide();
					console.log(e);
					this.$root.$toast.ShowError(e.error || e.message || 'Ocurrio un error al crear el producto');
				}
			},
			async search()
			{
				try
				{
					this.products 		= [];
					const res 			= await this.service.search(this.keyword);
					this.products 		= res.data;
					//this.current_page 	= page;
					this.total_pages 	= parseInt(res.headers.get("total-pages"));
					this.total_productos = res.total_products;
				}	
				catch(e)
				{
					console.log('ERROR', e);
					this.$root.$toast.ShowError(e.error || e.message || 'Ocurrio un error al crear el producto');
				}
			}
		},
		mounted()
		{
			const frame = (window.bootstrap || window.coreui);
			if( frame )
			{
				this.modalForm = new frame.Modal(this.$refs.modalprod);
			}
			else
			{
				this.modalForm = jQuery(this.$refs.modalprod);
			}
			this.$refs.modalprod.addEventListener('hidden.coreui.modal', (event) => {
				this.product = null;
			});

		},
		created()
		{
			this.getListaActividades();
			this.getUnidadesMedida();
			this.getProductosSin();
			this.getProducts();
		}
	};
	SBFramework.AppComponents = {
		'siat-products-list': ns.InvoiceProducts, 
	};
})(SBFramework.Components);
