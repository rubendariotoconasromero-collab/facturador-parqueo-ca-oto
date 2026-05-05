

(function(ns)
{
	ns.ComInvoicer = {
		template: `<div id="com-invoicer" style="position:relative;">
			<invoicer-top v-bind:puntosventa="puntosventa" v-bind:monedas="monedas" v-bind:invoice="invoice" 
				v-on:evento-activo="onActiveEvent" v-on:ops-clicked="showOps()" />
			<form ref="forminvoice" novalidate>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-sm-4">
							<div class="mb-1">
								<label for="customer_name">Cliente</label>
								<div class="input-group" style="position:relative;">
									<input type="text" id="customer_name" class="form-control" autocomplete="off" 
										v-model="keyword_customer" 
										v-on:input="buscaRapidoCliente(keyword_customer)" v-on:keydown.enter="seleccionarClienteEnter()" required />
									<div class="input-group-btn">
										<button type="button" class="btn btn-info text-white" title="Buscar cliente"><i class="fa fa-search"></i></button>
										<button type="button" class="btn btn-warning text-white" title="Crear cliente" v-on:click="crearCliente()">
											<i class="fa fa-plus"></i>
										</button>									
									</div>
									<!--
									<div class="invalid-feedback">Debe ingresar el nombre del cliente</div>
									-->
									<template v-if="searchResultsClientes.length > 0">
										<div class="com-completion-results shadow" style="z-index:500;position:absolute;top:100%;left:0;width:100%;background:#fff;border:1px solid #ececec;max-height:250px;overflow:auto;" 
											v-bind:style="{display: searchResultsClientes.length > 0 && keyword_customer!=''? 'block' : 'none'}">
											<ul style="list-style:none;padding:0;margin:0;">
												<li v-for="(item, index) in searchResultsClientes" v-on:click="selectCustomer(item, index)"  style="cursor:pointer;:hover:background:#ececec;padding:6px;border-bottom:1px solid #ececec;">
													<div class="container-fluid p-0 dropdown-item">
														<div class="row p-2 no-gutters">
															<div class="col-sm-2">
																<img v-bind:src="'/images/client.png'" alt="" class="rounded-circle img-fluid img-thumbnail" />
															</div>
															<div class="col-sm-10">
																<div class="search-item-title">{{ item.text }}</div>
																<div class="search-item-excerpt">{{ item.email }}</div>
															</div>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</template>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-3">
							<div class="mb-1">
								<label class="d-block">
									NIT/CI
								</label>
								<input type="text" class="form-control" required v-model="keyword_nit" />
								<div class="invalid-feedback">Debe ingresar el NIT/CI del cliente</div>
							</div>
						</div>
						<div class="col-12 col-sm-1">
							<div class="mb-1">
								<label title="Complemento">Com</label>
								<input type="text" class="form-control" v-model="invoice.complemento" />
							</div>
						</div>
						<div class="col-12 col-sm-4">
							<div class="mb-1">
								<label>Tipo de Documento de Identidad</label>
								<select class="form-control form-select" v-model="invoice.tipo_documento_identidad" required>
									<option value="">-- tipo de documento --</option>
									<option v-bind:value="tc.codigoClasificador" v-for="(tc, itc) in tipos_documentos">
										{{ tc.descripcion }}
									</option>
								</select>
								<div class="invalid-feedback">Debe seleccionar el tipo de documento</div>
							</div>
						</div>
					</div>
					<!--<div class="row">
						<div class="col">
							<div class="mb-2">
								<label v-on:click="controlTributario('normal')" style="font-size:11px;">
									<input type="radio" name="im" value="normal" v-model="tipo_cliente" />
									Normal
								</label>
								<label v-on:click="controlTributario('control_tributario')" style="font-size:11px;">
									<input type="radio" name="im" value="control_tributario" v-model="tipo_cliente" />
									Control Tributario
								</label>
								<label v-on:click="controlTributario('ventas_menores')" style="font-size:11px;">
									<input type="radio" name="im" value="ventas_menores" v-model="tipo_cliente" />
									Ventas Menores del Dia
								</label>
								<label v-on:click="controlTributario('caso_especial')" style="font-size:11px;">
									<input type="radio" name="im" value="caso_especial" v-model="tipo_cliente" />
									Caso Especial
								</label>
							</div>
						</div>
					</div>-->
					<div class="row" v-show="activeEvent && [5, 6, 7].indexOf(activeEvent.evento_id) != -1">
						<div class="col-6 col-sm-3">
							<div class="mb-3">
								<label>Nro. Factura (talonario)</label>
								<input type="text" class="form-control" v-model="invoice.data.nro_factura" />
							</div>
						</div>
						<div class="col-6 col-sm-3">
							<div class="mb-3">
								<label>Fecha</label>
								<input type="date" class="form-control" ref="fecha" />
							</div>
						</div>
						<div class="col-6 col-sm-3">
							<div class="mb-3">
								<label>Hora</label>
								<input type="time" class="form-control" ref="hora" />
							</div>
						</div>
					</div>
					<template v-if="scom_detalle">
						<keep-alive>
							<component ref="headercom" v-bind:is="sector_com_detalle" v-bind:invoice="invoice"></component>
						</keep-alive>
					</template>
					<div class="row">
						<div class="col-sm-12">
							<div class="mb-3" style="position:relative;">
								<label>Adicionar item</label>
								<div class="input-group">
									<input type="text" v-model="keyword" class="form-control" placeholder="Nombre del item/producto"
										v-on:keydown.enter="$event.preventDefault()"
										v-on:input="buscaRapido(keyword)"
										v-on:keyup.enter="seleccionarProductoUnico()" />
									<!--
									<span class="">
										<input type="number" min="0" class="form-control" placeholder="Cantidad" />
									</span>
									-->
									<div class="input-group-btn">
										<button class="btn btn-info text-white" v-on:click="addItem($event)">Adicionar</button>
									</div>
								</div>
								<template v-if="searchResults.length > 0">
									<div class="com-completion-results shadow" style="z-index:500;position:absolute;top:100%;width:100%;background:#fff;border:1px solid #ececec;max-height:250px;overflow:auto;" 
										v-bind:style="{display: searchResults.length > 0 && keyword!='' ? 'block' : 'none'}">
										<ul style="list-style:none;padding:0;margin:0;">
											<li v-for="(item, index) in searchResults" v-on:click="agregarProductoCheck(item, index)" style="cursor:pointer;:hover:background:#ececec;padding:6px;border-bottom:1px solid #ececec;">
												<div class="container-fluid p-0 dropdown-item">
													<div class="row p-2 no-gutters">
														<div class="col-sm-2">
															<span class="rounded-circle img-fluid img-thumbnail" style="font-size:30px;">
																<i class="fa fa-box"></i>
															</span>
														</div>
														<div class="col-sm-10">
															<div class="search-item-title">({{ item.code }}) {{ item.name }}</div>
															<div class="search-item-excerpt"><b>Precio:</b> {{ item.price }}</div>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</template>
							</div>
						</div>
						<!--<div class=col-sm-4>
							<label>Codigo:</label>
							<div class="input-group">
								<input v-model="codigo_parqueo" type="text" class="form-control" placeholder="codigo parqueo">
								<a @click="obtenerDatos()" href="#" class="btn btn-success"><i class="fas fa-plus text-white"></i></a>
							</div>
						</div>-->
					</div>
					<div class="row">
						<div class="col-12"><h4>Detalle</h4></div>
						<i><b>Cantidad items: </b>{{invoice.items.length}}</i>
					</div>
					<div class="row border-bottom">
						<div class="col-sm-1 text-center"><b>Opción</b></div>
						<div class="col-sm-3 text-center"><b>Item</b></div>
						<div class="col-sm-1 text-center"><b>Cant.</b></div>
						<div class="col-sm-1 text-center"><b>Descuento</b></div>
						<div class="col-sm-2 text-center"><b>Importe</b></div>
						<div class="col-sm-3 text-center"><b>Descripcion servicio</b></div>
						<!--<div class="col-sm-1 text-center"><b>Opciones</b></div>-->
						<div class="col-sm-1 text-center"><b>Total</b></div>
					</div>
					<template v-if="invoice.items.length > 0 ">
						<template v-for="(item, index) in invoice.items">
							<template v-if="item_edit == index">
								<div class="row">
									<div class="col-12 col-sm-2">
										<div class="mb-2">
											<label>Codigo</label><input type="text" class="form-control" required v-model="item.product_code" />
										</div>
									</div>
									<div class="col-12 col-sm-4">
										<div class="mb-2">
											<label>Producto</label>
											<!--
											<input type="text" class="form-control" required v-model="item.product_name" />
											-->
											<textarea class="form-control" required v-model="item.product_name"></textarea>
										</div>
									</div>
									<div class="col-12 col-sm-2">
										<div class="mb-2"><label>Cantidad</label><input type="number" class="form-control" v-model="item.quantity" /></div>
									</div>
									<div class="col-12 col-sm-2">
										<div class="mb-2"><label>Precio</label><input type="text" class="form-control" v-model="item.price" /></div>
									</div>
									<div class="col-12 col-sm-2">
										<div class="mb-2"><label>Descuento</label><input type="text" class="form-control" v-model="item.discount" /></div>
									</div>
									<template v-if="!item.product_id || item.product_id <= 0">
										<div class="col-12 col-sm-4">
											<div class="mb-2">
												<label class="">Actividad</label>
												<select class="form-control form-select" required v-model="item.codigo_actividad">
													<option value="">-- actividad --</option>
													<option v-for="(a, ai) in lista_actividades" v-bind:value="a.codigoCaeb">
														{{ a.descripcion }}
													</option>
												</select>
											</div>
										</div>
										<div class="col-12 col-sm-4">
											<div class="mb-2">
												<label class="">Tipo Producto</label>
												<select class="form-control form-select" required v-model="item.codigo_producto_sin">
													<option value="">-- producto SIN --</option>
													<option v-for="(sp, spi) in item_sin_products" v-bind:value="sp.codigoProducto">
														{{ sp.descripcionProducto }}
													</option>
												</select>
											</div>
										</div>
										<div class="col-12 col-sm-4">
											<div class="mb-2">
												<label>Unidad Medida</label>
												<select class="form-control form-select" v-model="item.unidad_medida">
													<template v-for="(um, umi) in unidadesMedida">
														<option v-bind:value="um.codigoClasificador">{{ um.descripcion }}</option>
													</template>
												</select>
											</div>
										</div>
									</template>
									<!--<div class="col-12 col-sm-3">
										<div class="mb-2"><label>Num. Serie</label><input type="text" class="form-control" v-model="item.numero_serie" /></div>
									</div>
									<div class="col-12 col-sm-3">
										<div class="mb-2"><label>Num. IMEI</label><input type="text" class="form-control" v-model="item.imei" /></div>
									</div>-->
								</div>
								<template v-if="scom_item">
									<keep-alive>
										<component v-bind:is="sector_com_item" v-bind:invoice="invoice" v-bind:item="item"></component>
									</keep-alive>
								</template>
								<div class="row">
									<div class="col">
										<button type="button" class="btn btn-sm btn-info text-white" v-on:click="saveItem(index)">Guardar</button>
									</div>
								</div>
							</template>
							
							<div v-else class="row border-bottom p-2" style="position:relative;">
								<div class="col-12 col-sm-1">
									<button type="button" class="btn btn-sm btn-danger text-white" v-on:click="removeItem(index)"><i class="fa fa-trash"></i></button>
								</div>
								<div class="col-12 col-sm-3">
									<div class="fw-bold text-primary" style="font-size:13px;">Codigo: {{ item.product_code }}</div>
									<div>{{ item.product_name }}</div>
								</div>
								<div class="col-12 col-sm-1">
									<div class="text-center"><input style="font-size:14px;" type="number" class="form-control" v-model="item.quantity" v-on:keyup="actualizarMontos(index)"/></div>
								</div>
								
								<div class="col-12 col-sm-1">
									<div class="text-end">
										<input style="font-size:14px;" type="text" class="form-control" v-model="item.discount" v-on:keyup="actualizarMontos(index)"/>
									</div>
								</div>
								<div class="col-12 col-sm-2">
									<input style="font-size:14px;" type="text" class="form-control" v-model="item.price" v-on:keyup="actualizarMontos(index)" v-on:input="actualizarMontos(index)"/>
								</div>
								<div class="col-12 col-sm-3">
									<textarea style="font-size:14px;" type="text" class="form-control" v-model="item.imei"></textarea>
								</div>
								<!--<div class="col-12 col-sm-1">
									<div class="text-end">
										<a v-if="item.product_name=='TEMPORAL'" @click='insertarTicket(index)' class="btn btn-info btn-sm text-white">
										<i class="fas fa-ticket"></i>
										Ticket</a>
									</div>
								</div>-->
								<div style="font-size:15px;" class="col-12 col-sm-1"><div class="text-end">{{ item.total.toFixed(2) }}</div></div>
								<!--<div class="col-12 col-sm-12">
									<button type="button" class="btn btn-sm btn-info text-white" v-on:click="editItem(index)"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-sm btn-danger text-white" v-on:click="removeItem(index)"><i class="fa fa-trash"></i></button>
								</div>-->
							</div>
						</template>
					</template>
					<div v-else><h6 class="text-info p-3 text-center">Aun no existen items en su factura</h6></div>
					<div class="row border-bottom">
						<div class="col-12 col-sm-9 text-end text-right"><b>Subtotal:</b></div>
						<div class="col-12 col-sm-3 text-end text-right"><b>{{ invoice.subtotal.toFixed(2) }}</b></div>
						
						<template v-if="with_giftcard">
							<div class="col-12 col-sm-9 text-end text-right"><div style="line-height:37px;"><b>Monto Gift Card:</b></div></div>
							<div class="col-12 col-sm-3">
								<input type="text" class="form-control text-end text-right" v-model="invoice.monto_giftcard" required />
							</div>
						</template>
						<div class="col-12 col-sm-9 text-right text-end"><div style="line-height:37px;"><b>Descuento:</b></div></div>
						<div class="col-12 col-sm-3">
							<input type="text" class="form-control text-end text-right" v-model="invoice.discount"/>
						</div>
							
						<div class="col-12 col-sm-9 text-end text-right"><b>Total Base Credito Fiscal:</b></div>
						<div class="col-12 col-sm-3 text-end text-right"><b>{{ invoice.total.toFixed(2) }}</b></div>
						
						<div class="col-12 col-sm-9 text-end text-right"><b>Crédito fiscal:</b></div>
						<div class="col-12 col-sm-3 text-end text-right"><b>{{ invoice.total_tax.toFixed(2) }}</b></div>
						
						
						<div class="col-12 col-sm-6 text-end">&nbsp;</div>
						<div class="col-12 col-sm-6 text-end">
							<div class="form-group mb-2">
								<label><b>Metodo de pago:</b></label>
								<section class="dropdown-wrapper form-control bg-disabled">
                                	<div @click="isVisible = !isVisible" class="selected-item">
                                    	<span v-if="metodo_pago_descripcion==''">Seleccione Metodo pago</span>
                                    	<span  v-else>{{metodo_pago_descripcion }} </span>
                                    	<svg :class="isVisible ? 'dropdown' : ''" class="drop-down-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z"/></svg>
                                	</div>
                                	<div :class="isVisible  ? 'visible' : 'invisible'" class="dropdown-popover">
                                    	<input type="text" class="form-control" placeholder="Buscar Metodo pago.."  v-model="searchString" aria-label="Buscar metodo..">
                                    	<div class="text-center"><span v-if="filteredOptions.length === 0">No existe el metodo pago</span></div>
                                    	<div class="options">
                                        	<ul>
                                            	<li @click="selectedMetodoPago(cliente)" v-for="(cliente, index) in filteredOptions" :key="index">{{cliente.descripcion}}</li>
                                        	</ul>
                                    	</div>
                                	</div> 
                                </section>
								<!--<sb-dropdown
									
									class="bg-white" 
									v-model="invoice.codigo_metodo_pago"
									placeholder="Buscar..."
									
									v-bind:options="metodos_pago.map( mp => {return {text: mp.descripcion, value: mp.codigoClasificador};} )" />-->
								<!--
								<select class="form-select form-control form-select-sm bg-white" v-model="invoice.codigo_metodo_pago" required>
									<option value="">-- metodo de pago --</option>
									<option v-if="mp.codigoClasificador==1" v-bind:value="mp.codigoClasificador" v-for="(mp, imp) in metodos_pago">{{ mp.descripcion }}</option>
								</select>
								-->
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-auto col-sm-auto">
							
							<div class="mt-3"><button type="button" class="btn btn-info text-white" v-on:click="save()">Generar Factura</button></div>
							
						</div>
						<div class="col-auto col-sm-auto">
							<div class="mt-3"><button type="button" class="btn btn-danger text-white" v-on:click="cancelar()">Cancelar</button></div>
						</div>
					</div>
				</div>
			</form>
			<!--<siat-customer-form ref="customer_form" />-->
			<siat-customer-form ref="customer_form" v-on:customer-saved="onCustomerSaved" />

			<div ref="modaldatostarjeta" class="modal fade">
				<form ref="formtarjeta" novalidate>
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-info text-white">
							<h5 class="modal-title">Datos Tarjeta</h5>
							<button class="close btn-close" type="button" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<p>Ingrese los datos de la tarjeta de cr&eacute;dito/d&eacute;bito</p>
								<div class="mb-3">
									<label>Nro. de Tarjeta</label>
									<div class="input-group">
										<span class="input-group-addon input-group-text "><i class="fa fa-credit-card"></i></span>
										<input type="text" class="form-control" required pattern="[0-9]{16}" maxlength="16" v-model="invoice.numero_tarjeta" oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');" ref="inputcard"/>
										<div class="invalid-feedback">Debe ingresar un n&uacute;mero de tarjeta v&aacute;lido</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger text-white" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal">Cancelar</button>
								<button type="button" class="btn btn-info text-white" v-on:click="save()">Continuar</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			
			<div ref="modalops" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content" novalidate>
						<div class="modal-header bg-info text-white">
							<h5 class="modal-title">Opciones de Facturacion</h5>
							<button class="close btn-close" type="button" data-bs-dismiss="modal" data-coreui-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="form-grooup mb-3">
								<label>Sucursal</label>
								<select class="form-control form-select" v-model="invoice.codigo_sucursal">
									<option value="0">Sucursal Principal 0 (por defecto)</option>
									<option v-bind:value="s.code" v-for="(s, si) in sucursales">{{ s.name }}</option>
								</select>
							</div>
							<div class="form-group mb-3">
								<label>Documento Sector</label>
								<select class="form-control form-select" v-model="documento_sector">
									<option v-bind:value="ds.com" v-for="(ds, ids) in sectores">{{ ds.nombre }}</option>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger text-white" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
			<div ref="modalimprimir" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content" novalidate>
						<div class="modal-header bg-info text-white">
							<h5 class="modal-title">Impresion</h5>
							<button class="close btn-close" type="button" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body row">
							<div class="col-3 text-center">
								<i class="fa fa-print" style="font-size:50px;"></i>
							</div>
							<div class="col-9">
								<p>La factura fue generada correctamente</p>
								<p>Desea imprimir la factura?</p>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger text-white" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal">Cerrar</button>
							<a v-if="generatedInvoice" 
								v-bind:href="generatedInvoice.print_url" 
								target="_blank" 
								class="btn btn-info text-white"
								v-on:click="closeModal(modalImprimir)">
								Imprimir
							</a>
							<a v-if="generatedInvoice" 
								v-bind:href="generatedInvoice.print_url + '?tpl=rollo'" 
								target="_blank" 
								class="btn btn-warning text-white"
								v-on:click="closeModal(modalImprimir)">
								Imprimir Ticket
							</a>
						</div>
					</div>
				</div>
			</div>
			<div ref="modalexcepcion" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content" novalidate>
						<div class="modal-header">
							<h5 class="modal-title">Verificacion de NIT</h5>
							<button class="close btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body row">
							<div class="col-3 text-center">
								<i class="fa fa-exclamation" style="font-size:50px;"></i>
							</div>
							<div class="col-9">
								<p>El NIT del cliente no es valido</p>
								<p>Desea generar la factura de todas formas?</p>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal">Cerrar</button>
							<button type="button" data-dismiss="modal" data-bs-dismiss="modal" data-coreui-dismiss="modal"
								class="btn btn-primary"
								v-on:click="invoice.excepcion = 1;save()">
								Generar Factura
							</button>
						</div>
					</div>
				</div>
			</div>
			<div id="modalTicket" class="modal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header bg-info text-white">
					<h5 class="modal-title">Número del ticket</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Ingrese numero interno</label>
						<input @keyup.enter="obtenerDatos()" v-model="codigo_parqueo" type="text" class="form-control" placeholder="Ingrese el numero del ticket">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
					<button @click="obtenerDatos()" type="button" class="btn btn-info text-white">Cargar Ticket</button>
				</div>
				</div>
			</div>
		</div>
		</div>
		
		`,
		
		components: {
			'sb-dropdown': SBFramework.Components.ComDropdown,
			'invoicer-top': ns.ComInvoicerTop, 
			'educativo_item': ns.ItemColegio,
			'educativo_detalle': ns.DetalleColegio,
			'turistico_item': ns.ItemTuristico,
			'turistico_detalle': ns.DetalleTuristico,
			'hotel_item': ns.ItemHotel,
			'hotel_detalle': ns.DetalleHotel,
			'hospital_item': ns.ItemHospital,
			'hospital_detalle': ns.DetalleHospital,
			'financiera_item': ns.ItemFinanciera,
			'financiera_detalle': ns.DetalleFinanciera,
			'tasacero_item': ns.ItemTasaCero,
			'tasacero_detalle': ns.ItemTasaCero,
			'exportservicio_item': ns.ItemExportacionServicio,
			'exportservicio_detalle': ns.DetalleExportacionServicio,
			'export_item': ns.ItemExportacion,
			'export_detalle': ns.DetalleExportacion,
			'alquiler_detalle': ns.DetalleAlquiler,
			'alquiler_item': ns.ItemAlquiler,
			'prevalorada_detalle': ns.DetallePrevalorada,
			'prevalorada_item': ns.ItemPrevalorada,
			'siat-customer-form': ns.ComCustomerForm,
		},
		mixins: [/*SBFramework.Mixins.SiatOnlineStatus*/SBFramework.Mixins.Common, SBFramework.Mixins.Events],
		data()
		{
			return {
				sectores: [
					{nombre: 'Compra Venta', com: null, codigo: 1},
					{nombre: 'Alquiler Inmuebles', com: 'alquiler', codigo: 2},
					//{nombre: 'Servicio Turistico y Hospedaje', com: 'turistico', codigo: 6},
					//{nombre: 'Tasa Cero', com: 'tasacero', codigo: 8},
					//{nombre: 'Sector Educativo', com: 'educativo', codigo: 11},
					//{nombre: 'Entidades Financieras', com: 'financiera', codigo: 15},
					//{nombre: 'Hoteles', com: 'hotel', codigo: 16},
					//{nombre: 'Hospitales y Clinicas', com: 'hospital', codigo: 17},
					//{nombre: 'Comercial Exportacion', com: 'export', codigo: 3},
					//{nombre: 'Prevalorada', com: 'prevalorada', codigo: 23},
					{nombre: 'Comercial Exportacion Servicio', com: 'exportservicio', codigo: 28},
				],
				searchString: '',
				metodo_pago_descripcion:'',
                isVisible: false,
				factura:-1,
				buscarPlaca:false,
				datosFacturacion:{},
				codigo_parqueo:0,
				documento_sector: null,
				keyword: '',
				itemfound: null,
				item_edit: -1,
				sucursales: [],
				puntosventa: [],
				tipos_productos: [],
				modalCustomer: null,
				modalDatosTarjeta: null,
				modalCerrarEvento: null,
				modelImprimir: null,
				modalExcepcion: null,
				modalOps: null,
				invoice: new SBFramework.Models.Invoice(),
				generatedInvoice: null,
				currentCustomer: {id: 0, customer_id: 0,},
				searchTimeout: null,
				searchProdTimeout: null,
				keyword_customer: '',
				keyword_nit: '',
				customers_list: [],
				products_list: [],
				unidadesMedida: [],
				monedas: [],
				tipos_documentos: [],
				metodos_pago: [],
				lista_actividades: [],
				activeEvent: null,
				tipo_cliente: 'normal',
				with_giftcard: true,
				scom_detalle: null,
				scom_item: null,
				isOnline: true,
				service: new SBFramework.Services.ServiceInvoices(),
				serviceCustomers: new SBFramework.Services.ServiceCustomers(),
				allow_payment_methods: [], //1,2,3,7],
				cliente_seleccionado:'',
				arrayProductos:[],
				arrayClientes:[],
				searchResults:[],
				searchResultsClientes:[],
				itemActual : '',
			};
		},
		computed:
		{
			filteredOptions() {
				const data = this.searchString.toLowerCase();
					if(this.searchString == ""){
						return this.metodos_pago;
					}
					return this.metodos_pago.filter((item)=>{
						return Object.values(item).some((word=>String(word).toLowerCase().includes(data)))
					})
			},
			tipos_productos_filter()
			{
				if( !this.actividad_economica )
					return this.tipos_productos;
				return this.tipos_productos.filter( tp => tp.codigoActividad == this.actividad_economica );
				//return this.tipos_productos
			},
			sector_com_detalle()
			{
				return this.scom_detalle;
			},
			sector_com_item()
			{
				return this.scom_item;
			},
			current_doc_sector()
			{
				let doc_sector = this.sectores.find( ds => ds.com == this.documento_sector);
				return doc_sector ? doc_sector.codigo : 1;
			},
			item_sin_products()
			{
				if( this.item_edit <= -1 )
					return [];
				return this.filterSinProducts(this.invoice.items[this.item_edit].codigo_actividad);
			}
		},
		watch:
		{
			documento_sector()
			{
				console.log('documento_sector', this.documento_sector);
				this.invoice.codigo_documento_sector = 1; //compra venta
				this.invoice.tipo_factura_documento = 1; //credito fiscal
				this.scom_detalle = null;
				this.scom_item 	= null;
				this.invoice.items = [];
				if( !this.documento_sector )
				{
					this.calculateTotals();
					return;
				}
				this.invoice.codigo_documento_sector = this.current_doc_sector;
				if( [6, 8, 28].indexOf(this.invoice.codigo_documento_sector) != -1 )
				{
					this.invoice.tipo_factura_documento = 2; //sin credito fiscal
				}
				console.log(this.invoice.codigo_documento_sector, this.invoice.tipo_factura_documento);
				this.scom_detalle = this.documento_sector + '_detalle';
				this.scom_item = this.documento_sector + '_item';
				console.log(this.scom_detalle, this.scom_item);
				this.calculateTotals();
			},
			'invoice.punto_venta'()
			{
				this.checkActiveEvent(this.invoice.codigo_sucursal, this.invoice.punto_venta);
			},
			'invoice.monto_giftcard'()
			{
				if( isNaN(parseFloat(this.invoice.monto_giftcard)) )
				{
					this.invoice.monto_giftcard = 0;
					return;
				}
				this.invoice.monto_giftcard = parseFloat(parseFloat(this.invoice.monto_giftcard).toFixed(2));
				/*
				if( isNaN(parseFloat(this.invoice.total)) )
				{
					this.invoice.total = 0; 
				}
				this.invoice.total = parseFloat(parseFloat(this.invoice.total).toFixed(2));
				this.invoice.total -= this.invoice.monto_giftcard;
				*/
			},
			'invoice.codigo_metodo_pago'()
			{
				this.invoice.monto_giftcard = 0;
				const metodo_pago 			= this.buscarMetodoPago(this.invoice.codigo_metodo_pago);
				if( metodo_pago.descripcion.toUpperCase().indexOf('GIFT') != -1 )
				{
					this.with_giftcard = true;
					return true;
				}
				this.with_giftcard = false;
			},
			'invoice.discount'()
			{
				if( isNaN(parseFloat(this.invoice.discount)) )
				{
					this.invoice.discount = 0;
					//return;
				}	
				this.calculateTotals();
			},
			'invoice.monto_giftcard'()
			{
				/*
				if( this.invoice.monto_giftcard.toString().trim() <= 0 )
				{
					this.calculateTotals();
					return;
				}	
				*/	
				if( isNaN(parseFloat(this.invoice.monto_giftcard)) )
				{
					this.invoice.monto_giftcard = 0;
				}	
				this.calculateTotals();
			},
			'keyword_customer'(){
				if(this.keyword_customer==''){
					this.invoice.tipo_documento_identidad='';
					this.keyword_nit='';
				}
			}
		},
		methods: 
		{
			/*obtenerDatos(){
				code = this.codigo_parqueo;
				//console.log(this.codigo_parqueo);
				const url = '/Conex/TaerDatos?numero='+code;
				let me=this;
				axios.get(url).then(function(response){
					if(response.data.val==1){
						console.log('valor: ',response.data.val);
						me.datosFacturacion=JSON.parse(response.data.msg);
						// this.datosFacturacion.importe=430;
						// this.datosFacturacion.placa='6242UUA';

						console.log('datos:',me.datosFacturacion);
						me.arrayProductos[me.itemActual].imei=' '+(me.datosFacturacion.placa!='')?' Nro. placa: '+me.datosFacturacion.placa:'';
						me.arrayProductos[me.itemActual].price=me.datosFacturacion.importe;
						//me.arrayProductos[me.itemActual].total=me.invoice.items[me.itemActual].quantity * me.invoice.items[me.itemActual].price;
						me.selectProduct(me.arrayProductos[me.itemActual], 1);
						
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Operación exitosa',
							showConfirmButton: false,
							timer: 1500
						}); 

					}else{
						console.log('valor: ',response.data.val);
						Swal.fire({
							position: 'top-center',
							icon: 'error',
							title: response.data.msg,
							showConfirmButton: true,
							
						}); 
					}
					$('#modalTicket').modal('hide');
				
				})
				.catch(function(error){
					console.log(error);

				})
			},*/
			selectedMetodoPago(pago) {
                this.invoice.codigo_metodo_pago=pago.codigoClasificador;
				this.metodo_pago_descripcion=pago.descripcion;
                this.isVisible = false;

                //this.datos.descuento = cliente.descuento * this.datos.sub_total / 100;
            },
			contieneSoloNumeros(cadena) {
				return /^[0-9]+$/.test(cadena);
			},
			obtenerDatos2(item, codigo_parqueo){
				// Obtén el token CSRF de la etiqueta meta en el HTML
				const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

				// Configura el token CSRF como encabezado en las solicitudes Axios
				axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

				let code = codigo_parqueo;
				let datosEnviar={};
				
				//code = this.codigo_parqueo;
				//console.log(this.codigo_parqueo);
				//let code="123A";

				if(this.contieneSoloNumeros(code)){
					datosEnviar={
					
						numticket: code,
						placa: ""
					}
					console.log('es numero');
				}else{
					
					datosEnviar={
						
							numticket: 0,
							placa: code
						}
						console.log('es cadena');
					
				}
				
				const url = '/Conex/TraerDosDatos';
				let me=this;

				axios.post(url, datosEnviar).then(response=>{
					if(response.data.val==1){
						console.log('valor: ',response.data.val);
						me.datosFacturacion=JSON.parse(response.data.msg);
						// this.datosFacturacion.importe=430;
						// this.datosFacturacion.placa='6242UUA';

						console.log('datos:',me.datosFacturacion);
						item['imei']=' '+(me.datosFacturacion.placa!='')?' Nro. placa: '+me.datosFacturacion.placa:'';
						item['price']=me.datosFacturacion.importe;
						//me.arrayProductos[me.itemActual].total=me.invoice.items[me.itemActual].quantity * me.invoice.items[me.itemActual].price;
						me.selectProduct(item, 1);
						
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Operación exitosa',
							showConfirmButton: false,
							timer: 1500
						}); 

					}else{
						console.log('valor: ',response.data.val);
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: response.data.msg,
							showConfirmButton: true,
							
						}); 
					}
					//$('#modalTicket').modal('hide');
				
				})
				.catch(error=>{
					console.log(error);
					Swal.fire({
						position: 'top-center',
						icon: 'error',
						title: 'error',
						text: error.message,
						showConfirmButton: true,
						
					}); 

				})
			},

			async obtenerDatos3(item, codigo_parqueo){
			
					let code = codigo_parqueo;// nroTiket / Placa
					let datosEnviar={};
					var url='';
					let me=this;
					
					if(this.contieneSoloNumeros(code)){
						datosEnviar={
						
							numticket: code,
							placa: ""
						};

						//me.consultarTicket(code);
						
						url='/Conex/TaerDatos?numero='+datosEnviar.numticket;
						console.log('es numero');
					}else{
						
						datosEnviar={
							
								numticket: 0,
								placa: code
							};
							url='/Conex/TaerDatosPlaca?placa='+datosEnviar.placa;
							console.log('es cadena');
						
					}
					//let placa = placa_parqueo;
				
					
					await axios.get(url).then(response=>{
						console.log('probando datos', response.data.val);
						if(response.data.val==1){
							Swal.fire({
								position: 'center',
								icon: 'error',
								title: 'Error',
								text: 'El ticket ya fue facturado',
								showConfirmButton: false,
								timer: 1500
							}); 
						}else{
							if(response.data.nroTiket!=0 && response.data.importe!=0 && response.data.placa!=''){
								console.log('valor: ',response.data.val);
								//me.datosFacturacion=JSON.parse(response.data.msg);
								// this.datosFacturacion.importe=430;
								// this.datosFacturacion.placa='6242UUA';
								
									console.log('datos:',response.data);
									item['imei']=' '+(response.data.placa!='')?' Nro. placa: '+response.data.placa:'';
									item['price']=response.data.importe;
									//me.arrayProductos[me.itemActual].total=me.invoice.items[me.itemActual].quantity * me.invoice.items[me.itemActual].price;
									me.selectProduct(item, 1);
									me.invoice.num_ticket=codigo_parqueo;
									Swal.fire({
										position: 'top-end',
										icon: 'success',
										title: 'Operación exitosa',
										showConfirmButton: false,
										timer: 1500
									}); 
								
			
							}else{
								console.log('valor: ',response.data);
								console.log('Procesandooo---------!!!!!!!!!!!');
									// mensaje advertencia
								Swal.fire({
									position: 'center',
									icon: 'warning',
									title: 'Ticket ya procesado',
									text:'Desea importar datos para facturar',
									showConfirmButton: true,
									showCancelButton: true, // Agrega el botón de "Reintentar"
									cancelButtonText: 'Importar',
									showConfirmButton: false,
																
								})
								.then((result) => {
									if (result.dismiss === Swal.DismissReason.cancel) {
										// Ejecuta el método de reintentar aquí (el que está comentado)
										me.obtenerDatosImporte(item, code);
									}
								});
								// reintentar
							}
						}
							
					})
					.catch(error=>{
						console.log(error);
						Swal.fire({
							position: 'top-center',
							icon: 'error',
							title: 'error',
							text: error.message,
							showConfirmButton: true,
								
						}); 
					})
			},
			consultarTicket(numero_ticket){
	
				//let me=this;
				axios.get('/factura/existe_ticket?numero_ticket='+numero_ticket)
				.then(function(response){
					//return response.data.respuesta;
					if(response.data.respuesta==1){
						this.factura=1;
						console.log('rest', response.data.respuesta);
					}
				})
				.catch((error)=>{
					console.log(error.message);				
				})
			
			},
			obtenerDatosImporte(item, numeroTicket){
				let code = numeroTicket;// nroTiket / Placa
				let datosEnviar={};
				var url='';
				if(this.contieneSoloNumeros(code)){
					datosEnviar={
					
						numticket: code,
						placa: ""
					};
					url='/Conex/TaerDatosImporteTicket?numero='+datosEnviar.numticket;
					console.log('es numero');
				}else{
					
					datosEnviar={
						
							numticket: 0,
							placa: code
						};
						url='/Conex/TaerDatosImportePlaca?placa='+datosEnviar.placa;
						console.log('es cadena');
					
				}
				//let placa = placa_parqueo;
			
				let me=this;

				axios.get(url).then(response=>{
					if(response.data.nroTiket!=0 && response.data.importe!=0 && response.data.placa!=''){
						console.log('valor: ',response.data.val);
						//me.datosFacturacion=JSON.parse(response.data.msg);
						// this.datosFacturacion.importe=430;
						// this.datosFacturacion.placa='6242UUA';

						console.log('datos:',response.data);
						item['imei']=' '+(response.data.placa!='')?' Nro. placa: '+response.data.placa:'';
						item['price']=response.data.importe;
						//me.arrayProductos[me.itemActual].total=me.invoice.items[me.itemActual].quantity * me.invoice.items[me.itemActual].price;
						me.selectProduct(item, 1);
						me.invoice.num_ticket=numeroTicket;
						
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Operación exitosa',
							showConfirmButton: false,
							timer: 1500
						}); 

					}else{
						console.log('valor: ',response.data);
						//console.log('Procesandooo---------!!!!!!!!!!!');
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Error',
							text:'error al obtener ticket',
							showConfirmButton: true,
							
						}); 
					}
					//$('#modalTicket').modal('hide');
				
				})
				.catch(error=>{
					console.log(error);
					Swal.fire({
						position: 'top-center',
						icon: 'error',
						title: 'error',
						text: error.message,
						showConfirmButton: true,
						
					}); 

				})
			},
			buscarSinNombre(nombre){
				// Buscar el objeto en el arreglo por su nombre
				const objetoEncontrado = this.arrayClientes.find(objeto => objeto.lastname === nombre);

				if (objetoEncontrado) {
					console.log('cliente encontrado:', objetoEncontrado);
				} else {
					console.log('cliente no encontrado');
				}
				return objetoEncontrado;
			},
			insertarTicket(index){
				$('#modalTicket').modal('show');
				console.log(this.datosFacturacion);
				this.codigo_parqueo=0;
				this.itemActual=index;
				console.log(this.itemActual);
			},
			limpiarMetodosPago(){
				//this.metodos_pago.splice(0);
				this.metodos_pago=[];
				// for (i = 0; i < this.metodos_pago.length; i++) {
				// 	this.metodos_pago[i].codigoClasificador='';
				// 	this.metodos_pago[i].descripcion='';
				// } 
			},
			imprimirPDF() {
                var pdfURL = '/pdfs/factura.pdf';
                var iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = pdfURL;
                document.body.appendChild(iframe);

                iframe.onload = function() {
                    iframe.contentWindow.print();
                };
            },
			buscaRapido(buscar) {
				// Limpia el array de resultados de búsqueda antes de realizar una nueva búsqueda
				this.searchResults = [];
		  
				// Realiza la búsqueda dentro del array original
				for (let i = 0; i < this.arrayProductos.length; i++) {
				  const item = this.arrayProductos[i];
				  
				  // Realiza la lógica de búsqueda según tus necesidades
				  // En este ejemplo, se buscarán elementos que contengan el término de búsqueda en su nombre
				  if (item.name.toLowerCase().includes(buscar.toLowerCase()) || item.code.includes(buscar) ) {
						this.searchResults.push(item); // Agrega el elemento encontrado al array de resultados
				  }
				}
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
				let customer={};
				Object.assign(customer, data.customer);
				this.selectCustomer(customer);
				// this.keyword_customer = data.customer.lastname;
				// this.keyword_nit = data.customer.nit_ruc_nif;
				// this.invoice.tipo_documento_identidad = data.customer.identity_document;


				this.cargarClientes();
				setTimeout(()=>{
					this.buscaRapidoCliente(customer.nit_ruc_nif);
					this.currentCustomer.id=this.searchResultsClientes[0].id;
					this.searchResultsClientes=[];
				},2000);
				//this.getCustomers(page);
			},

			
			buscaRapidoCliente(buscar) {
				// Limpia el array de resultados de búsqueda antes de realizar una nueva búsqueda
				this.searchResultsClientes = [];
		  
				// Realiza la búsqueda dentro del array original
				for (let i = 0; i < this.arrayClientes.length; i++) {
				  const item = this.arrayClientes[i];
				  
				  // Realiza la lógica de búsqueda según tus necesidades
				  // En este ejemplo, se buscarán elementos que contengan el término de búsqueda en su nombre
				  if (item.nit_ruc_nif.toLowerCase().includes(buscar.toLowerCase()) || item.lastname.toLowerCase().includes(buscar.toLowerCase()) ) {
						this.searchResultsClientes.push(item); // Agrega el elemento encontrado al array de resultados
				  }
				}
			},
			async cargarClientes(){
				
					const res = await this.serviceCustomers.cargarClientes();
					this.arrayClientes = res.data;
					
					
			},
			onActiveEvent(event)
			{
				this.activeEvent = event;
			},
			async cargarProductos(){
				const res = await this.service.cargarProductos();
				this.arrayProductos = res.data;
			},
			cancelar(){
				location.reload();
			},
			async agregarProductoCheckRespaldo(item, index) {
				//buscarPlaca=true
				let me= this;
				let titulo = (item.name!='TEMPORAL')?'Ingrese una descripcion del servicio': 'Ingrese Nr. Ticket / Placa';
				//if(item['name']!='TEMPORAL'){
					Swal.fire({
						title: item.name + '\n' +titulo+ '\n',
						input: 'text',
						inputAttributes: {
							autocapitalize: 'off',
							size: 3
						},
					
						showCancelButton: true,
						confirmButtonText: 'Guardar',
						cancelButtonText: 'Cancelar',
						showLoaderOnConfirm: true,
						preConfirm: (value) => {
						   
							if (!value.trim()) {
								Swal.showValidationMessage(
									`Ingrese un valor`
								);
							}else{
								if(item['name']!='TEMPORAL'){
									console.log(value);
									item['imei']=value;
									me.selectProduct(item, 1);
								}else{
									me.obtenerDatos3(item, value);
								}
							} 
						
	
						},
					}).then((result) => {
						if (result.isConfirmed) {
							if(item.name!='TEMPORAL'){
								Swal.fire({
									position: 'top-end',
									icon: 'success',
									title: 'Producto agregado...',
									showConfirmButton: false,
									timer: 1500
								});
							}
						
						}
					})
			
            
            },
			async agregarProductoCheckOld(item, index) {
				//buscarPlaca=true
				let me= this;
				let titulo = 'Ingrese los siguientes datos:';
				//if(item['name']!='TEMPORAL'){
					Swal.fire({
						title: item.name + '\n' +titulo+ '\n',
						input: 'text',
						inputAttributes: {
							autocapitalize: 'off',
							size: 3
						},
					
						showCancelButton: true,
						confirmButtonText: 'Guardar',
						cancelButtonText: 'Cancelar',
						showLoaderOnConfirm: true,
						preConfirm: (value) => {
						   
							if (!value.trim()) {
								Swal.showValidationMessage(
									`Ingrese un valor`
								);
							}else{
								// if(item['name']!='TEMPORAL'){
									console.log(value);
									item['imei']=value;// para la descripcion
									me.selectProduct(item, 1);
								// }else{
								// 	me.obtenerDatos3(item, value);
								// }
							} 
						
	
						},
					}).then((result) => {
						if (result.isConfirmed) {
							// if(item.name!='TEMPORAL'){
								Swal.fire({
									position: 'top-end',
									icon: 'success',
									title: 'Producto agregado...',
									showConfirmButton: false,
									timer: 1500
								});
							// }
						
						}
					})
            },
			async agregarProductoCheckSeparado(item, index) {
				let me = this;
				let titulo = 'Ingrese los siguientes datos:';
			
				let descriptionResult = await Swal.fire({
					title: item.name + '\n' + titulo,
					input: 'text',
					inputValue: item.imei, // Valor por defecto en la caja de texto de descripción
					inputAttributes: {
						autocapitalize: 'off',
						size: 3
					},
					showCancelButton: true,
					confirmButtonText: 'Siguiente',
					cancelButtonText: 'Cancelar',
					showLoaderOnConfirm: true,
					inputValidator: (value) => {
						if (!value.trim()) {
							return 'Ingrese una descripción';
						}
					}
				});
			
				if (!descriptionResult.dismiss) {
					let priceResult = await Swal.fire({
						title: 'Ingrese el precio:',
						input: 'number',
						inputAttributes: {
							autocapitalize: 'off',
							size: 3
						},
						showCancelButton: true,
						confirmButtonText: 'Guardar',
						cancelButtonText: 'Cancelar',
						showLoaderOnConfirm: true,
						inputValidator: (value) => {
							if (!value) {
								return 'Ingrese un precio';
							}
							if (isNaN(value)) {
								return 'Ingrese un valor numérico';
							}
						}
					});
			
					if (!priceResult.dismiss) {
						let description = descriptionResult.value;
						let price = parseFloat(priceResult.value);
			
						// Aquí puedes usar la descripción y el precio en tus funciones
						me.selectProduct(item, 1, description, price);
			
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Producto agregado...',
							showConfirmButton: false,
							timer: 1500
						});
					}
				}
			},

			async agregarProductoCheck(item, index) {
				let me = this;
				let titulo = 'Ingrese los siguientes datos:';
				
				let result = await Swal.fire({
					title: item.name.toUpperCase() + '\n' + titulo,
					html:
					'<input id="descripcion" class="swal2-input custom-input" placeholder="Placa / Descripción">' +
					'<input id="precio" class="swal2-input custom-input" placeholder="Precio" type="number" step="0.01" min="0">',
					focusConfirm: false,
					showCancelButton: true,
					confirmButtonText: 'Guardar',
					cancelButtonText: 'Cancelar',
					preConfirm: () => {
						const descripcion = Swal.getPopup().querySelector('#descripcion').value;
						const precio = Swal.getPopup().querySelector('#precio').value;

						// imei - guardar descripcion
						item['imei']=descripcion;
						item['price']=precio;

						// guardando precio

			
						if (!descripcion || !precio) {
							Swal.showValidationMessage('Por favor, complete ambos campos.');
						}
			
						return { descripcion: descripcion, precio: precio };
					}
				});
			
				if (result.isConfirmed) {
					const descripcion = result.value.descripcion;
					const precio = parseFloat(result.value.precio);
			
					me.selectProduct(item, 1, descripcion, precio);
			
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Producto agregado...',
						showConfirmButton: false,
						timer: 1500
					});
				}
			},
			
			
			
			toggleCheckbox() {
				this.buscarPlaca = !this.buscarPlaca;
			},
			seleccionarClienteEnter(){
				this.cliente_seleccionado='';
				if(!isNaN(this.keyword_customer)){
					//console.log('es numerico');
					//if(this.products_list[0].code==parseInt(this.keyword)){
					// Supongamos que deseas buscar el valor "ejemplo" en la propiedad "miPropiedad"
					const resultados = this.searchResultsClientes.filter(objeto => parseFloat(objeto.nit_ruc_nif) === parseFloat(this.keyword_customer));

					if (resultados.length > 0) {
					// Se encontraron resultados en el array
					// Puedes acceder a los objetos encontrados en el array 'resultados'
						//this.agregarProductoCheck(this.products_list[0], 0);
						console.log(resultados[0].nit_ruc_nif);
						this.cliente_seleccionado=resultados[0].lastname;
						this.selectCustomer(resultados[0]);
						this.searchResultsClientes=[];


						//this.agregarProductoCheck(resultados[0], 0);


					} else {
						Swal.fire({
							position: 'top-center',
							icon: 'warning',
							title: '¡No existe cliente con ese codigo!',
							showConfirmButton: false,
							timer: 800
						});
					}
				}else{
					if(this.searchResultsClientes.length==1){
						this.cliente_seleccionado=this.searchResultsClientes[0].lastname;
						this.selectCustomer(this.searchResultsClientes[0]);
						this.searchResultsClientes=[];
						
						
					}else{
						console.log('Hay mas de un registro como resultado');
					}
				}

				//console.log('diste enter');
			
			},
			seleccionarProductoUnico(){
				if(!isNaN(this.keyword)){
					//console.log('es numerico');
					//if(this.products_list[0].code==parseInt(this.keyword)){
					// Supongamos que deseas buscar el valor "ejemplo" en la propiedad "miPropiedad"
					const resultados = this.searchResults.filter(objeto => parseFloat(objeto.code) === parseFloat(this.keyword));

					if (resultados.length > 0) {
					// Se encontraron resultados en el array
					// Puedes acceder a los objetos encontrados en el array 'resultados'
						//this.agregarProductoCheck(this.products_list[0], 0);
						console.log(resultados[0].code);
						this.agregarProductoCheck(resultados[0], 0);


					} else {
						Swal.fire({
							position: 'top-center',
							icon: 'warning',
							title: '¡No existe producto con ese codigo!',
							showConfirmButton: false,
							timer: 800
						});
					}
				}else{
					if(this.searchResults.length==1){
						if(!isNaN(this.keyword)){
							//if(this.products_list[0].code==parseInt(this.keyword)){
								this.agregarProductoCheck(this.searchResults[0], 0);
							/*}else{
								Swal.fire({
									position: 'top-center',
									icon: 'warning',
									title: '¡No existe producto con ese codigo!',
									showConfirmButton: false,
									timer: 800
								});
							}*/
							
						}else{
							this.agregarProductoCheck(this.searchResults[0], 0)
						}
					}else{
						console.log('solo debe tener un producto en la lista para utilizar esta función');
					}
				}
			},
			actualizarMontos(index){
				const item 		= this.invoice.items[index];
				item.quantity 	= isNaN(parseFloat(item.quantity)) ? 0 : parseFloat(item.quantity);
				item.price 		= isNaN(parseFloat(item.price)) ? 0 : parseFloat(item.price);
				item.discount 	= isNaN(parseFloat(item.discount)) ? 0 : parseFloat(item.discount);
				item.total 		= (item.quantity * item.price) - item.discount;
				this.calculateTotals();
				
			},

			async getSucursales()
			{
				const res = await this.service.obtenerSucursales();
				this.sucursales = res.data
			},
			buscarMetodoPago(codigo)
			{
				return this.metodos_pago.find( mp => mp.codigoClasificador == codigo);
			},
			filterSinProducts(codigoActividad)
			{
				return this.tipos_productos.filter( tp => tp.codigoActividad == codigoActividad );
			},
			addItem(e, prod, cantidad_producto)
			{
				e ? e.preventDefault() : null;
				if( this.keyword.trim().length <= 0 )
					return false;
					
				let item_name = this.keyword;
				if( this.itemfound )
				{
					item_name = this.itemfound;
				}
				let found = this.invoice.items.find( item => prod && item.product_id == prod.id);
				if( typeof(found) != 'undefined' )
				{
					found.quantity++;
					found.total = (found.price * found.quantity) - found.discount;
				}
				else
				{
					this.invoice.items.push(
						{
							item_id: 0,
							invoice_id: 0,
							product_id: prod ? prod.id : 0,
							product_code: prod ? prod.code : '',
							product_name: prod ? prod.name : item_name,
							price: prod ? prod.price : 0,
							quantity: cantidad_producto,
							total: prod ? prod.price * cantidad_producto : 0,
							unidad_medida: prod ? prod.unidad_medida : 58,
							numero_serie: prod ? prod.numserie : '',
							imei: prod ? prod.imei : '',
							codigo_producto_sin: prod ? prod.codigo_sin : '',
							codigo_actividad: prod ? prod.codigo_actividad : '',
							discount: 0,
							data: {custom_fields: {}}
						}
					);
				}
				
				this.keyword = '';
				this.calculateTotals();
			},
			removeItem(index)
			{
				this.invoice.items.splice(index, 1);
				this.calculateTotals();
			},
			calculateTotals()
			{
				let total = 0;
				for(let item of this.invoice.items)
				{
					total += item.total;
				}
				this.invoice.subtotal = total;
				this.invoice.total = this.invoice.subtotal - this.invoice.discount - this.invoice.monto_giftcard;
				if( [6, 8, 28].indexOf(this.invoice.codigo_documento_sector) == -1 )
					this.invoice.total_tax = this.invoice.total * 0.13;
				else
					this.invoice.total_tax = 0;
			},
			editItem(index)
			{
				this.item_edit = index;
			},
			saveItem(index)
			{
				const item 		= this.invoice.items[index];
				item.quantity 	= isNaN(parseFloat(item.quantity)) ? 0 : parseFloat(item.quantity);
				item.price 		= isNaN(parseFloat(item.price)) ? 0 : parseFloat(item.price);
				item.discount 	= isNaN(parseFloat(item.discount)) ? 0 : parseFloat(item.discount);
				item.total 		= (item.quantity * item.price) - item.discount;
				this.calculateTotals();
				this.item_edit = -1;
			},
			async getPuntosVenta()
			{
				const res = await this.service.obtenerPuntosVenta();
				this.puntosventa = res.data;
			},
			async tiposProductos()
			{
				const res = await this.service.obtenerProductosServicios();
				this.tipos_productos = res.data.RespuestaListaProductos.listaCodigos;
			},
			async getUnidadesMedida()
			{
				const res = await this.service.obtenerUnidadesMedida();
				this.unidadesMedida = res.data.RespuestaListaParametricas.listaCodigos;	
			},
			async getMonedas()
			{
				const res = await this.service.obtenerMonedas();
				this.monedas = res.data.RespuestaListaParametricas.listaCodigos;	
			},
			async getTiposDocumentosIdentidad()
			{
				const res = await this.service.obtenerDocumentosIdentidad();
				this.tipos_documentos = res.data.RespuestaListaParametricas.listaCodigos;	
			},
			async getMetodosPago()
			{
				const res = await this.service.obtenerMetodosPago();
				//this.metodos_pago = res.data.RespuestaListaParametricas.listaCodigos;
				this.metodos_pago = [];
				for(let pm of res.data.RespuestaListaParametricas.listaCodigos)
				{
					if(pm.codigoClasificador==1 || pm.codigoClasificador==2 || pm.codigoClasificador==3 || pm.codigoClasificador==8
						|| pm.codigoClasificador==10 || pm.codigoClasificador==11 || pm.codigoClasificador==14 || pm.codigoClasificador==16 || pm.codigoClasificador==19
						|| pm.codigoClasificador==47 || pm.codigoClasificador==84 || pm.codigoClasificador==92 || pm.codigoClasificador==136){
						if( this.allow_payment_methods.length > 0 && this.allow_payment_methods.indexOf(pm.codigoClasificador) != -1 )
							this.metodos_pago.push( pm );
						else
							this.metodos_pago.push( pm );
					}
				}		
			},
			async getListaActividades()
			{
				const res = await this.service.obtenerActividades();
				this.lista_actividades = Array.isArray(res.data.RespuestaListaActividades.listaActividades) ?
					res.data.RespuestaListaActividades.listaActividades : [res.data.RespuestaListaActividades.listaActividades];
				if( this.lista_actividades.length > 0 )
					this.actividad_economica = this.lista_actividades[0].codigoCaeb;
					
			},
			crearCliente()
			{
				this.$refs.customer_form.showModal();
				
			},
			buscarCliente(by)
			{
				if( this.searchTimeout )
					clearTimeout(this.searchTimeout);
				let keyword = '';
				if( by == 'customer' )
					keyword = this.keyword_customer;
				else 
					keyword = this.keyword_nit;
				if( keyword.trim().length <= 0 )
					return;
				this.searchTimeout = setTimeout(async () => 
				{
					try
					{
						const res = await this.serviceCustomers.search(keyword);
						this.customers_list = res.data;
						this.customers_list=(this.cliente_seleccionado==this.keyword_customer)? []:this.customers_list;
						
					}
					catch(e)
					{
						console.log(e);
					}
				}, 500);
			},
			selectCustomer(item, index)
			{
				this.currentCustomer 	= item;
				this.keyword_customer	= '';
				this.invoice.tipo_documento_identidad=item.identity_document;
				if( item.first_name || item.firstname )
					this.keyword_customer = item.first_name || item.firstname;
				if( item.last_name )
					this.keyword_customer += item.first_name ? ` ${item.last_name}` : item.last_name;
				if( item.lastname )
					this.keyword_customer += item.firstname ? ` ${item.lastname}` : item.lastname;
				this.keyword_nit 		= item.tax_number || item.nit_ruc_nif; //item.meta && item.meta._nit_ruc_nif ? item.meta._nit_ruc_nif : '';
				this.searchResultsClientes 	= [];
			},
			buscarProducto(by)
			{
				if( this.searchProdTimeout )
					clearTimeout(this.searchProdTimeout);
				let keyword = this.keyword;
				if( keyword.trim().length <= 0 )
					return;
				this.searchProdTimeout = setTimeout(async () => 
				{
					try
					{
						const res = await this.service.buscarProducto(keyword);
						this.products_list = res.data;
						
					}
					catch(e)
					{
						console.log(e);
					}
				}, 500);
			},
			selectProduct(item, index)
			{
				//item.price = isNaN(parseFloat(item.price.toString())) ? 0 : parseFloat(item.price.toString());
				this.addItem(null, item, index);
				this.products_list = [];
			},
		
			async save()
			{
				this.closeModal(this.modalExcepcion);
				this.closeModal(this.modalDatosTarjeta);
				this.$refs.forminvoice.classList.remove('was-validated');
				this.$refs.formtarjeta.classList.remove('was-validated');
				try
				{
					this.closeModal(this.modalDatosTarjeta);
					if( !this.$refs.forminvoice.checkValidity() )
					{
						this.$refs.forminvoice.classList.add('was-validated');
						return;
					}
					if( this.currentCustomer == null || this.currentCustomer.customer_id <= 0 )
						throw {error: 'Debe seleccionar un cliente para la factura'};
					if( this.invoice.items.length <= 0 )
						throw {error: 'Debe adicionar almenos un item a la factura'};
						
					if( this.activeEvent && [5, 6, 7].indexOf( parseInt(this.activeEvent.evento_id) ) != -1)
					{
						if( !this.$refs.fecha )
							throw {error: 'Debe seleccionar la fecha de la factura'};
						if( !this.$refs.hora )
							throw {error: 'Debe seleccionar la hora de la factura'};
						if( !this.invoice.data.nro_factura )
							throw {error: 'Debe ingresar el numero de factura'};
							
						this.invoice.invoice_date_time = new Date(`${this.$refs.fecha.value} ${ this.$refs.hora.value}`);
						//this.evento.fecha_inicio.setSeconds((new Date()).getSeconds());
					}
					
					if( [6, 16].indexOf(this.invoice.codigo_documento_sector) != -1 )
					{
						this.invoice.data.custom_fields['fechaIngresoHospedaje'] = this.$refs.headercom.getFechaHoraIngreso();
					}
					//if( this.invoice.total <= 0 )
					//	throw {error: 'El monto de la factura no puede ser cero'};
					const metodo_pago = this.buscarMetodoPago(this.invoice.codigo_metodo_pago);
					if( metodo_pago.descripcion.toUpperCase().indexOf( 'TARJETA' ) != -1 ) 
					{
						// this.invoice.numero_tarjeta = this.$refs.inputcard.dataset.realvalue || null;
						this.invoice.numero_tarjeta = this.invoice.numero_tarjeta  || null;
						this.$refs.formtarjeta.classList.add('was-validated');
						if( !this.invoice.numero_tarjeta )
						{
							this.openModal(this.modalDatosTarjeta);
							return;
						}
						if( !this.$refs.formtarjeta.checkValidity() )
						{
							this.openModal(this.modalDatosTarjeta);
							throw {error: 'Datos de tarjeta invalidos'};
						}
					}
					this.invoice.customer_id 			= this.currentCustomer.id;
					this.invoice.customer				= this.keyword_customer;
					//this.invoice.customer 				= this.currentCustomer.name; //`${this.currentCustomer.first_name} ${this.currentCustomer.last_name}`;
					this.invoice.nit_ruc_nif 			= this.keyword_nit;
					this.invoice.actividad_economica	= this.actividad_economica;
					
					this.$root.$processing.show('Procesando factura...');
					const res = await this.service.crearFactura(this.invoice);
					//this.limpiarMetodosPago();
					//this.getMetodosPago();
				    
				    this.selectedMetodoPago(this.metodos_pago[7]);

					// para imprimir por el protocolo y comandas
					console.log('datos facturacion:', res.data);
					//esto deberia abrir y autocerra la pestaña del navegador
					window.open("print://" + res.data, '_self').close() 
					this.invoice.codigo_metodo_pago=1;
					
					if( res.data && res.data.id )
					{
						/*
						//this.openModal(this.modalImprimir);
						this.generatedInvoice = res.data;
						//this.generatedInvoice.print_url;
						//1=imprimir;2=ver
						//this.metodos_pago=[];
						
						this.invoice.codigo_metodo_pago=1;
						const url = this.generatedInvoice.print_url + '?tpl=rollo&opcion=1';
						
						axios.get(url)
						.then(function(response){
							console.log(response);
						})
						.catch(function(error){
							console.log(error);
						});
						// window.open(url, "_blank");

						setTimeout(()=>{
							this.imprimirPDF();
						},4000);
						// window.location.href = url;
						*/
					}
					else
					{
						this.$root.$toast.ShowSuccess('La factura fue generada correctamente');

					}
					this.activeEvent = null;
					await this.checkActiveEvent(this.invoice.codigo_sucursal, this.invoice.punto_venta);
					this.$root.$processing.hide();
					
					this.reset();
					const clienteSinNombre=this.buscarSinNombre('SIN NOMBRE');
					this.selectCustomer(clienteSinNombre, 0);
					

					
				}
				catch(e)
				{
					this.$root.$processing.hide();
					if( e.response == 'error_nit' )
						this.openModal(this.modalExcepcion);
					else
						this.$root.$toast.ShowError(e.error || e.message || 'Error desconocido');
				}
			},
			reset()
			{
				const pv = this.invoice.punto_venta;
				this.invoice = 	new SBFramework.Models.Invoice();
				this.invoice.codigo_documento_sector = null;
				this.invoice.codigo_documento_sector = this.current_doc_sector;
				this.invoice.punto_venta = pv;
				this.currentCustomer = {id: 0, customer_id: 0};
				this.$refs.inputcard.value = '';
				this.$refs.inputcard.dataset.realvalue = '';
				// Reseteamos los datos del cliente
				this.keyword_customer="";
				this.keyword_nit="";
			},
			controlTributario(val)
			{
				if( val == 'control_tributario' )
				{
					this.keyword_customer = 'Control Tributario';
					this.keyword_nit = 99002;
				}
				else if( val == 'ventas_menores' )
				{
					this.keyword_customer = 'Ventas Menores del Dia';
					this.keyword_nit = 99003;
				}
				else if( val == 'caso_especial' )
				{
					this.keyword_customer = '';
					this.keyword_nit = 99001; 
				}
				else
				{
					this.keyword_customer = '';
					this.keyword_nit = '';
				}
			},
			async searchProduct()
			{
				
			},
			setInputCardEvents()
			{
				this.$refs.inputcard.addEventListener('keydown', function(e)
				{
					if( e.keyCode == 8 )
						return true;
					if( this.dataset.realvalue && this.dataset.realvalue.length >= 16 || this.readOnly )
					{
						e.preventDefault();
						return false;
					}
					if( (e.keyCode >= 48 && e.keyCode <= 57 ) || e.keyCode == 8 )
						return true;
					e.preventDefault();
					return false;
				});
				this.$refs.inputcard.addEventListener('keyup', function(e)
				{
					if( typeof this.dataset.realvalue == 'undefined')
						this.dataset.realvalue = '';
					if( e.keyCode == 8 && this.dataset.realvalue )
					{
						this.dataset.realvalue = this.dataset.realvalue.substring(0, this.dataset.realvalue.length - 1);
						return true;
					}
					if( this.dataset.realvalue && this.dataset.realvalue.length >= 16 )
					{
						return false;
					}
					//console.log(e);
					if( !this.value || this.value.length <= 0 )
					{
						this.dataset.realvalue = '';
						return true;
					}
					
					//const lastChar = this.value.substr(-1);
					this.dataset.realvalue += this.value.substr(-1);
					this.value = '';
					
					for(let i in this.dataset.realvalue)
					{
						if( typeof i == 'undefined' || isNaN(i))
							continue;
						console.log('i -> ', i);
						if( i > 3 && i < 12 )
							this.value += '0';
						else
							this.value += this.dataset.realvalue[i];
					}
					
				});
			},
			showOps()
			{
				this.openModal(this.modalOps);
			}
		},
		async mounted()
		{
			const frame = (window.bootstrap || window.coreui);
			if( frame )
			{
				//this.modalCustomer 		= frame.Modal.getOrCreateInstance(this.$refs.modalcustomer);
				this.modalDatosTarjeta 	= frame.Modal.getOrCreateInstance(this.$refs.modaldatostarjeta);
				//this.modalCerrarEvento	= frame.Modal.getOrCreateInstance(this.$refs.modalcerrarevento);
				this.modalImprimir 		= frame.Modal.getOrCreateInstance(this.$refs.modalimprimir);
				this.modalExcepcion 	= frame.Modal.getOrCreateInstance(this.$refs.modalexcepcion);
				this.modalOps		 	= frame.Modal.getOrCreateInstance(this.$refs.modalops);
			}
			else
			{
				//this.modalCustomer 		= jQuery(this.$refs.modalcustomer);
				this.modalDatosTarjeta 	= jQuery(this.$refs.modaldatostarjeta);
				//this.modalCerrarEvento 	= jQuery(this.$refs.modalcerrarevento);
				this.modalImprimir 		= jQuery(this.$refs.modalimprimir);
				this.modalExcepcion 	= jQuery(this.$refs.modalexcepcion);
				this.modalOps		 	= jQuery(this.$refs.modalops);
			}
			//this.setInputCardEvents();
			//this.startInterval();
			let evt = new CustomEvent('invoicer_built', {detail: {com: this}});
			window.document.dispatchEvent(evt);
		},
		async created()
		{
			try
			{
				this.$root.$processing.show('Estableciendo datos...');
				await Promise.all([
					this.getSucursales(),
					this.getPuntosVenta(), 
					this.getUnidadesMedida(), 
					this.getMonedas(), 
					this.getTiposDocumentosIdentidad(),
					this.tiposProductos(),
					this.getMetodosPago(),
					this.getListaActividades(),
					this.cargarProductos(),
					this.cargarClientes(),
					
					//this.checkActiveEvent(),
					//this.checkOnlineStatus(),
				]);
				this.$root.$processing.hide();
				const clienteSinNombre=this.buscarSinNombre('SIN NOMBRE');
				this.selectCustomer(clienteSinNombre, 0);
				
				
			}
			catch(e)
			{
				this.$root.$processing.hide();
				console.log('ERROR', e);
			}
			
		}
	};
	SBFramework.AppComponents = {
		'siat-invoicer': ns.ComInvoicer, 
	};
})(SBFramework.Components.Siat);
