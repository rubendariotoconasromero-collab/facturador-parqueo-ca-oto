<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                <div class="card">
                    <div class="card-header text-center text-white" style="background-color: #3399FF">
                        <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 col-md-11">COMPRA</h5>
                            <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                        </div>
                    </div>
                    <template v-if="listado==0 && estadoCaja == 'Abierta'">
                        <div class="card-body">
                            <div class="form-group row" style='margin-left: 1%'>
                            <form class="row">
                                <div class="col-md-6">
                                <label for="exampleInputPassword1" class="form-label" style='font-size: 0.8rem'>Proveedor<span style="color:red;" > *</span></label>
                                    <select class="form-select" v-model="datos.id_proveedor" style='font-size: 0.8rem'>
                                        <option value="0" disabled>Seleccione el Proveedor</option>
                                        <option v-for="proveedor in arrayProveedor" :key="proveedor.id" :value="proveedor.id" v-text="proveedor.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label" style='font-size: 0.8rem'>Fecha</label>
                                    <input type="date" class="form-control"  v-model="datos.fecha" disabled style='font-size: 0.8rem'>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label" style='font-size: 0.8rem'>Tipo Pago</label>
                                        <select class="form-select" v-model="datos.id_tipo_pago" style='font-size: 0.8rem'>
                                            <option value="0" disabled>Seleccione el Tipo Pago</option>
                                            <option v-for="tipo_pago in arrayPago" :key="tipo_pago.id" :value="tipo_pago.id" v-text="tipo_pago.nombre"></option>
                                        </select>  
                                    </div>
                                    <div class="col-md-6" v-if="datos.id_tipo_pago == 2">
                                        <label for="exampleInputPassword1" class="form-label" style='font-size: 0.8rem'>Fecha Final</label>
                                        <input type="date" class="form-control"  v-model="datosPago.fecha_final" style='font-size: 0.8rem'>  
                                    </div>
                                    <div class="col-md-6" v-if="datos.id_tipo_pago == 1">
                                        <label for="exampleInputPassword1" class="form-label" style='font-size: 0.8rem'>Forma Pago</label>
                                        <template>
                                            <select class="form-select" v-model="datos.id_forma_pago" style='font-size: 0.8rem'>
                                                <option value="0" disabled>Seleccione la Forma de Pago</option>
                                                <option v-for="forma_pago in arrayForma2" :key="forma_pago.id" :value="forma_pago.id" v-text="forma_pago.nombre"></option>
                                            </select>  
                                        </template> 
                                </div>

                                <div class="col-md-12">
                                    <label for="exampleInputPassword1" class="form-label" style='font-size: 0.8rem'>Descripcion</label>
                                    <textarea class="form-control" v-model="datos.descripcion" rows="2" style='font-size: 0.8rem' ></textarea>
                                </div>
                                &nbsp;
                                <div class="col-md-12">
                                    <label style='font-size: 0.8rem'>Productos<span style="color:red;" >(*Seleccione)</span></label>
                                    <button type="button"  class="btn btn-info text-white position-relative" data-bs-toggle="modal" data-bs-target="#modalArticulo" @click="listarArticulo(buscarP,criterioP)" style='font-size: 0.8rem'><i class="fa fa-search"></i> Agregar Productos</button>
                                </div>
                            </form>
                            </div>

                            <br>
                            <div class="form-group row">
                                <div class="table-responsive">
                                <table class="table table-striped table-hover" style='width:96%;margin-left: 2%'>
                                    <thead style="background-color: #46546C">
                                        <tr>
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Opción</th>
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Nombre</th>
                                            <!-- <th scope="col" class="text-white">Tienda</th> -->
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Precio</th>
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Cantidad</th>
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white"></i></button>
                                            </td>
                                            <td v-text="detalle.articulo"></td>
                                            <!-- <td v-text="detalle.tienda"></td> -->
                                            <td>
                                                <input v-model="detalle.costo_compra" type="text" value="3" class="form-control"
                                                oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');">
                                            </td>
                                            <td>
                                                <input v-model="detalle.cantidad" type="text" value="3" class="form-control" min="0"
                                                oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');">
                                            </td>
                                            <td>{{detalle.sub_total = detalle.costo_compra*detalle.cantidad}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5">
                                            <td colspan="4" align="right"> <strong>Total:</strong> </td>
                                            <td>{{datos.total = calcularTotal.toFixed(2)}} bs</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5">
                                            <td colspan="4" align="right"> <strong>Descuento:</strong> </td>
                                            <td>
                                                <input v-model="datos.descuento" type="text" value="0" class="form-control"
                                                oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');">
                                            </td>
                                        </tr>
                                         <tr style="background-color: #CEECF5">
                                            <td colspan="4" align="right"> <strong>Sub Total:</strong> </td>
                                            <td>{{datos.sub_total = datos.total- datos.descuento}} bs</td>
                                        </tr>
                                        <template v-if="datos.id_forma_pago ==6">
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> <strong>Total Efect.:</strong> </td>
                                                <td>
                                                     <input v-model="datos.total_efectivo" value="0" class="form-control" >

                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> <strong>Total Dep.:</strong> </td>
                                                <td>{{datos.total_deposito = datos.total- datos.total_efectivo}} bs</td>
                                            </tr>
                                        </template>

                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5" style='font-size: 0.8rem'>No hay Productos agregados</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end" style='width:96%;margin-left: 2.2%'>
                                <button class="btn btn-danger me-md-2 text-white" type="button" @click="volverCompraListado()" style='font-size: 0.8rem'>Cancelar</button>
                                <button class="btn btn-info btn-lg text-white" type="button" @click="guardarCompra()" style='font-size: 0.8rem'>Guardar</button>
                            </div>
                        </div>
                    </template>
                    <template v-if="listado==0 && estadoCaja == 'Cerrada'">
                        <div class="alert alert-warning alert-dismissable text-center">
                            <strong>¡Cuidado!</strong> Se requiere Aperturar Caja Primero.
                        </div>
                    </template>
                </div>
                </div>
            </div>
        <!-- </div>   -->

        <!--Modal Formulario Articulo-->
        <div class="modal fade" id="modalArticulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white" style="height:45px;" >
                      <h5 class="modal-title ">BUSQUEDA DE PRODUCTOS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

<!-- df -->
                    <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <template v-if="usuario.id_tienda == 100">
                                    <select style="display:none" class="form-select" v-model="tienda" @change="listarArticulo(buscarP, criterioP)">
                                        <!-- <option value="1" disabled>Seleccione la Tienda</option> -->
                                        <option v-for="tienda in arrayTienda2" :key="tienda.id" :value="tienda.id" v-text="tienda.nombre"></option>
                                    </select>
                                    </template>
                                    &nbsp;
                                    <select class="form-select col-md-3" v-model="criterioP">
                                        <option value="articulo.nombre">Producto</option>
                                        <option value="categoria.nombre">Categoria</option>
                                        <!-- <option value="articulo.marca">Marca</option>                                     -->
                                    </select>&nbsp;&nbsp;&nbsp;
                                    <input type="text" v-model="buscarP" @keyup.enter="listarArticulo(buscarP, criterioP)" @keyup="BuscandoProducto()" class="form-control" placeholder="Texto a buscar">
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit" @click="listarArticulo(buscarP, criterioP)" class="btn btn-info text-white"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>&nbsp;
<!-- KCda                         -->
                        <!-- <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" v-model="buscarP" @keyup.enter="listarArticulo(buscarP,criterioPbuscarP)" class="form-control" placeholder="Texto a buscar">
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit" @click="listarArticulo(buscarP,criterioPbuscarP)" class="btn btn-info text-white"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>&nbsp; -->
                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead style="background-color: #46546C">
                                <tr>
                                    <th scope="col" class="text-white">Categoria</th>
                                    <th scope="col" class="text-white">Nombre</th>
                                    <!-- <th scope="col" class="text-white">Tienda</th> -->
                                    <th scope="col" class="text-white">Precio</th>
                                    <th scope="col" class="text-white">Opción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tienda_articulo in arrayArticulo" :key="tienda_articulo.id">
                                    <td v-text="tienda_articulo.categoria"></td>
                                    <td v-text="tienda_articulo.articulo"></td>
                                    <!-- <td v-text="tienda_articulo.tienda"></td> -->
                                    <td v-text="tienda_articulo.costo_compra"></td>

                                    <td>
                                        <button type="button" @click="seleccionarTiendaArticulo(tienda_articulo)" class="btn btn-success btn-sm"><i class="fa fa-check text-white"></i></button>
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
        <div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white">
                        <h4 class="modal-title ">Pago al Credito</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Fecha</label>
                                <div><input type="date" class="form-control" v-model="datosPago.fecha" disabled></div>
                            </div>
                            <div class="mb-3">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Monto Total</label>
                                <div><input type="number" class="form-control" v-model="datos.total" disabled></div>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Anticipo</label>
                                <div><input type="number" class="form-control" v-model="datosPago.anticipo" v-on:keyup.enter="calcularSaldoAnticipado()"></div>
                            </div> -->
                            <div class="mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Saldo</label>
                                <div><input type="number" class="form-control" v-model="datosPago.saldo" disabled></div>
                            </div>
                            <div class="mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Descripcion</label>
                                <textarea class="form-control" id="message-text" v-model="datosPago.descripcion"></textarea>
                                <!-- <div class="col-sm-10"><input type="text" class="form-control" v-model="datosCategoria.descripcion"></div> -->
                            </div>
                            <div v-show="errorPago" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjPago" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-info text-white" data-bs-dismiss="modal">Guardar</button>
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
        created() {
            this.verificarCaja();
            this.datos.id_forma_pago = 2;
        },
        data(){
            return {
                datos : {
                    id : 0,
                    fecha : moment().format('YYYY-MM-DD'),

                    sub_total : 0,
                    descuento : 0,
                    total : 0,
                    descripcion : '',
                    id_proveedor : 0,
                    id_forma_pago : 2,
                    id_tipo_pago : 1,
                    proveedor : '',
                    tipoPago : 'Contado',
                    formaPago : '',

                    total_efectivo:0,
                    total_deposito:0,
                },
                datosPago:{
                    id: 0,
                    fecha_inicio : moment().format('YYYY-MM-DD'),
                    fecha_final : moment().add(1,'month').format('YYYY-MM-DD'),
                    saldo : 0,
                    anticipo : 0,
                    descripcion: '',
                },

                arrayCompra : [],
                arrayPago: [],
                arrayDetalle : [],
                arrayForma2: [],
                arrayForma: [],
                arrayArticulo : [],
                arrayProveedor: [],
                arrayFormaPago: [],
                listado : 0,
                tipoAccion : 0,
                errorCompra : 0,
                errorPago : 0,
                errorMostrarMsjPago : [],
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
                criterioP : 'articulo.nombre',
                setTimeoutBuscador: '',
                listadoMenu: 0,
                tienda : 1,
                usuario : {},
                arrayTienda2 : [],
                estadoCaja: '',

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
            calcularTotal: function(){
                var resultado = 0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado = resultado + (this.arrayDetalle[i].costo_compra*this.arrayDetalle[i].cantidad);
                }
                return resultado;
            }
        },
        methods : {
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
            selectTienda(){
                let me=this;
                var url='/tienda/selectTienda';
                axios.get(url).then(function(response){
                    me.arrayTienda2=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            volverMenu(){
                this.$emit('cerrarMenu', this.listadoMenu);
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarCompra(page, buscar, criterio);
            },
            listarArticulo(buscarP, criterioP){
                let me = this;
                if(me.usuario.id_tienda == 100){
                    var url='/tienda/listarSinPaginateCompra?buscar=' + buscarP + '&criterio=' + criterioP + '&id_tienda=' + me.tienda;
                    axios.get(url).then(function(response){
                        me.arrayArticulo= response.data;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }else
                {   
                    var url='/tienda/listarSinPaginateCompra?buscar=' + buscarP + '&criterio=' + criterioP + '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function(response){
                        me.arrayArticulo= response.data;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },
            listarArticuloBusquedaRapida(){
                let me = this;
                me.buscarCliente= '';
                me.isVisible = false;
                if(me.usuario.id_tienda == 100){
                    var url='/tienda/listarSinPaginateCompra?buscar=' + me.buscarP+ '&criterio=' + me.criterioP + '&id_tienda=' + me.tienda;
                    axios.get(url).then(function(response){
                        me.arrayArticulo= response.data;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }else
                {
                    var url='/tienda/listarSinPaginateCompra?buscar=' + me.buscarP+ '&criterio=' + me.criterioP + '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function(response){
                        me.arrayArticulo= response.data;
                    })
                    .catch(function(error){
                        console.log(error);
                    }); 
                }
            },
            BuscandoProducto(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida,350)
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
                        id_articulo : data['id_articulo'],
                        id_tienda : data['id_tienda'],
                        articulo : data['articulo'],
                        tienda : data['tienda'],
                        costo_compra : data['costo_compra'],
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
            cancelarCompra(){
                let me = this;
                me.arrayDetalle = [];
                me.arrayArticulo = [];
                me.datos.nombre = '';
                me.buscarP = '';
            },
            volverCompraListado(){
                let me = this;
                me.arrayDetalle = [];
                me.arrayArticulo = [];
                me.datos.nombre = '';
                me.buscarP = '';
                me.listado = 0;
                me.tienda = 1,
                me.limpiarDatosCompra();
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
                    //me.arrayFormaPago=response.data;
                    me.arrayForma2 = response.data;
                    me.arrayForma2 = me.arrayForma2.filter((item) => item.id !== 1);
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            verCompra(data=[]){
                let me = this;
                me.listado = 2;
                me.datos.id=data['id'];
                me.datos.proveedor=data['proveedor'];
                me.datos.fecha=data['fecha'];
                me.datos.descripcion=data['descripcion'];
                me.datos.descuento=data['descuento'];
                me.datos.estado=data['estado'];
                me.datos.formaPago=data['formaP'];

                var url='/compra/permiso/detalle?id=' + data['id'];
                axios.get(url).then(function(response){
                    me.arrayDetalle= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            validarCompra(){
                this.errorCompra = 0;

                if(this.datos.id_proveedor==""){
                    this.validacionError('Seleccione un Proveedor!',3000);
                }
                else
                {
                    if(this.datos.id_tipo_pago==0){
                        this.validacionError('Seleccione un Tipo de Pago!',3000);
                    }
                    else
                    {
                        if(this.datos.id_forma_pago==0){
                            this.validacionError('Seleccione una Forma de Pago',3000);
                        }
                        else
                        {
                            if(this.datos.descuento<0){
                                this.validacionError('El descuento no puede ser negativo',3000);
                            }else{
                                if(this.arrayDetalle.length<=0){
                                    this.validacionError('Agregue Productos a la Compra',3000);
                                }
                                else
                                {
                                    if(this.datos.total <= 0 || this.datos.sub_total <=0){
                                        this.validacionError('El total no puedes cero o Negativo!',3000);
                                    }else{ 
                                        if(this.arrayDetalle.find(seg => (seg.cantidad <= 0 ))){
                                            this.validacionError('Debe ingresar cantidad valida para el producto',3000);
                                        }else{
                                            if(this.arrayDetalle.find(seg => (seg.costo_compra <= 0 ))){
                                                this.validacionError('Precio no puede ser menor a 0',3000);
                                            }else{ 
                                            this.errorCompra = 3;
                                            }    
                                        }

                                    }
                                }
                            }
                        }
                    }
                }
                return this.errorCompra;
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
            guardarCompra(){
                this.validarCompra();
                if(this.errorCompra==3){
                    let me = this;
                    axios.post('/compra/guardarContado',{
                        'fecha': me.datos.fecha,
                        'fecha_inicio': me.datosPago.fecha_inicio,
                        'fecha_final': me.datosPago.fecha_final,

                        'descripcion': me.datos.descripcion,
                        'sub_total': me.datos.sub_total,
                        'descuento': me.datos.descuento,
                        'total': me.datos.total,
                        'id_proveedor': me.datos.id_proveedor,
                        'id_tipo_pago': me.datos.id_tipo_pago,
                        'id_tienda': me.tienda,
                        'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
                        'detalle': me.arrayDetalle,
                        'monto_total': me.datos.total,
                        'descripcion_pago': me.datosPago.descripcion,
                        'saldo': me.datosPago.saldo,

                        'total_efectivo': me.datos.total_efectivo,
                        'total_deposito': me.datos.total_deposito,
                    }).then(function(response){
                        console.log(me.arrayDetalle);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Compra registrado exitosamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        me.volverCompraListado();
                        //me.listarCompra(1,'', 'nombre');
                        me.limpiarDatosCompra();
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                }
            },
            limpiarDatosCompra(){
                this.tienda = 1,
                this.datos = {
                    id : 0,
                    id_proveedor : 0,
                    id_forma_pago : 2,
                    id_tipo_pago : 1,
                    fecha : moment().format('YYYY-MM-DD'),
                    descripcion : '',
                    sub_total : 0,
                    descuento : 0,
                    total : 0,
                }
            },
            // validarCompra(){
            //     this.errorCompra = 0;
            //     this.errorMostrarMsjCompra = [];

            //     if(!this.datos.nombre) this.errorMostrarMsjCompra.push("El nombre del Compra no puede estar vacio ");
            //     if(this.errorMostrarMsjCompra.length) this.errorCompra=1;
            //     return this.errorCompra;
            // },
            frmCompra(){
                this.listado = 1;
                this.selectProveedor();
                this.selectFormaP();
            },
        },
        mounted() {
            this.usuarioAuth();
            this.selectTienda();
            this.selectProveedor();
            this.selectFormaP();
            this.selectTipoP();
            this.verificarCaja();

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
