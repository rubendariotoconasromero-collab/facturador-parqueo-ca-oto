<template>
    <main class="main">
        <!-- <div class="container"> -->
        <div class="row">
            <div class="col">
                &nbsp;
                <div class="card">
                    <template v-if="listado==0">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">HISTORIAL DE VENTA</h5>
                                <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                            </div>
                        </div>

                        <!-- Inicio -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true" style='font-size: 0.8rem'>Ventas</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <div class="form-group row" id="home">

                                    <div class="col-md-8">
                                        &nbsp;&nbsp;<div class="input-group"
                                            style='width:96%;margin-left: 3.3%;font-size: 0.8rem'>
                                            <div>
                                                <input type="date" class="form-control" style='font-size: 0.8rem'
                                                    v-model="datos.fecha_inicio" @click="listarVenta(1,buscar,criterio)"
                                                    @change="listarVenta(1,buscar,criterio)">
                                                <!-- <input type="date" class="form-control"  v-model="datos.fecha_producto" @click="listarVenta(buscar,criterio)" @change="listarVenta(buscar,criterio)">   -->
                                            </div>
                                            &nbsp;&nbsp;&nbsp;
                                            <div>
                                                <input type="date" class="form-control" style='font-size: 0.8rem'
                                                    v-model="datos.fecha_fin" @click="listarVenta(1,buscar,criterio)"
                                                    @change="listarVenta(1,buscar,criterio)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        &nbsp;&nbsp;<div class="input-group"
                                            style='width:96%;margin-left: 3.3%;font-size: 0.8rem'>
                                            <!--<template v-if="usuario.id_tienda == 100">
                                        <select class="form-select" v-model="tienda" @change="listarVenta(1, buscar, criterio)" style='font-size: 0.8rem'>
                               
                                            <option v-for="tienda in arrayTienda2" :key="tienda.id" :value="tienda.id" v-text="tienda.nombre"></option>
                                        </select>
                                    </template>-->
                                            &nbsp;
                                            <select class="form-select col-md-3" v-model="criterio"
                                                style='font-size: 0.8rem'>
                                                <option value="cliente.nombre">Nombre</option>
                                                <option value="venta.usuario">Mesero</option>
                                                <option value="mesa.nombre">Mesa</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="text" v-model="buscar"
                                                @keyup.enter="listarVenta(1, buscar, criterio)"
                                                @keyup="BuscandoVenta(),TotalCobrado(),TotalPrecuenta()"
                                                class="form-control" placeholder="Texto a buscar"
                                                style='font-size: 0.8rem'>
                                            &nbsp;&nbsp;&nbsp;
                                            <button type="submit" @click="listarVenta(1, buscar, criterio)"
                                                class="btn btn-info text-white" style='font-size: 0.8rem'><i
                                                    class="fa fa-search"></i> Buscar</button>
                                        </div>
                                        <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for=""
                                            style='font-size: 0.8rem'><strong>TOTAL VENTA Bs.</strong> :
                                            {{isNaN(parseFloat(totalC.total))? 0 : (parseFloat(totalC.total)).toFixed(0)}}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>TOTAL PRECUENTA :
                                            </strong>{{isNaN(parseFloat(totalP.total))? 0 : (parseFloat(totalP.total)).toFixed(0)}}
                                        </label>

                                    </div>
                                </div>
                                <br>
                                <!-- Light table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover"
                                        style='width:96%;margin-left: 2.2%;font-size: 0.8rem'>
                                        <thead style="background-color: #46546C">
                                            <tr>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Fecha</th>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Cliente
                                                </th>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Venta - Mesa</th>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Total</th>
                                                <th scope="col" class="text-white text-center"
                                                    style='font-size: 0.8rem'>Estado</th>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Forma P.
                                                </th>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Usuario - Mesero</th>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Opciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="venta in arrayVenta" :key="venta.id">
                                                <td v-text="venta.fecha" style='font-size: 0.8rem'></td>
                                                <td v-text="venta.cliente" style='font-size: 0.8rem'></td>
                                                <td style='font-size: 0.8rem'> {{venta.mesa ? venta.mesa : 'Directa'}}
                                                </td>
                                                <td v-text="venta.total" style='font-size: 0.8rem'></td>
                                                <td class="text-center" style='font-size: 0.8rem'>
                                                    <template v-if="venta.estado=='Registrado'">
                                                        <span class="badge bg-success tamaño"
                                                            style='font-size: 0.8rem'>{{venta.estado}}</span>
                                                    </template>
                                                    <template v-if="venta.estado=='Cobrado'">
                                                        <span class="badge bg-info tamaño"
                                                            style='font-size: 0.8rem'>{{venta.estado}}</span>
                                                    </template>
                                                    <template v-if="venta.estado=='Anulado'">
                                                        <template v-if="venta.tipo_venta==1">
                                                            <span class="badge bg-danger tamaño"
                                                                style='font-size: 0.6rem'>{{venta.estado +'-Venta'  }}</span>
                                                        </template>
                                                        <template v-else>
                                                            <span class="badge bg-warning tamaño"
                                                                style='font-size: 0.6rem'>{{venta.estado +'-Preventa'  }}</span>
                                                            <!--span class="badge bg-danger tamaño" style='font-size: 0.7rem'>{{venta.efectivo }}</span>-->
                                                        </template>
                                                    </template>
                                                </td>
                                                <td v-text="venta.formaP" style='font-size: 0.8rem'></td>
                                                <td v-text="venta.usuario" style='font-size: 0.8rem'></td>

                                                <!-- <td>
                                        <a class="dropdown-item" href="#"><i class="fa fa-edit text-warning"></i> Modificar</a>
                                    </td> -->
                                                <!-- <td>
                                        <button type="button" class="btn btn-info text-white position-relative" data-bs-toggle="modal" data-bs-target="#modalPago" :disabled="venta.tipoP == 'Contado' || venta.estado == 'Anulado' ? true : false" @click="realizarPagos(venta)">Pagos</button>
                                    </td>  -->
                                                <td style='font-size: 0.8rem'>
                                                    <button class="btn btn-outline-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                                        style='font-size: 0.8rem'>Accion</button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#"
                                                                @click="verVenta(venta)"><i
                                                                    class="fa fa-eye text-success"></i> Ver detalle</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#"
                                                                @click="actImpresion(venta.id)"><i
                                                                    class="fa fa-print text-info"></i> Imprimir</a></li>
                                                        <!-- <li><a class="dropdown-item" href="#" @click="cargarPdf(venta.id)"><i class="fa fa-ticket text-danger"></i> Ticket</a></li> -->
                                                        <li><a class="dropdown-item" href="#"
                                                                @click="cargarPdf(venta.id,venta.id_tienda)"><i
                                                                    class="fa fa-ticket text-danger"></i> Ticket</a>
                                                        </li>
                                                        <!--<template v-if="usuario.id==1">-->
                                                        <template v-if="venta.estado=='Registrado'">
                                                            <li><a class="dropdown-item" 
                                                                    @click="anularVenta(venta.id,venta.id_mesa)"><i
                                                                        class="fa fa-lock text-danger"></i> Anular</a>
                                                            </li>
                                                        </template>
                                                        <template v-else-if="venta.estado=='Cobrado'">
                                                            <li><a class="dropdown-item" 
                                                                    @click="anularVentaRealizada(venta.id,venta.id_mesa)"><i
                                                                        class="fa fa-lock text-danger"></i> Anular</a>
                                                            </li>
                                                        </template>
                                                        <!--</template>-->
                                                        <template v-else>
                                                        </template>


                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Card Pagination -->
                                <div class="card-footer py-4">
                                    <nav>
                                        <ul class="pagination justify-content-end mb-0">
                                            <li class="page-item bg-color" v-if="pagination.current_page > 1">
                                                <a class="page-link" href="#"
                                                    @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                                            </li>
                                            <li class="page-item bg-color" v-for="page in pagesNumber" :key="page"
                                                :class="[page==isActived ? 'active' :'']">
                                                <a class="page-link" href="#"
                                                    @click.prevent="cambiarPagina(page, buscar, criterio)"
                                                    v-text="page">1</a>
                                            </li>
                                            <li class="page-item bg-color"
                                                v-if="pagination.current_page < pagination.last_page">
                                                <a class="page-link" href="#"
                                                    @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!--fin  -->

                    </template>

                    <!-- MODIFICAR -->
                    <template v-if="listado==1">
                        <div class="card-body">
                            <div class="form-group row" style='margin-left: 1%'>
                                <form class="row">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1" class="form-label">Cliente</label>
                                        <div class="input-group mb-6">
                                            <input type="text" readonly class="form-control"
                                                placeholder="Buscar Clientes.." v-model="datos.cliente"
                                                aria-label="Buscar Productos.." aria-describedby="button-addon2">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Fecha</label>
                                        <input type="date" class="form-control" v-model="datos.fecha" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Estado</label>
                                        <select class="form-select" v-model="datos.estado"
                                            :disabled="disabledAnulado || disabledEntregado">
                                            <option value="Recepcionado">Recepcionado</option>
                                            <option value="Concluido">Concluido</option>
                                            <template v-if="datos.estado == 'Entregado'">
                                                <option value="Entregado">Entregado</option>
                                            </template>
                                            <template v-if="datos.estado == 'Anulado'">
                                                <option value="Anulado">Anulado</option>
                                            </template>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Pagos</label>
                                        <template v-if="datos.id_descuento == 1">
                                            <input value="Unitario" type="text" id="Unitario" class="form-control"
                                                disabled>
                                        </template>
                                        <template v-if="datos.id_descuento == 2">
                                            <input value="Mayorista" type="text" id="Mayorista" class="form-control"
                                                disabled>
                                        </template>
                                        <template v-if="datos.id_descuento == 3">
                                            <input value="Preferencial" type="text" id="Preferencial"
                                                class="form-control" disabled>
                                        </template>
                                        <template v-if="datos.id_descuento == 0">
                                            <input value="" type="text" id="Preferencial" class="form-control" disabled>
                                        </template>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="exampleInputPassword1" class="form-label">Descripcion</label>
                                        <textarea class="form-control" v-model="datos.descripcion" rows="2"
                                            disabled></textarea>
                                    </div>
                                    &nbsp;
                                </form>
                            </div>

                            <br>
                            <div class="form-group row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" style='width:96%;margin-left: 2%'>
                                        <thead style="background-color: #46546C">
                                            <tr>
                                                <!-- <th scope="col" class="text-white">Opción</th> -->
                                                <th scope="col" class="text-white">Categoria</th>
                                                <th scope="col" class="text-white">Nombre</th>
                                                <th scope="col" class="text-white">Articulo</th>
                                                <th scope="col" class="text-white">Tienda</th>
                                                <th scope="col" class="text-white">Precio</th>
                                                <th scope="col" class="text-white">Cantidad</th>
                                                <th scope="col" class="text-white">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                                <!-- <td>
                                            <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white"></i></button>
                                        </td> -->
                                                <td v-text="detalle.categoria"></td>
                                                <td v-text="detalle.articulo"></td>
                                                <td v-text="detalle.marca"></td>
                                                <td v-text="detalle.tienda"></td>
                                                <td>
                                                    <input v-model="detalle.costo_venta" type="number" value="3"
                                                        class="form-control" disabled>
                                                </td>

                                                <td>
                                                    <input v-model="detalle.cantidad" type="number" value="3"
                                                        class="form-control" disabled>
                                                    <!-- <span style="color:red;" v-show="detalle.cantidad>detalle.stock">Stock: {{detalle.stock}}</span> -->
                                                </td>
                                                <td>
                                                    {{detalle.sub_total}} bs
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="6" align="right"> <strong>Sub Total:</strong> </td>
                                                <td>{{datos.sub_total}} bs</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="6" align="right"> <strong>Descuento:</strong> </td>
                                                <td><input v-model="datos.descuento" type="number" value="0"
                                                        class="form-control" disabled></td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="6" align="right"> <strong>Total:</strong> </td>
                                                <td>{{datos.total}} bs</td>
                                            </tr>

                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="6">No hay Productos agregados</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end"
                                style='width:96%;margin-left: 2.2%'>
                                <button class="btn btn-danger me-md-2 text-white" type="button"
                                    @click="volverVentaListado()">Cancelar</button>
                                <button class="btn btn-info btn-lg text-white" type="button"
                                    @click="actualizarServicio()">Actualizar</button>
                            </div>
                        </div>
                    </template>
                    <!-- FIN MODIFICAR -->

                    <!-- VER -->
                    <template v-if="listado==2">
                        <!-- <div class="card-header row m-0">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-danger text-white" @click="volverVentaListado()">
                                    <i class="fa fa-reply-all"></i>&nbsp;Volver
                                </button>
                                <button type="button" @click="cargarPdf(datos.id, datos.foto, datos.empresa_nombre)" class="btn btn-info">
                                    <i class="icon-doc text-white"></i><span class="text-white">&nbsp;Reporte</span>
                                </button>
                            </div>
                            <div class="col-md-4 text-center" ><h3 class="mb-0">REGISTRO DE VENTA</h3></div>
                            <div class="col-md-4">&nbsp;</div>
                        </div> -->
                        <div class="card-header text-center">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">REGISTRO DE VENTA</h5>
                                <button type="button" class="btn-close btn-close" @click="volverVentaListado()"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <form class="row g-3">
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Cliente</label>
                                        <input type="text" class="form-control" v-model="datos.cliente" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Fecha</label>
                                        <input type="date" class="form-control" v-model="datos.fecha" disabled>
                                    </div>
                                    <template v-if="datos.formaPago != 'Cuenta por Cobrar'">
                                        <div class="col-md-6">
                                            <label for="exampleInputPassword1" class="form-label">Forma Pago</label>
                                            <input type="text" class="form-control" v-model="datos.formaPago" disabled>
                                        </div>
                                    </template>
                                </form>
                            </div>

                            <br>
                            <div class="form-group row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" style='font-size: 0.8rem'>
                                        <thead style="background-color: #46546C">
                                            <tr>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Nombre</th>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Precio
                                                    Venta</th>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Cantidad
                                                </th>
                                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Sub Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                                <td v-text="detalle.articulo" style='font-size: 0.8rem'></td>
                                                <td style="font-weight: bold;font-size: 0.8rem"
                                                    v-text="detalle.costo_venta"></td>
                                                <td v-text="detalle.cantidad" style='font-size: 0.8rem'></td>
                                                <td v-text="detalle.sub_total" style='font-size: 0.8rem'></td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="2"></td>
                                                <td align="right" style='font-size: 0.8rem'><strong>Sub Total:</strong>
                                                </td>
                                                <td style='font-size: 0.8rem'>{{datos.sub_total}} bs</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="2"></td>
                                                <td align="right" style='font-size: 0.8rem'> <strong>Descuento:</strong>
                                                </td>
                                                <td v-text="datos.descuento" style='font-size: 0.8rem'></td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="2"></td>
                                                <td align="right" style='font-size: 0.8rem'> <strong>Total:</strong>
                                                </td>
                                                <td style='font-size: 0.8rem'>{{datos.total}} bs</td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="7" style='font-size: 0.8rem'>No hay Productos agregados
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- FIN VER -->
                </div>
            </div>
        </div>
        <!-- </div>   -->

        <!--Modal Formulario Articulo-->
        <div class="modal fade" id="modalArticulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white">
                        <h4 class="modal-title ">Busqueda de Articulos</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" v-model="buscarP" @keyup.enter="listarArticulo(buscarP)"
                                        class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulo(buscarP)"
                                        class="btn btn-primary text-white"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead style="background-color: #46546C">
                                    <tr>
                                        <th scope="col" class="text-white">Nombre</th>
                                        <th scope="col" class="text-white">Tienda</th>
                                        <th scope="col" class="text-white">Precio</th>
                                        <th scope="col" class="text-white">Opción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="tienda_articulo in arrayArticulo" :key="tienda_articulo.id">
                                        <td v-text="tienda_articulo.articulo"></td>
                                        <td v-text="tienda_articulo.tienda"></td>
                                        <td v-text="tienda_articulo.costo_venta"></td>

                                        <td>
                                            <button type="button" @click="seleccionarTiendaArticulo(tienda_articulo)"
                                                class="btn btn-success btn-sm"><i
                                                    class="fa fa-check text-white"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin modal Formulario Articulo-->


        <!--Modal Formulario Pago al Crédito-->
        <div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white" style="height:55px;">
                        <h4 class="modal-title ">Pago al Credito</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row">
                                <div class="mb-3 col-sm-6">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Fecha</label>
                                    <div><input type="date" class="form-control" v-model="datosPago.fecha" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Fecha Final</label>
                                    <div><input type="date" class="form-control" v-model="datosPago.fecha_final"
                                            disabled></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-6">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Pago</label>
                                    <div>
                                        <!-- <input type="number" class="form-control" v-model="datosPago.amortizacion" v-on:change="calcularSaldo"> -->
                                        <input type="number" class="form-control" v-model="datosPago.amortizacion"
                                            v-on:change="parseFloat(calcularSaldo)"
                                            :disabled="ultimoPago.saldo > 0 ? false : true">
                                        <!-- <vue-numeric class="form-control" v-model="datosPago.amortizacion" separator="," :precision="2" v-on:change="parseFloat(calcularSaldo)" :disabled="ultimoPago.saldo > 0 ? false : true"/> -->
                                    </div>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Saldo</label>
                                    <div class="border border-secondary rounded p-2 bg-gris">
                                        <!-- <input type="number" class="form-control" v-model="ultimoPago.saldo" disabled> -->
                                        <!-- <vue-numeric class="form-control" v-model="ultimoPago.saldo" separator="," :precision="2" disabled/> -->
                                        {{calcularSaldo.toFixed(2)}}
                                    </div>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Monto Total</label>
                                    <div><input type="number" class="form-control" v-model="ultimoPago.monto_total"
                                            disabled></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Descripcion</label>
                                <textarea class="form-control" id="message-text"
                                    v-model="datosPago.descripcion"></textarea>
                                <!-- <div class="col-sm-10"><input type="text" class="form-control" v-model="datosCategoria.descripcion"></div> -->
                            </div>&nbsp;&nbsp;&nbsp;
                            <!-- <div v-show="errorPago" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjPago" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div> -->

                            <!--                             <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" v-model="buscarP" @keyup.enter="listarPagos()" class="form-control" placeholder="Texto a buscar">
                                        &nbsp;&nbsp;&nbsp;
                                        <button type="submit" @click="listarPagos(buscarP)" class="btn btn-info text-white"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>&nbsp; -->



                            <!-- detalles de Pagos -->
                            <table class="table table-striped table-hover">
                                <thead style="background-color: #46546C">
                                    <tr>
                                        <th scope="col" class="text-white">Numero</th>
                                        <th scope="col" class="text-white">Fecha</th>
                                        <th scope="col" class="text-white">Monto Total</th>
                                        <th scope="col" class="text-white">Pagos</th>
                                        <th scope="col" class="text-white">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(c_x_cobrar,index) in arrayCXCobrar" :key="c_x_cobrar.id">
                                        <td v-if="c_x_cobrar.monto_total != c_x_cobrar.saldo" class="text-center"
                                            width=10%>{{index}}</td>
                                        <td v-if="c_x_cobrar.monto_total != c_x_cobrar.saldo" v-text="c_x_cobrar.fecha">
                                        </td>
                                        <td v-if="c_x_cobrar.monto_total != c_x_cobrar.saldo"
                                            v-text="c_x_cobrar.monto_total"></td>
                                        <td v-if="c_x_cobrar.monto_total != c_x_cobrar.saldo"
                                            v-text="c_x_cobrar.amortizacion"></td>
                                        <td v-if="c_x_cobrar.monto_total != c_x_cobrar.saldo" v-text="c_x_cobrar.saldo">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- fin detalles de Pagos -->




                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal"
                            @click="limpiarCXCobrar()">Cerrar</button>
                        <button type="button" class="btn btn-info text-white" data-bs-dismiss="modal"
                            @click="guardarAmortizacion()"
                            :disabled="ultimoPago.saldo > 0 ? false : true">Guardar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin modal Formulario Pago al credito-->
    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    import moment from 'moment';
    export default {
        create() {
            this.contrasena();
            this.usuarioAuth();
            
        },
        data() {
            return {
                datos: {
                    id: 0,
                    fecha: moment().format('YYYY-MM-DD'),
                    sub_total: 0,
                    descuento: 0,
                    total: 0,
                    id_tipo_pago: 0,
                    id_forma_pago: 0,
                    id_cliente: 0,
                    cliente: '',
                    tipoPago: '',
                    formaPago: '',
                    id_descuento: '',
                    foto: '',
                    empresa_nombre: '',
                    empresa_direccion: '',
                    fecha_inicio: moment().format('YYYY-MM-DD'),
                    fecha_fin: moment().format('YYYY-MM-DD'),
                },

                datosPago: {
                    id: 0,
                    fecha: moment().format('YYYY-MM-DD'),
                    fecha_final: moment().format('YYYY-MM-DD'),
                    monto_total: '',
                    saldo: 0,
                    amortizacion: '',
                    descripcion: '',
                    id_pago: '',
                },

                arrayVenta: [],
                arrayDetalle: [],
                arrayDetalle2: [],
                arrayArticulo: [],
                arrayCliente: [],
                arrayVentaServicio: [],
                arrayCXCobrar: [],
                arrayEmpresa: [],
                arrayPago: [],
                arrayVentaVacuna: [],
                arrayListaPagos: [],
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
                arrayForma: [],
                listado: 0,
                tipoAccion: 0,
                errorCompra: 0,
                errorMostrarMsjCompra: [],
                errorPago: 0,
                errorMostrarMsjPago: [],
                ultimoPago: {},
                CXCobrar: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                paginationServicio: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                paginationCotizacion: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'cliente.nombre',
                buscar: '',
                buscarP: '',
                numero: 0,
                imagenMiniatura: '',
                empresa: {},
                setTimeoutBuscador: '',
                listadoMenu: 0,
                totalC: {},
                totalP: {},
                usuario: {},
                arrayTienda2: [],
                tienda: 1,
                contrasena_id: 0,

            }
        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
            isActivedServicio: function () {
                return this.paginationServicio.current_page;
            },
            isActivedCotizacion: function () {
                return this.paginationCotizacion.current_page;
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
            pagesNumberServicio: function () {
                if (!this.paginationServicio.to) {
                    return [];
                }
                var from = this.paginationServicio.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.paginationServicio.last_page) {
                    to = this.paginationServicio.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            pagesNumberCotizacion: function () {
                if (!this.paginationCotizacion.to) {
                    return [];
                }
                var from = this.paginationCotizacion.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.paginationCotizacion.last_page) {
                    to = this.paginationCotizacion.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularTotal: function () {
                var resultado = 0.0;
                for (var i = 0; i < this.arrayDetalle.length; i++) {
                    if (this.datos.id_descuento == 1) {
                        resultado = resultado + (this.arrayDetalle[i].costo_unitario * this.arrayDetalle[i]
                            .cantidad);
                    } else if (this.datos.id_descuento == 2) {
                        resultado = resultado + (this.arrayDetalle[i].costo_mayorista * this.arrayDetalle[i]
                            .cantidad);
                    } else if (this.datos.id_descuento == 3) {
                        resultado = resultado + (this.arrayDetalle[i].costo_preferencial * this.arrayDetalle[i]
                            .cantidad);
                    } else {}

                }
                return resultado;
            },
            calcularSaldo: function () {
                var resultado = 0.0
                var saldo = this.datosPago.amortizacion <= this.ultimoPago.saldo ? this.datosPago.amortizacion : 0
                resultado = this.ultimoPago.saldo - saldo;
                return resultado
            }
        },
        methods: {
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
                        me.arrayTienda2 = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            actImpresion(id) {
                let me = this;
                //me.arrayVenta.id= id;
                //me.listado = 4;
                var url = '/venta/imprimirVenta?id=' + id;
                axios.put(url).then(function (response) {
                        //me.arrayVenta = response.data;
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
            cargarPdf(id, id_tienda) {
                //this.actImpresion();
                //this.arrayVenta.id= id;
                // axios.get('/venta/pdf?id=' + id,{responseType: 'blob'})
                axios.get('/venta/pdfPreVenta?id=' + id + '&id_tienda=' + id_tienda, {
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
            listarVenta(page, buscar, criterio) {
                let me = this;
                me.tienda = 2;
                if (me.usuario.id_tienda == 100) {
                    var url = '/venta_tienda1?page=' + page + '&fecha_inicio=' + me.datos.fecha_inicio + '&fecha_fin=' +
                        this.datos.fecha_fin + '&buscar=' + buscar + '&criterio=' + criterio + '&id_tienda=' + me
                        .tienda;
                    axios.get(url).then(function (response) {
                            me.arrayVenta = response.data.data;
                            me.pagination = {
                                total: response.data.total,
                                current_page: response.data.current_page,
                                per_page: response.data.per_page,
                                last_page: response.data.last_page,
                                from: response.data.from,
                                to: response.data.to
                            }

                            me.TotalCobrado();
                            me.TotalPrecuenta();

                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                } else {
                    var url = '/venta_tienda1?page=' + page + '&fecha_inicio=' + me.datos.fecha_inicio + '&fecha_fin=' +
                        this.datos.fecha_fin + '&buscar=' + buscar + '&criterio=' + criterio + '&id_tienda=' + me
                        .usuario.id_tienda;
                    axios.get(url).then(function (response) {
                            me.arrayVenta = response.data.data;
                            me.pagination = {
                                total: response.data.total,
                                current_page: response.data.current_page,
                                per_page: response.data.per_page,
                                last_page: response.data.last_page,
                                from: response.data.from,
                                to: response.data.to
                            }

                            me.TotalCobrado();
                            me.TotalPrecuenta();

                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                }
            },
            TotalCobrado() {
                let me = this;
                if (me.usuario.id_tienda == 100) {
                    var url = '/venta_tienda1/totalCobrado?buscar=' + me.buscar + '&criterio=' + me.criterio +
                        '&fecha_inicio=' + me.datos.fecha_inicio + '&fecha_fin=' + me.datos.fecha_fin + '&id_tienda=' +
                        me.tienda;
                    axios.get(url).then(function (response) {
                            me.totalC = response.data;

                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                } else {
                    var url = '/venta_tienda1/totalCobrado?buscar=' + me.buscar + '&criterio=' + me.criterio +
                        '&fecha_inicio=' + me.datos.fecha_inicio + '&fecha_fin=' + me.datos.fecha_fin + '&id_tienda=' +
                        me.usuario.id_tienda;
                    axios.get(url).then(function (response) {
                            me.totalC = response.data;

                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                }
            },
            TotalPrecuenta() {
                let me = this;
                if (me.usuario.id_tienda == 100) {
                    var url = '/venta_tienda1/totalPrecuenta?buscar=' + me.buscar + '&criterio=' + me.criterio +
                        '&fecha_inicio=' + me.datos.fecha_inicio + '&fecha_fin=' + me.datos.fecha_fin + '&id_tienda=' +
                        me.tienda;
                    axios.get(url).then(function (response) {
                            me.totalP = response.data;

                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                } else {
                    var url = '/venta_tienda1/totalPrecuenta?buscar=' + me.buscar + '&criterio=' + me.criterio +
                        '&fecha_inicio=' + me.datos.fecha_inicio + '&fecha_fin=' + me.datos.fecha_fin + '&id_tienda=' +
                        me.usuario.id_tienda;
                    axios.get(url).then(function (response) {
                            me.totalP = response.data;

                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                }
            },
            listarVentaCotizacion(page, buscar, criterio) {
                let me = this;
                var url = '/ventaControl_tienda1?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                        me.arrayVentaVacuna = response.data.data;
                        me.paginationCotizacion = {
                            total: response.data.total,
                            current_page: response.data.current_page,
                            per_page: response.data.per_page,
                            last_page: response.data.last_page,
                            from: response.data.from,
                            to: response.data.to
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            listarVentaBusquedaRapida() {
                let me = this;
                var url = '/venta_tienda1?page=' + 1 + '&fecha_inicio=' + me.datos.fecha_inicio + '&fecha_fin=' + me
                    .datos.fecha_fin + '&buscar=' + me.buscar + '&criterio=' + me.criterio;
                axios.get(url).then(function (response) {
                        me.arrayVenta = response.data.data;
                        me.pagination = {
                            total: response.data.total,
                            current_page: response.data.current_page,
                            per_page: response.data.per_page,
                            last_page: response.data.last_page,
                            from: response.data.from,
                            to: response.data.to
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            BuscandoVenta() {
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarVentaBusquedaRapida, 350)
            },
            listarVentaServicio(page, buscar, criterio) {
                let me = this;
                var url = '/ventaServicio_tienda1?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                        me.arrayVentaServicio = response.data.data;
                        me.paginationServicio = {
                            total: response.data.total,
                            current_page: response.data.current_page,
                            per_page: response.data.per_page,
                            last_page: response.data.last_page,
                            from: response.data.from,
                            to: response.data.to
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            listarVentaServicioVentaDirecta() {
                let me = this;
                var url = '/ventaServicio_tienda1?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio;
                axios.get(url).then(function (response) {
                        me.arrayVentaServicio = response.data.data;
                        me.paginationServicio = {
                            total: response.data.total,
                            current_page: response.data.current_page,
                            per_page: response.data.per_page,
                            last_page: response.data.last_page,
                            from: response.data.from,
                            to: response.data.to
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            BuscandoVentaServicio() {
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarVentaServicioVentaDirecta, 350)
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarVenta(page, buscar, criterio);
            },
            cambiarPaginaServicio(page, buscar, criterio) {
                let me = this;
                me.paginationServicio.current_page = page;
                me.listarVentaServicio(page, buscar, criterio);
            },
            cambiarPaginaCotizacion(page, buscar, criterio) {
                let me = this;
                me.paginationCotizacion.current_page = page;
                me.listarVentaCotizacion(page, buscar, criterio);
            },
            listarArticulo(buscarP) {
                let me = this;
                var url = '/tienda/listarSinPaginate2?buscar=' + buscarP;
                axios.get(url).then(function (response) {
                        me.arrayArticulo = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
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
            eliminarDetalle(index) {
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            seleccionarTiendaArticulo(data = []) {
                let me = this;
                if (me.encuentra(data['id_articulo'])) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'Este articulo ya se encuentra agregado!'
                    })
                } else {
                    me.arrayDetalle.push({
                        id_tienda_articulo: data['id'],
                        id_articulo: data['id_articulo'],
                        articulo: data['articulo'],
                        categoria: data['categoria'],
                        marca: data['marca'],
                        tienda: data['tienda'],
                        costo_venta: data['costo_venta'],
                        cantidad: 1,
                        sub_total: data['sub_total']
                    });
                }
            },
            cancelarCompra() {
                let me = this;
                me.arrayDetalle = [];
                me.arrayArticulo = [];
                me.datos.nombre = '';
                me.buscarP = '';
            },
            volverVentaListado() {
                let me = this;
                me.arrayDetalle = [];
                me.arrayArticulo = [];
                me.datos.nombre = '';
                me.buscarP = '';
                me.listado = 0;
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
                me.datos.id_descuento = data['id_descuento'];
                me.datos.total = data['total'];
                me.datos.sub_total = data['sub_total'];

                var url = '/venta/permiso/detalle_tienda1?id=' + data['id'];
                axios.get(url).then(function (response) {
                        me.arrayDetalle = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            editarDetalle(data = []) {
                let me = this;
                me.listado = 1;
                me.datos.id = data['id'];
                me.datos.id_cliente = data['id_cliente'];
                me.datos.cliente = data['cliente'];
                me.datos.estado = data['estado'];
                me.datos.fecha = data['fecha'];
                me.datos.descuento = data['descuento'];
                me.datos.descripcion = data['descripcion'];
                me.datos.tipoPago = data['tipoP'];
                me.datos.formaPago = data['formaP'];
                me.datos.id_descuento = data['id_descuento'];
                me.datos.sub_total = data['sub_total'];
                me.datos.total = data['total'];
                var url = '/venta/permiso/detalle_tienda1?id=' + data['id'];
                axios.get(url).then(function (response) {
                        me.arrayDetalle = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            guardarVenta() {
                if (this.arrayDetalle.length <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'No Existe permisos agregados!'
                    })
                }
                let me = this;
                axios.post('/venta/guardar', {
                        'fecha': me.datos.fecha,
                        'sub_total': me.datos.sub_total,
                        'descuento': me.datos.descuento,
                        'total': me.datos.total,
                        'id_cliente': me.datos.id_cliente,
                        'id_tipo_pago': me.datos.id_tipo_pago,
                        'id_forma_pago': me.datos.id_forma_pago,
                        'detalle': me.arrayDetalle
                    }).then(function (response) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Venta registrado exitosamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        me.volverVentaListado();
                        me.listarVenta(1, '', 'nombre');
                        me.limpiarDatosCategoria();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            guardarAmortizacion() {
                let me = this;
                if (me.datosPago.amortizacion == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'Ingrese un monto!'
                    })
                    me.limpiarCXCobrar();
                } else {
                    console.log(me.ultimoPago.amortizacion);
                    if (me.datosPago.amortizacion > parseFloat(me.ultimoPago.saldo)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Monto Mayor al Saldo!'
                        })
                        me.limpiarPago();
                    } else {
                        axios.post('/c_x_cobrar/guardar', {
                                'fecha': me.datosPago.fecha,
                                'monto_total': parseFloat(me.ultimoPago.monto_total).toFixed(2),
                                'amortizacion': parseFloat(me.datosPago.amortizacion).toFixed(2),
                                'saldo': me.ultimoPago.saldo,
                                'descripcion': me.datosPago.descripcion,
                                'id_pago': me.datosPago.id_pago,
                            }).then(function (response) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Pago registrado exitosamente',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                console.log('datosPago', me.datosPago);
                                me.volverVentaListado();
                                me.listarVenta(1, '', 'nombre');
                                me.listarCXCobrar(me.datosPago.id_pago);
                                me.limpiarDatosCategoria();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }

                }
            },
            validarCompra() {
                this.errorCompra = 0;
                this.errorMostrarMsjCompra = [];

                if (!this.datos.nombre) this.errorMostrarMsjCompra.push("El nombre del Compra no puede estar vacio ");
                if (this.errorMostrarMsjCompra.length) this.errorCompra = 1;
                return this.errorCompra;
            },
            frmVenta() {
                this.listado = 1;
                this.selectCliente();
                this.selectTipoP();
                this.selectFormaP();
            },
            anularVenta(id, id_mesa) {
               
                let me=this;
                Swal.fire({

                    title: 'Ingrese credenciales para anular la venta?',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelbuttonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {

                        if((cant!=me.contrasena_id.Contrasena)  || cant==''){
                            Swal.showValidationMessage(
                                `Contraseña Incorrecta :)`
                            );
                            console.log(cant);
                        }else{
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


            anularVentaRealizada(id, id_mesa) {
                
                let me=this;
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

                        if((cant!=me.contrasena_id.Contrasena)  || cant==''){
                            Swal.showValidationMessage(
                                `Contraseña Incorrecta :)`
                            );
                            console.log(cant);
                        }else{
                            axios.put('/venta/anular_tienda1Realizada', {
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
            limpiarDatosCategoria() {
                this.datos = {
                    id: 0,
                    fecha: moment().format('YYYY-MM-DD'),
                    sub_total: 0,
                    descuento: 0,
                    total: 0,
                    id_tipo_pago: 0,
                    id_forma_pago: 0,
                    id_cliente: 0,
                    cliente: '',
                    tipoPago: '',
                    formaPago: '',
                }
                this.datosPago.amortizacion = 0;
            },
            listarPagos(buscarP) {
                let me = this;
                var url = '/pagos?buscar=' + buscarP;
                axios.get(url).then(function (response) {
                        me.arrayListaPagos = response.data;
                        me.datosPago.fecha_final = me.arrayListaPagos[0].fecha_final;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            listarCXCobrar(pago) {
                let me = this;
                var url = '/c_x_cobrar?buscar=' + pago;
                axios.get(url).then(function (response) {
                        me.arrayCXCobrar = response.data;
                        me.CXCobrar = response.data;
                        me.cargarUltimoPago();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            realizarPagos(venta) {
                this.listarPagos(venta.id);
                this.datosPago.id_pago = venta.id;
                this.listarCXCobrar(this.datosPago.id_pago);
                this.datosPago.monto_total = venta.total;
                this.datosPago.saldo = this.datosPago.monto_total;
                this.datosPago.amortizacion = this.datosPago.amortizacion;
            },
            cargarUltimoPago() {
                const array = this.CXCobrar;
                this.ultimoPago = array[array.length - 1];
                //this.tipoFecha = this.tipoFechas.find(f => f.id > 0);
                // this.ultimoPago = this.CXCobrar.pop();
                // console.log(this.CXCobrar.length)
                //this.ultimoPago = this.CXCobrar.find(f => Math.max(this.CXCobrar.id));
            },

            limpiarCXCobrar() {
                this.datosPago = {
                        id: 0,
                        fecha: moment().format('YYYY-MM-DD'),
                        monto_total: 0,
                        saldo: 0,
                        amortizacion: 0,
                        descripcion: '',
                        amortizacion: 0,
                        id_pago: 0,
                    },

                    this.ultimoPago = {
                        monto_total: 0,
                        amorticacion: 0,
                        saldo: 0,
                    };
            },
            limpiarPago() {
                this.datosPago.amortizacion = 0;
                this.datosPago.descripcion = '';
            },

            listarEmpresa(page, buscar, criterio) {
                let me = this;

            },
            volverMenu() {
                this.$emit('cerrarMenu', this.listadoMenu);
            }
        },
        mounted() {
            this.contrasena();
            this.usuarioAuth();
            this.selectTienda();
            this.selectTienda();
            setTimeout(() => {
                this.listarVenta(1, this.buscar, this.criterio);
            }, 1500)
            

            //this.listarEmpresa(1, this.buscar, this.criterio);

        }
    }

</script>
<style>
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

    .bg-gris {
        background-color: #D8DBE0;
    }

    .tamaño {
        width: 100px !important;
    }

</style>
