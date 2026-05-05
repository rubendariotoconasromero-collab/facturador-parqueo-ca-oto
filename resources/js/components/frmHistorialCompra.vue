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
                            <h5 class="mb-0 col-md-11">HISTORIAL COMPRAS</h5>
                            <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                        </div>
                    </div>

                        <div class="form-group row">
                            <div class="col-md-8">
                                &nbsp;&nbsp;<div class="input-group" style='width:96%;margin-left: 3.3%;font-size: 0.8rem'>
                                    <template v-if="usuario.id_tienda == 100">
                                        <select class="form-select" v-model="tienda" @change="listarCompra(1, buscar, criterio)" style='font-size: 0.8rem'>
                                            <!-- <option value="1" disabled>Seleccione la Tienda</option> -->
                                            <option v-for="tienda in arrayTienda2" :key="tienda.id" :value="tienda.id" v-text="tienda.nombre"></option>
                                        </select>
                                    </template>
                                    &nbsp;
                                    <select class="form-select col-md-3" v-model="criterio" style='font-size: 0.8rem'>
                                        <option value="proveedor.nombre">Proveedor</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="text" v-model="buscar" @keyup.enter="listarCompra(1, buscar, criterio)" @keyup="BuscandoCompra()" class="form-control" placeholder="Texto a buscar" style='font-size: 0.8rem'>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit" @click="listarCompra(1, buscar, criterio)" class="btn btn-info text-white" style='font-size: 0.8rem'><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- Light table -->
                        <div class="table-responsive">
                        <table class="table table-striped table-hover" style='width:96%;margin-left: 2.2%;font-size: 0.8rem'>
                            <thead style="background-color: #46546C">
                                <tr>
                                    <th scope="col" class="text-white" style='font-size: 0.8rem'>Fecha</th>
                                    <th scope="col" class="text-white" style='font-size: 0.8rem'>Proveedor</th>
                                    <!-- <th scope="col" class="text-white" style='font-size: 0.8rem'>Usuario</th>
                                    <th scope="col" class="text-white" style='font-size: 0.8rem'>Descripcion</th>
                                    <th scope="col" class="text-white" style='font-size: 0.8rem'>Descuento</th> -->
                                    <th scope="col" class="text-white" style='font-size: 0.8rem'>Total</th>
                                    <th scope="col" class="text-white text-center" style='font-size: 0.8rem'>Estado</th>
                                    <th scope="col" class="text-white" style='font-size: 0.8rem'>Forma P.</th>
                                    <th scope="col" class="text-white" style='font-size: 0.8rem'>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="compra in arrayCompra" :key="compra.id">
                                    <td v-text="compra.fecha" style='font-size: 0.8rem'></td>
                                    <td v-text="compra.proveedor" style='font-size: 0.8rem'></td>
                                    <!-- <td v-text="compra.name"></td>
                                    <td v-text="compra.descripcion"></td>
                                    <td v-text="compra.descuento"></td> -->
                                    <td v-text="compra.total" style='font-size: 0.8rem'></td>
                                    <td class="text-center" style='font-size: 0.8rem'>
                                        <template v-if="compra.estado=='Registrado'">
                                            <span class="badge bg-success tamaño text-white" style='font-size: 0.8rem'>{{compra.estado}}</span>
                                        </template>
                                        <template v-if="compra.estado=='Anulado'">
                                            <span class="badge bg-danger tamaño text-white" style='font-size: 0.8rem'>{{compra.estado}}</span>
                                        </template>
                                    </td>
                                    <td v-text="compra.formaP" style='font-size: 0.8rem'></td>
                                    <td style='font-size: 0.8rem'>
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style='font-size: 0.8rem'>Accion</button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#" @click="verCompra(compra)"><i class="fa fa-eye text-success"></i> Ver detalle</a></li>
                                            <li><a class="dropdown-item" href="#" @click="cargarPdf(compra.id)"><i class="fa fa-file-pdf-o text-danger"></i> Imprimir</a></li>

                                            <template v-if="compra.estado=='Registrado'">
                                                <li><a class="dropdown-item" href="#" @click="anularCompra(compra.id)"><i class="fa fa-lock text-danger"></i> Anular</a></li>
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
                    </template>
                    <template v-if="listado==1">
                        <div class="card-body">
                            <!-- <button type="button" class="btn btn-danger text-white" @click="volverCompraListado()"><i class="fa fa-reply-all"></i>&nbsp;Volver</button>
                            <div class="card-header text-center" style="background-color: #CEECF5"><h3 class="mb-0">REGISTRO DE COMPRA - ALMACEN GENERAL</h3></div>                             -->
                            <div class="form-group row">
                            <form class="row">
                                <div class="col-md-6">
                                <label for="exampleInputPassword1" class="form-label">Proveedor</label>
                                    <select class="form-select" v-model="datos.id_proveedor">
                                        <option value="0" disabled>Seleccione el Proveedor</option>
                                        <option v-for="proveedor in arrayProveedor" :key="proveedor.id" :value="proveedor.id" v-text="proveedor.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Fecha</label>
                                    <input type="date" class="form-control"  v-model="datos.fecha" disabled>
                                </div>
                                <div class="col-md-6">
                                <label for="exampleInputPassword1" class="form-label">Forma Pago</label>
                                    <select class="form-select" v-model="datos.id_forma_pago">
                                        <option value="0" disabled>Seleccione la Forma Pago</option>
                                        <option  v-for="forma_pago in arrayFormaPago" :key="forma_pago.id" :value="forma_pago.id " v-text="forma_pago.nombre"></option>
                                    </select>
                                </div>
                                <!-- <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Descuento</label>
                                    <input type="number" class="form-controls" v-model="datos.descuento">
                                </div> -->

                                <div class="col-md-12">
                                    <label for="exampleInputPassword1" class="form-label">Descripcion</label>
                                    <textarea class="form-control" v-model="datos.descripcion" rows="2"></textarea>
                                </div>
                                &nbsp;
                                <div class="col-md-12">
                                    <label>Articulos<span style="color:red;" >(*Seleccione)</span></label>
                                    <button type="button" class="btn btn-info text-white position-relative" data-bs-toggle="modal" data-bs-target="#modalArticulo"><i class="fa fa-search"></i> Agregar Articulos</button>
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
                                <table class="table table-striped table-hover">
                                    <thead style="background-color: #46546C">
                                        <tr>
                                            <th scope="col" class="text-white">Opción</th>
                                            <th scope="col" class="text-white">Categoria</th>
                                            <th scope="col" class="text-white">Nombre</th>
                                            <th scope="col" class="text-white">Marca</th>
                                            <th scope="col" class="text-white">Tienda</th>
                                            <th scope="col" class="text-white">Precio</th>
                                            <th scope="col" class="text-white">Cantidad</th>
                                            <th scope="col" class="text-white">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm"><i class="icon-trash text-white"></i></button>
                                            </td>
                                            <td v-text="detalle.categoria"></td>
                                            <td v-text="detalle.articulo"></td>
                                            <td v-text="detalle.marca"></td>
                                            <td v-text="detalle.tienda"></td>
                                            <td><input v-model="detalle.costo_compra" type="number" value="3" class="form-control"></td>
                                            <td><input v-model="detalle.cantidad" type="number" value="3" class="form-control"></td>
                                            <td>{{detalle.sub_total = detalle.costo_compra*detalle.cantidad}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5">
                                            <td colspan="5" align="right"> <strong>Total:</strong> </td>
                                            <td>{{datos.total = calcularTotal.toFixed(2)}} bs</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5">
                                            <td colspan="5" align="right"> <strong>Descuento:</strong> </td>
                                            <td><input v-model="datos.descuento" type="number" value="0" class="form-control"></td>
                                        </tr>
                                         <tr style="background-color: #CEECF5">
                                            <td colspan="5" align="right"> <strong>Sub Total:</strong> </td>
                                            <td>{{datos.sub_total = datos.total- datos.descuento}} bs</td>
                                        </tr>

                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">No hay Permisos agregados</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-danger me-md-2 text-white" type="button" @click="volverCompraListado()">Cancelar</button>
                                <button class="btn btn-info btn-lg text-white" type="button" @click="guardarCompra()">Guardar</button>
                            </div>
                        </div>
                    </template>

                    <template v-if="listado==2">
                        <!-- <div class="card-header row m-0">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-danger text-white" @click="volverCompraListado()">
                                    <i class="fa fa-reply-all"></i>&nbsp;Volver
                                </button>
                                <button type="button" @click="cargarPdf(datos.id, datos.foto)" class="btn btn-info">
                                    <i class="icon-doc text-white"></i><span class="text-white">&nbsp;Reporte</span>
                                </button>
                            </div>
                            <div class="col-md-4 text-center"><h3 class="mb-0">REGISTRO DE COMPRA</h3></div>
                            <div class="col-md-4">&nbsp;</div>
                        </div> -->
                        <div class="card-header text-center">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">REGISTRO DE COMPRA</h5>
                                <button type="button" class="btn-close btn-close" @click="volverCompraListado()" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="card-body" >
                            <!-- <button type="button" class="btn btn-danger text-white" @click="volverCompraListado()"><i class="fa fa-reply-all"></i>&nbsp;Volver</button> -->
                            <div class="form-group row">
                                <form class="row g-1" >
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Proveedor</label>
                                    <input type="text" class="form-control"  v-model="datos.proveedor" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Fecha</label>
                                    <input type="date" class="form-control"  v-model="datos.fecha" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Forma Pago</label>
                                    <input type="text" class="form-control"  v-model="datos.formaPago" disabled>
                                </div>
                                <!-- <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Descuento</label>
                                    <input type="number" class="form-control" v-model="datos.descuento">
                                </div> -->

                                <div class="col-md-12">
                                    <label for="exampleInputPassword1" class="form-label">Descripcion</label>
                                    <textarea class="form-control" v-model="datos.descripcion" rows="2" disabled></textarea>
                                </div>

                            </form>
                            </div>

                            <br>
                            <div class="form-group row">
                                <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead style="background-color: #46546C">
                                        <tr>
                                            <!-- <th scope="col" class="text-white">Categoria</th> -->
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Nombre</th>
                                            <!-- <th scope="col" class="text-white" style='font-size: 0.8rem'>Marca</th>
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Tienda</th> -->
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Precio</th>
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Cantidad</th>
                                            <th scope="col" class="text-white" style='font-size: 0.8rem'>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <!-- <td v-text="detalle.categoria"></td> -->
                                            <td v-text="detalle.articulo" style='font-size: 0.8rem'></td>
                                            <!-- <td v-text="detalle.marca"></td>
                                            <td v-text="detalle.tienda"></td> -->
                                            <td v-text="detalle.costo_compra" style='font-size: 0.8rem'></td>
                                            <td v-text="detalle.cantidad" style='font-size: 0.8rem'></td>
                                            <td v-text="detalle.sub_total" style='font-size: 0.8rem'></td>
                                        </tr>
                                        <tr style="background-color: #CEECF5">
                                            <td colspan="3" align="right" style='font-size: 0.8rem'> <strong>Total:</strong> </td>
                                            <td style='font-size: 0.8rem'>{{datos.total = calcularTotal.toFixed(2)}} bs</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5">
                                            <td colspan="3" align="right" style='font-size: 0.8rem'> <strong>Descuento:</strong> </td>
                                            <td v-text="datos.descuento" style='font-size: 0.8rem'></td>
                                        </tr>
                                         <tr style="background-color: #CEECF5">
                                            <td colspan="3" align="right" style='font-size: 0.8rem'> <strong>Sub Total:</strong> </td>
                                            <td style='font-size: 0.8rem'>{{datos.sub_total = (datos.total- datos.descuento).toFixed(2)}} bs</td>
                                        </tr>
                                        <template v-if="datos.id_forma_pago ==6">
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="3" align="right" style='font-size: 0.8rem'> <strong>Total Efect.:</strong> </td>
                                                <td v-text="datos.total_efectivo" style='font-size: 0.8rem'></td>

                                                <!-- <td>
                                                     <input v-model="datos.total_efectivo" value="0" class="form-control" >

                                                </td> -->
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="3" align="right" style='font-size: 0.8rem'> <strong>Total Dep.:</strong> </td>
                                                <td style='font-size: 0.8rem'>{{datos.total_deposito = datos.total- datos.total_efectivo}} bs</td>
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
                        </div>
                    </template>
                </div>
                </div>
            </div>
        <!-- </div>   -->

        <!--Modal Formulario Articulo-->
        <div class="modal fade" id="modalArticulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white">
                        <h4 class="modal-title ">Busqueda de Articulos</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" v-model="buscarP" @keyup.enter="listarArticulo(buscarP)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulo(buscarP)" class="btn btn-primary text-white"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead style="background-color: #46546C">
                                <tr>
                                    <th scope="col" class="text-white">Nombre</th>
                                    <th scope="col" class="text-white">Tienda</th>
                                    <th scope="col" class="text-white">Precio</th>
                                    <th scope="col" class="text-white">Opción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tienda_articulo in arrayArticulo" :key="tienda_articulo.id">
                                    <td v-text="tienda_articulo.articulo"></td>
                                    <td v-text="tienda_articulo.tienda"></td>
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
    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    import moment from 'moment';
    export default {
        create()
        {
            this.usuarioAuth();
            this.selectTienda();
        },
        data(){
            return {
                datos : {
                    id : 0,
                    fecha : moment().format('YYYY-MM-DD'),
                    descripcion : '',
                    sub_total : 0,
                    descuento : 0,
                    total : 0,
                    id_proveedor : 0,
                    id_forma_pago : 0,
                    proveedor : '',
                    tipoPago : '',
                    formaPago : '',

                    total_efectivo:0,
                    total_deposito:0,
                },

                arrayCompra : [],
                arrayDetalle : [],
                arrayArticulo : [],
                arrayProveedor: [],
                arrayFormaPago: [],
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
                criterio : 'proveedor.nombre',
                buscar : '',
                buscarP : '',
                listadoMenu: 0,
                setTimeoutBuscador: '',
                usuario : {},
                arrayTienda2 : [],
                tienda : 1,
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
            listarCompra(page, buscar, criterio){
                let me=this;
                if(me.usuario.id_tienda == 100){
                    var url='/compra?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&id_tienda=' + me.tienda;
                    axios.get(url).then(function(response){
                        me.arrayCompra=response.data.data;
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
                }else
                {
                    var url='/compra?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function(response){
                        me.arrayCompra=response.data.data;
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
                }
            },
            listarCompraBusquedaRapida(){
                let me=this;
                if(me.usuario.id_tienda == 100){
                    var url='/compra?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio + '&id_tienda=' + me.tienda;
                    axios.get(url).then(function(response){
                        me.arrayCompra=response.data.data;
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
                }else
                {    
                    var url='/compra?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio + '&id_tienda=' + me.usuario.id_tienda;
                    axios.get(url).then(function(response){
                        me.arrayCompra=response.data.data;
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
                }           
            },
            BuscandoCompra(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarCompraBusquedaRapida,350)
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarCompra(page, buscar, criterio);
            },
            listarArticulo(buscarP){
                let me = this;
                var url='/tienda/listarSinPaginate?buscar=' + buscarP;
                axios.get(url).then(function(response){
                    me.arrayArticulo= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
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
                        text: 'Este articulo ya se encuentra agregado!'
                    })
                }
                else{
                    me.arrayDetalle.push({
                        id_tienda_articulo : data['id'],
                        id_articulo : data['id_articulo'],
                        articulo : data['articulo'],
                        tienda : data['tienda'],
                        costo_compra : data['costo_compra'],
                        cantidad : 1,
                        sub_total : data['sub_total']
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
            selectFormaP(){
                let me=this;
                var url='/formaPago/selectFormaP';
                axios.get(url).then(function(response){
                    me.arrayFormaPago=response.data;
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
                me.datos.id_forma_pago=data['id_forma_pago'];
                me.datos.total_efectivo=data['total_efectivo'];
                me.datos.total_deposito=data['total_deposito'];

                var url='/compra/permiso/detalle?id=' + data['id'];
                axios.get(url).then(function(response){
                    me.arrayDetalle= response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            cargarPdf(id) {
                axios.get('/compra/pdfCompraGeneral?id=' + id,{responseType: 'blob'})
                    .then(response => {
                        var blob = new Blob([response.data], {type: 'application/pdf'});
                        var downloadUrl = URL.createObjectURL(blob);
                        window.open(downloadUrl, '_blank');
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            guardarCompra(){
                if(this.arrayDetalle.length<=0){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'No Existe permisos agregados!'
                    })
                }
                let me = this;
                axios.post('/compra/guardar',{
                    'fecha': me.datos.fecha,
                    'descripcion': me.datos.descripcion,
                    'sub_total': me.datos.sub_total,
                    'descuento': me.datos.descuento,
                    'total': me.datos.total,
                    'id_proveedor': me.datos.id_proveedor,
                    'id_forma_pago': me.datos.id_forma_pago,
                    'detalle': me.arrayDetalle
                }).then(function(response){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Compra registrado exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    me.volverCompraListado();
                    me.listarCompra(1,'', 'users.name');
                    me.limpiarDatosCompra();
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            limpiarDatosCompra(){
                this.datos = {
                    id : 0,
                    id_proveedor : 0,
                    id_forma_pago : 0,
                    fecha : moment().format('YYYY-MM-DD'),
                    descripcion : '',
                    sub_total : 0,
                    descuento : 0,
                    total : 0,
                }
            },
            validarCompra(){
                this.errorCompra = 0;
                this.errorMostrarMsjCompra = [];

                if(!this.datos.nombre) this.errorMostrarMsjCompra.push("El nombre del Compra no puede estar vacio ");
                if(this.errorMostrarMsjCompra.length) this.errorCompra=1;
                return this.errorCompra;
            },
            frmCompra(){
                this.listado = 1;
                this.selectProveedor();
                this.selectFormaP();
            },
            anularCompra(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Anular esta Compra??',
                    text: "No Puede revertir esta decision!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Habilitar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/compra/anular',{'id': id}).then(function (response) {
                        me.listarCompra(1,'', 'nombre');
                        swalWithBootstrapButtons.fire(
                        'Anulado!',
                        'Este compra se ha Anulado.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Esta compra no ha tenido cambios :)',
                    'error'
                    )
                }
                })
            }
        },
        mounted() {
            this.usuarioAuth();
            this.selectTienda();
            setTimeout(()=> {
                this.listarCompra(1, "", "");
            },1000)

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
