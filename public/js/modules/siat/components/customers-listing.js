(function(ns)
{
	ns.ComCustomersListing = {
		template: `<div id="mod-customers-listing">
			
			<div class="card-header text-start text-white mb-3">
				<button type="button" class="btn btn-info text-white" v-on:click="newCustomer()">Nuevo Cliente</button>
			</div>
			<div class="form-group mb-2">
				<input type="text" class="form-control" placeholder="Buscar..." v-on:keyup="search()" v-model="keyword" v-on:keyup.enter="search()" />
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover" style='width:96%;margin-left: 2%;font-size: 0.7rem'>
					<thead style="background-color: #46546c">
						<tr>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>NIT/RUC/NIF</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Nombre</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Email</th>

							<th scope="col" class="text-white" style='font-size: 0.7rem'>Opciones</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(customer, ci) in items">
							<td style='font-size: 0.7rem'>{{customer.nit_ruc_nif }}</td>
							<td style='font-size: 0.7rem'>{{ customer.firstname }} {{ customer.lastname }}</td>
							<td style='font-size: 0.7rem'>{{customer.email}}</td>

							<td style='font-size: 0.7rem'>
								<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
									aria-expanded="false" style='font-size: 0.7rem'>Accion</button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li><a class="dropdown-item" href="#" v-on:click="eliminar(customer, ci)"><i
												class="fa fa-unlock text-danger"></i> Eliminar</a></li>
									<li><a class="dropdown-item" href="#" v-on:click="edit(customer)"><i
												class="fa fa-pencil text-success"></i> Editar</a></li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="mt-2 mb-2">
				<pager v-if="total_pages > 1" 
					v-bind:currentPage="current_page" 
					v-bind:totalPages="total_pages" 
					v-on:pager-change-page="changePage" 
					v-on:pager-previous-page="prevPage"
					v-on:pager-next-page="nextPage" />
			</div>
			<siat-customer-form ref="customer_form" v-bind:edit_customer="customer" v-on:customer-saved="onCustomerSaved" />
		</div>`,
		components: 
		{
			'pager': SBFramework.Components.ComPager,
			'siat-customer-form': ns.ComCustomerForm,
		},
		data()
		{
			return {
				service: new SBFramework.Services.ServiceCustomers(),
				items: [],
				customer: {},
				keyword: '',
				// cambios paginador
				total_pages: 0,
				current_page: 0,
				//-------------------
			};	
		},
		methods: 
		{
			async getCustomers(page)
			{
				this.$root.$processing.show('Obteniendo datos...');
				const res	= await this.service.readAll(page);
				this.items 	= res.data;
				this.$root.$processing.hide();
				// cambios paginador
				this.current_page = page;
				this.total_pages = parseInt(res.headers.get("total-pages"));
				//-------------------------

			},
			changePage(page)
			{
				this.getCustomers(page);
			},
			prevPage(page)
			{
				this.getCustomers(page);
			},
			nextPage(page)
			{
				this.getCustomers(page);
			},
			newCustomer()
			{
				this.$refs.customer_form.showModal();
			},
			edit(customer)
			{
				this.customer = customer;
				this.$refs.customer_form.setCustomer(customer);
				this.$refs.customer_form.showModal();
			},
			onCustomerSaved(data)
			{
				//this.$root.$toast.ShowSuccess('Cliente guardado correctamente');
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Operación exitosa...',
					showConfirmButton: false,
					timer: 1500
				}); 
				console.log('customer_save', data);
				if( data.action == 'update' )
				{
					Object.assign(this.customer, data.customer);
					return true;
				}
				this.getCustomers(1);
			},
			eliminar(customer, index){
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
					  this.remove(customer, index);
					  
					}
				  })
			},
			async remove(customer, index)
			{
				try
				{
					this.$root.$processing.show('Borrando cliente...');
					const res = await this.service.remove(customer.id);
					this.$root.$processing.hide();
					//this.$root.$toast.ShowSuccess('Cliente borrado correctamente');
					//this.getCustomers();
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Operación exitosa...',
						showConfirmButton: false,
						timer: 1500
					}); 
					this.items.splice(index, 1);
				}
				catch(e)
				{
					this.$root.$processing.hide();
				}
			},
			async search()
			{
				if( this.keyword.trim().length <= 0 )
				{
					this.getCustomers(1);
					
					return false;	
				}	
					
				//this.$root.$processing.show('Buscando...');
				const res	= await this.service.search(this.keyword, 1);
				this.items 	= res.data;
				// cambios paginador
				this.current_page 	= 1;
				this.total_pages	= 1;
				//-------------------------
				this.$root.$processing.hide();
			}
		},
		mounted()
		{
			const frame = (window.bootstrap || window.coreui);
			if( frame )
			{
				
			}
			else
			{
			}
		},
		created()
		{
			this.getCustomers();
		}
	};
	SBFramework.AppComponents = {
		'siat-customers-listing': ns.ComCustomersListing, 
	};
})(SBFramework.Components.Siat);