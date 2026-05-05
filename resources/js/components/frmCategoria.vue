<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                <div class="card">
                    <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">CATEGORIA</h5>
                                <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                            </div>
                    </div>

                    <!-- prueba card -->
                    <div class="row mt-2" style='width:90%;margin-left: 1.3%'>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card mb-4" style="--cui-card-cap-bg: #3399FF">
                            <div class="card-header position-relative d-flex justify-content-center align-items-center text-white">
                            <strong style='font-size: 0.8rem'> CATEGORIA </strong>
                            </div>
                            <div class="card-body row text-center">
                                <div class="col">
                                    <div class="avatar avatar-md"><img class="avatar-img" src="img/sit_norte/categoria.png"></div>
                                </div>
                                <div class="vr"></div>
                                <div class="col">
                                    <div class="fs-5 fw-semibold" style='font-size: 0.8rem'>{{categoria_registro}}</div>
                                    <div class="text-uppercase text-medium-emphasis small " style='font-size: 0.8rem'>Registros</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- prueba fin card -->


                    <div class="card-header">
                        <button type="button" @click="abrirModal('categoria','registrar')" class="btn btn-info text-white" style='margin-left: 1%;font-size: 0.8rem'>
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8">
                            &nbsp;&nbsp;<div class="input-group" style='width:96%;margin-left: 3.3%;font-size: 0.8rem'>
                                <div class="col-md-3">
                                    <select class="form-select col-md-3" v-model="criterio" style='font-size: 0.8rem'>
                                        <option value="nombre">Nombre</option>
                                    </select>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                                <input type="text" v-model="buscar" @keyup.enter="listarCategoria(1, buscar, criterio)"  @keyup="BuscandoCategoria()" class="form-control" placeholder="Texto a buscar" style='font-size: 0.8rem'>
                                &nbsp;&nbsp;&nbsp;
                                <button type="submit" @click="listarCategoria(1, buscar, criterio)" class="btn btn-info text-white" style='font-size: 0.8rem'><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Light table -->
                    <div class="table-responsive">
                    <table class="table table-striped table-hover" style='width:96%;margin-left: 2.2%;font-size: 0.8rem'>
                        <thead style="background-color: #46546C">
                            <tr>                      
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Nombre</th>
                                <!-- <th scope="col" class="text-white" style='font-size: 0.8rem'>Descripcion</th> -->
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Foto</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Estado</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                                <td v-text="categoria.nombre" style='font-size: 0.8rem'></td>
                                <!-- <td v-text="categoria.descripcion"></td>     -->
                                <td style='font-size: 0.8rem'><img :src="'img/producto/'+categoria.foto" width="45" height="45" class="border border-1 border-dark rounded-circle" align="left" alt=""></td>   
                                <td>
                                    <template v-if="categoria.estado==1">
                                        <span class="badge bg-success">Activo</span>
                                    </template>
                                    <template v-else>
                                        <span class="badge bg-danger">Desactivo</span>
                                    </template>
                                </td> 
                                <td style='font-size: 0.8rem'>
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style='font-size: 0.8rem'>Accion</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" @click="abrirModal('categoria','modificar',categoria)"><i class="fa fa-edit text-warning"></i> Modificar</a></li>
                                        <template v-if="categoria.estado==1">
                                            <li><a class="dropdown-item" href="#" @click="desactivarCategoria(categoria.id)"><i class="fa fa-unlock text-success"></i> Desactivar</a></li>
                                        </template>
                                        <template v-else>
                                            <li><a class="dropdown-item" href="#" @click="activarCategoria(categoria.id)"><i class="fa fa-lock text-danger"></i> Activar</a></li>
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
                    <div class="modal-header text-white" style="background-color: #66B3FF">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cerrarModal()"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="row"  :class="errores.nombre ? 'mb-1' : 'mb-3'">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10"><input type="text" class="form-control" v-model="datos.nombre" ></div>
                            </div>
                           <div class="row mb-2" v-if="errores.nombre">
                                <div class="col-sm-2">&nbsp;</div>
                                <div class="col-sm-10"><span class="text-danger">{{errores.nombre[0]}}</span></div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Descripcion</label>
                                <div class="col-sm-10"><input type="text" class="form-control" v-model="datos.descripcion"></div>
                            </div>
                            <div class="row pb-3">      
                                    <label for="imagen" class="col-md-2 form-control-label">Foto</label>
                                    <div class="col-md-10">
                                        <input type="file" @change="obtenerImagen" class="form-control" id="imagen" :key="fileInputKey">

                                    </div>                              
                            </div>
                            <center>    
                                    <!-- <figure><img width="100" height="100" :src="imagenMiniatura" onerror="this.src='../public_html/img/producto/defecto.png'" alt=""></figure> -->
                                    <figure><img width="100" height="100" :src="imagenMiniatura" onerror="this.src='../img/producto/defecto.png'" class="border border-1 border-dark" alt=""></figure>
                            </center> 

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

                            <div v-show="errorCategoria" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" @click="cerrarModal()">Cerrar</button>
                        <button :disabled="guardando" type="button" v-if="tipoAccion==1" class="btn btn-info text-white" @click="guardar()">Guardar</button>
                        <button :disabled="modificando" type="button" v-if="tipoAccion==2" class="btn btn-info text-white" @click="modificarCategoria()">Modificar</button>
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
                    descripcion : '',
                    estado : '1',
                    foto : '',
                    imagenActual : '',
                },
                imagenMiniatura : '',                                    
                arrayCategoria : [],
                modal : 0,
                tituloModal : '',
                fileInputKey : '',
                tipoAccion : 0,
                errores:{},
                categoria_registro :0, 
                errorCategoria : 0,
                errorMostrarMsjCategoria : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                setTimeoutBuscador: '',
                listadoMenu: 0,
                is_busy:0,
                guardando:false,
                modificando:false,
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
            listarCategoria(page, buscar, criterio){
                let me=this;
                var url='/categoria?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response){
                    me.arrayCategoria=response.data.data;
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
            listarCategoriaBusquedaRapida(){
                let me=this;
                var url='/categoria?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio;
                axios.get(url).then(function(response){
                    me.arrayCategoria=response.data.data;
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
            BuscandoCategoria(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarCategoriaBusquedaRapida,350)
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarCategoria(page, buscar, criterio);
            },
            registrosCategoria(){
                let me=this;
                var url='/categoria/cantidad';
                axios.get(url).then(function(response){
                    me.categoria_registro=response.data.nro;
                })
                .catch(function(error){
                    console.log(error)
                });                
            }, 
            guardar(){
                //if(this.is_busy == 0){
                    this.guardarCategoria();
                    this.is_busy=1;
                //}  
            },
            async guardarCategoria(){
                let me = this;
           
                try {
                    me.guardando=true;
                    const res = await axios.post('/categoria/guardar',this.datos);
                    if(res.data.error==0){
                        me.guardando=false;
                        //me.$toaster.error('Matricula ya existe...');
                        Swal.fire({
                            icon: 'error',
                            title: 'Nombre ya existe...',
                            text: 'Debe usar otra nombre!'
                        })
                        me.is_busy= 0;
                    }else{
                        if(res.data.error==1){
                         me.guardando=false;
                            me.validacionError("El nombre no puede estar vacio", 3000);
                        }
                        else{
                            me.guardando=false;
                            me.cerrarModal();
                            me.registrosCategoria();
                            me.listarCategoria(1, '', 'nombre');   
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
                    me.guardando=false;
                    if(error.response.data){
                        this.errores=error.response.data.errors;
                        this.is_busy=0;
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
            modificarCategoria(){
                /*if(this.validarCategoria()){
                    return;
                }*/
                let me = this;
               
                me.modificando=true;
                //if(me.is_busy==0){
                    axios.put('/categoria/modificar',this.datos).then(function(response){
                        if(response.data.error==0){
                            me.modificando=false;
                            me.validacionError("El nombre no puede estar vacio", 3000);
                        }else{
                            me.modificando=false;
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Registro modificado...',
                                showConfirmButton: false,
                                timer: 1500
                            }) 
                            me.cerrarModal();
                            me.listarCategoria(1,'', 'nombre');                    
                        }
                    }).catch(function(error){
                        console.log(error);
                    });
                //}
                me.is_busy=1;
            },         
            validarCategoria(){
                this.errorCategoria = 0;
                this.errorMostrarMsjCategoria = [];

                if(!this.datos.nombre) this.errorMostrarMsjCategoria.push("El nombre del Cargo no puede estar vacio ");
                if(this.errorMostrarMsjCategoria.length) this.errorCategoria=1;
                return this.errorCategoria;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.imagenMiniatura = '';
                this.datos.imagenActual = '';
                this.fileInputKey++;
                this.errorCategoria = 0;
                this.datos = {
                    id : 0,
                    nombre : '',
                    descripcion : '',
                    estado : '1',
                }
            },
            abrirModal(modelo, accion, data=[]){
                this.is_busy=0;
                this.errorCategoria = 0;
                this.errorMostrarMsjCategoria = [];
                switch(modelo){
                    case "categoria":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.imagenMiniatura = '';
                                        this.datos.imagenActual = '';
                                        this.tituloModal='Registro Categoria'
                                        this.datos = {
                                            id : 0,
                                            nombre : '',
                                            descripcion : '',
                                            foto:'',
                                            estado : '1',
                                        }                                      
                                        this.tipoAccion = 1;
                                        break;
                                    }
                                case 'modificar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Modificar Categoria';
                                        this.tipoAccion = 2;
                                        this.datos.id = data['id'];
                                        this.datos.nombre = data['nombre'];
                                        this.datos.descripcion = data['descripcion'];
                                        this.datos.estado = data['estado'];
                                        this.datos.foto = data['foto'];
                                        this.datos.imagenActual = data['foto'];
                                        this.imagenMiniatura= 'img/producto/'+ this.datos.foto;
                                       break;
                                    }
                            }
                        }
              }
        
            },
            desactivarCategoria(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Inhabilitar este Categoria??',
                    text: "Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Inhabilitar!', 
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/categoria/desactivar',{'id': id}).then(function (response) {
                        me.listarCategoria(1,'', 'nombre');
                        swalWithBootstrapButtons.fire(
                        'Inhabilitado!',
                        'Este categoria se ha Inhabilitado.',
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
            activarCategoria(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Habilitar este Categoria??',
                    text: "Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Habilitar!',

                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/categoria/activar',{'id': id}).then(function (response) {
                        me.listarCategoria(1,'', 'nombre');
                        swalWithBootstrapButtons.fire(
                        'Habilitado!',
                        'Este categoria se ha Habilitado.',
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
            } 
        },
        mounted() {
            this.listarCategoria(1, this.buscar, this.criterio);
            this.registrosCategoria();
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