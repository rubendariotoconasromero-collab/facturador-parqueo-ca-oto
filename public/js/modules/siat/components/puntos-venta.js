(function(ns)
{
	ns.ComPuntosVenta = {
		template: `<div id="com-siat-puntos-venta">
			
			<div class="card-header text-center text-white mb-3">
				<div class="col-sm-12 d-flex justify-content-start align-items-center">
					<button type="button" class="btn btn-info text-white" v-on:click="nuevo()">Nuevo</button>
					<button type="button" class="btn btn-warning text-white ms-3" v-on:click="sync()">Sincronizar</button>
				</div>
			</div>
			<template v-if="items.length > 0">
			<div class="table-responsive">
				<table class="table table-striped table-hover" style='width:96%;margin-left: 2%;font-size: 0.7rem'>
					<thead style="background-color: #46546c">
						<tr>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Código</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Tipo</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Nombre</th>
							
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Opciones</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item, index) in items">
							<td style='font-size: 0.7rem'>{{item.codigo}}</td>
							<td style='font-size: 0.7rem'>{{item.tipo}}</td>
							<td style='font-size: 0.7rem'>{{item.nombre}}</td>
					
							<td style='font-size: 0.7rem'>
								<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
									aria-expanded="false" style='font-size: 0.7rem'>Accion</button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li><a class="dropdown-item" href="#" v-on:click="borrar(item, index)"><i
												class="fa fa-unlock text-danger"></i> Eliminar</a></li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			</template>
			<div v-else>
				<i class="text-info">No se encontraron registros</i>
			</div>
			<div ref="modal" class="modal fade">
				<div class="modal-dialog">
					<form action="" method="" class="modal-content">
						<div class="modal-header bg-info text-white">
							<h5 class="modal-title">Nuevo Punto de Venta</h5>
							<button class="btn-close" type="button" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="mb-3">
								<label>Sucursal</label>
								<select class="form-control form-select" required v-model="pv.sucursal_id">
									<option value="">-- sucursal --</option>
									<option value="0">Sucursal Principal 0 (por defecto)</option>
									<option v-bind:value="s.code" v-for="(s, si) in sucursales">{{ s.name }}</option>
								</select>
							</div>
							<div class="mb-3">
								<label>Tipo Punto de Venta</label>
								<select class="form-control form-select" required v-model="pv.tipo_id">
									<option value="">-- tipo --</option>
									<template v-for="(tipo, ti) in tipos">
									<option v-bind:value="tipo.codigoClasificador">{{ tipo.descripcion }}</option>
									</template>
								</select>
							</div>
							<div class="mb-3">
								<label>Nombre Punto de Venta</label>
								<input type="text" name="" value="" class="form-control" required v-model="pv.nombre" />
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger text-white" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal">Cerrar</button>
							<button type="button" class="btn btn-info text-white" v-on:click="guardar()">Guardar</button>
						</div>
					</form>
				</div>
			</div>
		</div>`,
		mixins: [SBFramework.Mixins.Common],
		data()
		{
			return {
				modal: null,
				sucursales: [],
				items: [],
				tipos: [],
				pv: {
					sucursal_id: 0,
					tipo_id: '',
					tipo: '',
					nombre: ''
				},
				service: new SBFramework.Services.ServicePointOfSale(),
				serviceBranches: new SBFramework.Services.ServiceBranches(),
				serviceInvoices: new SBFramework.Services.ServiceInvoices(),
			};
		},
		methods: 
		{
			async getItems()
			{
				const res = await this.service.readAll();
				this.items = res.data;
			},
			async getSucursales()
			{
				const res = await this.serviceBranches.readAll();
				this.sucursales = res.data
			},
			async getTipos()
			{
				const res = await this.serviceInvoices.obtenerTiposPuntoVenta();
				this.tipos = res.data.RespuestaListaParametricas.listaCodigos;	
			},
			nuevo()
			{
				this.getTipos();
				this.openModal(this.modal);
			},
			async guardar()
			{
				try
				{
					this.$root.$processing.show('Guardando datos...');
					for(let t of this.tipos)
					{
						if( t.codigoClasificador == this.pv.tipo_id )
						{
							this.pv.tipo = t.descripcion;
							break;
						}
					}
					const res = this.pv.id > 0 ?
						await this.service.update(this.pv) :
						await this.service.create(this.pv);
					this.$root.$processing.hide();
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Operación exitosa...',
						showConfirmButton: false,
						timer: 1500
					}); 
					this.closeModal(this.modal);
					this.getItems();
				}	
				catch(e)
				{
					this.$root.$processing.hide();
					console.log('ERROR', e);
					this.$root.$toast.ShowError(e.error || e.message || 'Error desconocido');
				}
			},
			async sync()
			{
				try
				{
					this.$root.$processing.show('Sincronizando datos...');
					await this.service.sync();
					this.$root.$processing.hide();
					this.getItems();
				}
				catch(e)
				{
					this.$root.$processing.hide();
					console.log('ERROR', e);
				}
			},
			async borrar(item, index)
			{
				try
				{
					if( !confirm('Esta seguro de borrar el punto de venta') )
						return false;
						
					this.$root.$processing.show('Borrando datos...');
					await this.service.remove(item.id );
					this.$root.$processing.hide();
					this.items.splice(index, 1);
					this.$root.$toast.ShowSuccess('Punto de Venta borrado');
				}
				catch(e)
				{
					this.$root.$processing.hide();
					console.log('ERROR', e);
					this.$root.$toast.ShowError('Ocurrio un error al borrar el Punto de Venta');
				}
			}
		},
		mounted()
		{
			const frame = (window.bootstrap || window.coreui);
			if( frame )
			{
				this.modal = frame.Modal.getOrCreateInstance(this.$refs.modal);
			}
			else
			{
				this.modal = jQuery(this.$refs.modal);
			}
		},
		created()
		{
			this.getSucursales();
			this.getItems();
		}
	};
	SBFramework.AppComponents = {
		'siat-puntos-venta': ns.ComPuntosVenta, 
	};
})(SBFramework.Components.Siat);