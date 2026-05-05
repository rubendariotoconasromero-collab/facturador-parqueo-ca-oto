<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                &nbsp;
                    <div class="card">

                    <div class="card-header text-center text-white" style="background-color: #3399FF">
                        <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                            <h3 class="mb-0 col-md-11">MESEROS</h3>
                            <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row" style='margin-left: 1%'>
                            <form class="row">
                    <!-- Listado de Ventas -->
                    <template v-if="listado==0">

                                    <div  class="col-md-12">
                                        <button type="button" @click="galCategoria()" class="btn btn-outline-primary btn-sm">Nueva + Galeria</button>
                                        <!-- <button type="button" @click="galCombo()" class="btn btn-outline-info btn-sm">Combo</button> -->
                                        <!-- <button type="button" @click="galMesa()" class="btn btn-outline-primary">Mesas + Galeria</button>
                                        <button type="button" @click="galMesa2()" class="btn btn-outline-primary">Karaoke + Galeria</button> -->
                                        <!-- <button type="button" @click="listProductos()" class="btn btn-outline-secondary">Nuevo + Filtro</button> -->
                                        <button type="button" @click="ActualizarPrincipal()" class="btn btn-outline-warning btn-sm">Actualizar </button>
                                        <p> </p>
                                       <p style="font-size: 9px"> <b> Total Venta: <a>{{this.usuario_id_total['total'] ? parseFloat(this.usuario_id_total['total']) : 0}} Bs.</a></b></p>
                                       <!-- <p style="font-size: 9px"> <b> Total Venta Credito: <a>{{this.usuario_id_total2['total'] ? parseFloat(this.usuario_id_total2['total']) : 0}} Bs.</a></b></p> -->
                                    </div>
                                    <div class="row justify-content-center"  style="overflow-y: auto; height: 445px;">
                                    <div clas="table-responsive">
                                    <table class="table">
                                            <thead class="bg-negro">
                                                <tr >
                                                    <th class="text-white" scope="col"  style="font-size: 8px;">Nro</th>
                                                    <th class="text-white" scope="col" style="font-size: 8px;">Cliente</th>
                                                    <!-- <th class="text-white" scope="col" style="font-size: 8px;">Vendedor</th> -->
                                                    <!-- <th class="text-white" scope="col" style="font-size: 8px;">Cantidad</th> -->
                                                    <th class="text-white" scope="col" style="font-size: 8px;">Total</th>
                                                    <!-- <th class="text-white" scope="col" style="font-size: 8px;">F. Pago</th> -->
                                                    <th class="text-white" scope="col" style="font-size: 8px;">Estado</th>
                                                    <th class="text-white" scope="col" style="font-size: 8px; widows: 150px;">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="venta in arrayVenta" :key="venta.id">
                                                    <td  v-text="venta.nro" style="font-size: 7px;"></td>
                                                    <td v-text="venta.nmcliente" style="font-size: 7px;"></td>
                                                    <!-- <td v-text="venta.vendedor" style="font-size: 9px;"></td> -->
                                                    <!-- <td v-text="venta.cantidad" style="font-size: 9px;"></td> -->
                                                    <td v-text="venta.total" style="font-size: 7px;"></td>
                                                    <!-- <td v-text="venta.FormaPago" style="font-size: 9px;"></td> -->
                                                    <td>
                                                    <template v-if="venta.Eliminado==0">
                                                        <span class="badge bg-success" style="font-size: 7px;">Activo</span>
                                                    </template>
                                                    <template v-else>
                                                        <span class="badge bg-danger" style="font-size: 7px;">Anulado</span>
                                                    </template>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                            <button type="button" @click="verDetalle(venta.id)" class="btn btn-outline-success btn-sm" style="font-size: 7px; width: 45px;">Ver</button>
                                                            <button type="button" @click="actImpresion(venta.id)" class="btn btn-outline-warning btn-sm" style="font-size: 7px; width: 45px;">Imprimir</button>
                                                            <template v-if="venta.eliminado != 0">
                                                                <button type="button" @click="anular(venta.id)" class="btn btn-outline-danger btn-sm" style="font-size: 7px; width: 45px;">Anular</button>

                                                            </template>
                                                            <template v-else>
                                                                <button type="button" @click="anular(venta.id)" class="btn btn-outline-secondary btn-sm" disabled style="font-size:7px;width: 45px;">Anular</button>
                                                            </template>
                                                            </div>
                                                            <!-- <button type="button" @click="verDetalle(venta.id)" class="btn btn-outline-success btn-sm" style="font-size: 9px; width: 100px;">Ver</button>
                                                            <button type="button" @click="actImpresion(venta.id)" class="btn btn-outline-warning btn-sm" style="font-size: 9px; width: 100px;">Imprimir</button>
                                                            <template v-if="venta.Eliminado == 0">
                                                            <button type="button" @click="anular(venta.id)" class="btn btn-outline-danger btn-sm" style="font-size: 9px; width: 100px;">Anular</button>
                                                            </template>
                                                            <template v-else>
                                                                <button type="button" @click="anular(venta.id)" class="btn btn-outline-secondary btn-sm" disabled style="font-size:9px;width: 100px;">Anular</button>
                                                            </template> -->
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                        <!-- <template>
                                        <div>
                                            <b-table striped hover :items="items"></b-table>
                                        </div>
                                        </template> -->

                                    </div>

                                    </template>
                                    <!-- Fin Listado de Ventas -->
                                    <!-- Galeria de Categoria -->
                                    <template v-if="listado==1">
                                        <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 540px;">
                                            <div class="col" v-for="categoria in arrayCat" :key="categoria.id">
                                                <template v-if="categoria.id == 1">
                                                <div class="card" @click="galProductos2()" >
                                                    <img :src="'img/producto/'+categoria.foto" class="card-img-top" alt="" width="50" height="100">
                                                    <div class="card-footer"  style="font-size: 7px;">
                                                   <p class="text-center"><strong>{{categoria.nombre}}</strong></p>
                                                    </div>
                                                </div>
                                                </template>
                                                <template v-else>
                                                    <div class="card" @click="galProductos(categoria.id)">
                                                    <img :src="'img/producto/'+categoria.foto" class="card-img-top" alt="" width="50" height="100">
                                                    <div class="card-footer"  style="font-size: 7px;">
                                                        <p class="text-center"><strong>{{categoria.nombre}}</strong></p>
                                                    </div>
                                                </div>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button class="btn btn-outline-success btn-sm" type="button" @click="anteriorPreventa()">Volver</button>
                                        </div>
                                    </template>
                                    <!-- Fin Galeria -->

                                    <!-- Galeria de Productos -->
                                    <template v-if="listado==2">
                                        <div class="row col-sm-12">
                                            <div class="input-group mb-3">
                                            <input class="form-control"
                                                    type="search"
                                                    placeholder="Buscar nombre..."
                                                    aria-label="Search"
                                                    v-model="buscar"
                                                    @keyup="selectProductoCat">
                                            <button type="button" class="btn btn-info position-relative text-white" @click="guardarPreVenta()">Carrito
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    {{cantidadCarrito}} +
                                                    <span class="visually-hidden">Nuevo producto</span>
                                                </span>
                                            </button>
                                            </div>
                                            <!-- <div class="form-group row">
                                                <input
                                                    class="form-control"
                                                    type="search"
                                                    placeholder="Buscar nombre..."
                                                    aria-label="Search"
                                                    v-model="buscar"
                                                    @keyup="selectProductoCat"
                                                >
                                            </div>
                                            <button type="button" class="btn btn-primary position-relative" @click="guardarPreVenta()">Carrito
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    {{cantidadCarrito}} +
                                                    <span class="visually-hidden">Nuevo producto</span>
                                                </span>
                                            </button> -->
                                        </div>
                                        <div class="form-group row">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div>
                                        <!-- <label for="exampleInputPassword1" class="form-label">Tipo Pago</label>    -->
                                        <select class="form-select" v-model="datos.id_tipo_pago">
                                            <option value="0" disabled>Seleccione el Tipo Pago</option>
                                            <option v-for="tipo_pago in arrayPago" :key="tipo_pago.id" :value="tipo_pago.id" v-text="tipo_pago.nombre"></option>
                                        </select>
                                        </div>
                                        <div v-if="datos.id_tipo_pago == 2">
                                            <!-- <label for="exampleInputPassword1" class="form-label">Fecha Final</label> -->
                                            <input type="date" class="form-control"  v-model="datosPago.fecha_final">
                                        </div>
                                        <div v-if="datos.id_tipo_pago == 1">
                                            <!-- <label for="exampleInputPassword1" class="form-label">Forma Pago</label> -->
                                            <select class="form-select" v-model="datos.id_forma_pago">
                                                <option value="0" disabled>Seleccione la Forma de Pago</option>
                                                <option v-for="forma_pago in arrayForma2" :key="forma_pago.id" :value="forma_pago.id" v-text="forma_pago.nombre"></option>
                                            </select>
                                        </div>
                                            <button class="btn btn-outline-success btn-sm" type="button" @click="anteriorCategoria()">Volver</button>
                                            <button class="btn btn-outline-info btn-sm" type="button" @click="guardarPreVenta()">Guardar Venta</button>
                                        </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row row-cols-3 row-cols-md-6 g-4" style="overflow-y: auto; height: 380px;">
                                            <div class="col" v-for="producto in arrayProd" :key="producto.id">
                                                <div class="card">
                                                    <!-- <header><h3><strong>{{producto.Id_Producto}}</strong></h3></header> -->
                                                    <template>
                                                    <img @click="agregarProductoCheck(producto)" :src="'img/producto/'+producto.foto" class="card-img-top" alt="" width="50" height="100">
                                                    </template>
                                                    <div class="card-footer">
                                                        <div class="text-center" style="font-size: 8px;"><strong>{{producto.descripcion}}</strong></div>
                                                        <template v-if="producto.stock==0">
                                                                <span><div v-if="producto.eliminado==1" class="text-center" style="font-size: 8px;"><strong class="badge bg-danger">Q.: {{producto.stock}}</strong></div></span>
                                                        </template>
                                                        <template v-else>
                                                            <span><div v-if="producto.eliminado==1" class="text-center" style="font-size: 8px;"><strong>Q.: {{producto.stock}}</strong></div></span>
                                                        </template>


                                                        <div class="text-center" style="font-size: 8px;"><strong>Bs.: {{producto.precio}}</strong></div>
                                                        <div v-if="producto.Combo==1" class="text-center" style="font-size: 8px;"><button type="button" @click="galDetCombo(producto.Id_Producto,producto.descripcion)" class="btn btn-outline-success btn-sm center" style="font-size: 9px; width: 45px;">Ver</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Galeria de Paquete -->
                                    <template v-if="listado==3">
                                        <div class="row col-sm-12">
                                            <div class="input-group mb-3">
                                            <input class="form-control"
                                                    type="search"
                                                    placeholder="Buscar nombre..."
                                                    aria-label="Search"
                                                    v-model="buscar"
                                                    @keyup="selectProductoCat">
                                            <button type="button" class="btn btn-info position-relative text-white" @click="guardarPreVenta()">Carrito
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    {{cantidadCarrito}} +
                                                    <span class="visually-hidden">Nuevo producto</span>
                                                </span>
                                            </button>
                                            </div>
                                            <!-- <div class="form-group row">
                                                <input
                                                    class="form-control"
                                                    type="search"
                                                    placeholder="Buscar nombre..."
                                                    aria-label="Search"
                                                    v-model="buscar"
                                                    @keyup="selectProductoCat"
                                                >
                                            </div>
                                            <button type="button" class="btn btn-primary position-relative" @click="guardarPreVenta()">Carrito
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    {{cantidadCarrito}} +
                                                    <span class="visually-hidden">Nuevo producto</span>
                                                </span>
                                            </button> -->
                                        </div>
                                        <div class="form-group row">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div>
                                        <!-- <label for="exampleInputPassword1" class="form-label">Tipo Pago</label>    -->
                                        <select class="form-select" v-model="datos.id_tipo_pago">
                                            <option value="0" disabled>Seleccione el Tipo Pago</option>
                                            <option v-for="tipo_pago in arrayPago" :key="tipo_pago.id" :value="tipo_pago.id" v-text="tipo_pago.nombre"></option>
                                        </select>
                                        </div>
                                        <div v-if="datos.id_tipo_pago == 2">
                                            <!-- <label for="exampleInputPassword1" class="form-label">Fecha Final</label> -->
                                            <input type="date" class="form-control"  v-model="datosPago.fecha_final">
                                        </div>
                                        <div v-if="datos.id_tipo_pago == 1">
                                            <!-- <label for="exampleInputPassword1" class="form-label">Forma Pago</label> -->
                                            <select class="form-select" v-model="datos.id_forma_pago">
                                                <option value="0" disabled>Seleccione la Forma de Pago</option>
                                                <option v-for="forma_pago in arrayForma2" :key="forma_pago.id" :value="forma_pago.id" v-text="forma_pago.nombre"></option>
                                            </select>
                                        </div>
                                            <button class="btn btn-outline-success btn-sm" type="button" @click="anteriorCategoria()">Volver</button>
                                            <button class="btn btn-outline-info btn-sm" type="button" @click="guardarPreVenta()">Guardar Venta</button>
                                        </div>
                                        <br>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row row-cols-3 row-cols-md-6 g-4" style="overflow-y: auto; height: 380px;">
                                            <div class="col" v-for="producto in arrayPaquete" :key="producto.id">
                                                <div class="card">
                                                    <!-- <header><h3><strong>{{producto.id}}</strong></h3></header> -->
                                                    <template>
                                                    <img @click="agregarProductoCheck2(producto)" :src="'img/producto/'+producto.foto" class="card-img-top" alt="" width="50" height="100">
                                                    </template>
                                                    <div class="card-footer">
                                                        <div class="text-center" style="font-size: 8px;"><strong>{{producto.descripcion}}</strong></div>
                                                        <template v-if="producto.stock==0">
                                                                <span><div v-if="producto.eliminado==1" class="text-center" style="font-size: 8px;"><strong class="badge bg-danger">Q.: {{producto.stock}}</strong></div></span>
                                                        </template>
                                                        <template v-else>
                                                            <span><div v-if="producto.eliminado==1" class="text-center" style="font-size: 8px;"><strong>Q.: {{producto.stock}}</strong></div></span>
                                                        </template>


                                                        <div class="text-center" style="font-size: 8px;"><strong>Bs.: {{producto.precio}}</strong></div>
                                                        <div class="text-center" style="font-size: 8px;"><button type="button" @click="galDetCombo(producto.id,producto.descripcion)" class="btn btn-outline-success btn-sm center" style="font-size: 9px; width: 45px;">Ver</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <!-- Galeria de Detalle Combo -->
                                    <template v-if="listado==8">
                                        <h2 class="text-center">Detallle del : {{datos.nombreCombo}}</h2>
                                        <div class="row row-cols-2 row-cols-md-6 g-4" style="overflow-y: auto; height: 540px;">
                                            <div class="col" v-for="detCombo in arrayDetCombo" :key="detCombo.id">
                                                <div class="card" @click="galDetCombo(detCombo.id)">
                                                    <img :src="'img/producto/'+detCombo.foto" class="card-img-top" alt="" width="50" height="100">
                                                    <div class="card-footer"  style="font-size: 7px;">
                                                        <div class="text-center" style="font-size: 8px;"><strong>{{detCombo.descripcion}}</strong></div>
                                                            <div class="text-center" style="font-size: 8px;"><strong>Cantidad.: {{detCombo.cantidad}}</strong></div>
                                                            <template v-if="detCombo.stock==0">
                                                                <span><div class="text-center" style="font-size: 8px;"><strong class="badge bg-danger">Q.: {{detCombo.stock}}</strong></div></span>
                                                            </template>
                                                            <template v-else>
                                                                <span> <div class="text-center" style="font-size: 8px;"><strong>Q.: {{detCombo.stock}}</strong></div></span>
                                                            </template>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button class="btn btn-outline-success btn-sm" type="button" @click="anteriorCombo()">Volver</button>
                                        </div>
                                    </template>
                                    <template v-if="listado==5">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Nombre Cliente:</label>
                                            <input type="text" class="form-control" v-model="datos.cliente" disabled>
                                        </div>
                                        <br>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Precio Venta</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">SubTotal</th>
                                            </thead>
                                            <tbody v-if="arrayDet.length">
                                                <tr v-for="detalle in arrayDet" :key="detalle.id">
                                                    <td v-text="detalle.producto"></td>
                                                    <td v-text="detalle.precio + ' bs'"></td>
                                                    <td v-text="detalle.cantidad"></td>
                                                    <td>{{detalle.SubTotal = detalle.precio*detalle.cantidad}}</td>
                                                </tr>
                                                <tr style="background-color: #CEECF5">
                                                    <td colspan="3" align="right"> <strong>Monto Total:</strong> </td>
                                                    <td>{{datos.monto}} bs</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button class="btn btn-outline-success " type="button" @click="anteriorPreventa()">Volver</button>
                                        </div>
                                    </template>
                            </form>
                        </div>
                    </div>
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
                    id_tipo_pago : 1,
                    id_forma_pago : 2,
                    nombre : '',
                    fecha :  moment().format('YYYY-MM-DD'),
                    cantidad : 0,
                    asistencia : 0,
                    estado : 0,
                    eliminado : 0,
                    id_personal : 0,
                    id_usuario : 0,
                    personal : '',
                    cliente : '',
                    usuario : '',
                    nombreCombo:'',
                    tipo_venta: 'Venta Mesero',
                    id_cliente: null,

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
                arrayPago:[],
                arrayForma:[],
                arrayForma2:[],
                arrayDetCombo:[],
                arrayClienteR:[],
                arrayCat:[],
                arrayProd:[],
                arrayPaquete:[],
                arrayVenta:[],
                arrayDetalle : [],
                arrayDetalle2 : [],
                arrayDetalleProducto : [],
                arrayProductoPaquete : [],
                arrayDetalleCombo : [],
                arrayDet : [],
                contrasena_id : [],
                arrayCorrelativoEstado : [],
                arrayContador : [],
                cantidad_cliente:0,
                usuario_id:0,
                usuario_id_total:0,
                usuario_id_total2:0,
                usuario_nombre:0,
                buscar : '',
                listado:0,
                id_categoria : 0,
                sub_listado : 0,
                cantidad_producto : 0,
                listadoMenu: 0,
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
            },
            cantidadCarrito: function(){
                var resultado = 0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado = resultado + 1;
                }
                return resultado;
            },
            // validarStock(){
            //     let me = this;
            //         //me.listarArticulo('', 'nombre_comercial');
            //         me.arrayDetalleProducto.forEach(
            //             item => {
            //                 console.log('Prueba')
            //                 //item.cantidad_aux = item.cantidad*me.cantidad_producto;

            //                 me.arrayProd.forEach( item2 => {item2.id == item.Id_Producto ?  (item2.stock=item2.stock-1, console.log('Prueba')) : ''})
            //         });
            // }
        },
        methods : {
            contador(){
                let me = this;
                var url='/index';
                axios.get(url).then(function(response){
                    me.arrayContador = response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            correlativoEstado(){
                let me = this;
                var url='/estado';
                axios.get(url).then(function(response){
                    me.arrayCorrelativoEstado = response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            actImpresion(id){
                let me = this;
                //me.arrayVenta.id= id;
                //me.listado = 4;
                var url='/venta_imp?id_venta='+id;
                axios.put(url).then(function(response){
                    //me.arrayDetalle = response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Imprimiendo...',
                    showConfirmButton: false,
                    timer: 1000
                });
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
            usuarioNombre(){
                let me=this;
                var url='/usuario_nombre'
                axios.get(url).then(function(response){
                    me.usuario_nombre=response.data;
                    me.datos.usuario= me.usuario_nombre['usuario'];
                    me.datos.id_usuario= me.usuario_nombre['id'];
                    me.preVenta();
                    //me.datos.id_personal=response.data[0].id_personal;
                    // me.ClienteR(me.usuario_id['id_personal']);
                    // me.contador(me.usuario_id['id_personal']);
                })
                .catch(function(error){
                    console.log(error)

                });
            },
            preVenta(){
                let me = this;
                me.listado = 0;
                me.datos.cliente = '';
                var url='/preventa?id_usuario='+me.datos.id_usuario;
                axios.get(url).then(function(response){
                    me.arrayVenta = response.data;
                    me.usuarioIDTotal()
                    me.usuarioIDTotal2()
                    // me.Total()
                    // me.usuarioID2()


                })
                .catch(function(error){
                    console.log(error)
                });
            },
            Actualizar(){
                let me = this;
                // me.contador();
                 me.preVenta();
                 me.limpiar();
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: 'Sistema Actualizado...',
                //     showConfirmButton: false,
                //     timer: 2000
                // });
            },
            ActualizarPrincipal(){
                let me = this;
                // me.contador();
                 me.preVenta();
                 me.limpiar();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Sistema Actualizado...',
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            limpiar()
            {
                this.nmcliente='';
                this.arrayDetalle=[];
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
            galCategoria(){
            let me = this;
            if(me.arrayCorrelativoEstado[0].estado != 0){
                    //me.logout();
                    Swal.fire({
                        position: 'top-end',
                            icon: 'warning',
                            title: 'Apertura de caja por favor...',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    // setTimeout(function(){
                    //     location. reload();
                    // }, 2000);
                }else{

                    me.contador();
                    me.preVenta();
                    me.listado=1;
                    var url='/categoria2';
                    axios.get(url).then(function(response){
                        me.arrayCat = response.data;

                    })
                    .catch(function(error){
                        console.log(error)


                    });


                }
            },
            galProductos(id){
                let me = this;
                me.listado=2;
                me.id_categoria = id;
                var url='/producto?id_categoria='+id;
                axios.get(url).then(function(response){
                    me.arrayProd = response.data;
                    me.arrayProductoPaquete.forEach(element => {
                        // me.actualizarStockProducto(element.Id_Producto)
                        console.log(element.id_articulo);
                        //me.listarArticulo('', 'nombre_comercial');
                        // if(item2.paquete == 'Venta Paquete'){
                            me.arrayProd.forEach(
                                item => {
                                    //console.log(item2)

                                    item.Id_Producto == element.id_articulo ? item.stock= item.stock-element.cantidad : '';
                                    // me.cantidad_producto = item.cantidad_aux;

                                });
                // }
                    });

                    me.selectTipoP();
                    me.selectFormaP();
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            galProductos2(){
                let me = this;
                me.listado=3;
                //me.id_categoria = id;
                var url='/paquete2';
                axios.get(url).then(function(response){
                    me.arrayPaquete = response.data;
                    me.selectTipoP();
                    me.selectFormaP();
                })

                .catch(function(error){
                    console.log(error)
                });
            },
            actualizarStockProducto(item2){
                let me = this;
                console.log(item2);
                //me.listarArticulo('', 'nombre_comercial');
                // if(item2.paquete == 'Venta Paquete'){
                    me.arrayProd.forEach(
                        item => {
                            console.log(item2)

                            item.Id_Producto == item2.Id_Producto ? item.stock= item.stock*2 : '';
                            // me.cantidad_producto = item.cantidad_aux;

                        });
                // }

            },
            selectProductoCat: function() {
                let me = this;
                var url='/category/producto?filtro='+me.buscar+'&id_categoria='+me.id_categoria;
                axios.get(url).then(function(response){
                    me.arrayProd= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            anteriorCategoria(){
                let me = this;
                //me.preVenta();
                me.listado=1;
                //me.arrayProd=[];
            },
            anteriorPreventa(){
                let me = this;
                me.contador();
                me.preVenta();
                me.listado=0;
                me.datos.cliente = '';
               // me.datos.id_mesa=0,
                me.arrayCat=[];
                //me.arrayDet=[];
                me.arrayDetalle=[];
                //me.arrayDetalleCombo=[];
                //me.limpiarDetalle();
            },
            anteriorCombo(){
                let me = this;
                me.contador();
                me.preVenta();
                //me.arrayDetCombo=[];
                me.listado=3;
            },
            encuentraDelete(id){
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id_articulo==id){
                        this.eliminarDetalle(i);
                    }
                }
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index,1);
            },
            encuentraPaquete(id){
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id_paquete==id ){
                        this.eliminarDetalle(i);
                        this.arrayProductoPaquete=[];
                    }
                }

            },
            agregarProductoCheck(data=[]){
                let me = this;
                // if(me.arrayCorrelativoEstado[0].Estado != 0){
                //     Swal.fire({
                //             icon: 'error',
                //             title: 'Error...',
                //             text: 'No Existe productos agregados!'
                //         })
                // }else{
                me.encuentraDelete(data['Id_Producto'])

                Swal.fire({

                    title: 'Pedido N. : '+me.arrayContador[0].Correlativo+'\n'+'ㅤㅤ'+'Ingrese la cantidad ㅤㅤㅤ \n'+data['descripcion']+'ㅤ \n'+data['precio']+' bs.',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {

                        if((cant>parseInt(data['stock']) || cant=='')&& data['eliminado'] == 1 ){
                            Swal.showValidationMessage(
                                `Cantidad invalida :)`
                            )
                        }else{
                            me.arrayDetalle.push({
                                id_tienda_articulo : data['Id_Producto'],
                                id_articulo : data['Id_Producto'],
                                cantidad : cant,
                                articulo : data['descripcion'],
                                precio : data['precio'],
                                costo_unitario : data['precio'],
                                costo_venta : data['precio'],
                                //combo : data['Combo'],
                                preciov : 0,
                                stock : parseInt(data['stock']),
                                producto_venta: 'Venta Producto'
                                //tipo_producto: data['tipo_producto']
                            });
                        }

                         //me.agregarProductoCombo(data['Id_Producto'],cant);
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
            agregarProductoCheck2(data=[]){
                let me = this;
                // if(me.arrayCorrelativoEstado[0].Estado != 0){
                //     Swal.fire({
                //             icon: 'error',
                //             title: 'Error...',
                //             text: 'No Existe productos agregados!'
                //         })
                // }else{
                me.encuentraPaquete(data['id'])

                Swal.fire({

                    title: 'Pedido N. : '+me.arrayContador[0].Correlativo+'\n'+'ㅤㅤ'+'Ingrese la cantidad ㅤㅤㅤ \n'+data['descripcion']+'ㅤ \n'+data['precio']+' bs.',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {

                        // if((cant>parseInt(data['stock']) || cant=='') ){
                        //     Swal.showValidationMessage(
                        //         `Cantidad invalida :)`
                        //     )
                        // }else{
                            me.arrayDetalle.push({
                                id_paquete : data['id'],
                                cantidad : cant,
                                producto : data['descripcion'],
                                precio : data['precio'],
                                //combo : data['Combo'],
                                preciov : 0,
                                stock : 0,
                                producto_venta: 'Venta Paquete'
                            });
                        //}
                        //   me.cargarDetallePaquete(data['id']);

                         me.cargarDetallePaquete(data['id'],cant);
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
            cargarDetallePaquete(id,cant){
                let me = this;
                var url='/paquete/permiso/detalle?id=' + id;
                axios.get(url).then(function(response){
                    me.arrayDetalleProducto= response.data;
                    me.arrayDetalleProducto.forEach(item => {item.cantidad =parseInt(item.cantidad)*cant});

                    //me.arrayProd.forEach( item2 => {item2.Id_Producto == item.id_articulo ?  (item2.stock=item2.stock-item.cantidad, console.log('Prueba')) : ''})


                    if(me.arrayProductoPaquete.length==0){
                        me.arrayProductoPaquete = me.arrayDetalleProducto;
                    }else{
                        me.arrayProductoPaquete=me.arrayProductoPaquete.concat(me.arrayDetalleProducto);
                    }
                    if(me.arrayProductoPaquete.find(seg => (seg.stock - ((seg.cantidad)) < 0 ))){

                                    Swal.fire({
                                            icon: 'error',
                                            title: 'Error...',
                                            text: 'No hay stock para el producto!'
                                        })
                                        me.arrayDetalle=[];
                                        me.arrayProductoPaquete=[];
                                        //me.cantidad_producto=0;
                                    } else {

                                    console.log(me.arrayDetalle);

                                    me.arrayDetalle.forEach(element => {
                                        if(element.producto_venta != 'Venta Paquete'){
                                    // me.actualizarStockProducto(element.Id_Producto)
                                    console.log(element.id_articulo);
                                    //me.listarArticulo('', 'nombre_comercial');
                                    // if(item2.paquete == 'Venta Paquete'){
                                        me.arrayProductoPaquete.forEach(
                                            item => {
                                                console.log(item.id_articulo);

                                                item.id_articulo == element.id_articulo ?  item.cantidad=( parseFloat(item.cantidad)+ parseFloat(element.cantidad)) : '';
                                                if(item.stock - ((item.cantidad)) < 0 ){
                                                    Swal.fire({
                                                icon: 'error',
                                                title: 'Error...',
                                                text: 'No hay stock para el producto!'
                                            })
                                            me.arrayDetalle=[];
                                            me.arrayProductoPaquete=[];
                                                }
                                                // me.cantidad_producto = item.cantidad_aux;

                                            });
                                            }
                            // }
                                });

                                    }


                })
                .catch(function(error){
                    console.log(error);
                });
            },
            agregarProductoCombo(id,cant){
                let me = this;
                var url='/paquete/permiso/detalle?id='+ id;
                                axios.get(url).then(function(response){
                                    me.arrayDetalleCombo= response.data;
                                    me.arrayDetalleCombo.forEach(item => item.cantidad =parseInt(item.cantidad)*cant);
                                   if(me.arrayDetalleProducto.length==0){
                                        me.arrayDetalleProducto = me.arrayDetalleCombo;
                                    }else{
                                        me.arrayDetalleProducto=me.arrayDetalleProducto.concat(me.arrayDetalleCombo);
                                    }
                                    if(me.arrayDetalleProducto.find(seg => (seg.stock - ((seg.cantidad)) < 0 ))){

                                    Swal.fire({
                                            icon: 'error',
                                            title: 'Error...',
                                            text: 'No hay stock para el producto!'
                                        })
                                        me.arrayDetalle=[];
                                        me.arrayDetalleProducto=[];
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

                //  Swal.fire({

                //     title: 'Pedido N. : '+me.arrayContador[0].Correlativo+'\n'+'ㅤㅤ'+'Ingrese la cantidad ㅤㅤㅤ \n',
                //     input: 'number',
                //     inputAttributes: {
                //         autocapitalize: 'off',
                //         size: 3
                //     },
                //     showCancelButton: true,
                //     confirmButtonText: 'Guardar',
                //     showLoaderOnConfirm: true,




                //             preConfirm: (cant) => {
                //             // console.log(me.arrayDetalle);
                //             if(me.arrayDetalleCombo.find(seg => (seg.stock - ((seg.cantidad)*cant) < 0 ))){
                //                 Swal.fire({
                //                     icon: 'error',
                //                     title: 'Error...',
                //                     text: 'No hay stock para el producto!'
                //                 })
                //             } else {

                //                 var url='/combo/detalle?id_combo='+data['Id_Producto'];
                //                 axios.get(url).then(function(response){
                //                     me.arrayDetalleCombo= response.data;
                //                    // me.arrayDetalle.forEach(item => item.cantidad =parseInt(item.cantidad)*cant);
                //                 })
                //                 .catch(function(error){
                //                     console.log(error);
                //                 });
                //             }




                //     },
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             Swal.fire({
                //                 position: 'top-end',
                //                 icon: 'success',
                //                 title: 'Producto agregado...',
                //                 showConfirmButton: false,
                //                 timer: 500
                //             });
                //         }
                //     })
               //}
            },
            guardarPreVenta(){
                let me = this;
                if(this.sub_listado!=0){
                    this.listado=4;
                }
                else{
                    if(this.arrayDetalle.length<=0){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'No Existe productos agregados!'
                        })
                    }
                    else
                    {
                    //console.log('Hola')    ;
                    if(this.arrayProductoPaquete.find(seg => (seg.stock - seg.cantidad_aux < 0 && seg.tipo_producto == 'Producto Venta'))){
                        me.cantidad_producto=0;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'No hay stock para el paquete!'
                        })
                    } else
                    {
                        //

                        Swal.fire({
                        title: 'Ingrese nombre del Cliente',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        showLoaderOnConfirm: true,
                        preConfirm: (nmcliente) => {

                                var resultado = 0.0;
                                for(var i=0;i<this.arrayDetalle.length;i++){
                                    resultado = resultado + (this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad);
                                }
                                axios.post('/venta/guardar/mesero',{
                                    'id_servicio': me.datos.id,
                                    'fecha': me.datos.fecha,
                                    'usuario': me.datos.usuario,
                                    'fecha_final': me.datosPago.fecha_final,
                                    // 'id_cliente': me.datos.id_cliente,
                                    'tipo_venta': me.datos.tipo_venta,
                                    'id_tipo_pago': me.datos.id_tipo_pago,
                                    'id_forma_pago': (me.datos.id_tipo_pago == 2) ? me.arrayForma[0].id : me.datos.id_forma_pago,
                                    'estado': me.datos.estado,
                                    //'usuario': me.datos.usuario,
                                    'id_usuario': me.datos.id_usuario,
                                    'cliente': nmcliente,
                                    'FormaPago': me.datos.FormaPago,
                                    'monto': resultado,
                                    'saldo': me.datosPago.saldo,
                                    'monto_total':resultado,
                                    'detalle': me.arrayDetalle,
                                    'tipo_producto': me.datos.tipo_producto,
                                    'stock_detalle_producto' : me.arrayDetalleProducto ,
                                    'stock_producto_paquete': me.arrayProductoPaquete

                                }).then(function(response){

                                    me.arrayDetalle=[];
                                    me.arrayDet = [];
                                    me.arrayCat=[];
                                    me.arrayProd=[];
                                    me.arrayDetalleProducto=[];
                                    me.buscar = '';
                                    me.listado = 0;
                                    me.preVenta();
                                    //me.contador();
                                    me.datos.cliente ='';
                                    // me.datos.monto = 0;
                                    me.id_categoria = 0;
                                    me.cantidad_producto = 0;
                                    //me.datos.id_mesa = 0;
                                    //me.datos.FormaPago = 'Contado';
                                })
                                .catch(function(error){
                                    console.log(error);
                                });

                        },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Venta registrada...',
                                    showConfirmButton: false,
                                    timer: 500
                                });
                            }
                        //me.agregarProductoCombo(me.datos.id);
                        // me.cargar2();
                        // me.Actualizar();


                    })
                    }
                    }

                }
            },
            anular(id){
                Swal.fire({

                    title: 'Ingrese credenciales para anular la venta?',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        size: 3
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (cant) => {

                        if((cant!=this.contrasena_id.nombre)  || cant==''){
                            Swal.showValidationMessage(
                                `Contraseña Incorrecta :)`
                            )
                        }else{
                            axios.put('/venta_anular',{'id': id});
                        }
                        // me.Actualizar();
                    },
                    }).then((result) => {
                        //me.Actualizar();
                        if (result.isConfirmed) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Venta Anulada...',
                                showConfirmButton: false,
                                timer: 500
                            });
                        }
                                this.Actualizar();
                })
               // me.Actualizar();
            },
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
            galDetCombo(id,nombre){
                let me = this;
                me.listado=8;
                    var url='/paquete/permiso/detalle/venta/paquete?id='+ id;
                axios.get(url).then(function(response){
                    me.arrayDetCombo = response.data;
                     me.datos.nombreCombo = nombre;
                })
                .catch(function(error){
                    console.log(error)
                });

                //me.agregarProductoCombo(id)
            },
            verDetalle(id){
                let me = this;
                me.arrayDet = [];
                me.listado=5;

                var url='/venta/cabecera?id_venta='+id;
                axios.get(url).then(function(response){
                    me.datos.cliente= response.data.cliente;
                    me.datos.monto = response.data.monto;
                    me.datos.total = response.data.total;
                })
                .catch(function(error){
                    console.log(error);
                });

                var url='/venta/detalle?id_venta='+id;
                axios.get(url).then(function(response){
                    me.arrayDet= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });

                var url='/paquete/permiso/detalle/venta/paquete?id=' + id;
                axios.get(url).then(function(response){
                    me.arrayDetalle2= response.data;
                    if(me.arrayDet.length==0){
                        me.arrayDet = me.arrayDetalle2;
                    }else{
                        me.arrayDet=me.arrayDet.concat(me.arrayDetalle2);
                    }
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            usuarioIDTotal(){
                let me=this;
                var url='/usuario_id/total?id_usuario='+me.datos.id_usuario;
                axios.get(url).then(function(response){
                    me.usuario_id_total=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            usuarioIDTotal2(){
                let me=this;
                var url='/usuario_id/total/credito?id_usuario='+me.datos.id_usuario;
                axios.get(url).then(function(response){
                    me.usuario_id_total2=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            volverMenu(){
                this.$emit('cerrarMenu', this.listadoMenu);
            }
        },

        mounted() {
            this.usuarioNombre();
            this.correlativoEstado();
            this.preVenta();
            this.ClienteR();
            this.contrasena();
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
    .bg-negro{
     background-color: 	#000000 !important;
     /* color: white !important; */
    }

</style>
