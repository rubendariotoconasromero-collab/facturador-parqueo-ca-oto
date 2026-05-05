<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                &nbsp;
                    <div class="card">
                    <div class="card-header text-center text-white" style="background-color: #3399FF"><h3 class="mb-0">RELACIONADOR</h3></div>
                        <!-- Listado de Ventas -->
                        <template v-if="listado==0">
                            <div class="card-body">
                                <div class="form-group row" style='margin-left: 1%'>   
                                <form class="row">
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Cliente</label>
                                        <input type="text" class="form-control"  v-model="datos.nombre">  
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1" class="form-label">Relacionador</label>
                                        <div class="input-group mb-6">
                                            <input type="text" readonly class="form-control"   v-model="this.usuario_id['personal']" aria-label="Buscar Productos.." aria-describedby="button-addon2">
                                            &nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Fecha</label>
                                        <input type="date" class="form-control"  v-model="datos.fecha" >  
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label">Cantidad</label>
                                        <input type="number" class="form-control"  v-model="datos.cantidad">  
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword1" class="form-label"></label>
                                        <input class="form-control" type="search" placeholder="Buscar nombre..." aria-label="Search" v-model="buscar" @keyup="ClienteR(datos.id_personal)"> 
                                    </div>
                                    <div class="col-md-6">
                                        &nbsp;
                                        <p> <b> Total Registros: <a>{{this.contador_id['registro']? parseFloat(this.contador_id['registro']) : 0}}</a></b></p>

                                        <!-- <p> <b> Total Venta Transferencia: <a>{{this.usuario_id2['total']}} Bs.</a></b></p>    -->
                                    </div>&nbsp;
                                    
                                    <div class="col-md-12"> 

                        <div class="row justify-content-center"  style="overflow-y: auto; height: 200px;">
                           <div clas="table-responsive">
                           <table class="table">
                                <thead  class="bg-negro">
                                    <tr>
                                        <!-- <th scope="col">Nro</th> -->
                                        <th class="text-white" scope="col" style="font-size: 9px;"><strong>Cliente </strong></th>
                                        <th class="text-white" scope="col" style="font-size: 9px;"><strong>Relacionador</strong></th>
                                        <th class="text-white" scope="col" style="font-size: 9px;"><strong>Fecha</strong></th>
                                        <th class="text-white" scope="col" style="font-size: 9px;"><strong>Cantidad</strong></th>
                                        <th class="text-white" scope="col" style="font-size: 9px;"><strong>Estado</strong></th>
                                        <th class="text-white" scope="col" style="font-size: 9px;"><strong>Opciones</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="personal in arrayPersonalT" :key="personal.id">
                                        <!-- <td v-text="personal.nro"></td> -->
                                        <td v-text="personal.Cliente" style="font-size: 9px;"></td>
                                        <td v-text="personal.nombre" style="font-size: 9px;"></td>
                                        <td v-text="personal.fecha" style="font-size: 9px;"></td>
                                        <td v-text="personal.cantidad" style="font-size: 9px;"></td>
                                        <td>
                                        <template v-if="personal.eliminado!=0">
                                            <span class="badge bg-danger" style="font-size: 9px;">NO</span>
                                        </template>
                                        <template v-else>
                                            <span class="badge bg-success" style="font-size: 9px;" >SI</span>
                                        </template>
                                        </td> 
                                        <td>
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Accion</button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#" @click="editarArticulo(personal)"><i class="fa fa-edit text-warning"></i> Modificar</a></li>
                                                <template v-if="personal.eliminado==1">
                                                <li><a class="dropdown-item" href="#" @click="desactivarCliente(personal.id)"><i class="fa fa-unlock text-success"></i> Desactivar</a></li>
                                            </template>
                                            <template v-else>
                                                <li><a class="dropdown-item" href="#" @click="activarCliente(personal.id)"><i class="fa fa-lock text-danger"></i> Activar</a></li>
                                            </template>
                                            </ul>
                                        </td>  
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>     

                                </form>   
                                </div>
                                <br>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end" style='width:96%;margin-left: 2.2%'>
                                    <button class="btn btn-danger me-md-2 text-white" type="button" @click="volverVentaListado()">Cancelar</button>
                                        <button class="btn btn-info btn-lg text-white" v-if="tipoAccion==1"  type="button" @click="guardarClienteRelacionador()">Guardar</button>
                                        <button class="btn btn-info btn-lg text-white" v-if="tipoAccion==2"  type="button" @click="modificarArticulo()">Modificar</button>
                                <!-- <button class="btn btn-info btn-lg text-white" v-if="tipoAccion==1" type="button" @click="guardarClienteRelacionador()">Guardar</button> -->
                                </div>
                            </div>
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
                    nombre : '',
                    fecha :  moment().format('YYYY-MM-DD'),
                    cantidad : 0,
                    asistencia : 0,
                    estado : 0,
                    eliminado : 0,
                    id_personal : 0,
                    personal : '',

                },  
                contador_id:0,
                usuario_id:0,
                arrayVenta : [],
                arrayDetalle : [],
                arrayArticulo : [],
                arrayDetalleProducto : [],
                arrayProductoPaquete: [],
                //arrayDetallePaqueteProducto : [],
                arrayCliente: [],
                arrayCostoPago: [{id:1,nombre:'Unitario'},{id:2,nombre:'Mayorista'},{id:3,nombre:'Preferencial'}],
                arrayTipoCliente: [],
                arrayPersonal: [],
                arrayPersonalT: [],
                arrayPago: [],
                arrayForma: [],
                arrayForma2: [],
                arrayOrden : [],  
                arrayPaquete : [],  
                listado : 0,
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
                buscar : '',
                buscarP : '',
                isDisabled: true,
                isDisabledCliente: false,
                isDisabledProducto: false,
                isDisabledOrden: false,
                isDisabledPaquete: false,
                setTimeoutBuscador: '',
                isVisible: false,
                buscarPersonal: '',
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
            filteredPersonal(){
                const data = this.buscarPersonal.toLowerCase();
                if(this.buscarPersonal == ""){
                    return this.arrayCliente;
                }
                return this.arrayCliente.filter((item)=>{
                    return Object.values(item).some((word=>String(word).toLowerCase().includes(data)))
                })
            }
        },
        methods : {
            usuarioID(){
                let me=this;
                var url='/personal_id'
                axios.get(url).then(function(response){
                    me.usuario_id=response.data;
                    me.datos.personal= me.usuario_id['personal'];
                    me.datos.id_personal= me.usuario_id['id_personal'];
                    //me.datos.id_personal=response.data[0].id_personal;
                    me.ClienteR(me.usuario_id['id_personal']);
                    me.contador(me.usuario_id['id_personal']);
                })
                .catch(function(error){
                    console.log(error)

                });                
            },
            ClienteR(personal){
                let me = this;
                me.listado = 0;
                //me.usuario_id();
                this.tipoAccion = 1;
                 me.datos.cliente = '';
                ///var url='/cliente/relacionador2?filtro='+me.buscar;
                // var url='/cliente/relacionador2?id_personal='+me.datos.id_usuario+filtro + ='+me.buscar;
                // var url='/cliente/relacionador2?id_personal=' + personal;
                var url='/cliente/relacionador2?id_personal=' + personal + '&filtro=' + me.buscar;


                axios.get(url).then(function(response){
                    me.arrayPersonalT = response.data;
                    me.contador(me.datos.id_personal);


                    //me.datos.id_cliente=response.data[0].Id_Cliente;
                })
                .catch(function(error){
                    console.log(error)
                });
            },

            contador(personal){
                let me=this;
                 //var url='/cliente/relacionador/contador';
                var url='/cliente/relacionador/contador2?id_personal='+ personal;
                axios.get(url).then(function(response){
                    me.contador_id=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            volverVentaListado(){
                let me = this;
                me.arrayDetalle = [];
                me.arrayArticulo = [];
                me.listado = 0;
                me.ClienteR(me.datos.id_personal);
                me.isDisabledCliente = false;
                me.isDisabledProducto = false;
                me.isDisabledPaquete = false;
                me.isDisabledOrden = false;
                me.buscar = '';
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
            selectCliente(){
                let me=this;
                var url='/personal/selectPersonal';
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
            // guardarClienteRelacionador(){
            //     if(this.arrayDetalle.length<=0){
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Error...',
            //             text: 'No Existe Productos agregados!'
            //         })
            //     }
            //     if(this.datos.cliente == ''){
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Error...',
            //             text: 'Debe Agregar un Cliente!'
            //         })
            //     }
            //     if(this.arrayDetalle.find(seg => (seg.stock - seg.cantidad < 0 && this.datos.tipo_venta!='Venta Servicio'))){
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Error...',
            //             text: 'No hay stock para el producto!'
            //         })
            //     } else {
            //         if(this.arrayProductoPaquete.find(seg => (seg.stock - seg.cantidad_aux < 0 && seg.tipo_producto == 'Producto Venta'))){
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: 'Error...',
            //                 text: 'No hay stock para el paquete!'
            //             })
            //         } else {
            //             if(this.datos.total < 0){
            //                 Swal.fire({
            //                     icon: 'error',
            //                     title: 'Error...',
            //                     text: 'El total no puedes ser Negativo!'
            //                 })
            //             } else {
            //                 let me = this;
            //                 axios.post('/venta/guardar_tienda1',{
            //                     'id_servicio': me.datos.id,
            //                     'fecha': me.datos.fecha,
            //                     'fecha_final': me.datosPago.fecha_final,
            //                     'sub_total': me.datos.sub_total,
            //                     'descuento': me.datos.descuento,
            //                     'total': me.datos.total,
            //                     'estado': me.datos.estado,
            //                     'id_cliente': me.datos.id_cliente,
            //                     'id_tipo_pago': me.datos.id_tipo_pago,
            //                     'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
            //                     'id_costo_pago': me.datos.id_descuento,
            //                     'detalle': me.arrayDetalle,
            //                     'monto_total': me.datos.total,
            //                     'descripcion_pago': me.datosPago.descripcion,
            //                     'saldo': me.datosPago.saldo,
            //                     'tipo_venta': me.datos.tipo_venta,
                                
            //                     'stock_producto_paquete': me.arrayProductoPaquete,
            //                 }).then(function(response){
            //                     Swal.fire({
            //                         position: 'top-end',
            //                         icon: 'success',
            //                         title: 'Venta registrado exitosamente',
            //                         showConfirmButton: false,
            //                         timer: 1500
            //                     });
            //                     me.cargarPdf2();
            //                     me.volverVentaListado();
            //                     me.limpiarDatosVenta();
            //                     console.log(me.datos);
            //                 })
            //                 .catch(function(error){
            //                     console.log(error);
            //                 });
            //             }
                        
            //         }
            //     }
                
            // },  
            async guardarClienteRelacionador(){
                try {
                    let me = this;
                    const res = await axios.post('/cliente/relacionador/guardar',this.datos);
                        //me.usuario_id();
                        me.datos.nombre='';
                        me.datos.cantidad=0;
                        me.datos.fecha = moment().format('YYYY-MM-DD'),
                        me.ClienteR(me.datos.id_personal);
                        me.contador(me.datos.id_personal);
                        // me.registrosCargo();
                        // me.listarCargo(1, '', 'nombre');   
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Registro agregado...',
                            showConfirmButton: false,
                            timer: 1500
                        })
                      me.limpiarDatosPersonal();
                } catch (error) {
                    if(error.response.data){
                        this.errores=error.response.data.errors;
                    }
                }
            }, 
            async modificarArticulo(){
                try {
                    let me = this;
                    const res = await axios.put('/cliente/relacionador/modificar',me.datos);
                        me.datos.nombre='';
                        me.datos.cantidad=0;
                        me.datos.fecha = moment().format('YYYY-MM-DD'),
                        me.ClienteR(me.datos.id_personal);
                        me.contador(me.datos.id_personal);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Registro modificado...',
                            showConfirmButton: false,
                            timer: 1500
                        }) 

                       //me.limpiarDatosPersonal(); 
                     
                } catch (error) {
                    if(error.response.data){
                        this.errores=error.response.data.errors;
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
                this.selectCliente();
                this.selectTipoP();
                this.selectFormaP();        
            },
            desactivarCliente(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Inhabilitar este Cliente??',
                    text: "Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Inhabilitar!', 
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/cliente/relacionador/desactivar',{'id': id}).then(function (response) {
                        //me.usuario_id();
                        me.ClienteR(me.datos.id_personal);
                        swalWithBootstrapButtons.fire(
                        'Inhabilitado!',
                        'Este cliente se ha Inhabilitado.',
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
            activarCliente(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Habilitar este Personal??',
                    text: "Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Habilitar!',

                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/cliente/relacionador/activar',{'id': id}).then(function (response) {
                        me.ClienteR(me.datos.id_personal);
                        // me.ClienteR(id);
                        swalWithBootstrapButtons.fire(
                        'Habilitado!',
                        'Este cliente se ha Habilitado.',
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
            this.usuarioID();
            this.selectCliente();
            this.selectTipoP();
            this.selectFormaP(); 
           // this.ClienteR(); 
           // this.verificarCaja();
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

    .bg-negro{
     background-color: 	#000000 !important;
     /* color: white !important; */
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