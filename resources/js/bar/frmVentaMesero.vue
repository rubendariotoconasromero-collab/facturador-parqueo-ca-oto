<template>
    <main class="main">
        <!-- <div class="container"> -->
        <div class="row">
            <div class="col">
                <!-- <div class="card"> -->
                <template v-if="listado==0 && estadoCaja=='Abierta'">
                    <!-- inicio nuevo sistemas -->

                    <div class="col-xs-12 mt-2">


                        <!--<div class="row mt-2">
                            <div class="col">
                                Total Ventas Bs.: <strong>{{monto_total_ventas.toFixed(2) }}</strong>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                Total V. Efectivo Bs.: <strong>{{monto_total_efectivo.toFixed(2) }}</strong>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Total V. Depósito Bs.: <strong>{{monto_total_deposito.toFixed(2) }}</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Total V. Eliminados Bs.: <strong>{{monto_total_anulado.toFixed(2) }}</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Total Precuenta Bs.: <strong>{{monto_total_registrado.toFixed(2) }}</strong>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                Comisión Bs.: <strong
                                    class="badge bg-success">{{parseFloat(monto_porcentaje_venta.toFixed(2)).toFixed(2) }}</strong>
                            </div>
                        </div>-->

                        <div class="row mb-2">
                            <div class="col">
                                <div class="bg-light text-dark py-2 px-3 mb-2">Total Ventas Bs.:
                                    <strong>{{monto_total_ventas.toFixed(2)}}</strong></div>
                                <div class="bg-info text-white py-2 px-3 mb-2">Total V. Efectivo Bs.:
                                    <strong>{{monto_total_efectivo.toFixed(2)}}</strong></div>
                                <div class="bg-warning text-dark py-2 px-3 mb-2">Total V. Depósito Bs.:
                                    <strong>{{monto_total_deposito.toFixed(2)}}</strong></div>
                                <div class="bg-danger text-white py-2 px-3 mb-2">Total V. Eliminados Bs.:
                                    <strong>{{monto_total_anulado.toFixed(2)}}</strong></div>
                                <div class="bg-success text-white py-2 px-3 mb-2">Total Precuenta Bs.:
                                    <strong>{{monto_total_registrado.toFixed(2)}}</strong></div>
                                <div class="bg-dark text-white py-2 px-3 mb-2">Comisión Bs.:
                                    <strong>{{parseFloat(monto_porcentaje_venta.toFixed(2)).toFixed(2)}}</strong></div>
                            </div>
                        </div>
                        <div class="container text-center mb-2">
                            <button type="button" @click="iniciarVentaDirecta()" class="btn btn-outline-info">Venta
                                directa</button>
                            <button type="button" @click="galSalon()" class="btn bg-mesa text-white">Salon</button>
                            <button type="button" @click="Actualizar()" class="btn bg-actualizar text-white">Actualizar
                            </button>
                        </div>

                    </div>

                    <div class="row justify-content-center" style="overflow-y: auto; height: 445px;">
                        <div clas="table-responsive">
                            <table class="table">
                                <thead style="background-color: #46546c">
                                    <tr>
                                        <th scope="col" class="text-white" style="font-size: 9px;">Nro</th>
                                        <th scope="col" class="text-white" style="font-size: 9px;">Cliente</th>
                                        <th scope="col" class="text-white" style="font-size: 9px;">Total</th>
                                        <th scope="col" class="text-white" style="font-size: 9px;">Mesa</th>
                                        <th scope="col" class="text-white" style="font-size: 9px;">Estado</th>
                                        <th scope="col" class="text-white" style="font-size: 9px; widows: 150px;">
                                            Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(venta,index) in arrayVenta" :key="venta.id">
                                        <td v-text="index +  1" style="font-size: 9px;"></td>
                                        <td v-text="venta.cliente" style="font-size: 9px;"></td>
                                        <td v-text="venta.total" style="font-size: 9px;"></td>
                                        <td v-text="venta.mesa" style="font-size: 9px;"></td>
                                        <td>
                                            <template v-if="venta.estado=='Registrado'">
                                                <span class="badge bg-success" style="font-size: 7px;">Activo</span>
                                            </template>
                                            <template v-else-if="venta.estado=='Anulado'">
                                                <span class="badge bg-danger" style="font-size: 7px;">Anulado</span>
                                            </template>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" @click="verDetalle(venta.id,venta.mesa)"
                                                        class="btn bg-ver btn-sm text-white"
                                                        style="font-size: 9px; width: 45px;">Ver</button>
                                                    <!--<button type="button" @click="actImpresion(venta.id)"
                                                        class="btn bg-imprimir btn-sm text-white"
                                                        style="font-size: 9px; width: 47px;">Imprimir</button>-->
                                                    <!-- <template v-if="venta.estado=='Registrado'">
                                                    <button type="button" @click="anularVenta(venta.id,venta.id_mesa)" class="btn bg-anular btn-sm" style="font-size: 9px; width: 45px;">Anular</button>

                                                </template>
                                                 <template v-else>
                                                    <button type="button"  class="btn btn-outline-secondary btn-sm" disabled style="font-size:9px;width: 45px;">Anular</button>
                                                </template> -->
                                                    <button type="button" @click="abrirModalCobrarMesa(venta.id, '');"
                                                        class="btn btn-warning  btn-sm text-white"
                                                        style="font-size: 9px; width: 45px;">Cobrar Mesa</button>

                                                    <!--<button type="button" @click="anular(venta.id_mesa);"
                                                        class="btn btn-danger  btn-sm text-white"
                                                        style="font-size: 9px; width: 45px;">Anular</button>-->


                                                </div>

                                                <!-- <li><a class="dropdown-item" href="#" @click="abrirModalCobrarMesa(mesa.id, mesa);"><i class="fa fa-money text-danger"></i> Cobrar Mesa</a></li> -->

                                                <!-- <button type="button" @click="verDetalle(venta.id)" class="btn btn-outline-success btn-sm" style="font-size: 9px; width: 100px;">Ver</button>
                                                <button type="button" @click="actImpresion(venta.id)" class="btn btn-outline-warning btn-sm" style="font-size: 9px; width: 100px;">Imprimir</button>
                                                <template v-if="venta.Eliminado == 0">
                                                <button type="button" @click="anular(venta.id)" class="btn btn-outline-danger btn-sm" style="font-size: 9px; width: 100px;">Anular</button>
                                                </template>
                                                <template v-else>
                                                    <button type="button" @click="anular(venta.id)" class="btn btn-outline-secondary btn-sm" disabled style="font-size:9px;width: 100px;">Anular</button>
                                                </template> -->
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <template>
                            <div>
                                <b-table striped hover :items="items"></b-table>
                            </div>
                            </template> -->

                    </div>
                </template>
                <template v-if="listado==0 && estadoCaja == 'Cerrada'">
                    <div class="card-header text-center text-white" style="background-color: #3399FF">
                        <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 col-md-11">VENTA</h5>
                            <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                        </div>
                    </div>
                    <div class="alert alert-warning alert-dismissable text-center">
                        <strong>¡Cuidado!</strong> Se requiere Aperturar Caja Primero.
                    </div>
                </template>
                <!-- Salon-->
                <template v-if="listado==1">
                    <div class="form-group row p-2">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">Salon</h5>
                                <button type="button" class="btn-close btn-close-white" @click="volverMenu()"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 500px;">
                        <div class="col" v-for="salon in arraySalon" :key="salon.id">
                            <div class="card">
                                <div @click="galMesa(salon.id,salon.nombre)">
                                    <img :src="'img/producto/'+salon.foto" class="card-img-top" alt="" width="50"
                                        height="100">
                                </div>
                                <div class="card-footer" style="font-size: 0.7rem">
                                    <p class="text-center">{{salon.nombre}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <!--Mesa-->
                <template v-if="listado==2">
                    <div class="form-group row p-2">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">Mesa de {{ datos.mesa}}</h5>
                                <button type="button" class="btn-close btn-close-white" @click="volverSalon()"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 500px;">
                        <div class="col" v-for="mesa in arrayMesa" :key="mesa.id">
                            <div class="card">
                                <template v-if="mesa.estado == 0">
                                    <img @click="ModificarMesa(mesa.id)" :src="'img/producto/'+mesa.foto"
                                        class="card-img-top" alt="" width="50" height="100"
                                        style="background-color: #FF002E">
                                </template>
                                <template v-else>
                                    <div @click="galCategoria(mesa)">
                                        <img :src="'img/producto/'+mesa.foto" class="card-img-top" alt="" width="50"
                                            height="100">
                                    </div>
                                </template>
                                <div class="card-footer" style="font-size: 0.7rem">
                                    <p class="text-center">{{mesa.nombre}}</p>
                                </div>
                                <template v-if="mesa.estado == 0">
                                    <!--<button class="btn btn-outline-secondary dropdown-toggle text-center" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false"
                                        style='font-size: 0.7rem'>Accion</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"
                                                @click="abrirModalCobrarMesa2(mesa.id, mesa);"><i
                                                    class="fa fa-money text-danger"></i> Cobrar Mesa</a></li>
                                    </ul>-->
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Galeria de Categoria -->
                <template v-if="listado==3">
                    <div class="form-group row p-2">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">Categorias</h5>
                                <button type="button" class="btn-close btn-close-white" @click="volverSalon()"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 540px;">
                        <div class="col" v-for="categoria in arrayCategoria" :key="categoria.id">
                            <div class="card" style="font-size: 0.8rem; background-color: #E1E6FC">
                                <img :src="'img/producto/'+categoria.foto" class="card-img-top" alt="" width="50"
                                    height="100" @click="galProductos(categoria.id,categoria.nombre)">
                                <div class="card-footer"
                                    style="font-size: 0.8rem;overflow-y: auto; max-height: 60px; height: 60px;">
                                    <p class="text-center"><strong>{{categoria.nombre}}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Galeria de Productos  Pre Venta-->
                <template v-if="listado==4">
                    <div class="form-group row p-2">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">Producto - {{ categoria }}</h5>
                                <button type="button" class="btn-close btn-close-white" @click="volverCategoria()"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">

                        <div class="input-group mb-3">
                            <input class="form-control" type="search" placeholder="Buscar Producto..."
                                aria-label="Search" v-model="buscar" @keyup="selectProductoCat">
                            <button v-if="tipo_venta==''" @click="abrirModalDetalleVenta()" type="button"
                                class="btn btn-success text-white">Carrito
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{cantidadCarrito}} +
                                    <span class="visually-hidden">Nuevo producto</span>
                                </span>
                            </button>
                            <button v-if="tipo_venta=='directa'" @click="abrirModalDetalleVentaDirecta()" type="button"
                                class="btn btn-success text-white">Carrito
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{cantidadCarrito}} +
                                    <span class="visually-hidden">Nuevo producto</span>
                                </span>
                            </button>
                        </div>

                    </div>

                    <br>
                    <br>
                    <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 380px;">
                        <div class="col" v-for="producto in arrayProducto" :key="producto.id">
                            <div class="card">
                                <header class="" style="background-color: #3399FF">
                                    <h6 class="text-center text-white"><strong>Bs.: {{producto.precio}}</strong></h6>
                                </header>
                                <img :src="'img/producto/'+producto.foto" class="card-img-top" alt="" width="50"
                                    height="100" @click="agregarProductoCheck(producto)">
                                <div class="card-footer"
                                    style="font-size: 0.8rem; background-color: #E1E6FC ;overflow-y: auto; max-height: 60px; height: 60px;">
                                    <div class="text-center" style="font-size: 0.8rem;">
                                        <strong>{{producto.descripcion}}</strong></div>
                                    <template v-if="producto.id_tipo_producto==3">
                                        <template v-if="producto.stock<=0">
                                            <span>
                                                <div v-if="producto.estado==1" class="text-center"
                                                    style="font-size: 0.7rem;"><strong class="badge bg-danger">Q.:
                                                        {{Math.floor((producto.stock/producto.contenido_presentacion))}}</strong>
                                                </div>
                                            </span>
                                        </template>
                                        <template v-else>
                                            <span>
                                                <div v-if="producto.estado==1" class="text-center"
                                                    style="font-size: 0.7rem;"><strong>Q.:
                                                        {{Math.floor((producto.stock/producto.contenido_presentacion))}}</strong>
                                                </div>
                                            </span>
                                        </template>
                                    </template>
                                    <template
                                        v-if=" producto.id_tipo_producto==5 || producto.id_tipo_producto==2 || producto.stock<0">
                                        <span>
                                            <div v-if="producto.estado==1" class="text-center"
                                                style="font-size: 0.7rem; color: #E1E6FC;"><strong
                                                    class="badge ">ㅤ</strong></div>
                                        </span>
                                    </template>

                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Modificar Mesa  Preventa-->
                <template v-if="listado==5">
                    <div class="card-header text-center text-white" style="background-color: #3399FF">
                        <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 col-md-11 text-uppercase">Venta - {{ datos.mesa }}</h5>
                            <button type="button" class="btn-close btn-close-white" @click="volverMesa()"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row" style='margin-left:1%'>
                            <form class="row">
                                <div class="col-md-12 pt-2">
                                    <label for="exampleInputEmail1" class="form-label"
                                        style="font-size: 0.8rem;">Cliente</label>
                                    <div><input type="text" class="form-control" v-model="datos.cliente" disabled></div>
                                </div>
                                <template v-if="usuario.id_grupo == 1">
                                    <div class="col-md-6 pt-2">
                                        <div>
                                            <label for="exampleInputPassword1" class="form-label"
                                                style="font-size: 0.8rem;">Tipo Pago</label>
                                        </div>
                                        <div>
                                            <select class="form-select" v-model="datos.id_tipo_pago" disabled>
                                                <option value="0" style="font-size: 0.8rem;">Seleccione el Tipo Pago
                                                </option>
                                                <option v-for="tipo_pago in arrayPago" :key="tipo_pago.id"
                                                    :value="tipo_pago.id" v-text="tipo_pago.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" v-if="datos.id_tipo_pago == 2">
                                        <div>
                                            <label for="exampleInputPassword1" class="form-label"
                                                style="font-size: 0.8rem">Fecha Final</label>
                                        </div>
                                        <div>
                                            <input type="date" class="form-control" v-model="datosPago.fecha_final">
                                        </div>
                                    </div>
                                    <div class="col-md-6" v-if="datos.id_tipo_pago == 1">
                                        <div>
                                            <label for="exampleInputPassword1" class="form-label"
                                                style="font-size: 0.8rem">Forma Pago</label>
                                        </div>

                                        <template>
                                            <select class="form-select" v-model="datos.id_forma_pago">
                                                <option value="0" disabled>Seleccione la Forma de Pago</option>
                                                <option v-for="forma_pago in arrayForma2" :key="forma_pago.id"
                                                    :value="forma_pago.id" v-text="forma_pago.nombre"></option>
                                            </select>
                                        </template>

                                    </div>
                                </template>
                                <div class="col-md-6">
                                </div>&nbsp;
                                <div class="col-md-12">
                                    <textarea class="form-control" v-model="datos.observacion" rows="2"
                                        placeholder="Descripcion"></textarea>
                                </div>&nbsp;
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
                        <div class="form-group row">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" style='width:96%;margin-left: 2%'>
                                    <thead style="background-color: #46546C">
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">Eliminar</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem; " width="15%">
                                            Producto</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;" width="15%">Costo
                                        </th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">Cantidad</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">SubTotal</th>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="index">
                                            <template v-if="detalle.Estado == 0">
                                                <td><button
                                                        @click="eliminarDetalleDb(detalle.id_detalle,detalle.id_tipo_producto)"
                                                        type="button" class="btn btn-danger btn-sm text-white"
                                                        style="font-size: 0.7rem;"><i
                                                            class="icon-trash text-white"></i></button></td>
                                            </template>
                                            <template v-else-if="detalle.id_tipo_producto == 5">
                                                <td>
                                                    <button
                                                        @click="eliminarDetalle(index),encuentraProductoCombo2Delete(detalle.id_articulo)"
                                                        type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: 0.7rem;"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>
                                            <template v-else>
                                                <td>
                                                    <button @click="eliminarDetalle(index)" type="button"
                                                        class="btn btn-danger btn-sm" style="font-size: 0.7rem;"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>
                                            <td v-text="detalle.articulo" style="font-size: 0.8rem;vertical-align: top">
                                            </td>
                                            <td style="font-size: 0.8rem;">
                                                {{detalle.costo_venta = isNaN(detalle.costo_venta)? 0 : parseFloat(detalle.costo_venta).toFixed(2)}}
                                            </td>

                                            <td>

                                                <div>
                                                    <template v-if="detalle.Estado == 0">
                                                        <input v-model="detalle.cantidad" type="number" value="3"
                                                            class="form-control" min="0" style="font-size: 0.8rem"
                                                            @keyup="contadorStock(detalle)" disabled>
                                                    </template>
                                                    <template v-else>
                                                        <input v-model="detalle.cantidad" type="number" value="3"
                                                            class="form-control" min="0" style="font-size: 0.8rem"
                                                            @keyup="contadorStock(detalle)">
                                                    </template>
                                                </div>
                                                <span style="color:red;font-size: 0.4rem;vertical-align: top;"
                                                    v-show="detalle.descuento_stock>parseFloat(detalle.stock)">Stock:
                                                    {{detalle.stock}} </span>
                                            </td>
                                            <td style="font-size: 0.8rem">
                                                {{detalle.sub_total = (isNaN(detalle.costo_venta*detalle.cantidad))? 0 : (detalle.costo_venta*detalle.cantidad).toFixed(2)}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #e5f5fd">
                                            <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Sub
                                                    Total:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                {{datos.sub_total = isNaN(calcularSubTotal) ? 0 : calcularSubTotal.toFixed(2)}}
                                                bs</td>
                                        </tr>
                                        <tr style="background-color: #e5f5fd">
                                            <td colspan="4" align="right" style="font-size: 0.8rem;">
                                                <strong>Descuento:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                <input v-model="calcularDescuento" type="number" min="0" value="0"
                                                    class="form-control" disabled>
                                            </td>
                                        </tr>
                                        <tr style="background-color: #e5f5fd">
                                            <td colspan="4" align="right" style="font-size: 0.8rem;">
                                                <strong>Total:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                {{datos.total = datos.sub_total- calcularDescuento}} bs</td>
                                        </tr>
                                        <template v-if="datos.id_forma_pago ==6">
                                            <template v-if="usuario.id_grupo == 1">
                                                <tr style="background-color: #CEECF5">
                                                    <td colspan="4" align="right" style="font-size: 0.8rem;">
                                                        <strong>Total Efect.:</strong> </td>
                                                    <td>
                                                        <input v-model="datos.total_efectivo" value="0"
                                                            class="form-control" style="font-size: 0.8rem;">
                                                    </td>
                                                </tr>
                                                <tr style="background-color: #CEECF5">
                                                    <td colspan="4" align="right" style="font-size: 0.8rem;">
                                                        <strong>Total Dep.:</strong> </td>
                                                    <td style="font-size: 0.8rem;">
                                                        {{datos.total_deposito = datos.total- datos.total_efectivo}} bs
                                                    </td>
                                                </tr>
                                                <tr style="background-color: #FF6775">
                                                    <td colspan="4" align="right" class="text-white">
                                                        <strong>Efectivo:</strong> </td>
                                                    <td>
                                                        <input v-model="datos.efectivo" value="0" class="form-control"
                                                            min="0">
                                                    </td>
                                                </tr>
                                                <tr style="background-color: #FF6775">
                                                    <td colspan="4" align="right" class="text-white">
                                                        <strong>Cambio:</strong> </td>
                                                    <template v-if="datos.efectivo != 0">
                                                        <td class="text-white">
                                                            {{datos.cambio = datos.efectivo- datos.total_efectivo}} bs
                                                        </td>
                                                    </template>
                                                    <template v-else>
                                                        <td class="text-white">{{datos.cambio = datos.efectivo- 0}}</td>
                                                    </template>
                                                </tr>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <template v-if="usuario.id_grupo == 1">
                                                <tr style="background-color: #FF6775">
                                                    <td colspan="4" align="right" class="text-white">
                                                        <strong>Efectivo:</strong> </td>
                                                    <td>
                                                        <input v-model="datos.efectivo" value="0" min="0"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr style="background-color: #FF6775">
                                                    <td colspan="4" align="right" class="text-white">
                                                        <strong>Cambio:</strong> </td>
                                                    <template v-if="datos.efectivo != 0">
                                                        <td class="text-white">
                                                            {{datos.cambio = datos.efectivo- datos.total}} bs</td>
                                                    </template>
                                                    <template v-else>
                                                        <td class="text-white">{{datos.cambio = datos.efectivo- 0}}</td>
                                                    </template>
                                                </tr>
                                            </template>
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
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="width:96%;margin-left: 2.2%">
                            <template v-if="usuario.id_grupo == 1">
                                <button class="btn btn-danger btn-sm text-white" type="button"
                                    @click="CobrarMesa()">Cobrar Mesa</button>
                            </template>
                            <button class="btn btn-dark btn-sm text-white" type="button"
                                @click="agregarArticuloDet()">Agregar</button>
                            <button v-if="accionVenta==1" :disabled="modificar_venta"
                                class="btn bg-info btn-sm text-white" type="button"
                                @click="modificarPreVenta()">Confirmar modificar</button>
                        </div>
                    </div>
                </template>
                <!-- Galeria de Categoria Modificar -->
                <template v-if="listado==6">
                    <div class="form-group row p-2">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">Categorias</h5>
                                <button type="button" class="btn-close btn-close-white" @click="volverSalon()"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 540px;">
                        <div class="col" v-for="categoria in arrayCategoria" :key="categoria.id">
                            <div class="card" style="font-size: 0.8rem; background-color: #E1E6FC">
                                <img :src="'img/producto/'+categoria.foto" class="card-img-top" alt="" width="50"
                                    height="100" @click="galProductos2(categoria.id,categoria.nombre)">
                                <div class="card-footer"
                                    style="font-size: 0.8rem;overflow-y: auto; max-height: 60px; height: 60px;">
                                    <p class="text-center"><strong>{{categoria.nombre}}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Galeria de Productos  Modificar Pre Venta-->
                <template v-if="listado==7">
                    <div class="form-group row p-2">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">Producto - {{ categoria }}</h5>
                                <button type="button" class="btn-close btn-close-white" @click="volverCategoria2()"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <div class="input-group mb-3">
                            <input class="form-control" type="search" placeholder="Buscar Producto..."
                                aria-label="Search" v-model="buscar" @keyup="selectProductoCat">
                            <button type="button" class="btn bg-guardar position-relative text-white"
                                @click="abrirModalDetalleVenta()">Carrito
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{cantidadCarrito}} +
                                    <span class="visually-hidden">Nuevo producto</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="d-grid gap-2">
                            <!--<button class="btn bg-guardar btn-sm text-white" type="button"
                                @click="detallePreventa2()">Guardar Venta</button>-->
                        </div>
                        <br>
                    </div>
                    <br>
                    <br>
                    <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 380px;">
                        <div class="col" v-for="producto in arrayProducto" :key="producto.id">
                            <div class="card">
                                <header class="" style="background-color: #3399FF">
                                    <h6 class="text-center text-white"><strong>Bs.: {{producto.precio}}</strong></h6>
                                </header>
                                <img :src="'img/producto/'+producto.foto" class="card-img-top" alt="" width="50"
                                    height="100" @click="agregarProductoCheck2(producto)">
                                <div class="card-footer"
                                    style="font-size: 0.8rem; background-color: #E1E6FC ;overflow-y: auto; max-height: 60px; height: 60px;">
                                    <div class="text-center" style="font-size: 0.8rem;">
                                        <strong>{{producto.descripcion}}</strong></div>
                                    <template v-if="producto.id_tipo_producto==3">
                                        <template v-if="producto.stock<=0">
                                            <span>
                                                <div v-if="producto.estado==1" class="text-center"
                                                    style="font-size: 0.7rem;"><strong class="badge bg-danger">Q.:
                                                        {{Math.floor((producto.stock/producto.contenido_presentacion))}}</strong>
                                                </div>
                                            </span>
                                        </template>
                                        <template v-else>
                                            <span>
                                                <div v-if="producto.estado==1" class="text-center"
                                                    style="font-size: 0.7rem;"><strong>Q.:
                                                        {{Math.floor((producto.stock/producto.contenido_presentacion))}}</strong>
                                                </div>
                                            </span>
                                        </template>
                                    </template>
                                    <template
                                        v-if=" producto.id_tipo_producto==5 || producto.id_tipo_producto==2 || producto.stock<0">
                                        <span>
                                            <div v-if="producto.estado==1" class="text-center"
                                                style="font-size: 0.7rem; color: #E1E6FC;"><strong
                                                    class="badge ">ㅤ</strong></div>
                                        </span>
                                    </template>

                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- ver Detalle -->
                <template v-if="listado==8">
                    <div class="form-group row p-2">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">Detalle - {{ mesaD }}</h5>
                                <button type="button" class="btn-close btn-close-white" @click="volverMenu()"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nombre Cliente:</label>
                        <input type="text" class="form-control" v-model="datos.cliente" disabled>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead style="background-color: #46546c">
                            <th scope="col" class="text-white">Producto</th>
                            <th scope="col" class="text-white">Precio Venta</th>
                            <th scope="col" class="text-white">Cantidad</th>
                            <th scope="col" class="text-white">SubTotal</th>
                        </thead>
                        <tbody v-if="arrayDet.length">
                            <tr v-for="detalle in arrayDet" :key="detalle.id">
                                <td v-text="detalle.producto"></td>
                                <td v-text="detalle.precio + ' bs'"></td>
                                <td v-text="detalle.cantidad"></td>
                                <td>{{detalle.SubTotal = detalle.precio*detalle.cantidad}}</td>
                            </tr>
                            <tr style="background-color: #CEECF5">
                                <td colspan="3" align="right"> <strong>Monto Total:</strong> </td>
                                <td>{{datos.monto}} bs</td>
                            </tr>
                        </tbody>
                    </table>
                </template>
                <!-- </div> -->
            </div>
        </div>

        <!-- MODAL de COBRAR MESA -->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' :modalcobrar}" role="dialog"
            aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: #66b3ff">
                        <h5 class="modal-title ">Registro de Cobro de Mesa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click="cerrarModalCobrarMesa()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pb-0 mb-0" style="margin-left:1%">


                            <form class=" row">
                                <div class="col-md-12 pb-2 ">
                                    <div class="col-md-12 pb-2 mb-2">
                                        <label for="exampleInputEmail1" class="form-label"
                                            style="font-size: 0.9rem;">Cliente</label>
                                        <div class="input-group mb-6">
                                            <section class="dropdown-wrapper form-control">
                                                <div @click="ocultar()" class="selected-item">
                                                    <input type="text" class="form-control sinborde"
                                                        placeholder="Seleccione Cliente.." v-model="datos.cliente"
                                                        aria-label="Buscar Clientes.." @keyup="guardarCliente()">


                                                    <svg :class="isVisible ? 'dropdown' : ''" class="drop-down-icon"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z" />
                                                        <path
                                                            d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z" />
                                                    </svg>
                                                </div>
                                                <div :class="isVisible  ? 'visible' : 'invisible'"
                                                    class="dropdown-popover">
                                                    <div class="text-center"><span
                                                            v-if="filteredCliente.length === 0">No
                                                            existen Clientes</span>
                                                    </div>
                                                    <div class="options">
                                                        <ul>
                                                            <li @click="selectedCliente(cliente)"
                                                                v-for="(cliente, index) in filteredCliente"
                                                                :key="`cliente-${index}`">
                                                                {{cliente.nombre}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </section>
                                            &nbsp;&nbsp;&nbsp;
                                            <button type="button" class="btn btn-info text-white position-relative"
                                                @click="abrirModal('cliente','registrar')"><i class="fa fa-search"></i>
                                                Agregar Clientes</button>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 pb-2">
                                    <div>
                                        <label for="exampleInputPassword1" class="form-label"
                                            style="font-size: 0.9rem;">Tipo Pago</label>
                                    </div>
                                    <div>
                                        <select class="form-select" v-model="datos.id_tipo_pago" disabled>
                                            <option :value="1" v-text="'Contado'"></option>
                                            <!--<option value="0" style="font-size: 0.9rem;">
                                                Seleccione el Tipo Pago</option>
                                            <option v-for="tipo_pago in arrayPago" :key="tipo_pago.id"
                                                :value="tipo_pago.id" v-text="tipo_pago.nombre"></option>-->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="datos.id_tipo_pago == 2">
                                    <div>
                                        <label for="exampleInputPassword1" class="form-label"
                                            style="font-size: 0.9rem">Fecha
                                            Final</label>
                                    </div>
                                    <div>
                                        <input type="date" class="form-control" v-model="datosPago.fecha_final">
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="datos.id_tipo_pago == 1">
                                    <div>
                                        <label for="exampleInputPassword1" class="form-label"
                                            style="font-size: 0.9rem">Forma Pago</label>
                                    </div>


                                    <select class="form-select" v-model="datos.id_forma_pago">
                                        <option value="0" disabled>Seleccione la Forma
                                            de
                                            Pago
                                        </option>
                                        <option v-for="forma_pago in arrayForma2" :key="forma_pago.id"
                                            :value="forma_pago.id" v-text="forma_pago.nombre"></option>
                                    </select>


                                </div>


                            </form>
                            <div class="col-md-12 p-0 m-0">
                                <div v-show="errorPago" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPago" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row" style="overflow-y: auto; height: 400px;">
                            <div class="table-responsive p-2">
                                <table class="table table-striped table-hover" style='width:96%;margin-left: 2%'>


                                    <tbody v-if="arrayDetalle.length" class="mt-0 mb-0">
                                        <tr class="invisible" v-for="(detalle,index) in arrayDetalle" :key="index"
                                            style="display:none">
                                            <template v-if="detalle.Estado == 0">
                                                <td><button
                                                        @click="eliminarDetalleDb(detalle.id_detalle,detalle.id_tipo_producto)"
                                                        type="button" class="btn btn-danger btn-sm"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>

                                            <template v-else-if="detalle.id_tipo_producto == 5">
                                                <td>
                                                    <button
                                                        @click="eliminarDetalle(index),encuentraProductoCombo2Delete(detalle.id_articulo)"
                                                        type="button" class="btn btn-danger btn-sm"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>
                                            <template v-else>
                                                <td>
                                                    <button @click="eliminarDetalle(index)" type="button"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>


                                            <td v-text="detalle.articulo" style="font-size: 0.8rem;vertical-align: top">
                                            </td>
                                            <td style="font-size: 0.8rem;">
                                                {{detalle.costo_unitario = isNaN(detalle.costo_unitario)? 0 : parseFloat(detalle.costo_unitario).toFixed(2)}}
                                            </td>

                                            <td>

                                                <div>
                                                    <template v-if="detalle.Estado == 0">
                                                        <input v-model="detalle.cantidad" type="number" value="3"
                                                            class="form-control" min="0" style="font-size: 0.8rem"
                                                            @keyup="contadorStock(detalle)" disabled>
                                                    </template>
                                                    <template v-else>
                                                        <input v-model="detalle.cantidad" type="number" value="3"
                                                            class="form-control" min="0" style="font-size: 0.8rem"
                                                            @keyup="contadorStock(detalle)">
                                                    </template>
                                                </div>
                                                <span style="color:red;font-size: 0.4rem;vertical-align: top;"
                                                    v-show="detalle.descuento_stock>parseFloat(detalle.stock)">Stock:
                                                    {{detalle.stock}} </span>
                                            </td>

                                            <td style="font-size: 0.8rem">
                                                {{detalle.sub_total = (isNaN(detalle.costo_unitario*detalle.cantidad))? 0 : (detalle.costo_unitario*detalle.cantidad).toFixed(2)}}
                                            </td>

                                        </tr>

                                        <tr style="background-color: #eff4fe">
                                            <td colspan="4" align="right" style="font-size: 0.8rem;">
                                                <strong>Sub Total:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                {{datos.sub_total = isNaN(calcularSubTotal) ? 0 : calcularSubTotal.toFixed(2)}}
                                                bs</td>
                                        </tr>
                                        <tr style="background-color: #eff4fe">
                                            <td colspan="4" align="right" style="font-size: 0.8rem;">
                                                <strong>Descuento:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                <input v-model="datos.descuento" type="number" min="0" value="0"
                                                    class="form-control">
                                            </td>
                                        </tr>
                                        <tr style="background-color: #eff4fe">
                                            <td colspan="4" align="right" style="font-size: 0.8rem;">
                                                <strong>Total:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                {{datos.total = datos.sub_total- datos.descuento}}
                                                bs
                                            </td>
                                        </tr>
                                        <template v-if="datos.id_forma_pago ==6">
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right" style="font-size: 0.8rem;">
                                                    <strong>Total
                                                        Efect.:</strong> </td>
                                                <td>
                                                    <input v-model="datos.total_efectivo" value="0" class="form-control"
                                                        style="font-size: 0.8rem;">
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right" style="font-size: 0.8rem;">
                                                    <strong>Total
                                                        Dep.:</strong> </td>
                                                <td style="font-size: 0.8rem;">
                                                    {{datos.total_deposito = datos.total- datos.total_efectivo}}
                                                    bs</td>
                                            </tr>
                                            <tr style="background-color: #FF6775">
                                                <td colspan="4" align="right" class="text-white">
                                                    <strong>Efectivo:</strong> </td>
                                                <td>
                                                    <input v-model="datos.efectivo" value="0" class="form-control"
                                                        min="0">
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FF6775">
                                                <td colspan="4" align="right" class="text-white">
                                                    <strong>Cambio:</strong> </td>
                                                <template v-if="datos.efectivo != 0">
                                                    <td class="text-white">
                                                        {{datos.cambio = datos.efectivo- datos.total_efectivo}}
                                                        bs</td>
                                                </template>
                                                <template v-else>
                                                    <td class="text-white">
                                                        {{datos.cambio = datos.efectivo- 0}}
                                                    </td>
                                                </template>
                                            </tr>
                                        </template>
                                        <template
                                            v-else-if="datos.id_forma_pago ==4 || datos.id_forma_pago==5 || datos.id_forma_pago==3">

                                        </template>
                                        <template v-else>
                                            <tr style="background-color: #FF6775">
                                                <td colspan="4" align="right" class="text-white">
                                                    <strong>Efectivo:</strong> </td>
                                                <td>
                                                    <input v-model="datos.efectivo" value="0" min="0"
                                                        class="form-control">
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FF6775">
                                                <td colspan="4" align="right" class="text-white">
                                                    <strong>Cambio:</strong> </td>
                                                <template v-if="datos.efectivo != 0">
                                                    <td class="text-white">
                                                        {{datos.cambio = datos.efectivo- datos.total}}
                                                        bs</td>
                                                </template>
                                                <template v-else>
                                                    <td class="text-white">
                                                        {{datos.cambio = datos.efectivo- 0}}
                                                    </td>
                                                </template>
                                            </tr>
                                        </template>
                                    </tbody>

                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5" style="font-size: 0.8rem;">
                                                No
                                                hay Producto
                                                agregados</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white"
                            @click="cerrarModalCobrarMesa()">Cerrar</button>
                        <button :disabled="cobrando_mesa" type="button" class="btn bg-info text-white"
                            @click="CobrarMesa()">Cobrar Mesa</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- FIN abrir MODAL COBRAR MESA -->

        <!-- INICIO MODAL VER DETALLE VENTA -->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' :modaldetalleventa}" role="dialog"
            aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: #66b3ff">
                        <h5 class="modal-title ">Detalle de la venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click="cerrarModalDetalleVenta()"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group row">
                            <div class="d-grid gap-2">
                                <div class="input-group mb-6">
                                    <section class="dropdown-wrapper form-control">
                                        <div @click="ocultar()" class="selected-item">
                                            <!-- <input v-if="buscarCliente==''" type="text" class="form-control" placeholder="Seleccione Cliente.."  v-model="buscarCliente" aria-label="Buscar Clientes.."> -->

                                            <input type="text" class="form-control sinborde"
                                                placeholder="Seleccione Cliente.." v-model="datos.cliente"
                                                aria-label="Buscar Clientes.." @keyup="guardarCliente()">

                                            <!-- <span v-if="datos.cliente==''">Seleccione Cliente</span>
                                                        <span v-else>{{datos.cliente }}</span> -->
                                            <svg :class="isVisible ? 'dropdown' : ''" class="drop-down-icon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z" />
                                            </svg>
                                        </div>
                                        <div :class="isVisible  ? 'visible' : 'invisible'" class="dropdown-popover">
                                            <!-- <input type="text" class="form-control" placeholder="Buscar Clientes.."  v-model="buscarCliente" aria-label="Buscar Productos.."> -->
                                            <div class="text-center"><span v-if="filteredCliente.length === 0">No
                                                    existen
                                                    Clientes</span></div>
                                            <div class="options">
                                                <ul>
                                                    <li @click="selectedCliente(cliente)"
                                                        v-for="(cliente, index) in filteredCliente"
                                                        :key="`cliente-${index}`">{{cliente.nombre}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </section>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-info text-white position-relative"
                                        @click="abrirModal('cliente','registrar')"><i class="fa fa-search"></i>
                                        Agregar Clientes</button>
                                </div>
                                <!--<button :disabled="guardando_venta_mesero" class="btn bg-guardar btn-sm text-white"
                                type="button" @click="guardarVenta()">Guardar Venta</button>-->
                            </div>
                            <br>
                        </div>

                        <div class="form-group row" style="overflow-y: auto; height: 400px;">
                            <div class="table-responsive p-2">
                                <table class="table table-striped table-hover" style='width:96%;margin-left: 2%'>

                                    <thead style="background-color: #46546C">
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">Eliminar</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem; " width="15%">
                                            Producto</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;" width="15%">Costo
                                        </th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">Cantidad</th>
                                        <th scope="col" class="text-white" style="font-size: 0.9rem;">Descripción</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">SubTotal</th>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length" class="mt-0 mb-0">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="index">
                                            <template v-if="detalle.Estado == 0">
                                                <td><button
                                                        @click="eliminarDetalleDb(detalle.id_detalle,detalle.id_tipo_producto)"
                                                        type="button" class="btn btn-danger btn-sm"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>

                                            <template v-else-if="detalle.id_tipo_producto == 5">
                                                <td>
                                                    <button
                                                        @click="eliminarDetalle(index),encuentraProductoCombo2Delete(detalle.id_articulo)"
                                                        type="button" class="btn btn-danger btn-sm"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>
                                            <template v-else>
                                                <td>
                                                    <button @click="eliminarDetalle(index)" type="button"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>


                                            <td v-text="detalle.articulo" style="font-size: 0.8rem;vertical-align: top">
                                            </td>
                                            <td style="font-size: 0.8rem;">
                                                {{detalle.costo_unitario = isNaN(detalle.costo_unitario)? 0 : parseFloat(detalle.costo_unitario).toFixed(2)}}
                                            </td>

                                            <td>

                                                <div>
                                                    <template v-if="detalle.Estado == 0">
                                                        <input v-model="detalle.cantidad" type="number" value="3"
                                                            class="form-control" min="0" style="font-size: 0.8rem"
                                                            @keyup="contadorStock(detalle)" disabled>
                                                    </template>
                                                    <template v-else>
                                                        <input v-model="detalle.cantidad" type="number" value="3"
                                                            class="form-control" min="0" style="font-size: 0.8rem"
                                                            @keyup="contadorStock(detalle)">
                                                    </template>
                                                </div>
                                                <span style="color:red;font-size: 0.4rem;vertical-align: top;"
                                                    v-show="detalle.descuento_stock>parseFloat(detalle.stock)">Stock:
                                                    {{detalle.stock}} </span>
                                            </td>
                                            <td>

                                                <textarea style="font-size:0.8rem;" class="form-control"
                                                    v-model="detalle.descripcion" rows="2"></textarea>

                                            </td>

                                            <td style="font-size: 0.8rem">
                                                {{detalle.sub_total = (isNaN(detalle.costo_unitario*detalle.cantidad))? 0 : (detalle.costo_unitario*detalle.cantidad).toFixed(2)}}
                                            </td>

                                        </tr>

                                        <tr style="background-color: #eff4fe">
                                            <td colspan="5" align="right" style="font-size: 0.8rem;">
                                                <strong>Sub Total:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                {{datos.sub_total = isNaN(calcularSubTotal) ? 0 : calcularSubTotal.toFixed(2)}}
                                                bs</td>
                                        </tr>

                                        <tr style="background-color: #eff4fe">
                                            <td colspan="5" align="right" style="font-size: 0.8rem;">
                                                <strong>Total:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                {{datos.total = datos.sub_total- datos.descuento}}
                                                bs
                                            </td>
                                        </tr>


                                    </tbody>

                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5" style="font-size: 0.8rem;">
                                                No
                                                hay Producto
                                                agregados</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="accionVenta==0" :disabled="guardando_venta_mesero"
                            class="btn btn-success text-white" type="button" @click="guardarVenta()">Guardar
                            Venta</button>

                        <button v-else-if="accionVenta==1" class="btn btn-success text-white" type="button"
                            @click="detallePreventa2()">Agregar productos</button>

                        <button type="button" class="btn btn-danger text-white"
                            @click="cerrarModalDetalleVenta()">Cerrar</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- FIN VER DETALLE VENTA -->

        <!-- INICIO MODAL VER DETALLE VENTA  - VENTA DIRECTA-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' :modaldetalleventadirecta}" role="dialog"
            aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: #66b3ff">
                        <h5 class="modal-title ">Detalle de la venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click="cerrarModalDetalleVentaDirecta()"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group row">
                            <div class="d-grid gap-2">
                                <div class="input-group mb-6">
                                    <section class="dropdown-wrapper form-control">
                                        <div @click="ocultar()" class="selected-item">
                                            <!-- <input v-if="buscarCliente==''" type="text" class="form-control" placeholder="Seleccione Cliente.."  v-model="buscarCliente" aria-label="Buscar Clientes.."> -->

                                            <input type="text" class="form-control sinborde"
                                                placeholder="Seleccione Cliente.." v-model="datos.cliente"
                                                aria-label="Buscar Clientes.." @keyup="guardarCliente()">

                                            <!-- <span v-if="datos.cliente==''">Seleccione Cliente</span>
                                                        <span v-else>{{datos.cliente }}</span> -->
                                            <svg :class="isVisible ? 'dropdown' : ''" class="drop-down-icon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z" />
                                            </svg>
                                        </div>
                                        <div :class="isVisible  ? 'visible' : 'invisible'" class="dropdown-popover">
                                            <!-- <input type="text" class="form-control" placeholder="Buscar Clientes.."  v-model="buscarCliente" aria-label="Buscar Productos.."> -->
                                            <div class="text-center"><span v-if="filteredCliente.length === 0">No
                                                    existen
                                                    Clientes</span></div>
                                            <div class="options">
                                                <ul>
                                                    <li @click="selectedCliente(cliente)"
                                                        v-for="(cliente, index) in filteredCliente"
                                                        :key="`cliente-${index}`">{{cliente.nombre}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </section>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-info text-white position-relative"
                                        @click="abrirModal('cliente','registrar')"><i class="fa fa-search"></i>
                                        Agregar Clientes</button>
                                </div>
                                <!--<button :disabled="guardando_venta_mesero" class="btn bg-guardar btn-sm text-white"
                                type="button" @click="guardarVenta()">Guardar Venta</button>-->
                            </div>
                            <br>
                        </div>

                        <div class="form-group row" style="overflow-y: auto; height: 400px;">
                            <div class="table-responsive p-2">
                                <table class="table table-striped table-hover" style='width:96%;margin-left: 2%'>

                                    <thead style="background-color: #46546C">
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">Eliminar</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem; " width="15%">
                                            Producto</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;" width="15%">Costo
                                        </th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">Cantidad</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">Descripción</th>
                                        <th scope="col" class="text-white" style="font-size: 0.7rem;">SubTotal</th>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length" class="mt-0 mb-0">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="index">
                                            <template v-if="detalle.Estado == 0">
                                                <td><button
                                                        @click="eliminarDetalleDb(detalle.id_detalle,detalle.id_tipo_producto)"
                                                        type="button" class="btn btn-danger btn-sm"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>

                                            <template v-else-if="detalle.id_tipo_producto == 5">
                                                <td>
                                                    <button
                                                        @click="eliminarDetalle(index),encuentraProductoCombo2Delete(detalle.id_articulo)"
                                                        type="button" class="btn btn-danger btn-sm"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>
                                            <template v-else>
                                                <td>
                                                    <button @click="eliminarDetalle(index)" type="button"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="icon-trash text-white"></i></button>
                                                </td>
                                            </template>


                                            <td v-text="detalle.articulo" style="font-size: 0.8rem;vertical-align: top">
                                            </td>
                                            <td style="font-size: 0.8rem;">
                                                {{detalle.costo_unitario = isNaN(detalle.costo_unitario)? 0 : parseFloat(detalle.costo_unitario).toFixed(2)}}
                                            </td>

                                            <td>

                                                <div>
                                                    <template v-if="detalle.Estado == 0">
                                                        <input v-model="detalle.cantidad" type="number" value="3"
                                                            class="form-control" min="0" style="font-size: 0.8rem"
                                                            @keyup="contadorStock(detalle)" disabled>
                                                    </template>
                                                    <template v-else>
                                                        <input v-model="detalle.cantidad" type="number" value="3"
                                                            class="form-control" min="0" style="font-size: 0.8rem"
                                                            @keyup="contadorStock(detalle)">
                                                    </template>
                                                </div>
                                                <span style="color:red;font-size: 0.4rem;vertical-align: top;"
                                                    v-show="detalle.descuento_stock>parseFloat(detalle.stock)">Stock:
                                                    {{detalle.stock}} </span>
                                            </td>

                                            <td>

                                                <textarea style="font-size:0.8rem;" class="form-control"
                                                    v-model="detalle.descripcion" rows="2"></textarea>

                                            </td>
                                            <td style="font-size: 0.8rem">
                                                {{detalle.sub_total = (isNaN(detalle.costo_unitario*detalle.cantidad))? 0 : (detalle.costo_unitario*detalle.cantidad).toFixed(2)}}
                                            </td>

                                        </tr>

                                        <tr style="background-color: #eff4fe">
                                            <td colspan="5" align="right" style="font-size: 0.8rem;">
                                                <strong>Sub Total:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                {{datos.sub_total = isNaN(calcularSubTotal) ? 0 : calcularSubTotal.toFixed(2)}}
                                                bs</td>
                                        </tr>

                                        <tr style="background-color: #eff4fe">
                                            <td colspan="5" align="right" style="font-size: 0.8rem;">
                                                <strong>Total:</strong> </td>
                                            <td style="font-size: 0.8rem;">
                                                {{datos.total = datos.sub_total- datos.descuento}}
                                                bs
                                            </td>
                                        </tr>


                                    </tbody>

                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5" style="font-size: 0.8rem;">
                                                No
                                                hay Producto
                                                agregados</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="accionVenta==0" :disabled="guardando_venta_mesero_directa"
                            class="btn btn-success text-white" type="button" @click="guardarVentaDirecta()">Guardar
                            Venta</button>

                        <button v-else-if="accionVenta==1" class="btn btn-success text-white" type="button"
                            @click="detallePreventa2()">Agregar productos</button>

                        <button type="button" class="btn btn-danger text-white"
                            @click="cerrarModalDetalleVentaDirecta()">Cerrar</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- FIN VER DETALLE VENTA -->



        <!-- </div>   -->
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' :modal}" role="dialog" aria-labelledby="myModalLabel"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: #66b3ff">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click="cerrarModal()"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row mb-3">
                                <!-- <label for="inputPassword" class="col-sm-2 col-form-label">NIT/CI:</label> -->
                                <input type="text" class="form-control" v-model="datosCliente.matricula"
                                    placeholder="NIT/CI">
                            </div>
                            <!-- <div class="row mb-2" v-if="errores.matricula">
                                <div class="col-sm-2">&nbsp;</div>
                                <span class="text-danger">{{errores.matricula[0]}}</span></div>
                            </div> -->
                            <div class="row mb-3">
                                <!-- <label for="inputPassword" class="col-sm-2 col-form-label">Nombre</label> -->
                                <input type="text" class="form-control" v-model="datosCliente.nombre"
                                    placeholder="Nombre">
                            </div>
                            <!-- <div class="row mb-2" v-if="errores.nombre">
                                <div class="col-sm-2">&nbsp;</div>
                                <span class="text-danger">{{errores.nombre[0]}}</span></div>
                            </div> -->
                            <div class="row mb-3">
                                <!-- <label for="inputPassword" class="col-sm-2 col-form-label">Telefono</label> -->
                                <input type="number" class="form-control" v-model="datosCliente.telefono"
                                    placeholder="Telefono">
                            </div>
                            <div class="row mb-3">
                                <!-- <label for="inputPassword" class="col-sm-2 col-form-label">Correo</label> -->
                                <input type="text" class="form-control" v-model="datosCliente.email"
                                    placeholder="Correo">
                            </div>
                            <div class="row mb-3">
                                <!-- <label for="inputPassword" class="col-sm-2 col-form-label">Direccion</label> -->
                                <input type="text" class="form-control" v-model="datosCliente.direccion"
                                    placeholder="Direccion">
                            </div>
                            <!--<div class="row mb-3">
                               
                                <input type="number" class="form-control" v-model="datosCliente.descuento"
                                    placeholder="Descuento %">
                            </div>-->

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info text-white"
                            @click="verificarCaja(),guardarClienteM(),datosNuevoCliente(datosCliente)">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-info text-white"
                            @click="modificarCliente()">Modificar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->

    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    import moment from 'moment';
    export default {
        created() {
            this.usuarioNombre();
            this.usuarioAuth();
            this.selectTienda();
            this.datos.costo_pago = 1;
        },
        data() {
            return {
                datos: {
                    id: 0,
                    fecha: moment().format('YYYY-MM-DD'),
                    sub_total: 0,
                    descuento: 0,
                    total: 0,
                    id_salon: 0,
                    id_tipo_pago: 1,
                    id_forma_pago: 2,
                    id_cliente: 1,
                    cliente: '',
                    tipoPago: '',
                    formaPago: '',
                    costo_pago: '',
                    id_descuento: '',
                    personal: '',
                    estado: '',
                    tipo_venta: 'Venta Directa',
                    id_orden_servicio: null,
                    usuario: '',
                    id_mesa: 0,
                    mesa: '',
                    total_efectivo: 0,
                    total_deposito: 0,
                    efectivo: 0,
                    cambio: 0,
                    nro: 0,
                    descripcion: '',
                    monto: 0,
                    id_user: 0,
                    porcentaje: 0,
                },
                datosCliente: {
                    id: 0,
                    nombre: '',
                    matricula: '',
                    email: '',
                    descuento: 0,
                    telefono: '',
                    direccion: '',
                    descripcion: '',
                    estado: '1',
                    descuento: 0,
                },
                datosPago: {
                    id: 0,
                    fecha: moment().format('YYYY-MM-DD'),
                    fecha_final: moment().format('YYYY-MM-DD'),
                    //monto_total: 0,
                    saldo: 0,
                    anticipo: 0,
                    descripcion: '',
                },
                arrayVenta: [],
                arrayCategoria: [],
                arrayProducto: [],
                arraySalon: [],
                arrayMesa: [],
                arrayDetalle: [],
                arrayArticulo: [],
                arrayDetalleProducto: [],
                arrayProductoPaquete: [],
                //arrayDetallePaqueteProducto : [],
                arrayCliente: [],
                arrayCostoPago: [{
                    id: 1,
                    nombre: 'Unitario'
                }, {
                    id: 2,
                    nombre: 'Mayorista'
                }, {
                    id: 3,
                    nombre: 'Preferencial'
                }],
                arrayTipoCliente: [],
                arrayPersonal: [],
                arrayPago: [],
                arrayForma: [],
                arrayForma2: [],
                arrayOrden: [],
                arrayPaquete: [],
                listado: 0,
                tipoAccion: 0,
                errorPago: 0,
                errorMostrarMsjPago: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterioP: 'articulo.nombre',
                buscar: '',
                buscarP: '',
                isDisabled: true,
                isDisabledCliente: false,
                isDisabledProducto: false,
                isDisabledOrden: false,
                isDisabledPaquete: false,
                setTimeoutBuscador: '',
                setTimeoutBuscador2: '',
                isVisible: false,
                buscarCliente: '',
                estadoCaja: '',
                cantidad_producto: 0,
                usuario_nombre: 0,
                listadoMenu: 0,
                arrayDetalleSimpleAux: [],
                arrayDetalleSimple: [],
                arrayDetalleProductoSimple: [],
                arrayDetalleAux: [],
                arrayDetalleCompuesto: [],
                arrayDetalleProductoCompuesto: [],
                id_combo: '',
                id_combo2: '',
                arrayDetalleCombo: [],
                arrayDetalleProductoCombo: [],
                arrayDetalleElaboradoAux: [],
                arrayDetalleElaborado: [],
                arrayDetalleProductoElaborado: [],
                arrayDetalleProductoCombo2: [],
                arrayDet: [],
                arrayTienda: [],
                is_busy: 0,
                id_salon2: 0,
                id_venta: 0,
                contrasena_id: 0,
                usuario: {},
                estadoCaja: '',
                id_tienda: 1,
                id_categoria: 0,
                categoria: '',
                modalcobrar: 0,
                modaldetalleventa: 0,
                modaldetalleventadirecta: 0,
                modal: 0,
                mesa2: '',
                tituloModal: '',
                sub_listado: 0,
                mesaD: '',
                PreVenta: [],
                arrayDetalle: [],
                guardando_venta_mesero: false,
                guardando_venta_mesero_directa: false,
                cobrando_mesa: false,
                arrayDetalleModificar: [],
                monto_porcentaje_venta: 0,
                monto_total_ventas: 0,
                monto_total_efectivo: 0,
                monto_total_deposito: 0,
                monto_total_anulado: 0,
                monto_total_registrado: 0,

                accionVenta: 0,
                modificar_venta: false,
                tipo_venta: '',
            }
        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularSubTotal: function () {
                var resultado = 0.0;
                if (this.datos.tipo_venta == 'Venta Directa') {
                    for (var i = 0; i < this.arrayDetalle.length; i++) {

                        resultado = resultado + (this.arrayDetalle[i].costo_unitario * this.arrayDetalle[i]
                            .cantidad);
                    }
                } else {
                    for (var i = 0; i < this.arrayDetalle.length; i++) {
                        resultado = resultado + (this.arrayDetalle[i].costo_venta * this.arrayDetalle[i].cantidad);
                    }
                }

                return resultado;
            },

            calcularSaldoAnticipado: function () {
                this.datosPago.saldo = this.datos.total - this.datosPago.anticipo;
            },
            filteredCliente() {
                const data = this.datos.cliente.toLowerCase();
                if (this.datos.cliente == "") {
                    return this.arrayCliente;
                }
                return this.arrayCliente.filter((item) => {
                    return Object.values(item).some((word => String(word).toLowerCase().includes(data)))
                })
            },
            validarStock() {
                let me = this;
                //me.listarArticulo('', 'nombre_comercial');
                me.arrayDetalleProducto.forEach(
                    item => {
                        console.log('Prueba')
                        //item.cantidad_aux = item.cantidad*me.cantidad_producto;

                        me.arrayArticulo.forEach(item2 => {
                            item2.id == item.id_articulo ? (item2.stock = item2.stock - me
                                .cantidad_producto, console.log('Prueba')) : ''
                        })
                    });
            },
            calcularDescuento: function () {
                var resultado = 0.0;
                resultado = this.datos.descuento * this.datos.sub_total / 100;
                //this.aux=resultado;
                return resultado;
            },
            cantidadCarrito: function () {
                var resultado = 0.0;
                for (var i = 0; i < this.arrayDetalle.length; i++) {
                    resultado = resultado + 1;
                }
                return resultado;
            }

        },
        methods: {
            cerrarModalCobrarMesa() {
                this.modalcobrar = 0;
                this.datos.id_tipo_pago = 1;
                this.datos.id_forma_pago = 2;
                this.datos.efectivo = 0;
                this.datos.cambio = 0,
                    this.datos.total_efectivo = 0;
                this.datos.total_deposito = 0;
            },
            iniciarVentaDirecta() {
                this.listado = 3;
                this.tipo_venta = "directa";
                this.galCategoria2();
            },

            salirCajaCerrada() {
                if (this.estadoCaja == 'Cerrada') {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Caja cerrada...',
                        text: 'Espere a que se aperture una caja',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    document.getElementById('logout-form').submit();
                } else {
                    var url = '/arqueo_caja/cantidad_cajas_abiertas';
                    axios.get(url).then(function (response) {

                            if (response.data.cantidad_abiertas > 1) {
                                console.log(response.data.cantidad_abiertas);
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Hay más de una caja abierta...',
                                    text: 'Solo debe haber una caja abierta',
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                document.getElementById('logout-form').submit();
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },



            abrirModalDetalleVenta() {
                this.modaldetalleventa = 1;

            },
            abrirModalDetalleVentaDirecta() {
                this.modaldetalleventadirecta = 1;

            },
            cerrarModalDetalleVenta() {
                this.modaldetalleventa = 0;
            },
            cerrarModalDetalleVentaDirecta() {
                this.modaldetalleventadirecta = 0;

            },
            calcularMontoPorcentajeVenta() {
                let me = this;
                var url = '/venta/porcentaje_venta?id_user=' + me.datos.id_user;
                axios.get(url).then(function (response) {
                        me.monto_porcentaje_venta = response.data.monto_porcentaje;
                        me.monto_total_ventas = response.data.monto_total_ventas;
                        me.monto_total_efectivo = response.data.monto_total_efectivo;
                        me.monto_total_deposito = response.data.monto_total_deposito;
                        me.monto_total_anulado = response.data.monto_total_anulado;
                        me.monto_total_registrado = response.data.monto_total_registrado;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            Actualizar() {
                let me = this;
                // me.contador();
                me.preVenta();
                me.calcularMontoPorcentajeVenta();
                me.limpiar();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Sistema Actualizado...',
                    showConfirmButton: false,
                    timer: 1000
                });
            },
            limpiar() {
                //this.nmcliente='';
                this.arrayDetalle = [];
            },
            verDetalle(id, mesa) {
                let me = this;
                me.arrayDet = [];
                me.listado = 8;
                me.mesaD = mesa;
                var url = '/venta/cabecera?id_venta=' + id;
                axios.get(url).then(function (response) {
                        me.datos.cliente = response.data.cliente;
                        me.datos.monto = response.data.monto;
                        me.datos.total = response.data.total;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                var url = '/venta/detalle?id_venta=' + id;
                axios.get(url).then(function (response) {
                        me.arrayDet = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            actImpresion(id) {
                let me = this;
                //me.arrayVenta.id= id;
                //me.listado = 4;
                var url = '/venta_imp?id_venta=' + id;
                axios.put(url).then(function (response) {
                        //me.arrayDetalle = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Imprimiendo...',
                    showConfirmButton: false,
                    timer: 1000
                });
            },
            preVenta() {
                let me = this;
                me.listado = 0;
                me.datos.cliente = '';
                var url = '/venta_tienda1/ventaMesero?id_usuario=' + me.usuario.id;
                axios.get(url).then(function (response) {
                        me.arrayVenta = response.data;
                        // me.usuarioID()
                        // me.usuarioID2()

                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            verificarCaja() {
                let me = this;
                var url = '/arqueo_caja/estado_caja';
                axios.get(url).then(function (response) {
                        me.estadoCaja = response.data.estado;
                        //console.log('salir usuario');
                        me.salirCajaCerrada();

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                //setTimeOut(1000);
            },
            usuarioAuth() {
                let me = this;
                var url = '/usuario_auth';
                axios.get(url).then(function (response) {
                        me.usuario = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            selectTienda() {
                let me = this;
                var url = '/tienda/selectTienda';
                axios.get(url).then(function (response) {
                        me.arrayTienda = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            guardarCliente() {
                if (this.datos.cliente != '') {
                    this.datos.id_cliente = 0;
                } else {
                    this.datos.id_cliente = 1;
                }

            },
            ocultar() {
                this.isVisible = !(this.isVisible);
                setTimeout(() => {
                    this.isVisible = false;
                }, 10000);
            },
            contadorStock(detalle) {
                var totalCantidad = 0;

                //var costo_venta = detalle.costo_venta;
                var id_tipo_producto = detalle.id_tipo_producto;
                var id_producto_compuesto = detalle.id_producto_compuesto;
                var id_producto = detalle.id_articulo;
                var detalle_cantidad = detalle.cantidad;
                var cantidad_presentacion = detalle.cantidad_presentacion;

                // if(id_tipo_producto == 2){
                //     this.agregarProductoElaborado(id_producto,detalle_cantidad);
                // }
                if (id_tipo_producto == 3) {
                    this.agregarProductoSimple(id_producto, detalle_cantidad);
                }
                if (id_tipo_producto == 4) {
                    this.agregarProductoCompuesto(id_producto_compuesto, detalle_cantidad, cantidad_presentacion);
                }
                if (id_tipo_producto == 5) {
                    //this.agregarCombo(id_producto,detalle_cantidad);
                    this.agregarCombo2(id_producto, detalle_cantidad);
                    this.agregarProductoCompuestoCombo(id_producto_compuesto, detalle_cantidad);
                }
            },
            ventaDirecta() {
                let me = this;
                me.listado = 2;
                me.is_busy = 0;
                me.arrayDetalle = [];
                var url = '/categoria2';
                axios.get(url).then(function (response) {
                        me.arrayCategoria = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)


                    });
            },
            listarSalon() {
                let me = this;
                me.id_venta = 0;
                var url = '/salon/selectSalon';
                axios.get(url).then(function (response) {
                        me.arraySalon = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            galMesa(id, nombre) {
                let me = this;
                me.listado = 2;
                me.datos.id_salon = id;
                me.datos.mesa = nombre;
                me.id_salon2 = id;
                me.mesa2 = nombre;
                var url = '/mesa2?id_salon=' + id;
                axios.get(url).then(function (response) {
                        me.arrayMesa = response.data;
                        //me.datos.id_mesa = response.data[0].id;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            galSalon() {
                let me = this;
                me.listado = 1;
                var url = '/salon/selectSalonVenta?id_tienda=' + me.usuario.id_tienda;
                axios.get(url).then(function (response) {
                        me.arraySalon = response.data;
                        //me.datos.id_mesa = response.data[0].id;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            galCategoria(mesa) {
                let me = this;
                me.accionVenta = 0;
                me.is_busy = 0;
                me.datos.cliente = '';
                me.arrayDetalle = [];
                me.listado = 3;
                me.datos.id_mesa = mesa.id;
                me.datos.mesa = mesa.nombre;
                var url = '/categoria2';
                axios.get(url).then(function (response) {
                        me.arrayCategoria = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)


                    });
            },
            galCategoria2() { // Para venta directa
                let me = this;
                me.accionVenta = 0;
                me.is_busy = 0;
                me.datos.cliente = '';
                me.arrayDetalle = [];
                me.listado = 3;

                var url = '/categoria2';
                axios.get(url).then(function (response) {
                        me.arrayCategoria = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            agregarArticuloDet() {
                let me = this;
                me.is_busy = 0;
                me.sub_listado = 1;
                //me.galCategoria2();
                me.galCategoriaModificar();
            },
            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "cliente": {
                        switch (accion) {
                            case 'registrar': {
                                this.modal = 1;
                                this.tituloModal = 'Registro de Cliente'
                                this.datosCliente = {
                                    id: 0,
                                    nombre: '',
                                    matricula: '',
                                    telefono: '',
                                    direccion: '',
                                    descripcion: '',
                                    id_descuento: 1,
                                    estado: '1',
                                    email: '',
                                    descuento: 0
                                }
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'modificar': {
                                this.modal = 1;
                                this.tituloModal = 'Modificar Cliente';
                                this.tipoAccion = 2;
                                this.datos.id = data['id'];
                                this.datos.nombre = data['nombre'];
                                this.datos.matricula = data['matricula'];
                                this.datos.telefono = data['telefono'];
                                this.datos.direccion = data['direccion'];
                                this.datos.descripcion = data['descripcion'];
                                this.datos.ciudad = data['ciudad'];
                                this.datos.estado = data['estado'];
                                this.datos.fecha_nacimiento = data['fecha_nacimiento'];
                                this.datos.descuento = data['descuento'];
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.datosCliente = {
                    id: 0,
                    nombre: '',
                    matricula: '',
                    telefono: '',
                    direccion: '',
                    descripcion: '',
                    estado: '1',
                    descuento: 0,
                    ciudad: '',
                    fecha_nacimiento: moment().format('YYYY-MM-DD'),

                };
                this.errores = {};
            },
            galCategoriaModificar() {
                let me = this;
                // me.contadorModificar();
                // me.preVenta();
                me.listado = 6;

                var url = '/categoria2';
                axios.get(url).then(function (response) {
                        me.arrayCategoria = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)


                    });

            },
            galProductos(id, nombre) {
                let me = this;
                me.id_categoria = id;
                me.listado = 4;
                me.categoria = nombre;

                if (me.usuario.id_tienda == 100) {
                    var url = '/producto?id_categoria=' + id + '&id_tienda=' + me.id_tienda;
                    axios.get(url).then(function (response) {
                            me.arrayProducto = response.data;
                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                    //me.arrayDetalle = [];
                } else {
                    var url = '/producto?id_categoria=' + id + '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function (response) {
                            me.arrayProducto = response.data;
                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                }
            },
            galProductos2(id, nombre) {
                let me = this;
                me.id_categoria = id;
                me.listado = 7;
                me.categoria = nombre;

                if (me.usuario.id_tienda == 100) {
                    var url = '/producto?id_categoria=' + id + '&id_tienda=' + me.id_tienda;
                    axios.get(url).then(function (response) {
                            me.arrayProducto = response.data;
                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                    //me.arrayDetalle = [];
                } else {
                    var url = '/producto?id_categoria=' + id + '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function (response) {
                            me.arrayProducto = response.data;
                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                }
            },
            selectProductoCat: function () {
                let me = this;
                if (me.usuario.id_tienda == 100) {
                    var url = '/buscar/producto?buscar=' + me.buscar + '&id_categoria=' + me.id_categoria +
                        '&id_tienda=' + me.id_tienda;
                    axios.get(url).then(function (response) {
                            me.arrayProducto = response.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    var url = '/buscar/producto?buscar=' + me.buscar + '&id_categoria=' + me.id_categoria +
                        '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function (response) {
                            me.arrayProducto = response.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }

            },
            detallePreventa2() {
                let me = this;
                if (this.arrayDetalle.length <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'No Existe productos agregados!'
                    })
                } else {
                    me.listado = 5;
                    me.selectCliente();

                }
                if (me.accionVenta == 1) {
                    me.cerrarModalDetalleVenta();
                }
            },
            encuentraProductoSimpleDelete(id) {
                for (var i = 0; i < this.arrayDetalleProductoSimple.length; i++) {
                    if (this.arrayDetalleProductoSimple[i].id_producto == id) {
                        this.eliminarDetalleProductoSimple(i);
                    }
                }
            },
            encuentraProductoElaboradoDelete(id) {
                for (var i = 0; i < this.arrayDetalleProductoElaborado.length; i++) {
                    if (this.arrayDetalleProductoElaborado[i].id_producto == id) {
                        this.eliminarDetalleProductoElaborado(i);
                    }
                }
            },
            encuentraProductoCompuestoDelete(id) {
                for (var i = 0; i < this.arrayDetalleProductoCompuesto.length; i++) {
                    if (this.arrayDetalleProductoCompuesto[i].id_producto == id) {
                        this.eliminarDetalleProductoCompuesto(i);
                    }
                }
            },
            encuentraCombo(combo) {
                this.arrayDetalleProductoAux = this.arrayDetalleProductoCombo;
                var cont = 0;
                for (var i = 0; i < this.arrayDetalleProductoCombo.length; i++) {
                    //console.log('cantidad',this.arrayDetalleProductoCombo.length )
                    if (this.arrayDetalleProductoCombo[i].id_combo == combo) {
                        cont++;
                    }

                }
                //console.log(cont);


                for (var i = 0; i < this.arrayDetalleProductoCombo.length; i++) {
                    //console.log('cantidad',this.arrayDetalleProductoCombo.length )
                    if (this.arrayDetalleProductoCombo[i].id_combo == combo) {
                        //console.log(this.arrayDetalleProductoCombo,'-',i)
                        this.eliminarDetalleCombo(i, cont);
                        i = 0;
                    }

                }


            },
            datosNuevoCliente(cliente) {
                //console.log(cliente);
                this.datosCliente = cliente;
                /*setTimeout(() => {
                    //this.obtenerCliente();
                }, 1000)*/
                this.datos.cliente = cliente.nombre;
                this.datos.id_cliente = 0;
                //this.datos.descuento = cliente.descuento * this.datos.sub_total / 100;
                //this.listarCliente("");
                this.selectCliente();
            },
            async guardarClienteM() {
                // if(this.validarCliente()){
                //     return;
                // }
                try {
                    let me = this;
                    //me.verificarCaja();
                    //setTimeOut(1500);
                    const res = await axios.post('/cliente/guardar', this.datosCliente);
                    if (res.data.error == 0) {
                        //me.$toaster.error('Matricula ya existe...');
                        Swal.fire({
                            icon: 'error',
                            title: 'Nombre ya existe...',
                            text: 'Debe usar otro Nombre!'
                        })
                        this.validacionError('Nombre ya existe... ¡Debe usar otro Nombre!', 5000);

                        this.is_busy = 0;
                    } else {
                        me.cerrarModal();

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Registro agregado...',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                } catch (error) {
                    if (error.response.data) {
                        this.errores = error.response.data.errors;
                        this.is_busy = 0;
                    }
                }
            },
            async encuentraProductoCombo2Delete(id) {
                try {
                    var url = '/combo2?id=' + id;
                    const res = await axios.get(url)
                    // me.id_receta=(res.data[0].id).toString();
                    this.id_combo2 = (res.data[0].id).toString();

                    var url = '/combo/detalleCombo2?id=' + this.id_combo2;
                    const res2 = await axios.get(url)
                    this.arrayDetalleProductoCombo2 = res2.data;
                    console.log(id)
                    var cont = 0;

                    this.arrayDetalleProductoCombo.forEach((item, index1) => {
                        this.arrayDetalleProductoCombo2.forEach((item2, index2) => {
                            if (item.id_combo == this.id_combo2)
                            // if(item.id_combo==this.id_combo2 && item.id_producto == item2.id_producto)
                            {
                                console.log(item.id_producto);
                                this.eliminarDetalleCombo2(index1);
                            }
                        })
                    })
                    //console.log('prueba= ',this.arrayDetalleProductoCombo);

                } catch (error) {
                    console.log(error);
                }

            },
            eliminarDetalleCombo2(index) {
                let me = this;
                me.arrayDetalleProductoCombo.splice(index, 1);

            },
            eliminarDetalleCombo(index, cont) {
                let me = this;
                this.arrayDetalleProductoCombo.splice(index, cont);

            },
            eliminarDetalleProductoSimple(index) {
                let me = this;
                me.arrayDetalleProductoSimple.splice(index, 1);
            },
            eliminarDetalleProductoCombo2(index, id_combo) {
                let me = this;
                me.arrayDetalleProductoCombo.find(item => {
                    if (item.id_combo == id_combo) {
                        me.arrayDetalleProductoCombo.splice(index, item.cont);
                    }
                });
            },
            eliminarDetalleProductoElaborado(index) {
                let me = this;
                me.arrayDetalleProductoElaborado.splice(index, 1);
            },
            eliminarDetalleProductoCompuesto(index) {
                let me = this;
                me.arrayDetalleProductoCompuesto.splice(index, 1);
            },
            encuentraDelete(id) {
                for (var i = 0; i < this.arrayDetalle.length; i++) {
                    if (this.arrayDetalle[i].id_articulo == id) {
                        this.eliminarDetalle(i);

                        //this.galProductos(this.id_categoria);
                    }
                }
            },
            agregarProductoCheck(data = []) {
                let me = this;
                me.encuentraDelete(data['Id_Producto'])
                me.encuentraProductoSimpleDelete(data['Id_Producto'])
                Swal.fire({
                    title: 'Mesa N. : ' + me.datos.mesa + '\n' + 'Ingrese la cantidad \n' + data[
                        'descripcion'] + '\n' + data['precio'] + ' bs.',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {

                        if (cant == 0) {
                            Swal.showValidationMessage(
                                `Cantidad no puede ser 0`
                            );
                        } else {
                            if (cant < 0) {
                                Swal.showValidationMessage(
                                    `Cantidad no puede ser negativo`
                                );
                            } else {
                                if (cant == '') {
                                    Swal.showValidationMessage(
                                        `Cantidad esta Vacia`
                                    );
                                } else {
                                    if ((cant > parseInt(data['stock']) || cant == '') && data['estado'] ==
                                        1 && data['id_tipo_producto'] != 2 && data['id_tipo_producto'] != 5
                                    ) {
                                        Swal.showValidationMessage(
                                            `Cantidad invalida :)`
                                        )
                                    } else {
                                        if (data['id_tipo_producto'] == 5) {
                                            me.agregarCombo2(data['Id_Producto'], cant);
                                            setTimeout(() => {

                                                if (me.arrayDetalleProductoCombo.find(seg => (
                                                        parseFloat(seg.stock) - parseFloat(seg
                                                            .cantidad) < 0 && seg
                                                        .id_tipo_producto != 2))) {

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
                                                        me.encuentraDelete(data[
                                                            'Id_Producto'])
                                                        me.encuentraProductoCombo2Delete(
                                                            data['Id_Producto'])
                                                    }, "1000")

                                                    //me.arrayDetalleCombo=[];
                                                    //me.arrayDetalleProductoCombo=[];
                                                } else {
                                                    //console.log(me.arrayDetalleProductoCombo)
                                                    //me.galProductos(me.id_categoria);

                                                    me.arrayDetalle.push({
                                                        id_tienda_articulo: data[
                                                            'Id_Producto'],
                                                        id_articulo: data['Id_Producto'],
                                                        cantidad: parseFloat(cant),
                                                        cantidadAux: parseFloat(cant),
                                                        articulo: data['descripcion'],
                                                        precio: data['precio'],
                                                        costo_unitario: data['precio'],
                                                        costo_venta: data['precio'],
                                                        //combo : data['Combo'],
                                                        preciov: 0,
                                                        stock: parseInt(data['stock']),
                                                        producto_venta: 'Venta Producto',
                                                        sub_total: (cant * data['precio']),
                                                        cantidad_presentacion: (cant * data[
                                                            'contenido_presentacion'
                                                        ]),
                                                        id_producto_compuesto: data[
                                                            'id_producto_compuesto'],
                                                        id_tipo_producto: data[
                                                            'id_tipo_producto'],

                                                        //tipo_producto: data['tipo_producto']
                                                    });
                                                }
                                            }, "700")


                                        } else {
                                            me.arrayDetalle.push({
                                                id_tienda_articulo: data['Id_Producto'],
                                                id_articulo: data['Id_Producto'],
                                                cantidad: parseFloat(cant),
                                                cantidadAux: parseFloat(cant),
                                                articulo: data['descripcion'],
                                                precio: data['precio'],
                                                costo_unitario: data['precio'],
                                                costo_venta: data['precio'],
                                                //combo : data['Combo'],
                                                preciov: 0,
                                                stock: parseInt(data['stock']),
                                                producto_venta: 'Venta Producto',
                                                sub_total: (cant * data['precio']),
                                                cantidad_presentacion: (cant * data[
                                                    'contenido_presentacion']),
                                                id_producto_compuesto: data[
                                                    'id_producto_compuesto'],
                                                id_tipo_producto: data['id_tipo_producto'],

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
                        if (data['id_tipo_producto'] == 3) {
                            me.agregarProductoSimple(data['Id_Producto'], cant);
                        }
                        if (data['id_tipo_producto'] == 4) {
                            me.agregarProductoCompuesto(data['id_producto_compuesto'], cant, data[
                                'contenido_presentacion']);
                        }
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
            agregarProductoCheck2(data = []) {
                let me = this;
                me.encuentraDelete(data['Id_Producto'])
                me.encuentraProductoSimpleDelete(data['Id_Producto'])
                Swal.fire({
                    title: 'Modificar Mesa N.: ' + me.datos.mesa + '\n' + 'Ingrese la cantidad \n' + data[
                        'descripcion'] + '\n' + data['precio'] + ' bs.',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {
                        me.encuentraDelete(data['Id_Producto'])
                        if (cant == 0) {
                            Swal.showValidationMessage(
                                `Cantidad no puede ser 0`
                            );
                        } else {
                            if (cant < 0) {
                                Swal.showValidationMessage(
                                    `Cantidad no puede ser negativo`
                                );
                            } else {
                                if (cant == '') {
                                    Swal.showValidationMessage(
                                        `Cantidad esta Vacia`
                                    );
                                } else {
                                    if ((cant > parseInt(data['stock']) || cant == '') && data['estado'] ==
                                        1 && data['id_tipo_producto'] != 2 && data['id_tipo_producto'] != 5
                                    ) {
                                        Swal.showValidationMessage(
                                            `Cantidad invalida :)`
                                        )
                                    } else {
                                        if (data['id_tipo_producto'] == 5) {
                                            //console.log('Hola');
                                            me.agregarCombo2(data['Id_Producto'], cant);
                                            setTimeout(() => {

                                                if (me.arrayDetalleProductoCombo.find(seg => (
                                                        parseFloat(seg.stock) - parseFloat(seg
                                                            .cantidad) < 0 && seg
                                                        .id_tipo_producto != 2))) {

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
                                                        me.encuentraDelete(data[
                                                            'Id_Producto'])
                                                        me.encuentraProductoCombo2Delete(
                                                            data['Id_Producto'])
                                                    }, "1000")
                                                } else {
                                                    console.log(me.arrayDetalleProductoCombo)
                                                    //me.galProductos(me.id_categoria);

                                                    me.arrayDetalle.push({
                                                        id_tienda_articulo: data[
                                                            'Id_Producto'],
                                                        id_articulo: data['Id_Producto'],
                                                        cantidad: parseFloat(cant),
                                                        cantidadAux: parseFloat(cant),
                                                        articulo: data['descripcion'],
                                                        precio: data['precio'],
                                                        costo_unitario: data['precio'],
                                                        costo_venta: data['precio'],
                                                        Estado: 1,
                                                        //combo : data['Combo'],
                                                        preciov: 0,
                                                        stock: parseInt(data['stock']),
                                                        producto_venta: 'Venta Producto',
                                                        cantidad_presentacion: (cant * data[
                                                            'contenido_presentacion'
                                                        ]),
                                                        id_producto_compuesto: data[
                                                            'id_producto_compuesto'],
                                                        id_tipo_producto: data[
                                                            'id_tipo_producto'],

                                                        //tipo_producto: data['tipo_producto']
                                                    });
                                                }
                                            }, "700")

                                        } else {
                                            me.arrayDetalle.push({
                                                id_tienda_articulo: data['Id_Producto'],
                                                Estado: 1,
                                                id_articulo: data['Id_Producto'],
                                                cantidad: parseFloat(cant),
                                                articulo: data['descripcion'],
                                                precio: data['precio'],
                                                costo_unitario: data['precio'],
                                                costo_venta: data['precio'],
                                                //combo : data['Combo'],
                                                preciov: 0,
                                                stock: parseInt(data['stock']),
                                                producto_venta: 'Venta Producto',
                                                cantidad_presentacion: (cant * data[
                                                    'contenido_presentacion']),
                                                id_producto_compuesto: data[
                                                    'id_producto_compuesto'],
                                                id_tipo_producto: data['id_tipo_producto'],

                                                //tipo_producto: data['tipo_producto']
                                            });
                                            me.calcularDescuento.toFixed(2);
                                        }
                                    }
                                }
                            }
                        }
                        //me.contadorStock(det);
                        // if(data['id_tipo_producto'] == 2){
                        //     me.agregarProductoElaborado(data['Id_Producto'],cant);
                        // }
                        if (data['id_tipo_producto'] == 3) {
                            me.agregarProductoSimple(data['Id_Producto'], cant);
                        }
                        if (data['id_tipo_producto'] == 4) {
                            me.agregarProductoCompuesto(data['id_producto_compuesto'], cant, data[
                                'contenido_presentacion']);
                        }
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
                            timer: 500
                        });
                    }
                })
                //}
            },
            agregarProductoCheck3(data = []) {
                let me = this;
                me.encuentraProductoSimpleDelete(data['Id_Producto'])
                me.encuentraProductoElaboradoDelete(me.id_combo)
                Swal.fire({
                    title: 'Ingrese la cantidad\n' + data['descripcion'] + 'ㅤ \n' + data['precio'] + ' bs.',
                    // title: 'Mesa N. : '+me.datos.mesa+'\n'+'Ingrese la cantidad \n'+data['descripcion']+'\n'+data['precio']+' bs.',

                    // title: 'Pedido N. : '+me.arrayContador[0].Correlativo+'\n'+'ㅤㅤ'+'Ingrese la cantidad ㅤㅤㅤ \n'+data['descripcion']+'ㅤ \n'+data['precio']+' bs.',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {
                        me.encuentraDelete(data['Id_Producto'])
                        if (cant == 0) {
                            Swal.showValidationMessage(
                                `Cantidad no puede ser 0`
                            );
                        } else {
                            if (cant < 0) {
                                Swal.showValidationMessage(
                                    `Cantidad no puede ser negativo`
                                );
                            } else {
                                if (cant == '') {
                                    Swal.showValidationMessage(
                                        `Cantidad esta Vacia`
                                    );
                                } else {
                                    if ((cant > parseInt(data['stock']) || cant == '') && data['estado'] ==
                                        1 && data['id_tipo_producto'] != 2 && data['id_tipo_producto'] != 5
                                    ) {
                                        Swal.showValidationMessage(
                                            `Cantidad invalida :)`
                                        )
                                    } else {
                                        if (data['id_tipo_producto'] == 5) {
                                            //console.log('Hola')
                                            me.agregarCombo2(data['Id_Producto'], cant);
                                            setTimeout(() => {

                                                if (me.arrayDetalleProductoCombo.find(seg => (
                                                        parseFloat(seg.stock) - parseFloat(seg
                                                            .cantidad) < 0))) {

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
                                                        me.encuentraDelete(data[
                                                            'Id_Producto'])
                                                        me.encuentraProductoCombo2Delete(
                                                            data['Id_Producto'])
                                                    }, "1000")
                                                    //me.arrayDetalleProductoCombo=[];
                                                    //me.arrayDetalleCombo=[];
                                                } else {
                                                    console.log(me.arrayDetalleProductoCombo)
                                                    //me.galProductos(me.id_categoria);

                                                    me.arrayDetalle.push({
                                                        id_tienda_articulo: data[
                                                            'Id_Producto'],
                                                        id_articulo: data['Id_Producto'],
                                                        cantidad: parseFloat(cant),
                                                        cantidadAux: parseFloat(cant),
                                                        articulo: data['descripcion'],
                                                        precio: data['precio'],
                                                        costo_unitario: data['precio'],
                                                        costo_venta: data['precio'],
                                                        //combo : data['Combo'],
                                                        preciov: 0,
                                                        stock: parseInt(data['stock']),
                                                        producto_venta: 'Venta Producto',
                                                        cantidad_presentacion: (cant * data[
                                                            'contenido_presentacion'
                                                        ]),
                                                        id_producto_compuesto: data[
                                                            'id_producto_compuesto'],
                                                        id_tipo_producto: data[
                                                            'id_tipo_producto'],

                                                        //tipo_producto: data['tipo_producto']
                                                    });
                                                }
                                            }, "700")

                                        } else {
                                            me.arrayDetalle.push({
                                                id_tienda_articulo: data['Id_Producto'],
                                                id_articulo: data['Id_Producto'],
                                                cantidad: parseFloat(cant),
                                                articulo: data['descripcion'],
                                                precio: data['precio'],
                                                costo_unitario: data['precio'],
                                                costo_venta: data['precio'],
                                                //combo : data['Combo'],
                                                preciov: 0,
                                                stock: parseInt(data['stock']),
                                                producto_venta: 'Venta Producto',
                                                cantidad_presentacion: (cant * data[
                                                    'contenido_presentacion']),
                                                id_producto_compuesto: data[
                                                    'id_producto_compuesto'],
                                                id_tipo_producto: data['id_tipo_producto'],

                                                //tipo_producto: data['tipo_producto']
                                            });
                                        }
                                    }
                                }
                            }
                        }

                        // if(data['id_tipo_producto'] == 2){
                        //     me.agregarProductoElaborado(data['Id_Producto'],cant);
                        // }
                        if (data['id_tipo_producto'] == 3) {
                            me.agregarProductoSimple(data['Id_Producto'], cant);
                        }
                        if (data['id_tipo_producto'] == 4) {
                            me.agregarProductoCompuesto(data['id_producto_compuesto'], cant, data[
                                'contenido_presentacion']);
                        }
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
                            timer: 500
                        });
                    }
                })
                // }
            },
            agregarProductoElaborado(id, cant) {
                let me = this;
                //console.log(cant);
                var url = '/producto/elaborado?id_producto=' + id;
                axios.get(url).then(function (response) {
                        me.arrayDetalleElaboradoAux = response.data;

                        //me.arrayDetalleProductoElaborado= response.data;
                        me.arrayDetalleElaboradoAux.forEach(item => {
                            item.cantidad = cant
                            item.estadoN = 0

                        });
                        //console.log(me.arrayDetalleElaboradoAux);
                        if (me.arrayDetalleElaborado.length == 0) {
                            me.arrayDetalleElaborado = me.arrayDetalleElaboradoAux;
                            me.arrayDetalleProductoElaborado = me.arrayDetalleElaboradoAux;
                            //console.log('prueba');

                            //Combo
                            me.arrayDetalleProductoCombo.forEach(item => {
                                me.arrayDetalle.forEach(item2 => {
                                    if (item.id_producto == item2.id_articulo) {
                                        // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })
                            //interno
                            me.arrayDetalleProductoCombo.forEach(item => {
                                me.arrayDetalleProductoElaborado.forEach(item2 => {
                                    if (item.id_producto == item2.id_producto) {
                                        // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })

                        } else {
                            me.arrayDetalleElaborado = me.arrayDetalleElaborado.concat(me.arrayDetalleElaboradoAux);
                            me.encuentraProductoElaboradoDelete(id)
                            me.arrayDetalleProductoElaborado = me.arrayDetalleProductoElaborado.concat(me
                                .arrayDetalleElaboradoAux);
                            //console.log(me.arrayDetalleElaborado);
                            //Combo
                            me.arrayDetalleProductoCombo.forEach(item => {
                                me.arrayDetalle.forEach(item2 => {
                                    if (item.id_producto == item2.id_articulo) {
                                        // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })
                            //interno
                            me.arrayDetalleProductoCombo.forEach(item => {
                                me.arrayDetalleProductoElaborado.forEach(item2 => {
                                    if (item.id_producto == item2.id_producto) {
                                        // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })

                        }
                        if (me.arrayDetalleProductoElaborado.find(seg => (seg.stock - ((seg.cantidad)) < 0 && seg
                                .estadoN == 0))) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'No hay stock para el producto!'
                            })
                            me.encuentraProductoElaboradoDelete(id)
                            me.encuentraDelete(id)


                            // me.arrayDetalle=[];
                            //me.arrayDetalleProductoElaborado=[];
                            //me.arrayDetalleProductoCompuesto=[];
                        } else {
                            //me.arrayDetalleCombo.forEach(item => item.stock =parseInt(item.stock)-(parseInt(item.cantidad)));
                            // Swal.fire({
                            //     position: 'top-end',
                            //     icon: 'success',
                            //     title: 'Producto agregado...',
                            //     showConfirmButton: false,
                            //     timer: 500
                            // });

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
            agregarProductoSimple(id, cant) {
                let me = this;
                //console.log(cant);
                var url = '/producto/simple?id_producto=' + id;
                axios.get(url).then(function (response) {
                        me.arrayDetalleSimpleAux = response.data;

                        //me.arrayDetalleProductoSimple= response.data;
                        me.arrayDetalleSimpleAux.forEach(item => {
                            item.cantidad = cant
                            item.estadoN = 0

                        });
                        //console.log(me.arrayDetalleSimpleAux);
                        if (me.arrayDetalleSimple.length == 0) {
                            me.arrayDetalleSimple = me.arrayDetalleSimpleAux;
                            me.arrayDetalleProductoSimple = me.arrayDetalleSimpleAux;
                            //console.log('prueba');
                            //Combo
                            me.arrayDetalleProductoCombo.forEach(item => {
                                me.arrayDetalle.forEach(item2 => {
                                    if (item.id_producto == item2.id_articulo) {
                                        // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })
                            //interno
                            me.arrayDetalleProductoCombo.forEach(item => {
                                me.arrayDetalleProductoSimple.forEach(item2 => {
                                    if (item.id_producto == item2.id_producto) {
                                        // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })


                        } else {
                            me.arrayDetalleSimple = me.arrayDetalleSimple.concat(me.arrayDetalleSimpleAux);
                            me.encuentraProductoSimpleDelete(id)
                            me.arrayDetalleProductoSimple = me.arrayDetalleProductoSimple.concat(me
                                .arrayDetalleSimpleAux);
                            //console.log(me.arrayDetalleSimple);

                            //Combo
                            me.arrayDetalleProductoCombo.forEach(item => {
                                me.arrayDetalle.forEach(item2 => {
                                    if (item.id_producto == item2.id_articulo) {
                                        // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })
                            //interno
                            me.arrayDetalleProductoCombo.forEach(item => {
                                me.arrayDetalleProductoSimple.forEach(item2 => {
                                    if (item.id_producto == item2.id_producto) {
                                        // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })


                        }
                        if (me.arrayDetalleProductoSimple.find(seg => (seg.stock - ((seg.cantidad)) < 0 && seg
                                .estadoN == 0))) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'No hay stock para el producto!'
                            })
                            me.encuentraProductoSimpleDelete(id)
                            me.encuentraDelete(id)
                            // me.arrayDetalle=[];
                            //me.arrayDetalleProductoSimple=[];
                        } else {
                            //me.arrayDetalleCombo.forEach(item => item.stock =parseInt(item.stock)-(parseInt(item.cantidad)));
                            // Swal.fire({
                            //     position: 'top-end',
                            //     icon: 'success',
                            //     title: 'Producto agregado...',
                            //     showConfirmButton: false,
                            //     timer: 500
                            // });

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
            agregarProductoCompuesto(id, cant, contenido) {
                let me = this;
                var url = '/producto/compuesto?id_producto=' + id;
                axios.get(url).then(function (response) {
                        me.arrayDetalleAux = response.data;
                        //me.arrayDetalleProductoCompuesto= response.data;
                        me.arrayDetalleAux.forEach(item => item.cantidad = cant * contenido);
                        //console.log(me.arrayDetalleAux);
                        if (me.arrayDetalleCompuesto.length == 0) {
                            me.arrayDetalleCompuesto = me.arrayDetalleAux;
                            me.arrayDetalleProductoCompuesto = me.arrayDetalleAux;
                            //console.log('prueba');

                        } else {
                            me.arrayDetalleCompuesto = me.arrayDetalleCompuesto.concat(me.arrayDetalleAux);
                            me.encuentraProductoCompuestoDelete(id)
                            me.arrayDetalleProductoCompuesto = me.arrayDetalleProductoCompuesto.concat(me
                                .arrayDetalleAux);
                            //console.log(me.arrayDetalleCompuesto);

                        }
                        if (me.arrayDetalleProductoCompuesto.find(seg => (seg.stock - ((seg.cantidad)) < 0))) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'No hay stock para el producto!'
                            })
                            me.arrayDetalle = [];
                            me.arrayDetalleProductoCompuesto = [];
                        } else {
                            //me.arrayDetalleCombo.forEach(item => item.stock =parseInt(item.stock)-(parseInt(item.cantidad)));
                            // Swal.fire({
                            //     position: 'top-end',
                            //     icon: 'success',
                            //     title: 'Producto agregado...',
                            //     showConfirmButton: false,
                            //     timer: 500
                            // });

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
            agregarProductoCompuestoCombo(id, cant) {
                let me = this;
                var url = '/producto/compuesto?id_producto=' + id;
                axios.get(url).then(function (response) {
                        me.arrayDetalleAux = response.data;
                        //me.arrayDetalleProductoCompuesto= response.data;
                        me.arrayDetalleAux.forEach(item => item.cantidad = cant);
                        //console.log(me.arrayDetalleAux);
                        if (me.arrayDetalleCompuesto.length == 0) {
                            me.arrayDetalleCompuesto = me.arrayDetalleAux;
                            me.arrayDetalleProductoCompuesto = me.arrayDetalleAux;
                            //console.log('prueba');
                        } else {
                            me.arrayDetalleCompuesto = me.arrayDetalleCompuesto.concat(me.arrayDetalleAux);
                            me.encuentraProductoCompuestoDelete(id)
                            me.arrayDetalleProductoCompuesto = me.arrayDetalleProductoCompuesto.concat(me
                                .arrayDetalleAux);
                            //console.log(me.arrayDetalleCompuesto);

                        }
                        if (me.arrayDetalleProductoCompuesto.find(seg => (seg.stock - ((seg.cantidad)) < 0))) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'No hay stock para el producto!'
                            })
                            me.arrayDetalle = [];
                            me.arrayDetalleProductoCompuesto = [];
                        } else {
                            //me.arrayDetalleCombo.forEach(item => item.stock =parseInt(item.stock)-(parseInt(item.cantidad)));
                            // Swal.fire({
                            //     position: 'top-end',
                            //     icon: 'success',
                            //     title: 'Producto agregado...',
                            //     showConfirmButton: false,
                            //     timer: 500
                            // });

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
            async agregarCombo(id, cant) {
                let me = this;
                try {
                    var url = '/combo2?id=' + id;
                    const res = await axios.get(url)
                    // me.id_receta=(res.data[0].id).toString();
                    me.id_combo = (res.data[0].id).toString();

                    // me.arrayReceta.forEach(item2 => {
                    // var url='/receta/detalle?id=' + me.arrayReceta[0].id;
                    // axios.get(url).then(function(response){
                    // me.arrayDetalleCombo = response.data;
                    // var url='/receta/detalle?id=' + me.id_receta;
                    var url = '/combo/detalleCombo2?id=' + me.id_combo;
                    const res2 = await axios.get(url)
                    me.arrayDetalleCombo = res2.data;

                    me.arrayDetalleCombo.forEach(item => {
                        if (item.id_tipo_producto == 2) {
                            item.cantidad = parseInt(item.cantidad) * cant
                            item.cantidadAux = cant
                            item.estadoN = 0
                        }
                        if (item.id_tipo_producto == 3) {
                            item.cantidad = parseInt(item.cantidad) * cant
                            item.cantidadAux = cant
                            item.estadoN = 0
                        }
                        // if(item.id_tipo_producto == 4){
                        //     item.cantidad =parseInt(item.cantidad)*cant
                        //     //console.log(item.cantidad);
                        //         me.agregarProductoCompuestoCombo(item.id_producto_compuesto,item.cantidad)
                        //     }
                    });

                    // me.arrayDetalleProductoCombo=me.arrayDetalleProductoCombo.concat(me.arrayDetalleCombo);
                    // me.encuentraCombo(me.id_receta);

                    if (me.arrayDetalleProductoCombo.length == 0) {
                        me.arrayDetalleProductoCombo = me.arrayDetalleCombo;
                        //me.arrayDetalleRecetaAux = me.arrayDetalleCombo;
                        //me.arrayDetalleProductoAux = me.arrayDetalleProductoCombo;

                        // me.arrayDetalleRecetaAux = me.arrayDetalleCombo;
                        // me.encuentraCombo(me.id_receta);

                        // if(arrayDetalleProductoCombo[0].Id_TipoProducto == 4)
                        //         {
                        //console.log();


                        // }
                        this.arrayDetalleProductoSimple.forEach(item => {
                            this.arrayDetalleCombo.forEach(item2 => {
                                if (item.id_producto == item2.id_producto) {
                                    item2.stock = parseFloat(item2.stock) - parseFloat(item
                                        .cantidad)
                                    console.log(item.cantidad);
                                }
                            })
                        })


                    } else {
                        //me.arrayDetalleRecetaAux=me.arrayDetalleRecetaAux.concat(me.arrayDetalleCombo);
                        //me.arrayDetalleProductoCombo = [];
                        me.encuentraCombo(me.id_combo);
                        me.arrayDetalleProductoCombo = me.arrayDetalleProductoCombo.concat(me.arrayDetalleCombo);

                    }
                    // me.arrayDetalleCombo.forEach(item => {
                    // if(item.id_tipo_producto == 3){
                    if (me.arrayDetalleCombo.find(seg => (seg.stock - ((seg.cantidad)) < 0 && seg
                            .id_tipo_producto != 5))) {

                        //me.arrayDetalleProductoCombo=[];
                        //console.log('hola');
                    } else {
                        // me.arrayDetalleCombo.forEach(item =>
                        // {
                        //     me.arrayProducto.forEach(item2 =>
                        //     {
                        //         console.log(item2.Id_Producto);
                        //         if(item.id_producto == item2.Id_Producto)
                        //         {
                        //             item.cantidad = parseFloat(item.cantidad) - parseFloat(item2.stock)
                        //         }
                        //     })
                        // })
                    }
                    //     }
                    // });

                } catch (error) {
                    if (error.response.data) {
                        this.errores = error.response.data.errors;
                    }
                }
                // me.validarFecha();
            },
            async agregarCombo2(id, cant) {
                let me = this;
                try {
                    var url = '/combo2?id=' + id;
                    const res = await axios.get(url)

                    me.id_combo = (res.data[0].id).toString();
                    var url = '/combo/detalleCombo2?id=' + me.id_combo;
                    const res2 = await axios.get(url)
                    me.arrayDetalleCombo = res2.data;

                    me.arrayDetalleCombo.forEach(item => {
                        // if(item.id_tipo_producto == 2){
                        //     item.cantidad =parseInt(item.cantidad)*cant
                        //     item.cantidadAux =cant
                        //     item.estadoN =0
                        // }
                        if (item.id_tipo_producto == 3) {
                            item.cantidad = parseInt(item.cantidad) * cant
                            item.estadoN = 0
                        }

                    });

                    me.arrayDetalleCombo.forEach(item => {

                        item.cont = item.id_combo
                        item.cont++;

                    });

                    if (me.arrayDetalleProductoCombo.length == 0) {
                        me.arrayDetalleProductoCombo = me.arrayDetalleCombo;
                        //console.log('SDKFSAJF')

                        //Combo
                        this.arrayDetalle.forEach(item => {
                            // if(item.id_tipo_producto == 2){
                            //     this.arrayDetalleCombo.forEach(item2 =>
                            //     {
                            //         if(item.id_articulo == item2.id_producto)
                            //         {
                            //             item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                            //             //console.log(item2.stock);
                            //         }
                            //     })
                            // }
                            if (item.id_tipo_producto == 3) {
                                this.arrayDetalleCombo.forEach(item2 => {
                                    if (item.id_articulo == item2.id_producto) {
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        //console.log(item2.stock);
                                    }
                                })
                            }
                        })

                    } else {
                        //me.arrayDetalleRecetaAux=me.arrayDetalleRecetaAux.concat(me.arrayDetalleCombo);
                        //me.arrayDetalleProductoCombo = [];
                        me.encuentraCombo(me.id_combo);
                        me.arrayDetalleProductoCombo = me.arrayDetalleProductoCombo.concat(me.arrayDetalleCombo);

                        //Combo
                        this.arrayDetalle.forEach(item => {
                            // if(item.id_tipo_producto == 2){
                            //     this.arrayDetalleCombo.forEach(item2 =>
                            //     {
                            //         if(item.id_articulo == item2.id_producto)
                            //         {
                            //             item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                            //             //console.log(item2.stock);
                            //         }
                            //     })
                            // }
                            if (item.id_tipo_producto == 3) {
                                this.arrayDetalleCombo.forEach(item2 => {
                                    if (item.id_articulo == item2.id_producto) {
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item
                                            .cantidad)
                                        // console.log(item2.stock);
                                    }
                                })
                            }
                        })
                    }
                    // me.arrayDetalleCombo.forEach(item => {
                    // if(item.id_tipo_producto == 3){
                    if (me.arrayDetalleCombo.find(seg => (seg.stock - ((seg.cantidad)) < 0 && seg
                            .id_tipo_producto != 5 && seg.id_tipo_producto != 2))) {
                        // Swal.fire({
                        //         icon: 'error',
                        //         title: 'Error...',
                        //         text: 'No hay stock para el combo!'
                        //     })
                        //     //me.arrayDetalle=[];
                        //     me.arrayDetalleProductoCombo=[];
                        //console.log('hola');
                        // setTimeout(() => {
                        //     me.encuentraCombo(me.id_combo);
                        //     me.encuentraDelete(data['Id_Producto'])
                        // }, "1000")
                    } else {
                        // me.arrayDetalleCombo.forEach(item =>
                        // {
                        //     me.arrayProducto.forEach(item2 =>
                        //     {
                        //         console.log(item2.Id_Producto);
                        //         if(item.id_producto == item2.Id_Producto)
                        //         {
                        //             item.cantidad = parseFloat(item.cantidad) - parseFloat(item2.stock)
                        //         }
                        //     })
                        // })
                    }
                    //     }
                    // });

                } catch (error) {
                    if (error.response.data) {
                        this.errores = error.response.data.errors;
                    }
                }
                // me.validarFecha();
            },
            validacionError(nombreError, tiempo) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: tiempo,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: '<span style="color: red; font-size: 15px">ERROR!!!</div><span style="color: black; font-size: 15px">...' +
                        nombreError + '</span>'
                })
            },
            guardarVenta() {
                this.verificarCaja();
                this.guardando_venta_mesero = true;
                if (this.arrayDetalle.length <= 0) {
                    this.guardando_venta_mesero = false;
                    this.validacionError('No Existe Productos agregados!', 2000);
                } else {
                    /*if(this.datos.total < 0)
                    {
                        this.validacionError('El total no puedes ser Negativo!',3000);
                    }else{*/
                    if (this.arrayDetalle.find(seg => (parseFloat(seg.cantidad) <= 0 || seg.cantidad == ''))) {
                        this.guardando_venta_mesero = false;
                        this.validacionError('Cantidad  puede ser 0 ni Negativo', 2000);
                    } else {
                        if (this.arrayDetalle.find(seg => (seg.costo_venta <= 0))) {
                            this.guardando_venta_mesero = false;
                            this.validacionError('Precio no puede ser menor a 0', 3000);
                        } else {
                            if (this.arrayDetalle.find(seg => (seg.stock - seg.cantidad < 0 && seg.id_tipo_producto !=
                                    5 && seg.id_tipo_producto != 2))) {
                                this.guardando_venta_mesero = false;
                                this.validacionError('No hay stock para el producto!', 3000);
                            } else {
                                if (this.arrayDetalle.find(seg => (seg.id_tipo_producto == 5))) {
                                    if (this.arrayDetalleProductoCombo.find(seg => (seg.stock - seg.cantidad < 0 && seg
                                            .id_tipo_producto != 2))) {
                                        this.guardando_venta_mesero = false;
                                        this.validacionError('No hay stock en detalle Combo!', 3000);
                                    } else {
                                        if (this.datos.descuento < 0) {
                                            this.validacionError('El descuento no puedes ser Negativo!', 3000);
                                        } else {
                                            let me = this;
                                            //if(me.is_busy==0){
                                            var resultado = 0.0;
                                            for (var i = 0; i < this.arrayDetalle.length; i++) {
                                                resultado = resultado + (this.arrayDetalle[i].precio * this
                                                    .arrayDetalle[i].cantidad);
                                            }
                                            axios.post('/venta/guardar_tienda1', {
                                                    'id_servicio': me.datos.id,
                                                    'fecha': me.datos.fecha,
                                                    'fecha_final': me.datosPago.fecha_final,
                                                    'id_mesa': me.datos.id_mesa,
                                                    'observacion': me.datos.observacion,
                                                    'sub_total': resultado,
                                                    'descuento': me.datos.descuento,
                                                    'usuario': me.datos.usuario,
                                                    'total': me.datos.total,
                                                    'estado': me.datos.estado,
                                                    'id_cliente': me.datos.id_cliente,
                                                    'cliente': me.datos.cliente,
                                                    'usuario': me.datos.usuario,
                                                    'id_tienda': me.id_tienda,
                                                    'id_tipo_pago': me.datos.id_tipo_pago,
                                                    'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0]
                                                        .id : me.datos.id_forma_pago,
                                                    'id_costo_pago': me.datos.id_descuento,
                                                    'detalle': me.arrayDetalle,
                                                    'monto_total': me.datos.total,
                                                    'descripcion_pago': me.datosPago.descripcion,
                                                    'saldo': me.datosPago.saldo,
                                                    'tipo_venta': me.datos.tipo_venta,

                                                    // 'stock_producto_paquete': me.arrayProductoPaquete,
                                                    'arrayDetalleCombo': me.arrayDetalleCombo,
                                                    'arrayDetalleProductoElaborado': me
                                                        .arrayDetalleProductoElaborado,
                                                    'arrayDetalleProductoCompuesto': me
                                                        .arrayDetalleProductoCompuesto,
                                                    'arrayDetalleProductoSimple': me.arrayDetalleProductoSimple
                                                }).then(function (response) {
                                                    me.guardando_venta_mesero = false;
                                                    Swal.fire({
                                                        position: 'top-end',
                                                        icon: 'success',
                                                        title: 'Venta registrado exitosamente',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });
                                                    //me.cargarPdf2();
                                                    me.listado = 1,
                                                        me.arrayDetalle = [];
                                                    me.arrayProducto = [];
                                                    me.arrayDetalleCombo = [],
                                                        me.arrayDetalleProductoCompuesto = [],
                                                        me.arrayDetalleProductoSimple = [],
                                                        me.arrayDetalleProductoCombo = [],
                                                        me.arrayProductoSimple = [],
                                                        me.arrayDetalleSimple = [],
                                                        me.arrayDetalleSimpleAux = [],
                                                        me.arrayDetalleElaboradoAux = [],
                                                        me.arrayDetalleElaborado = [],
                                                        me.arrayDetalleProductoElaborado = [],
                                                        // me.arraySalon = [],
                                                        //me.arrayMesa = [],
                                                        me.arrayDetalleProductoElaborado = [],
                                                        me.volverVentaListado();
                                                    me.limpiarDatosVenta();
                                                    me.listado = 0;
                                                    //me.contador();
                                                    me.preVenta();
                                                    //me.galMesa(me.id_salon2,me.mesa2);

                                                    //console.log(me.id_salon2);
                                                })
                                                .catch(function (error) {
                                                    me.guardando_venta_mesero = false;
                                                    console.log(error);
                                                });
                                            //}
                                            me.is_busy = 1;
                                        }

                                    }
                                } else {
                                    if (this.datos.descuento < 0) {
                                        me.guardando_venta_mesero = false;
                                        this.validacionError('El descuento no puedes ser Negativo!', 2000);
                                    } else {
                                        let me = this;
                                        //if(me.is_busy==0){
                                        var resultado = 0.0;
                                        for (var i = 0; i < this.arrayDetalle.length; i++) {
                                            resultado = resultado + (this.arrayDetalle[i].precio * this.arrayDetalle[i]
                                                .cantidad);
                                        }
                                        axios.post('/venta/guardar_tienda1', {
                                                'id_servicio': me.datos.id,
                                                'fecha': me.datos.fecha,
                                                'fecha_final': me.datosPago.fecha_final,
                                                'id_mesa': me.datos.id_mesa,
                                                'observacion': me.datos.observacion,
                                                'sub_total': resultado,
                                                'descuento': me.datos.descuento,
                                                'usuario': me.datos.usuario,
                                                'total': me.datos.total,
                                                'estado': me.datos.estado,
                                                'id_cliente': me.datos.id_cliente,
                                                'cliente': me.datos.cliente,
                                                'usuario': me.datos.usuario,
                                                'id_tienda': me.id_tienda,
                                                'id_tipo_pago': me.datos.id_tipo_pago,
                                                'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0]
                                                    .id : me.datos.id_forma_pago,
                                                'id_costo_pago': me.datos.id_descuento,
                                                'detalle': me.arrayDetalle,
                                                'monto_total': me.datos.total,
                                                'descripcion_pago': me.datosPago.descripcion,
                                                'saldo': me.datosPago.saldo,
                                                'tipo_venta': me.datos.tipo_venta,

                                                'arrayDetalleCombo': me.arrayDetalleCombo,
                                                'arrayDetalleProductoElaborado': me.arrayDetalleProductoElaborado,
                                                'arrayDetalleProductoCompuesto': me.arrayDetalleProductoCompuesto,
                                                'arrayDetalleProductoSimple': me.arrayDetalleProductoSimple
                                            }).then(function (response) {
                                                me.guardando_venta_mesero = false;
                                                Swal.fire({
                                                    position: 'top-end',
                                                    icon: 'success',
                                                    title: 'Venta registrado exitosamente',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                                me.listado = 1,
                                                    me.arrayDetalle = [];
                                                me.arrayProducto = [];
                                                me.arrayDetalleCombo = [],
                                                    me.arrayDetalleProductoCompuesto = [],
                                                    me.arrayDetalleProductoSimple = [],
                                                    me.arrayDetalleProductoCombo = [],
                                                    me.arrayProductoSimple = [],
                                                    me.arrayDetalleSimple = [],
                                                    me.arrayDetalleSimpleAux = [],
                                                    me.arrayDetalleElaboradoAux = [],
                                                    me.arrayDetalleElaborado = [],
                                                    me.arrayDetalleProductoElaborado = [],
                                                    me.arrayDetalleProductoElaborado = [],
                                                    me.volverVentaListado();
                                                me.limpiarDatosVenta();
                                                me.listado = 0;
                                                //me.contador();
                                                me.preVenta();
                                                //me.galMesa(me.id_salon2,me.mesa2);

                                            })
                                            .catch(function (error) {
                                                me.guardando_venta_mesero = false;
                                                console.log(error);
                                            });
                                        //}
                                        me.is_busy = 1;
                                    }
                                }

                            }
                        }
                    }
                    //}
                }
                this.calcularMontoPorcentajeVenta();
                this.cerrarModalDetalleVenta();

            },
            guardarVentaDirecta() {
                this.guardando_venta_mesero_directa = true;
                if (this.arrayDetalle.length <= 0) {
                    this.guardando_venta_mesero_directa = false;
                    this.validacionError('No Existe Productos agregados!', 3000);
                } else {
                    if (this.datos.total < 0) {
                        this.guardando_venta_mesero_directa = false;
                        this.validacionError('El total no puedes ser Negativo!', 3000);
                    } else {
                        if (this.arrayDetalle.find(seg => (seg.stock - seg.cantidad < 0 && seg.id_tipo_producto != 2 &&
                                seg.id_tipo_producto != 5))) {
                            this.guardando_venta_mesero_directa = false;
                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'No hay stock para el producto!'
                            })
                        } else {
                            if (this.arrayDetalle.find(seg => (seg.id_tipo_producto == 5))) {
                                if (this.arrayDetalleProductoCombo.find(seg => (seg.stock - seg.cantidad < 0 && seg
                                        .id_tipo_producto != 5))) {
                                    this.guardando_venta_mesero_directa = false;
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error...',
                                        text: 'No hay stock en detalle Combo!'
                                    })
                                } else {
                                    if (this.datos.descuento < 0) {
                                        this.guardando_venta_mesero_directa = false;
                                        this.validacionError('El descuento no puedes ser Negativo!', 3000);
                                    } else {
                                        let me = this;
                                        //if (me.is_busy == 0) {
                                        axios.post('/venta/guardar_tienda1/directa', {
                                                'id_servicio': me.datos.id,
                                                'fecha': me.datos.fecha,
                                                'fecha_final': me.datosPago.fecha_final,
                                                'id_mesa': me.datos.id_mesa,
                                                'observacion': me.datos.observacion,
                                                'sub_total': me.datos.sub_total,
                                                'descuento': me.datos.descuento,
                                                'usuario': me.datos.usuario,
                                                'total': me.datos.total,
                                                'efectivo': me.datos.efectivo,
                                                'cambio': me.datos.cambio,
                                                'total_efectivo': me.datos.total_efectivo,
                                                'total_deposito': me.datos.total_deposito,
                                                'estado': me.datos.estado,
                                                'id_cliente': me.datos.id_cliente,
                                                'id_tienda': me.id_tienda,
                                                'cliente': me.datos.cliente,
                                                'usuario': me.datos.usuario,
                                                'id_tipo_pago': me.datos.id_tipo_pago,
                                                'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0]
                                                    .id : me.datos.id_forma_pago,
                                                'id_costo_pago': me.datos.id_descuento,
                                                'detalle': me.arrayDetalle,
                                                'monto_total': me.datos.total,
                                                'descripcion_pago': me.datosPago.descripcion,
                                                'saldo': me.datosPago.saldo,
                                                'tipo_venta': me.datos.tipo_venta,

                                                // 'stock_producto_paquete': me.arrayProductoPaquete,
                                                'arrayDetalleCombo': me.arrayDetalleCombo,
                                                'arrayDetalleProductoElaborado': me
                                                    .arrayDetalleProductoElaborado,
                                                'arrayDetalleProductoCompuesto': me
                                                    .arrayDetalleProductoCompuesto,
                                                'arrayDetalleProductoSimple': me.arrayDetalleProductoSimple
                                            }).then(function (response) {
                                                me.guardando_venta_mesero_directa = false;
                                                me.tipo_venta = "";
                                                Swal.fire({
                                                    position: 'top-end',
                                                    icon: 'success',
                                                    title: 'Venta registrado exitosamente',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                                //me.cargarPdf2();
                                                me.listado = 1,
                                                    me.arrayDetalle = [];
                                                me.arrayProducto = [];
                                                me.arrayDetalleCombo = [],
                                                    me.arrayDetalleProductoCompuesto = [],
                                                    me.arrayDetalleProductoSimple = [],
                                                    me.arrayDetalleProductoCombo = [],
                                                    me.arrayProductoSimple = [],
                                                    me.arrayDetalleSimple = [],
                                                    me.arrayDetalleSimpleAux = [],
                                                    me.arrayDetalleElaboradoAux = [],
                                                    me.arrayDetalleElaborado = [],
                                                    me.arrayDetalleProductoElaborado = [],
                                                    // me.arraySalon = [],
                                                    //me.arrayMesa = [],
                                                    me.arrayDetalleProductoElaborado = [],
                                                    me.volverVentaListado();
                                                    me.limpiarDatosVenta();
                                                    me.listado = 0;
                                                    me.preVenta();
                                                    //me.listarArticulo('', 'nombre_comercial');
                                                    //console.log(me.id_salon2);
                                            })
                                            .catch(function (error) {
                                                me.guardando_venta_mesero_directa = false;
                                                console.log(error);
                                            });
                                        //}
                                        me.cargarPdfTicketVentaDirecta();
                                        me.is_busy = 1;
                                    }
                                }
                            } else {
                                if (this.datos.descuento < 0) {
                                    this.validacionError('El descuento no puedes ser Negativo!', 3000);
                                } else {
                                    let me = this;
                                    //if (me.is_busy == 0) {
                                    axios.post('/venta/guardar_tienda1/directa', {
                                            'id_servicio': me.datos.id,
                                            'fecha': me.datos.fecha,
                                            'fecha_final': me.datosPago.fecha_final,
                                            'id_mesa': me.datos.id_mesa,
                                            'observacion': me.datos.observacion,
                                            'sub_total': me.datos.sub_total,
                                            'descuento': me.datos.descuento,
                                            'usuario': me.datos.usuario,
                                            'total': me.datos.total,
                                            'efectivo': me.datos.efectivo,
                                            'cambio': me.datos.cambio,
                                            'total_efectivo': me.datos.total_efectivo,
                                            'total_deposito': me.datos.total_deposito,
                                            'estado': me.datos.estado,
                                            'id_cliente': me.datos.id_cliente,
                                            'cliente': me.datos.cliente,
                                            'usuario': me.datos.usuario,
                                            'id_tienda': me.id_tienda,
                                            'id_tipo_pago': me.datos.id_tipo_pago,
                                            'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0]
                                                .id : me.datos.id_forma_pago,
                                            'id_costo_pago': me.datos.id_descuento,
                                            'detalle': me.arrayDetalle,
                                            'monto_total': me.datos.total,
                                            'descripcion_pago': me.datosPago.descripcion,
                                            'saldo': me.datosPago.saldo,
                                            'tipo_venta': me.datos.tipo_venta,

                                            // 'stock_producto_paquete': me.arrayProductoPaquete,
                                            'arrayDetalleCombo': me.arrayDetalleCombo,
                                            'arrayDetalleProductoElaborado': me.arrayDetalleProductoElaborado,
                                            'arrayDetalleProductoCompuesto': me.arrayDetalleProductoCompuesto,
                                            'arrayDetalleProductoSimple': me.arrayDetalleProductoSimple
                                        }).then(function (response) {
                                            me.guardando_venta_mesero_directa = false;
                                            me.tipo_venta = "";
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Venta registrado exitosamente',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                            //me.cargarPdf2();
                                                me.listado = 1,
                                                me.arrayDetalle = [];
                                                me.arrayProducto = [];
                                                me.arrayDetalleCombo = [],
                                                me.arrayDetalleProductoCompuesto = [],
                                                me.arrayDetalleProductoSimple = [],
                                                me.arrayDetalleProductoCombo = [],
                                                me.arrayProductoSimple = [],
                                                me.arrayDetalleSimple = [],
                                                me.arrayDetalleSimpleAux = [],
                                                me.arrayDetalleElaboradoAux = [],
                                                me.arrayDetalleElaborado = [],
                                                me.arrayDetalleProductoElaborado = [],
                                                // me.arraySalon = [],
                                                //me.arrayMesa = [],
                                                me.arrayDetalleProductoElaborado = [],
                                                //me.cargarPdfTicketVentaDirecta();
                                                me.volverVentaListado();
                                                me.limpiarDatosVenta();
                                                me.listado = 0;
                                                me.preVenta();
                                                //me.listarArticulo('', 'nombre_comercial');
                                                //console.log(me.id_salon2);
                                        })
                                        .catch(function (error) {
                                            me.guardando_venta_mesero_directa = false;
                                            console.log(error);
                                        });
                                    //}
                                    me.is_busy = 1;
                                }
                            }

                        }
                    }
                }
                this.calcularMontoPorcentajeVenta();
                this.cerrarModalDetalleVentaDirecta();
            },
            ModificarMesa(id) {
                let me = this;
                me.is_busy = 0;
                me.accionVenta = 1;
                me.arrayDetalle = [];
                //me.datos.id=id;
                //me.actEstado();
                // var url='/venta/cabecera?Id_Mesa='+id;
                // axios.get(url).then(function(response){
                //     me.datos.descripcion = response.data.usuario;
                // })
                // .catch(function(error){
                //     console.log(error);
                // });
                // if(me.datos.usuario == me.datos.descripcion ){

                me.listado = 5;
                var url = '/venta/cabecera/modificar?id_mesa=' + id;
                axios.get(url).then(function (response) {
                        me.datos.cliente = response.data.cliente;
                        me.datos.monto = response.data.monto;
                        me.datos.nro = response.data.nro;
                        me.datos.id = response.data.Id_Venta;
                        me.datos.mesa = response.data.Mesa;
                        me.datos.id_mesa = response.data.NMesa;
                        me.datos.descripcion = response.data.usuario;
                        me.datos.descuento = response.data.descuento;

                        //console.log(+me.datos.id);
                        var url = '/venta_act?id_venta=' + me.datos.id;
                        axios.put(url).then(function (response) {
                                //me.arrayDetalle = response.data;
                            })
                            .catch(function (error) {
                                console.log(error)
                            });

                        var PreVenta = [];
                        var url = '/venta/detalle?id_venta=' + me.datos.id;
                        axios.get(url).then(function (response) {
                                PreVenta = response.data;
                                me.id_venta = PreVenta[0].id_venta;

                                for (var i = 0; i < PreVenta.length; i++) {
                                    me.arrayDetalle.push({
                                        id_producto: PreVenta[i].id_producto,
                                        id_detalle: PreVenta[i].id_detalle_venta,
                                        id_tipo_producto: PreVenta[i].id_tipo_producto,
                                        id_producto_compuesto: PreVenta[i].id_producto_compuesto,
                                        cantidad_presentacion: PreVenta[i].cantidad_presentacion,
                                        cantidad: PreVenta[i].cantidad,
                                        articulo: PreVenta[i].producto,
                                        costo_venta: PreVenta[i].precio,
                                        costo_unitario: PreVenta[i].precio,
                                        sub_total: PreVenta[i].precio * PreVenta[i].cantidad,
                                        preciov: PreVenta[i].preciov,
                                        Estado: PreVenta[i].estado,
                                        id_venta: PreVenta[i].id_venta,
                                        total_cantidad: (parseInt(PreVenta[i].cantidad) * parseInt(
                                            PreVenta[i].cantidad_presentacion)),
                                        stock: parseInt(PreVenta[i].stock) + parseInt(PreVenta[i]
                                            .cantidad),
                                    });
                                }

                            })
                            .catch(function (error) {
                                console.log(error);
                            });



                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            modificarPreVenta() {
                let me = this;
                me.verificarCaja();
                me.modificar_venta = true;
                if (this.datos.total < 0) {
                    me.modificar_venta = false;
                    this.validacionError('El total no puedes ser Negativo!', 2000);
                } else {
                    if (this.arrayDetalle.find(seg => (parseFloat(seg.cantidad) <= 0 || seg.cantidad == ''))) {
                        me.modificar_venta = false;
                        this.validacionError('Cantidad  puede ser 0 ni Negativo', 2000);
                    } else {
                        if (this.arrayDetalle.find(seg => (seg.costo_venta <= 0))) {
                            me.modificar_venta = false;
                            this.validacionError('Precio no puede ser menor a 0', 2000);
                        } else {
                            if (this.arrayDetalle.find(seg => (seg.stock - seg.cantidad < 0 && seg.id_tipo_producto !=
                                    2 && seg.id_tipo_producto != 5))) {
                                me.modificar_venta = false;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error...',
                                    text: 'No hay stock para el producto!'
                                })
                            } else {
                                if (this.arrayDetalle.find(seg => (seg.id_tipo_producto == 5))) {
                                    if (this.arrayDetalleProductoCombo.find(seg => (seg.stock - seg.cantidad < 0 && seg
                                            .id_tipo_producto != 5 && seg.id_tipo_producto != 2))) {
                                        me.modificar_venta = false;
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error...',
                                            text: 'No hay stock en detalle Combo!'
                                        })
                                    } else {
                                        if (this.datos.descuento < 0) {
                                            me.modificar_venta = false;
                                            this.validacionError('El descuento no puedes ser Negativo!', 3000);
                                        } else {
                                            //if (me.is_busy == 0) {
                                            axios.put('/venta/modificar', {
                                                    'Id_Venta': me.datos.id,
                                                    'observacion': me.datos.observacion,
                                                    'total': me.datos.total,
                                                    'sub_total': me.datos.sub_total,
                                                    'descuento': me.datos.descuento,
                                                    'detalle': me.arrayDetalle,
                                                    'arrayDetalleCombo': me.arrayDetalleCombo,
                                                    'arrayDetalleProductoCompuesto': me
                                                        .arrayDetalleProductoCompuesto,
                                                    'arrayDetalleProductoSimple': me.arrayDetalleProductoSimple,
                                                    'arrayDetalleProductoElaborado': me
                                                        .arrayDetalleProductoElaborado,

                                                }).then(function (response) {
                                                    me.modificar_venta = false;
                                                    me.arrayDetalle = [];
                                                    // me.arrayDet = [];
                                                    me.arrayCategoria = [];
                                                    me.arrayProducto = [];
                                                    me.arrayDetalleCombo = [],
                                                        me.arrayDetalleProductoCompuesto = [],
                                                        me.arrayDetalleProductoSimple = [],
                                                        me.arrayDetalleProductoCombo = [],
                                                        me.arrayProductoSimple = [],
                                                        me.arrayDetalleSimple = [],
                                                        me.arrayDetalleSimpleAux = [],
                                                        me.arrayDetalleElaboradoAux = [],
                                                        me.arrayDetalleElaborado = [],
                                                        me.arrayDetalleProductoElaborado = [],
                                                        // me.arrayDetalleProducto=[];
                                                        // me.arrayDetalleProductoCompuesto=[];
                                                        // me.arrayDetalleProductoSimple=[]
                                                        me.buscar = '';
                                                    me.listado = 0;
                                                    me.sub_listado = 0;
                                                    // me.contadorModificar();
                                                    me.preVenta();
                                                    me.datos.cliente = '';
                                                    me.datos.observacion = '';
                                                    //me.id_categoria = 0;
                                                    me.calcularMontoPorcentajeVenta();
                                                    Swal.fire({
                                                        position: 'top-end',
                                                        icon: 'success',
                                                        title: 'Preventa modificada...',
                                                        showConfirmButton: false,
                                                        timer: 500
                                                    });
                                                    //me.cargarPdf();
                                                })
                                                .catch(function (error) {
                                                    me.modificar_venta = false;
                                                    console.log(error);
                                                });
                                            //}
                                            me.is_busy = 1;
                                        }
                                    }
                                } else {
                                    if (this.datos.descuento < 0) {
                                        me.modificar_venta = false;
                                        this.validacionError('El descuento no puedes ser Negativo!', 3000);
                                    } else {
                                        //if (me.is_busy == 0) {
                                        axios.put('/venta/modificar', {
                                                'Id_Venta': me.datos.id,
                                                'observacion': me.datos.observacion,
                                                'total': me.datos.total,
                                                'sub_total': me.datos.sub_total,
                                                'descuento': me.datos.descuento,
                                                'detalle': me.arrayDetalle,
                                                'arrayDetalleCombo': me.arrayDetalleCombo,
                                                'arrayDetalleProductoCompuesto': me
                                                    .arrayDetalleProductoCompuesto,
                                                'arrayDetalleProductoSimple': me.arrayDetalleProductoSimple,
                                                'arrayDetalleProductoElaborado': me
                                                    .arrayDetalleProductoElaborado,

                                            }).then(function (response) {
                                                me.modificar_venta = false;
                                                me.arrayDetalle = [];
                                                // me.arrayDet = [];
                                                me.arrayCategoria = [];
                                                me.arrayProducto = [];
                                                me.arrayDetalleCombo = [],
                                                    me.arrayDetalleProductoCompuesto = [],
                                                    me.arrayDetalleProductoSimple = [],
                                                    me.arrayDetalleProductoCombo = [],
                                                    me.arrayProductoSimple = [],
                                                    me.arrayDetalleSimple = [],
                                                    me.arrayDetalleSimpleAux = [],
                                                    me.arrayDetalleElaboradoAux = [],
                                                    me.arrayDetalleElaborado = [],
                                                    me.arrayDetalleProductoElaborado = [],
                                                    // me.arrayDetalleProducto=[];
                                                    // me.arrayDetalleProductoCompuesto=[];
                                                    // me.arrayDetalleProductoSimple=[]
                                                    me.buscar = '';
                                                me.listado = 0;
                                                me.sub_listado = 0;
                                                // me.contadorModificar();
                                                me.preVenta();
                                                me.datos.cliente = '';
                                                me.datos.observacion = '';
                                                //me.id_categoria = 0;
                                                me.calcularMontoPorcentajeVenta();
                                                Swal.fire({
                                                    position: 'top-end',
                                                    icon: 'success',
                                                    title: 'Preventa modificada...',
                                                    showConfirmButton: false,
                                                    timer: 500
                                                });
                                                //me.cargarPdf();
                                            })
                                            .catch(function (error) {
                                                me.modificar_venta = false;
                                                console.log(error);
                                            });
                                        //}
                                        me.is_busy = 1;
                                    }
                                }
                            }

                        }
                    }

                }
            },
            CobrarMesa() {

                let me = this;
                me.verificarCaja();
                me.cobrando_mesa = true;
                if (me.datos.efectivo < me.datos.total && (me.datos.id_forma_pago != 6 && me.datos.id_forma_pago ==
                        2)) {
                    me.cobrando_mesa = false;
                    this.validacionError('El efectivo es insuficiente...!', 2000);
                    me.is_busy = 0;
                } else {
                    if (me.datos.efectivo < me.datos.total_efectivo && me.datos.id_forma_pago == 6) {
                        me.cobrando_mesa = false;
                        this.validacionError('El efectivo es insuficiente...!', 2000);
                    } else {
                        if (me.datos.total < 0) {
                            me.cobrando_mesa = false;
                            this.validacionError('El total no debe ser negativo!', 2000);
                        } else {
                            /*if (me.datos.total > me.datos.efectivo) {
                                me.cobrando_mesa = false;
                                this.validacionError('El efectivo es insuficiente', 2000);
                            } else {*/
                            //if(me.is_busy==0){
                            axios.put('/venta/modificar/cobrar_mesero', {
                                    'id': me.datos.id,
                                    'id_mesa': me.datos.id_mesa,
                                    'fecha': me.datosPago.fecha,
                                    'fecha_final': me.datosPago.fecha_final,
                                    'estado': me.datos.estado,
                                    'total': me.datos.total,
                                    'efectivo': me.datos.efectivo,
                                    'cambio': me.datos.cambio,
                                    'total_efectivo': me.datos.total_efectivo,
                                    'total_deposito': me.datos.total_deposito,
                                    'sub_total': me.datos.sub_total,
                                    'descuento': me.datos.descuento,
                                    'id_tipo_pago': me.datos.id_tipo_pago,
                                    'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos
                                        .id_forma_pago,
                                    'tipo_venta': me.datos.tipo_venta,
                                    'descripcion_pago': me.datosPago.descripcion,
                                    'saldo': me.datosPago.saldo,
                                    'monto_total': me.datos.total,
                                    'detalle': me.arrayDetalle,
                                    'cliente': me.datos.cliente,
                                }).then(function (response) {
                                    me.cobrando_mesa = false;
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Mesa Liberada...',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    me.arrayDetalle = [];
                                    me.arrayDetalleCombo = [],
                                        me.arrayDetalleProductoCompuesto = [],
                                        me.arrayDetalleProductoSimple = [],
                                        me.arrayDetalleProductoCombo = [],
                                        me.arrayProductoSimple = [],
                                        me.arrayDetalleSimple = [],
                                        me.arrayDetalleSimpleAux = [],
                                        //me.volverVentaListadoModificar();
                                        me.limpiarDatosVentaModificar();
                                    me.cerrarModalCobrarMesa();
                                    me.Actualizar();
                                    //me.cargarPdfTicket2(me.id_venta);
                                })
                                .catch(function (error) {
                                    me.cobrando_mesa = false;
                                    console.log(error);
                                });
                            //}
                            //me.galMesa(me.id_salon2);
                            me.is_busy = 1;
                            //}
                        }
                    }
                }
                // setTimeout(() => {
                // }, 1000)
                me.calcularMontoPorcentajeVenta()
            },
            /*CobrarMesa2(){

                let me = this;
                me.cobrando_mesa=true;
                if(me.datos.cambio < 0){
                    me.cobrando_mesa=false;
                    this.validacionError('El cambio no puedes ser Negativo!',2000);
                    me.is_busy=0;
                } 
                    else{
                        if(me.datos.total<0){
                            me.cobrando_mesa=false;
                            this.validacionError('El total no debe ser negativo!',2000);
                        }
                        else{
                            if(me.datos.total>me.datos.efectivo){
                                me.cobrando_mesa=false;
                                this.validacionError('El efectivo es insuficiente',2000);
                            }
                            else {
                                //if(me.is_busy==0){
                                    axios.put('/venta/modificar/cobrar2',{
                                        'id': me.datos.id,
                                        'id_mesa': me.datos.id_mesa,
                                        'fecha': me.datosPago.fecha,
                                        'fecha_final': me.datosPago.fecha_final,
                                        'estado': me.datos.estado,
                                        'total': me.datos.total,
                                        'efectivo': me.datos.efectivo,
                                        'cambio': me.datos.cambio,
                                        'total_efectivo': me.datos.total_efectivo,
                                        'total_deposito': me.datos.total_deposito,
                                        'sub_total': me.datos.sub_total,
                                        'descuento': me.datos.descuento,
                                        'id_tipo_pago': me.datos.id_tipo_pago,
                                        'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
                                        'tipo_venta': me.datos.tipo_venta,
                                        'descripcion_pago': me.datosPago.descripcion,
                                        'saldo': me.datosPago.saldo,
                                        'monto_total': me.datos.total,
                                        'detalle': me.arrayDetalle,
                                        'cliente':me.datos.cliente,
                                    }).then(function(response){
                                        me.cobrando_mesa=false;
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Mesa Liberada...',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        me.arrayDetalle = [];
                                        me.arrayDetalleCombo = [],
                                        me.arrayDetalleProductoCompuesto = [],
                                        me.arrayDetalleProductoSimple = [],
                                        me.arrayDetalleProductoCombo = [],
                                        me.arrayProductoSimple = [],
                                        me.arrayDetalleSimple = [],
                                        me.arrayDetalleSimpleAux = [],
                                        //me.volverVentaListadoModificar();
                                        me.limpiarDatosVentaModificar();
                                        me.cerrarModalCobrarMesa();
                                        me.Actualizar();
                                        me.cargarPdfTicket2(me.id_venta);
                                    })
                                    .catch(function(error){
                                        me.cobrando_mesa=false;
                                        console.log(error);
                                    });
                                //}
                                //me.galMesa(me.id_salon2);
                                me.is_busy=1;
                            }
                        }
                    }
                // setTimeout(() => {
                    // }, 1000)
                    
            },*/
            volverVentaListadoModificar() {
                let me = this;
                //me.datos.id = 0,
                me.datos.id_categoria = 2,
                    me.datos.id_mesa = 0,
                    me.datos.observacion = '',
                    me.datos.nombreSalon = '',
                    me.datos.fecha = moment().format('YYYY-MM-DD'),
                    me.datos.sub_total = 0,
                    me.datos.descuento = 0,
                    me.datos.total = 0,
                    me.datos.id_tipo_pago = 1,
                    me.datos.id_forma_pago = 2,
                    me.datos.id_cliente = 1,
                    me.datos.cliente = '',
                    me.datos.tipoPago = '',
                    me.datos.formaPago = '',
                    me.datos.costo_pago = '',
                    me.datos.id_descuento = '',
                    me.datos.personal = '',
                    me.datos.estado = '',
                    me.datos.tipo_venta = '0',
                    me.datos.id_orden_servicio = null,
                    me.datos.usuario = '',
                    me.datos.mesa = '',
                    me.datos.total_efectivo = 0,
                    me.datos.total_deposito = 0,
                    me.datos.efectivo = 0,
                    me.datos.cambio = 0,
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
            },
            abrirModalCobrarMesa(venta_id, mesa) {
                let me = this;
                me.is_busy = 0;
                me.arrayDetalle = [];

                var url = '/venta/cabecera/modificar2?id_venta=' + venta_id;
                axios.get(url).then(function (response) {
                        me.datos.cliente = response.data.cliente;
                        //me.datos.id_cliente = response.data.id_cliente;
                        me.datos.nro = response.data.nro;
                        me.datos.id = response.data.Id_Venta;
                        me.datos.mesa = response.data.Mesa;
                        me.datos.id_mesa = response.data.NMesa;
                        me.datos.descripcion = response.data.usuario;
                        me.datos.descuento = response.data.descuento;
                        me.datos.monto = response.data.monto - me.datos.descuento;
                        //me.datos.monto_total_a_pagar = response.data.monto_total_a_pagar;
                        //delay: 1000;
                        //console.log(+me.datos.id);
                        var url = '/venta_act?id_venta=' + me.datos.id;
                        axios.put(url).then(function (response) {
                                //me.arrayDetalle = response.data;
                            })
                            .catch(function (error) {
                                console.log(error)
                            });

                        var PreVenta = [];
                        var url = '/venta/detalle?id_venta=' + me.datos.id;
                        axios.get(url).then(function (response) {
                                PreVenta = response.data;
                                me.id_venta = PreVenta[0].id_venta;

                                for (var i = 0; i < PreVenta.length; i++) {
                                    me.arrayDetalle.push({
                                        id_producto: PreVenta[i].id_producto,
                                        id_detalle: PreVenta[i].id_detalle_venta,
                                        id_tipo_producto: PreVenta[i].id_tipo_producto,
                                        id_producto_compuesto: PreVenta[i].id_producto_compuesto,
                                        cantidad_presentacion: PreVenta[i].cantidad_presentacion,
                                        cantidad: PreVenta[i].cantidad,
                                        articulo: PreVenta[i].producto,
                                        costo_venta: PreVenta[i].precio,
                                        costo_unitario: PreVenta[i].precio,
                                        sub_total: PreVenta[i].precio * PreVenta[i].cantidad,
                                        preciov: PreVenta[i].preciov,
                                        Estado: PreVenta[i].estado,
                                        id_venta: PreVenta[i].id_venta,
                                        //monto_pago_parcial: PreVenta[i].monto_pago_parcial,
                                        //monto_total_a_pagar: PreVenta[i].monto_total_a_pagar,
                                        total_cantidad: (parseInt(PreVenta[i].cantidad) * parseInt(
                                            PreVenta[i].cantidad_presentacion)),
                                        stock: parseInt(PreVenta[i].stock) + parseInt(PreVenta[i]
                                            .cantidad),
                                    });
                                }

                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        //this.listarArticulo('', 'categoria');



                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                me.modalcobrar = 1;

            },

            abrirModalCobrarMesa2(mesa_id, mesa) {
                let me = this;
                me.is_busy = 0;
                me.arrayDetalle = [];

                var url = '/venta/cabecera/modificar?id_mesa=' + mesa_id;
                axios.get(url).then(function (response) {
                        me.datos.cliente = response.data.cliente;
                        //me.datos.id_cliente = response.data.id_cliente;
                        me.datos.nro = response.data.nro;
                        me.datos.id = response.data.Id_Venta;
                        me.datos.mesa = response.data.Mesa;
                        me.datos.id_mesa = response.data.NMesa;
                        me.datos.descripcion = response.data.usuario;
                        me.datos.descuento = response.data.descuento;
                        me.datos.monto = response.data.monto - me.datos.descuento;
                        //me.datos.monto_total_a_pagar = response.data.monto_total_a_pagar;
                        //delay: 1000;
                        //console.log(+me.datos.id);
                        var url = '/venta_act?id_venta=' + me.datos.id;
                        axios.put(url).then(function (response) {
                                //me.arrayDetalle = response.data;
                            })
                            .catch(function (error) {
                                console.log(error)
                            });

                        var PreVenta = [];
                        var url = '/venta/detalle?id_venta=' + me.datos.id;
                        axios.get(url).then(function (response) {
                                PreVenta = response.data;
                                me.id_venta = PreVenta[0].id_venta;

                                for (var i = 0; i < PreVenta.length; i++) {
                                    me.arrayDetalle.push({
                                        id_producto: PreVenta[i].id_producto,
                                        id_detalle: PreVenta[i].id_detalle_venta,
                                        id_tipo_producto: PreVenta[i].id_tipo_producto,
                                        id_producto_compuesto: PreVenta[i].id_producto_compuesto,
                                        cantidad_presentacion: PreVenta[i].cantidad_presentacion,
                                        cantidad: PreVenta[i].cantidad,
                                        articulo: PreVenta[i].producto,
                                        costo_venta: PreVenta[i].precio,
                                        costo_unitario: PreVenta[i].precio,
                                        sub_total: PreVenta[i].precio * PreVenta[i].cantidad,
                                        preciov: PreVenta[i].preciov,
                                        Estado: PreVenta[i].estado,
                                        id_venta: PreVenta[i].id_venta,
                                        //monto_pago_parcial: PreVenta[i].monto_pago_parcial,
                                        //monto_total_a_pagar: PreVenta[i].monto_total_a_pagar,
                                        total_cantidad: (parseInt(PreVenta[i].cantidad) * parseInt(
                                            PreVenta[i].cantidad_presentacion)),
                                        stock: parseInt(PreVenta[i].stock) + parseInt(PreVenta[i]
                                            .cantidad),
                                    });
                                }

                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        //this.listarArticulo('', 'categoria');



                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                me.modalcobrar = 1;

            },
            limpiarDatosVentaModificar() {
                let me = this;
                me.datos = {
                    //id : 0,
                    id_categoria: 2,
                    id_mesa: 0,
                    nombreSalon: '',
                    observacion: '',
                    fecha: moment().format('YYYY-MM-DD'),
                    sub_total: 0,
                    descuento: 0,
                    total: 0,
                    total_efectivo: 0,
                    total_deposito: 0,
                    efectivo: 0,
                    deposito: 0,
                    id_tipo_pago: 1,
                    id_forma_pago: 2,
                    id_cliente: 1,
                    cliente: '',
                    tipoPago: '',
                    formaPago: '',
                    costo_pago: '',
                    id_descuento: '',
                    personal: '',
                    estado: '',
                    tipo_venta: '0',
                    id_orden_servicio: null,
                    usuario: '',
                    mesa: '',

                    //   me.datos.usuario= me.usuario_nombre['usuario'];
                }
                me.usuarioNombre();
                me.arrayOrden = [];
                me.arrayDetalle = [];
                me.arrayDetalleCombo = [],
                    me.arrayDetalleProductoCompuesto = [],
                    me.arrayDetalleProductoSimple = [],
                    me.arrayDetalleProductoCombo = [],
                    me.arrayProductoSimple = [],
                    me.arrayDetalleSimple = [],
                    me.arrayDetalleSimpleAux = [],
                    me.arrayDetalleElaboradoAux = [],
                    me.arrayDetalleElaborado = [],
                    me.arrayDetalleProductoElaborado = [],
                    me.isDisabledOrden = false;
                me.isDisabledCliente = false;
                me.isDisabledProducto = false;
                me.isDisabledPaquete = false;
                me.buscarP = '';
                me.buscar = '';
                me.buscarCliente = '';
                me.isDisabled = false;
            },
            limpiarDatosVenta() {
                let me = this;
                me.datos = {
                    id: 0,
                    id_categoria: 2,
                    id_mesa: 0,
                    nombreSalon: '',
                    observacion: '',
                    fecha: moment().format('YYYY-MM-DD'),
                    sub_total: 0,
                    descuento: 0,
                    total: 0,
                    total_efectivo: 0,
                    total_deposito: 0,
                    efectivo: 0,
                    deposito: 0,
                    id_tipo_pago: 1,
                    id_forma_pago: 2,
                    id_cliente: 1,
                    cliente: '',
                    tipoPago: '',
                    formaPago: '',
                    costo_pago: '',
                    id_descuento: '',
                    personal: '',
                    estado: '',
                    tipo_venta: '0',
                    id_orden_servicio: null,
                    usuario: '',
                    mesa: '',

                    //   me.datos.usuario= me.usuario_nombre['usuario'];
                }
                me.usuarioNombre();
                me.arrayOrden = [];
                me.arrayDetalle = [];
                me.arrayDetalleCombo = [],
                    me.arrayDetalleProductoCompuesto = [],
                    me.arrayDetalleProductoSimple = [],
                    me.arrayDetalleProductoCombo = [],
                    me.arrayProductoSimple = [],
                    me.arrayDetalleSimple = [],
                    me.arrayDetalleSimpleAux = [],
                    me.arrayDetalleElaboradoAux = [],
                    me.arrayDetalleElaborado = [],
                    me.arrayDetalleProductoElaborado = [],
                    me.isDisabledOrden = false;
                me.isDisabledCliente = false;
                me.isDisabledProducto = false;
                me.isDisabledPaquete = false;
                me.buscarP = '';
                me.buscar = '';
                me.buscarCliente = '';
                me.isDisabled = false;
            },
            volverVentaListado() {
                let me = this;
                me.datos.id = 0,
                    me.datos.id_categoria = 2,
                    me.datos.id_mesa = 0,
                    me.datos.observacion = '',
                    me.datos.nombreSalon = '',
                    me.datos.fecha = moment().format('YYYY-MM-DD'),
                    me.datos.sub_total = 0,
                    me.datos.descuento = 0,
                    me.datos.total = 0,
                    me.datos.id_tipo_pago = 1,
                    me.datos.id_forma_pago = 2,
                    me.datos.id_cliente = 1,
                    me.datos.cliente = '',
                    me.datos.tipoPago = '',
                    me.datos.formaPago = '',
                    me.datos.costo_pago = '',
                    me.datos.id_descuento = '',
                    me.datos.personal = '',
                    me.datos.estado = '',
                    me.datos.tipo_venta = '0',
                    me.datos.id_orden_servicio = null,
                    me.datos.usuario = '',
                    me.datos.mesa = '',
                    me.datos.total_efectivo = 0,
                    me.datos.total_deposito = 0,
                    me.datos.efectivo = 0,
                    me.datos.cambio = 0,
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
            },
            cargarPdfTicket2(id) {
                axios.get('/venta/pdfPreVenta?id=' + id, {
                        responseType: 'blob'
                    })
                    .then(response => {
                        var blob = new Blob([response.data], {
                            type: 'application/pdf'
                        });
                        var downloadUrl = URL.createObjectURL(blob);
                        window.open(downloadUrl, '_blank');
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            cargarPdfTicketVentaDirecta() {
                axios.get('/venta/pdf2', {
                        responseType: 'blob'
                    })
                    .then(response => {
                        var blob = new Blob([response.data], {
                            type: 'application/pdf'
                        });
                        var downloadUrl = URL.createObjectURL(blob);
                        window.open(downloadUrl, '_blank');
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            // ModificarMesaActualizar(id)
            // {
            //     let me = this;
            //     me.arrayDetalle = [];
            //     me.listado=3;
            //     var url='/venta/cabecera/modificar?id_mesa='+id;
            //     axios.get(url).then(function(response){
            //         me.datos.cliente= response.data.cliente;
            //         me.datos.monto = response.data.monto;
            //         me.datos.nro = response.data.nro;
            //         me.datos.id = response.data.Id_Venta;
            //         me.datos.mesa = response.data.Mesa;
            //         me.datos.id_mesa = response.data.NMesa;
            //         me.datos.descripcion = response.data.usuario;

            //         var PreVenta=[];
            //         var url='/venta/detalle?id_venta='+ me.datos.id;
            //         axios.get(url).then(function(response){
            //             PreVenta = response.data;
            //             for(var i=0;i<PreVenta.length;i++){
            //                 me.arrayDetalle.push({
            //                     id_producto : PreVenta[i].id_producto,
            //                     id_detalle : PreVenta[i].id_detalle_venta,
            //                     id_tipo_producto : PreVenta[i].id_tipo_producto,
            //                     id_producto_compuesto : PreVenta[i].id_producto_compuesto,
            //                     cantidad_presentacion : PreVenta[i].cantidad_presentacion,
            //                     cantidad : PreVenta[i].cantidad,
            //                     articulo : PreVenta[i].producto,
            //                     costo_venta : PreVenta[i].precio,
            //                     costo_unitario : PreVenta[i].precio,
            //                     sub_total : PreVenta[i].precio * PreVenta[i].cantidad,
            //                     preciov : PreVenta[i].preciov,
            //                     Estado : PreVenta[i].estado,
            //                     total_cantidad : (parseInt(PreVenta[i].cantidad)*parseInt(PreVenta[i].cantidad_presentacion)),
            //                     stock : parseInt(PreVenta[i].stock)+parseInt(PreVenta[i].cantidad),
            //                 });
            //             }

            //         })
            //         .catch(function(error){
            //             console.log(error);
            //         });



            //     })
            //     .catch(function(error){
            //         console.log(error);
            //     });
            // },
            ModificarMesaActualizar(id) {
                let me = this;
                me.arrayDetalle = [];
                me.listado = 5;
                var url = '/venta/cabecera/modificar?id_mesa=' + id;
                axios.get(url).then(function (response) {
                        me.datos.cliente = response.data.cliente;
                        me.datos.monto = response.data.monto;
                        me.datos.nro = response.data.nro;
                        me.datos.id = response.data.Id_Venta;
                        me.datos.mesa = response.data.Mesa;
                        me.datos.id_mesa = response.data.NMesa;
                        me.datos.descripcion = response.data.usuario;
                        me.datos.descuento = response.data.descuento;

                        var PreVenta = [];
                        var url = '/venta/detalle?id_venta=' + me.datos.id;
                        axios.get(url).then(function (response) {
                                PreVenta = response.data;
                                for (var i = 0; i < PreVenta.length; i++) {
                                    me.arrayDetalle.push({
                                        id_producto: PreVenta[i].id_producto,
                                        id_detalle: PreVenta[i].id_detalle_venta,
                                        id_tipo_producto: PreVenta[i].id_tipo_producto,
                                        id_producto_compuesto: PreVenta[i].id_producto_compuesto,
                                        cantidad_presentacion: PreVenta[i].cantidad_presentacion,
                                        cantidad: PreVenta[i].cantidad,
                                        articulo: PreVenta[i].producto,
                                        costo_venta: PreVenta[i].precio,
                                        costo_unitario: PreVenta[i].precio,
                                        sub_total: PreVenta[i].precio * PreVenta[i].cantidad,
                                        preciov: PreVenta[i].preciov,
                                        Estado: PreVenta[i].estado,
                                        total_cantidad: (parseInt(PreVenta[i].cantidad) * parseInt(
                                            PreVenta[i].cantidad_presentacion)),
                                        stock: parseInt(PreVenta[i].stock) + parseInt(PreVenta[i]
                                            .cantidad),
                                    });
                                }

                            })
                            .catch(function (error) {
                                console.log(error);
                            });



                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            eliminarDetalleDb(id, id_tipo_producto) {
                let me = this;
                if (me.arrayDetalle.length == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'No se puede eliminar el último Producto!'
                    })
                } else {
                    me.arrayDetalleModificar = [];

                    for (let i = 0; i < me.arrayDetalle.length; i++) {
                        if (me.arrayDetalle[i].Estado != 0) {
                            me.arrayDetalleModificar.push(me.arrayDetalle[i]);
                        }
                    }

                    axios.put('/detalle/eliminar?id_detalle_venta=' + id, {
                            'id_venta': me.datos.id,
                            'id_tipo_producto': id_tipo_producto,
                            'total': me.datos.total,
                            'sub_total': me.datos.sub_total,
                            'descuento': me.datos.descuento,
                        }).then(function (response) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Producto eliminado...',
                                showConfirmButton: false,
                                timer: 500
                            });
                            me.calcularDescuento.toFixed(2);
                            me.ModificarMesaActualizar(me.datos.id_mesa)

                            for (let j = 0; j < me.arrayDetalleModificar.length; j++) {
                                me.arrayDetalle.unshift(me.arrayDetalleModificar[j]);
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    me.ModificarMesa(me.datos.mesa)
                }

            },
            contrasena() {
                let me = this;
                var url = '/contrasena'
                axios.get(url).then(function (response) {
                        me.contrasena_id = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },










            actualizarStockProducto(id, cantidad, paquete) {
                let me = this;
                me.listarArticulo('', 'nombre_comercial');
                if (paquete == 'Venta Paquete') {
                    me.arrayProductoPaquete.forEach(
                        item => {
                            item.id_paquete == id && item.tipo_producto == 'Producto Venta' ? item.cantidad_aux =
                                item.cantidad * cantidad : '';
                            me.cantidad_producto = item.cantidad_aux;
                        });
                }

            },
            /*verificarCaja() {
                let me = this;
                var url = '/arqueo_caja/estado_caja';
                axios.get(url).then(function (response) {
                        me.estadoCaja = response.data.estado;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },*/
            // listarArticulo(buscarP){
            //     let me = this;
            //     me.buscarCliente= '';
            //     me.isVisible = false;
            //     var url='/tienda/listarSinPaginate2/tienda1?buscar=' + buscarP;
            //     axios.get(url).then(function(response){
            //         me.arrayArticulo= response.data;
            //     })
            //     .catch(function(error){
            //         console.log(error);
            //     });
            // },
            listarArticulo(buscarP, criterioP) {
                let me = this;
                me.buscarCliente = '';
                me.isVisible = false;
                var url = '/tienda/listarSinPaginate2/tienda1?buscar=' + buscarP + '&criterio=' + criterioP;
                axios.get(url).then(function (response) {
                        me.arrayArticulo = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            listarArticuloBusquedaRapida() {
                let me = this;
                me.buscarCliente = '';
                me.isVisible = false;
                var url = '/tienda/listarSinPaginate2/tienda1?buscar=' + me.buscarP + '&criterio=' + me.criterioP;
                axios.get(url).then(function (response) {
                        me.arrayArticulo = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            BuscandoProducto() {
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida, 350)
            },
            listarCliente(buscarP) {
                let me = this;
                me.buscarCliente = '';
                me.isVisible = false;
                var url = '/cliente/listarSinPaginate?buscar=' + buscarP;
                axios.get(url).then(function (response) {
                        me.arrayTipoCliente = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            listarClienteBusquedaRapida() {
                let me = this;
                var url = '/cliente/listarSinPaginate?buscar=' + me.buscarP;
                axios.get(url).then(function (response) {
                        me.arrayTipoCliente = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            BuscandoCliente() {
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarClienteBusquedaRapida, 350)
            },
            selectedCliente(cliente) {
                this.datos.cliente = '';
                this.datos.id_cliente = 0;
                this.datos.id_descuento = '';
                this.isVisible = false;
                this.datos.cliente = cliente.nombre;
                this.datos.id_cliente = cliente.id;
                this.datos.id_descuento = cliente.descuento;
                this.datos.descuento = cliente.descuento;
            },
            listarOrden(buscarP) {
                let me = this;
                me.buscarCliente = '',
                    me.isVisible = false;
                var url = '/servicio/listarOrdenSinPaginate_tienda1?buscar=' + buscarP;
                axios.get(url).then(function (response) {
                        me.arrayOrden = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            listarPaquete(buscarP) {
                let me = this;
                me.buscarCliente = '',
                    me.isVisible = false;
                var url = '/paquete/listarOrdenSinPaginate?buscar=' + buscarP;
                axios.get(url).then(function (response) {
                        me.arrayPaquete = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            listarPaqueteBusquedaRapida() {
                let me = this;
                var url = '/paquete/listarOrdenSinPaginate?buscar=' + me.buscarP;
                axios.get(url).then(function (response) {
                        me.arrayPaquete = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            BuscandoPaquete() {
                let me = this;
                clearTimeout(me.setTimeoutBuscador2)
                me.setTimeoutBuscador2 = setTimeout(me.listarPaqueteBusquedaRapida, 350)
            },
            encuentra(id) {
                var sw = 0;
                for (var i = 0; i < this.arrayDetalle.length; i++) {
                    if (this.arrayDetalle[i].id_articulo == id) {
                        sw = true;
                    }
                }
                return sw;
            },
            encuentraPaquete(id) {
                var sw = 0;
                for (var i = 0; i < this.arrayDetalle.length; i++) {
                    if (this.arrayDetalle[i].id_paquete == id) {
                        sw = true;
                    }
                }
                return sw;
            },

            eliminarDetalle(index) {
                let me = this;
                if (me.arrayDetalle.length == 1 && me.accionVenta == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'No se puede eliminar el último Producto!'
                    })
                } else {
                    me.arrayDetalle.splice(index, 1);
                }
                // me.arrayDetalleProductoSimple.splice(index,1);

            },
            eliminarProductoPaquete(id) {
                let array = [];
                array = this.arrayProductoPaquete.filter(item => item.id_paquete != id);
                this.arrayProductoPaquete = array;
            },

            /*eliminarDetalle(index){
                let me = this;
                let id_paquete = 0;
                if(me.arrayDetalle[index].producto_venta=='Venta Paquete'){
                    id_paquete = me.arrayDetalle[index].id_paquete;
                    me.eliminarProductoPaquete(id_paquete);
                }
                me.arrayDetalle.splice(index,1);
            },*/


            seleccionarPaquete(data = []) {
                let me = this;
                if (me.encuentraPaquete(data['id'])) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'Este paquete ya se encuentra agregado!'
                    })
                } else {

                    me.arrayDetalle.push({
                        //id_tienda_articulo : data['id'],
                        id_paquete: data['id'],
                        articulo: data['nombre'],
                        tienda: '',
                        costo_unitario: data['total'],
                        costo_mayorista: '',
                        costo_preferencial: '',
                        costo_compra: '',
                        marca: '',
                        id_categoria: '',
                        categoria: '',
                        stock: 1000,
                        cantidad: 1,
                        producto_venta: 'Venta Paquete'
                        //sub_total : data['sub_total'],
                    });
                    me.datos.estado = 'Entregado';
                    me.datos.tipo_venta = 'Venta Directa'
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

            cargarDetallePaquete(id) {
                let me = this;
                var url = '/paquete/permiso/detalle?id=' + id;
                axios.get(url).then(function (response) {
                        me.arrayDetalleProducto = response.data;
                        me.arrayDetalleProducto.forEach(
                            item => {
                                item.cantidad_aux = item.cantidad * 1;
                            });

                        if (me.arrayProductoPaquete.length == 0) {
                            me.arrayProductoPaquete = me.arrayDetalleProducto;
                        } else {
                            me.arrayProductoPaquete = me.arrayProductoPaquete.concat(me.arrayDetalleProducto);
                        }

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },



            cargarArticuloPaquete() {
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



            seleccionarTiendaArticulo(data = []) {
                let me = this;
                if (me.encuentra(data['id_articulo'])) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'Este producto ya se encuentra agregado!'
                    })
                } else {
                    me.arrayDetalle.push({
                        id_tienda_articulo: data['id'],
                        id_articulo: data['id_articulo'],
                        articulo: data['articulo'],
                        tienda: data['tienda'],
                        costo_unitario: data['costo_unitario'],
                        costo_mayorista: data['costo_mayorista'],
                        costo_preferencial: data['costo_preferencial'],
                        costo_compra: data['costo_compra'],
                        marca: data['marca'],
                        id_categoria: data['id_categoria'],
                        categoria: data['categoria'],
                        stock: data['stock'],
                        cantidad: 1,
                        sub_total: data['sub_total'],
                        producto_venta: 'Venta Producto'
                    });
                    me.datos.estado = 'Entregado';
                    me.datos.tipo_venta = 'Venta Directa'
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
            },

            seleccionarCliente(data = []) {
                this.buscarCliente = '',
                    this.datos.id_cliente = data['id'];
                this.datos.cliente = data['nombre'];
                this.datos.id_descuento = data['descuento'];
            },

            selectCostoPago() {
                let me = this;
                var url = '/articulo/selectPrecio';
                axios.get(url).then(function (response) {
                        me.arrayCostoPago = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            selectCliente() {
                let me = this;
                var url = '/cliente/selectCliente';
                axios.get(url).then(function (response) {
                        me.arrayCliente = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            selectTipoP() {
                let me = this;
                var url = '/tipoPago/selectTipoP';
                axios.get(url).then(function (response) {
                        me.arrayPago = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            selectFormaP() {
                let me = this;
                var url = '/formaPago/selectFormaP';
                axios.get(url).then(function (response) {
                        me.arrayForma = response.data;
                        me.arrayForma2 = response.data;
                        me.arrayForma2 = me.arrayForma2.filter((item) => item.id !== 1);
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            verVenta(data = []) {
                let me = this;
                me.listado = 2;
                me.datos.id = data['id'];
                me.datos.cliente = data['cliente'];
                me.datos.fecha = data['fecha'];
                me.datos.descuento = data['descuento'];
                me.datos.tipoPago = data['tipoP'];
                me.datos.formaPago = data['formaP'];

                var url = '/venta/permiso/detalle/tienda1?id=' + data['id'];
                axios.get(url).then(function (response) {
                        me.arrayDetalle = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            validarCompra() {
                this.errorPago = 0;
                this.errorMostrarMsjPago = [];

                if (!this.datos.nombre) this.errorMostrarMsjPago.push("El nombre del Pago no puede estar vacio ");
                if (this.errorMostrarMsjPago.length) this.errorPago = 1;
                return this.errorPago;
            },
            frmVenta() {
                this.listado = 1;
                this.selectCliente();
                this.selectTipoP();
                this.selectFormaP();
                this.usuarioNombre();
            },
            anular(id) {
                let me = this;
                Swal.fire({

                    title: 'Ingrese credenciales para anular la venta?',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {

                        if ((cant != me.contrasena_id.Contrasena) || cant == '') {
                            Swal.showValidationMessage(
                                `Contraseña Incorrecta :)`
                            );
                            console.log(cant);
                        } else {
                            axios.put('/venta/anular_tienda1_2', {
                                'id_mesa': id,
                                'id_usuario': me.usuario_nombre.id
                            }).then(function (response) {
                                me.listarVenta(1, '', 'nombre');
                            }).catch(function (error) {
                                console.log(error);
                            });
                        }
                        // me.Actualizar();
                    },
                }).then((result) => {
                    //me.Actualizar();

                    if (result.isConfirmed) {
                        me.calcularMontoPorcentajeVenta();
                        me.listarVenta(1, '', 'nombre');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Venta Anulada...',
                            showConfirmButton: false,
                            timer: 500
                        });
                    }
                    //this.Actualizar();
                })
                // me.Actualizar();
            },
            /*anularVenta(id, id_mesa) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Anular esta Venta??',
                    text: "No Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Habilitar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put('/venta/anular_tienda1', {
                            'id': id,
                            'id_mesa': id_mesa
                        }).then(function (response) {
                            me.preVenta();
                            swalWithBootstrapButtons.fire(
                                'Anulado!',
                                'Este venta se ha Anulado.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'Esta venta no ha tenido cambios :)',
                            'error'
                        )
                    }
                })
            },*/

            anularVenta(id, id_mesa) {

                let me = this;
                Swal.fire({

                    title: 'Ingrese credenciales para anular la venta?',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {

                        if ((cant != me.contrasena_id.Contrasena) || cant == '') {
                            Swal.showValidationMessage(
                                `Contraseña Incorrecta :)`
                            );
                            console.log(cant);
                        } else {
                            axios.put('/venta/anular_tienda1', {
                                'id': id,
                                'id_mesa': id_mesa
                            }).then(function (response) {
                                me.listarVenta(1, '', 'nombre');

                            }).catch(function (error) {
                                console.log(error);
                            });
                        }
                        // me.Actualizar();
                    },
                }).then((result) => {
                    //me.Actualizar();

                    if (result.isConfirmed) {
                        me.calcularMontoPorcentajeVenta();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Venta Anulada...',
                            showConfirmButton: false,
                            timer: 500
                        });
                    }
                    //this.Actualizar();
                })
                // me.Actualizar();
            },

            limpiarArticulo() {
                this.arrayArticulo = [];
                this.buscarP = '';
                this.buscar = '';
                this.arrayDetalle.forEach(item => item.saldoStock = 0);
            },
            limpiarCliente() {
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
            seleccionarOrdenServicio(data = []) {
                let me = this;
                me.datos.id = data['id'];
                me.datos.id_cliente = data['id_cliente'];
                me.datos.cliente = data['cliente'];
                me.datos.id_descuento = data['id_descuento'];
                me.datos.tipo_venta = 'Venta Servicio';
                me.datos.estado = 'Entregado';
                me.datos.descuento = data['descuento']

                var url = '/servicio/permiso/detalle?id=' + data['id'];
                axios.get(url).then(function (response) {
                        me.arrayDetalle = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                me.isDisabledCliente = true;
                me.isDisabledProducto = true;
                me.isDisabledPaquete = true;
            },
            seleccionarPaquete2(data = []) {
                let me = this;
                // me.datos.id=data['id'];
                // me.datos.id_cliente=data['id_cliente'];
                // me.datos.cliente=data['cliente'];
                // me.datos.id_descuento=data['id_descuento'];
                // me.datos.tipo_venta='Venta Servicio';
                me.datos.estado = 'Entregado';
                // me.datos.descuento=data['descuento']

                var url = '/paquete/permiso/detalle?id=' + data['id'];
                axios.get(url).then(function (response) {
                        me.arrayDetalle = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                //me.isDisabledCliente=true;
                //me.isDisabledProducto=true;
                me.isDisabledOrden = true;
            },
            usuarioNombre() {
                let me = this;
                var url = '/usuario_nombre'
                axios.get(url).then(function (response) {
                        me.usuario_nombre = response.data;
                        me.datos.usuario = me.usuario_nombre['usuario'];
                        me.datos.id_user = me.usuario_nombre['id'];
                        me.datos.porcentaje = me.usuario_nombre['porcentaje'];
                        //me.datos.id_personal=response.data[0].id_personal;
                        // me.ClienteR(me.usuario_id['id_personal']);
                        // me.contador(me.usuario_id['id_personal']);
                    })
                    .catch(function (error) {
                        console.log(error)

                    });
            },

            numericValidate(event) {
                const keyValidate = new RegExp('^[0-9]*$');
                const keysCaracter = ['Delete', 'Backspace', 'ArrowLeft', 'ArrowRight', 'KeyX', 'KeyC', 'KeyV', 'Home',
                    'End', 'Tab'
                ];
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
            cargarPdf2() {
                axios.get('/venta/pdfVentasGeneral2', {
                        responseType: 'blob'
                    })
                    .then(response => {
                        var blob = new Blob([response.data], {
                            type: 'application/pdf'
                        });
                        var downloadUrl = URL.createObjectURL(blob);
                        window.open(downloadUrl, '_blank');
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            volverMenu() {
                this.listado = 0;
                this.tipo_venta = "";
                this.preVenta();
            },
            volverSalon() {
                if (this.tipo_venta == "directa") {
                    this.listado = 0;
                    this.tipo_venta = "";
                } else {
                    this.listado = 1;
                }
            },
            volverCategoria() {
                this.listado = 3;
                this.categoria = '';
                this.id_categoria = 0;
            },
            volverCategoria2() {
                this.listado = 6;
                this.categoria = '';
                this.id_categoria = 0;
            },
            volverMesa() {
                this.listado = 2;
                this.arrayCategoria = [];
                this.arrayProducto = [];
                this.buscar = '';
                // this.datos.id_categoria = 2;
                //this.datos.id_mesa = 0;
            },

        },
        mounted() {
            this.verificarCaja();
            this.preVenta();
            this.listarSalon();
            this.contrasena();
            this.selectCliente();
            this.selectTipoP();
            this.selectFormaP();
            setTimeout(() => {
                //this.listarInventario(1, this.buscar, this.criterio);
                this.calcularMontoPorcentajeVenta();
            }, 1000);
            this.salirCajaCerrada();



        }
    }

</script>
<style scoped lang="scss">
    .dropdown-wrapper {
        position: relative;
        //margin: 0 auto;

        .selected-item {
            height: 25px;
            //border: 2px solid lightgray;
            border-radius: 5px;
            padding: 5px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            //font-size: 16px;
            //font-weight: 500;

            .drop-down-icon {
                transform: rotate(0deg);
                transition: all 0.5s ease;

                &.dropdown {
                    transform: rotate(180deg);
                }
            }
        }

        .dropdown-popover {
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


            &.visible {
                max-height: 450px;
                visibility: visible;
            }

            input {
                width: 100%;
                height: 30px;
                border: 2px solid lightgray;
                font-size: 18px;
                padding-left: 8px;
            }

            .options {
                width: 100%;
                padding-top: 12px;

                ul {
                    list-style: none;
                    text-align: left;
                    padding-left: 2px;
                    max-height: 200px;
                    overflow-y: scroll;
                    overflow-x: hidden;
                }

                li {
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



    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }

    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #d1cdcd7a !important;
    }

    .div-error {
        display: flex;
        justify-content: center;
    }

    .text-error {
        color: red !important;
        font-weight: bold;
    }

    .footer {
        position: relative !important;
        width: auto !important;
    }

    .tamaño {
        width: 100px !important;
    }

    .bg-disabled {
        background-color: #D8DBE1;
    }

    .bg-azul {
        background-color: #3399FF;
    }

    .bg-galeria {
        background-color: #0c131c !important;
        /* color: white !important; */
    }

    .bg-volver {
        background-color: #D00823 !important;
        /* color: white !important; */
    }

    .bg-guardar {
        background-color: #1b3f62 !important;
        /* color: white !important; */
    }

    .bg-actualizar {
        background-color: #3b5b80 !important;
        /* color: white !important; */
    }

    .bg-mesa {
        background-color: #1b3f62 !important;
        /* color: white !important; */
    }

    .bg-negro {
        background-color: #000000 !important;
        /* color: white !important; */
    }

    .bg-ver {
        background-color: #245b6a !important;
        /* color: white !important; */
    }

    .bg-imprimir {
        background-color: #407787 !important;
        /* color: white !important; */
    }

    .bg-anular {
        background-color: #9bcad4 !important;
        /* color: white !important; */
    }

</style>
