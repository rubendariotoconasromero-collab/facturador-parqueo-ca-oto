<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <template v-if="listado==0">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 col-md-11">MESA</h6>
                                <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                            </div>
                        </div>
                        <!-- prueba card -->
                        <div class="row mt-2" style='width:90%;margin-left: 1.5%'>
                            <div class="col-sm-6 col-lg-3" >
                                <div class="card mb-4" style="--cui-card-cap-bg: #3399FF">
                                    <div class="card-header position-relative d-flex justify-content-center align-items-center text-white">
                                    <strong style='font-size: 0.7rem'> MESA </strong>
                                    </div>
                                    <div class="card-body row text-center">
                                        <div class="col">
                                            <div class="avatar avatar-md" ><img class="avatar-img" src="img/sit_norte/icons8-producto-48.png"></div>
                                        </div>
                                        <div class="col">
                                            <div class="fs-5 fw-semibold" style='font-size: 0.7rem'>{{mesa_registro}}</div>
                                            <div class="text-uppercase text-medium-emphasis small">Registros</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- /.col-->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4" style="--cui-card-cap-bg: #0E91FF">
                                    <div class="card-header position-relative d-flex justify-content-center align-items-center text-white">
                                    <strong style='font-size: 0.7rem'> SALON </strong>
                                    </div>
                                    <div class="card-body row text-center">
                                    <div class="col">
                                        <div class="fs-5 fw-semibold" style='font-size: 0.7rem'>{{salon_registro}}</div>
                                        <div class="text-uppercase text-medium-emphasis small" style='font-size: 0.7rem'>Registros </div>
                                    </div>
                                    <div class="vr"></div>
                                    <div class="col">
                                        <button type="button" class="btn btn-info text-white position-relative" data-bs-toggle="modal" data-bs-target="#frmSalon" style='font-size: 0.7rem'>
                                            <i  class="icon-plus"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                new
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <!-- prueba fin card -->

                            <div class="card-header">
                                <button type="button" @click="btnNuevoArticulo()" class="btn btn-info text-white" style='margin-left: 1.2%;font-size: 0.7rem'>
                                    <i class="icon-plus" ></i>&nbsp;Nuevo
                                </button>
                            </div>
                            <div class="form-group mt-3 mb-3" id="home" >
                                <div class="col-md-8">
                                <div class="input-group" style='width:96%;margin-left: 3.3%;font-size: 0.7rem'>
                           
                                            <!-- <select class="form-select col-md-3" v-model="datos.impresion" @change="cambiarVenta()" style='font-size: 0.7rem'>
                                                <option value="0">Bar</option>
                                                <option value="1">Cocina</option>                                  
                                            </select> -->
                    
                                            &nbsp;
                                            <select class="form-select col-md-3" v-model="criterio" style='font-size: 0.7rem'>
                                                <option value="salon.nombre">Salon</option>
                                                <option value="mesa.nombre">Mesa</option>
                                            </select>
                                            &nbsp;
                                        <input type="text" v-model="buscar" @keyup.enter="listarMesa(1, buscar, criterio)" @keyup="BuscandoArticulo()" class="form-control" placeholder="Texto a buscar" style='font-size: 0.7rem'>
                                        &nbsp;
                                        <button type="submit" @click="listarMesa(1, buscar, criterio)" class="btn btn-info text-white" style='font-size: 0.7rem'><i class="fa fa-search" ></i> Buscar</button>
 
                                    </div>
                                </div>
                            </div>
                            <!-- Light table -->
                            <div class="table-responsive">
                            <table class="table table-striped table-hover" style='width:96%;margin-left: 2.2%;font-size: 0.7rem'>
                                <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 400px;">
                                    <div class="col" v-for="articulo in arrayArticulo" :key="articulo.id">
                                        <div class="card" >
                                            <img :src="'img/producto/'+articulo.foto" class="card-img-top" alt="" width="25" height="120" @click="editarArticulo(articulo)">
                                            <ul class="list-group list-group-flush" style="font-size: 0.7rem;">
                                                <li class="list-group-item text-center" style="font-size: 0.7rem;"><strong>{{articulo.nombre}}</strong></li>
                                                <li class="list-group-item text-center" style="font-size: 0.7rem;"><strong>{{articulo.salon}}</strong></li>
                                            </ul>
                                            <div class="card-footer" style="font-size: 0.7rem;">
                                                <!-- <p class="text-center"><strong></strong></p> -->
                                                <template v-if="articulo.estado==1">
                                                   <a class="dropdown-item text-center"  @click="desactivarArticulo(articulo.id)"><i class="fa fa-unlock text-success"></i> Desactivar</a>
                                                </template>
                                                <template v-else>
                                                   <a class="dropdown-item text-center"  @click="activarArticulo(articulo.id)"><i class="fa fa-lock text-danger"></i> Activar</a>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                <!--<div class="card-header text-center">
                                    <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 col-md-11">DATOS DE MESA</h5>
                                        <button type="button" class="btn-close btn-close" @click="ocultarListado1()" aria-label="Close"></button>
                                    </div>
                                </div>-->
                                <div class="card-header text-center text-white" style="background-color: #3399FF">
                                    <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 col-md-11">DATOS DE MESA</h6>
                                        <button type="button" class="btn-close btn-close" @click="ocultarListado1()" aria-label="Close"></button>
                                        <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                                    </div>
                                </div>
                                <div class="card-header text-center line p-0 m-0"  style="background-color: #3399FF">
                                </div>&nbsp;
                                
                                <form class="row g-3">
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" v-model="datos.nombre">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1" class="form-label">Salon</label>
                                        <div class="input-group mb-6">
                                            <section class="dropdown-wrapper form-control bg-disabled">
                                                <div @click="isVisible = !isVisible" class="selected-item">
                                                    <span v-if="datos.salon==''">Seleccione Salon</span>
                                                    <span v-else>{{datos.salon }}</span>
                                                    <svg :class="isVisible  ? 'dropdown' : ''" class="drop-down-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z"/></svg>
                                                </div>
                                                <div :class="isVisible   ? 'visible' : 'invisible'" class="dropdown-popover">
                                                    <input type="text" class="form-control" placeholder="Buscar Salon.."  v-model="buscarSalon" aria-label="Buscar Salon..">
                                                    <div class="text-center"><span v-if="filteredSalon.length === 0">No existen Salon</span></div>
                                                    <div class="options">
                                                        <ul>
                                                            <li @click="selectedSalon(salon)" v-for="(salon, index) in filteredSalon" :key="`cliente-${index}`">{{salon.nombre}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
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
                                                <img width="100" height="100" :src="imagenMiniatura" onerror="this.src='../img/producto/mesa.png'" class="border border-1 border-dark" alt="">
                                            </figure>
                                            </center> 
                                        </div>                         
                                    </div>

                                    <div class="col-md-6">
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
                                    </div>
                                </form>
                                <div class="header-divider"></div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-danger me-md-2 text-white" type="button" @click="ocultarListado1()">Cancelar</button>
                                    <button :disabled="guardando" class="btn btn-info btn-lg text-white" v-if="tipoAccion==1"  type="button" @click="guardar()">Guardar Mesa</button>
                                    <button :disabled="modificando" class="btn btn-info btn-lg text-white" v-if="tipoAccion==2"  type="button" @click="modificarMesa()">Modificar Mesa</button>
                                </div>
                            </div>
                            
                        </template>
                    </div>
                </div>
            </div>
        <!-- </div> -->

        <!--Modal Formulario Categoria-->
        <div class="modal fade" id="frmSalon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white">
                        <h4 class="modal-title ">Registro Salon</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row" :class="errores.nombre ? 'mb-1' : 'mb-3'">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
                                <div><input type="text" class="form-control" v-model="datosSalon.nombre"></div>
                            </div>
                            <div class="row mb-2" v-if="errores.nombre">
                                <div class="col-sm-2">&nbsp;</div>
                                <div class="col-sm-10"><span class="text-danger">{{errores.nombre[0]}}</span></div>
                            </div>
                            <div class="row pb-3">      
                                    <label for="imagen" class="col-md-2 form-control-label">Foto</label>
                                    &nbsp;
                                    <div class="col-md-12">
                                        <input type="file" @change="obtenerImagen2" class="form-control" id="imagen" :key="fileInputKey">

                                    </div>                              
                            </div>

                            <center>
                                    <figure><img width="100" height="100" :src="imagenMiniatura" onerror="this.src='img/producto/defecto.png'" class="border border-1 border-dark" alt=""></figure>
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
                        <button :disabled="guardando_salon" type="button" class="btn btn-info text-white" @click="guardarSalon() ">Guardar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin modal Formulario Categoria-->
        <!--Modal Formulario Unidad Medida-->
        <div class="modal fade" id="frmUnidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
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
                                <!-- <div class="col-sm-10"><input type="text" class="form-control" v-model="datosSalon.descripcion"></div> -->
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

        data(){
            return {
                datos : {
                    id : 0,
                    nombre : '',
                    estado : '1',
                    id_salon : 0,
                    foto :'',
                    imagenActual : '',
                    salon : '',
                },
                datosSalon : {
                    id : 0,
                    nombre : '',
                    estado : '1',
                    foto :'',
                    imagenActual : '',
                    id_tienda:2,
                },  
                datosUnidad : {
                    id : 0,
                    nombre : '',
                    estado : '1',
                    abreviatura : '',
                },  
                imagenMiniatura : '',
                salon_registro :0,
                mesa_registro :0, 
                producto_registro :0,                                
                arrayArticulo : [],
                arrayArticulo2 : [],
                errores:{},
                fileInputKey:'',
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorArticulo : 0,
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
                criterio : 'salon.nombre',
                buscar : '',
                arraySalon : [],
                arrayUnidad : [],
                arrayProductoCompuesto : [],
                arrayTipoProducto : [],
                arrayProveedor : [],
                listado: 0,
                setTimeoutBuscador: '',
                buscarSalon: '',
                isVisible: false,
                validar_tipo:false,
                generar:false,
                listadoMenu: 0,
                unidad_registro :0,
                is_busy : 0,
                guardando:false,
                modificando:false,
                guardando_salon:false,
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
            filteredSalon(){
                const data = this.buscarSalon.toLowerCase();
                if(this.buscarSalon == ""){
                    return this.arraySalon;
                }
                return this.arraySalon.filter((item)=>{
                    return Object.values(item).some((word=>String(word).toLowerCase().includes(data)))
                })
            }
        },
        methods : {
            volverMenu(){
                this.$emit('cerrarMenu', this.listadoMenu);
            },
            obtenerImagen(e){
                var fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = e => {
                    this.datos.foto = e.target.result;
                    this.imagenMiniatura=this.datos.foto;
                };
            },
            obtenerImagen2(e){
                var fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = e => {
                    this.datosSalon.foto = e.target.result;
                    this.imagenMiniatura=this.datosSalon.foto;
                };
            },
            selectedSalon(salon){
                this.datos.salon='';
                this.datos.id_salon=0;
                this.isVisible = false;
                this.datos.salon = salon.nombre;
                this.datos.id_salon = salon.id;
            },
            // cambiarVenta()
            // {
            //     if(this.datos.impresion == '0')
            //     {
            //         this.listarMesa(1, '', 'salon.nombre'); 
            //     }
            //     else
            //     {
            //         this.listarArticulo2(1, '', 'salon.nombre'); 
            //     }
            // },
            listarMesa(page, buscar, criterio){
                let me=this;
                me.buscarSalon= '';
                me.isVisible = false;
                var url='/mesa?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response){
                    me.arrayArticulo=response.data.data;
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
            listarArticulo2(page, buscar, criterio){
                let me=this;
                var url='/articuloComida?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response){
                    me.arrayArticulo=response.data.data;
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
            listarArticuloBusquedaRapida(){
                let me=this;
                var url='/mesa?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio;
                axios.get(url).then(function(response){
                    me.arrayArticulo=response.data.data;
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
            listarArticuloBusquedaRapida2(){
                let me=this;
                var url='/articuloFarmacia?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio;
                axios.get(url).then(function(response){
                    me.arrayArticulo=response.data.data;
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
            BuscandoArticulo(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida,350)
            },
            BuscandoArticulo2(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida2,350)
            },
            btnNuevoArticulo(){
                this.selectSalon();
                this.selectTipoProducto();
                this.selectTipoProductoCompuesto();
                this.selectUnidad();
                let me = this;
                me.listado=1;
                this.is_busy = 0;
                this.tipoAccion = 1;
                this.imagenMiniatura = '';
                this.datos.imagenActual = '';
                this.fileInputKey++;
                me.datos = {
                    id : 0,
                    nombre : '',
                    estado : '1',
                    id_salon : 0,
                    foto :'',
                    imagenActual : '',
                    salon : '',

                };
            },
            guardar(){
            if(this.datos.nombre==''){
                this.validacionError('Ingrese el nombre no puede estar vacio',3000);
                }else{ 
                    if(this.datos.id_salon==0){
                        this.validacionError('Seleccione un Salon',3000);
                    }else{ 
                        //if(this.is_busy == 0){
                            this.guardarMesa();
                            //this.is_busy=1;
                        //}     
                    }       
                    
                }        
            },
            async guardarMesa(){
                       let me = this;
                        me.guardando=true;
                       try {
                            // let data = {
                            //     id : me.datos.id,
                            //     nombre : me.datos.nombre,
                            //     estado : me.datos.estado,
                            //     foto : me.datos.foto,
                            //     id_salon : me.datos.id_salon >0 ? me.datos.id_salon : "",
                            
                            // }
                            const res = await axios.post('/mesa/guardar',this.datos);
                            if(res.data.error==0){
                                //me.$toaster.error('Matricula ya existe...');
                                // Swal.fire({
                                //     icon: 'error',
                                //     title: 'Nombre ya existe...',
                                //     text: 'Debe usar otra nombre!'
                                // })
                                 me.guardando=false;

                                this.validacionError('Nombre ya existe... !Debe usar otra nombre!',3000);

                                me.is_busy = 0;
                            }
                            else{
                                me.guardando=false;

                                me.listado =0;
                                me.registrosMesa();
                                me.listarMesa(1, '', 'salon.nombre');   
                                me.errores ={};
                                me.datos = {
                                id : 0,
                                nombre : '',
                                cod_ean : '',
                                costo_compra: 0,
                                precio_venta: 0,
                                descripcion : '',
                                estado : '1',
                                id_categoria : 0,
                                id_tipo_producto : 0,
                                id_unidad : 0,
                                accion : '1',
                                foto :'',
                                imagenActual : '',
                                categoria : '',
                                unidad : '',
                                tipo : '',
                                impresion:'0',
                            },
                            me.registrosMesa();
                            me.registrosArticuloProducto()
                            me.arrayArticulo = [];
                            //me.arrayArticulo2 = [];
                            me.arraySalon = [];
        
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Registro agregado...',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }  

                        } catch (error) {
                            if(error.response.data){
                                me.guardando=false;

                                this.errores=error.response.data.errors;
                                this.is_busy=0;
                            }
                        
                        }

            },
            async modificarMesa(){
                try {
                    let me = this;
                    me.modificando=true;
                    const res = await axios.put('/mesa/modificar',me.datos);
                    if(res.data.error==0){
                        this.validacionError('Nombre ya existe... !Debe usar otra nombre!',3000);
                        me.modificando=false;
                    } 
                    else{
                        if(res.data.error==1){
                            me.modificando=false;
                            this.validacionError('El nombre no puede estar vacio!!!!',3000);
                        }
                        else {
                            me.modificando=false;
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Registro modificado...',
                                showConfirmButton: false,
                                timer: 1500
                            }) 
                            me.listado =0;
                                me.registrosMesa();
                                me.listarMesa(1, '', 'salon.nombre');   
                                me.errores ={};
                                me.datos = {
                                id : 0,
                                nombre : '',
                                cod_ean : '',
                                costo_compra: 0,
                                precio_venta: 0,
                                descripcion : '',
                                estado : '1',
                                id_categoria : 0,
                                id_tipo_producto : 0,
                                id_unidad : 0,
                                accion : '1',
                                foto :'',
                                imagenActual : '',
                                categoria : '',
                                unidad : '',
                                tipo : '',
                                impresion:'0',
                            }    
                        } 
                    }
                } catch (error) {
                    if(error.response.data){
                        this.errores=error.response.data.errors;
                    }
                }
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
            registrosSalon(){
                let me=this;
                var url='/salon/cantidad';
                axios.get(url).then(function(response){
                    me.salon_registro=response.data.nro;
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            registrosMesa(){
                let me=this;
                var url='/mesa/cantidad';
                axios.get(url).then(function(response){
                    me.mesa_registro=response.data.nro;
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            registrosArticuloProducto(){
                let me=this;
                var url='/articulo/cantidad';
                axios.get(url).then(function(response){
                    me.producto_registro=response.data.nro;
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            selectSalon(){
                let me=this;
                var url='/salon/selectSalon';
                axios.get(url).then(function(response){
                    me.arraySalon=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            selectTipoProducto(){
                let me=this;
                var url='/selectTipoProducto';
                axios.get(url).then(function(response){
                    me.arrayTipoProducto=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            selectTipoProductoCompuesto(){
                let me=this;
                var url='/selectTipoProductoCompuesto';
                axios.get(url).then(function(response){
                    me.arrayProductoCompuesto=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            selectUnidad(){
                let me=this;
                var url='/unidad/selectUnidad';
                axios.get(url).then(function(response){
                    me.arrayUnidad=response.data;
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
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            editarArticulo(data=[]){
                this.selectSalon();
                let me = this;
                me.listado=1;
                this.tipoAccion = 2;
                this.datos.id = data['id'];
                this.datos.nombre = data['nombre'];
                this.datos.id_salon = data['id_salon'];
                this.datos.salon = data['salon'];
                this.datos.foto = data['foto'];

                this.datos.imagenActual = data['foto'];
                this.imagenMiniatura= '../img/producto/'+ this.datos.foto;
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarMesa(page, buscar, criterio);
            },
            ocultarListado1(){
                this.listado=0;
                this.errores = {};
            },
            async guardarSalon(){
                try {
                    let me = this;
                    me.guardando_salon=true;
                    me.datosSalon.id_tienda=2;// por defecto guardamos en tienda 2/1
                    const res = await axios.post('/salon/guardar',this.datosSalon);
                    if(res.data.error==0){
                        //me.$toaster.error('Matricula ya existe...');
                        me.guardando_salon=false;
                        Swal.fire({
                            icon: 'error',
                            title: 'Nombre ya existe...',
                            text: 'Debe usar otra nombre!'
                        })
                    }else{
                        if(res.data.error==1){
                            me.guardando_salon=false;
                            me.validacionError('El nombre no puede estar vacio',3000);
                        }
                        else{
                            me.guardando_salon=false;
                            me.imagenMiniatura = '';
                            me.datosSalon.imagenActual = '';  
                            me.registrosSalon();  
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
                    if(error.response.data){
                        me.guardando_salon=false;
                        this.errores=error.response.data.errors;
                    }
                }
            }, 
            async guardarUnidad(){
                try {
                    let me = this;
                    const res = await axios.post('/unidad/guardar',this.datosUnidad);
                    if(res.data.error==0){
                        //me.$toaster.error('Matricula ya existe...');
                        Swal.fire({
                            icon: 'error',
                            title: 'Nombre ya existe...',
                            text: 'Debe usar otra nombre!'
                        })
                    }
                    else{
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
                    if(error.response.data){
                        this.errores=error.response.data.errors;
                    }
                }
            },   
            registrosUnidad(){
                let me=this;
                var url='/unidad/cantidad';
                axios.get(url).then(function(response){
                    me.unidad_registro=response.data.nro;
                })
                .catch(function(error){
                    console.log(error)
                });                
            }, 
            limpiarDatosUnidad(){
                this.fileInputKey++; 
                this.datosUnidad = {
                    id : 0,
                    nombre : '',
                    abreviatura : '',
                    estado : '1',
                }
                this.errores = {}
            },
            // guardarSalon(){
            //     let me = this;
            //     axios.post('/categoria/guardar',this.datosSalon).then(function(response){
            //         Swal.fire({
            //             position: 'top-end',
            //             icon: 'success',
            //             title: 'Registro agregado...',
            //             showConfirmButton: false,
            //             timer: 1500
            //         }) 
            //         me.imagenMiniatura = '';
            //         me.datosSalon.imagenActual = '';  
            //         me.registrosSalon();  
            //         me.limpiarDatosCategoria();   
            //     })
            //     .catch(function(error){
            //         console.log(error);
            //     });
            //     this.selectSalon();
            // },
            limpiarDatosCategoria(){
                this.fileInputKey++; 
                this.datosSalon = {
                    id : 0,
                    nombre : '',
                    descripcion : '',
                    estado : '1',
                    foto :  '',
                }
                this.errores = {}
            },
            validarArticulo(){
                this.errorArticulo = 0;
                this.errorMostrarMsjArticulo = [];

                if(!this.datos.nombre) this.errorMostrarMsjArticulo.push("El nombre del Cliente no puede estar vacio ");
                if(this.errorMostrarMsjArticulo.length) this.errorArticulo=1;
                return this.errorArticulo;
            },
            desactivarArticulo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Inhabilitar esta Mesa??',
                    text: "Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Inhabilitar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/mesa/desactivar',{'id': id}).then(function (response) {
                        me.listarMesa(1,'', 'salon.nombre');
                        swalWithBootstrapButtons.fire(
                        'Inhabilitado!',
                        'Este mesa se ha Inhabilitado.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });                    
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Este mesa no ha tenido cambios :)',
                    'error'
                    )
                }
                })   
            },
            activarArticulo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Habilitar este Mesa??',
                    text: "Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Habilitar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/mesa/activar',{'id': id}).then(function (response) {
                        me.listarMesa(1,'', 'salon.nombre');
                        swalWithBootstrapButtons.fire(
                        'Habilitado!',
                        'Este mesa se ha Habilitado.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });                    
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Este mesa no ha tenido cambios :)',
                    'error'
                    )
                }
                })   
            } 
        },
        mounted() {
            this.listarMesa(1, this.buscar, this.criterio);
            this.registrosSalon();
            this.registrosMesa();
            this.registrosUnidad();
            this.registrosArticuloProducto();
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
