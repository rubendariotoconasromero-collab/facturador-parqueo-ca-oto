
(function(ns)
{
	ns.Usuarios = {
		template: `
		<div>
		<div id="mod-customers-listing">
			
		<div class="card-header text-start text-white mb-3">
			<button type="button" class="btn btn-info text-white" v-on:click="newUsuario()">Nuevo usuario</button>
		</div>
		<div class="form-group mb-2">
			<input type="text" class="form-control" placeholder="Buscar..." @input="search()" v-model="buscar" />
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover" style='width:96%;margin-left: 2%;font-size: 0.7rem'>
				<thead style="background-color: #46546c">
					<tr>
						<th scope="col" class="text-white" style='font-size: 0.7rem'>Codigo Sistema</th>
						<th scope="col" class="text-white" style='font-size: 0.7rem'>Nombre</th>
						<th scope="col" class="text-white" style='font-size: 0.7rem'>Email</th>
						<th scope="col" class="text-white" style='font-size: 0.7rem'>Rol</th>
						<th scope="col" class="text-white" style='font-size: 0.7rem'>Estado</th>
						<th scope="col" class="text-white" style='font-size: 0.7rem'>Opciones</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="usuario.name!='administrador' && usuario.name!='Administrador'" v-for="(usuario, codigo_sistema) in items">
						<td style='font-size: 0.7rem'>{{usuario.codigo_sistema }}</td>
						<td style='font-size: 0.7rem'>{{ usuario.name }}</td>
						<td style='font-size: 0.7rem'>{{usuario.email}}</td>
						<td style='font-size: 0.7rem'>{{usuario.rol}}</td>
						<td style='font-size: 0.7rem'>
						<span v-if="usuario.estado==1" class="badge bg-success">Activo</span>
						<span v-else-if="usuario.estado==0" class="badge bg-danger">Inactivo</span>
						</td>

						<td style='font-size: 0.7rem'>
							<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
								aria-expanded="false" style='font-size: 0.7rem'>Accion</button>
							<ul class="dropdown-menu dropdown-menu-end">
						
								<li><a class="dropdown-item" href="#" v-on:click="edit(usuario)"><i
											class="fa fa-pencil text-success"></i> Editar</a></li>
								<li v-if="usuario.estado==1"><a class="dropdown-item" href="#" v-on:click="desactivar(usuario.id)"><i
											class="fa fa-times text-danger"></i> Desactivar</a></li>
								<li v-if="usuario.estado==0"><a class="dropdown-item" href="#" v-on:click="activar(usuario.id)"><i
											class="fa fa-check text-success"></i> Activar</a></li>
							</ul>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!--<div class="mt-2 mb-2">
			<pager v-if="total_pages > 1" 
				v-bind:currentPage="current_page" 
				v-bind:totalPages="total_pages" 
				v-on:pager-change-page="changePage" 
				v-on:pager-previous-page="prevPage"
				v-on:pager-next-page="nextPage" />
		</div>-->
	</div>
	<div class="modal fade" id="modalNuevo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form>
		<div class="modal-content">
			<div class="modal-header bg-info text-white">
				<h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
				<button @click="cerrarNuevo()" type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close">
					<!--<span aria-hidden="true">&times;</span>-->
				</button>
			</div>
			<div class="modal-body">
					<div class="form-group mb-2">
						<label for="codigo">Código</label>
						<input type="number" class="form-control" id="codigo" v-model="usuario.codigo_sistema"  step="1" oninput="this.value = Math.round(this.value)" required>
					</div>
					<div class="form-group mb-2">
						<label for="nombre">Nombre</label>
						<input type="text" class="form-control" id="nombre" v-model="usuario.nombre" required>
						</div>
					<div class="form-group mb-2">
						<label for="nombre">Contraseña</label>
						<input type="password" class="form-control" id="password" v-model="usuario.password" required>
					</div>
					<div class="form-group mb-2">
						<label for="correo">Correo Electrónico</label>
						<input type="email" class="form-control" id="correo" v-model="usuario.correo" required>
				    </div>
					<div class="form-group mb-2">
						<label for="rol">Rol</label>
						<select class="form-control" id="rol" v-model="usuario.rol" required>
							<option value="" selected="selected" disabled>Seleccione un rol</option>
							<option value="administrador">Administrador</option>
							<option value="cajero">Cajero</option>
						</select>
					</div>
			</div>
			<div class="modal-footer">
				<button @click="cerrarNuevo()" type="button" class="btn btn-danger text-white" data-dismiss="modal">Cerrar</button>
				<button v-if="usuario.accion==0" type="button" class="btn btn-info text-white" @click="guardarUsuario()">Guardar</button>
				<button v-else-if="usuario.accion!=0" type="button" class="btn btn-info text-white" @click="modificarUsuario()">Modificar</button>
			</div>
		</div>
		</form>
	</div>
</div>
	</div>`,

	
		data()
		{
			return {
			
				items: [],
				customer: {},
				buscar: '',
				// cambios paginador
				total_pages: 0,
				current_page: 0,
				usuario:{
					id_usuario:0,
					accion:0,
					nombre:'',
					codigo_sistema:0,
					correo:'',
					rol:'',			
					password:'',			
				}
					
			
			};
		},
		methods: 
		{
			newUsuario(){
				this.resetUsuario();
				$("#modalNuevo").modal('show');
			},
			cerrarNuevo(){
				$("#modalNuevo").modal('hide');
			},
			async guardarUsuario(){
				if(this.usuario.codigo_sistema==0 || this.usuario.codigo_sistema===undefined){
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Error!',
						text:'Debe ingresar un codigo para el usuario',
						showConfirmButton: true,
						
					}); 
				}else{
					if(this.usuario.nombre=='' || this.usuario.nombre===undefined){
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Error!',
							text:'Debe ingresar un nombre para el usuario',
							showConfirmButton: true,
							
						});
					}else{
						if(this.usuario.password=='' || this.usuario.password===undefined){
							Swal.fire({
								position: 'center',
								icon: 'error',
								title: 'Error!',
								text:'Debe ingresar una contraseña para el usuario',
								showConfirmButton: true,
								
							});
						}else{
							if(this.usuario.rol=='' || this.usuario.nombre===undefined){
								Swal.fire({
									position: 'center',
									icon: 'error',
									title: 'Error!',
									text:'Debe seleccionar un rol',
									showConfirmButton: true,
									
								});
							}else{
								const url="/usuarios/guardar";
								let me=this;
								let success=0;
								await axios.post(url, this.usuario).then(function(response){
									if(response.data.error==0){
										Swal.fire({
											position: 'center',
											icon: 'error',
											title: 'Error!',
											text:'ya existe un usuario con ese codigo de sistema',
											showConfirmButton: true,
											
										});
									}else{
										$("#modalNuevo").modal('hide');
										me.search();
										console.log(response);
										success=1;
									}

								})
								.catch(function(error){
									console.log(error);
								})
								.finally(function(){
									if(success==1){
										Swal.fire({
											position: 'top-end',
											icon: 'success',
											title: 'Operación exitosa...',
											showConfirmButton: true,
											timer: 2000
										}); 
									}
								})
							}
						}
					}
				}
			},

			async modificarUsuario(){
			
				if(this.usuario.codigo_sistema==0 || this.usuario.codigo_sistema===undefined){
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Error!',
						text:'Debe ingresar un codigo para el usuario',
						showConfirmButton: true,
						
					}); 
				}else{
					if(this.usuario.nombre=='' || this.usuario.nombre===undefined){
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Error!',
							text:'Debe ingresar un nombre para el usuario',
							showConfirmButton: true,
							
						});
					}else{
						if(this.usuario.password=='' || this.usuario.password===undefined){
							Swal.fire({
								position: 'center',
								icon: 'error',
								title: 'Error!',
								text:'Debe ingresar una contraseña para el usuario',
								showConfirmButton: true,
								
							});
						}else{
							if(this.usuario.rol=='' || this.usuario.nombre===undefined){
								Swal.fire({
									position: 'center',
									icon: 'error',
									title: 'Error!',
									text:'Debe seleccionar un rol',
									showConfirmButton: true,
									
								});
							}else{
								const url="/usuarios/modificar";
								let me=this;
								await axios.post(url, this.usuario).then(function(response){
									$("#modalNuevo").modal('hide');
									me.search();
									console.log(response);
								})
								.catch(function(error){
									console.log(error);
								})
								.finally(function(){
									Swal.fire({
										position: 'top-end',
										icon: 'success',
										title: 'Operación exitosa...',
										showConfirmButton: true,
										timer: 2000
									}); 
								})
							}
						}
					}
				}
			},
			
			async search(){
				let url="/usuarios/buscar";
				let me= this;
				await axios.get(url+"?buscar="+this.buscar).then(function(response){
					me.items=response.data;
				})
				.catch(function (error){
					console.log(error);
				})
			},
			edit(usuario){
				this.resetUsuario();
				this.usuario.id_usuario=usuario.id;
				this.usuario.accion=1;
				this.usuario.nombre=usuario.name;
				this.usuario.rol=usuario.rol;
				this.usuario.correo=usuario.email;
				this.usuario.codigo_sistema=usuario.codigo_sistema;
				this.usuario.password='';
				$("#modalNuevo").modal('show');

			},
			resetUsuario(){
				this.usuario.id_usuario=0;
				this.usuario.accion=0;
				this.usuario.nombre='';
				this.usuario.rol='';
				this.usuario.correo='';
				this.usuario.codigo_sistema=0;
				this.usuario.password='';
			},
			activar(id_usuario){
				let url = '/usuarios/activar';
				let me=this;
				axios.post(url, {id_usuario}).then(function(response){
					
					console.log(response)
					me.search();
				}).catch(function(error){
					console.log(error);
				})
				.finally(function(){
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Operación exitosa...',
						showConfirmButton: true,
						timer: 2000
					}); 
				})
			},
			desactivar(id_usuario){
				let url = '/usuarios/desactivar';
				let me=this;
				axios.post(url, {id_usuario}).then(function(response){
					
					console.log(response)
					me.search();
				}).catch(function(error){
					console.log(error);
				})
				.finally(function(){
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Operación exitosa...',
						showConfirmButton: true,
						timer: 2000
					}); 
				})
			},
			
		},
		mounted()
		{
			this.search();
		},
		created()
		{
		
		}
	};
	SBFramework.AppComponents = {
		'siat-usuarios': ns.Usuarios, 
	};
})(SBFramework.Components);
