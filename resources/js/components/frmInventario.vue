<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                <div class="card">
                    <div class="card-header text-center text-white" style="background-color: #3399FF">
                            <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 col-md-11">INVENTARIO</h5>
                                <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                            </div>
                        </div>
                    <br>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <div class="input-group"  style='width:96%;margin-left: 3.3%;font-size: 0.8rem'>
                                <!--<template v-if="usuario.id_tienda == 100">-->
                                <select class="form-select" v-model="tienda" @change="listarInventario(1, buscar, criterio)" style='font-size: 0.8rem'>
                                    <!-- <option value="1" disabled>Seleccione la Tienda</option> -->
                                    <option :value="3">Inventario Total</option>
                                    <option v-for="tienda in arrayTienda2" :key="tienda.id" :value="tienda.id" v-text="tienda.nombre"></option>
                                </select>
                                <!--</template>-->
                                &nbsp;
                                <select class="form-select col-md-3" v-model="criterio"  style='font-size: 0.8rem'>
                                    <option value="articulo.nombre">Nombre</option>
                                    <option value="categoria.nombre">Categoria</option>
                                    <!-- <option value="cod_producto">Cod. Producto </option> -->
                                </select>
                                &nbsp;&nbsp;&nbsp;
                                <input type="text" v-model="buscar" @keyup.enter="listarInventario(1, buscar, criterio)" @keyup="BuscandoArticulo()" class="form-control" placeholder="Texto a buscar" style='font-size: 0.8rem'>
                                &nbsp;&nbsp;&nbsp;
                                <button type="submit" @click="listarInventario(1, buscar, criterio)" class="btn btn-info text-white" style='font-size: 0.8rem'><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Light table -->
                    <div class="table-responsive">
                    <table class="table table-striped table-hover" style='width:96%;margin-left: 2.2%;font-size: 0.8rem'>
                        <thead style="background-color: #46546c">
                            <tr v-if="tienda==3"><!-- Para busquedas de inventario total-->                      
                                <!-- <th scope="col" class="text-white">Cod. Ean</th>                        -->
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Nombre</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Categoria</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Costo Compra</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Costo Venta</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Stock - Almacen</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Stock - Tienda</th>
                            </tr>
                            <tr v-else-if="tienda!=3"><!-- Para busquedas de inventario total-->                      
                                <!-- <th scope="col" class="text-white">Cod. Ean</th>                        -->
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Nombre</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Categoria</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Costo Compra</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Costo Venta</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Stock</th>
                          
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="tienda==3"><!-- Para busquedas de inventario total-->  
                                <tr v-for="tienda_articulo in arrayTienda" :key="tienda_articulo.id">
                                        <!-- <td v-text="tienda_articulo.cod_ean"></td> -->
                                        <td v-text="tienda_articulo.nombre" style='font-size: 0.8rem'></td>
                                        <td v-text="tienda_articulo.categoria" style='font-size: 0.8rem'></td>
                                        <td v-text="tienda_articulo.costo_compra" style='font-size: 0.8rem'></td> 
                                        <td v-text="tienda_articulo.costo_venta" style='font-size: 0.8rem'></td> 
                                        <td v-text="tienda_articulo.tienda1_stock" style='font-size: 0.8rem'></td>    
                                        <td v-text="tienda_articulo.tienda2_stock" style='font-size: 0.8rem'></td>    
                                </tr>
                            </template>
                            <template v-if="tienda!=3"><!-- Para busquedas de inventario total-->  
                                <tr v-for="tienda_articulo in arrayTienda" :key="tienda_articulo.id">
                                        <!-- <td v-text="tienda_articulo.cod_ean"></td> -->
                                        <td v-text="tienda_articulo.nombre" style='font-size: 0.8rem'></td>
                                        <td v-text="tienda_articulo.categoria" style='font-size: 0.8rem'></td>
                                        <td v-text="tienda_articulo.costo_compra" style='font-size: 0.8rem'></td> 
                                        <td v-text="tienda_articulo.costo_venta" style='font-size: 0.8rem'></td> 
                                        <td v-text="tienda_articulo.stock" style='font-size: 0.8rem'></td>    
                                </tr>
                            </template>
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

    </main>
</template>

<script>

    export default {
        data(){
            return {
                datos : {
                    id : 0,
                    nombre : '',
                    matricula : '',
                    telefono : '',
                    direccion : '',
                    descripcion : '',
                    estado : '1',
                    id_tienda : 0,

                },                                 
                arrayTienda : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCliente : 0,
                errorMostrarMsjCliente : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'articulo.nombre',
                buscar : '',
                setTimeoutBuscador: '',
                listadoMenu: 0,
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
            listarInventario(page, buscar, criterio){
                let me=this;
                //if(me.usuario.id_tienda == 100){
                    var url='/tienda/inventario?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&id_tienda=' + me.tienda;
                    axios.get(url).then(function(response){
                        me.arrayTienda=response.data.data;
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
                //}
                /*else
                {      
                    let tienda_3=3;// para buscar por inventario total   
                    var url='/tienda/inventario?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&id_tienda=' + tienda_3;
                    axios.get(url).then(function(response){
                        me.arrayTienda=response.data.data;
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

                }*/

            },
            listarArticuloBusquedaRapida(){
                let me=this;
                if(me.usuario.id_tienda == 100){
                    var url='/tienda/inventario?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio + '&id_tienda=' + me.tienda;
                    axios.get(url).then(function(response){
                        me.arrayTienda=response.data.data;
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
                    let tienda_3=3;// Para buscar por el inventario total
                    var url='/tienda/inventario?page=' + 1 + '&buscar=' + me.buscar + '&criterio=' + me.criterio + '&id_tienda=' + tienda_3;
                    axios.get(url).then(function(response){
                        me.arrayTienda=response.data.data;
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
            BuscandoArticulo(){
                let me = this;
                clearTimeout(me.setTimeoutBuscador)
                me.setTimeoutBuscador = setTimeout(me.listarArticuloBusquedaRapida,350)
            },

            cambiarPagina(page,buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarInventario(page, buscar, criterio);
            }
        },
        mounted() {
            this.usuarioAuth();
            this.selectTienda();
            setTimeout(()=> {
                this.listarInventario(1, this.buscar, this.criterio);
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