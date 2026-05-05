<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                &nbsp;
                <div class="card">
                   <div class="card-header text-center text-white" style="background-color: #3399FF"><h3 class="mb-0">HISTORIAL ARQUEO DE CAJA</h3></div>
                    <template v-if="listado==0">
                        
                        <div class="form-group row">
                            <div class="col-md-8">
                                &nbsp;&nbsp;<div class="input-group" style='width:96%;margin-left: 3.3%'>
                                    <select class="form-select col-md-3" v-model="criterio">
                                        <option value="u.name">Responsable</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="text" v-model="buscar" @keyup.enter="listarArqueoCaja(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit" @click="listarArqueoCaja(1, buscar, criterio)" class="btn btn-info text-white"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- Light table -->
                        <div class="table-responsive">
                        <table class="table table-striped table-hover" style='width:96%;margin-left: 2.2%'>
                            <thead style="background-color: #46546C">
                                <tr>                      
                                    <th scope="col" class="text-white">Fecha Apertura</th>
                                    <th scope="col" class="text-white">Monto Apertura</th>
                                    <th scope="col" class="text-white">Ingresos</th>
                                    <th scope="col" class="text-white">Egresos</th>
                                    <th scope="col" class="text-white">Total Efectivo</th>
                                    <th scope="col" class="text-white">Usuario Responsable</th>
                                    <th scope="col" class="text-white">Estado</th>
                                    <th scope="col" class="text-white">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="caja in arrayArqueo" :key="caja.id">
                                    <td v-text="caja.fecha_apertura"></td>
                                    <td v-text="caja.apertura"></td> 
                                    <td v-text="caja.ingreso"></td>
                                    <td v-text="caja.egreso"></td> 
                                    <td v-text="caja.total_efectivo"></td>
                                    <td v-text="caja.name"></td>  
                                    <td class="text-center">
                                        <template v-if="caja.estado=='Abierta'">
                                            <span class="badge bg-success tamaño text-white">{{caja.estado}}</span>
                                        </template>
                                        <template v-if="caja.estado=='Cerrada'">
                                            <span class="badge bg-danger tamaño text-white">{{caja.estado}}</span>                                           
                                        </template>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Accion</button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#" @click="verArqueo(caja)"><i class="fa fa-eye text-success"></i> Ver detalle</a></li>
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
                        <div class="card-header row m-0">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-danger text-white" @click="volverHistorialListado()">
                                    <i class="fa fa-reply-all"></i>&nbsp;Volver
                                </button>
                            </div>
                            <div class="col-md-4 text-center"><h3 class="mb-0">DETALLE DE CAJA</h3></div>
                            <div class="col-md-4">&nbsp;</div>
                            <!-- <div class="col-md-2">
                                <img :src="'img/mi_empresa/'+ datos.foto" height="50px" align="left" alt=""> 
                            </div>  -->
                        </div>
                        <div class="card-header text-center line p-0 m-0"  style="background-color: #3399FF"></div>&nbsp;
                        <div class="card-body pt-0">
                            <div class="card-body pt-0">
                        
                        <form class="row pb-4" style="height:60%;width:100%;text-align: center;">
                            <div class="container" style="text-align: center;">
                                <div class="AA" style="height:57%;width:45%;float: left">
                                    <div class="border-apertura rounded" style="width:100%;">
                                        <div style="height:30%">
                                            &nbsp;
                                        </div>
                                        <div class="BB" style="height:100%">
                                            &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;  
                                        </div>
                                        <div class="BB" style="height:100%; width: 40%">
                                            <h4 class="tt" style="height:100%;" align="center">Apertura:</h4> 
                                        </div>
                                        <div class="BB">
                                            &nbsp;&nbsp; &nbsp; 
                                        </div>
                                        <div class="BB" style="height:100%">
                                            <h4 class="tt" style="height:100%">{{datos.apertura}}</h4>
                                        </div>
                                    </div>
                                    <div style="height:2%;width:100%;">
                                    </div>
                                    <div class="border-detalle rounded" style="width:100%">
                                        <div >
                                            &nbsp;
                                        </div>
                                        <div class="BB">
                                            &nbsp;&nbsp; &nbsp;  
                                        </div>
                                        <div class="BB">
                                            <div style="font-size: 25px">C</div>
                                            &nbsp;
                                            <h5 class="tt">200</h5>
                                              
                                            <h5 class="tt">100</h5>
                                              
                                            <h5 class="tt">50</h5>
                                              
                                            <h5 class="tt">20</h5>
                                              
                                            <h5 class="tt">10</h5>
                                              
                                            <h5 class="tt">5</h5>
                                              
                                            <h5 class="tt">2</h5>
                                              
                                            <h5 class="tt">1</h5>
                                              
                                            <h5 class="tt">0.5</h5>
                                              
                                            <h5 class="tt">0.2</h5>
                                              
                                            <h5 class="tt">100 $</h5>  
                                            &nbsp;
                                        </div>
                                        <div class="BB">
                                            &nbsp;&nbsp; &nbsp;  
                                        </div>
                                        <div class="BB">
                                            <div style="font-size: 25px">PIEZA</div>
                                            &nbsp;
                                            <p class="pp"> 
                                            <input  type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.doscientos" disabled>
                                            </p>
                                            
                                            <p > 
                                            <input type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.cien" disabled>
                                            </p>
                                             
                                            <p class="pp">  
                                            <input type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.cincuenta" disabled> 
                                            </p>
                                            
                                            <p class="pp"> 
                                            <input  type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.veinte" disabled>
                                            </p>
                                             
                                            <p class="pp">  
                                            <input type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.diez" disabled> 
                                            </p>
                                            
                                            <p class="pp"> 
                                            <input type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.cinco" disabled>
                                            </p>
                                             
                                            <p class="pp">  
                                            <input type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.dos" disabled> 
                                            </p>
                                            
                                            <p class="pp"> 
                                            <input type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.uno" disabled>
                                            </p>
                                             
                                            <p class="pp">  
                                            <input type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.cerocinco" disabled> 
                                            </p>
                                            
                                            <p class="pp"> 
                                            <input type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.ceroveinte" disabled>
                                            </p>
                                             
                                            <p class="pp">  
                                            <input type="number" v-on:keyup="calcularArqueo()" id="ttt" v-model="datos.cien_dolar" disabled> 
                                            </p>
                                            &nbsp; 
                                        </div>
                                        <div class="BB">
                                            &nbsp; &nbsp; &nbsp; 
                                        </div>
                                        <div class="BB">
                                            <div style="font-size: 25px">CANTIDAD</div>
                                            &nbsp;
                                            <h5 class="tt">{{(datos.doscientos*200).toFixed(2)}} </h5>  
                                            <h5 class="tt">{{(datos.cien*100).toFixed(2)}}</h5>  
                                            <h5 class="tt">{{(datos.cincuenta*50).toFixed(2)}}</h5>  
                                            <h5 class="tt">{{(datos.veinte*20).toFixed(2)}}</h5>  
                                            <h5 class="tt">{{(datos.diez*10).toFixed(2)}}</h5>  
                                            <h5 class="tt">{{(datos.cinco*5).toFixed(2)}}</h5>  
                                            <h5 class="tt">{{(datos.dos*2).toFixed(2)}}</h5>  
                                            <h5 class="tt">{{(datos.uno*1).toFixed(2)}}</h5>  
                                            <h5 class="tt">{{(datos.cerocinco*0.5).toFixed(2)}}</h5>  
                                            <h5 class="tt">{{(datos.ceroveinte*0.2).toFixed(2)}}</h5>  
                                            <h5 class="tt">{{(datos.cien_dolar*100*7).toFixed(2)}}</h5> 
                                            &nbsp; 
                                        </div>
                                        <div class="BB">
                                            &nbsp;&nbsp; &nbsp;  
                                        </div>
                                    </div>
                                </div>
                                <div class="AA" style="height:100%;width:3%;float: left">
                                    &nbsp;
                                </div>
                                <div class="AA" style="height:58%;width:45%;float: left;text-align: left;">
                                    <div class="border-registro rounded" style="width:100%">
                                        <div>
                                            &nbsp;&nbsp;
                                        </div>
                                        <div class="BB">
                                            &nbsp;&nbsp;&nbsp;&nbsp; 
                                        </div>
                                        <div class="BB" style="text-align: left">
                                            &nbsp;
                                            <h4 class="tt">Registro de Ventas</h4> 
                                            <h4 class="tt">Apertura</h4> 
                                            <h4 class="tt">Total Ingresos</h4> 
                                            <h4 class="tt">Gastos</h4> 
                                            <h4 class="tt">Registro de Compras</h4> 
                                            <h4 class="tt">Total Egresos</h4> 
                                            <h4 class="tt">Saldo Efectivo</h4> 
                                            <h4 class="tt">Diferencia</h4> 
                                            &nbsp;
                                        </div>
                                        <div class="BB">
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <div class="BB" style="text-align: right">
                                            &nbsp;
                                            <h4 class="tt">{{datos.registro_venta}}</h4> 
                                            <h4 class="tt">{{datos.apertura}} </h4> 
                                            <h4 class="tt">{{(datos.total).toFixed(2)}}</h4> 
                                            <h4 class="tt">{{datos.gastos}} </h4> 
                                            <h4 class="tt">{{datos.registro_compra}} </h4> 
                                            <h4 class="tt">{{(datos.saldo_sistema).toFixed(2)}}</h4> 
                                            <h4 class="tt">{{(datos.saldo_efectivo).toFixed(2)}}</h4> 
                                            <h4 class="tt">{{(datos.diferencia).toFixed(2)}}</h4> 
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div style="height:2%;width:100%;">
                                    </div>
                                    <div class="border-efectivo rounded" style="height:13%;width:100%;border: 2px solid #3399FF">
                                        <div class="BB">
                                            &nbsp;&nbsp;&nbsp;
                                        </div>
                                        <div class="BB">
                                            <h4 class="tt">Total Efectivo</h4>  
                                        </div>
                                        <div class="BB size-div" >
                                            &nbsp;
                                        </div>
                                        <div class="BB" style="text-align: right;">
                                            <h4 class="tt">{{total_efec}}</h4>  
                                        </div>
                                    </div>
                                    <div style="height:2%;width:100%;">
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                            <div class="header-divider"></div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-info btn-lg text-white" v-if="tipoAccion==1"  type="button" @click="guardarcliente()">Guardar cliente</button>
                                <button class="btn btn-info btn-lg text-white" v-if="tipoAccion==2"  type="button" @click="modificarcliente()">Modificar cliente</button>
                            </div>
                            </div>
                        </div>
                    </template>
                    
                </div>
                </div>
            </div>

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
                    fecha_apertura : '',
                    fecha_cierre : '',
                    doscientos : 0,
                    cien : 0,
                    cincuenta : 0,
                    veinte : 0,
                    diez : 0,
                    cinco : 0,
                    dos : 0,
                    uno : 0,
                    cerocinco : 0,
                    ceroveinte : 0,
                    cien_dolar : 0,
                    registro_venta : 0,
                    alojamiento : 0,
                    apertura : 0,
                    total : 0,
                    gastos : 0,
                    registro_compra : 0,
                    saldo_sistema : 0,
                    saldo_efectivo : 0,
                    diferencia : 0,
                    id_usuario : 0,
                    estado : 'abierta',
                },
                total_efec:0,  
                arrayArqueo : [],
                arrayDetalle : [],
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
                criterio : 'u.name',
                buscar : ''
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
            listarArqueoCaja(page, buscar, criterio){
                let me=this;
                var url='/arqueo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response){
                    me.arrayArqueo=response.data.data;
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
            calcularArqueo: function(){
                var x1=0;
                var x2=0;
                var x3=0;
                var x4=0;
                var x5=0;
                var x6=0;
                var x7=0;
                var x8=0;
                var x9=0;
                x1=parseFloat(this.datos.registro_venta);
                x2=parseFloat(this.datos.apertura);
                x3=x1+x2;

                x4=parseFloat(this.datos.gastos);
                x5=parseFloat(this.datos.registro_compra);
                x6=x4+x5;

                x7=x3-x6;
                x8=(this.datos.doscientos*200)+(this.datos.cien*100)+(this.datos.cincuenta*50)+(this.datos.veinte*20)+
                    (this.datos.diez*10)+(this.datos.cinco*5)+(this.datos.dos*2)+(this.datos.uno*1)+
                    (this.datos.cerocinco*0.5)+(this.datos.ceroveinte*0.2)+(this.datos.cien_dolar*700);
                x9=x8-x7;

                this.datos.total=x3;
                this.datos.saldo_sistema=x6;
                this.datos.saldo_efectivo=x7;
                this.datos.diferencia=x9;
                this.total_efec=x8;
                return this.datos,this.total_efec;
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarCompra(page, buscar, criterio);
            },
            volverHistorialListado(){
                let me = this;
                me.listado = 0;
                me.limpiarArqueoCaja();
                me.criterio = 'u.name',
                me.buscar = '';
            },
            verArqueo(data=[]){
                let me = this;
                me.listado = 1;
                me.datos.id = data['id'];
                me.datos.fecha_apertura = data['fecha_apertura'];
                me.datos.fecha_cierre = data['fecha_cierre'];
                me.datos.doscientos = data['doscientos'];
                me.datos.cien = data['cien'];
                me.datos.cincuenta = data['cincuenta'];
                me.datos.veinte = data['veinte'];
                me.datos.diez = data['diez'];
                me.datos.cinco = data['cinco'];
                me.datos.dos = data['dos'];
                me.datos.uno = data['uno'];
                me.datos.cerocinco = data['cerocinco'];
                me.datos.ceroveinte = data['ceroveinte'];
                me.datos.cien_dolar = data['cien_dolares'];
                me.datos.registro_venta = data['registro_venta'];
                me.datos.apertura = data['apertura'];
                me.datos.total = parseFloat(data['total']);
                me.datos.gastos = data['gastos'];
                me.datos.registro_compra = data['registro_compra'];
                me.datos.saldo_sistema = parseFloat(data['saldo_sistema']);
                me.datos.saldo_efectivo = parseFloat(data['saldo_efectivo']);
                me.datos.diferencia = parseFloat(data['diferencia']);
                me.datos.id_usuario = data['id_usuario'];
                me.datos.estado = data['estado'];
            },
            // cargarPdf(id,foto) {
            //     axios.get('/compra/pdfCompraGeneral?id=' + id  + '&foto='+ foto,{responseType: 'blob'})
            //         .then(response => {
            //             var blob = new Blob([response.data], {type: 'application/pdf'});
            //             var downloadUrl = URL.createObjectURL(blob);
            //             window.open(downloadUrl, '_blank');
            //         })
            //         .catch(error => {
            //             console.log(error);
            //         })
            // },
            limpiarArqueoCaja(){
                this.datos = {
                    id : 0,
                    fecha_apertura : '',
                    fecha_cierre : '',
                    doscientos : 0,
                    cien : 0,
                    cincuenta : 0,
                    veinte : 0,
                    diez : 0,
                    cinco : 0,
                    dos : 0,
                    uno : 0,
                    cerocinco : 0,
                    ceroveinte : 0,
                    cien_dolar : 0,
                    registro_venta : 0,
                    alojamiento : 0,
                    apertura : 0,
                    total : 0,
                    gastos : 0,
                    registro_compra : 0,
                    saldo_sistema : 0,
                    saldo_efectivo : 0,
                    diferencia : 0,
                    id_usuario : 0,
                    estado : 'abierta',
                }
                this.criterio = 'u.name',
                this.buscar = ''
            }, 
        },
        mounted() {
            this.listarArqueoCaja(1, this.buscar, this.criterio);

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