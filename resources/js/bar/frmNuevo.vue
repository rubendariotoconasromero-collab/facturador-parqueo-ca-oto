<template>
  <main class="main">
      <!-- <div class="container"> -->
          <div class="row">
              <div class="col">
              &nbsp;
                  <div class="card">
                  <div class="card-header text-center text-white" style="background-color: #3399FF"><h3 class="mb-0">FORMULARIO VENTA</h3></div>
                     <!-- Listado de Ventas -->
                      <template v-if="listado==0">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Ventas</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Buscador</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="card-body">
                                    <div class="form-group row" style='margin-left: 1%'>   
                                            <form class="row">
                                                <!-- <div class="col-md-6">
                                                    <label for="exampleInputPassword1" class="form-label">Fecha</label>
                                                    <input type="date" class="form-control"  v-model="datos.fecha">  
                                                </div> -->
                                                <div class="col-md-6">
                                                    <label for="exampleInputPassword1" class="form-label">CATEGORIAS</label>
                                                    <!-- <input type="text" class="form-control"  v-model="datos.cliente" disabled>   -->
                                                    <!-- <div class="row"> -->
                                                        <div class="input-group mb-6">
                                                            <select class="form-select" v-model="id_categoria" @change="listarArticulo(buscarP,criterio)" >
                                                                <option value="0" disabled>Categoria</option>
                                                                <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                                            </select>
                                                                &nbsp;&nbsp;
                                                                <input type="text" v-model="buscarP" @keyup.enter="listarArticulo(buscarP, criterio)"  @keyup="BuscandoArticulo()" class="form-control" placeholder="Buscar Productos">
                                                        </div>
                                                    <br>
                                                    <div class="col-sm-12">
                                                        <div class="form-group row" style='overflow-y: auto; height: 500px;'>
                                                            <div class="table-responsive" >
                                                                <table class="table table-striped table-hover" style='width:100%;margin-left: 0%;overflow-y: auto; height: 100px;'>
                                                                    <thead style="background-color: #46546C">
                                                                        <tr>                      
                                                                            <!-- <th scope="col" class="text-white">Imagen</th> -->
                                                                            <!-- <th scope="col" class="text-white">ID</th> -->
                                                                            <th scope="col" class="text-white">Producto</th>
                                                                            <th scope="col" class="text-white">Cantidad</th>
                                                                            <th scope="col" class="text-white">Precio</th>
                                                                            <th scope="col" class="text-white">Opcion</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody v-if="arrayArticulo.length">
                                                                        <tr v-for="(articulo,index) in arrayArticulo" :key="index">
                                                                            <!-- <td></td> -->
                                                                            <!-- <td></td> -->
                                                                            <template v-if="articulo.stock<=0">
                                                                                
                                                                                    <td v-text="articulo.nombre" style="background-color: #FFA07A"></td>
                                                                                    <!-- <td v-text="articulo.stock"></td> -->
                                                                                    <td v-text="articulo.stock" style="background-color: #FFA07A"></td>
                                                                                    <td v-text="articulo.costo_minorista" style="background-color: #FFA07A"></td>
                                                                                    <td style="background-color: #FFA07A">
                                                                                    <button type="button" @click="seleccionarTiendaArticulo(articulo, index)" class="btn btn-success btn-sm"><i class="fa fa-check text-white"></i></button>
                                                                                    </td>
                                                                                
                                                                            </template>
                                                                            <template v-else>
                                                                                <td v-text="articulo.nombre"></td>
                                                                                <td v-text="articulo.stock"></td>
                                                                                <td v-text="articulo.costo_minorista"></td>
                                                                                <td>
                                                                                <button type="button" @click="seleccionarTiendaArticulo(articulo, index)" class="btn btn-success btn-sm"><i class="fa fa-check text-white"></i></button>
                                                                                </td>
                                                                            </template>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tbody v-else>
                                                                        <tr>
                                                                            <td colspan="7">No hay Productos agregados</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="exampleInputPassword1" class="form-label">Clientes</label>
                                                                <div class="input-group mb-6">
                                                                    <!-- <div class="input-group mb-6">
                                                                        <select class="form-select" v-model="id_proveedor" @change="listarArticulo(buscarP,criterio)" >
                                                                            <option value="0" disabled>Cliente</option>
                                                                            <option v-for="proveedor in arrayProveedor" :key="proveedor.id" :value="proveedor.id" v-text="proveedor.nombre"></option>
                                                                        </select>
                                                                        &nbsp;&nbsp;
                                                                        <button type="button" @click="abrirModal('proveedor','registrar')" class="btn btn-info text-white"  style='margin-left: 1.2%'>
                                                                            <i class="icon-plus"></i>&nbsp;Nuevo
                                                                        </button>
                                                                    </div> -->
                                                                            <section class="dropdown-wrapper form-control">
                                                                                <div @click="ocultar()" class="selected-item">
                                                                                    <input type="text" class="form-control sinborde"
                                                                                        placeholder="Seleccione Cliente.." v-model="datos.proveedor"
                                                                                        aria-label="Buscar Clientes..">
                                                                                    <svg :class="isVisible ? 'dropdown' : ''" class="drop-down-icon"
                                                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                                                        height="24">
                                                                                        <path fill="none" d="M0 0h24v24H0z" />
                                                                                        <path d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z" />
                                                                                    </svg>
                                                                                </div>
                                                                                <div :class="isVisible  ? 'visible' : 'invisible'" class="dropdown-popover">
                                                                                    <div class="options">
                                                                                        <div class="text-center"><span
                                                                                                v-if="filteredCliente.length === 0">No
                                                                                                existen Clientes</span></div>
                                                                                        <ul>
                                                                                            <li @click="selectedCliente(proveedor)" v-for="(proveedor, index) in filteredCliente"
                                                                                                :key="`proveedor-${index}`">
                                                                                                {{proveedor.nombre}}</li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </section>
                                                                            &nbsp;&nbsp;
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="exampleInputPassword1" class="form-label">Forma Pago</label>
                                                                <div class="input-group">
                                                                    <select class="form-select" v-model="datos.moneda">
                                                                            <option value="0" disabled>Forma Pago</option>
                                                                            <option value="Ingresos">Ingresos</option>
                                                                            <option value="Egresos" >Egresos</option>
                                                                            <option value="Traspaso" >Traspaso</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <br>
                                                    <div class="form-group row" style='overflow-y: auto; height: 500px;'>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-hover" style='width:100%;margin-left: 0%'>
                                                                <thead style="background-color: #46546C">
                                                                    <tr>
                                                                        <th scope="col" class="text-white">Eliminar</th>
                                                                        <th scope="col" class="text-white">Producto</th>
                                                                        <th scope="col" class="text-white">Cantidad</th>
                                                                        <th scope="col" class="text-white">Precio</th>
                                                                        <th scope="col" class="text-white">Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody v-if="arrayDetalle.length">
                                                                    <tr v-for="(detalle,index) in arrayDetalle" :key="index">
                                                                        <td>
                                                                            <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white"></i></button>
                                                                        </td>
                                                                        <td v-text="detalle.articulo"></td>
                                                                        <td v-if="detalle.tipo_producto!='Servicio'">
                                                                            <input v-model="detalle.cantidad" type="number" value="3" class="form-control">
                                                                        </td>
                                                                        <td>
                                                                            <input  v-model="detalle.costo_minorista" type="number" value="3" class="form-control" >
                                                                        </td>
                                                                        <td>{{detalle.total = detalle.costo_minorista*detalle.stock}}</td>

                                                                    </tr>
                                                                    <tr style="background-color: #CEECF5">
                                                                        <td colspan="4" align="right"> <strong>Total:</strong> </td>
                                                                        <td>{{datos.sub_total = calcularSubTotal.toFixed(2)}} bs</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4" align="right"> <strong>Sub Total:</strong> </td>
                                                                        <td>{{datos.sub_total = calcularSubTotal.toFixed(2)}} bs</td> 
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4" align="right"> <strong>Descuento:</strong> </td>
                                                                        <td><vue-numeric v-model="datos.descuento" :precision="2" value="0" class="form-control" :max="parseFloat(datos.sub_total)"></vue-numeric></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4" align="right"> <strong>Total:</strong> </td>
                                                                        <td>{{datos.total = datos.sub_total- datos.descuento}} bs</td>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody v-else>
                                                                    <tr>
                                                                        <td colspan="7">No hay productos agregados</td>
                                                                    </tr>
                                                                </tbody>
                                                                
                                                            </table>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> 
                                        </div>
                                        &nbsp;
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end" style='width:96%;margin-left: 2.2%'>
                                            <button class="btn btn-outline-danger" type="button" @click="volverVentaListado()">Anular</button>
                                            <button class="btn btn-outline-secondary" type="button" @click="guardarVenta()">Nota</button>
                                            <button class="btn btn-outline-warning" type="button" @click="guardarVenta()">Adicionar Costo Extra</button>
                                            <button class="btn btn-outline-primary" type="button" @click="guardarVenta()">Guardar</button>
                                            <button class="btn btn-outline-success" type="button" @click="guardarVenta()">Registrar Venta</button>
                                        </div>
                                    </div>    
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                    <div class="card-body">
                            <div class="form-group row" style='margin-left: 1%'>
                            <div class="container">
                                <div class="row row-cols-2" >
                                    <div class="col">
                                    <form class="row row-cols-2 row-cols-md-2 g-2">
                                    <div class="col-md-12"><strong>CATEGORIAS</strong>
                                        <table class="table table-striped table-hover" style='width:96%;margin-left: 2.2%'>
                                            <div class="form-group row">
                                                <div class="row row-cols-2 row-cols-md-6 g-4 " style="overflow-y: auto; height: 218px;">
                                                        <div class="col" v-for="categoria in arrayCategoria" :key="categoria.id">
                                                            <div class="card">
                                                                <img :src="'img/producto/'+categoria.foto" class="card-img-top" alt="" width="50" height="100" @click="galProductos(categoria.id)">
                                                                <div class="card-footer"  style="font-size: 7px;">
                                                                    <p class="text-center"><strong>{{categoria.nombre}}</strong></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </table>
                                    </div>
                                    <div class="col-md-12"><strong>PRODUCTOS</strong>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" style='width:96%;margin-left: 2.2%'>
                                                <div class="form-group row">
                                                <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 510px;">
                                                    <div class="col" v-for="producto in arrayProducto" :key="producto.id">
                                                        <div class="card">
                                                            <img :src="'img/producto/'+producto.foto" class="card-img-top" alt="" width="25" height="120" @click="agregarProductoCheck3(producto)">
                                                            <div class="card-footer"  style="font-size: 0.7rem;">
                                                            <!-- <p class="text-center"><strong>{{producto.descripcion}}</strong></p> -->
                                                            <div class="text-center" style="font-size: 0.7rem;"><strong>{{producto.descripcion}}</strong></div>
                                                            <div class="text-center" style="font-size: 0.7rem;"><strong>Cat.: {{producto.categoria}}</strong></div>
                                                            <div class="text-center" style="font-size: 0.7rem;"><strong>Bs.: {{producto.precio}}</strong></div>
                                                            <template v-if="producto.id_tipo_producto==2">
                                                                <template v-if="producto.stock<=0">
                                                                        <span><div v-if="producto.estado==1" class="text-center" style="font-size: 0.7rem;"><strong class="badge bg-danger">Q.: {{Math.floor((producto.stock/producto.contenido_presentacion))}}</strong></div></span>
                                                                </template>
                                                                <template v-else>
                                                                    <span><div v-if="producto.estado==1" class="text-center" style="font-size: 0.7rem;"><strong>Q.: {{Math.floor((producto.stock/producto.contenido_presentacion))}}</strong></div></span>
                                                                </template>
                                                            </template>
                                                            <template v-if="producto.id_tipo_producto==3">
                                                                <template v-if="producto.stock<=0">
                                                                        <span><div v-if="producto.estado==1" class="text-center" style="font-size: 0.7rem;"><strong class="badge bg-danger">Q.: {{Math.floor((producto.stock/producto.contenido_presentacion))}}</strong></div></span>
                                                                </template>
                                                                <template v-else>
                                                                    <span><div v-if="producto.estado==1" class="text-center" style="font-size: 0.7rem;"><strong>Q.: {{Math.floor((producto.stock/producto.contenido_presentacion))}}</strong></div></span>
                                                                </template>
                                                            </template>
                                                            <template v-if=" producto.id_tipo_producto==5 || producto.stock<0">
                                                                    <span><div v-if="producto.estado==1" class="text-center" style="font-size: 0.7rem;"><strong class="badge bg-producto">Q.: -</strong></div></span>
                                                            </template>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </table>
                                </div>

                                    </div>
                                    </form>
                                    </div>
                                    <div class="col">
                                        <form class="row row-cols-2 row-cols-md-2 g-2">
                                    <div class="col-md-12 p-2">
                                    <!-- <div class="col-md-12 p-2 border border-black"> -->
                                        <div class="form-group row" style='margin-left:1%'>
                                            <form class="row" >
                                                <div class="col-md-6 pb-2 ">
                                                    <label for="exampleInputEmail1" class="form-label" style="font-size: 0.9rem;">Cliente</label>
                                                    <div class="input-group mb-6">
                                                                <section class="dropdown-wrapper form-control">
                                                                    <div @click="ocultar()" class="selected-item">
                                                                            <!-- <input v-if="buscarCliente==''" type="text" class="form-control" placeholder="Seleccione Cliente.."  v-model="buscarCliente" aria-label="Buscar Clientes.."> -->

                                                                            <input type="text" class="form-control sinborde" placeholder="Seleccione Cliente.." v-model="datos.cliente" aria-label="Buscar Clientes.." @keyup="guardarCliente()">

                                                                        <!-- <span v-if="datos.cliente==''">Seleccione Cliente</span>
                                                                        <span v-else>{{datos.cliente }}</span> -->
                                                                        <svg :class="isVisible ? 'dropdown' : ''" class="drop-down-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z"/></svg>
                                                                    </div>
                                                                    <div :class="isVisible  ? 'visible' : 'invisible'" class="dropdown-popover">
                                                                        <!-- <input type="text" class="form-control" placeholder="Buscar Clientes.."  v-model="buscarCliente" aria-label="Buscar Productos.."> -->
                                                                        <div class="text-center"><span v-if="filteredCliente.length === 0">No existen Clientes</span></div>
                                                                        <div class="options">
                                                                            <ul>
                                                                                <li @click="selectedCliente(cliente)" v-for="(cliente, index) in filteredCliente" :key="`cliente-${index}`">{{cliente.nombre}}</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <!-- &nbsp;&nbsp;&nbsp;
                                                                <button type="button" class="btn btn-info text-white position-relative" data-bs-toggle="modal" data-bs-target="#modalCliente" @click="listarCliente(buscarP)" :disabled="isDisabledCliente"><i class="fa fa-search"></i> Agregar Clientes</button> -->
                                                            </div>
                                                </div>
                                                    <div class="col-md-6 pb-2">
                                                        <div>
                                                        <label for="exampleInputPassword1" class="form-label" style="font-size: 0.9rem;">Tipo Pago</label>
                                                        </div>
                                                        <div>
                                                            <select class="form-select" v-model="datos.id_tipo_pago" disabled>
                                                                <option value="0"  style="font-size: 0.9rem;">Seleccione el Tipo Pago</option>
                                                                <option v-for="tipo_pago in arrayPago" :key="tipo_pago.id" :value="tipo_pago.id" v-text="tipo_pago.nombre" ></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" v-if="datos.id_tipo_pago == 2">
                                                    <div>
                                                        <label for="exampleInputPassword1" class="form-label" style="font-size: 0.9rem">Fecha Final</label>
                                                    </div>
                                                    <div>
                                                        <input type="date" class="form-control"  v-model="datosPago.fecha_final">
                                                    </div>
                                                    </div>
                                                    <div class="col-md-6" v-if="datos.id_tipo_pago == 1">
                                                    <div>
                                                        <label for="exampleInputPassword1" class="form-label" style="font-size: 0.9rem">Forma Pago</label>
                                                        </div>


                                                            <select class="form-select" v-model="datos.id_forma_pago">
                                                                <option value="0" disabled>Seleccione la Forma de Pago</option>
                                                                <option v-for="forma_pago in arrayForma2" :key="forma_pago.id" :value="forma_pago.id" v-text="forma_pago.nombre"></option>
                                                            </select>


                                                    </div>
                                                    <div class="col-md-6">
                                                    </div>&nbsp;
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" v-model="datos.observacion" rows="2" placeholder="Descripcion"></textarea>
                                                    </div>
                                                </form>
                                                <div class="col-md-12">
                                                    <div v-show="errorPago" class="form-group row div-error">
                                                        <div class="text-center text-error">
                                                            <div v-for="error in errorMostrarMsjPago" :key="error" v-text="error">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                    <div class="col-md-12" >
                                        <div class="form-group row" style="overflow-y: auto; height: 510px;">
                                        <div class="table-responsive p-2">
                                        <table class="table table-striped table-hover" style='width:96%;margin-left: 2%'>
                                            <thead style="background-color: #46546C">
                                                <th scope="col" class="text-white" style="font-size: 1rem;" >Eliminar</th>
                                                <th scope="col" class="text-white" style="font-size: 0.9rem; " width="15%">Producto</th>
                                                <th scope="col" class="text-white" style="font-size: 0.9rem;" width="15%">Costo</th>
                                                <th scope="col" class="text-white" style="font-size: 0.9rem;">Cantidad</th>
                                                <th scope="col" class="text-white" style="font-size: 0.9rem;">SubTotal</th>
                                            </thead>
                                            <tbody v-if="arrayDetalle.length">
                                                <tr v-for="(detalle,index) in arrayDetalle" :key="index">
                                                    <template v-if="detalle.id_tipo_producto == 5">
                                                    <td>
                                                        <button @click="eliminarDetalle(index),encuentraProductoCombo2Delete(detalle.id_articulo)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white" ></i></button>
                                                    </td>
                                                    </template>
                                                    <template v-else>
                                                    <td>
                                                        <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white" ></i></button>
                                                    </td>
                                                    </template>
                                                    <td v-text="detalle.articulo" style="font-size: 0.8rem;vertical-align: top"></td>
                                                    <td style="font-size: 0.8rem;">
                                                        {{detalle.costo_venta = isNaN(detalle.costo_venta)? 0 : parseFloat(detalle.costo_venta).toFixed(2)}}
                                                    </td>

                                                    <td >

                                                        <div>
                                                        <template v-if="detalle.Estado == 0">
                                                            <input v-model="detalle.cantidad" type="number"  value="3" class="form-control"  min="0" style="font-size: 0.8rem" @keyup="contadorStock(detalle)" disabled>
                                                        </template>
                                                        <template v-else>
                                                            <input v-model="detalle.cantidad" type="number"  value="3" class="form-control"  min="0" style="font-size: 0.8rem" @keyup="contadorStock(detalle)">
                                                        </template>
                                                        </div>
                                                        <span style="color:red;font-size: 0.4rem;vertical-align: top;" v-show="detalle.descuento_stock>parseFloat(detalle.stock)" >Stock: {{detalle.stock}} </span>
                                                    </td>
                                                    <td style="font-size: 0.8rem">
                                                        {{detalle.sub_total = (isNaN(detalle.costo_venta*detalle.cantidad))? 0 : (detalle.costo_venta*detalle.cantidad).toFixed(2)}}
                                                    </td>
                                                    </tr>
                                                <tr style="background-color: #e5f5fd">
                                                    <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Sub Total:</strong> </td>
                                                    <td style="font-size: 0.8rem;">{{datos.sub_total = isNaN(calcularSubTotal) ? 0 : calcularSubTotal.toFixed(2)}} bs</td>
                                                </tr>
                                                <tr style="background-color: #e5f5fd">
                                                    <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Descuento:</strong> </td>
                                                    <td style="font-size: 0.8rem;">
                                                        <input v-model="datos.descuento" type="number" min="0" value="0" class="form-control" >
                                                    </td>
                                                </tr>
                                                <tr style="background-color: #e5f5fd">
                                                    <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Total:</strong> </td>
                                                    <td style="font-size: 0.8rem;">{{datos.total = datos.sub_total- datos.descuento}} bs</td>
                                                </tr>
                                                <template v-if="datos.id_forma_pago ==6">
                                                        <tr style="background-color: #CEECF5">
                                                            <td colspan="4" align="right"  style="font-size: 0.8rem;"> <strong>Total Efect.:</strong> </td>
                                                            <td>
                                                                <input v-model="datos.total_efectivo" value="0" class="form-control"  style="font-size: 0.8rem;">
                                                            </td>
                                                        </tr>
                                                        <tr style="background-color: #CEECF5">
                                                            <td colspan="4" align="right"  style="font-size: 0.8rem;"> <strong>Total Dep.:</strong> </td>
                                                            <td  style="font-size: 0.8rem;">{{datos.total_deposito = datos.total- datos.total_efectivo}} bs</td>
                                                        </tr>
                                                        <tr style="background-color: #FF6775">
                                                            <td colspan="4" align="right" class="text-white"> <strong>Efectivo:</strong> </td>
                                                            <td>
                                                                <input v-model="datos.efectivo" value="0" class="form-control" min="0">
                                                            </td>
                                                        </tr>
                                                        <tr style="background-color: #FF6775">
                                                            <td colspan="4" align="right" class="text-white"> <strong>Cambio:</strong> </td>
                                                            <template v-if="datos.efectivo != 0">
                                                                <td class="text-white"> {{datos.cambio = datos.efectivo- datos.total_efectivo}} bs</td>
                                                            </template>
                                                            <template v-else>
                                                                <td class="text-white">{{datos.cambio = datos.efectivo- 0}}</td>
                                                            </template>
                                                        </tr>
                                                </template>
                                                <template v-else>
                                                        <tr style="background-color: #FF6775">
                                                            <td colspan="4" align="right" class="text-white"> <strong>Efectivo:</strong> </td>
                                                            <td>
                                                                <input v-model="datos.efectivo"  value="0" min="0" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr style="background-color: #FF6775">
                                                            <td colspan="4" align="right" class="text-white"> <strong>Cambio:</strong> </td>
                                                            <template v-if="datos.efectivo != 0">
                                                                <td class="text-white"> {{datos.cambio = datos.efectivo- datos.total}} bs</td>
                                                            </template>
                                                            <template v-else>
                                                                <td class="text-white">{{datos.cambio = datos.efectivo- 0}}</td>
                                                            </template>
                                                        </tr>
                                                </template>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="5" style="font-size: 0.8rem;">No hay Producto agregados</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>


                                    </div>

                                    </form>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end p-2" style="width:96%;margin-left: 2.2%">
                                            <button class="btn bg-info text-white" type="button" @click="guardarVentaDirecta()">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                                </div>

                                </div>
                            </div>
                            <!--Inicio del modal agregar/actualizar-->
                            <div class="modal fade" tabindex="-1" :class="{'mostrar' :modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header btn btn-info text-white">
                                            <h4 class="modal-title" v-text="tituloModal"></h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cerrarModal()"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                <div class="row" :class="erroresPersonal.nombre ? 'mb-1' : 'mb-3'">
                                                    <label for="inputPassword" class="col-sm-2 col-form-label" >Nombre</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" v-model="datos.nombre" placeholder="Ingrese El Nombre"></div>
                                                </div>

                                                <div class="row mb-2" v-if="erroresPersonal.nombre">
                                                    <div class="col-sm-2">&nbsp;</div>
                                                    <div class="col-sm-10"><span class="text-danger">{{erroresPersonal.nombre[0]}}</span></div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputPassword" class="col-sm-2 col-form-label">Nit</label>
                                                    <div class="col-sm-10"><input type="number" class="form-control" v-model="datos.nit"></div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputPassword" class="col-sm-2 col-form-label">Contacto</label>
                                                    <div class="col-sm-10"><input type="number" class="form-control" v-model="datos.contacto"></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputPassword" class="col-sm-2 col-form-label">Direccion</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" v-model="datos.direccion"></div>
                                                </div>
                                                <!-- <div class="row" :class="erroresPersonal.id_departamento ? 'mb-2' : 'mb-3'">
                                                    <label for="inputPassword" class="col-sm-2 col-form-label">Moneda</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-select" v-model="datos.moneda">
                                                            <option value="0" disabled>Seleccione Moneda</option>
                                                            <option value="Bolivianos">Bolivianos</option>
                                                            <option value="Dolares" >Dolares</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="row mb-3">
                                                    <label for="inputPassword" class="col-sm-2 col-form-label">Telefono</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" v-model="datos.telefono"></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputPassword" class="col-sm-2 col-form-label">Descripcion</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" v-model="datos.descripcion"></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputPassword" class="col-sm-2 col-form-label">Estado</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" v-model="datos.estado">
                                                            <label class="form-check-label" for="inlineRadio1">Activo</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="0" v-model="datos.estado">
                                                            <label class="form-check-label" for="inlineRadio2">Inactivo</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-show="errorPersonal" class="form-group row div-error">
                                                    <div class="text-center text-error">
                                                        <div v-for="error in errorMostrarMsjPersonal" :key="error" v-text="error">

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger text-white" @click="cerrarModal()">Cerrar</button>
                                            <button type="button" v-if="tipoAccion==1" class="btn btn-info text-white" @click="guardarEntidad()">Guardar</button>
                                            <button type="button" v-if="tipoAccion==2" class="btn btn-info text-white" @click="modificarEntidad()">Modificar</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!--Fin del modal--> 
                      </template>
                      <!-- Fin Listado de Ventas -->
                  </div>
              </div>
          </div>
      <!-- </div>   -->
  </main>
</template>

<script>
  import Swal from 'sweetalert2';
  import moment from 'moment';
  export default {
      created() {
          this.datos.costo_pago = 1;
      },
      data(){
          return {
              datos : {
                  id : 0,
                  fecha :  moment().format('YYYY-MM-DD'),
                  prox_fecha : moment().format('YYYY-MM-DD'),
                  sub_total : 0,
                  descuento : 0,
                  total : 0,
                  id_tipo_pago : 1,
                  id_forma_pago : 2,
                  id_paciente : 0,
                  id_proveedor : 0,
                  id_animal : 0,
                  animal : '',
                  proveedor : '',
                //   cliente : '',
                  edad : 0,
                  paciente : '',
                  tipoPago : '',
                  formaPago : '',
                  costo_pago : '',
                  id_descuento: '',
                  personal:'',
                  estado: '',
                  tipo_venta: 'Venta Directa',
                  id_orden_servicio: null,
                  mes: 0,
                  fecha_actual : moment().format('YYYY-MM-DD'),
              },
              datosPago:{
                  id: 0,
                  fecha :  moment().format('YYYY-MM-DD'),
                  fecha_final :  moment().format('YYYY-MM-DD'),
                  //monto_total: 0,
                  saldo : 0,
                  anticipo : 0,
                  descripcion: '',
                  
              },   
              edad2 :0,
              arrayVenta : [],
              arrayDetalle : [],
              arrayArticulo : [],
              arrayDetalleProducto : [],
              arrayProductoPaquete: [],
              //arrayDetallePaqueteProducto : [],
              arrayCliente: [],
              arrayCategoria:[],
              arrayProveedor:[],
              arrayCostoPago: [{id:1,nombre:'Unitario'},{id:2,nombre:'Mayorista'},{id:3,nombre:'Preferencial'}],
              arrayTipoCliente: [],
              arrayPersonal: [],
              arrayPago: [],
              arrayForma: [],
              arrayForma2: [],
              arrayOrden : [],  
              arrayPaquete : [],  
              listado : 0,
              modal : 0,
              tituloModal : '',
              errorPersonal : 0,
              errorMostrarMsjPersonal : [],
              erroresPersonal: {},
              tipoAccion : 0,
              errorPago : 0,
              errorMostrarMsjPago : [],
              pagination : {
                  'total' : 0,
                  'current_page' : 0,
                  'per_page' : 0,
                  'last_page' : 0,
                  'from' : 0,
                  'to' : 0,
              },
              offset : 3,
              criterioP : 'articulo.nombre_comercial',
              criterio : 'articulo.nombre',
              buscar : '',
            //   buscarCliente: '',
              cliente: '',
            //   proveedor : '',
              buscarP : '',
              buscarProveedor: '',
              isDisabled: true,
              isDisabledCliente: false,
              isDisabledProducto: false,
              isDisabledOrden: false,
              isDisabledPaquete: false,
              setTimeoutBuscador: '',
              isVisible: false,
              id_categoria: 0,
              id_proveedor: 0,
              buscarPaciente: '',
              estadoCaja: '',
              listadoVenta: 0,
              is_busy:0,
          }
      },
      computed : {
          isActived: function(){
              return this.pagination.current_page;
          },
          pagesNumber: function(){
              if(!this.pagination.to){
                  return [];
              }                
              var from = this.pagination.current_page - this.offset;
              if(from < 1){
                  from = 1;
              }
              var to = from + (this.offset * 2);
              if(to >= this.pagination.last_page){
                  to = this.pagination.last_page;
              }
              var pagesArray = [];
              while(from <= to){
                  pagesArray.push(from);
                  from++;
              }
              return pagesArray;
          },
          calcularSubTotal1: function(){
              var resultado = 0.0;
              if(this.datos.tipo_venta=='Venta Directa') {
                  for(var i=0;i<this.arrayDetalle.length;i++){

                      resultado = resultado + (this.arrayDetalle[i].costo_minorista*this.arrayDetalle[i].cantidad);
                  }
              } else {
                  for(var i=0;i<this.arrayDetalle.length;i++){
                      resultado = resultado + (this.arrayDetalle[i].costo_minorista*this.arrayDetalle[i].cantidad);
                  }
              }
              
              return resultado;
          },
          calcularSubTotal: function(){
                var resultado = 0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                     resultado = resultado + (this.arrayDetalle[i].costo_minorista*this.arrayDetalle[i].stock);

                }
                return resultado;
            },
          calcularSaldoAnticipado: function(){
              this.datosPago.saldo = this.datos.total - this.datosPago.anticipo;
          },
          filteredCliente(){
                const data = this.datos.proveedor.toLowerCase();
                if(this.datos.proveedor == ""){
                    return this.arrayProveedor;
                }
                return this.arrayProveedor.filter((item)=>{
                    return Object.values(item).some((word=>String(word).toLowerCase().includes(data)))
                })
            }

          // actualizarStockProducto(id,cantidad,paquete){
          //     let me = this;

          //     if(paquete == 'Venta Paquete'){
          //         me.arrayProductoPaquete.forEach(item => { item.id_paquete == id ? item.cantidad = item.cantidad*cantidad : ''});
          //     }
              
          // },
      },
      
      methods : {
        ocultar() {
                this.isVisible = !(this.isVisible);
                setTimeout(() => {
                    this.isVisible = false;
                }, 10000);
            },
        selectedCliente(proveedor){
                this.datos.proveedor='';
                this.datos.id_proveedor=0;
                // this.datos.id_descuento='';
                this.isVisible = false;
                this.datos.proveedor = proveedor.nombre;
                this.datos.id_proveedor = proveedor.id;
                // this.datos.id_descuento = cliente.descuento;
            },
        encuentraDelete(id){
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id_articulo==id){
                        this.eliminarDetalle(i);
                        
                        //this.galProductos(this.id_categoria);
                    }
                }
            },
        agregarProductoCheck(data=[]){
                let me = this;
                // if(data['id_tipo_producto'] == 5){
                //     me.encuentraDelete(data['Id_Producto'])
                // }
                // me.encuentraProductoSimpleDelete(data['Id_Producto'])
                //me.encuentraProductoCombo2Delete(me.id_combo)
                //me.encuentraProductoCombo2Delete(data['Id_Producto'])
                //me.encuentraCombo(data['Id_Producto'])
                Swal.fire({
                    title: 'Ingrese la cantidad\n'+data['nombre']+'ㅤ \n'+data['costo_minorista']+' bs.',
                    // title: 'Mesa N. : '+me.datos.mesa+'\n'+'Ingrese la cantidad \n'+data['descripcion']+'\n'+data['precio']+' bs.',
                    
                    // title: 'Pedido N. : '+me.arrayContador[0].Correlativo+'\n'+'ㅤㅤ'+'Ingrese la cantidad ㅤㅤㅤ \n'+data['descripcion']+'ㅤ \n'+data['precio']+' bs.',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {
                        me.encuentraDelete(data['id_articulo'])
                    if(cant==0){
                        Swal.showValidationMessage(
                            `Cantidad no puede ser 0`
                        );
                        }else{
                            if(cant <0){
                                    Swal.showValidationMessage(
                                        `Cantidad no puede ser negativo`
                                    );
                                }else{
                                    if(cant == ''){
                                        Swal.showValidationMessage(
                                            `Cantidad esta Vacia`
                                        );
                                    }else{
                                        if((cant>parseInt(data['stock']) || cant=='')&& data['estado'] == 1 && data['id_tipo_producto'] != 5){
                                            Swal.showValidationMessage(
                                                `Cantidad invalida :)`
                                            )
                                        }else{
                                            if(data['id_tipo_producto'] == 5 ){
                                                me.agregarCombo2(data['Id_Producto'],cant);
                                                setTimeout(() => {

                                                if(me.arrayDetalleProductoCombo.find(seg => (parseFloat(seg.stock) - parseFloat(seg.cantidad) < 0))){

                                                        Swal.showValidationMessage(
                                                            `Cantidad invalida :)`
                                                        )
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error...',
                                                            text: 'No hay stock para el combo!'
                                                        })
                                                        setTimeout(() => {
                                                            //me.encuentraCombo(me.id_combo);
                                                            me.encuentraDelete(data['id_articulo'])
                                                            me.encuentraProductoCombo2Delete(data['id_articulo'])
                                                        }, "1000")

                                                        //me.arrayDetalleCombo=[];
                                                        //me.arrayDetalleProductoCombo=[];
                                                    }else{
                                                        //console.log(me.arrayDetalleProductoCombo)
                                                         //me.galProductos(me.id_categoria);

                                                        me.arrayDetalle.push({
                                                            id_tienda_articulo : data['Id_Producto'],
                                                            id_articulo : data['id_articulo'],
                                                            cantidad : parseFloat(cant),
                                                            cantidadAux : parseFloat(cant),
                                                            nombre : data['nombre'],
                                                            costo_minorista : data['costo_minorista'],
                                                            costo_unitario : data['precio'],
                                                            costo_venta : data['precio'],
                                                            //combo : data['Combo'],
                                                            preciov : 0,
                                                            stock : parseInt(data['stock']),
                                                            producto_venta: 'Venta Producto',
                                                            cantidad_presentacion : (cant*data['contenido_presentacion']),
                                                            id_producto_compuesto : data['id_producto_compuesto'],
                                                            id_tipo_producto : data['id_tipo_producto'],
 
                                                            //tipo_producto: data['tipo_producto']
                                                        });
                                                    }
                                                }, "700")


                                            }else{
                                                me.arrayDetalle.push({
                                                    id_tienda_articulo : data['Id_Producto'],
                                                    id_articulo : data['id_articulo'],
                                                    cantidad : parseFloat(cant),
                                                    cantidadAux : parseFloat(cant),
                                                    nombre : data['nombre'],
                                                    costo_minorista : data['costo_minorista'],
                                                    costo_unitario : data['precio'],
                                                    costo_venta : data['precio'],
                                                    //combo : data['Combo'],
                                                    preciov : 0,
                                                    stock : parseInt(data['stock']),
                                                    producto_venta: 'Venta Producto',
                                                    cantidad_presentacion : (cant*data['contenido_presentacion']),
                                                    id_producto_compuesto : data['id_producto_compuesto'],
                                                    id_tipo_producto : data['id_tipo_producto'],

                                                    //tipo_producto: data['tipo_producto']
                                                });
                                            }

                                        }
                                    }
                                }
                            }
                            
                            
                        // if(data['id_tipo_producto'] == 2){
                        //     me.agregarProductoElaborado(data['Id_Producto'],cant);
                        //     //me.galProductos2(me.id_categoria,cant);
                        // }
                        // if(data['id_tipo_producto'] == 3){
                        //     me.agregarProductoSimple(data['Id_Producto'],cant);
                        // }
                        // if(data['id_tipo_producto'] == 4){
                        //     me.agregarProductoCompuesto(data['id_producto_compuesto'],cant,data['contenido_presentacion']);
                        // }
                        // if(data['id_tipo_producto'] == 5){
                        //     me.agregarCombo(data['Id_Producto'],cant);
                        // }

                    },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Producto agregado...',
                                showConfirmButton: false,
                                timer: 800
                            });
                            //console.log(me.arrayDetalleProductoCombo)
                        }
                    })
              // }
            },
        galProductos(id){
                let me = this;
                me.id_categoria = id;
                var url='/index_articulo?id_categoria='+ id;
                axios.get(url).then(function(response){
                    me.arrayArticulo = response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            
          cambiarDias(){
              let me = this;
              me.datos.edad = moment().add(me.datos.edad,'years').format('YYYY-MM-DD');
          },
          actualizarStockProducto(id,cantidad,paquete){
              let me = this;
              if(paquete == 'Venta Paquete'){ 
                  me.arrayProductoPaquete.forEach(
                      item => { 
                          item.id_paquete == id  && item.tipo_producto== 'Producto Venta'? item.cantidad_aux = item.cantidad*cantidad : '';
                      });
              }

          },
          verificarCaja(){
              let me = this;
              var url='/arqueo_caja/estado_caja';
              axios.get(url).then(function(response){
                  me.estadoCaja= response.data.estado;
              })
              .catch(function(error){
                  console.log(error);
              });
          },
          
          // listarArticulo(buscarP){
          //     let me = this;
          //     me.buscarPaciente= '';
          //     me.isVisible = false;
          //     var url='/tienda/listarSinPaginate2/tienda1?buscar=' + buscarP;
          //     axios.get(url).then(function(response){
          //         me.arrayArticulo= response.data;
          //     })
          //     .catch(function(error){
          //         console.log(error);
          //     });
          // },
          listarArticulo(buscarP, criterio){
                let me = this;
                var url='/index_articulo?buscar=' + buscarP + '&id_categoria=' + me.id_categoria + '&criterio=' + criterio;
                axios.get(url).then(function(response){
                    me.arrayArticulo= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            listarArticuloBusquedaRapida(){
                let me = this;
                var url='/index_articulo?buscar=' + me.buscarP + '&id_categoria=' + me.id_categoria + '&criterio=' + me.criterio;;
                axios.get(url).then(function(response){
                    me.arrayArticulo= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
          BuscandoProducto(){
              let me = this;
              clearTimeout(me.setTimeoutBuscador)
              me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida,350)
          },
          BuscandoArticulo(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me. listarArticuloBusquedaRapida,350)
            },
          listarCliente(buscarP){
              let me = this;
              me.buscarPaciente= '';
              me.isVisible = false;
              var url='/cliente/listarSinPaginate?buscar=' + buscarP;
              axios.get(url).then(function(response){
                  me.arrayTipoCliente= response.data;
              })
              .catch(function(error){
                  console.log(error);
              });
          },
          listarClienteBusquedaRapida(){
              let me = this;
              var url='/cliente/listarSinPaginate?buscar=' + me.buscarP;
              axios.get(url).then(function(response){
                  me.arrayTipoCliente= response.data;
              })
              .catch(function(error){
                  console.log(error);
              });
          },
          BuscandoCliente(){
              let me = this;
              clearTimeout(me.setTimeoutBuscador)
              me.setTimeoutBuscador = setTimeout(me.listarClienteBusquedaRapida,350)
          },
          selectedPaciente(paciente){
             
              //var fecha1 = new Date(paciente.edad).getTime();
              //var fecha2 = new Date(this.datos.fecha_actual).getTime();
              // console.log(paciente.edad);
              // console.log(this.datos.fecha_actual);
              
              //var cantidad_edad = (fecha2 - fecha1)/(1000*60*60*24*365);

              //var cantidad_entero = Math.floor((fecha2 - fecha1)/(1000*60*60*24*365));
              //var cantidad_meses = ((fecha2 - fecha1)/(1000*60*60*24*365*30)).toFixed(0);
              //var meses = ((cantidad_edad-cantidad_entero)*365)/30;
              // console.log(cantidad_entero);
              // console.log(cantidad_edad);
              // console.log(meses);




              // if(cantidad_edad.toFixed(0) == 0)
              // {
              //     var cantidad_meses = (fecha2 - fecha1)/(1000*60*60*24*30);
              // }

              this.datos.paciente='';
              this.datos.id_paciente=0;
              this.datos.id_animal='';
              this.isVisible = false;
              this.datos.paciente = paciente.nombre;
              this.datos.id_paciente = paciente.id;
              this.datos.id_animal = paciente.id_animal;
              this.datos.animal = paciente.animal;
              this.datos.edad = paciente.edad;
              this.datos.cliente = paciente.cliente;
              //this.datos.mes = meses.toFixed(0);
              this.datos.id_cliente = paciente.id_cliente;
          },
          listarOrden(buscarP){
              let me = this;
              me.buscarPaciente= '',
              me.isVisible = false;
              var url='/servicio/listarOrdenSinPaginate_tienda1?buscar=' + buscarP;
              axios.get(url).then(function(response){
                  me.arrayOrden= response.data;
              })
              .catch(function(error){
                  console.log(error);
              });
          },
          listarPaquete(buscarP){
              let me = this;
              me.buscarPaciente= '',
              me.isVisible = false;
              var url='/paquete/listarOrdenSinPaginate?buscar=' + buscarP;
              axios.get(url).then(function(response){
                  me.arrayPaquete= response.data;
              })
              .catch(function(error){
                  console.log(error);
              });
          },
          encuentra(id){
              var sw=0;
              for(var i=0;i<this.arrayDetalle.length;i++){
                  if(this.arrayDetalle[i].id_articulo==id ){
                      sw=true;
                  }
              }
              return sw;
          },
          encuentraPaquete(id){
              var sw=0;
              for(var i=0;i<this.arrayDetalle.length;i++){
                  if(this.arrayDetalle[i].id_paquete==id ){
                      sw=true;
                  }
              }
              return sw;
          },      
          eliminarDetalle(index){
              let me = this;
              me.arrayDetalle.splice(index,1);
          },         
          eliminarProductoPaquete(id){
              let array = [];
              array = this.arrayProductoPaquete.filter(item => item.id_paquete != id);
              this.arrayProductoPaquete = array;
          },       
        //   eliminarDetalle(index){
        //       let me = this;
        //       let id_paquete = 0;
        //       if(me.arrayDetalle[index].producto_venta=='Venta Paquete'){
        //           id_paquete = me.arrayDetalle[index].id_paquete;
        //           me.eliminarProductoPaquete(id_paquete);
        //       }
        //       me.arrayDetalle.splice(index,1);
        //   },
          seleccionarPaquete(data=[]){
              let me = this;
              if(me.encuentraPaquete(data['id'])){
                  Swal.fire({
                      icon: 'error',
                      title: 'Error...',
                      text: 'Este paquete ya se encuentra agregado!'
                  })
              }
              else{
                  
                  me.arrayDetalle.push({
                      //id_tienda_articulo : data['id'],
                      id_paquete : data['id'],
                      articulo : data['nombre'],
                      tienda : '',
                      costo_unitario : data['total'],
                      costo_mayorista : '',
                      costo_preferencial : '',
                      costo_compra : '',
                      marca : '',
                      id_categoria : '',
                      categoria : '',
                      stock : 1000,
                      cantidad : 1,
                      producto_venta: 'Venta Paquete'
                      //sub_total : data['sub_total'],
                  });
                  me.datos.estado= 'Entregado';
                  me.datos.tipo_venta= 'Venta Directa'
                  me.isDisabled = false;
                  me.isDisabledOrden = true;
                  //me.isDisabledPaquete = true;
                  Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Producto agregado...',
                      showConfirmButton: false,
                      timer: 500
                  });
              }
              this.cargarDetallePaquete(data['id']);

                  
          },
          async guardarEntidad(){
                try{
                        let me = this;
                        if(me.datos.nombre == 0 ){
                                me.validacionError('Registre el Nombre',3000);
                            }else
                        if(me.datos.nro_cuenta == 0  ){
                                me.validacionError('Registre Nro Cuenta',3000);
                            }else
                        if(me.datos.saldo == 0  ){
                                me.validacionError('Registre el Saldo',3000);
                            }else
                        if(me.datos.moneda == 0  ){
                                me.validacionError('Seleccione La Moneda',3000);
                            }else{
                                const res = await axios.post('/proveedor/guardar',this.datos);
                                if(res.data.error==0){
                                    //me.$toaster.error('Matricula ya existe...');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'El Entidad ya existe...',
                                        text: 'Debe usar otra entidad!'
                                    })
                                }
                                else{
                                    me.cerrarModal();
                                    // me.registrosEntidad();
                                    // me.listarEntidad(1, '', 'nombre');   
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Registro agregado...',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }  
                            }   
                }catch (error) {
                        if(error.response.data){
                            this.errores=error.response.data.errors;
                        }
                    }
            },
            async modificarEntidad(){
                try {
                    let me = this;
                    // console.log('prueba')
                    const res = await axios.put('/proveedor/modificar',this.datos);
                    if(res.data.error==0){
                        //me.$toaster.error('Matricula ya existe...');
                        Swal.fire({
                            icon: 'error',
                            title: 'El Entidad ya existe...',
                            text: 'Debe usar otra cargo!'
                        })
                    }
                    else{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Registro modificado...',
                            showConfirmButton: false,
                            timer: 1500
                        }) 
                        me.cerrarModal();
                        // me.listarEntidad(1,'', 'nombre');
                    }
                } catch (error) {
                    if(error.response.data){
                        this.errores=error.response.data.errors;
                    }
                }
            },
          precioVenta2(detalle)
            {
                var totalCantidad=0;
                var totalPrecio=0;
                this.arrayDetalle.forEach(element => {
                    if(element.id_articulo == detalle.id_articulo){
                        totalPrecio = parseFloat(element.costo_venta)* parseInt(element.stock)
                        if(isNaN(totalPrecio)){
                           totalPrecio=0;
                        }
                       element.total=totalPrecio;
                    }
                })
            },
          cargarDetallePaquete(id){
              let me = this;
              var url='/paquete/permiso/detalle?id=' + id;
              axios.get(url).then(function(response){
                  me.arrayDetalleProducto= response.data;
                  me.arrayDetalleProducto.forEach(
                  item => { 
                      item.cantidad_aux = item.cantidad*1;
                  });

                  if(me.arrayProductoPaquete.length==0){
                      me.arrayProductoPaquete = me.arrayDetalleProducto;
                  }else{
                      me.arrayProductoPaquete=me.arrayProductoPaquete.concat(me.arrayDetalleProducto);
                  }
                  
              })
              .catch(function(error){
                  console.log(error);
              });
          },
          
          cargarArticuloPaquete(){
              this.arrayProductoPaquete = this.arrayDetalleProducto;
              // me.arrayProductoPaquete.push({
              //     id_tienda_articulo : data['id'],
              //     id_articulo : data['id_articulo'],
              //     articulo : data['articulo'],
              //     tienda : data['tienda'],
              //     costo_unitario : data['costo_unitario'],
              //     costo_mayorista : data['costo_mayorista'],
              //     costo_preferencial : data['costo_preferencial'],
              //     costo_compra : data['costo_compra'],
              //     marca : data['marca'],
              //     id_categoria : data['id_categoria'],
              //     categoria : data['categoria'],
              //     stock : data['stock'],
              //     cantidad : 1,
              //     sub_total : data['sub_total'],
              // });
              
          },      
          seleccionarTiendaArticulo(data=[],index){
              let me = this;
              if(me.encuentra(data['id_articulo'])){
                  Swal.fire({
                      icon: 'error',
                      title: 'Error...',
                      text: 'Este producto ya se encuentra agregado!'
                  })
              }
              else{
                  me.arrayDetalle.push({
                      id_tienda_articulo : data['id'],
                      id_articulo : data['id_articulo'],
                      articulo : data['nombre'],
                      tienda : data['tienda'],
                      costo_minorista : data['costo_minorista'],
                    //   costo_mayorista : data['costo_mayorista'],
                    //   id_categoria : data['id_categoria'],
                    //   categoria : data['categoria'],
                      stock : data['stock'],
                      cantidad : 1,
                    //   sub_total : data['costo_unitario']*1,
                    //   total : data['costo_unitario'] *cantidad,
                      producto_venta: 'Venta Producto',
                      estado : 0,
                  });
                        me.datos.estado= 'Entregado';
                        me.datos.tipo_venta= 'Venta Directa'
                        me.arrayArticulo.splice(index,1);
                        me.isDisabled = false;
                        me.isDisabledOrden = true;
                        me.isDisabledPaquete = true;
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Producto agregado...',
                            showConfirmButton: false,
                            timer: 500
                        });
              }
              // me.calcularSubTotal();
              me.datos.sub_total = me.calcularSubTotal.toFixed(2);
              me.datos.total = me.datos.sub_total- me.datos.descuento
          },
          seleccionarCliente(data=[]){
              this.buscarPaciente= '',
              this.datos.id_cliente=data['id'];
              this.datos.cliente= data['nombre'];
              this.datos.id_descuento= data['descuento'];
          },
          volverVentaListado(){
              let me = this;
              me.is_busy=0;
              me.arrayDetalle = [];
              me.arrayArticulo = [];
              me.datos.cliente = '';
              me.datos.estado = '';
              me.datos.id_tipo_pago = 1,
              me.datos.id_forma_pago = 2,
              me.buscarP = '';
              me.listado = 0;
              me.isDisabledCliente = false;
              me.isDisabledProducto = false;
              me.isDisabledPaquete = false;
              me.isDisabledOrden = false;
              me.buscar = '';
              me.limpiarDatosVenta();
              me.selectProveedor();
          },
          volverVentaMenu(){
              this.listado = 0;
              this.selectProveedor();
              this.$emit('cerrarVentaTienda', this.listadoVenta);
          },
          selectCostoPago(){
              let me=this;
              var url='/articulo/selectPrecio';
              axios.get(url).then(function(response){
                  me.arrayCostoPago=response.data;
              })
              .catch(function(error){
                  console.log(error)
              });
          },
          selectCategoria(){
                let me=this;
                var url='/categoria/selectCategoria';
                axios.get(url).then(function(response){
                    me.arrayCategoria=response.data;
                    // me.listarArticulo(1,me.buscarP,me.criterio);
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            selectProveedor(){
                let me=this;
                var url='/proveedor/selectProveedor';
                axios.get(url).then(function(response){
                    me.arrayProveedor=response.data;
                    // me.listarArticulo(1,me.buscarP,me.criterio);
                })
                .catch(function(error){
                    console.log(error)
                });
            },
          selectCliente(){
              let me=this;
              var url='/paciente/selectPaciente';
              axios.get(url).then(function(response){
                  me.arrayCliente=response.data;
              })
              .catch(function(error){
                  console.log(error)
              });
          },
          selectTipoP(){
              let me=this;
              var url='/tipoPago/selectTipoP';
              axios.get(url).then(function(response){
                  me.arrayPago=response.data;
              })
              .catch(function(error){
                  console.log(error)
              });
          },
          selectFormaP(){
              let me=this;
              var url='/formaPago/selectFormaP';
              axios.get(url).then(function(response){
                  me.arrayForma=response.data;
                  me.arrayForma2 = response.data;
                  me.arrayForma2 = me.arrayForma2.filter((item) => item.id !== 1);
              })
              .catch(function(error){
                  console.log(error)
              });
          },
          verVenta(data=[]){
              let me = this;
              me.listado = 2;
              me.datos.id=data['id'];
              me.datos.cliente=data['cliente'];
              me.datos.fecha=data['fecha'];
              me.datos.descuento=data['descuento'];
              me.datos.tipoPago=data['tipoP'];
              me.datos.formaPago=data['formaP'];

              var url='/venta/permiso/detalle/tienda1?id=' + data['id'];
              axios.get(url).then(function(response){
                  me.arrayDetalle= response.data;
              })
              .catch(function(error){
                  console.log(error);
              });
          },
          guardarVenta(){
              if(this.arrayDetalle.length<=0){
                  Swal.fire({
                      icon: 'error',
                      title: 'Error...',
                      text: 'No Existe Productos agregados!'
                  })
              }
              if(this.datos.paciente == ''){
                  Swal.fire({
                      icon: 'error',
                      title: 'Error...',
                      text: 'Debe Agregar un Paciente!'
                  })
              } 
              if(this.arrayDetalle.find(seg => (seg.stock - seg.cantidad < 0 && this.datos.tipo_venta!='Venta Servicio'))){
                  Swal.fire({
                      icon: 'error',
                      title: 'Error...',
                      text: 'No hay stock para el producto!'
                  })
              } else {
                      if(this.datos.total < 0){
                          Swal.fire({
                              icon: 'error',
                              title: 'Error...',
                              text: 'El total no puedes ser Negativo!'
                          })
                      } else {
                          let me = this;
                          if(me.is_busy==0){
                              axios.post('/contro/vacuna/guardar',{
                                  //'id_servicio': me.datos.id,
                                  'fecha': me.datos.fecha,
                                  'prox_fecha': me.datos.prox_fecha,
                                  'fecha_final': me.datosPago.fecha_final,
                                  'edad': me.datos.edad,
                                  'sub_total': me.datos.sub_total,
                                  'descuento': me.datos.descuento,
                                  'total': me.datos.total,
                                  'estado': me.datos.estado,
                                  'id_paciente': me.datos.id_paciente,

                                  'id_cliente': me.datos.id_cliente,
                                  'id_tipo_pago': me.datos.id_tipo_pago,
                                  'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
                                  'id_costo_pago': me.datos.id_descuento,
                                  'detalle': me.arrayDetalle,
                                  'monto_total': me.datos.total,
                                  'descripcion_pago': me.datosPago.descripcion,
                                  'saldo': me.datosPago.saldo,
                                  
                                  'stock_producto_paquete': me.arrayProductoPaquete,
                              }).then(function(response){
                                  Swal.fire({
                                      position: 'top-end',
                                      icon: 'success',
                                      title: 'Control registrado exitosamente',
                                      showConfirmButton: false,
                                      timer: 1500
                                  });
                                  //me.cargarPdf2();
                                  me.volverVentaListado();
                                  me.limpiarDatosVenta();
                                  console.log(me.datos);
                              })
                              .catch(function(error){
                                  console.log(error);
                              });
                          }
                          me.is_busy=1;
                      }
                      
                  }
              
              
          },        
          validarCompra(){
              this.errorPago = 0;
              this.errorMostrarMsjPago = [];

              if(!this.datos.nombre) this.errorMostrarMsjPago.push("El nombre del Pago no puede estar vacio ");
              if(this.errorMostrarMsjPago.length) this.errorPago=1;
              return this.errorPago;
          },
          frmVenta(){
              this.listado = 1;
              this.selectProveedor();
              this.selectCliente();
              this.selectTipoP();
              this.selectFormaP();        
          },
          cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarArticulo(buscarP, criterio);
            },
          anularVenta(id){
              const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                      confirmButton: 'btn btn-success',
                      cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
              })

              swalWithBootstrapButtons.fire({
                  title: 'Esta seguro de Anular esta Compra??',
                  text: "Puede revertir esta decision!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Si, Habilitar!',
                  cancelButtonText: 'No, cancelar!',
                  reverseButtons: true
              }).then((result) => {
              if (result.isConfirmed) {
                  let me = this;
                  axios.put('/venta/anular1',{'id': id}).then(function (response) {
                      swalWithBootstrapButtons.fire(
                      'Habilitado!',
                      'Este compra se ha Anulado.',
                      'success'
                      )
                  }).catch(function (error) {
                      console.log(error);
                  });                    
              } else if (result.dismiss === Swal.DismissReason.cancel) {
                  swalWithBootstrapButtons.fire(
                  'Cancelado',
                  'Este categoria no ha tenido cambios :)',
                  'error'
                  )
              }
              })   
          },
          limpiarDatosVenta(){
              let me = this;
              me.datos = {
                  id : 0,
                  //fecha : moment().add(10,'days').format('YYYY-MM-DD'),
                  fecha :  moment().format('YYYY-MM-DD'),
                  prox_fecha : moment().format('YYYY-MM-DD'),
                  sub_total : 0,
                  descuento : 0,
                  total : 0,
                  id_tipo_pago : 1,
                  id_forma_pago : 2,
                  id_paciente : 0,
                  id_cliente : 0,
                  id_animal : 0,
                  animal : '',
                  edad : '',
                  paciente : '',
                  tipoPago : '',
                  formaPago : '',
                  costo_pago : '',
                  id_descuento: '',
                  personal:'',
                  estado: '',
                  tipo_venta: 'Venta Directa',
                  id_orden_servicio: null,
                  mes: 0,
                  
              }
              me.arrayOrden = [];
              me.arrayDetalle = [];
              me.isDisabledOrden = false;
              me.isDisabledCliente=false;
              me.isDisabledProducto=false;
              me.isDisabledPaquete=false;
              me.buscarP = '';
              me.buscar = '';
              me.buscarPaciente= '';
              me.isDisabled=false;
          },
          limpiarArticulo(){
              this.arrayArticulo = [];
              this.buscarP = '';
              this.buscar = '';
              this.arrayDetalle.forEach(item => item.saldoStock = 0);
          },
          limpiarCliente(){
              this.arrayTipoCliente = [];
              this.buscarP = '';
              this.buscar = '';
          },
          calcularSaldo() {
              this.datosPago.saldo = this.datos.total;
          },
          cerrarModalPago() {
              this.datosPago = this.anticipo;
          },
          seleccionarOrdenServicio(data=[]) {
              let me = this;
              me.datos.id=data['id'];
              me.datos.id_cliente=data['id_cliente'];
              me.datos.cliente=data['cliente'];
              me.datos.id_descuento=data['id_descuento'];
              me.datos.tipo_venta='Venta Servicio';
              me.datos.estado='Entregado';
              me.datos.descuento=data['descuento']

              var url='/servicio/permiso/detalle?id=' + data['id'];
              axios.get(url).then(function(response){
                  me.arrayDetalle= response.data;
              })
              .catch(function(error){
                  console.log(error);
              });

              me.isDisabledCliente=true;
              me.isDisabledProducto=true;
              me.isDisabledPaquete=true;
          },
          seleccionarPaquete2(data=[]) {
              let me = this;
              // me.datos.id=data['id'];
              // me.datos.id_cliente=data['id_cliente'];
              // me.datos.cliente=data['cliente'];
              // me.datos.id_descuento=data['id_descuento'];
              // me.datos.tipo_venta='Venta Servicio';
              me.datos.estado='Entregado';
              // me.datos.descuento=data['descuento']

              var url='/paquete/permiso/detalle?id=' + data['id'];
              axios.get(url).then(function(response){
                  me.arrayDetalle= response.data;
              })
              .catch(function(error){
                  console.log(error);
              });

              //me.isDisabledCliente=true;
              //me.isDisabledProducto=true;
              me.isDisabledOrden=true;
          },
          numericValidate(event) {
              const keyValidate = new RegExp('^[0-9]*$');
              const keysCaracter = ['Delete', 'Backspace', 'ArrowLeft', 'ArrowRight', 'KeyX', 'KeyC', 'KeyV', 'Home', 'End', 'Tab'];
              if (keysCaracter.includes(event.code)) {
                  switch (event.code) {
                  case 'KeyX':
                      if (!event.ctrlKey) {
                      event.preventDefault();
                      }
                      break;
                  case 'KeyC':
                      if (!event.ctrlKey) {
                      event.preventDefault();
                      }
                      break;
                  case 'KeyV':
                      if (!event.ctrlKey) {
                      event.preventDefault();
                      }
                      break;
                  default:
                      break;
                  }
                  return;
              }
              if (!keyValidate.test(event.key)) {
                  event.preventDefault();
              }
          },
          abrirModal(modelo, accion, data=[]){
                this.errorPersonal = 0;
                this.errorMostrarMsjPersonal = [];
                switch(modelo){
                    case "proveedor":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal='Registro Cliente'
                                        this.datos = {
                                            id : 0,
                                            nombre : '',
                                            nit : '',
                                            contacto : '',
                                            direccion : '',
                                            telefono : '',
                                            descripcion :'',
                                            estado : '1',
                                        }                                      
                                        this.tipoAccion = 1;
                                        break;
                                    }
                                case 'modificar':
                                    {
                                        this.modal = 1;
                                        // console.log('prueba');
                                        this.tituloModal = 'Modificar Cliente';
                                        this.tipoAccion = 2;
                                        this.datos.id = data['id'];
                                        this.datos.nombre = data['nombre'];
                                        this.datos.nit = data['nit'];
                                        this.datos.contacto = data['contacto'];
                                        this.datos.direccion = data['direccion'];
                                        this.datos.telefono = data['telefono'];
                                        this.datos.descripcion = data['descripcion'];
                                        this.datos.estado = data['estado'];
                                       break;
                                    }
                            }
                        }
                }
        
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.errorPersonal = 0;
                this.erroresPersonal = {};
                this.datos = {
                    id : 0,
                    nombre : '',
                    nit : '',
                    contacto : '',
                    direccion : '',
                    telefono : '',
                    descripcion :'',
                    estado : '1',
                
                }
            },
          cargarPdf2() {
              axios.get('/venta/pdfVentasGeneral2',{responseType: 'blob'})
                  .then(response => {
                      var blob = new Blob([response.data], {type: 'application/pdf'});
                      var downloadUrl = URL.createObjectURL(blob);
                      window.open(downloadUrl, '_blank');
                  })
                  .catch(error => {
                      console.log(error);
                  })
          }

      },
      mounted() {
        //   this.selectCliente();
        //   this.selectTipoP();
        //   this.selectFormaP();  
        //   this.verificarCaja();
          this.selectCategoria();
          this.selectProveedor();
          this.listarArticulo(this.buscarP,this.criterio);


      }
  }
</script>
<style scoped lang="scss">
  .dropdown-wrapper{
      position: relative;
      //margin: 0 auto;

      .selected-item{
          height: 25px;
          //border: 2px solid lightgray;
          border-radius: 5px;
          padding: 5px 10px;
          display: flex;
          justify-content: space-between;
          align-items: center;
          //font-size: 16px;
          //font-weight: 500;

          .drop-down-icon{
              transform: rotate(0deg);
              transition: all 0.5s ease;
              &.dropdown{
                  transform: rotate(180deg);
              }
          }
      }

      .dropdown-popover{
          position: absolute;
          border: 2px solid lightgray;
          top: 46;
          left: 0;
          right: 0;
          background-color: #fff;
          max-width: 100%;
          align-items: center;
          padding: 10px;
          visibility: hidden;
          transition: all 0.35s linear;
          max-height: 0px;
          overflow: hidden;


          &.visible{
              max-height: 450px;
              visibility: visible;
          }
          input{
              width: 100%;
              height: 30px;
              border: 2px solid lightgray;
              font-size: 18px;
              padding-left: 8px;
          }

          .options{
              width: 100%;
              padding-top: 12px;

              ul{
                  list-style: none;
                  text-align:left;
                  padding-left: 2px;
                  max-height: 200px;
                  overflow-y: scroll;
                  overflow-x: hidden;
              }

              li{
                  width: 100%;
                  border-bottom: 1px solid lightgray;
                  padding: 5px;
                  border: 1px solid lightgray;
                  background-color: #f1f1f1;
                  cursor: pointer;
                  &:hover {
                      background: #44536E;
                      color: #fff;
                      font-weight: bold;
                  }
              }
          }
      }
  }



  .modal-content{
      width: 100% !important;
      position: absolute !important;
  }
  .mostrar{
      display: list-item !important;
      opacity: 1 !important;
      position: fixed !important;
      background-color: #d1cdcd7a !important;
  }
  .div-error{
      display: flex;
      justify-content: center;
  }
  .text-error{
      color: red !important;
      font-weight: bold;
  }
  .footer{
      position:relative !important;
      width: auto !important;
  }
  .tamaño{
      width: 100px !important; 
  }
  .bg-disabled{
      background-color: #D8DBE1;
  }
</style>