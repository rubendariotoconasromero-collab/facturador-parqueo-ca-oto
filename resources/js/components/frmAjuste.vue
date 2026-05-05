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
                                <h5 class="mb-0 col-md-11">AJUSTE</h5>
                                <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                            </div>
                        </div>
                    <!-- prueba card -->
                    <div class="row mt-2" style='width:90%;margin-left: 1.3%'>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card mb-4" style="--cui-card-cap-bg: #3399FF">
                                <div class="card-header position-relative d-flex justify-content-center align-items-center text-white">
                                <strong style='font-size: 0.8rem'> AJUSTE </strong>
                                </div>
                                <div class="card-body row text-center">
                                    <div class="col">
                                        <div class="avatar avatar-md"><img class="avatar-img" src="img/sit_norte/cliente.png"></div>
                                    </div>
                                    <div class="vr"></div>
                                    <div class="col">
                                        <div class="fs-5 fw-semibold" style='font-size: 0.8rem'>{{categoria_registro}}</div>
                                        <div class="text-uppercase text-medium-emphasis small ">Registros</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- prueba fin card -->

                        <div class="card-header">
                            <button type="button" @click="btnNuevoAjuste()" class="btn btn-info text-white" style='margin-left: 1%;font-size: 0.8rem'>
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8">
                                &nbsp;&nbsp;<div class="input-group" style='width:96%;margin-left: 3.3%;font-size: 0.8rem'>
                                    <div class="col-md-4">
                                        <select class="form-select col-md-3" v-model="criterio" style='font-size: 0.8rem'>
                                            <option value="categoria.nombre">Categoria</option>
                                            <option value="articulo.nombre">Producto</option>
                                            <!--<option value="articulo.marca">Marca</option>-->
                                            <option value="motivo_ajuste.nombre">Motivo Ajuste</option>
                                        </select>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="text" v-model="buscar" @keyup="BuscandoAjuste()" class="form-control" placeholder="Texto a buscar" style='font-size: 0.8rem'>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit" @click="listarAjuste(1, buscar, criterio)" class="btn btn-info text-white" style='font-size: 0.8rem'><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style='width:96%;margin-left: 2.2%;font-size: 0.8rem'>
                                <thead style="background-color: #46546C">
                                    <tr>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Categoria</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Producto</th>
                                        <!-- <th scope="col" class="text-white" style='font-size: 0.8rem'>Marca</th> -->
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Motivo Ajuste</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Cantidad</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Stock Anterior</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Stock Actual</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Costo Compra</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Precio Venta</th>
                                        <!-- <th scope="col" class="text-white">P. Mayorista</th>
                                        <th scope="col" class="text-white">P. Preferencial</th> -->
                                        <!-- <th scope="col" class="text-white">Precio Venta</th> -->
                                    </tr>
                                </thead>
                                <tbody v-if="arrayAjuste.length">
                                    <tr v-for="ajuste in arrayAjuste" :key="ajuste.id">
                                        <td v-text="ajuste.categoria" style='font-size: 0.8rem'></td>
                                        <td v-text="ajuste.articulo" style='font-size: 0.8rem'></td>
                                        <!-- <td v-text="ajuste.marca"></td> -->
                                        <td v-text="ajuste.motivo_ajuste" style='font-size: 0.8rem'></td>
                                        <td v-text="ajuste.id_motivo_ajuste!=4 ? (ajuste.id_motivo_ajuste!=5 ? (parseFloat(ajuste.stock)).toFixed(2) : '-') : '-'" style='font-size: 0.8rem'></td>
                                        <td v-text="ajuste.id_motivo_ajuste!=4 ? (ajuste.id_motivo_ajuste!=5 ? (parseFloat(ajuste.stock_anterior)).toFixed(2) : '-') : '-'" style='font-size: 0.8rem'></td>
                                        <td v-text="ajuste.id_motivo_ajuste!=4 ? (ajuste.id_motivo_ajuste!=5 ? (parseFloat(ajuste.stock_actual)).toFixed(2) : '-') : '-'" style='font-size: 0.8rem'></td>
                                        <td v-text="ajuste.id_motivo_ajuste==4 || ajuste.id_motivo_ajuste==6 ? ajuste.costo_compra :'-'" style='font-size: 0.8rem'></td>
                                        <td v-text="ajuste.id_motivo_ajuste==5 ? ajuste.costo_venta:'-'" style='font-size: 0.8rem'></td>  
                                        <!-- <td v-text="ajuste.id_motivo_ajuste==5 ? ajuste.costo_unitario:'-'"></td>   -->
                                        <!-- <td v-text="ajuste.id_motivo_ajuste==5 ? ajuste.costo_mayorista:'-'"></td>   
                                        <td v-text="ajuste.id_motivo_ajuste==5 ? ajuste.costo_preferencial:'-'"></td>    -->
                                        <!-- <td v-text="ajuste.id_motivo_ajuste==7 || ajuste.id_motivo_ajuste==8 || ajuste.id_motivo_ajuste==9 ? ajuste.costo_venta:'-'"></td>                                     -->
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="12">No hay Ajustes agregados</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Card Pagination -->
                        <div class="card-footer py-4">
                            <nav>
                                <ul class="pagination justify-content-end mb-0">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' :'']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page">1</a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </template>

                    <template v-if="listado==1">
                        <div class="card-body">
                            <!-- <div class="card-header text-center"> -->
                                <!--<div class="card-header text-center">
                                    <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 col-md-11">DATOS AJUSTES</h5>
                                        <button type="button" class="btn-close btn-close" @click="ocultarListado1()" aria-label="Close"></button>
                                    </div>
                                </div>-->
                                <div class="card-header text-center text-white" style="background-color: #3399FF">
                                    <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 col-md-11">DATOS AJUSTES</h5>
                                        <button style="color:white !important" type="button" class="btn-close btn-close" @click="ocultarListado1(), cancelarAjuste()" aria-label="Close"></button>
                                        <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-1">
                                        <button type="button" @click="ocultarListado1()" class="btn btn-danger text-white " >
                                            <i class="fa fa-reply-all"></i>&nbsp;Volver
                                        </button>   
                                    </div>
                                    <div class="col-md-9 text-center">
                                        <h3 class="mb-0">DATOS AJUSTES</h3>  
                                    </div>
                                </div> -->
                            <!-- </div> -->
                            <div class="card-header text-center line p-0 m-0"  style="background-color: #3399FF"></div>&nbsp;
                            <form class="row">
                                <div class="col-md-6 mb-2">
                                <label for="exampleInputPassword1" class="form-label">Motivo Ajuste</label>
                                    <select class="form-select" v-model="datos.id_motivo_ajuste"  @change="seleccionarMotivo($event)">
                                        <option value="0" disabled>Seleccione el Motivo</option>
                                        <option v-for="motivo in arrayMotivo" :key="motivo.id" :value="motivo.id" v-text="motivo.nombre"></option>
                                    </select>  
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Productos<span style="color:red;" >(*Seleccione)</span></label>
                                    <div class="input-group mb-6">
                                        <button type="button" class="btn btn-info text-white position-relative" data-bs-toggle="modal" @click="listarArticulo(buscarP)" data-bs-target="#modalArticulo" :disabled="datos.id_motivo_ajuste == 0"><i class="fa fa-search"></i> Agregar</button>
                                    </div>
                                </div>
                                <!-- <template v-if="datos.id_motivo_ajuste == 1 || datos.id_motivo_ajuste == 2 || datos.id_motivo_ajuste == 3">
                                    <div class="col-md-6 mb-2">
                                        <label for="exampleInputPassword1" class="form-label">Stock</label>
                                        <input type="number" class="form-control" v-model="datos.stock">
                                    </div>    
                                </template>  --> 
                                <!-- <template v-if="datos.id_motivo_ajuste == 4">
                                    <div class="col-md-6" :class="errores.costo_compra ? 'mb-1' : 'mb-2'">
                                        <label for="exampleInputPassword1" class="form-label">Costo Compra</label>
                                        <input type="text" class="form-control" v-model="datos.costo_compra">
                                        <div class="row mb-2" v-if="errores.costo_compra">
                                            <div class="col-sm-10"><span class="text-danger">{{errores.costo_compra[0]}}</span></div>
                                        </div>  
                                    </div>                       
                                </template> -->
                                <!-- <template v-if="datos.id_motivo_ajuste == 5">
                                    <div class="col-md-6 mb-2">
                                        <label for="exampleInputPassword1" class="form-label">Precio Unitario</label>
                                        <input type="text" class="form-control" v-model="datos.costo_unitario">
                                        <div class="row mb-2" v-if="errores.costo_unitario">
                                            <div class="col-sm-10"><span class="text-danger">{{errores.costo_unitario[0]}}</span></div>
                                        </div>  
                                    </div>
                                </template> -->
                                <!-- <template v-if="datos.id_motivo_ajuste == 5">
                                    <div class="col-md-6 mb-2">
                                        <label for="exampleInputPassword1" class="form-label">Precio Mayorista</label>
                                        <input type="text" class="form-control" v-model="datos.costo_mayorista">
                                        <div class="row mb-2" v-if="errores.costo_mayorista">
                                            <div class="col-sm-10"><span class="text-danger">{{errores.costo_mayorista[0]}}</span></div>
                                        </div>  
                                    </div>
                                </template> -->
                                <!-- <template v-if="datos.id_motivo_ajuste == 5">
                                    <div class="col-md-6 mb-2">
                                        <label for="exampleInputPassword1" class="form-label">Precio Preferencial</label>
                                        <input type="text" class="form-control" v-model="datos.costo_preferencial">
                                        <div class="row mb-2" v-if="errores.costo_preferencial">
                                            <div class="col-sm-10"><span class="text-danger">{{errores.costo_preferencial[0]}}</span></div>
                                        </div>  
                                    </div>
                                </template> -->
                                <!-- <div class="col-md-12">
                                    <label for="exampleInputPassword1" class="form-label">Observacion</label>
                                    <textarea class="form-control" v-model="datos.observacion" rows="2"></textarea>
                                </div>  -->
                            </form>
                                <br>

                                    <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead style="background-color: #46546C">
                                            <tr>                      
                                                <th scope="col" class="text-white">Opción</th>
                                                <th scope="col" class="text-white">Categoria</th>
                                                <th scope="col" class="text-white">Nombre</th>
                                                <!-- <th scope="col" class="text-white">Marca</th> -->
                                                <th v-if="datos.id_motivo_ajuste == 1 || datos.id_motivo_ajuste == 2 || datos.id_motivo_ajuste == 3" scope="col" class="text-white">Stock</th>
                                                <th v-if="datos.id_motivo_ajuste == 4" scope="col" class="text-white">Precio de Compra</th>
                                                <th v-if="datos.id_motivo_ajuste == 5" scope="col" class="text-white">Precio de Venta</th>
                                                <!-- <th v-if="datos.id_motivo_ajuste == 5" scope="col" class="text-white">Precio Mayorista</th>
                                                <th v-if="datos.id_motivo_ajuste == 5" scope="col" class="text-white">Precio Preferencial</th> -->
                                                <th scope="col" class="text-white">Observación</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                                <td>
                                                    <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white"></i></button>
                                                </td>
                                                <td v-text="detalle.categoria"></td>
                                                <td v-text="detalle.articulo"></td>
                                                <!-- <td v-text="detalle.marca"></td> -->
                                                <td v-if="datos.id_motivo_ajuste == 1 || datos.id_motivo_ajuste == 2 || datos.id_motivo_ajuste == 3">
                                                    <!-- <vue-numeric v-model="detalle.stock" type="number" value="3" class="form-control"></vue-numeric> -->
                                                    <input v-model="detalle.stock" type="text" value="3" class="form-control"
                                                    oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                    v-on:focus="seleccionarContenido">
                                                </td>
                                                <td v-if="datos.id_motivo_ajuste == 4">
                                                    <!-- <vue-numeric v-model="detalle.costo_compra" type="number" value="3" class="form-control"></vue-numeric> -->
                                                    <input v-model="detalle.costo_compra" type="number" value="3" class="form-control">
                                                </td>
                                                <td v-if="datos.id_motivo_ajuste == 5">
                                                    <input v-model="detalle.costo_venta" type="number" value="3" class="form-control">
                                                    <!-- <vue-numeric v-model="detalle.costo_unitario" type="number" value="3" class="form-control"></vue-numeric> -->
                                                </td>  
                                                <!-- <td v-if="datos.id_motivo_ajuste == 5">
                                                    <vue-numeric v-model="detalle.costo_mayorista" type="number" value="3" class="form-control"></vue-numeric>
                                                </td>  
                                                <td v-if="datos.id_motivo_ajuste == 5">
                                                    <vue-numeric v-model="detalle.costo_preferencial" type="number" value="3" class="form-control"></vue-numeric>
                                                </td>   -->
                                                <td>
                                                    <input v-model="detalle.observacion" type="text"  id="Preferencial" class="form-control">
                                                </td>                                                               
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="8">No hay Productos agregados</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                            <div class="header-divider"></div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-danger me-md-2 text-white" type="button" @click="cancelarAjuste()">Cancelar</button>
                                <button class="btn btn-info btn-lg text-white" v-if="tipoAccion==1"  type="button" @click="guardarAjuste()">Guardar Ajuste</button>
                                <button class="btn btn-info btn-lg text-white" v-if="tipoAccion==2"  type="button" @click="modificarArticulo()">Modificar Articulo</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <!-- </div> -->

        <!--Modal Formulario Producto-->
        <div class="modal fade" id="modalArticulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white" style="height:45px;">
                        <h5 class="modal-title ">Busqueda de Productos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <!--<template v-if="usuario.id_tienda == 100">-->
                                        <select class="form-select" v-model="tienda" @change="listarArticulo(buscarP)">
                                        <!-- <option value="1" disabled>Seleccione la Tienda</option> -->
                                        <option v-for="tienda in arrayTienda" :key="tienda.id" :value="tienda.id" v-text="tienda.nombre"></option>
                                        </select>
                                    <!--</template>-->
                                    &nbsp;
                                    <input type="text" v-model="buscarP" @keyup.enter="listarArticulo(buscarP)" @keyup="BuscandoProducto()" class="form-control" placeholder="Texto a buscar">
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit" @click="listarArticulo(buscarP)" class="btn btn-info text-white"><i class="fa fa-search"></i> Buscar</button>
                                </div>  
                            </div>                   
                        </div>&nbsp;
                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead style="background-color: #46546C">
                                <tr>
                                    <!-- <th scope="col" class="text-white">Categoria</th>                     -->
                                    <th scope="col" class="text-white">Nombre</th>
     
                                    <th scope="col" class="text-white">Costo Compra</th>
                                    <th scope="col" class="text-white">Precio Venta</th>
                                    <th scope="col" class="text-white">Stock</th>
                                    <th scope="col" class="text-white">Opción</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayArticulo.length">
                                <tr v-for="(tienda_articulo, index) in arrayArticulo" :key="index">
                                    <!-- <td  v-text="tienda_articulo.categoria"></td> -->
                                    <td  v-text="tienda_articulo.articulo"></td>
                                    <td  v-text="tienda_articulo.costo_compra"></td>
                                    <td  v-text="tienda_articulo.costo_venta"></td>
                                    <td  v-text="tienda_articulo.stock"></td>
                                    <td >
                                        <button type="button"  data-dismiss="modal" @click="seleccionarArticulo(tienda_articulo,index)" class="btn btn-success btn-sm"><i class="fa fa-check text-white"></i></button> 
                                    </td>                                 
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="10">No hay Productos agregados</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin modal Formulario Producto-->
    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    export default {
        data(){
            return {
                datos : {
                    id : 0,
                    stock : 0,
                    costo_compra : 0,
                    costo_venta : 0,
                    observacion : '',
                    id_articulo : 0,
                    id_motivo_ajuste : 0,
                    producto : '',
                    saldoStock : 0,
                    
                },
                selectArticulo:{},
                categoria_registro :0,
                personal_registro :0,                                
                arrayAjuste : [],
                arrayArticulo: [],
                arrayDetalle : [],
                arrayTienda : [],
                tienda : 1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                categoria_registro :0, 
                errorArticulo : 0,
                modalCuenta:0,
                errorMostrarMsjArticulo : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'articulo.nombre',
                buscar : '',
                buscarP : '',
                arrayMotivo : [],
                listado: 0,
                setTimeoutBuscador: '',
                errores:{},
                listadoMenu: 0,
                is_busy:0,
                usuario : {},

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
            }
        },
        methods : {
            usuarioAuth(){
                let me=this;
                var url='/usuario_auth';
                axios.get(url).then(function(response){
                    me.usuario=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            seleccionarContenido(evento) {
                evento.target.select();
            },
            selectTienda(){
                let me=this;
                var url='/tienda/selectTienda';
                axios.get(url).then(function(response){
                    me.arrayTienda=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            validacionError(nombreError,tiempo){
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
                    title: '<span style="color: red; font-size: 15px">ERROR!!!</div><span style="color: black; font-size: 15px">...' + nombreError +'</span>'
                    })
            },
            volverMenu(){
                this.$emit('cerrarMenu', this.listadoMenu);
            },
            listarAjuste(page, buscar, criterio){
                let me=this;
                var url='/ajuste?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response){
                    me.arrayAjuste=response.data.data;
                    me.pagination={total:response.data.total, 
                        current_page:response.data.current_page,
                        per_page: response.data.per_page,
                        last_page: response.data.last_page,
                        from: response.data.from,
                        to: response.data.to
                    }
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            listarAjusteBusquedaRapida(){
                let me=this;
                var url='/ajuste?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio;
                axios.get(url).then(function(response){
                    me.arrayAjuste=response.data.data;
                    me.pagination={total:response.data.total, 
                        current_page:response.data.current_page,
                        per_page: response.data.per_page,
                        last_page: response.data.last_page,
                        from: response.data.from,
                        to: response.data.to
                    }
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            BuscandoAjuste(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarAjusteBusquedaRapida,350)
            },

            listarArticulo(buscarP){
                let me = this;
                //if(me.usuario.id_tienda == 100){
                    var url='/tienda/listarSinPaginateAjuste?buscar=' + buscarP  + '&id_tienda=' + me.tienda;
                    axios.get(url).then(function(response){
                        me.arrayArticulo= response.data;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                //}
                /*else
                {
                    var url='/tienda/listarSinPaginateAjuste?buscar=' + buscarP + '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function(response){
                        me.arrayArticulo= response.data;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }*/
            },
            listarArticuloBusquedaRapida(){
                let me = this;
                //if(me.usuario.id_tienda == 100){
                    var url='/tienda/listarSinPaginateAjuste?buscar=' + me.buscarP + '&id_tienda=' + me.tienda;
                    axios.get(url).then(function(response){
                        me.arrayArticulo= response.data;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                //}
                /*else
                {
                    var url='/tienda/listarSinPaginateAjuste?buscar=' + me.buscarP + '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function(response){
                        me.arrayArticulo= response.data;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }*/
            },
            BuscandoProducto(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida,350)
            },


            btnNuevoAjuste(){
                this.selectMotivo();
                let me = this;
                me.listado=1;
                me.is_busy = 0;
                this.tipoAccion = 1;
                me.datos = {
                    id : 0,
                    stock : 0,
                    costo_compra : 0,
                    costo_venta : 0,
                    observacion : '',
                    id_articulo : 0,
                    id_motivo_ajuste : 0,
                    producto : '',
                };
                me.selectArticulo={};
            },


            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id_articulo==id){
                        sw=true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index,1);
            },
            
            seleccionarArticulo(data=[],index){
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
                        id_tienda:data['id_tienda'],
                        id_articulo:data['id_articulo'],
                        categoria : data['categoria'],
                        articulo : data['articulo'],
                        marca : data['marca'],
                        costo_compra:data['costo_compra'],
                        costo_venta: 0,
                        //costo_unitario: data['costo_venta'],
                        contenido_presentacion: data['contenido_presentacion'],
                        observacion: '',
                        stock: 0,
                        // stockTotal : parseInt(stock) *data['contenido_presentacion'],
                        saldoStock:data['stock'],
                        stock_decimal : data['stock'] /data['contenido_presentacion'],

                    });
                    me.arrayArticulo.splice(index,1);
                    // Swal.fire({
                    //     position: 'top-end',
                    //     icon: 'success',
                    //     title: 'Producto agregado...',
                    //     showConfirmButton: false,
                    //     timer: 500
                    // });
                }
            },









            registrosAjuste(){
                let me=this;
                var url='/ajuste/cantidad';
                axios.get(url).then(function(response){
                    me.categoria_registro=response.data.nro;
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            guardarAjuste(){
                if(this.validarAjuste()){
                    return;
                }
                let me = this;
                    if(me.datos.id_motivo_ajuste < 3){
                        if(me.arrayDetalle.find(seg => (seg.stock <= 0))){
                            this.validacionError('Debe agregar Stock para producto!',3000);
                        } else {
                            if(me.datos.id_motivo_ajuste == 1 && me.arrayDetalle.find(seg => (seg.saldoStock > 0))){
                            Swal.fire({
                                title: 'Esta seguro de restablecer el stock?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#00C055',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, actualizar!',
                                cancelButtonText: 'No, cancelar!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        if(this.is_busy == 0){
                                            me.ajuste();
                                            this.is_busy=1;
                                        }  
                                    }
                                })
                            }else{
                                if(this.is_busy == 0){
                                    me.ajuste();
                                    this.is_busy=1;
                                }  
                            }
                        }
                    }else{
                        if(me.arrayDetalle.find(seg => ( parseFloat(seg.stock_decimal) - parseFloat(seg.stock) >= 0))) {
                           //console.log(parseFloat(seg.stock_decimal) - parseFloat(seg.stock));
                           if(this.is_busy == 0){
                                me.ajuste();
                                this.is_busy=1;
                            }  
                        }else{
                            this.validacionError('Debe agregar Stock para producto!',3000);
                        }
                    }
                
                
            },
            async ajuste(){
                try {
                    let me = this;
                    const res = await axios.post('/ajuste/guardar',{
                        'detalle': me.arrayDetalle,
                        'id_motivo_ajuste': me.datos.id_motivo_ajuste,
                    });
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro agregado...',
                        showConfirmButton: false,
                        timer: 1500
                    }) 
                    me.listado =0;
                    me.listarAjuste(1,'','articulo.nombre');
                    me.datos = {
                        id : 0,
                        stock : 0,
                        costo_compra : '',
                        costo_venta : '',
                        observacion : '',
                        id_articulo : 0,
                        id_motivo_ajuste : 0,
                        saldoStock : 0,
                    },
                    me.selectArticulo={};
                    me.arrayAjuste = [];
                    me.arrayDetalle = [];
                    me.arrayMotivo = [];
                    me.errores={};
                    me.registrosAjuste();
                } catch (error) {
                    if(error.response.data){
                        this.errores=error.response.data.errors;
                        this.is_busy=1;
                    }
                }
            },
            seleccionarMotivo(){
                    this.errores={};
                    this.datos.stock = 0;
                    this.datos.costo_compra = this.selectArticulo.costo_compra;
                    // this.datos.costo_unitario = this.selectArticulo.costo_unitario;
                    // this.datos.costo_mayorista = this.selectArticulo.costo_mayorista;
                    // this.datos.costo_preferencial = this.selectArticulo.costo_preferencial;
            },
            selectMotivo(){
                let me=this;
                var url='/motivo/selectMotivo';
                axios.get(url).then(function(response){
                    me.arrayMotivo=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarAjuste(page, buscar, criterio);
            },
            ocultarListado1(){
                this.listado=0;
                this.selectArticulo={}
                this.errores={};
            },
            cancelarAjuste(){
                this.listado=0;
                this.selectArticulo={}
                this.errores={};
                this.arrayDetalle=[];
                this.is_busy =0;
            },
            ocultarListado2(){
                this.listado=1;
            },
            abrirProducto(){
                this.modalCuenta=1;
            },
            cerrarProducto(){
                this.modalCuenta=0;
            },
                
            validarAjuste(){
                let me = this;
                if(me.arrayDetalle.length <= 0){

                    this.validacionError('Debe Seleccionar algun Producto!',3000);
                        
                }else{
                    if(me.datos.id_motivo_ajuste == 0){

                        this.validacionError('Debe Seleccionar un Motivo de Ajuste!',3000);

                    }
                }
            }           
        },
        mounted() {
            this.usuarioAuth();
            this.selectTienda();
            // setTimeout(()=> {
            //     this.listarArticulo(1, this.buscar, this.criterio);
            // },500)
            this.listarAjuste(1, this.buscar, this.criterio);
            this.registrosAjuste();

        }
    }
</script>
<style>
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
</style>
