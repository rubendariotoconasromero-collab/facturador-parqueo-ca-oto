<template>
    <main class="main">
        <!-- <div class="container"> -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <template v-if="listado==0">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">PRODUCTOS</h5>
                                <button v-if="isMobileDevice()==true" type="button" class="btn-close btn-close-white"
                                    @click="volverMenu()" aria-label="Close"></button>
                            </div>
                        </div>
                        <!-- prueba card -->
                        <div class="row mt-2" style='width:90%;margin-left: 1.5%'>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4" style="--cui-card-cap-bg: #3399FF">
                                    <div
                                        class="card-header position-relative d-flex justify-content-center align-items-center text-white">
                                        <strong style='font-size: 0.8rem'> PRODUCTOS </strong>
                                    </div>
                                    <div class="card-body row text-center">
                                        <div class="col">
                                            <div class="avatar avatar-md"><img class="avatar-img"
                                                    src="img/sit_norte/icons8-producto-48.png"></div>
                                        </div>
                                        <div class="col">
                                            <div class="fs-5 fw-semibold" style='font-size: 0.8rem'>
                                                {{producto_registro}}</div>
                                            <div class="text-uppercase text-medium-emphasis small">Registros</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4" style="--cui-card-cap-bg: #0E91FF">
                                    <div
                                        class="card-header position-relative d-flex justify-content-center align-items-center text-white">
                                        <strong style='font-size: 0.8rem'> CATEGORIA </strong>
                                    </div>
                                    <div class="card-body row text-center">
                                        <div class="col">
                                            <div class="fs-5 fw-semibold" style='font-size: 0.8rem'>
                                                {{categoria_registro}}</div>
                                            <div class="text-uppercase text-medium-emphasis small"
                                                style='font-size: 0.8rem'>Registros </div>
                                        </div>
                                        <div class="vr"></div>
                                        <div class="col">
                                            <button type="button" class="btn btn-info text-white position-relative"
                                                data-bs-toggle="modal" data-bs-target="#frmCategoria"
                                                style='font-size: 0.8rem'>
                                                <i class="icon-plus"></i>
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                    new
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-->
                            <!-- <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4" style="--cui-card-cap-bg: #0E91FF">
                                    <div class="card-header position-relative d-flex justify-content-center align-items-center text-white">
                                    <strong style='font-size: 0.8rem'> UNIDAD MEDIDA </strong>
                                    </div>
                                    <div class="card-body row text-center">
                                    <div class="col">
                                        <div class="fs-5 fw-semibold" style='font-size: 0.8rem'>{{unidad_registro}}</div>
                                        <div class="text-uppercase text-medium-emphasis small" style='font-size: 0.8rem'>Registros </div>
                                    </div>
                                    <div class="vr"></div>
                                    <div class="col">
                                        <button type="button" class="btn btn-info text-white position-relative" data-bs-toggle="modal" data-bs-target="#frmUnidad" style='font-size: 0.8rem'>
                                            <i  class="icon-plus"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                new
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>


                        <!-- prueba fin card -->

                        <div class="card-header">
                            <button type="button" @click="btnNuevoArticulo()" class="btn btn-info text-white"
                                style='margin-left: 1.2%;font-size: 0.8rem'>
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="form-group mt-3 mb-3" id="home">
                            <div class="col-md-8">
                                <div class="input-group" style='width:96%;margin-left: 3.3%;font-size: 0.8rem'>

                                    <!-- <select class="form-select col-md-3" v-model="datos.impresion" @change="cambiarVenta()" style='font-size: 0.8rem'>
                                                <option value="0">Bar</option>
                                                <option value="1">Cocina</option>                                  
                                            </select> -->
                                    <template v-if="usuario.id_tienda == 100">
                                        <!--<select class="form-select" v-model="tienda" @change="listarArticulo(1, buscar, criterio)" style='font-size: 0.8rem'>
                                                
                                                <option v-for="tienda in arrayTienda" :key="tienda.id" :value="tienda.id" v-text="tienda.nombre"></option>
                                            </select>-->
                                    </template>
                                    &nbsp;
                                    <select class="form-select col-md-3" v-model="criterio" style='font-size: 0.8rem'>
                                        <option value="articulo.nombre">Nombre</option>
                                        <option value="categoria.nombre">Categoria</option>
                                        <option value="articulo.cod_proveedor">Cod. Proveedor</option>
                                    </select>
                                    &nbsp;
                                    <input type="text" v-model="buscar"
                                        @keyup.enter="listarArticulo(1, buscar, criterio)" @keyup="BuscandoArticulo()"
                                        class="form-control" placeholder="Texto a buscar" style='font-size: 0.8rem'>
                                    &nbsp;
                                    <button type="submit" @click="listarArticulo(1, buscar, criterio)"
                                        class="btn btn-info text-white" style='font-size: 0.8rem'><i
                                            class="fa fa-search"></i> Buscar</button>

                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover"
                                style='width:96%;margin-left: 2.2%;font-size: 0.8rem'>
                                <thead style="background-color: #46546C">
                                    <tr>
                                        <!-- <th scope="col" class="text-white">Cod. Ean</th>                   -->
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Categoria</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Nombre</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Precio Venta</th>
                                        <!-- <th scope="col" class="text-white" style='font-size: 0.8rem'>Contenido Presentacion</th> -->
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Stock</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Foto</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Estado</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayArticulo.length">
                                    <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                        <!-- <td v-text="articulo.cod_ean"></td> -->
                                        <td v-text="articulo.categoria" style='font-size: 0.8rem'></td>
                                        <td v-text="articulo.nombre" style='font-size: 0.8rem'></td>
                                        <td v-text="articulo.costo_venta" style='font-size: 0.8rem'></td>
                                        <!-- <td v-text="articulo.contenido_presentacion" style='font-size: 0.8rem'></td> -->
                                        <td style='font-size: 0.8rem'>
                                            {{ (parseFloat(articulo.stock_actual)).toFixed(2)}}</td>
                                        <td style='font-size: 0.8rem'><img :src="'img/producto/'+articulo.foto"
                                                width="45" height="45"
                                                class="border border-1 border-dark rounded-circle" align="left" alt="">
                                        </td>
                                        <!-- <td><img :src="'img/producto/'+articulo.foto" width="60" align="left" alt=""></td>    -->

                                        <td>
                                            <template v-if="articulo.estado==1">
                                                <span class="badge bg-success">Activo</span>
                                            </template>
                                            <template v-else>
                                                <span class="badge bg-danger">Desactivo</span>
                                            </template>
                                        </td>
                                        <td style='font-size: 0.8rem'>
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style='font-size: 0.8rem'>Accion</button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#"
                                                        @click="editarArticulo(articulo)"><i
                                                            class="fa fa-edit text-warning"></i> Modificar</a></li>
                                                <template v-if="articulo.estado==1">
                                                    <li><a class="dropdown-item" href="#"
                                                            @click="desactivarArticulo(articulo.id)"><i
                                                                class="fa fa-unlock text-success"></i> Desactivar</a>
                                                    </li>
                                                </template>
                                                <template v-else>
                                                    <li><a class="dropdown-item" href="#"
                                                            @click="activarArticulo(articulo.id)"><i
                                                                class="fa fa-lock text-danger"></i> Activar</a></li>
                                                </template>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="13">No hay Productos agregados</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Card Pagination -->
                        <div class="card-footer py-4">
                            <nav>
                                <ul class="pagination justify-content-end mb-0">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#"
                                            @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page"
                                        :class="[page==isActived ? 'active' :'']">
                                        <a class="page-link" href="#"
                                            @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page">1</a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#"
                                            @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </template>

                    <template v-if="listado==1">
                        <div class="card-body">

                            <!-- <div class="col-md-1">
                                    <button type="button" @click="ocultarListado1()" class="btn btn-danger text-white " >
                                        <i class="fa fa-reply-all"></i>&nbsp;Volver
                                    
                                    </button>
                                    
                                </div>
                                <div class="col-md-9 text-center">
                                    <h3 class="mb-0"></h3>  
                                </div> -->
                            <div class="card-header text-center">
                                <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 col-md-11">DATOS DE PRODUCTOS</h5>
                                    <button type="button" class="btn-close btn-close" @click="ocultarListado1()"
                                        aria-label="Close"></button>
                                </div>
                            </div>


                            <div class="card-header text-center line p-0 m-0" style="background-color: #3399FF">

                            </div>&nbsp;

                            <form class="row g-3">
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" v-model="datos.nombre">
                                </div>
                                <!-- <div class="col-md-6">
                                            <label for="exampleInputPassword1" class="form-label">Proveedor</label>
                                            <select class="form-select" v-model="datos.id_proveedor">
                                                <option value="0" disabled>Seleccione Proveedor</option>
                                                <option v-for="proveedor in arrayProveedor" :key="proveedor.id" :value="proveedor.id" v-text="proveedor.nombre"></option>
                                            </select>
                                    </div> -->
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Categoria</label>
                                    <div class="input-group mb-6">
                                        <section class="dropdown-wrapper form-control bg-disabled">
                                            <div @click="isVisible = !isVisible" class="selected-item">
                                                <span v-if="datos.categoria==''">Seleccione Categoria</span>
                                                <span v-else>{{datos.categoria }}</span>
                                                <svg :class="isVisible  ? 'dropdown' : ''" class="drop-down-icon"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                    height="24">
                                                    <path fill="none" d="M0 0h24v24H0z" />
                                                    <path
                                                        d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z" />
                                                    </svg>
                                            </div>
                                            <div :class="isVisible   ? 'visible' : 'invisible'"
                                                class="dropdown-popover">
                                                <input type="text" class="form-control" placeholder="Buscar Categoria.."
                                                    v-model="buscarPaciente" aria-label="Buscar Paciente..">
                                                <div class="text-center"><span v-if="filteredCategoria.length === 0">No
                                                        existen Categoria</span></div>
                                                <div class="options">
                                                    <ul>
                                                        <li @click="selectedPaciente(categoria)"
                                                            v-for="(categoria, index) in filteredCategoria"
                                                            :key="`cliente-${index}`">{{categoria.nombre}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Unidad Medida</label>
                                    <select class="form-select" v-model="datos.id_unidad">
                                        <option value="0" disabled>Seleccione la Medida</option>
                                        <option v-for="unidad in arrayUnidad" :key="unidad.id" :value="unidad.id"
                                            v-text="unidad.nombre"></option>
                                    </select>
                                </div>
                                <!-- <template v-if="datos.id_tipo_producto == 5">
                                        <div class="col-md-6">
                                            <label for="exampleInputPassword1" class="form-label">Contenido Presentacion</label>
                                            <input type="number" class="form-control" v-model="datos.contenido_presentacion" min="0" disabled >
                                        </div>
                                    </template >
                                    <template v-else>
                                        <div class="col-md-6">
                                            <label for="exampleInputPassword1" class="form-label">Contenido Presentacion</label>
                                            <input type="number" class="form-control" v-model="datos.contenido_presentacion" min="0" >
                                        </div>
                                    </template> -->
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Codigo Ean</label>
                                    <input type="text" class="form-control" v-model="datos.cod_ean" min="0"
                                        onkeydown="if(event.key==='.'){event.preventDefault();}"
                                        oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');"
                                        v-on:focus="seleccionarContenido">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Tipo de Producto</label>
                                    <select class="form-select" v-model="datos.id_tipo_producto">
                                        <option value="0" disabled>Seleccione el Tipo de Producto</option>
                                        <option v-for="impresion in arrayTipoProducto" :key="impresion.id"
                                            :value="impresion.id" v-text="impresion.nombre"></option>
                                    </select>
                                </div>
                                <template v-if="datos.id_tipo_producto==4">
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Producto Compuesto</label>
                                        <select class="form-select" v-model="datos.id_producto_compuesto">
                                            <option value="0" disabled>Seleccione el Producto Compuesto</option>
                                            <option v-for="producto_compuesto in arrayProductoCompuesto"
                                                :key="producto_compuesto.id" :value="producto_compuesto.id"
                                                v-text="producto_compuesto.nombre"></option>
                                        </select>
                                        <!-- <div class="row" v-if="errores.id_categoria">
                                                <div class="col-sm-10"><span class="text-danger">{{errores.id_unidad[0]}}</span></div>
                                            </div> -->
                                    </div>
                                </template>
                                <template v-if="datos.id_tipo_producto!=2 && datos.id_tipo_producto !=5">
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Costo Compra</label>
                                        <input type="text" class="form-control" v-model="datos.costo_compra" min="0"
                                            oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                            v-on:focus="seleccionarContenido">
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Costo Compra</label>
                                        <input type="text" class="form-control" v-model="datos.costo_compra" min="0"
                                            oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                            v-on:focus="seleccionarContenido" disabled>
                                    </div>
                                </template>
                                <!-- <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Unidad Medida</label>
                                        <select class="form-select" v-model="datos.id_unidad">
                                            <option value="0" disabled>Seleccione la Unidad Medida</option>
                                            <option v-for="unidad in arrayUnidad" :key="unidad.id" :value="unidad.id" v-text="unidad.nombre"tienda></option>
                                        </select>
                                    </div> -->
                                <!-- <template v-if="datos.id_tipo_producto!=1">
                                    <div class="col-md-6">
                                            <label for="exampleInputPassword1" class="form-label">Impresion</label>
                                            <select class="form-select col-md-3" v-model="datos.impresion">
                                                <option value="0" disabled>Seleccione la Impresion</option>
                                                <option value="Bar">Bar</option>
                                                <option value="Cocina">Cocina</option>                                     
                                            </select>
                                    </div>
                                    </template> -->

                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Precio Venta</label>
                                    <!--<input type="text" class="form-control" v-model="datos.costo_venta" min="0"
                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                        v-on:focus="seleccionarContenido"
                                        :disabled="(datos.id_tipo_producto !=5)?false:true">-->

                                    <input type="text" class="form-control" v-model="datos.costo_venta" min="0"
                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                        v-on:focus="seleccionarContenido"
                                        >
                                </div>

                                <template
                                    v-if="tipoAccion == 1 && datos.id_tipo_producto !=5 && datos.id_tipo_producto !=2">
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Stock</label>
                                        <input type="text" class="form-control" v-model="datos.stock" min="0"
                                            oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                            v-on:focus="seleccionarContenido">
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Stock</label>
                                        <input type="text" class="form-control" v-model="datos.stock" min="0"
                                            oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                            v-on:focus="seleccionarContenido" disabled>
                                    </div>
                                </template>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Stock Minimo</label>
                                    <input type="text" class="form-control" v-model="datos.stock_minimo" min="0"
                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                        v-on:focus="seleccionarContenido"
                                        :disabled="(datos.id_tipo_producto !=5 && datos.id_tipo_producto!=2)?false:true">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Observacion</label>
                                    <input type="text" class="form-control" v-model="datos.descripcion">
                                </div>
                                <!-- <template v-if="usuario.id_tienda == 100">
                                        <div class="col-md-6">
                                            <label for="exampleInputPassword1" class="form-label">Tienda</label>
                                            <select class="form-select" v-model="datos.id_tienda">
                                                <option value="0" disabled>Seleccione la Tienda</option>
                                                <option v-for="tienda in arrayTienda" :key="tienda.id" :value="tienda.id" v-text="tienda.nombre"></option>
                                            </select>
                                        </div>
                                    </template> -->
                                <div class="col-md-6">
                                    <div>
                                        <label for="imagen" class="col-md-2 form-control-label">Foto</label>
                                    </div>
                                    <div class="p-0 m-2">
                                        <input type="file" @change="obtenerImagen" class="form-control">
                                        <center>&nbsp;
                                            <!-- <figure><img width="100" height="100" :src="imagenMiniatura" onerror="this.src='img/producto/defecto.png'" alt=""></figure> -->
                                            <figure>
                                                <!-- <img width="100" height="100" :src="imagenMiniatura" onerror="this.src='../public_html/img/producto/defecto.png'" alt=""> -->
                                                <img width="100" height="100" :src="imagenMiniatura"
                                                    onerror="this.src='../img/producto/defecto.png'"
                                                    class="border border-1 border-dark" alt="">
                                            </figure>
                                        </center>
                                    </div>
                                </div>

                                <!-- <div class="col-md-6">
                                        <label for="inputPassword" class="form-label">Estado</label>
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
                                    </div> -->
                            </form>
                            <div class="header-divider"></div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-danger me-md-2 text-white" type="button"
                                    @click="ocultarListado1()">Cancelar</button>
                                <button :disabled="guardando" class="btn btn-info btn-lg text-white"
                                    v-if="tipoAccion==1" type="button" @click="guardar()">Guardar Producto</button>
                                <button :disabled="modificando" class="btn btn-info btn-lg text-white"
                                    v-if="tipoAccion==2" type="button" @click="modificarArticulo()">Modificar
                                    Producto</button>
                            </div>
                        </div>

                    </template>
                </div>
            </div>
        </div>
        <!-- </div> -->

        <!--Modal Formulario Categoria-->
        <div class="modal fade" id="frmCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white">
                        <h4 class="modal-title ">Registro Categoría</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row" :class="errores.nombre ? 'mb-1' : 'mb-3'">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
                                <div><input type="text" class="form-control" v-model="datosCategoria.nombre"></div>
                            </div>
                            <div class="row mb-2" v-if="errores.nombre">
                                <div class="col-sm-2">&nbsp;</div>
                                <div class="col-sm-10"><span class="text-danger">{{errores.nombre[0]}}</span></div>
                            </div>
                            <div class="mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Descripción</label>
                                <textarea class="form-control" id="message-text"
                                    v-model="datosCategoria.descripcion"></textarea>
                                <!-- <div class="col-sm-10"><input type="text" class="form-control" v-model="datosCategoria.descripcion"></div> -->
                            </div>
                            <div class="row pb-3">
                                <label for="imagen" class="col-md-2 form-control-label">Foto</label>
                                &nbsp;
                                <div class="col-md-12">
                                    <input type="file" @change="obtenerImagen2" class="form-control" id="imagen"
                                        :key="fileInputKey">

                                </div>
                            </div>

                            <center>
                                <figure><img width="100" height="100" :src="imagenMiniatura"
                                        onerror="this.src='img/producto/defecto.png'"
                                        class="border border-1 border-dark" alt=""></figure>
                            </center>
                            <!-- <div v-show="errorProducto" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cerrar</button>
                        <button :disabled="guardando_categoria" type="button" class="btn btn-info text-white"
                            @click="guardarCategoria() ">Guardar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin modal Formulario Categoria-->
        <!--Modal Formulario Unidad Medida-->
        <div class="modal fade" id="frmUnidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white">
                        <h4 class="modal-title ">Registro Unidad Medida</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row" :class="errores.nombre ? 'mb-1' : 'mb-3'">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
                                <div><input type="text" class="form-control" v-model="datosUnidad.nombre"></div>
                            </div>
                            <div class="row mb-2" v-if="errores.nombre">
                                <div class="col-sm-2">&nbsp;</div>
                                <div class="col-sm-10"><span class="text-danger">{{errores.nombre[0]}}</span></div>
                            </div>
                            <div class="mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Abreviatura</label>
                                <div><input type="text" class="form-control" v-model="datosUnidad.abreviatura"></div>
                                <!-- <div class="col-sm-10"><input type="text" class="form-control" v-model="datosCategoria.descripcion"></div> -->
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-info text-white" @click="guardarUnidad() ">Guardar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin modal Formulario Unidad Medida-->
    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    import moment from 'moment';
    export default {
        create() {
            this.usuarioAuth();


            // this.selectTienda();
        },
        data() {
            return {
                datos: {
                    id: 0,
                    nombre: '',
                    cod_ean: 0,
                    costo_compra: 0,
                    costo_venta: 0,
                    descripcion: '',
                    estado: '1',
                    id_categoria: 0,
                    id_tipo_producto: 0,
                    id_tienda: 1,
                    id_unidad: 0,
                    id_proveedor: 0,
                    id_producto_compuesto: 0,
                    accion: '1',
                    foto: '',
                    imagenActual: '',
                    categoria: '',
                    impresion: '0',
                    stock_minimo: 0,
                    stock: 0,
                    contenido_presentacion: '1',
                },
                datosCategoria: {
                    id: 0,
                    nombre: '',
                    estado: '1',
                    descripcion: '',
                    foto: '',
                    imagenActual: '',
                },
                datosUnidad: {
                    id: 0,
                    nombre: '',
                    estado: '1',
                    abreviatura: '',
                },
                imagenMiniatura: '',
                categoria_registro: 0,
                personal_registro: 0,
                producto_registro: 0,
                arrayArticulo: [],
                arrayArticulo2: [],
                errores: {},
                fileInputKey: '',
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorArticulo: 0,
                errorMostrarMsjArticulo: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'articulo.nombre',
                buscar: '',
                arrayTipoCategoria: [],
                arrayUnidad: [],
                arrayProductoCompuesto: [],
                arrayTienda: [],
                arrayTipoProducto: [],
                arrayProveedor: [],
                listado: 0,
                setTimeoutBuscador: '',
                buscarPaciente: '',
                isVisible: false,
                validar_tipo: false,
                generar: false,
                listadoMenu: 0,
                unidad_registro: 0,
                is_busy: 0,
                tienda: 1,
                usuario: {},
                guardando_categoria: false,
                guardando: false,
                modificando: false,
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
            filteredCategoria() {
                const data = this.buscarPaciente.toLowerCase();
                if (this.buscarPaciente == "") {
                    return this.arrayTipoCategoria;
                }
                return this.arrayTipoCategoria.filter((item) => {
                    return Object.values(item).some((word => String(word).toLowerCase().includes(data)))
                })
            }
        },
        methods: {
            seleccionarContenido(evento) {
                evento.target.select();
            },
            isMobileDevice() {
                return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
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
            volverMenu() {
                this.$emit('cerrarMenu', this.listadoMenu);
            },
            obtenerImagen(e) {
                var fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = e => {
                    this.datos.foto = e.target.result;
                    this.imagenMiniatura = this.datos.foto;
                };
            },
            obtenerImagen2(e) {
                var fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = e => {
                    this.datosCategoria.foto = e.target.result;
                    this.imagenMiniatura = this.datosCategoria.foto;
                };
            },
            selectedPaciente(categoria) {
                this.datos.categoria = '';
                this.datos.id_categoria = 0;
                this.isVisible = false;
                this.datos.categoria = categoria.nombre;
                this.datos.id_categoria = categoria.id;
            },
            // cambiarVenta()
            // {
            //     if(this.datos.impresion == '0')
            //     {
            //         this.listarArticulo(1, '', 'producto.nombre'); 
            //     }
            //     else
            //     {
            //         this.listarArticulo2(1, '', 'producto.nombre'); 
            //     }
            // },
            listarArticulo(page, buscar, criterio) {
                let me = this;
                me.buscarPaciente = '';
                me.isVisible = false;
                me.id_tienda = 1;
                if (me.usuario.id_tienda == 100) {
                    var url = '/articulo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                    axios.get(url).then(function (response) {
                            me.arrayArticulo = response.data.data;
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
                } else {
                    var url = '/articulo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&id_tienda=' +
                        me.usuario.id_tienda;
                    axios.get(url).then(function (response) {
                            me.arrayArticulo = response.data.data;
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
                }

            },
            listarArticulo2(page, buscar, criterio) {
                let me = this;
                var url = '/articuloComida?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                        me.arrayArticulo = response.data.data;
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
            listarArticuloBusquedaRapida() {
                let me = this;
                if (me.usuario.id_tienda == 100) {
                    var url = '/articulo?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio +
                        '&id_tienda=' + me.tienda;
                    axios.get(url).then(function (response) {
                            me.arrayArticulo = response.data.data;
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
                } else {
                    var url = '/articulo?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio +
                        '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function (response) {
                            me.arrayArticulo = response.data.data;
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
                }
            },
            listarArticuloBusquedaRapida2() {
                let me = this;
                var url = '/articuloFarmacia?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio;
                axios.get(url).then(function (response) {
                        me.arrayArticulo = response.data.data;
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
            BuscandoArticulo() {
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida, 350)
            },
            BuscandoArticulo2() {
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida2, 350)
            },
            btnNuevoArticulo() {
                this.selectCategoria();
                this.selectTipoProducto();
                // this.selectProveedor();
                this.selectTipoProductoCompuesto();
                this.selectUnidad();
                let me = this;
                me.listado = 1;
                this.is_busy = 0;
                this.tipoAccion = 1;
                this.imagenMiniatura = '';
                this.datos.imagenActual = '';
                this.fileInputKey++;
                me.datos = {
                    id: 0,
                    nombre: '',
                    cod_ean: 0,
                    costo_compra: 0,
                    costo_venta: 0,
                    descripcion: '',
                    estado: '1',
                    id_categoria: 0,
                    id_tipo_producto: 0,
                    id_unidad: 0,
                    // id_proveedor : 0,
                    id_producto_compuesto: 0,
                    accion: '1',
                    foto: '',
                    imagenActual: '',
                    categoria: '',
                    impresion: '0',
                    stock_minimo: 0,
                    id_tienda: 1,
                    stock: 0,
                    contenido_presentacion: '1',

                };
            },
            guardar() {

                if (this.datos.nombre == '') {
                    this.validacionError('El nombre no puede estar vacio', 3000);
                } else {
                    if (this.datos.id_categoria == 0) {
                        this.validacionError('Seleccione una Categoria', 3000);
                    } else {
                        if (this.datos.id_tipo_producto == 0) {
                            this.validacionError('Seleccione el Tipo Producto', 3000);
                        } else {
                            this.guardarArticulo();
                        }
                    }

                }
            },
            async guardarArticulo() {
                //console.log("hola");
                let me = this;
                me.guardando = true;
                try {
                    // if(me.datos.impresion =="0"){
                    //     me.validar_tipo = true;
                    // }

                    // else{

                    let data = {
                        id: me.datos.id,
                        nombre: me.datos.nombre,
                        cod_ean: me.datos.cod_ean,
                        costo_compra: me.datos.costo_compra,
                        costo_venta: me.datos.costo_venta,
                        descripcion: me.datos.descripcion,
                        estado: me.datos.estado,
                        foto: me.datos.foto,
                        contenido_presentacion: me.datos.contenido_presentacion,
                        stock_minimo: me.datos.stock_minimo,
                        stock: me.datos.stock,
                        cod_ean: me.datos.cod_ean,
                        id_proveedor: me.datos.id_proveedor,
                        //impresion : me.datos.impresion,
                        id_tienda: me.datos.id_tienda,
                        id_categoria: me.datos.id_categoria > 0 ? me.datos.id_categoria : "",
                        // id_tienda : me.datos.id_tienda >0 ? me.datos.id_tienda : "",
                        id_tipo_producto: me.datos.id_tipo_producto > 0 ? me.datos.id_tipo_producto : "",
                        id_unidad: me.datos.id_unidad > 0 ? me.datos.id_unidad : "",
                        id_producto_compuesto: me.datos.id_producto_compuesto > 0 ? me.datos
                            .id_producto_compuesto : "",
                        impresion: me.datos.impresion != '0' ? me.datos.impresion : "",
                    }
                    const res = await axios.post('/articulo/guardar', data);
                    if (res.data.error == 0) {
                        me.guardando = false;
                        me.validacionError("El producto ya existe", 2000);
                    } else {
                        me.guardando = false;
                        me.listado = 0;
                        me.registrosArticulo();
                        me.listarArticulo(1, '', 'producto.nombre');
                        me.errores = {};
                        me.datos = {
                                id: 0,
                                nombre: '',
                                cod_ean: '',
                                costo_compra: 0,
                                precio_venta: 0,
                                descripcion: '',
                                estado: '1',
                                id_categoria: 0,
                                id_tipo_producto: 0,
                                id_unidad: 0,
                                id_tienda: 1,
                                id_proveedor: 0,
                                accion: '1',
                                foto: '',
                                imagenActual: '',
                                categoria: '',
                                unidad: '',
                                tipo: '',
                                impresion: '0',
                            },
                            me.registrosArticulo();
                        me.registrosArticuloProducto()
                        me.arrayArticulo = [];
                        //me.arrayArticulo2 = [];
                        me.arrayTipoCategoria = [];

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Registro agregado...',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                    //}  


                } catch (error) {
                    if (error.response.data) {
                        me.guardando = false;
                        this.errores = error.response.data.errors;
                        this.is_busy = 0;
                    }

                }

            },
            async modificarArticulo() {
                let me = this;
                me.modificando = true;
                try {
                    const res = await axios.put('/articulo/modificar', me.datos);
                    if (res.data.error == 0) {
                        me.modificando = false;
                        me.validacionError('Debe usar otra nombre! o Agregar nueva Categoría', 2000);

                    } else {
                        if (res.data.error == 1) {
                            me.modificando = false;
                            me.validacionError('El nombre no puede estar vacio', 2000);
                        } else {
                            me.modificando = false;
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Registro modificado...',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            me.listado = 0;
                            me.registrosArticulo();
                            me.listarArticulo(1, '', 'producto.nombre');
                            me.errores = {};
                            me.datos = {
                                id: 0,
                                nombre: '',
                                cod_ean: '',
                                costo_compra: 0,
                                precio_venta: 0,
                                descripcion: '',
                                estado: '1',
                                id_categoria: 0,
                                id_tienda: 0,
                                id_tipo_producto: 0,
                                id_unidad: 0,
                                accion: '1',
                                foto: '',
                                imagenActual: '',
                                categoria: '',
                                unidad: '',
                                tipo: '',
                                impresion: '0',
                            }
                        }
                    }
                } catch (error) {
                    if (error.response.data) {
                        me.modificando = false;
                        this.errores = error.response.data.errors;
                    }
                }
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
            registrosCategoria() {
                let me = this;
                var url = '/categoria/cantidad';
                axios.get(url).then(function (response) {
                        me.categoria_registro = response.data.nro;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            registrosArticulo() {
                let me = this;
                var url = '/articulo/cantidad';
                axios.get(url).then(function (response) {
                        me.personal_registro = response.data.nro;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            registrosArticuloProducto() {
                let me = this;
                var url = '/articulo/cantidad';
                axios.get(url).then(function (response) {
                        me.producto_registro = response.data.nro;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            selectCategoria() {
                let me = this;
                var url = '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                        me.arrayTipoCategoria = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            selectTipoProducto() {
                let me = this;
                var url = '/selectTipoProducto';
                axios.get(url).then(function (response) {
                        me.arrayTipoProducto = response.data;
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
            selectTipoProductoCompuesto() {
                let me = this;
                var url = '/selectTipoProductoCompuesto';
                axios.get(url).then(function (response) {
                        me.arrayProductoCompuesto = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            selectUnidad() {
                let me = this;
                var url = '/unidad/selectUnidad';
                axios.get(url).then(function (response) {
                        me.arrayUnidad = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            selectProveedor() {
                let me = this;
                var url = '/proveedor/selectProveedor';
                axios.get(url).then(function (response) {
                        me.arrayProveedor = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            editarArticulo(data = []) {
                this.selectTipoProducto();
                this.selectTipoProductoCompuesto();
                this.selectCategoria();
                this.selectProveedor();
                this.selectTienda();
                this.selectUnidad();
                let me = this;
                me.listado = 1;
                this.tipoAccion = 2;
                this.datos.id = data['id'];
                this.datos.cod_ean = data['cod_ean'];
                this.datos.nombre = data['nombre'];
                this.datos.costo_compra = data['costo_compra'];
                this.datos.costo_venta = data['costo_venta'];
                this.datos.descripcion = data['observacion'];
                this.datos.estado = data['estado'];
                this.datos.id_categoria = data['id_categoria'];
                this.datos.id_tienda = data['id_tienda'];
                this.datos.categoria = data['categoria'];
                this.datos.id_unidad = data['id_unidad'];
                this.datos.id_proveedor = data['id_proveedor'];
                this.datos.unidad = data['unidad'];
                this.datos.id_tipo_producto = data['id_tipo_producto'];
                this.datos.tipo = data['tipo'];
                this.datos.id_producto_compuesto = data['id_producto_compuesto'];
                this.datos.foto = data['foto'];
                this.datos.impresion = data['impresion'];
                this.datos.contenido_presentacion = data['contenido_presentacion'];
                this.datos.stock_minimo = data['stock_minimo'];
                this.datos.cod_ean = data['cod_ean'];
                this.datos.stock = (parseFloat(data['stock_actual'])).toFixed(2);
                this.datos.imagenActual = data['foto'];
                this.imagenMiniatura = '../img/producto/' + this.datos.foto;
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarArticulo(page, buscar, criterio);
            },
            ocultarListado1() {
                this.listado = 0;
                this.errores = {};
            },

            async guardarCategoria() {
                let me = this;
                me.guardando_categoria = true;
                try {
                    const res = await axios.post('/categoria/guardar', this.datosCategoria);
                    if (res.data.error == 0) {
                        me.guardando_categoria = false;
                        me.validacionError('La categoria ya existe', 2000);
                    } else {
                        if (res.data.error == 1) {
                            me.guardando_categoria = false;
                            me.validacionError('El nombre no puede estar vacio', 2000);
                        } else {
                            me.guardando_categoria = false;
                            me.imagenMiniatura = '';
                            me.datosCategoria.imagenActual = '';
                            me.registrosCategoria();
                            me.limpiarDatosCategoria();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Registro agregado...',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }

                } catch (error) {
                    if (error.response.data) {
                        me.guardando_categoria = false;
                        this.errores = error.response.data.errors;
                    }
                }
            },
            async guardarUnidad() {
                try {
                    let me = this;
                    const res = await axios.post('/unidad/guardar', this.datosUnidad);
                    if (res.data.error == 0) {
                        //me.$toaster.error('Matricula ya existe...');
                        Swal.fire({
                            icon: 'error',
                            title: 'Nombre ya existe...',
                            text: 'Debe usar otra nombre!'
                        })
                    } else {
                        me.registrosUnidad();
                        me.limpiarDatosUnidad();
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
                    }
                }
            },
            registrosUnidad() {
                let me = this;
                var url = '/unidad/cantidad';
                axios.get(url).then(function (response) {
                        me.unidad_registro = response.data.nro;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            limpiarDatosUnidad() {
                this.fileInputKey++;
                this.datosUnidad = {
                    id: 0,
                    nombre: '',
                    abreviatura: '',
                    estado: '1',
                }
                this.errores = {}
            },
            // guardarCategoria(){
            //     let me = this;
            //     axios.post('/categoria/guardar',this.datosCategoria).then(function(response){
            //         Swal.fire({
            //             position: 'top-end',
            //             icon: 'success',
            //             title: 'Registro agregado...',
            //             showConfirmButton: false,
            //             timer: 1500
            //         }) 
            //         me.imagenMiniatura = '';
            //         me.datosCategoria.imagenActual = '';  
            //         me.registrosCategoria();  
            //         me.limpiarDatosCategoria();   
            //     })
            //     .catch(function(error){
            //         console.log(error);
            //     });
            //     this.selectCategoria();
            // },
            limpiarDatosCategoria() {
                this.fileInputKey++;
                this.datosCategoria = {
                    id: 0,
                    nombre: '',
                    descripcion: '',
                    estado: '1',
                    foto: '',
                }
                this.errores = {}
            },
            validarArticulo() {
                this.errorArticulo = 0;
                this.errorMostrarMsjArticulo = [];

                if (!this.datos.nombre) this.errorMostrarMsjArticulo.push(
                "El nombre del Cliente no puede estar vacio ");
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
                return this.errorArticulo;
            },
            desactivarArticulo(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Inhabilitar este Articulo??',
                    text: "Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Inhabilitar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put('/articulo/desactivar', {
                            'id': id
                        }).then(function (response) {
                            me.listarArticulo(1, '', 'nombre');
                            swalWithBootstrapButtons.fire(
                                'Inhabilitado!',
                                'Este articulo se ha Inhabilitado.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'Este cargo no ha tenido cambios :)',
                            'error'
                        )
                    }
                })
            },
            activarArticulo(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Habilitar este Articulo??',
                    text: "Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Habilitar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put('/articulo/activar', {
                            'id': id
                        }).then(function (response) {
                            me.listarArticulo(1, '', 'nombre');
                            swalWithBootstrapButtons.fire(
                                'Habilitado!',
                                'Este articulo se ha Habilitado.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'Este articulo no ha tenido cambios :)',
                            'error'
                        )
                    }
                })
            }
        },
        mounted() {
            this.usuarioAuth();
            this.registrosCategoria();
            this.registrosArticulo();
            this.registrosUnidad();
            this.registrosArticuloProducto();
            this.selectTienda();
            this.selectProveedor();
            //this.listarArticulo(1, "", "");
            setTimeout(() => {
                this.listarArticulo(1, "", "");
            }, 1000)

            //this.listarArticulo(1, this.buscar, this.criterio);
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

</style>
