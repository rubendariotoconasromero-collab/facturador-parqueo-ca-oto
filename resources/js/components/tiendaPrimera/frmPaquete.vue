<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                &nbsp;
                <div class="card">
                    <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 col-md-11">COMBO</h6>
                                <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                            </div>
                    </div>
                    <template v-if="listado==0">
                        <div class="card-body">
                            <div class="form-group row" style='margin-left: 1%'>   
                            <form class="row">

                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label" style='font-size: 0.9rem'>Nombre</label>
                                    <!--<input type="text" class="form-control" style='font-size: 0.9rem' v-model="datos.nombre" readonly data-bs-toggle="modal" data-bs-target="#modalArticulo" @click="listarCombo(buscarP)" placeholder="Seleccione el combo">  -->
                                    <input type="text" 
                                        class="form-control form-input"
                                        style="font-size: 0.9rem; cursor: pointer; 
                                                background-color: #f2f2f2; color: #333; 
                                                border-color: #ccc; border-radius: 5px;"
                                        v-model="datos.nombre"
                                        readonly
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalArticulo"
                                        @click="listarCombo(buscarP)"
                                        placeholder="Seleccione el combo">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label" style='font-size: 0.9rem'>Precio</label>
                                    <input type="text" class="form-control"  v-model="datos.precio" min="0" style='font-size: 0.9rem'
                                    oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');">  
                                </div>
                                <!-- <div class="col-md-6">
                                        <label for="inputPassword" class="form-label">Estado</label>
                                        <div class="col-sm-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" v-model="datos.estado">
                                                <label class="form-check-label" for="inlineRadio1">Activo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="0" v-model="datos.estado">
                                                <label class="form-check-label" for="inlineRadio2">Inactivo</label>
                                            </div>
                                        </div>
                                </div>   -->

                                <!--<div class="col-md-6">      
                                    <label for="imagen" class="col-md-2 form-control-label" style='font-size: 0.9rem'>Foto</label>
                                    <div class="col-md-12">
                                        <input type="file" @change="obtenerImagen" class="form-control" id="imagen" :key="fileInputKey" style='font-size: 0.9rem'>

                                    </div>                              
                                </div>
                                <div class="col-md-6" style='font-size: 0.9rem'>&nbsp;
                                    <center>    
                                        
                                        <figure><img width="200" height="100" :src="imagenMiniatura" onerror="this.src='../img/producto/defecto.png'" class="border border-1 border-dark" alt=""></figure>
                                    </center>
                                </div>&nbsp;-->

                             
                                 <div class="col-md-12 mt-3">
                                    <label style='font-size: 0.9rem'>Productos<span style="color:red;font-size: 0.9rem" >(*Seleccione)</span></label>
                                    <button type="button" class="btn btn-info text-white position-relative" data-bs-toggle="modal" data-bs-target="#modalArticulo2" @click="listarArticulo(buscarP)" style='font-size: 0.9rem'><i class="fa fa-search"></i> Agregar Productos</button>
                                </div>              

                            </form>           
                                <div class="col-md-12">
                                    <div v-show="errorCompra" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjCompra" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="form-group row">
                                <div class="table-responsive">
                                <table class="table table-striped table-hover" style='width:96%;margin-left: 2%'>
                                    <thead style="background-color: #46546C">
                                        <tr>                      
                                            <th scope="col" class="text-white" style='font-size: 0.9rem'>Opción</th>
                                            <th scope="col" class="text-white" style='font-size: 0.9rem'>Nombre</th>
                                            <th scope="col" class="text-white" style='font-size: 0.9rem'>Precio</th>
                                            <th scope="col" class="text-white" style='font-size: 0.9rem'>Cantidad</th>
                                            <th scope="col" class="text-white" style='font-size: 0.9rem'>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="index">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white"></i></button>
                                            </td>
                                            <td v-text="detalle.articulo" style='font-size: 0.9rem'></td>
                                            <td v-text="detalle.costo_unitario" style='font-size: 0.9rem'></td>
                                            <td>
                                                <input v-model="detalle.cantidad" type="text" class="form-control" min="0" style='font-size: 0.9rem'
                                                oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');">
                                            </td>  
                                            <td v-text="detalle.costo_unitario*detalle.cantidad" style='font-size: 0.9rem'></td>
                                        </tr>
                                        <tr style="background-color: #e5f5fd">
                                            <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Total:</strong> </td>
                                            <td style="font-size: 0.8rem;">{{totalPrice}} bs</td>
                                        </tr>
                                    </tbody>
                                    <!--<tbody>
                                     <tr scope="col" class="text-white" style='font-size: 0.9rem'>Total</tr>
                                    </tbody>-->
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="7" style='font-size: 0.9rem'>No hay Combo agregados</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end" style='width:96%;margin-left: 2.2%'>
                                <button class="btn btn-danger me-md-2 text-white" type="button" @click="volverVentaListado()" style='font-size: 0.9rem'>Cancelar</button>
                                <template v-if="datos.id == 0">
                                    <button class="btn btn-info btn-lg text-white" type="button" @click="guardarPaquete()" style='font-size: 0.9rem'>Guardar</button>
                                </template>
                                <template v-else>
                                    <button class="btn btn-info btn-lg text-white" type="button" @click="modificarPaquete()" style='font-size: 0.9rem'>Modificar</button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
                </div>
            </div>
        <!-- </div>   -->
        <!--Modal Formulario Producto/Servicio-->
        <div class="modal fade" id="modalArticulo2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white" style="height:45px;">
                        <h5 class="modal-title ">BUSQUEDA DE PRODUCTOS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Producto</button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Productos</button>
                            </li> -->
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <!-- Servicios -->
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        &nbsp;&nbsp;<div class="input-group">

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
                                                <th scope="col" class="text-white">Nombre</th>
                                                <!-- <th scope="col" class="text-white">Tienda</th>
                                                <th scope="col" class="text-white">Costo Precio</th> -->
                                                <th scope="col" class="text-white">Precio Venta</th>
                                                <th scope="col" class="text-white">Opción</th>
                                                </tr>
                                        </thead>
                                        <tbody v-if="arrayArticulo.length">
                                            <tr v-for="tienda_articulo in arrayArticulo" :key="tienda_articulo.id">
                                                <td v-text="tienda_articulo.articulo"></td>
                                                <!-- <td v-text="tienda_articulo.tienda"></td>
                                                <td v-text="tienda_articulo.costo_unitario"></td> -->
                                                <td v-text="tienda_articulo.costo_venta"></td>
                                                <td>
                                                    <button type="button" @click="seleccionarTiendaArticulo2(tienda_articulo)" class="btn btn-success btn-sm"><i class="fa fa-check text-white"></i></button>   
                                                </td>                                 
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="7">No hay Producto agregados</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- Fin Servicios -->
                            <!-- Fin Productos -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal" @click="cerrarProductos()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin modal Formulario Producto/Servicio-->
        <!--Modal Formulario Producto/Servicio-->
        <div class="modal fade" id="modalArticulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white" style="height:45px;">
                        <h5 class="modal-title ">BUSQUEDA DE COMBOS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Producto</button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Productos</button>
                            </li> -->
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <!-- Servicios -->
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        &nbsp;&nbsp;<div class="input-group">

                                            <input type="text" v-model="buscarP" @keyup.enter="listarCombo(buscarP)" @keyup="BuscandoProductoCombo()" class="form-control" placeholder="Texto a buscar">
                                            &nbsp;&nbsp;&nbsp;
                                            <button type="submit" @click="listarCombo(buscarP)" class="btn btn-info text-white"><i class="fa fa-search"></i> Buscar</button>
                                        </div>  
                                    </div>                   
                                </div>&nbsp;
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead style="background-color: #46546C">
                                            <tr>        
                                                <!-- <th scope="col" class="text-white">Categoria</th>               -->
                                                <th scope="col" class="text-white">Nombre</th>
                                                <th scope="col" class="text-white">Precio Venta</th>
                                                <!-- <th scope="col" class="text-white">Tienda</th>
                                                <th scope="col" class="text-white">Costo Precio</th> -->
                                                <!-- <th scope="col" class="text-white">Stock</th> -->
                                                <th scope="col" class="text-white">Opción</th>
                                                </tr>
                                        </thead>
                                        <tbody v-if="arrayCombo.length">
                                            <tr v-for="tienda_articulo in arrayCombo" :key="tienda_articulo.id">
                                                <!-- <td v-text="tienda_articulo.categoria"></td> -->
                                                <td v-text="tienda_articulo.articulo"></td>
                                                <td v-text="tienda_articulo.costo_venta"></td>
                                                <!-- <td v-text="tienda_articulo.tienda"></td>
                                                <td v-text="tienda_articulo.costo_unitario"></td> -->
                                                <!-- <td v-text="tienda_articulo.stock"></td> -->
                                                <td>
                                                    <button type="button" data-dismiss="modal" @click="seleccionarCombo(tienda_articulo)" class="btn btn-success btn-sm" data-bs-dismiss="modal"><i class="fa fa-check text-white" ></i></button>   
                                                </td>                                 
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="7">No hay Producto agregados</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- Fin Servicios -->

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal" @click="cerrarProductos()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin modal Formulario Producto/Servicio-->
    </main>
</template>
<script>
    import Swal from 'sweetalert2';
    import moment from 'moment';
    export default {
        created() {
             this.datos.estado = '1';
        },
        data(){
            return {
                datos : {
                    id : 0,
                    id_tipo_producto : 0,
                    id_articulo : 0,
                    nombre : '',
                    estado:'1',
                    precio:0,
                    foto:'',
                    imagenActual : '',
                }, 
                imagenMiniatura : '',
                fileInputKey : '',            
                arrayVenta : [],
                arrayDetalle : [],
                arrayArticulo : [],
                arrayCombo : [],
                arrayComboVista : [],
                arrayArticuloServicio : [],
                listado : 0,
                tipoAccion : 0,
                errorCompra : 0,
                errorMostrarMsjCompra : [],
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
                buscarP : '',
                selectProducto : true,
                isVisible: false,
                buscarCliente: '',
                setTimeoutBuscador: '',
                isVisiblePersonal: false,
                buscarPersonal: '',
                estadoCaja: '',
                vista:0,
                listadoMenu: 0,
                is_busy : 0,
                tienda:2,
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
            calcularSubTotal: function(){
                var resultado = 0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado = resultado + (this.arrayDetalle[i].costo_unitario*this.arrayDetalle[i].cantidad);
                }
                return resultado;
            },
             totalPrice() {
                return this.arrayDetalle.reduce((total, item) => total + item.costo_unitario * item.cantidad , 0)
            }
        },
        methods : {
            volverMenu(){
                this.vista = 0;
                this.$emit('cerrarMenu', this.listadoMenu);
            },
            modificarPaquete(){
                if(this.arrayDetalle.length<=0){
                    this.validacionError('No Existe Productos agregados!',3000);
                }else {
                    if(this.arrayDetalle.find(seg =>  seg.cantidad < 0 )){
                            this.validacionError('La cantidad no puede ser negativo!',3000);
                        }else {
                            if(this.arrayDetalle.find(seg =>  seg.cantidad == 0 )){
                                this.validacionError('La cantidad no menor o igual a 0!',3000);
                            }else {
                                if(this.datos.precio<0){
                                    this.validacionError('El precio no puede ser negativo!',3000);
                                    }else {
                                        let me = this;
                                        if(me.is_busy==0){
                                            axios.put('/combo/modificar',{
                                                'id': me.datos.id,
                                                'nombre': me.datos.nombre,
                                                'id_articulo': me.datos.id_articulo,
                                                'precio': me.datos.precio,
                                                'foto': me.datos.foto,
                                                'imagenActual': me.datos.imagenActual,
                                                'detalle': me.arrayDetalle,
                                                'tipo_producto': me.arrayDetalle[0].tipo_producto,
                                            }).then(function(response){
                                                Swal.fire({
                                                    position: 'top-end',
                                                    icon: 'success',
                                                    title: 'Combo modificado exitosamente',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                                //me.cargarPdf2();
                                                me.volverVentaListado();
                                                me.limpiarDatosVenta();
                                            })
                                            .catch(function(error){
                                                console.log(error);
                                            });
                                        }
                                        me.is_busy=1;
                                    }
                            }
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
            seleccionarCombo(data=[]){
                this.buscarCliente= '',
                this.datos.id_articulo=data['id_articulo'];
                // this.datos.id_tipo_producto=data['id'];
                this.datos.nombre= data['articulo'];
                this.datos.precio= data['costo_venta'];
                this.datos.foto = data['foto'];

                this.datos.imagenActual = data['foto'];
                this.imagenMiniatura= '../img/producto/'+ this.datos.foto;
               
                this.listarComboVista(data['id_articulo']);

                // me.isDisabledCliente=true;

            },
            obtenerImagen(e){
                var fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = e => {
                    this.datos.foto = e.target.result;
                    this.imagenMiniatura=this.datos.foto;
                };
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
            listarArticulo(buscarP){
                let me = this;
                me.buscarCliente= '';
                me.isVisible = false;
                me.buscarPersonal= '';
                me.isVisiblePersonal = false;
                var url='/tienda/producto_tienda1?buscar=' + buscarP;
                axios.get(url).then(function(response){
                    me.arrayArticulo= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            listarCombo(buscarP){
                let me = this;
                me.is_busy =0;
                me.arrayDetalle = [];
                me.arrayComboVista = [];
                me.datos.id = 0;
                me.buscarCliente= '';
                me.isVisible = false;
                me.buscarPersonal= '';
                me.isVisiblePersonal = false;
                var url='/tienda/listarOrdenProductoTiendaCombo?buscar=' + buscarP;
                axios.get(url).then(function(response){
                    me.arrayCombo= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            listarComboVista(id){
                //console.log(id);
                let me = this;
                    var url='/combo/vista?id_articulo=' + id;
                    axios.get(url).then(function(response){
                        me.arrayComboVista= response.data;
                        me.datos.id= response.data[0].id;

                        var url='/combo/detalleComboP?id=' + me.arrayComboVista[0].id;
                        axios.get(url).then(function(response){
                            me.arrayDetalle= response.data;
                        })
                    
                    })
                    

                .catch(function(error){
                    console.log(error);
                });
            },
            listarComboBusquedaRapida(){
                let me = this;
                me.buscarCliente= '';
                me.isVisible = false;
                me.buscarPersonal= '';
                me.isVisiblePersonal = false;
                var url='/tienda/listarOrdenProductoTiendaCombo?buscar=' + me.buscarP;
                axios.get(url).then(function(response){
                    me.arrayCombo= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            listarArticuloBusquedaRapida(){
                let me = this;
                me.buscarCliente= '';
                me.isVisible = false;
                me.buscarPersonal= '';
                me.isVisiblePersonal = false;
                var url='/tienda/producto_tienda1?buscar=' + me.buscarP;
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
            BuscandoProductoCombo(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarComboBusquedaRapida,350)
            },
            listarArticulo2(buscarP){
                let me = this;
                me.buscarCliente= '';
                me.isVisible = false;
                me.buscarPersonal= '';
                me.isVisiblePersonal = false;
                var url='/tienda/servicio_tienda1?buscar=' + buscarP;
                axios.get(url).then(function(response){
                    me.arrayArticuloServicio= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            listarArticulo2BusquedaRapida(){
                let me = this;
                me.buscarCliente= '';
                me.isVisible = false;
                me.buscarPersonal= '';
                me.isVisiblePersonal = false;
                var url='/tienda/servicio_tienda1?buscar=' + me.buscarP;
                axios.get(url).then(function(response){
                    me.arrayArticuloServicio= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            BuscandoProductoServicio(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticulo2BusquedaRapida,350)
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
            seleccionarTiendaArticulo(data=[]){
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
                        categoria : data['categoria'],
                        id_articulo : data['id_articulo'],
                        articulo : data['articulo'],
                        tienda : data['tienda'],
                        costo_unitario : data['costo_unitario'],
                        costo_mayorista : data['costo_mayorista'],
                        costo_preferencial : data['costo_preferencial'],
                        costo_compra : data['costo_compra'],
                        tipo_producto : data['tipo_producto'],
                        stock : data['stock'],
                        cantidad : 1
                    });
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Producto agregado...',
                        showConfirmButton: false,
                        timer: 500
                    });
                }
            },
            seleccionarTiendaArticulo2(data=[]){
                let me = this;
                if(me.encuentra(data['id_articulo'])){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'Este producto ya se encuentra agregado!'
                    })
                }
                else{
                    me.datos.precio=(data['id_tipo_producto']==5)?data['costo_venta']:me.datos.precio;
                    me.arrayDetalle.push({
                        id_tienda_articulo : data['id_articulo'],
                        categoria : data['categoria'],
                        id_articulo : data['id_articulo'],
                        articulo : data['articulo'],
                        marca : data['marca'],
                        tienda : data['tienda'],
                        costo_unitario : data['costo_venta'],
                        costo_compra : data['costo_compra'],
                        stock : data['stock'],
                        cantidad : 1,
                        sub_total : data['sub_total']
                    });
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Producto agregado...',
                        showConfirmButton: false,
                        timer: 500
                    });
                }
            },
            volverVentaListado(){
                let me = this;
                me.arrayDetalle = [];
                me.arrayArticulo = [];
                me.datos.nombre = '';
                me.buscarP = '';
                me.is_busy =0;
                me.listado = 0;
            },
            guardarPaquete(){
                if(this.datos.nombre == ''){
                    this.validacionError('Debe Agregar el Combo!',3000);
                    this.is_busy=0;
                }else{
                    if(this.arrayDetalle.length<=0){
                        this.validacionError('No Existe Productos agregados!',3000);
                        this.is_busy=0;
                    } else {
                        if(this.arrayDetalle.find(seg =>  seg.cantidad < 0 )){
                            this.validacionError('La cantidad no puede ser negativo!',3000);
                            this.is_busy=0;
                        }else {
                            if(this.arrayDetalle.find(seg =>  seg.cantidad == 0 )){
                                this.validacionError('La cantidad no menor o igual a 0!',3000);
                                this.is_busy=0;
                            }else {
                                if(this.datos.precio<0){
                                    this.validacionError('El precio no puede ser negativo!',3000);
                                    this.is_busy=0;
                                    }else {
                                        let me = this;
                                            if(me.is_busy==0){
                                                axios.post('/combo/guardar',{
                                                    'nombre': me.datos.nombre,
                                                    'precio': me.datos.precio,
                                                    'estado': me.datos.estado,
                                                    'foto': me.datos.foto,
                                                    'imagenActual': me.datos.imagenActual,
                                                    'id_articulo': me.datos.id_articulo,
                                                    'detalle': me.arrayDetalle,
                                                    // 'tipo_producto': me.arrayDetalle[0].tipo_producto,
                                                }).then(function(response){
                                                    Swal.fire({
                                                        position: 'top-end',
                                                        icon: 'success',
                                                        title: 'Combo registrado exitosamente',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });
                                                    //me.cargarPdf2();
                                                    me.volverVentaListado();
                                                    me.limpiarDatosVenta();
                                                })
                                                .catch(function(error){
                                                    console.log(error);
                                                });
                                            }
                                            me.is_busy=1;
                                       }
                                 }
                            }
                        }
                    }
                        
            },        
            validarCompra(){
                this.errorCompra = 0;
                this.errorMostrarMsjCompra = [];

                if(!this.datos.nombre) this.errorMostrarMsjCompra.push("El nombre del Compra no puede estar vacio ");
                if(this.errorMostrarMsjCompra.length) this.errorCompra=1;
                return this.errorCompra;
            },
            limpiarDatosVenta(){
                this.datos = {
                    id : 0,
                    fecha_inicio : moment().format('YYYY-MM-DD'),
                    fecha_final : moment().format('YYYY-MM-DD'),
                    id_articulo : 0,
                    nombre:'',
                    foto:'',
                    estado:'1',
                    imagenActual : '',
                    arrayArticulo:[],
                    
                }
                this.imagenMiniatura = '',
                this.buscarCliente= ''
            },
            cerrarProductos(){
                this.arrayArticulo = [];
                this.arrayArticuloServicio = [];
                this.buscarP = '';
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
            cargarPdf2() {
                axios.get('/servicio/pdfOrdenServiciosGeneral2',{responseType: 'blob'})
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
            //this.listarVenta(1, this.buscar, this.criterio);
            this.verificarCaja();
            //this.listarComboVista();
            
             
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