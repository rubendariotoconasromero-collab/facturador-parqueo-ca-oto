(function(ns)
{
	ns.ComBranches = {
		template: `<div id="com-siat-branches">
			<div class="card-header text-start text-white mb-3">
				<button class="btn btn-info text-white" v-on:click="nuevo()">Nuevo</button>
			</div>
			<template v-if="items.length > 0">
			<div class="table-responsive">
				<table class="table table-striped table-hover" style='width:96%;margin-left: 2%;font-size: 0.7rem'>
					<thead style="background-color: #46546c">
						<tr>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Código</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Nombre</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Dirección</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Ciudad</th>
							<th scope="col" class="text-white" style='font-size: 0.7rem'>Opciones</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item, index) in items">
							<td style='font-size: 0.7rem'>{{item.code}}</td>
							<td style='font-size: 0.7rem'>{{item.name}}</td>
							<td style='font-size: 0.7rem'>{{item.address}}</td>
							<td style='font-size: 0.7rem'>{{item.city}}</td>
							<td style='font-size: 0.7rem'>
								<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
									aria-expanded="false" style='font-size: 0.7rem'>Accion</button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li><a class="dropdown-item" href="#" v-on:click="eliminar(item, index)"><i
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
					<form action="" method="" class="modal-content" ref="form">
						<div class="modal-header bg-info text-white">
							<h5 class="modal-title">Nueva Sucursal</h5>
							<button class="btn-close" type="button" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="mb-3">
								<label>Codigo</label>
								<input type="number" class="form-control" required v-model="s.code" />
							</div>
							<div class="mb-3">
								<label>Nombre Sucursal</label>
								<input type="text" class="form-control" required v-model="s.name">
							</div>
							<div class="mb-3">
								<label>Direccion</label>
								<input type="text" class="form-control" required v-model="s.address">
							</div>
							<div class="mb-3">
								<label>Ciudad</label>
								<input type="text" class="form-control" required v-model="s.city">
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
				items: [],
				s: {
					id: 0,
					code: '',
					name: '',
					address: '',
					city: '',
				},
				service: new SBFramework.Services.ServiceBranches(),
			};
		},
		methods: 
		{
			async getItems()
			{
				const res = await this.service.readAll();
				this.items = res.data;
			},
			nuevo()
			{
				this.openModal(this.modal);
			},
			async guardar()
			{
				try
				{
					if( isNaN(parseInt(this.s.code)) || parseInt(this.s.code) <= 0 )
						throw {error: 'El codigo de sucursal es invalido'};
					this.$root.$processing.show('Guardando datos...');
					const res = this.s.id > 0 ?
						await this.service.update(this.s) :
						await this.service.create(this.s);
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
					this.$refs.form.reset();
				}	
				catch(e)
				{
					this.$root.$processing.hide();
					console.log('ERROR', e);
					this.$root.$toast.ShowError(e.error || e.message || 'Error desconocido');
				}
			},
			eliminar(item, index){
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
					  this.borrar(item, index)
					  
					}
				  })
			},
			async borrar(item, index)
			{
				try
				{
					this.$root.$processing.show('Borrando datos...');
					await this.service.remove( item.id );
					this.$root.$processing.hide();
					this.items.splice(index, 1);
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Acción conpletada...',
						showConfirmButton: false,
						timer: 1500
					})
					//this.$root.$toast.ShowSuccess('Sucursal borrada');
				}
				catch(e)
				{
					console.log('ERROR', e);
					this.$root.$processing.hide();
					this.$root.$toast.ShowError('Ocurrio un error al borrar la sucursal');
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
			this.getItems();
		}
	};
	SBFramework.AppComponents = {
		'siat-branches': ns.ComBranches, 
	};
})(SBFramework.Components.Siat);