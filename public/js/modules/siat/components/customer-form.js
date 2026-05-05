(function(ns)
{
	ns.ComCustomerForm = {
		template: `<div id="com-customer-form">
			<div ref="modalcustomer" class="modal fade">
				<form ref="formcustomer" novalidate>
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-info text-white">
							<h5 class="modal-title">Ingrese datos</h5>
							<button class="btn-close" type="button" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal" aria-label="Close"></button>
							</div>
							
							<div class="modal-body">
								<!--<div class="mb-3">
									<label>Nombres</label>
									<input type="text" class="form-control" v-model="customer.firstname" />
									<div class="invalid-feedback">Ingrese el nombre del cliente</div>
								</div>-->
								<div class="mb-3">
									<label>Nombres/Razon Social</label>
									<input type="text" class="form-control" v-model="customer.lastname" required />
									<div class="invalid-feedback">Ingrese Nombres o Razón social </div>
								</div>
								<div class="mb-3">
									<label>NIT/CI</label>
									<input type="text" class="form-control" v-model="customer.nit_ruc_nif" required />
									<div class="invalid-feedback">Ingrese el NIT/CI del cliente</div>
								</div>
								<div class="mb-3">
									<div class="mb-1">
										<label>Tipo de Documento de Identidad</label>
										<select class="form-control form-select" v-model="customer.identity_document" required>
											<option value="">-- tipo de documento --</option>
											<option v-bind:value="tc.codigoClasificador" v-for="(tc, itc) in tipos_documentos">
												{{ tc.descripcion }}
											</option>
										</select>
										<div class="invalid-feedback">Debe seleccionar el tipo de documento</div>
									</div>
								</div>
								<div class="mb-3">
									<label>Direccion/Telefono</label>
									<input type="text" class="form-control" v-model="customer.address" />
									<div class="invalid-feedback">Ingrese la direccion del cliente</div>
								</div>
								<div class="mb-3">
									<label>Email</label>
									<input type="email" class="form-control" v-model="customer.email" />
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger text-white" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal">Cancelar</button>
								<button type="button" class="btn btn-info text-white" v-on:click="guardarCliente()">Guardar</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>`,
		props: 
		{
			//edit_customer: {type: Object, required: false}
		},
		data()
		{
			return {
				customer: {},
				modal: null,
				invoice: new SBFramework.Models.Invoice(),
				serviceCustomers: new SBFramework.Services.ServiceCustomers(),
				service: new SBFramework.Services.ServiceInvoices(),
				tipos_documentos: [],
			};
		},
		
		methods: 
		{
			resetCustomer()
			{
				this.customer = {
					id: 0,
					firstname: '',
					lastname: '',
					address: '',
					email: '',
					nit_ruc_nif: '',
					identity_document:0,
				};	
			},
			async getTiposDocumentosIdentidad()
			{
				const res = await this.service.obtenerDocumentosIdentidad();
				this.tipos_documentos = res.data.RespuestaListaParametricas.listaCodigos;	
			},
			showModal()
			{
				if( this.modalCustomer.modal )
				{
					this.modalCustomer.modal('show');
					return true;
				}
				this.modalCustomer.show();
			},
			closeModal()
			{
				if( this.modalCustomer.modal )
				{
					this.modalCustomer.modal('hide');
					return true;
				}
				this.modalCustomer.hide();
			},
			setCustomer(obj)
			{
				Object.assign(this.customer, obj);
			},
			async guardarCliente()
			{
				this.$refs.formcustomer.classList.remove('was-validated')
				try
				{
					if( !this.$refs.formcustomer.checkValidity() )
					{
						this.$refs.formcustomer.classList.add('was-validated')
						return false;
					}
					this.$root.$processing.show('Creando cliente...');
					if( !this.customer.company )
						this.customer.company = this.customer.last_name;
					const action = this.customer.id ? 'update' : 'create';
					const res = this.customer.id > 0 ?
						await this.serviceCustomers.update(this.customer) :
						await this.serviceCustomers.create(this.customer);
					
					this.$root.$processing.hide();
					this.closeModal();
					this.$emit('customer-saved', {
						action: action,
						customer: Object.assign({}, this.customer)
					});
					this.resetCustomer();
				}
				catch(e)
				{
					this.$root.$processing.hide();
					alert(e.error || e.message || 'Ocurrio un error al crear el cliente');
				}
			},
		},
		mounted()
		{
			const frame = (window.bootstrap || window.coreui);
			if( frame )
			{
				this.modalCustomer = frame.Modal.getOrCreateInstance(this.$refs.modalcustomer);
			}
			else
			{
				this.modalCustomer	= jQuery(this.$refs.modalcustomer);
			}
		},
		created()
		{
		    this.getTiposDocumentosIdentidad(),
			this.resetCustomer();
			console.log(this.edit_customer);
		}
	};
})(SBFramework.Components.Siat);
