<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                <div class="card">
                    <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 col-md-11">CONTRASEÑA</h6>
                                <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                            </div>
                    </div>
                    <!-- prueba card -->
                    <div class="row mt-2" style='width:90%;margin-left: 1.5%'>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card mb-4" style="--cui-card-cap-bg: #00C29D">
                            <div class="card-header position-relative d-flex justify-content-center align-items-center text-white">
                            <strong style='font-size: 0.7rem'> CONTRASEÑA </strong>
                            </div>
                            <div class="card-body row text-center">
                                <div class="col">
                                    <div class="avatar avatar-md"><img class="avatar-img" src="img/sit_norte/Personal.png"></div>
                                </div>
                                <div class="vr"></div>
                                <div class="col">
                                    <div class="fs-5 fw-semibold" style='font-size: 0.7rem'>{{contrasena_registro}}</div>
                                    <div class="text-uppercase text-medium-emphasis small " style='font-size: 0.7rem'>Registros</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                    <table class="table table-striped table-hover" style='width:96%;margin-left: 2.5%;font-size: 0.7rem'>
                        <thead style="background-color: #46546C">
                            <tr>
                                <th scope="col" class="text-white" style='font-size: 0.7rem'>Registro</th>
                                <th scope="col" class="text-white" style='font-size: 0.7rem'>Contraseña</th>
                                <th scope="col" class="text-white" style='font-size: 0.7rem'>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="personal in arrayPersonal" :key="personal.id">
                                <td v-text="personal.id" style='font-size: 0.7rem'></td>
                                <td v-text="personal.nombre" style='font-size: 0.7rem'></td>   
                                <td style='font-size: 0.7rem'>
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style='font-size: 0.7rem'>Acción</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" @click="abrirModal('personal','modificar',personal)"><i class="fa fa-edit text-warning"></i> Modificar</a></li>
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
                </div>
                </div>
            </div>
        <!-- </div> -->
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
                            <div class="row mb-3">
                                <label for="inputPassword" class="col-sm-3 col-form-label">Contraseña</label>
                                <div class="col-sm-9"><input type="text" class="form-control" v-model="datos.nombre" placeholder="Nombre"></div>
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
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info text-white" @click="guardarPersonal()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-info text-white" @click="modificarPersonal()">Modificar</button>
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
    
    export default {
        data(){
            return {
                datos : {
                    id : 0,
                    nombre : '',
                },
                datosCargo : {
                    id : 0,
                    nombre : '',
                    descripcion : '',
                    estado : '1',
                }, 
                datosDepartamento : {
                    id : 0,
                    nombre : '',
                    descripcion : '',
                    estado : '1',
                }, 
                buffer : '',
                imagenMiniatura : '',
                cargo_registro :0,
                departamento_registro :0,
                contrasena_registro :0,                                
                arrayPersonal : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPersonal : 0,
                errorMostrarMsjPersonal : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'personal.nombre',
                buscar : '',
                arrayTipoCargo : [],
                arrayTipodepartamento: [],
                listadoMenu: 0,
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
            imagenMin(){
            return this.imagenMiniatura;
            return this.datos.imagenActual;
            }
        },
        
        methods : {
            volverMenu(){
                this.$emit('cerrarMenu', this.listadoMenu);
            },
            listarEmpresa(page, buscar, criterio){
                let me=this;
                var url='/contrasena/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response){
                    me.arrayPersonal=response.data.data;
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

            registrosContrasena(){
                let me=this;
                var url='/contrasena/cantidad';
                axios.get(url).then(function(response){
                    me.contrasena_registro=response.data.nro;
                })
                .catch(function(error){
                    console.log(error)
                });                
            },

            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarEmpresa(page, buscar, criterio);
            },
            guardarPersonal(){
                if(this.validarPersonal()){
                    return;
                }
                let me = this;
                axios.post('/mi_empresa/guardar',this.datos).then(function(response){
                    if(response.data.error==0){
                        Swal.fire({
                            icon: 'error',
                            title: 'Este Nombre ya existe...',
                            text: 'Debe usar otro Nombre!'
                        })
                    }
                    else{
                        Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro agregado...',
                        showConfirmButton: false,
                        timer: 1500
                    }) 
                    me.cerrarModal();
                    me.listarEmpresa(1, '', 'mi_empresa.nombre');
                    me.registrosContrasena();    
                    }  
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            modificarPersonal(){
                if(this.validarPersonal()){
                    return;
                }
                let me = this;
                axios.put('/contrasena/modificar',this.datos).then(function(response){
                     Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro modificado...',
                        showConfirmButton: false,
                        timer: 1500
                    }) 
                    me.cerrarModal();
                    me.listarEmpresa(1,'', 'personal.nombre');                    
                }).catch(function(error){
                    console.log(error);
                });
            },         
            validarPersonal(){
                this.errorPersonal = 0;
                this.errorMostrarMsjPersonal = [];

                if(!this.datos.nombre) this.errorMostrarMsjPersonal.push("La contraseña no puede estar vacio");
                if(this.errorMostrarMsjPersonal.length) this.errorPersonal=1;
                return this.errorPersonal;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.errorPersonal = 0;
                this.datos = {
                    id : 0,
                    nombre : '',
                }
            },
            abrirModal(modelo, accion, data=[]){
                this.errorPersonal = 0;
                this.errorMostrarMsjPersonal = [];
                switch(modelo){
                    case "personal":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal='Registro Personal'
                                        this.datos = {
                                            id : 0,
                                            nombre : '',
                                        }                                      
                                        this.tipoAccion = 1;
                                        break;
                                    }
                                case 'modificar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Modificar Contraseña';
                                        this.tipoAccion = 2;
                                        this.datos.id = data['id'];
                                        this.datos.nombre = data['nombre'];
                                       break;
                                    }
                            }
                        }
              }
        
            }
        },
        mounted() {
            this.listarEmpresa(1, this.buscar, this.criterio);
            this.registrosContrasena();
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