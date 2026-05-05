<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                    <div class="card">
                  
                    <template v-if="listado==0">
                        <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 col-md-11 text-uppercase">MENU DEL DIA</h3>
                                <button type="button" class="btn-close btn-close-white" @click="volverMesa()" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="card-body">
                        <div class="form-group row" style='margin-left: 1%'>
                         <div class="container">
                            <div class="row row-cols-2" >
                                <div class="col">
                                    <form class="row row-cols-2 row-cols-md-2 g-2">
                                        <div class="col-md-12 p-2">
                                            <!-- <div class="col-md-12 p-2 border border-black"> -->
                                                <div class="form-group row" style='margin-left:1%'>
                                                    <form class="row" >
                                                        <div class="col-md-6">
                                                        </div>&nbsp;
                                                        <div class="col-md-12">
                                                            <div>
                                                                <strong>PRODUCTO EN GENERAL</strong>
                                                            </div>
                                                            &nbsp;
                                                            <input type="text" v-model="nombre" @keyup.enter="listarArticulo(nombre)" @keyup="BuscandoProducto()" class="form-control" placeholder="Texto a buscar" style='font-size: 0.7rem'>

                                                            <!-- <input class="form-control" v-model="datos.observacion" rows="2" placeholder="Descripcion"></input> -->
                                                        </div>
                                                    </form>
                                                    <div class="col-md-12">
                                                        <div v-show="errorPago" class="form-group row div-error">
                                                            <div class="text-center text-error">
                                                                <div v-for="error in errorMostrarMsjPago" :key="error" v-text="error">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                <div class="col-md-12" >
                                    <div class="form-group row" style='overflow-y: auto; height: 500px;'>
                                    <div class="table-responsive">
                                    <table class="table table-striped table-hover" style='width:96%;margin-left: 3%'>
                                        <thead style="background-color: #46546C">
                                            <th scope="col" class="text-white" style="font-size: 1rem;" >Opcion</th>
                                            <th scope="col" class="text-white" style="font-size: 0.9rem; " width="15%">Producto</th>
                                            <!-- <th scope="col" class="text-white" style="font-size: 0.9rem;" width="15%">Costo</th> -->
                                            <!-- <th scope="col" class="text-white" style="font-size: 0.9rem;">Cantidad</th>
                                            <th scope="col" class="text-white" style="font-size: 0.9rem;">SubTotal</th> -->
                                        </thead>
                                        <tbody>
                                            <tr v-for="producto in arrayArticulo1" :key="producto.id">
                                                <td>
                                               <button type="button" @click="seleccionarTiendaArticulo(producto)" class="btn btn-success btn-sm"><i class="fa fa-check text-white"></i></button>
                                                </td>
                                                <!-- <template v-if="detalle.id_tipo_producto == 5">
                                                <td>
                                                    <button @click="eliminarDetalle(index),encuentraProductoCombo2Delete(detalle.id_articulo)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white" ></i></button>
                                                 </td>
                                                </template>
                                                <template v-else>
                                                <td>
                                                    <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white" ></i></button>
                                                </td>
                                                </template> -->
                                                <td v-text="producto.nombre" style="font-size: 0.8rem;vertical-align: top"></td>
                                                <!-- <td v-text="producto.menu_dia" style="font-size: 0.8rem;vertical-align: top"></td> -->
                                                <!-- <td style="font-size: 0.8rem;">
                                                    {{producto.costo_venta = isNaN(producto.costo_venta)? 0 : parseFloat(producto.costo_venta).toFixed(2)}}
                                                </td> -->

                                                <!-- <td >

                                                    <div>
                                                    <template v-if="detalle.Estado == 0">
                                                        <input v-model="detalle.cantidad" type="number"  value="3" class="form-control"  min="0" style="font-size: 0.8rem" @keyup="contadorStock(detalle)" disabled>
                                                    </template>
                                                    <template v-else>
                                                        <input v-model="detalle.cantidad" type="number"  value="3" class="form-control"  min="0" style="font-size: 0.8rem" @keyup="contadorStock(detalle)">
                                                    </template>
                                                    </div>
                                                    <span style="color:red;font-size: 0.4rem;vertical-align: top;" v-show="detalle.descuento_stock>parseFloat(detalle.stock)" >Stock: {{detalle.stock}} </span>
                                                </td> -->
                                                <!-- <td style="font-size: 0.8rem">
                                                    {{detalle.sub_total = (isNaN(detalle.costo_venta*detalle.cantidad))? 0 : (detalle.costo_venta*detalle.cantidad).toFixed(2)}}
                                                </td> -->
                                            </tr>
                                            <!-- <tr style="background-color: #e5f5fd">
                                                <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Sub Total:</strong> </td>
                                                <td style="font-size: 0.8rem;">{{datos.sub_total = isNaN(calcularSubTotal) ? 0 : calcularSubTotal.toFixed(2)}} bs</td>
                                            </tr> -->
                                            <!-- <tr style="background-color: #e5f5fd">
                                                <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Descuento:</strong> </td>
                                                <td style="font-size: 0.8rem;">
                                                    <input v-model="datos.descuento" type="number" min="0" value="0" class="form-control" >
                                                </td>
                                            </tr> -->
                                            <!-- <tr style="background-color: #e5f5fd">
                                                <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Total:</strong> </td>
                                                <td style="font-size: 0.8rem;">{{datos.total = datos.sub_total- datos.descuento}} bs</td>
                                            </tr> -->
                                            <!-- <template v-if="datos.id_forma_pago ==6">
                                                    <tr style="background-color: #CEECF5">
                                                        <td colspan="4" align="right"  style="font-size: 0.8rem;"> <strong>Total Efect.:</strong> </td>
                                                        <td>
                                                            <input v-model="datos.total_efectivo" value="0" class="form-control"  style="font-size: 0.8rem;">
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #CEECF5">
                                                        <td colspan="4" align="right"  style="font-size: 0.8rem;"> <strong>Total Dep.:</strong> </td>
                                                        <td  style="font-size: 0.8rem;">{{datos.total_deposito = datos.total- datos.total_efectivo}} bs</td>
                                                    </tr>
                                                    <tr style="background-color: #FF6775">
                                                        <td colspan="4" align="right" class="text-white"> <strong>Efectivo:</strong> </td>
                                                        <td>
                                                            <input v-model="datos.efectivo" value="0" class="form-control" min="0">
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FF6775">
                                                        <td colspan="4" align="right" class="text-white"> <strong>Cambio:</strong> </td>
                                                        <template v-if="datos.efectivo != 0">
                                                            <td class="text-white"> {{datos.cambio = datos.efectivo- datos.total_efectivo}} bs</td>
                                                        </template>
                                                        <template v-else>
                                                            <td class="text-white">{{datos.cambio = datos.efectivo- 0}}</td>
                                                        </template>
                                                    </tr>
                                            </template>
                                            <template v-else>
                                                    <tr style="background-color: #FF6775">
                                                        <td colspan="4" align="right" class="text-white"> <strong>Efectivo:</strong> </td>
                                                        <td>
                                                            <input v-model="datos.efectivo"  value="0" min="0" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FF6775">
                                                        <td colspan="4" align="right" class="text-white"> <strong>Cambio:</strong> </td>
                                                        <template v-if="datos.efectivo != 0">
                                                            <td class="text-white"> {{datos.cambio = datos.efectivo- datos.total}} bs</td>
                                                        </template>
                                                        <template v-else>
                                                            <td class="text-white">{{datos.cambio = datos.efectivo- 0}}</td>
                                                        </template>
                                                    </tr>
                                            </template> -->
                                        </tbody>
                                        <!-- <tbody v-else>
                                            <tr>
                                                <td colspan="5" style="font-size: 0.8rem;">No hay Producto agregados</td>
                                            </tr>
                                        </tbody> -->
                                    </table>
                                    </div>
                                </div>


                                </div>

                                </form>
                                <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-end p-2" style="width:96%;margin-left: 2.2%">
                                        <button class="btn bg-info text-white" type="button" @click="guardarVentaDirecta()">Guardar</button>
                                    </div> -->
                                </div>
                                <div class="col">
                                    <form class="row row-cols-2 row-cols-md-2 g-2">
                                        <div class="col-md-12 p-2">
                                            <!-- <div class="col-md-12 p-2 border border-black"> -->
                                                <div class="form-group row" style='margin-left:1%'>
                                                    <form class="row" >
                                                        <div class="col-md-6">
                                                        </div>&nbsp;
                                                        <div class="col-md-12">
                                                            <div>
                                                                <strong>MENU DEL DIA</strong>
                                                            </div>
                                                            &nbsp;
                                                            <input type="text" v-model="nombre1" @keyup.enter="listarArticulo1(nombre1)" @keyup="BuscandoProducto1()" class="form-control" placeholder="Texto a buscar" style='font-size: 0.7rem; '>

                                                        </div>
                                                    </form>
                                                    <div class="col-md-12">
                                                        <div v-show="errorPago" class="form-group row div-error">
                                                            <div class="text-center text-error">
                                                                <div v-for="error in errorMostrarMsjPago" :key="error" v-text="error">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                <div class="col-md-12" >
                                    <div class="form-group row" style='overflow-y: auto; height: 500px;'>
                                    <div class="table-responsive">
                                    <table class="table table-striped table-hover" style='width:96%;margin-left: 3%'>
                                        <thead style="background-color: #46546C">
                                            <th scope="col" class="text-white" style="font-size: 1rem;" >Opcion</th>
                                            <th scope="col" class="text-white" style="font-size: 0.9rem; " width="15%">Producto</th>
                                            <!-- <th scope="col" class="text-white" style="font-size: 0.9rem;" width="15%">Costo</th> -->
                                            <!-- <th scope="col" class="text-white" style="font-size: 0.9rem;">Cantidad</th>
                                            <th scope="col" class="text-white" style="font-size: 0.9rem;">SubTotal</th> -->
                                        </thead>
                                        <tbody>
                                            <tr v-for="detalle in arrayArticulo2" :key="detalle.id">
                                                <template v-if="detalle.id_tipo_producto == 5">
                                                <!-- <td>
                                                    <button @click="eliminarDetalle(index),encuentraProductoCombo2Delete(detalle.id_articulo)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white" ></i></button>
                                                 </td> -->
                                                </template>
                                                <template v-else>
                                                <td>
                                                    <button type="button" @click="seleccionarTiendaArticulo2(detalle)" class="btn btn-success btn-sm"><i class="fa fa-check text-white"></i></button>
                                                </td>
                                                </template>
                                                <td v-text="detalle.nombre" style="font-size: 0.8rem;vertical-align: top"></td>
                                                <!-- <td v-text="detalle.menu_dia" style="font-size: 0.8rem;vertical-align: top"></td> -->
                                                <!-- <td style="font-size: 0.8rem;">
                                                    {{detalle.costo_venta = isNaN(detalle.costo_venta)? 0 : parseFloat(detalle.costo_venta).toFixed(2)}}
                                                </td> -->

                                                <!-- <td >

                                                    <div>
                                                    <template v-if="detalle.Estado == 0">
                                                        <input v-model="detalle.cantidad" type="number"  value="3" class="form-control"  min="0" style="font-size: 0.8rem" @keyup="contadorStock(detalle)" disabled>
                                                    </template>
                                                    <template v-else>
                                                        <input v-model="detalle.cantidad" type="number"  value="3" class="form-control"  min="0" style="font-size: 0.8rem" @keyup="contadorStock(detalle)">
                                                    </template>
                                                    </div>
                                                    <span style="color:red;font-size: 0.4rem;vertical-align: top;" v-show="detalle.descuento_stock>parseFloat(detalle.stock)" >Stock: {{detalle.stock}} </span>
                                                </td> -->
                                                <!-- <td style="font-size: 0.8rem">
                                                    {{detalle.sub_total = (isNaN(detalle.costo_venta*detalle.cantidad))? 0 : (detalle.costo_venta*detalle.cantidad).toFixed(2)}}
                                                </td> -->
                                            </tr>
                                            <!-- <tr style="background-color: #e5f5fd">
                                                <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Sub Total:</strong> </td>
                                                <td style="font-size: 0.8rem;">{{datos.sub_total = isNaN(calcularSubTotal) ? 0 : calcularSubTotal.toFixed(2)}} bs</td>
                                            </tr>
                                            <tr style="background-color: #e5f5fd">
                                                <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Descuento:</strong> </td>
                                                <td style="font-size: 0.8rem;">
                                                    <input v-model="datos.descuento" type="number" min="0" value="0" class="form-control" >
                                                </td>
                                            </tr>
                                            <tr style="background-color: #e5f5fd">
                                                <td colspan="4" align="right" style="font-size: 0.8rem;"> <strong>Total:</strong> </td>
                                                <td style="font-size: 0.8rem;">{{datos.total = datos.sub_total- datos.descuento}} bs</td>
                                            </tr> -->
                                            <!-- <template v-if="datos.id_forma_pago ==6">
                                                    <tr style="background-color: #CEECF5">
                                                        <td colspan="4" align="right"  style="font-size: 0.8rem;"> <strong>Total Efect.:</strong> </td>
                                                        <td>
                                                            <input v-model="datos.total_efectivo" value="0" class="form-control"  style="font-size: 0.8rem;">
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #CEECF5">
                                                        <td colspan="4" align="right"  style="font-size: 0.8rem;"> <strong>Total Dep.:</strong> </td>
                                                        <td  style="font-size: 0.8rem;">{{datos.total_deposito = datos.total- datos.total_efectivo}} bs</td>
                                                    </tr>
                                                    <tr style="background-color: #FF6775">
                                                        <td colspan="4" align="right" class="text-white"> <strong>Efectivo:</strong> </td>
                                                        <td>
                                                            <input v-model="datos.efectivo" value="0" class="form-control" min="0">
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FF6775">
                                                        <td colspan="4" align="right" class="text-white"> <strong>Cambio:</strong> </td>
                                                        <template v-if="datos.efectivo != 0">
                                                            <td class="text-white"> {{datos.cambio = datos.efectivo- datos.total_efectivo}} bs</td>
                                                        </template>
                                                        <template v-else>
                                                            <td class="text-white">{{datos.cambio = datos.efectivo- 0}}</td>
                                                        </template>
                                                    </tr>
                                            </template>
                                            <template v-else>
                                                    <tr style="background-color: #FF6775">
                                                        <td colspan="4" align="right" class="text-white"> <strong>Efectivo:</strong> </td>
                                                        <td>
                                                            <input v-model="datos.efectivo"  value="0" min="0" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FF6775">
                                                        <td colspan="4" align="right" class="text-white"> <strong>Cambio:</strong> </td>
                                                        <template v-if="datos.efectivo != 0">
                                                            <td class="text-white"> {{datos.cambio = datos.efectivo- datos.total}} bs</td>
                                                        </template>
                                                        <template v-else>
                                                            <td class="text-white">{{datos.cambio = datos.efectivo- 0}}</td>
                                                        </template>
                                                    </tr>
                                            </template> -->
                                        </tbody>
                                        <!-- <tbody v-else>
                                            <tr>
                                                <td colspan="5" style="font-size: 0.8rem;">No hay Producto agregados</td>
                                            </tr>
                                        </tbody> -->
                                    </table>
                                    </div>
                                </div>


                                </div>

                                </form>
                                <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-end p-2" style="width:96%;margin-left: 2.2%">
                                        <button class="btn bg-info text-white" type="button" @click="guardarVentaDirecta()">Guardar</button>
                                    </div> -->
                                </div>
                            </div>
                            </div>
                        </div>
                                    </div>
                                    <!-- prueba fin card -->
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
                    fecha :  moment().format('YYYY-MM-DD'),
                    sub_total : 0,
                    descuento : 0,
                    total : 0,
                    id_salon : 0,
                    id_tipo_pago : 1,
                    id_forma_pago : 2,
                    id_cliente : 1,
                    articulo:'',
                    cliente : '',
                    tipoPago : '',
                    formaPago : '',
                    costo_pago : '',
                    id_descuento: '',
                    personal:'',
                    estado:'',
                    tipo_venta: 'Venta Directa',
                    id_orden_servicio: null,
                    usuario:'',
                    id_mesa: 0,
                    mesa :'',
                    total_efectivo : 0,
                    total_deposito: 0,
                    efectivo :0,
                    cambio :0,
                },
                datosPago:{
                    id: 0,
                    fecha :  moment().format('YYYY-MM-DD'),
                    fecha_final : moment().format('YYYY-MM-DD'),
                    //monto_total: 0,
                    saldo : 0,
                    anticipo : 0,
                    descripcion: '',
                },
                arrayVenta : [],
                arrayCategoria : [],
                arrayProducto : [],
                arraySalon : [],
                arrayMesa : [],
                arrayDetalle : [],
                arrayArticulo : [],
                arrayArticulo1:[],
                arrayArticulo2:[],
                arrayDetalleProducto : [],
                arrayProductoPaquete: [],
                //arrayDetallePaqueteProducto : [],
                arrayCliente: [],
                arrayCostoPago: [{id:1,nombre:'Unitario'},{id:2,nombre:'Mayorista'},{id:3,nombre:'Preferencial'}],
                arrayTipoCliente: [],
                arrayPersonal: [],
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
                criterioP : 'articulo.nombre',
                buscar : '',
                // nombre : '',
                buscarP : '',
                isDisabled: true,
                isDisabledCliente: false,
                isDisabledProducto: false,
                isDisabledOrden: false,
                isDisabledPaquete: false,
                setTimeoutBuscador: '',
                setTimeoutBuscador2: '',
                isVisible: false,
                buscarCliente: '',
                estadoCaja: '',
                cantidad_producto : 0,
                usuario_nombre:0,
                listadoMenu: 0,
                arrayDetalleSimpleAux :[],
                arrayDetalleSimple :[],
                arrayDetalleProductoSimple :[],
                arrayDetalleAux:[],
                arrayDetalleCompuesto:[],
                arrayDetalleProductoCompuesto:[],
                id_combo : '',
                id_combo2 : '',
                arrayDetalleCombo : [],
                arrayDetalleProductoCombo : [],
                arrayDetalleElaboradoAux : [],
                arrayDetalleElaborado : [],
                arrayDetalleProductoElaborado : [],
                arrayDetalleProductoCombo2 :[],
                is_busy : 0,
                id_salon2 : 0,
                id_venta : 0,
                contrasena_id:0,
                //id_categoria :0,
                nombre :'',
                nombre1 :'',

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
                if(this.datos.tipo_venta=='Venta Directa') {
                    for(var i=0;i<this.arrayDetalle.length;i++){

                        resultado = resultado + (this.arrayDetalle[i].costo_unitario*this.arrayDetalle[i].cantidad);
                    }
                } else {
                    for(var i=0;i<this.arrayDetalle.length;i++){
                        resultado = resultado + (this.arrayDetalle[i].costo_venta*this.arrayDetalle[i].cantidad);
                    }
                }

                return resultado;
            },
            calcularSaldoAnticipado: function(){
                this.datosPago.saldo = this.datos.total - this.datosPago.anticipo;
            },
            filteredCliente(){
                const data = this.datos.cliente.toLowerCase();
                if(this.datos.cliente == ""){
                    return this.arrayCliente;
                }
                return this.arrayCliente.filter((item)=>{
                    return Object.values(item).some((word=>String(word).toLowerCase().includes(data)))
                })
            },
            validarStock(){
                let me = this;
                    //me.listarArticulo('', 'nombre_comercial');
                    me.arrayDetalleProducto.forEach(
                        item => {
                            console.log('Prueba')
                            //item.cantidad_aux = item.cantidad*me.cantidad_producto;

                            me.arrayArticulo.forEach( item2 => {item2.id == item.id_articulo ?  (item2.stock=item2.stock-me.cantidad_producto, console.log('Prueba')) : ''})
                    });
            }

            // actualizarStockProducto(id,cantidad,paquete){
            //     let me = this;

            //     if(paquete == 'Venta Paquete'){
            //         me.arrayProductoPaquete.forEach(item => { item.id_paquete == id ? item.cantidad = item.cantidad*cantidad : ''});
            //     }

            // },
        },
        methods : {
            guardarCliente()
            {
                if(this.datos.cliente !=''){
                    this.datos.id_cliente = 0;
                }else
                {
                    this.datos.id_cliente = 1;
                }

            },
            ocultar(){
                this.isVisible = !(this.isVisible);
                setTimeout(()=> {
                    this.isVisible = false;
                }, 10000);
            },
            contadorStock(detalle)
            {
                var totalCantidad=0;

                //var costo_venta = detalle.costo_venta;
                var id_tipo_producto = detalle.id_tipo_producto;
                var id_producto_compuesto = detalle.id_producto_compuesto;
                var id_producto = detalle.id_articulo;
                var detalle_cantidad = detalle.cantidad;
                var cantidad_presentacion = detalle.cantidad_presentacion;

                if(id_tipo_producto == 2){
                    this.agregarProductoElaborado(id_producto,detalle_cantidad);
                }
                if(id_tipo_producto == 3){
                    this.agregarProductoSimple(id_producto,detalle_cantidad);
                }
                if(id_tipo_producto == 4){
                    this.agregarProductoCompuesto(id_producto_compuesto,detalle_cantidad,cantidad_presentacion);
                }
                if(id_tipo_producto == 5){
                    //this.agregarCombo(id_producto,detalle_cantidad);
                    this.agregarCombo2(id_producto,detalle_cantidad);
                    this.agregarProductoCompuestoCombo(id_producto_compuesto,detalle_cantidad);
                }

                //if(detalle_cantidad >= detalle_cantidad)

                // this.arrayDetalleCombo.forEach(item =>
                //     {
                //         this.arrayProducto.forEach(item2 =>
                //         {
                //             if(item.id_producto == item2.Id_Producto)
                //             {
                //                 item.cantidadAux = item.cantidad
                //                // console.log(item.id_producto,item2.Id_Producto);
                //                //if(item.cantidad >=)
                //                 item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                //                 console.log(item.cantidad);
                //             }
                //         })
                // })
            },
            ventaDirecta()
            {
                let me=this;
                me.listado =0;
                me.is_busy =0;
                me.arrayDetalle = [];
                var url='/categoria2';
                axios.get(url).then(function(response){
                    me.arrayCategoria = response.data;
                })
                .catch(function(error){
                    console.log(error)


                });
            },
            volverMesa(){
                this.listado = 0;
                this.arrayCategoria = [];
                this.arrayProducto = [];
                this.buscar = '';
                // this.datos.id_categoria = 2;
                this.datos.id_mesa = 0;
            },
            listarSalon(){
                let me=this;
                me.id_venta = 0;
                var url='/salon/selectSalon';
                axios.get(url).then(function(response){
                    me.arraySalon=response.data;

                })
                .catch(function(error){
                    console.log(error)
                });
            },
            galMesa(id){
                let me = this;
                // me.is_busy=0;
                me.datos.cliente = '';
                me.arrayDetalle = [];
                me.datos.id_salon= id;
                me.id_salon2= id;
                var url='/mesa2?id_salon='+id;
                axios.get(url).then(function(response){
                    me.arrayMesa = response.data;
                    //me.datos.id_mesa = response.data[0].id;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            galCategoria(mesa){
            let me = this;
                me.is_busy = 0;
                me.datos.cliente = '';
                me.arrayDetalle = [];
                me.listado=1;
                me.datos.id_mesa = mesa.id;
                me.datos.mesa = mesa.nombre;
                var url='/categoria2';
                axios.get(url).then(function(response){
                    me.arrayCategoria = response.data;
                })
                .catch(function(error){
                    console.log(error)


                });
            },
            galCategoriaModificar(mesa){
            let me = this;
                me.listado=3;
                me.datos.id_mesa = mesa.id;
                me.datos.mesa = mesa.nombre;
                var url='/categoria2';
                axios.get(url).then(function(response){
                    me.arrayCategoria = response.data;
                })
                .catch(function(error){
                    console.log(error)


                });
            },
            galProductos(){
                let me = this;
                // me.id_categoria = id;
                var url='/producto1';
                axios.get(url).then(function(response){
                    me.arrayProducto = response.data;
                    //Combo
                    // me.arrayDetalleCombo.forEach(item =>
                    // {
                    //     me.arrayProducto.forEach(item2 =>
                    //     {
                    //         if(item.id_producto == item2.Id_Producto)
                    //         {
                    //            // console.log(item.id_producto,item2.Id_Producto);
                    //             item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                    //             console.log(item.cantidad);
                    //         }
                    //     })
                    // })

                    //Simple
                    // me.arrayDetalleProductoSimple.forEach(item =>
                    // {
                    //     me.arrayProducto.forEach(item2 =>
                    //     {
                    //         if(item.id_producto == item2.Id_Producto)
                    //         {
                    //            // console.log(item.id_producto,item2.Id_Producto);
                    //             item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                    //             console.log(item.cantidad);
                    //         }
                    //     })
                    // })

                    // //Elaborado
                    // me.arrayDetalleProductoElaborado.forEach(item =>
                    // {
                    //     me.arrayProducto.forEach(item2 =>
                    //     {
                    //         if(item.id_producto == item2.Id_Producto)
                    //         {
                    //            // console.log(item.id_producto,item2.Id_Producto);
                    //             item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                    //             console.log(item.cantidad);
                    //         }
                    //     })
                    // })

                })
                .catch(function(error){
                    console.log(error)
                });
            },
            encuentraProductoSimpleDelete(id){
                for(var i=0;i<this.arrayDetalleProductoSimple.length;i++){
                    if(this.arrayDetalleProductoSimple[i].id_producto==id){
                        this.eliminarDetalleProductoSimple(i);
                    }
                }
            },
            encuentraProductoElaboradoDelete(id){
                for(var i=0;i<this.arrayDetalleProductoElaborado.length;i++){
                    if(this.arrayDetalleProductoElaborado[i].id_producto==id){
                        this.eliminarDetalleProductoElaborado(i);
                    }
                }
            },
            encuentraProductoCompuestoDelete(id){
                for(var i=0;i<this.arrayDetalleProductoCompuesto.length;i++){
                    if(this.arrayDetalleProductoCompuesto[i].id_producto==id){
                        this.eliminarDetalleProductoCompuesto(i);
                    }
                }
            },
            encuentraCombo(combo){
                this.arrayDetalleProductoAux = this.arrayDetalleProductoCombo;
                var cont = 0;
                for(var i=0;i<this.arrayDetalleProductoCombo.length;i++){
                    //console.log('cantidad',this.arrayDetalleProductoCombo.length )
                    if(this.arrayDetalleProductoCombo[i].id_combo==combo){
                        cont++;
                    }

                }
                //console.log(cont);


                for(var i=0;i<this.arrayDetalleProductoCombo.length;i++){
                    //console.log('cantidad',this.arrayDetalleProductoCombo.length )
                    if(this.arrayDetalleProductoCombo[i].id_combo==combo){
                        //console.log(this.arrayDetalleProductoCombo,'-',i)
                        this.eliminarDetalleCombo(i,cont);
                        i=0;
                    }

                }


            },
            async encuentraProductoCombo2Delete(id){
            try {
                var url='/combo2?id=' + id;
                const res = await axios.get(url)
                // me.id_receta=(res.data[0].id).toString();
                this.id_combo2=(res.data[0].id).toString();

                var url='/combo/detalleCombo2?id=' + this.id_combo2;
                const res2 = await axios.get(url)
                this.arrayDetalleProductoCombo2=res2.data;
                console.log(id)
                //console.log(this.arrayDetalleProductoCombo2);
                var cont = 0;

                // for(var i=0;i<this.arrayDetalleProductoCombo.length;i++){
                //     //console.log('cantidad',this.arrayDetalleProductoCombo.length )
                //     console.log(this.arrayDetalleProductoCombo[i].id_producto);

                //     for(var j=0;j<this.arrayDetalleProductoCombo2.length;j++){
                //         if(this.arrayDetalleProductoCombo[i].id_combo==id && this.arrayDetalleProductoCombo[i].id_producto == this.arrayDetalleProductoCombo2[j].id_producto)
                //         {
                //             this.eliminarDetalleCombo2(i);
                //         }

                //     }
                // }

                this.arrayDetalleProductoCombo.forEach((item,index1) =>
                {
                    this.arrayDetalleProductoCombo2.forEach((item2,index2) =>
                    {
                        if(item.id_combo==this.id_combo2)
                        // if(item.id_combo==this.id_combo2 && item.id_producto == item2.id_producto)
                        {
                            console.log(item.id_producto);
                            this.eliminarDetalleCombo2(index1);
                        }
                    })
                })
                //console.log('prueba= ',this.arrayDetalleProductoCombo);

            } catch (error) {
                console.log(error);
            }

            },
            eliminarDetalleCombo2(index){
                let me = this;
                me.arrayDetalleProductoCombo.splice(index,1);

            },
            eliminarDetalleCombo(index,cont){
                let me = this;
                this.arrayDetalleProductoCombo.splice(index,cont);

            },
            eliminarDetalleProductoSimple(index){
                let me = this;
                me.arrayDetalleProductoSimple.splice(index,1);
            },
            eliminarDetalleProductoCombo2(index,id_combo){
                let me = this;
                me.arrayDetalleProductoCombo.find( item =>
                {
                    if(item.id_combo == id_combo)
                    {
                        me.arrayDetalleProductoCombo.splice(index,item.cont);
                    }
                });
            },
            eliminarDetalleProductoElaborado(index){
                let me = this;
                me.arrayDetalleProductoElaborado.splice(index,1);
            },
            eliminarDetalleProductoCompuesto(index){
                let me = this;
                me.arrayDetalleProductoCompuesto.splice(index,1);
            },
            encuentraDelete(id){
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id_articulo==id){
                        this.eliminarDetalle(i);

                        //this.galProductos(this.id_categoria);
                    }
                }
            },
            agregarProductoCheck(data=[]){
                let me = this;
                // if(data['id_tipo_producto'] == 5){
                //     me.encuentraDelete(data['Id_Producto'])
                // }
                me.encuentraProductoSimpleDelete(data['Id_Producto'])
                //me.encuentraProductoCombo2Delete(me.id_combo)
                //me.encuentraProductoCombo2Delete(data['Id_Producto'])
                //me.encuentraCombo(data['Id_Producto'])
                Swal.fire({
                    // title: 'Ingrese la cantidad\n'+data['descripcion']+'ㅤ \n'+data['precio']+' bs.',
                    title: 'Mesa N. : '+me.datos.mesa+'\n'+'Ingrese la cantidad \n'+data['descripcion']+'\n'+data['precio']+' bs.',

                    // title: 'Pedido N. : '+me.arrayContador[0].Correlativo+'\n'+'ㅤㅤ'+'Ingrese la cantidad ㅤㅤㅤ \n'+data['descripcion']+'ㅤ \n'+data['precio']+' bs.',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {
                        me.encuentraDelete(data['Id_Producto'])
                    if(cant==0){
                        Swal.showValidationMessage(
                            `Cantidad no puede ser 0`
                        );
                        }else{
                            if(cant <0){
                                    Swal.showValidationMessage(
                                        `Cantidad no puede ser negativo`
                                    );
                                }else{
                                    if(cant == ''){
                                        Swal.showValidationMessage(
                                            `Cantidad esta Vacia`
                                        );
                                    }else{
                                        if((cant>parseInt(data['stock']) || cant=='')&& data['estado'] == 1 && data['id_tipo_producto'] != 5){
                                            Swal.showValidationMessage(
                                                `Cantidad invalida :)`
                                            )
                                        }else{
                                            if(data['id_tipo_producto'] == 5 ){
                                                me.agregarCombo2(data['Id_Producto'],cant);
                                                setTimeout(() => {

                                                if(me.arrayDetalleProductoCombo.find(seg => (parseFloat(seg.stock) - parseFloat(seg.cantidad) < 0))){

                                                        Swal.showValidationMessage(
                                                            `Cantidad invalida :)`
                                                        )
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error...',
                                                            text: 'No hay stock para el combo!'
                                                        })
                                                        setTimeout(() => {
                                                            //me.encuentraCombo(me.id_combo);
                                                            me.encuentraDelete(data['Id_Producto'])
                                                            me.encuentraProductoCombo2Delete(data['Id_Producto'])
                                                        }, "1000")

                                                        //me.arrayDetalleCombo=[];
                                                        //me.arrayDetalleProductoCombo=[];
                                                    }else{
                                                        //console.log(me.arrayDetalleProductoCombo)
                                                         //me.galProductos(me.id_categoria);

                                                        me.arrayDetalle.push({
                                                            id_tienda_articulo : data['Id_Producto'],
                                                            id_articulo : data['Id_Producto'],
                                                            articulo : data['articulo'],
                                                            cantidad : parseFloat(cant),
                                                            cantidadAux : parseFloat(cant),
                                                            articulo : data['descripcion'],
                                                            precio : data['precio'],
                                                            costo_unitario : data['precio'],
                                                            costo_venta : data['precio'],
                                                            //combo : data['Combo'],
                                                            preciov : 0,
                                                            stock : parseInt(data['stock']),
                                                            producto_venta: 'Venta Producto',
                                                            cantidad_presentacion : (cant*data['contenido_presentacion']),
                                                            id_producto_compuesto : data['id_producto_compuesto'],
                                                            id_tipo_producto : data['id_tipo_producto'],

                                                            //tipo_producto: data['tipo_producto']
                                                        });
                                                    }
                                                }, "700")


                                            }else{
                                                me.arrayDetalle.push({
                                                    id_tienda_articulo : data['Id_Producto'],
                                                    id_articulo : data['Id_Producto'],
                                                    cantidad : parseFloat(cant),
                                                    cantidadAux : parseFloat(cant),
                                                    articulo : data['articulo'],
                                                    precio : data['precio'],
                                                    costo_unitario : data['precio'],
                                                    costo_venta : data['precio'],
                                                    //combo : data['Combo'],
                                                    preciov : 0,
                                                    stock : parseInt(data['stock']),
                                                    producto_venta: 'Venta Producto',
                                                    cantidad_presentacion : (cant*data['contenido_presentacion']),
                                                    id_producto_compuesto : data['id_producto_compuesto'],
                                                    id_tipo_producto : data['id_tipo_producto'],

                                                    //tipo_producto: data['tipo_producto']
                                                });
                                            }

                                        }
                                    }
                                }
                            }


                        if(data['id_tipo_producto'] == 2){
                            me.agregarProductoElaborado(data['Id_Producto'],cant);
                            //me.galProductos2(me.id_categoria,cant);
                        }
                        if(data['id_tipo_producto'] == 3){
                            me.agregarProductoSimple(data['Id_Producto'],cant);
                        }
                        if(data['id_tipo_producto'] == 4){
                            me.agregarProductoCompuesto(data['id_producto_compuesto'],cant,data['contenido_presentacion']);
                        }
                        // if(data['id_tipo_producto'] == 5){
                        //     me.agregarCombo(data['Id_Producto'],cant);
                        // }

                    },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Producto agregado...',
                                showConfirmButton: false,
                                timer: 800
                            });
                            //console.log(me.arrayDetalleProductoCombo)
                        }
                    })
              // }
            },
            agregarProductoCheck2(data=[]){
                let me = this;
                me.encuentraProductoSimpleDelete(data['Id_Producto'])
                me.encuentraProductoElaboradoDelete(data['Id_Producto'])
                Swal.fire({
                    title: 'Modificar Mesa N.: '+me.datos.mesa+'\n'+'Ingrese la cantidad \n'+data['descripcion']+'\n'+data['precio']+' bs.',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {
                        me.encuentraDelete(data['Id_Producto'])
                    if(cant==0){
                    Swal.showValidationMessage(
                        `Cantidad no puede ser 0`
                    );
                    }else{
                        if(cant <0){
                                Swal.showValidationMessage(
                                    `Cantidad no puede ser negativo`
                                );
                            }else{
                                if(cant == ''){
                                    Swal.showValidationMessage(
                                        `Cantidad esta Vacia`
                                    );
                                }else{
                                    if((cant>parseInt(data['stock']) || cant=='')&& data['estado'] == 1 && data['id_tipo_producto'] != 2 && data['id_tipo_producto'] != 5){
                                        Swal.showValidationMessage(
                                            `Cantidad invalida :)`
                                        )
                                    }else{
                                        if(data['id_tipo_producto'] == 5 ){
                                                me.agregarCombo2(data['Id_Producto'],cant);
                                                setTimeout(() => {

                                                if(me.arrayDetalleProductoCombo.find(seg => (parseFloat(seg.stock) - parseFloat(seg.cantidad) < 0))){

                                                        Swal.showValidationMessage(
                                                            `Cantidad invalida :)`
                                                        )
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error...',
                                                            text: 'No hay stock para el combo!'
                                                        })
                                                        setTimeout(() => {
                                                            //me.encuentraCombo(me.id_combo);
                                                            me.encuentraDelete(data['Id_Producto'])
                                                            me.encuentraProductoCombo2Delete(data['Id_Producto'])
                                                        }, "1000")
                                                    }else{
                                                        console.log(me.arrayDetalleProductoCombo)
                                                         //me.galProductos(me.id_categoria);

                                                        me.arrayDetalle.push({
                                                            id_tienda_articulo : data['Id_Producto'],
                                                            id_articulo : data['Id_Producto'],
                                                            cantidad : parseFloat(cant),
                                                            cantidadAux : parseFloat(cant),
                                                            articulo : data['articulo'],
                                                            precio : data['precio'],
                                                            costo_unitario : data['precio'],
                                                            costo_venta : data['precio'],
                                                            Estado : 1,
                                                            //combo : data['Combo'],
                                                            preciov : 0,
                                                            stock : parseInt(data['stock']),
                                                            producto_venta: 'Venta Producto',
                                                            cantidad_presentacion : (cant*data['contenido_presentacion']),
                                                            id_producto_compuesto : data['id_producto_compuesto'],
                                                            id_tipo_producto : data['id_tipo_producto'],

                                                            //tipo_producto: data['tipo_producto']
                                                        });
                                                    }
                                                }, "700")

                                            }else{
                                                me.arrayDetalle.push({
                                                    id_tienda_articulo : data['Id_Producto'],
                                                    Estado : 1,
                                                    id_articulo : data['Id_Producto'],
                                                    cantidad : parseFloat(cant),
                                                    articulo : data['articulo'],
                                                    precio : data['precio'],
                                                    costo_unitario : data['precio'],
                                                    costo_venta : data['precio'],
                                                    //combo : data['Combo'],
                                                    preciov : 0,
                                                    stock : parseInt(data['stock']),
                                                    producto_venta: 'Venta Producto',
                                                    cantidad_presentacion : (cant*data['contenido_presentacion']),
                                                    id_producto_compuesto : data['id_producto_compuesto'],
                                                    id_tipo_producto : data['id_tipo_producto'],

                                                    //tipo_producto: data['tipo_producto']
                                                });
                                             }
                                    }
                                }
                            }
                        }
                        //me.contadorStock(det);
                        if(data['id_tipo_producto'] == 2){
                            me.agregarProductoElaborado(data['Id_Producto'],cant);
                        }
                        if(data['id_tipo_producto'] == 3){
                            me.agregarProductoSimple(data['Id_Producto'],cant);
                        }
                        if(data['id_tipo_producto'] == 4){
                            me.agregarProductoCompuesto(data['id_producto_compuesto'],cant,data['contenido_presentacion']);
                        }
                        // if(data['id_tipo_producto'] == 5){
                        //     me.agregarCombo(data['Id_Producto'],cant);
                        // }
                    },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Producto agregado...',
                                showConfirmButton: false,
                                timer: 500
                            });
                        }
                    })
               //}
            },
            agregarProductoCheck3(data=[]){
                let me = this;
                me.encuentraProductoSimpleDelete(data['Id_Producto'])
                me.encuentraProductoElaboradoDelete(me.id_combo)
                Swal.fire({
                    title: 'Ingrese la cantidad\n'+data['descripcion']+'ㅤ \n'+data['precio']+' bs.',
                    // title: 'Mesa N. : '+me.datos.mesa+'\n'+'Ingrese la cantidad \n'+data['descripcion']+'\n'+data['precio']+' bs.',

                    // title: 'Pedido N. : '+me.arrayContador[0].Correlativo+'\n'+'ㅤㅤ'+'Ingrese la cantidad ㅤㅤㅤ \n'+data['descripcion']+'ㅤ \n'+data['precio']+' bs.',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {
                        me.encuentraDelete(data['Id_Producto'])
                    if(cant==0){
                        Swal.showValidationMessage(
                            `Cantidad no puede ser 0`
                        );
                        }else{
                            if(cant <0){
                                    Swal.showValidationMessage(
                                        `Cantidad no puede ser negativo`
                                    );
                                }else{
                                    if(cant == ''){
                                        Swal.showValidationMessage(
                                            `Cantidad esta Vacia`
                                        );
                                    }else{
                                        if((cant>parseInt(data['stock']) || cant=='')&& data['estado'] == 1 && data['id_tipo_producto'] != 5){
                                            Swal.showValidationMessage(
                                                `Cantidad invalida :)`
                                            )
                                        }else{
                                            if(data['id_tipo_producto'] == 5 ){
                                                me.agregarCombo2(data['Id_Producto'],cant);
                                                setTimeout(() => {

                                                if(me.arrayDetalleProductoCombo.find(seg => (parseFloat(seg.stock) - parseFloat(seg.cantidad) < 0))){

                                                        Swal.showValidationMessage(
                                                            `Cantidad invalida :)`
                                                        )
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error...',
                                                            text: 'No hay stock para el combo!'
                                                        })
                                                        setTimeout(() => {
                                                            //me.encuentraCombo(me.id_combo);
                                                            me.encuentraDelete(data['Id_Producto'])
                                                            me.encuentraProductoCombo2Delete(data['Id_Producto'])
                                                        }, "1000")
                                                        //me.arrayDetalleProductoCombo=[];
                                                        //me.arrayDetalleCombo=[];
                                                    }else{
                                                        console.log(me.arrayDetalleProductoCombo)
                                                         //me.galProductos(me.id_categoria);

                                                        me.arrayDetalle.push({
                                                            id_tienda_articulo : data['Id_Producto'],
                                                            id_articulo : data['Id_Producto'],
                                                            cantidad : parseFloat(cant),
                                                            cantidadAux : parseFloat(cant),
                                                            articulo : data['articulo'],
                                                            precio : data['precio'],
                                                            costo_unitario : data['precio'],
                                                            costo_venta : data['precio'],
                                                            //combo : data['Combo'],
                                                            preciov : 0,
                                                            stock : parseInt(data['stock']),
                                                            producto_venta: 'Venta Producto',
                                                            cantidad_presentacion : (cant*data['contenido_presentacion']),
                                                            id_producto_compuesto : data['id_producto_compuesto'],
                                                            id_tipo_producto : data['id_tipo_producto'],

                                                            //tipo_producto: data['tipo_producto']
                                                        });
                                                    }
                                                }, "700")

                                            }else{
                                                me.arrayDetalle.push({
                                                    id_tienda_articulo : data['Id_Producto'],
                                                    id_articulo : data['Id_Producto'],
                                                    cantidad : parseFloat(cant),
                                                    articulo : data['articulo'],
                                                    precio : data['precio'],
                                                    costo_unitario : data['precio'],
                                                    costo_venta : data['precio'],
                                                    //combo : data['Combo'],
                                                    preciov : 0,
                                                    stock : parseInt(data['stock']),
                                                    producto_venta: 'Venta Producto',
                                                    cantidad_presentacion : (cant*data['contenido_presentacion']),
                                                    id_producto_compuesto : data['id_producto_compuesto'],
                                                    id_tipo_producto : data['id_tipo_producto'],

                                                    //tipo_producto: data['tipo_producto']
                                                });
                                            }
                                        }
                                    }
                                }
                            }

                        if(data['id_tipo_producto'] == 2){
                            me.agregarProductoElaborado(data['Id_Producto'],cant);
                        }
                        if(data['id_tipo_producto'] == 3){
                            me.agregarProductoSimple(data['Id_Producto'],cant);
                        }
                        if(data['id_tipo_producto'] == 4){
                            me.agregarProductoCompuesto(data['id_producto_compuesto'],cant,data['contenido_presentacion']);
                        }
                        // if(data['id_tipo_producto'] == 5){
                        //     me.agregarCombo(data['Id_Producto'],cant);
                        // }
                    },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Producto agregado...',
                                showConfirmButton: false,
                                timer: 500
                            });
                        }
                    })
              // }
            },
            agregarProductoElaborado(id,cant){
                let me = this;
                //console.log(cant);
                var url='/producto/elaborado?id_producto='+ id;
                    axios.get(url).then(function(response){
                    me.arrayDetalleElaboradoAux = response.data;

                    //me.arrayDetalleProductoElaborado= response.data;
                    me.arrayDetalleElaboradoAux.forEach(item => {
                        item.cantidad = cant
                        item.estadoN = 0

                    });
                    //console.log(me.arrayDetalleElaboradoAux);
                        if(me.arrayDetalleElaborado.length==0){
                            me.arrayDetalleElaborado = me.arrayDetalleElaboradoAux;
                            me.arrayDetalleProductoElaborado = me.arrayDetalleElaboradoAux;
                            //console.log('prueba');

                        //Combo
                          me.arrayDetalleProductoCombo.forEach(item =>
                        {
                            me.arrayDetalle.forEach(item2 =>
                            {
                                if(item.id_producto == item2.id_articulo)
                                {
                                // console.log(item.id_producto,item2.Id_Producto);
                                    item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                    console.log(item2.stock);
                                }
                            })
                        })
                        //interno
                        me.arrayDetalleProductoCombo.forEach(item =>
                        {
                            me.arrayDetalleProductoElaborado.forEach(item2 =>
                            {
                                if(item.id_producto == item2.id_producto)
                                {
                                // console.log(item.id_producto,item2.Id_Producto);
                                    item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                    console.log(item2.stock);
                                }
                            })
                        })

                        }else{
                            me.arrayDetalleElaborado=me.arrayDetalleElaborado.concat(me.arrayDetalleElaboradoAux);
                            me.encuentraProductoElaboradoDelete(id)
                            me.arrayDetalleProductoElaborado=me.arrayDetalleProductoElaborado.concat(me.arrayDetalleElaboradoAux);
                            //console.log(me.arrayDetalleElaborado);
                            //Combo
                            me.arrayDetalleProductoCombo.forEach(item =>
                            {
                                me.arrayDetalle.forEach(item2 =>
                                {
                                    if(item.id_producto == item2.id_articulo)
                                    {
                                    // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })
                            //interno
                            me.arrayDetalleProductoCombo.forEach(item =>
                            {
                                me.arrayDetalleProductoElaborado.forEach(item2 =>
                                {
                                    if(item.id_producto == item2.id_producto)
                                    {
                                    // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })

                        }
                        if(me.arrayDetalleProductoElaborado.find(seg => (seg.stock - ((seg.cantidad)) < 0 && seg.estadoN == 0))){

                            Swal.fire({
                                    icon: 'error',
                                    title: 'Error...',
                                    text: 'No hay stock para el producto!'
                                })
                                me.encuentraProductoElaboradoDelete(id)
                                me.encuentraDelete(id)


                               // me.arrayDetalle=[];
                                //me.arrayDetalleProductoElaborado=[];
                                //me.arrayDetalleProductoCompuesto=[];
                        } else {
                        //me.arrayDetalleCombo.forEach(item => item.stock =parseInt(item.stock)-(parseInt(item.cantidad)));
                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'Producto agregado...',
                        //     showConfirmButton: false,
                        //     timer: 500
                        // });

                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });

            },
            agregarProductoSimple(id,cant){
                let me = this;
                //console.log(cant);
                var url='/producto/simple?id_producto='+ id;
                    axios.get(url).then(function(response){
                    me.arrayDetalleSimpleAux = response.data;

                    //me.arrayDetalleProductoSimple= response.data;
                    me.arrayDetalleSimpleAux.forEach(item => {
                        item.cantidad = cant
                        item.estadoN = 0

                    });
                    //console.log(me.arrayDetalleSimpleAux);
                        if(me.arrayDetalleSimple.length==0){
                            me.arrayDetalleSimple = me.arrayDetalleSimpleAux;
                            me.arrayDetalleProductoSimple = me.arrayDetalleSimpleAux;
                            //console.log('prueba');
                        //Combo
                        me.arrayDetalleProductoCombo.forEach(item =>
                        {
                            me.arrayDetalle.forEach(item2 =>
                            {
                                if(item.id_producto == item2.id_articulo)
                                {
                                // console.log(item.id_producto,item2.Id_Producto);
                                    item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                    console.log(item2.stock);
                                }
                            })
                        })
                        //interno
                        me.arrayDetalleProductoCombo.forEach(item =>
                        {
                            me.arrayDetalleProductoSimple.forEach(item2 =>
                            {
                                if(item.id_producto == item2.id_producto)
                                {
                                // console.log(item.id_producto,item2.Id_Producto);
                                    item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                    console.log(item2.stock);
                                }
                            })
                        })


                        }else{
                            me.arrayDetalleSimple=me.arrayDetalleSimple.concat(me.arrayDetalleSimpleAux);
                            me.encuentraProductoSimpleDelete(id)
                            me.arrayDetalleProductoSimple=me.arrayDetalleProductoSimple.concat(me.arrayDetalleSimpleAux);
                            //console.log(me.arrayDetalleSimple);

                            //Combo
                            me.arrayDetalleProductoCombo.forEach(item =>
                            {
                                me.arrayDetalle.forEach(item2 =>
                                {
                                    if(item.id_producto == item2.id_articulo)
                                    {
                                    // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })
                            //interno
                            me.arrayDetalleProductoCombo.forEach(item =>
                            {
                                me.arrayDetalleProductoSimple.forEach(item2 =>
                                {
                                    if(item.id_producto == item2.id_producto)
                                    {
                                    // console.log(item.id_producto,item2.Id_Producto);
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                        console.log(item2.stock);
                                    }
                                })
                            })


                        }
                        if(me.arrayDetalleProductoSimple.find(seg => (seg.stock - ((seg.cantidad)) < 0 && seg.estadoN == 0))){

                            Swal.fire({
                                    icon: 'error',
                                    title: 'Error...',
                                    text: 'No hay stock para el producto!'
                                })
                            me.encuentraProductoSimpleDelete(id)
                            me.encuentraDelete(id)
                               // me.arrayDetalle=[];
                                //me.arrayDetalleProductoSimple=[];
                        } else {
                        //me.arrayDetalleCombo.forEach(item => item.stock =parseInt(item.stock)-(parseInt(item.cantidad)));
                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'Producto agregado...',
                        //     showConfirmButton: false,
                        //     timer: 500
                        // });

                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });

            },
            agregarProductoCompuesto(id,cant,contenido){
                let me = this;
                var url='/producto/compuesto?id_producto='+ id;
                    axios.get(url).then(function(response){
                    me.arrayDetalleAux = response.data;
                    //me.arrayDetalleProductoCompuesto= response.data;
                    me.arrayDetalleAux.forEach(item => item.cantidad = cant*contenido);
                    //console.log(me.arrayDetalleAux);
                        if(me.arrayDetalleCompuesto.length==0){
                            me.arrayDetalleCompuesto = me.arrayDetalleAux;
                            me.arrayDetalleProductoCompuesto = me.arrayDetalleAux;
                            //console.log('prueba');

                        }else{
                            me.arrayDetalleCompuesto=me.arrayDetalleCompuesto.concat(me.arrayDetalleAux);
                            me.encuentraProductoCompuestoDelete(id)
                            me.arrayDetalleProductoCompuesto=me.arrayDetalleProductoCompuesto.concat(me.arrayDetalleAux);
                            //console.log(me.arrayDetalleCompuesto);

                        }
                        if(me.arrayDetalleProductoCompuesto.find(seg => (seg.stock - ((seg.cantidad)) < 0 ))){

                            Swal.fire({
                                    icon: 'error',
                                    title: 'Error...',
                                    text: 'No hay stock para el producto!'
                                })
                            me.arrayDetalle=[];
                            me.arrayDetalleProductoCompuesto=[];
                        } else {
                        //me.arrayDetalleCombo.forEach(item => item.stock =parseInt(item.stock)-(parseInt(item.cantidad)));
                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'Producto agregado...',
                        //     showConfirmButton: false,
                        //     timer: 500
                        // });

                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });

            },
            agregarProductoCompuestoCombo(id,cant){
                let me = this;
                var url='/producto/compuesto?id_producto='+ id;
                    axios.get(url).then(function(response){
                    me.arrayDetalleAux = response.data;
                    //me.arrayDetalleProductoCompuesto= response.data;
                    me.arrayDetalleAux.forEach(item => item.cantidad = cant);
                    //console.log(me.arrayDetalleAux);
                        if(me.arrayDetalleCompuesto.length==0){
                            me.arrayDetalleCompuesto = me.arrayDetalleAux;
                            me.arrayDetalleProductoCompuesto = me.arrayDetalleAux;
                            //console.log('prueba');
                        }else{
                            me.arrayDetalleCompuesto=me.arrayDetalleCompuesto.concat(me.arrayDetalleAux);
                            me.encuentraProductoCompuestoDelete(id)
                            me.arrayDetalleProductoCompuesto=me.arrayDetalleProductoCompuesto.concat(me.arrayDetalleAux);
                            //console.log(me.arrayDetalleCompuesto);

                        }
                        if(me.arrayDetalleProductoCompuesto.find(seg => (seg.stock - ((seg.cantidad)) < 0 ))){

                        Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'No hay stock para el producto!'
                            })
                            me.arrayDetalle=[];
                            me.arrayDetalleProductoCompuesto=[];
                        } else {
                        //me.arrayDetalleCombo.forEach(item => item.stock =parseInt(item.stock)-(parseInt(item.cantidad)));
                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'Producto agregado...',
                        //     showConfirmButton: false,
                        //     timer: 500
                        // });

                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });

            },
            async agregarCombo(id,cant){
                let me=this;
                try {
                    var url='/combo2?id=' + id;
                    const res = await axios.get(url)
                    // me.id_receta=(res.data[0].id).toString();
                    me.id_combo=(res.data[0].id).toString();

                    // me.arrayReceta.forEach(item2 => {
                    // var url='/receta/detalle?id=' + me.arrayReceta[0].id;
                    // axios.get(url).then(function(response){
                    // me.arrayDetalleCombo = response.data;
                    // var url='/receta/detalle?id=' + me.id_receta;
                    var url='/combo/detalleCombo2?id=' + me.id_combo;
                    const res2 = await axios.get(url)
                    me.arrayDetalleCombo=res2.data;

                    me.arrayDetalleCombo.forEach(item => {
                    if(item.id_tipo_producto == 2){
                        item.cantidad =parseInt(item.cantidad)*cant
                        item.cantidadAux =cant
                        item.estadoN =0
                    }
                    if(item.id_tipo_producto == 3){
                        item.cantidad =parseInt(item.cantidad)*cant
                        item.cantidadAux =cant
                        item.estadoN =0
                    }
                // if(item.id_tipo_producto == 4){
                //     item.cantidad =parseInt(item.cantidad)*cant
                //     //console.log(item.cantidad);
                //         me.agregarProductoCompuestoCombo(item.id_producto_compuesto,item.cantidad)
                //     }
                    });

                    // me.arrayDetalleProductoCombo=me.arrayDetalleProductoCombo.concat(me.arrayDetalleCombo);
                    // me.encuentraCombo(me.id_receta);

                    if(me.arrayDetalleProductoCombo.length==0){
                        me.arrayDetalleProductoCombo = me.arrayDetalleCombo;
                        //me.arrayDetalleRecetaAux = me.arrayDetalleCombo;
                        //me.arrayDetalleProductoAux = me.arrayDetalleProductoCombo;

                        // me.arrayDetalleRecetaAux = me.arrayDetalleCombo;
                        // me.encuentraCombo(me.id_receta);

                        // if(arrayDetalleProductoCombo[0].Id_TipoProducto == 4)
                        //         {
                            //console.log();


                        // }
                        this.arrayDetalleProductoSimple.forEach(item =>
                    {
                        this.arrayDetalleCombo.forEach(item2 =>
                        {
                            if(item.id_producto == item2.id_producto)
                            {
                                item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                console.log(item.cantidad);
                            }
                        })
                    })


                    }else{
                        //me.arrayDetalleRecetaAux=me.arrayDetalleRecetaAux.concat(me.arrayDetalleCombo);
                        //me.arrayDetalleProductoCombo = [];
                                me.encuentraCombo(me.id_combo);
                                me.arrayDetalleProductoCombo=me.arrayDetalleProductoCombo.concat(me.arrayDetalleCombo);

                            }
                            // me.arrayDetalleCombo.forEach(item => {
                            // if(item.id_tipo_producto == 3){
                                    if(me.arrayDetalleCombo.find(seg => (seg.stock - ((seg.cantidad)) < 0 && seg.id_tipo_producto != 5))){

                                        //me.arrayDetalleProductoCombo=[];
                                        //console.log('hola');
                                    } else
                                    {
                                        // me.arrayDetalleCombo.forEach(item =>
                                        // {
                                        //     me.arrayProducto.forEach(item2 =>
                                        //     {
                                        //         console.log(item2.Id_Producto);
                                        //         if(item.id_producto == item2.Id_Producto)
                                        //         {
                                        //             item.cantidad = parseFloat(item.cantidad) - parseFloat(item2.stock)
                                        //         }
                                        //     })
                                        // })
                                    }
                            //     }
                            // });

                } catch (error) {
                    if(error.response.data){
                        this.errores=error.response.data.errors;
                    }
                }
               // me.validarFecha();
            },

            async agregarCombo2(id,cant){
                let me=this;
                try {
                    var url='/combo2?id=' + id;
                    const res = await axios.get(url)
                    // me.id_receta=(res.data[0].id).toString();
                    me.id_combo=(res.data[0].id).toString();

                    // me.arrayReceta.forEach(item2 => {
                    // var url='/receta/detalle?id=' + me.arrayReceta[0].id;
                    // axios.get(url).then(function(response){
                    // me.arrayDetalleCombo = response.data;
                    // var url='/receta/detalle?id=' + me.id_receta;
                    var url='/combo/detalleCombo2?id=' + me.id_combo;
                    const res2 = await axios.get(url)
                    me.arrayDetalleCombo=res2.data;

                    me.arrayDetalleCombo.forEach(item => {
                    if(item.id_tipo_producto == 2){
                        item.cantidad =parseInt(item.cantidad)*cant
                        item.cantidadAux =cant
                        item.estadoN =0
                    }
                    if(item.id_tipo_producto == 3){
                        item.cantidad =parseInt(item.cantidad)*cant
                        //item.cantidadAux =cant
                        item.estadoN =0
                    }
                // if(item.id_tipo_producto == 4){
                //     item.cantidad =parseInt(item.cantidad)*cant
                //     //console.log(item.cantidad);
                //         me.agregarProductoCompuestoCombo(item.id_producto_compuesto,item.cantidad)
                //     }
                    });

                    me.arrayDetalleCombo.forEach(item => {

                        item.cont = item.id_combo
                        item.cont++;


                // if(item.id_tipo_producto == 4){
                //     item.cantidad =parseInt(item.cantidad)*cant
                //     //console.log(item.cantidad);
                //         me.agregarProductoCompuestoCombo(item.id_producto_compuesto,item.cantidad)
                //     }
                    });

                    // me.arrayDetalleProductoCombo=me.arrayDetalleProductoCombo.concat(me.arrayDetalleCombo);
                    // me.encuentraCombo(me.id_receta);

                    if(me.arrayDetalleProductoCombo.length==0){
                        me.arrayDetalleProductoCombo = me.arrayDetalleCombo;
                        //console.log('SDKFSAJF')


                        //me.arrayDetalleRecetaAux = me.arrayDetalleCombo;
                        //me.arrayDetalleProductoAux = me.arrayDetalleProductoCombo;

                        // me.arrayDetalleRecetaAux = me.arrayDetalleCombo;
                        // me.encuentraCombo(me.id_receta);

                        // if(arrayDetalleProductoCombo[0].Id_TipoProducto == 4)
                        //         {
                            //console.log();


                        // }
                        //Combo
                        this.arrayDetalle.forEach(item =>
                        {
                            if(item.id_tipo_producto == 2){
                                this.arrayDetalleCombo.forEach(item2 =>
                                {
                                    if(item.id_articulo == item2.id_producto)
                                    {
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                        //console.log(item2.stock);
                                    }
                                })
                            }
                            if(item.id_tipo_producto == 3){
                                this.arrayDetalleCombo.forEach(item2 =>
                                {
                                    if(item.id_articulo == item2.id_producto)
                                    {
                                        item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                        //console.log(item2.stock);
                                    }
                                })
                            }
                        })

                        //DETALLE
                        // this.arrayDetalleCombo.forEach(item =>
                        // {
                        //     if(item.id_tipo_producto == 2){
                        //         this.arrayProducto.forEach(item2 =>
                        //         {
                        //             if(item.id_producto == item2.Id_Producto)
                        //             {
                        //                 item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                        //                 console.log(item2.stock);
                        //             }
                        //         })
                        //     }
                        //     if(item.id_tipo_producto == 3){
                        //         this.arrayProducto.forEach(item2 =>
                        //         {
                        //             if(item.id_producto == item2.id_articulo)
                        //             {
                        //                 item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                        //                 console.log(item2.stock);
                        //             }
                        //         })
                        //     }
                        // })

                        // //Simple
                        // this.arrayDetalleProductoSimple.forEach(item =>
                        // {
                        //     this.arrayDetalleCombo.forEach(item2 =>
                        //     {
                        //         if(item.id_producto == item2.id_producto)
                        //         {
                        //             item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                        //             console.log(item2.stock);
                        //         }
                        //     })
                        // })

                        // //Elaborado
                        // me.arrayDetalleProductoElaborado.forEach(item =>
                        // {
                        //     me.arrayDetalleCombo.forEach(item2 =>
                        //     {
                        //         if(item.id_producto == item2.id_producto)
                        //         {
                        //         // console.log(item.id_producto,item2.Id_Producto);
                        //             item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                        //             console.log(item.cantidad);
                        //         }
                        //     })
                        // })
                        //console.log(me.arrayDetalleProductoCombo)

                    }else{
                        //me.arrayDetalleRecetaAux=me.arrayDetalleRecetaAux.concat(me.arrayDetalleCombo);
                        //me.arrayDetalleProductoCombo = [];
                                me.encuentraCombo(me.id_combo);
                                me.arrayDetalleProductoCombo=me.arrayDetalleProductoCombo.concat(me.arrayDetalleCombo);
                                // //Simple
                                // this.arrayDetalleProductoSimple.forEach(item =>
                                // {
                                //     this.arrayDetalleProductoCombo.forEach(item2 =>
                                //     {
                                //         if(item.id_producto == item2.id_producto)
                                //         {
                                //             item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                //             console.log(item2.stock);
                                //         }
                                //     })
                                // })

                                // //Elaborado
                                // me.arrayDetalleProductoElaborado.forEach(item =>
                                // {
                                //     me.arrayDetalleProductoCombo.forEach(item2 =>
                                //     {
                                //         if(item.id_producto == item2.id_producto)
                                //         {
                                //         // console.log(item.id_producto,item2.Id_Producto);
                                //             item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                //             console.log(item.cantidad);
                                //         }
                                //     })
                                // })
                                //Combo
                                this.arrayDetalle.forEach(item =>
                                {
                                    if(item.id_tipo_producto == 2){
                                        this.arrayDetalleCombo.forEach(item2 =>
                                        {
                                            if(item.id_articulo == item2.id_producto)
                                            {
                                                item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                                //console.log(item2.stock);
                                            }
                                        })
                                    }
                                    if(item.id_tipo_producto == 3){
                                        this.arrayDetalleCombo.forEach(item2 =>
                                        {
                                            if(item.id_articulo == item2.id_producto)
                                            {
                                                item2.stock = parseFloat(item2.stock) - parseFloat(item.cantidad)
                                               // console.log(item2.stock);
                                            }
                                        })
                                    }
                                })
                            }
                            // me.arrayDetalleCombo.forEach(item => {
                            // if(item.id_tipo_producto == 3){
                                    if(me.arrayDetalleCombo.find(seg => (seg.stock - ((seg.cantidad)) < 0 && seg.id_tipo_producto != 5))){
                                        // Swal.fire({
                                        //         icon: 'error',
                                        //         title: 'Error...',
                                        //         text: 'No hay stock para el combo!'
                                        //     })
                                        //     //me.arrayDetalle=[];
                                        //     me.arrayDetalleProductoCombo=[];
                                        //console.log('hola');
                                        // setTimeout(() => {
                                        //     me.encuentraCombo(me.id_combo);
                                        //     me.encuentraDelete(data['Id_Producto'])
                                        // }, "1000")
                                    } else
                                    {
                                        // me.arrayDetalleCombo.forEach(item =>
                                        // {
                                        //     me.arrayProducto.forEach(item2 =>
                                        //     {
                                        //         console.log(item2.Id_Producto);
                                        //         if(item.id_producto == item2.Id_Producto)
                                        //         {
                                        //             item.cantidad = parseFloat(item.cantidad) - parseFloat(item2.stock)
                                        //         }
                                        //     })
                                        // })
                                    }
                            //     }
                            // });

                } catch (error) {
                    if(error.response.data){
                        this.errores=error.response.data.errors;
                    }
                }
               // me.validarFecha();
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
            guardarVenta(){
                if(this.arrayDetalle.length<=0){
                    this.validacionError('No Existe Productos agregados!',3000);
                }else{
                    if(this.datos.total < 0){
                        this.validacionError('El total no puedes ser Negativo!',3000);
                    } else {
                        if(this.arrayDetalle.find(seg => (seg.stock - seg.cantidad < 0 && seg.id_tipo_producto !=5))){
                           //console.log('dfdf');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'No hay stock para el producto!'
                            })
                        } else {
                            if(this.arrayDetalle.find(seg => (seg.id_tipo_producto ==5))){
                                if(this.arrayDetalleProductoCombo.find(seg => (seg.stock - seg.cantidad < 0))){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error...',
                                        text: 'No hay stock en detalle Combo!'
                                    })
                                    //this.arrayDetalleProductoCombo = [];
                                }else
                                {
                                    if(this.datos.descuento < 0){
                                        this.validacionError('El descuento no puedes ser Negativo!',3000);
                                    } else {
                                        let me = this;
                                        if(me.is_busy==0){
                                        axios.post('/venta/guardar_tienda1',{
                                            'id_servicio': me.datos.id,
                                            'fecha': me.datos.fecha,
                                            'fecha_final': me.datosPago.fecha_final,
                                            'id_mesa': me.datos.id_mesa,
                                            'observacion': me.datos.observacion,
                                            'sub_total': me.datos.sub_total,
                                            'descuento': me.datos.descuento,
                                            'usuario': me.datos.usuario,
                                            'total': me.datos.total,
                                            'estado': me.datos.estado,
                                            'id_cliente': me.datos.id_cliente,
                                            'cliente': me.datos.cliente,
                                            'usuario': me.datos.usuario,
                                            'id_tipo_pago': me.datos.id_tipo_pago,
                                            'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
                                            'id_costo_pago': me.datos.id_descuento,
                                            'detalle': me.arrayDetalle,
                                            'monto_total': me.datos.total,
                                            'descripcion_pago': me.datosPago.descripcion,
                                            'saldo': me.datosPago.saldo,
                                            'tipo_venta': me.datos.tipo_venta,

                                            // 'stock_producto_paquete': me.arrayProductoPaquete,
                                            'arrayDetalleCombo' : me.arrayDetalleCombo,
                                            'arrayDetalleProductoElaborado' : me.arrayDetalleProductoElaborado,
                                            'arrayDetalleProductoCompuesto' : me.arrayDetalleProductoCompuesto,
                                            'arrayDetalleProductoSimple' : me.arrayDetalleProductoSimple
                                        }).then(function(response){
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Venta registrado exitosamente',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                            //me.cargarPdf2();
                                            me.listado = 1 ,
                                            me.arrayDetalle = [];
                                            me.arrayProducto = [];
                                            me.arrayDetalleCombo = [],
                                            me.arrayDetalleProductoCompuesto = [],
                                            me.arrayDetalleProductoSimple = [],
                                            me.arrayDetalleProductoCombo = [],
                                            me.arrayProductoSimple = [],
                                            me.arrayDetalleSimple = [],
                                            me.arrayDetalleSimpleAux = [],
                                            me.arrayDetalleElaboradoAux = [],
                                            me.arrayDetalleElaborado = [],
                                            me.arrayDetalleProductoElaborado = [],
                                            // me.arraySalon = [],
                                            //me.arrayMesa = [],
                                            me.arrayDetalleProductoElaborado = [],
                                            me.volverVentaListado();
                                            me.limpiarDatosVenta();
                                            me.galMesa(me.id_salon2);

                                            //me.listarArticulo('', 'nombre_comercial');
                                            //console.log(me.id_salon2);
                                        })
                                        .catch(function(error){
                                            console.log(error);
                                        });
                                    }
                                        me.is_busy=1;
                                    }

                                }
                            } else {
                                    if(this.datos.descuento < 0){
                                        this.validacionError('El descuento no puedes ser Negativo!',3000);
                                    } else {
                                        let me = this;
                                        if(me.is_busy==0){
                                        axios.post('/venta/guardar_tienda1',{
                                            'id_servicio': me.datos.id,
                                            'fecha': me.datos.fecha,
                                            'fecha_final': me.datosPago.fecha_final,
                                            'id_mesa': me.datos.id_mesa,
                                            'observacion': me.datos.observacion,
                                            'sub_total': me.datos.sub_total,
                                            'descuento': me.datos.descuento,
                                            'usuario': me.datos.usuario,
                                            'total': me.datos.total,
                                            'estado': me.datos.estado,
                                            'id_cliente': me.datos.id_cliente,
                                            'cliente': me.datos.cliente,
                                            'usuario': me.datos.usuario,
                                            'id_tipo_pago': me.datos.id_tipo_pago,
                                            'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
                                            'id_costo_pago': me.datos.id_descuento,
                                            'detalle': me.arrayDetalle,
                                            'monto_total': me.datos.total,
                                            'descripcion_pago': me.datosPago.descripcion,
                                            'saldo': me.datosPago.saldo,
                                            'tipo_venta': me.datos.tipo_venta,

                                            // 'stock_producto_paquete': me.arrayProductoPaquete,
                                            'arrayDetalleCombo' : me.arrayDetalleCombo,
                                            'arrayDetalleProductoElaborado' : me.arrayDetalleProductoElaborado,
                                            'arrayDetalleProductoCompuesto' : me.arrayDetalleProductoCompuesto,
                                            'arrayDetalleProductoSimple' : me.arrayDetalleProductoSimple
                                        }).then(function(response){
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Venta registrado exitosamente',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                            //me.cargarPdf2();
                                            me.listado = 1 ,
                                            me.arrayDetalle = [];
                                            me.arrayProducto = [];
                                            me.arrayDetalleCombo = [],
                                            me.arrayDetalleProductoCompuesto = [],
                                            me.arrayDetalleProductoSimple = [],
                                            me.arrayDetalleProductoCombo = [],
                                            me.arrayProductoSimple = [],
                                            me.arrayDetalleSimple = [],
                                            me.arrayDetalleSimpleAux = [],
                                            me.arrayDetalleElaboradoAux = [],
                                            me.arrayDetalleElaborado = [],
                                            me.arrayDetalleProductoElaborado = [],
                                            // me.arraySalon = [],
                                            //me.arrayMesa = [],
                                            me.arrayDetalleProductoElaborado = [],
                                            me.volverVentaListado();
                                            me.limpiarDatosVenta();
                                            me.galMesa(me.id_salon2);

                                            //me.listarArticulo('', 'nombre_comercial');
                                            //console.log(me.id_salon2);
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
            guardarVentaDirecta(){
                if(this.arrayDetalle.length<=0){
                    this.validacionError('No Existe Productos agregados!',3000);
                }else{
                    if(this.datos.total < 0){
                        this.validacionError('El total no puedes ser Negativo!',3000);
                    } else {
                        if(this.arrayDetalle.find(seg => (seg.stock - seg.cantidad < 0 && seg.id_tipo_producto !=5))){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'No hay stock para el producto!'
                            })
                        } else {
                            if(this.arrayDetalle.find(seg => (seg.id_tipo_producto ==5))){
                                if(this.arrayDetalleProductoCombo.find(seg => (seg.stock - seg.cantidad < 0 && seg.id_tipo_producto !=5))){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error...',
                                        text: 'No hay stock en detalle Combo!'
                                    })
                                }else
                                {
                                    if(this.datos.descuento < 0){
                                        this.validacionError('El descuento no puedes ser Negativo!',3000);
                                    } else {
                                            let me = this;
                                            if(me.is_busy==0){
                                            axios.post('/venta/guardar_tienda1/directa',{
                                                'id_servicio': me.datos.id,
                                                'fecha': me.datos.fecha,
                                                'fecha_final': me.datosPago.fecha_final,
                                                'id_mesa': me.datos.id_mesa,
                                                'observacion': me.datos.observacion,
                                                'sub_total': me.datos.sub_total,
                                                'descuento': me.datos.descuento,
                                                'usuario': me.datos.usuario,
                                                'total': me.datos.total,
                                                'efectivo': me.datos.efectivo,
                                                'cambio': me.datos.cambio,
                                                'total_efectivo': me.datos.total_efectivo,
                                                'total_deposito': me.datos.total_deposito,
                                                'estado': me.datos.estado,
                                                'id_cliente': me.datos.id_cliente,
                                                'cliente': me.datos.cliente,
                                                'usuario': me.datos.usuario,
                                                'id_tipo_pago': me.datos.id_tipo_pago,
                                                'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
                                                'id_costo_pago': me.datos.id_descuento,
                                                'detalle': me.arrayDetalle,
                                                'monto_total': me.datos.total,
                                                'descripcion_pago': me.datosPago.descripcion,
                                                'saldo': me.datosPago.saldo,
                                                'tipo_venta': me.datos.tipo_venta,

                                                // 'stock_producto_paquete': me.arrayProductoPaquete,
                                                'arrayDetalleCombo' : me.arrayDetalleCombo,
                                                'arrayDetalleProductoElaborado' : me.arrayDetalleProductoElaborado,
                                                'arrayDetalleProductoCompuesto' : me.arrayDetalleProductoCompuesto,
                                                'arrayDetalleProductoSimple' : me.arrayDetalleProductoSimple
                                            }).then(function(response){
                                                Swal.fire({
                                                    position: 'top-end',
                                                    icon: 'success',
                                                    title: 'Venta registrado exitosamente',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                                //me.cargarPdf2();
                                                me.listado = 0 ,
                                                me.arrayDetalle = [];
                                                me.arrayProducto = [];
                                                me.arrayDetalleCombo = [],
                                                me.arrayDetalleProductoCompuesto = [],
                                                me.arrayDetalleProductoSimple = [],
                                                me.arrayDetalleProductoCombo = [],
                                                me.arrayProductoSimple = [],
                                                me.arrayDetalleSimple = [],
                                                me.arrayDetalleSimpleAux = [],
                                                me.arrayDetalleElaboradoAux = [],
                                                me.arrayDetalleElaborado = [],
                                                me.arrayDetalleProductoElaborado = [],
                                                // me.arraySalon = [],
                                                //me.arrayMesa = [],
                                                me.arrayDetalleProductoElaborado = [],
                                                me.volverVentaListado();
                                                me.limpiarDatosVenta();
                                                //me.listarArticulo('', 'nombre_comercial');
                                                //console.log(me.id_salon2);
                                            })
                                            .catch(function(error){
                                                console.log(error);
                                            });
                                        }
                                        me.cargarPdfTicketVentaDirecta();
                                        me.is_busy=1;
                                    }
                                }
                            } else {
                                if(this.datos.descuento < 0){
                                    this.validacionError('El descuento no puedes ser Negativo!',3000);
                                } else {
                                    let me = this;
                                    if(me.is_busy==0){
                                    axios.post('/venta/guardar_tienda1/directa',{
                                        'id_servicio': me.datos.id,
                                        'fecha': me.datos.fecha,
                                        'fecha_final': me.datosPago.fecha_final,
                                        'id_mesa': me.datos.id_mesa,
                                        'observacion': me.datos.observacion,
                                        'sub_total': me.datos.sub_total,
                                        'descuento': me.datos.descuento,
                                        'usuario': me.datos.usuario,
                                        'total': me.datos.total,
                                        'efectivo': me.datos.efectivo,
                                        'cambio': me.datos.cambio,
                                        'total_efectivo': me.datos.total_efectivo,
                                        'total_deposito': me.datos.total_deposito,
                                        'estado': me.datos.estado,
                                        'id_cliente': me.datos.id_cliente,
                                        'cliente': me.datos.cliente,
                                        'usuario': me.datos.usuario,
                                        'id_tipo_pago': me.datos.id_tipo_pago,
                                        'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
                                        'id_costo_pago': me.datos.id_descuento,
                                        'detalle': me.arrayDetalle,
                                        'monto_total': me.datos.total,
                                        'descripcion_pago': me.datosPago.descripcion,
                                        'saldo': me.datosPago.saldo,
                                        'tipo_venta': me.datos.tipo_venta,

                                        // 'stock_producto_paquete': me.arrayProductoPaquete,
                                        'arrayDetalleCombo' : me.arrayDetalleCombo,
                                        'arrayDetalleProductoElaborado' : me.arrayDetalleProductoElaborado,
                                        'arrayDetalleProductoCompuesto' : me.arrayDetalleProductoCompuesto,
                                        'arrayDetalleProductoSimple' : me.arrayDetalleProductoSimple
                                    }).then(function(response){
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Venta registrado exitosamente',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        //me.cargarPdf2();
                                        me.listado = 0 ,
                                        me.arrayDetalle = [];
                                        me.arrayProducto = [];
                                        me.arrayDetalleCombo = [],
                                        me.arrayDetalleProductoCompuesto = [],
                                        me.arrayDetalleProductoSimple = [],
                                        me.arrayDetalleProductoCombo = [],
                                        me.arrayProductoSimple = [],
                                        me.arrayDetalleSimple = [],
                                        me.arrayDetalleSimpleAux = [],
                                        me.arrayDetalleElaboradoAux = [],
                                        me.arrayDetalleElaborado = [],
                                        me.arrayDetalleProductoElaborado = [],
                                        // me.arraySalon = [],
                                        //me.arrayMesa = [],
                                        me.arrayDetalleProductoElaborado = [],
                                        me.cargarPdfTicketVentaDirecta();
                                        me.volverVentaListado();
                                        me.limpiarDatosVenta();
                                        //me.listarArticulo('', 'nombre_comercial');
                                        //console.log(me.id_salon2);
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
            ModificarMesa(id)
            {
                let me = this;
                me.is_busy = 0;
                me.listado=3;
                me.arrayDetalle = [];
                var url='/venta/cabecera/modificar?id_mesa='+id;
                axios.get(url).then(function(response){
                    me.datos.cliente= response.data.cliente;
                    me.datos.monto = response.data.monto;
                    me.datos.nro = response.data.nro;
                    me.datos.id = response.data.Id_Venta;
                    me.datos.mesa = response.data.Mesa;
                    me.datos.id_mesa = response.data.NMesa;
                    me.datos.descripcion = response.data.usuario;

                    //console.log(+me.datos.id);
                    var url='/venta_act?id_venta='+me.datos.id;
                    axios.put(url).then(function(response){
                        //me.arrayDetalle = response.data;
                    })
                    .catch(function(error){
                        console.log(error)
                    });

                    var PreVenta=[];
                    var url='/venta/detalle?id_venta='+ me.datos.id;
                    axios.get(url).then(function(response){
                        PreVenta = response.data;
                        me.id_venta = PreVenta[0].id_venta;

                        for(var i=0;i<PreVenta.length;i++){
                            me.arrayDetalle.push({
                                id_producto : PreVenta[i].id_producto,
                                id_detalle : PreVenta[i].id_detalle_venta,
                                id_tipo_producto : PreVenta[i].id_tipo_producto,
                                id_producto_compuesto : PreVenta[i].id_producto_compuesto,
                                cantidad_presentacion : PreVenta[i].cantidad_presentacion,
                                cantidad : PreVenta[i].cantidad,
                                articulo : PreVenta[i].producto,
                                costo_venta : PreVenta[i].precio,
                                costo_unitario : PreVenta[i].precio,
                                sub_total : PreVenta[i].precio * PreVenta[i].cantidad,
                                preciov : PreVenta[i].preciov,
                                Estado : PreVenta[i].estado,
                                id_venta : PreVenta[i].id_venta,
                                total_cantidad : (parseInt(PreVenta[i].cantidad)*parseInt(PreVenta[i].cantidad_presentacion)),
                                stock : parseInt(PreVenta[i].stock)+parseInt(PreVenta[i].cantidad),
                            });
                        }

                    })
                    .catch(function(error){
                        console.log(error);
                    });



                })
                .catch(function(error){
                    console.log(error);
                });
            },
            modificarPreVenta(){
                let me = this;
                if(this.datos.total < 0){
                        this.validacionError('El total no puedes ser Negativo!',3000);
                    } else {
                        if(this.arrayDetalle.find(seg => (seg.stock - seg.cantidad < 0  && seg.id_tipo_producto !=5))){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'No hay stock para el producto!'
                            })
                        } else {
                            if(this.arrayDetalle.find(seg => (seg.id_tipo_producto ==5))){
                                if(this.arrayDetalleProductoCombo.find(seg => (seg.stock - seg.cantidad < 0 && seg.id_tipo_producto !=5))){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error...',
                                        text: 'No hay stock en detalle Combo!'
                                    })
                                }else
                                {
                                    if(this.datos.descuento < 0){
                                    this.validacionError('El descuento no puedes ser Negativo!',3000);
                                    } else {
                                        if(me.is_busy==0){
                                        axios.put('/venta/modificar',{
                                            'Id_Venta': me.datos.id,
                                            'observacion': me.datos.observacion,
                                            'total': me.datos.total,
                                            'sub_total': me.datos.sub_total,
                                            'descuento': me.datos.descuento,
                                            'detalle': me.arrayDetalle,
                                            'arrayDetalleCombo' : me.arrayDetalleCombo,
                                            'arrayDetalleProductoCompuesto' : me.arrayDetalleProductoCompuesto,
                                            'arrayDetalleProductoSimple' : me.arrayDetalleProductoSimple,
                                            'arrayDetalleProductoElaborado' : me.arrayDetalleProductoElaborado,

                                        }).then(function(response){
                                            me.arrayDetalle=[];
                                            // me.arrayDet = [];
                                            me.arrayCategoria=[];
                                            me.arrayProducto=[];
                                            me.arrayDetalleCombo = [],
                                            me.arrayDetalleProductoCompuesto = [],
                                            me.arrayDetalleProductoSimple = [],
                                            me.arrayDetalleProductoCombo = [],
                                            me.arrayProductoSimple = [],
                                            me.arrayDetalleSimple = [],
                                            me.arrayDetalleSimpleAux = [],
                                            me.arrayDetalleElaboradoAux = [],
                                            me.arrayDetalleElaborado = [],
                                            me.arrayDetalleProductoElaborado = [],
                                            // me.arrayDetalleProducto=[];
                                            // me.arrayDetalleProductoCompuesto=[];
                                            // me.arrayDetalleProductoSimple=[]
                                            me.buscar = '';
                                            me.listado = 0;
                                            me.sub_listado=0;
                                            // me.contadorModificar();
                                            // me.preVenta();
                                            me.datos.cliente ='';
                                            me.datos.observacion ='';
                                            //me.id_categoria = 0;

                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Preventa modificada...',
                                                showConfirmButton: false,
                                                timer: 500
                                            });
                                            //me.cargarPdf();
                                        })
                                        .catch(function(error){
                                            console.log(error);
                                        });
                                    }
                                    me.is_busy=1;
                                }
                            }
                            } else {
                                if(this.datos.descuento < 0){
                                    this.validacionError('El descuento no puedes ser Negativo!',3000);
                                } else {
                                    if(me.is_busy==0){
                                    axios.put('/venta/modificar',{
                                        'Id_Venta': me.datos.id,
                                        'observacion': me.datos.observacion,
                                        'total': me.datos.total,
                                        'sub_total': me.datos.sub_total,
                                        'descuento': me.datos.descuento,
                                        'detalle': me.arrayDetalle,
                                        'arrayDetalleCombo' : me.arrayDetalleCombo,
                                        'arrayDetalleProductoCompuesto' : me.arrayDetalleProductoCompuesto,
                                        'arrayDetalleProductoSimple' : me.arrayDetalleProductoSimple,
                                        'arrayDetalleProductoElaborado' : me.arrayDetalleProductoElaborado,

                                    }).then(function(response){
                                        me.arrayDetalle=[];
                                        // me.arrayDet = [];
                                        me.arrayCategoria=[];
                                        me.arrayProducto=[];
                                        me.arrayDetalleCombo = [],
                                        me.arrayDetalleProductoCompuesto = [],
                                        me.arrayDetalleProductoSimple = [],
                                        me.arrayDetalleProductoCombo = [],
                                        me.arrayProductoSimple = [],
                                        me.arrayDetalleSimple = [],
                                        me.arrayDetalleSimpleAux = [],
                                        me.arrayDetalleElaboradoAux = [],
                                        me.arrayDetalleElaborado = [],
                                        me.arrayDetalleProductoElaborado = [],
                                        // me.arrayDetalleProducto=[];
                                        // me.arrayDetalleProductoCompuesto=[];
                                        // me.arrayDetalleProductoSimple=[]
                                        me.buscar = '';
                                        me.listado = 0;
                                        me.sub_listado=0;
                                        // me.contadorModificar();
                                        // me.preVenta();
                                        me.datos.cliente ='';
                                        me.datos.observacion ='';
                                        //me.id_categoria = 0;

                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Preventa modificada...',
                                            showConfirmButton: false,
                                            timer: 500
                                        });
                                        //me.cargarPdf();
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
            CobrarMesa(){
                let me = this;
                if(me.datos.cambio < 0){
                    this.validacionError('El cambio no puedes ser Negativo!',3000);
                    me.is_busy=0;
                } else {
                    if(me.is_busy==0){
                        axios.put('/venta/modificar/cobrar',{
                            'id': me.datos.id,
                            'id_mesa': me.datos.id_mesa,
                            'fecha': me.datosPago.fecha,
                            'fecha_final': me.datosPago.fecha_final,
                            'estado': me.datos.estado,
                            'total': me.datos.total,
                            'efectivo': me.datos.efectivo,
                            'cambio': me.datos.cambio,
                            'total_efectivo': me.datos.total_efectivo,
                            'total_deposito': me.datos.total_deposito,
                            'sub_total': me.datos.sub_total,
                            'descuento': me.datos.descuento,
                            'id_tipo_pago': me.datos.id_tipo_pago,
                            'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
                            'tipo_venta': me.datos.tipo_venta,
                            'descripcion_pago': me.datosPago.descripcion,
                            'saldo': me.datosPago.saldo,
                            'monto_total': me.datos.total,
                            'detalle': me.arrayDetalle,
                        }).then(function(response){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Mesa Liberada...',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            me.arrayDetalle = [];
                            me.arrayDetalleCombo = [],
                            me.arrayDetalleProductoCompuesto = [],
                            me.arrayDetalleProductoSimple = [],
                            me.arrayDetalleProductoCombo = [],
                            me.arrayProductoSimple = [],
                            me.arrayDetalleSimple = [],
                            me.arrayDetalleSimpleAux = [],
                            me.volverVentaListadoModificar();
                            me.limpiarDatosVentaModificar();


                        })
                        .catch(function(error){
                            console.log(error);
                        });
                    }
                    me.galMesa(me.id_salon2);
                    me.is_busy=1;
                }
                // setTimeout(() => {
                    me.cargarPdfTicket2(me.id_venta);
                    // }, 1000)

            },
            volverVentaListadoModificar(){
                let me = this;
                //me.datos.id = 0,
                me.datos.id_categoria = 2,
                me.datos.id_mesa = 0,
                me.datos.observacion='',
                me.datos.nombreSalon='',
                me.datos.fecha =  moment().format('YYYY-MM-DD'),
                me.datos.sub_total = 0,
                me.datos.descuento = 0,
                me.datos.total = 0,
                me.datos.id_tipo_pago = 1,
                me.datos.id_forma_pago = 2,
                me.datos.id_cliente = 1,
                me.datos.cliente = '',
                me.datos.tipoPago = '',
                me.datos.formaPago = '',
                me.datos.costo_pago = '',
                me.datos.id_descuento= '',
                me.datos.personal='',
                me.datos.estado='',
                me.datos.tipo_venta= '0',
                me.datos.id_orden_servicio= null,
                me.datos.usuario='',
                me.datos.mesa='',
                me.datos.total_efectivo = 0,
                me.datos.total_deposito= 0,
                me.datos.efectivo =0,
                me.datos.cambio =0,
                me.arrayDetalle = [];
                me.arrayArticulo = [];
                me.datos.cliente = '';
                me.datos.estado = '';
                me.datos.id_tipo_pago = 1,
                me.datos.id_forma_pago = 2,
                me.buscarP = '';
                me.listado = 0;
                me.isDisabledCliente = false;
                me.isDisabledProducto = false;
                me.isDisabledPaquete = false;
                me.isDisabledOrden = false;
                me.buscar = '';
            },
            limpiarDatosVentaModificar(){
                let me = this;
                me.datos = {
                    //id : 0,
                    id_categoria : 2,
                    id_mesa : 0,
                    nombreSalon:'',
                    observacion:'',
                    fecha :  moment().format('YYYY-MM-DD'),
                    sub_total : 0,
                    descuento : 0,
                    total : 0,
                    total_efectivo : 0,
                    total_deposito : 0,
                    efectivo : 0,
                    deposito : 0,
                    id_tipo_pago : 1,
                    id_forma_pago : 2,
                    id_cliente : 1,
                    cliente : '',
                    tipoPago : '',
                    formaPago : '',
                    costo_pago : '',
                    id_descuento: '',
                    personal:'',
                    estado:'',
                    tipo_venta: '0',
                    id_orden_servicio: null,
                    usuario:'',
                    mesa:'',

                 //   me.datos.usuario= me.usuario_nombre['usuario'];
                }
                me.usuarioNombre();
                me.arrayOrden = [];
                me.arrayDetalle = [];
                me.arrayDetalleCombo = [],
                me.arrayDetalleProductoCompuesto = [],
                me.arrayDetalleProductoSimple = [],
                me.arrayDetalleProductoCombo = [],
                me.arrayProductoSimple = [],
                me.arrayDetalleSimple = [],
                me.arrayDetalleSimpleAux = [],
                me.arrayDetalleElaboradoAux = [],
                me.arrayDetalleElaborado = [],
                me.arrayDetalleProductoElaborado = [],
                me.isDisabledOrden = false;
                me.isDisabledCliente=false;
                me.isDisabledProducto=false;
                me.isDisabledPaquete=false;
                me.buscarP = '';
                me.buscar = '';
                me.buscarCliente= '';
                me.isDisabled=false;
            },
            limpiarDatosVenta(){
                let me = this;
                me.datos = {
                    id : 0,
                    id_categoria : 2,
                    id_mesa : 0,
                    nombreSalon:'',
                    observacion:'',
                    fecha :  moment().format('YYYY-MM-DD'),
                    sub_total : 0,
                    descuento : 0,
                    total : 0,
                    total_efectivo : 0,
                    total_deposito : 0,
                    efectivo : 0,
                    deposito : 0,
                    id_tipo_pago : 1,
                    id_forma_pago : 2,
                    id_cliente : 1,
                    cliente : '',
                    tipoPago : '',
                    formaPago : '',
                    costo_pago : '',
                    id_descuento: '',
                    personal:'',
                    estado:'',
                    tipo_venta: '0',
                    id_orden_servicio: null,
                    usuario:'',
                    mesa:'',

                 //   me.datos.usuario= me.usuario_nombre['usuario'];
                }
                me.usuarioNombre();
                me.arrayOrden = [];
                me.arrayDetalle = [];
                me.arrayDetalleCombo = [],
                me.arrayDetalleProductoCompuesto = [],
                me.arrayDetalleProductoSimple = [],
                me.arrayDetalleProductoCombo = [],
                me.arrayProductoSimple = [],
                me.arrayDetalleSimple = [],
                me.arrayDetalleSimpleAux = [],
                me.arrayDetalleElaboradoAux = [],
                me.arrayDetalleElaborado = [],
                me.arrayDetalleProductoElaborado = [],
                me.isDisabledOrden = false;
                me.isDisabledCliente=false;
                me.isDisabledProducto=false;
                me.isDisabledPaquete=false;
                me.buscarP = '';
                me.buscar = '';
                me.buscarCliente= '';
                me.isDisabled=false;
            },
            volverVentaListado(){
                let me = this;
                me.datos.id = 0,
                me.datos.id_categoria = 2,
                me.datos.id_mesa = 0,
                me.datos.observacion='',
                me.datos.nombreSalon='',
                me.datos.fecha =  moment().format('YYYY-MM-DD'),
                me.datos.sub_total = 0,
                me.datos.descuento = 0,
                me.datos.total = 0,
                me.datos.id_tipo_pago = 1,
                me.datos.id_forma_pago = 2,
                me.datos.id_cliente = 1,
                me.datos.cliente = '',
                me.datos.tipoPago = '',
                me.datos.formaPago = '',
                me.datos.costo_pago = '',
                me.datos.id_descuento= '',
                me.datos.personal='',
                me.datos.estado='',
                me.datos.tipo_venta= '0',
                me.datos.id_orden_servicio= null,
                me.datos.usuario='',
                me.datos.mesa='',
                me.datos.total_efectivo = 0,
                me.datos.total_deposito= 0,
                me.datos.efectivo =0,
                me.datos.cambio =0,
                me.arrayDetalle = [];
                me.arrayArticulo = [];
                me.datos.cliente = '';
                me.datos.estado = '';
                me.datos.id_tipo_pago = 1,
                me.datos.id_forma_pago = 2,
                me.buscarP = '';
                me.listado = 0;
                me.isDisabledCliente = false;
                me.isDisabledProducto = false;
                me.isDisabledPaquete = false;
                me.isDisabledOrden = false;
                me.buscar = '';
            },
            cargarPdfTicket2(id) {
                axios.get('/venta/pdfPreVenta?id=' + id,{responseType: 'blob'})
                    .then(response => {
                        var blob = new Blob([response.data], {type: 'application/pdf'});
                        var downloadUrl = URL.createObjectURL(blob);
                        window.open(downloadUrl, '_blank');
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            cargarPdfTicketVentaDirecta() {
                axios.get('/venta/pdf2',{responseType: 'blob'})
                    .then(response => {
                        var blob = new Blob([response.data], {type: 'application/pdf'});
                        var downloadUrl = URL.createObjectURL(blob);
                        window.open(downloadUrl, '_blank');
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            ModificarMesaActualizar(id)
            {
                let me = this;
                me.arrayDetalle = [];
                me.listado=3;
                var url='/venta/cabecera/modificar?id_mesa='+id;
                axios.get(url).then(function(response){
                    me.datos.cliente= response.data.cliente;
                    me.datos.monto = response.data.monto;
                    me.datos.nro = response.data.nro;
                    me.datos.id = response.data.Id_Venta;
                    me.datos.mesa = response.data.Mesa;
                    me.datos.id_mesa = response.data.NMesa;
                    me.datos.descripcion = response.data.usuario;

                    var PreVenta=[];
                    var url='/venta/detalle?id_venta='+ me.datos.id;
                    axios.get(url).then(function(response){
                        PreVenta = response.data;
                        for(var i=0;i<PreVenta.length;i++){
                            me.arrayDetalle.push({
                                id_producto : PreVenta[i].id_producto,
                                id_detalle : PreVenta[i].id_detalle_venta,
                                id_tipo_producto : PreVenta[i].id_tipo_producto,
                                id_producto_compuesto : PreVenta[i].id_producto_compuesto,
                                cantidad_presentacion : PreVenta[i].cantidad_presentacion,
                                cantidad : PreVenta[i].cantidad,
                                articulo : PreVenta[i].producto,
                                costo_venta : PreVenta[i].precio,
                                costo_unitario : PreVenta[i].precio,
                                sub_total : PreVenta[i].precio * PreVenta[i].cantidad,
                                preciov : PreVenta[i].preciov,
                                Estado : PreVenta[i].estado,
                                total_cantidad : (parseInt(PreVenta[i].cantidad)*parseInt(PreVenta[i].cantidad_presentacion)),
                                stock : parseInt(PreVenta[i].stock)+parseInt(PreVenta[i].cantidad),
                            });
                        }

                    })
                    .catch(function(error){
                        console.log(error);
                    });



                })
                .catch(function(error){
                    console.log(error);
                });
            },
            eliminarDetalleDb(id,id_tipo_producto){
                let me = this;
                if(me.arrayDetalle.length == 1){
                    Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'No se puede eliminar el último Producto!'
                        })
                }else
                {
                //     Swal.fire({

                //     title: 'Ingrese credenciales para eliminar este item?',
                //     input: 'password',
                //     inputAttributes: {
                //         autocapitalize: 'off',
                //         size: 3
                //     },
                //     showCancelButton: true,
                //     confirmButtonText: 'Guardar',
                //     showLoaderOnConfirm: true,
                //     preConfirm: (cant) => {

                //         if((cant!=this.contrasena_id.Contrasena)  || cant==''){
                //             Swal.showValidationMessage(
                //                 `Contraseña Incorrecta :)`
                //             )
                //         }else{
                //             axios.put('/detalle/eliminar?id_detalle_venta='+id,{
                //                 'id_venta': me.datos.id,
                //                 'id_tipo_producto': id_tipo_producto,
                //                 'total': me.datos.total,
                //                 'sub_total': me.datos.sub_total,
                //                 'descuento': me.datos.descuento,
                //             }).then(function(response){
                //                 Swal.fire({
                //                 position: 'top-end',
                //                 icon: 'success',
                //                 title: 'Producto eliminado...',
                //                 showConfirmButton: false,
                //                 timer: 500
                //                 });
                //                 me.ModificarMesaActualizar(me.datos.id_mesa)

                //             })
                //             .catch(function(error){
                //                 console.log(error);
                //             });


                //         }
                //         // me.Actualizar();
                //     },

                // })






                    axios.put('/detalle/eliminar?id_detalle_venta='+id,{
                        'id_venta': me.datos.id,
                        'id_tipo_producto': id_tipo_producto,
                        'total': me.datos.total,
                        'sub_total': me.datos.sub_total,
                        'descuento': me.datos.descuento,
                    }).then(function(response){
                        Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Producto eliminado...',
                        showConfirmButton: false,
                        timer: 500
                        });
                        me.ModificarMesaActualizar(me.datos.id_mesa)

                    })
                    .catch(function(error){
                        console.log(error);
                    });
                    me.ModificarMesa(me.datos.mesa)
                }

            },
            contrasena(){
                let me=this;
                var url='/contrasena'
                axios.get(url).then(function(response){
                    me.contrasena_id=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
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
            // listarArticulo(buscarP){
            //     let me = this;
            //     me.buscarCliente= '';
            //     me.isVisible = false;
            //     var url='/tienda/listarSinPaginate2/tienda1?buscar=' + buscarP;
            //     axios.get(url).then(function(response){
            //         me.arrayArticulo= response.data;
            //     })
            //     .catch(function(error){
            //         console.log(error);
            //     });
            // },
            listarArticulo(nombre){
                let me=this;
                me.buscarPaciente= '';
                me.isVisible = false;
                var url='/articulo1?nombre=' + nombre;
                axios.get(url).then(function(response){
                    me.arrayArticulo1=response.data;
                    // me.arrayArticulo2=response.data.data;
                
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            listarArticuloBusquedaRapida(){
                let me = this;
                // me.buscarCliente= '';
                me.isVisible = false;
                var url='/articulo1?nombre=' + me.nombre;
                axios.get(url).then(function(response){
                    me.arrayArticulo1= response.data;
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
            listarArticulo1(nombre1){
                let me=this;
                // me.buscarPaciente= '';
                me.isVisible = false;
                var url='/articulo3?nombre=' + nombre1;
                axios.get(url).then(function(response){
                    me.arrayArticulo2=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });                
            },
            listarArticuloBusquedaRapida1(){
                let me = this;
                // me.buscarCliente= '';
                me.isVisible = false;
                var url='/articulo3?nombre1=' + me.nombre1;
                axios.get(url).then(function(response){
                    me.arrayArticulo2= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            
            BuscandoProducto1(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida1,350)
            },
           
            listarCliente(buscarP){
                let me = this;
                me.buscarCliente= '';
                me.isVisible = false;
                var url='/cliente/listarSinPaginate?buscar=' + buscarP;
                axios.get(url).then(function(response){
                    me.arrayTipoCliente= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            listarClienteBusquedaRapida(){
                let me = this;
                var url='/cliente/listarSinPaginate?buscar=' + me.buscarP;
                axios.get(url).then(function(response){
                    me.arrayTipoCliente= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            BuscandoCliente(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarClienteBusquedaRapida,350)
            },
            selectedCliente(cliente){
                this.datos.cliente='';
                this.datos.id_cliente=0;
                this.datos.id_descuento='';
                this.isVisible = false;
                this.datos.cliente = cliente.nombre;
                this.datos.id_cliente = cliente.id;
                this.datos.id_descuento = cliente.descuento;
            },
            listarOrden(buscarP){
                let me = this;
                me.buscarCliente= '',
                me.isVisible = false;
                var url='/servicio/listarOrdenSinPaginate_tienda1?buscar=' + buscarP;
                axios.get(url).then(function(response){
                    me.arrayOrden= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            listarPaquete(buscarP){
                let me = this;
                me.buscarCliente= '',
                me.isVisible = false;
                var url='/paquete/listarOrdenSinPaginate?buscar=' + buscarP;
                axios.get(url).then(function(response){
                    me.arrayPaquete= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            listarPaqueteBusquedaRapida(){
                let me = this;
                var url='/paquete/listarOrdenSinPaginate?buscar=' + me.buscarP;
                axios.get(url).then(function(response){
                    me.arrayPaquete= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            BuscandoPaquete(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador2)
                me.setTimeoutBuscador2 = setTimeout(me.listarPaqueteBusquedaRapida,350)
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id_articulo==id ){
                        sw=true;
                    }
                }
                return sw;
            },
            encuentraPaquete(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id_paquete==id ){
                        sw=true;
                    }
                }
                return sw;
            },

            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index,1);
               // me.arrayDetalleProductoSimple.splice(index,1);

            },
            eliminarProductoPaquete(id){
                let array = [];
                array = this.arrayProductoPaquete.filter(item => item.id_paquete != id);
                this.arrayProductoPaquete = array;
            },

            eliminarDetalle(index){
                let me = this;
                let id_paquete = 0;
                if(me.arrayDetalle[index].producto_venta=='Venta Paquete'){
                    id_paquete = me.arrayDetalle[index].id_paquete;
                    me.eliminarProductoPaquete(id_paquete);
                }
                me.arrayDetalle.splice(index,1);
            },


            seleccionarPaquete(data=[]){
                let me = this;
                if(me.encuentraPaquete(data['id'])){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'Este paquete ya se encuentra agregado!'
                    })
                }
                else{

                    me.arrayDetalle.push({
                        //id_tienda_articulo : data['id'],
                        id_paquete : data['id'],
                        articulo : data['nombre'],
                        tienda : '',
                        costo_unitario : data['total'],
                        costo_mayorista : '',
                        costo_preferencial : '',
                        costo_compra : '',
                        marca : '',
                        id_categoria : '',
                        categoria : '',
                        stock : 1000,
                        cantidad : 1,
                        producto_venta: 'Venta Paquete'
                        //sub_total : data['sub_total'],
                    });
                    me.datos.estado= 'Entregado';
                    me.datos.tipo_venta= 'Venta Directa'
                    me.isDisabled = false;
                    me.isDisabledOrden = true;
                    //me.isDisabledPaquete = true;
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Producto agregado...',
                        showConfirmButton: false,
                        timer: 500
                    });
                }
                this.cargarDetallePaquete(data['id']);


            },

            cargarDetallePaquete(id){
                let me = this;
                var url='/paquete/permiso/detalle?id=' + id;
                axios.get(url).then(function(response){
                    me.arrayDetalleProducto= response.data;
                    me.arrayDetalleProducto.forEach(
                    item => {
                        item.cantidad_aux = item.cantidad*1;
                    });

                    if(me.arrayProductoPaquete.length==0){
                        me.arrayProductoPaquete = me.arrayDetalleProducto;
                    }else{
                        me.arrayProductoPaquete=me.arrayProductoPaquete.concat(me.arrayDetalleProducto);
                    }

                })
                .catch(function(error){
                    console.log(error);
                });
            },



            cargarArticuloPaquete(){
                this.arrayProductoPaquete = this.arrayDetalleProducto;
                // me.arrayProductoPaquete.push({
                //     id_tienda_articulo : data['id'],
                //     id_articulo : data['id_articulo'],
                //     articulo : data['articulo'],
                //     tienda : data['tienda'],
                //     costo_unitario : data['costo_unitario'],
                //     costo_mayorista : data['costo_mayorista'],
                //     costo_preferencial : data['costo_preferencial'],
                //     costo_compra : data['costo_compra'],
                //     marca : data['marca'],
                //     id_categoria : data['id_categoria'],
                //     categoria : data['categoria'],
                //     stock : data['stock'],
                //     cantidad : 1,
                //     sub_total : data['sub_total'],
                // });

            },



            // seleccionarTiendaArticulo(data=[]){
            //     let me = this;
            //     if(me.encuentra(data['id_articulo'])){
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Error...',
            //             text: 'Este producto ya se encuentra agregado!'
            //         })
            //     }
            //     else{
            //         me.arrayDetalle.push({
            //             id_tienda_articulo : data['id'],
            //             id_articulo : data['id_articulo'],
            //             nombre : data['descripcion'],
            //             tienda : data['tienda'],
            //             costo_unitario : data['costo_unitario'],
            //             costo_venta : data['costo_venta'],
            //             costo_mayorista : data['costo_mayorista'],
            //             costo_preferencial : data['costo_preferencial'],
            //             costo_compra : data['costo_compra'],
            //             marca : data['marca'],
            //             id_categoria : data['id_categoria'],
            //             categoria : data['categoria'],
            //             stock : data['stock'],
            //             cantidad : 1,
            //             sub_total : data['sub_total'],
            //             producto_venta: 'Venta Producto'
            //         });
            //         me.datos.estado= 'Entregado';
            //         me.datos.tipo_venta= 'Venta Directa'
            //         me.isDisabled = false;
            //         me.isDisabledOrden = true;
            //         me.isDisabledPaquete = true;
            //         Swal.fire({
            //             position: 'top-end',
            //             icon: 'success',
            //             title: 'Producto agregado...',
            //             showConfirmButton: false,
            //             timer: 500
            //         });
            //     }
            // },
            seleccionarTiendaArticulo(data=[]){
                let me = this;
                axios.put('/articulo/modificarMenu_Dia',{
                    id_articulo : data['id'],
                    }).then(function(response){
                        
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'modificada...',
                            showConfirmButton: false,
                            timer: 500
                        });
                        me.listarArticulo(me.nombre);
                        me.listarArticulo1(me.nombre1);
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },
            seleccionarTiendaArticulo2(data=[]){
                let me = this;
                axios.put('/articulo/modificarMenu_Dia2',{
                    id_articulo : data['id'],
                    }).then(function(response){
                        
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'modificada...',
                            showConfirmButton: false,
                            timer: 500
                        });
                        me.listarArticulo(me.nombre);
                        me.listarArticulo1(me.nombre1);
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },

            seleccionarCliente(data=[]){
                this.buscarCliente= '',
                this.datos.id_cliente=data['id'];
                this.datos.cliente= data['nombre'];
                this.datos.id_descuento= data['descuento'];
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
                var url='/cliente/selectCliente';
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
                this.usuarioNombre();
            },
            anularVenta(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Anular esta Compra??',
                    text: "Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Habilitar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/venta/anular1',{'id': id}).then(function (response) {
                        swalWithBootstrapButtons.fire(
                        'Habilitado!',
                        'Este compra se ha Anulado.',
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

            limpiarArticulo(){
                this.arrayArticulo = [];
                this.buscarP = '';
                this.buscar = '';
                this.arrayDetalle.forEach(item => item.saldoStock = 0);
            },
            limpiarCliente(){
                this.arrayTipoCliente = [];
                this.buscarP = '';
                this.buscar = '';
            },
            calcularSaldo() {
                this.datosPago.saldo = this.datos.total;
            },
            cerrarModalPago() {
                this.datosPago = this.anticipo;
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
            usuarioNombre(){
                let me=this;
                var url='/usuario_nombre'
                axios.get(url).then(function(response){
                    me.usuario_nombre=response.data;
                    me.datos.usuario= me.usuario_nombre['usuario'];
                    //me.datos.id_personal=response.data[0].id_personal;
                    // me.ClienteR(me.usuario_id['id_personal']);
                    // me.contador(me.usuario_id['id_personal']);
                })
                .catch(function(error){
                    console.log(error)

                });
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
            },
            volverMenu(){
                this.$emit('cerrarMenu', this.listadoMenu);
            }

        },
        mounted() {
            this.listarSalon();
            this.ventaDirecta();
            this.listarArticulo(this.nombre);
            this.listarArticulo1(this.nombre1);
            this.contrasena();
            this.usuarioNombre();
            this.selectCliente();
            this.selectTipoP();
            this.selectFormaP();
            this.verificarCaja();
            this.galProductos();
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
    .bg-azul{
        background-color: #3399FF;
    }
</style>
