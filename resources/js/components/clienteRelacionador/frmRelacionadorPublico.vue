<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                &nbsp;
                    <div class="card">
                    <div class="card-header text-center text-white" style="background-color: #3399FF"><h3 class="mb-0">LISTA DE CLIENTES</h3></div>
                <!-- Listado de Ventas -->
                <template v-if="listado==0">           
                    <div class="card-body">
                        <div class="form-group row" style='margin-left: 1%'>   
                            <form class="row">
                                <p style="font-size: 14px;"> <b>Nro. Cantidad Ingreso: <a>{{this.cantidad_cliente['total'] ? parseFloat(this.cantidad_cliente['total']) : 0}}</a></b></p>                                         
                                <div class="input-group mb-3">
                                    <input class="form-control"
                                            type="search"
                                            placeholder="Buscar nombre..."
                                            aria-label="Search"
                                            v-model="buscar"
                                            @keyup="ClienteR">
                                    <button type="button" class="btn btn-info position-relative text-white" @click="ActualizarCliente1()">Actualizar
                                        
                                    </button>
                                    </div>

                                    <div class="col-md-12"  style="overflow-y: auto; height: 480px;">
                                    <div clas="table-responsive">
                                    <table class="table">
                                            <thead class="bg-negro">
                                                <tr>
                                                    <!-- <th scope="col">Nro</th> -->
                                                    <th class="text-white" scope="col" style="font-size: 9px;">Cliente</th>
                                                    <!-- <th scope="col" style="font-size: 9px;">Fecha</th> -->
                                                    <th class="text-white" scope="col" style="font-size: 9px;">Relacionador</th>
                                                    <th class="text-white" scope="col" style="font-size: 9px;">Asistencia</th>
                                                    <th class="text-white" scope="col" style="font-size: 9px;">Acompañantes</th>
                                                    <th class="text-white" scope="col" style="font-size: 9px;">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                <tr v-for="cliente in arrayClienteR" :key="cliente.id">
                                                    <!-- <td v-text="cliente.nro"></td> -->
                                                    <td :class="cliente.Asistencia==1 ? 'bg-rojo' : ''" v-text="cliente.Cliente" style="font-size: 9px;"></td>
                                                    <!-- <td v-text="cliente.Fecha" style="font-size: 9px;"></td> -->
                                                    <td :class="cliente.Asistencia==1 ? 'bg-rojo' : ''" v-text="cliente.Nombre" style="font-size: 9px;"></td>
                                                    <td :class="cliente.Asistencia==1 ? 'bg-rojo' : ''">                       
                                                    <template v-if="cliente.Asistencia==0">
                                                        <span @click="agregarCantidad1(cliente.Id_Cliente,cliente.Cliente,cliente.Cantidad)" class="badge bg-danger" style="font-size: 9px;" >X</span>
                                                    </template>
                                                    <template v-else>
                                                        <!-- <span @click="asistencia(cliente.Id_Cliente)" class="badge bg-success" style="font-size: 9px;" >SI</span> -->
                                                        <span @click="agregarCantidad1(cliente.Id_Cliente,cliente.Cliente,cliente.Cantidad)" class="badge bg-negro" style="font-size: 9px;" >X</span>
                                                    </template>


                                                    </td> 
                                                    <td v-text="cliente.Cantidad" style="font-size: 9px;" :class="cliente.Asistencia==1 ? 'bg-rojo' : ''"></td>
                                                    <td :class="cliente.Asistencia==1 ? 'bg-rojo' : ''">
                                                        <template v-if="cliente.Asistencia==0">
                                                            <button type="button" @click="agregarCantidad(cliente.Id_Cliente,cliente.Cliente)" class="btn btn-outline-success btn-sm" style="font-size: 9px; width: 70px;">Asistencia</button>
                                                            <button type="button" @click="asistencia(cliente.Id_Cliente)" class="btn btn-outline-primary btn-sm" style="font-size: 9px; width: 55px;">Mesa</button>
                                                        </template>
                                                        <template v-else>
                                                            <button type="button" @click="agregarCantidad(cliente.Id_Cliente,cliente.Cliente)" class="btn btn-outline-dark btn-sm" style="font-size: 9px; width: 70px;">Asistencia</button>
                                                            <button type="button" @click="asistencia2(cliente.Id_Cliente)" class="btn btn-outline-dark btn-sm" style="font-size: 9px; width: 55px;">Mesa</button>
                                                        </template>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                </form>   
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
                    cliente : '',

                },  
                arrayClienteR:[],
                cantidad_cliente:0,
                usuario_id:0,
                buscar : '',
                listado:0,
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
            ClienteR(){
                let me = this;
                me.listado = 0;
                me.datos.cliente = '';
                var url='/cliente/relacionador?filtro='+me.buscar;
                axios.get(url).then(function(response){
                    me.arrayClienteR = response.data;
                    me.CantidadCliente();
                    //me.datos.id_cliente=response.data[0].Id_Cliente;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            CantidadCliente(){
                let me=this;
                var url='/CantidadCliente';
                axios.get(url).then(function(response){
                    me.cantidad_cliente=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            agregarCantidad(id,cantidad){
                Swal.fire({
                    
                    html: '<h2><b>' + cantidad + '</b></h2>' +'\n'+'<h3>Ingrese la cantidad de acompañantes?</h3>' ,
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 1

                    },
                  
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {

                        // if((cant==this.datos.cantidad)  || cant==''){
                        //     Swal.showValidationMessage(
                        //         `Cantidad invalida :)`
                        //     )
                        // }else{
                            axios.put('/cantidad?Id_Cliente='+id+'&Cantidad='+cant+'&Cliente='+cantidad);
                        //}
                        // me.Actualizar();
                    },
                    }).then((result) => {
                        //me.Actualizar();
                        if (result.isConfirmed) {
                            this.ClienteR();
                            this.ActualizarCliente();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Acompañante registrado...',
                                showConfirmButton: false,
                                timer: 500
                            });
                        }
                                this.ActualizarCliente();
                })
               // me.Actualizar();
            },
            agregarCantidad1(id,cantidad,cantidad2){
                Swal.fire({
                    
                    html: '<h2><b>' + cantidad + '</b></h2>' +'\n'+'<h3>Eliminar la cantidad de acompañantes?</h3>' ,
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 1

                    },
                  
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {

                        if(((cantidad2 - cant) < 0)  || cant==''){
                            Swal.showValidationMessage(
                                `Cantidad invalida :)`
                            )
                        }else{
                            axios.put('/cantidad1?Id_Cliente='+id+'&Cantidad='+cant+'&Cliente='+cantidad);
                        }
                        // me.Actualizar();
                    },
                    }).then((result) => {
                        //me.Actualizar();
                        if (result.isConfirmed) {
                            this.ClienteR();
                            this.ActualizarCliente();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Acompañante eliminado...',
                                showConfirmButton: false,
                                timer: 500
                            });
                        }
                                this.ActualizarCliente();
                })
               // me.Actualizar();
            },
            ActualizarCliente(){
                let me = this;
                 me.ClienteR(); 
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: 'Sistema Actualizado...',
                //     showConfirmButton: false,
                //     timer: 2000
                // });
            },
            ActualizarCliente1(){
                let me = this;
                 me.ClienteR(); 
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Sistema Actualizado...',
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            asistencia(id){
                
                Swal.fire({
                    title: 'Esta seguro de realizar esta acción?',
                    html: "No puede revertir esta acción",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00C055',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, aceptar!',
                    cancelButtonText: 'No, cancelar!',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        //  var url='/cliente/asistencia?Id_Cliente='+id;

                        axios.put('/mesa',{'Id_Cliente': id}).then(function (response) {
                            me.ClienteR();
                            me.ActualizarCliente();
                            Swal.fire(
                                'Mesa cerrada...',
                                '',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });  
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Cancelado!',
                            'Esta venta no ha tenido cambios :)',
                            'error'
                        )
                    }
                }) 
            },
            asistencia2(id){
                
                Swal.fire({
                    title: 'Esta seguro de realizar esta acción?',
                    html: "No puede revertir esta acción",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00C055',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, aceptar!',
                    cancelButtonText: 'No, cancelar!',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        //  var url='/cliente/asistencia?Id_Cliente='+id;

                        axios.put('/mesa2',{'Id_Cliente': id}).then(function (response) {
                            me.ClienteR();
                            me.ActualizarCliente();
                            Swal.fire(
                                'Mesa activa...',
                                '',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });  
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Cancelado!',
                            'Esta venta no ha tenido cambios :)',
                            'error'
                        )
                    }
                }) 
            },
        },
        mounted() {
            this.ClienteR(); 
            this.CantidadCliente(); 
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

    .bg-blue{
     background-color: 	#E13F82 !important;
    }
    .bg-rojo{
     background-color: 	#FFD2D6 !important;
     /* color: white !important; */
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