<template>
    <main class="main">
        <!-- <div class="container"> -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header text-center text-white" style="background-color: #3399FF">
                        <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 col-md-11">CAJA</h5>
                            <!-- <button type="button" class="btn-close btn-close-white" @click="volverMenu()" aria-label="Close"></button> -->
                        </div>
                    </div>
                    <!-- prueba card -->
                    <div class="row g-2 p-2 d-flex flex-wrap justify-content-center">

                        <div class="col-md-3">
                            <div class="p-2 mb-2 border border-black" style='height:100%'>
                                <div class="card-header position-relative d-flex justify-content-center align-items-center text-white"
                                    style="background-color: #3399FF">
                                    <strong style='font-size: 0.8rem'> APERTURA DE CAJA </strong>
                                </div>
                                <div class="card-body row text-center">

                                    <div class="col" style='width:10%'>
                                        <div class="text-uppercase text-medium-emphasis small ">Monto</div>
                                        <div>
                                            <input type="text" class="form-control" v-model="datos.apertura"
                                                style='font-size: 0.8rem'
                                                oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                v-on:focus="seleccionarContenido">
                                        </div>
                                    </div>
                                    <div>
                                        &nbsp;
                                    </div>
                                    <div class="text-center">


                                        <button type="button" class="btn btn-info text-white position-relative"
                                            @click="aperturarCaja()" style='font-size: 0.8rem'>
                                            Dar Apertura
                                        </button>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 mb-2 border border-black" style='height:100%'>
                                <div class="card-header position-relative d-flex justify-content-center align-items-center text-white"
                                    style="background-color: #3399FF">
                                    <strong style='font-size: 0.8rem'> ARQUEO DE CAJA </strong>
                                </div>
                                <div class="card-body row text-center">

                                    <div class="col" style='width:60%'>
                                        <div class="text-uppercase text-medium-emphasis small "
                                            style='font-size: 0.8rem'>Configurar</div>
                                        <div>
                                            <button type="button" class="btn btn-outline-info position-relative"
                                                @click="btnArqueo()" style='font-size: 0.8rem'>
                                                Arqueo
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-2 mb-2 border border-black" style='height:100%'>
                                <div class="card-header position-relative d-flex justify-content-center align-items-center text-white"
                                    style="background-color: #3399FF">
                                    <strong style='font-size: 0.8rem'> PAGOS MESEROS </strong>
                                </div>
                                <div class="card-body row text-center">

                                    <div class="col" style='width:60%'>
                                        <div class="text-uppercase text-medium-emphasis small "
                                            style='font-size: 0.8rem'>Pagar</div>
                                        <div>
                                            <button @click="desplegarListaMeserosPagar('')" data-bs-toggle="modal"
                                                data-bs-target="#modalPagoMesero" type="button"
                                                class="btn btn-outline-info position-relative"
                                                style='font-size: 0.8rem'>
                                                Pagar
                                            </button>
                                        </div>

                                        <div class="text-uppercase text-medium-emphasis small mt-2"
                                            style='font-size: 0.8rem'>Historial Pagos</div>
                                        <div>
                                            <button type="button" class="btn btn-outline-info position-relative"
                                                @click="abrirModalHistorialPagoMeseros()" style='font-size: 0.8rem'>
                                                Historial
                                            </button>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- prueba fin card -->


                    <!-- Card Pagination -->
                    <!-- Light table -->
                    <div class="card-body px-1 pb-0">
                        <div class="table-responsive">
                            <!-- <template v-if="usuario.id_grupo == 1"> -->
                            <table class="table table-striped table-hover"
                                style='width:96%;margin-left: 2%;font-size: 0.8rem'>
                                <thead style="background-color: #46546C">
                                    <tr>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Fecha Apertura</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Monto Apertura</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Ingresos</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Egresos</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Total Efectivo</th>
                                        <th scope="col" class="text-white" style='font-size: 0.8rem'>Usuario Responsable
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="caja in arrayCaja" :key="caja.id">
                                        <td v-text="caja.fecha_apertura" style='font-size: 0.8rem'></td>
                                        <td v-text="caja.apertura" style='font-size: 0.8rem'></td>
                                        <td v-text="caja.ingreso" style='font-size: 0.8rem'></td>
                                        <td v-text="caja.egreso" style='font-size: 0.8rem'></td>
                                        <td v-text="caja.total_efectivo" style='font-size: 0.8rem'></td>
                                        <td v-text="caja.name" style='font-size: 0.8rem'></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- </template> -->
                            <!-- <template v-else>
                    <table class="table table-striped table-hover" style='width:96%;margin-left: 2%;font-size: 0.8rem'>
                        <thead style="background-color: #46546C">
                            <tr>                      
                                <th scope="col" class="text-white" style='font-size: 0.8rem;'>Fecha Apertura</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Monto Apertura</th>
                                <th scope="col" class="text-white" style='font-size: 0.8rem'>Usuario Responsable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="caja in arrayCaja" :key="caja.id">
                                <td v-text="caja.fecha_apertura" style='font-size: 0.8rem'></td>
                                <td v-text="caja.apertura" style='font-size: 0.8rem'></td> 
                                <td v-text="caja.name" style='font-size: 0.8rem'></td>      
                            </tr>
                        </tbody>
                    </table>
                    </template> -->
                        </div>
                    </div>
                    <template v-if="listado==1">
                        <div class="card-body pt-0">
                            <div class="card-body pt-0">

                                <div class="card-header text-center">
                                    <div class="col-sm-12 bg-black d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 col-md-11">ARQUEO DE CAJA</h5>
                                        <button type="button" class="btn-close btn-close" @click="ocultarListado1()"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="card-header text-center line p-0 m-0" style="background-color: #3399FF">
                                </div>&nbsp;
                                <form class="row pb-4" style="height:60%;width:100%;text-align: center;">
                                    <div class="container" style="text-align: center;">
                                        <div class="row g-2">
                                            <!-- <template v-if="usuario.id_grupo == 1"> -->
                                            <div class="col-md-6">
                                                <div class="p-2 mb-2 border border-warning">
                                                    <h5 class="mx-4 px-4 my-1">Apertura: {{datos.apertura}}</h5>
                                                </div>
                                                <div class="p-2 border border-warning">

                                                    <!--<table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" width="30%">C</th>
                                                                <th scope="col" width="35%">PIEZA</th>
                                                                <th scope="col" width="35%" class="text-center">CANTIDAD
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="align-middle">200</td>
                                                                <td><input class="form-control form-control-sm"
                                                                        type="text" v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.doscientos"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.doscientos*200).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">100</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.cien"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.cien*100).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">50</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.cincuenta"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.cincuenta*50).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">20</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.veinte"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.veinte*20).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">10</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.diez"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.diez*10).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">5</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.cinco"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.cinco*5).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">2</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.dos"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.dos*2).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">1</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.uno"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.uno*1).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">0.5</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.cerocinco"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.cerocinco*0.5).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">0.2</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.ceroveinte"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.ceroveinte*0.2).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">100 $</td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        v-on:keyup="calcularArqueo()"
                                                                        v-model="datos.cien_dolar"
                                                                        oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                                        v-on:focus="seleccionarContenido"></td>
                                                                <td class="align-middle text-center">
                                                                    {{parseFloat(datos.cien_dolar*100*7).toFixed(2)}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th height="259px"></th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </tbody>
                                                    </table>-->
                                                    <div class="form-group">
                                                        <label class="text-start mb-3 text-warning">INGRESE TOTAL
                                                            EFECTIVO: </label>
                                                        <input type="text" class="form-control" v-model="efectivo_total"
                                                            v-on:keyup="calcularArqueo()"
                                                            oninput="event.target.value =event.target.value.replace(/[^0-9\.]*/g,'');"
                                                            v-on:focus="seleccionarContenido">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-2 mb-2 border border-warning">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" width="10%" height="100px"></th>
                                                                <th scope="col" width="60%" class="text-info">Total
                                                                    Ingresos + Apertura Caja</th>
                                                                <th scope="col" width="30%" class="text-info">
                                                                    {{datos.total}}</th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-info">Total Ventas Efectivo</th>
                                                                <th class="text-info">{{datos.total_efectivo}} </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-info">Total Ventas Depositos</th>
                                                                <th class="text-info">{{datos.total_deposito}} </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-info">Total Pagos Efectivo V. Credito
                                                                </th>
                                                                <th class="text-info">{{datos.total_credito}} </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-info">Total Pagos Deposito V. Credito
                                                                </th>
                                                                <th class="text-info">{{datos.total_credito_deposito}}
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-info">Apertura Caja</th>
                                                                <th class="text-info">{{datos.apertura}} </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th>Total Ingresos Efectivo</th>
                                                                <th>{{datos.registro_venta}}</th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-danger">Total Egresos</th>
                                                                <th class="text-danger">{{datos.saldo_sistema}}</th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-danger">Total Gastos Efectivo</th>
                                                                <th class="text-danger">{{datos.gastos}}</th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-danger">Total Gastos Depositos</th>
                                                                <th class="text-danger">{{datos.gastos_deposito}}</th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-danger">Total Compra Efectivo</th>
                                                                <th class="text-danger">{{datos.total_efectivo_compra}}
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-danger">Total Compra Deposito</th>
                                                                <th class="text-danger">{{datos.total_deposito_compra}}
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-danger">Total Pago Efectivo C. Credito
                                                                </th>
                                                                <th class="text-danger">{{datos.total_credito_compra}}
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-danger">Total Pago Deposito C. Credito
                                                                </th>
                                                                <th class="text-danger">
                                                                    {{datos.total_credito_deposito_compra}} </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-danger">Total Pago Meseros
                                                                </th>
                                                                <th class="text-danger">
                                                                    {{datos.total_pago_meseros}} </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th>Total Egresos Efectivo</th>
                                                                <th>{{datos.total_egreso_efectivo}}</th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th>Saldo Efectivo</th>
                                                                <th>{{(datos.saldo_efectivo).toFixed(2)}}</th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th>Diferencia</th>
                                                                <th>{{(datos.diferencia).toFixed(2)}}</th>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                    <div class="p-2 mb-2 border border-warning">
                                                        <h5 class="mx-4 px-4 my-1">Total Efectivo: {{total_efec}}</h5>
                                                    </div>
                                                    <div class="p-2 mb-3 border border-warning">
                                                        <button style="width:100%" type="button"
                                                            class="btn btn-warning text-white" @click="cerrarCaja()">
                                                            Cerrar Caja
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- </template>
                                    <template v-else>
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-6">

                                            <div class="p-2 border border-warning">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col" width="30%">C</th>
                                                        <th scope="col" width="35%">PIEZA</th>
                                                        <th scope="col" width="35%" class="text-center">CANTIDAD</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="align-middle">200</td>
                                                            <td><input class="form-control form-control-sm" type="number" v-on:keyup="calcularArqueo()" v-model="datos.doscientos"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.doscientos*200).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">100</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.cien"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.cien*100).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">50</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.cincuenta"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.cincuenta*50).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">20</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.veinte"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.veinte*20).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">10</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.diez"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.diez*10).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">5</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.cinco"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.cinco*5).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">2</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.dos"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.dos*2).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">1</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.uno"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.uno*1).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">0.5</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.cerocinco"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.cerocinco*0.5).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">0.2</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.ceroveinte"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.ceroveinte*0.2).toFixed(2)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle">100 $</td>
                                                            <td><input type="number" class="form-control form-control-sm" v-on:keyup="calcularArqueo()" v-model="datos.cien_dolar"></td>
                                                            <td class="align-middle text-center">{{parseFloat(datos.cien_dolar*100*7).toFixed(2)}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="p-2 mb-3 border border-warning">
                                                    <button style="width:100%" type="button" class="btn btn-warning text-white" @click="cerrarCaja()">
                                                        Cerrar Caja
                                                    </button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                    </template> -->
                                        </div>

                                    </div>

                                </form>
                                <div class="header-divider"></div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-info btn-lg text-white" v-if="tipoAccion==1" type="button"
                                        @click="guardarcliente()">Guardar cliente</button>
                                    <button class="btn btn-info btn-lg text-white" v-if="tipoAccion==2" type="button"
                                        @click="modificarcliente()">Modificar cliente</button>
                                </div>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
        <!--Modal Formulario Grupo-->
        <div class="modal fade" id="modalPagoMesero" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header btn btn-info text-white">
                        <h4 class="modal-title ">Pago de meseros</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <!--<input type="text" v-model="buscarP" @keyup.enter="modalPermisoForm(buscarP)"
                                        @keyup="BuscandoPermisoForm()" class="form-control"
                                        placeholder="Texto a buscar">&nbsp;&nbsp;
                                    <button type="submit" @click="modalPermisoForm(buscarP)"
                                        class="btn btn-info text-white"><i class="fa fa-search text-white"></i>
                                        Buscar</button>-->
                                </div>
                            </div>
                        </div>
                        &nbsp;
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead style="background-color: #46546C">
                                    <tr>
                                        <th scope="col" class="text-white">Numero</th>
                                        <th scope="col" class="text-white">Mesero</th>
                                        <th scope="col" class="text-white">Total Venta</th>
                                        <th scope="col" class="text-white">Monto a cancelar</th>
                                        <th scope="col" class="text-white">Opción
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span>
                                                <label for="form-checkbox" data-toggle="modal"
                                                    data-target="#modalConfirmarPago">
                                                    <input type="checkbox" v-model="selectAll"
                                                        @click="seleccionarTodos()">
                                                </label>
                                                <!--<button type="button" class="btn btn-primary" @click="abrirModalConfirmarPagos()">Abrir modal</button>-->

                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(mesero, index) in arrayMeseros" :key="index">
                                        <td v-text="index+1"></td>
                                        <td v-text="mesero.nombre"></td>
                                        <td v-text="parseFloat(mesero.total_ventas).toFixed(2)"></td>
                                        <td v-text="parseFloat(mesero.total_comision).toFixed(2)"></td>
                                        <td>
                                            <button type="button" @click="seleccionarMesero(mesero,index)"
                                                class="btn btn-success btn-sm"><i
                                                    class="fa fa-check text-white"></i></button>
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
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin modal Formulario Grupo-->
        <!-- Modal confirmar pagos-->
        <div class="modal fade" id="modalConfirmarPagos" :class="{'mostrar' :modalconfirmarpagos}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document"
                style="max-width:600px; min-width:500px;">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: #66b3ff">
                        <h5 class="modal-title" id="exampleModalLongTitle">CONFIRME PAGO DE MESEROS</h5>
                        <button @click="cerrarModalConfirmarPagos()" type="button" class="btn-close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Nombre</th>
                                    <th>Total Venta</th>
                                    <th>Total Comisión</th>
                                    <th>Opción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pagomesero, index) in arrayDetalleMesero" :key="index">
                                    <td v-text="index+1"></td>
                                    <td v-text="pagomesero.nombre"></td>
                                    <td v-text="parseFloat(pagomesero.total_venta).toFixed(2)"></td>
                                    <td v-text="parseFloat(pagomesero.total_comision).toFixed(2)"></td>
                                    <td>
                                        <!--<button type="button" @click="seleccionarPermiso(permiso,index)"
                                                class="btn btn-success btn-sm"><i
                                                    class="fa fa-check text-white"></i></button>-->
                                        <button type="button" class="btn btn-danger btn-sm text-white"
                                            @click="eliminarDetalle(index)"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white"
                            @click="cerrarModalConfirmarPagos()">Cerrar</button>
                        <button :disabled="arrayDetalleMesero.length==0?true:false" type="button"
                            class="btn bg-info text-white" @click="pagarListaMeseros()">Confirmar pagar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modal confirmas pagos-->

        <!-- Modal historial pago de meseros-->
        <div class="modal fade" id="modalHistorialPagoMeseros" :class="{'mostrar' :modalhistorialpagomeseros}"
            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document"
                style="max-width:900; min-width:850;">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: #66b3ff">
                        <h5 class="modal-title" id="exampleModalLongTitle">CONFIRME PAGO DE MESEROS</h5>
                        <button @click="cerrarModalHistorialPagoMeseros()" type="button" class="btn-close"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-8">
                                &nbsp;&nbsp;<div class="input-group"
                                    style='width:96%;margin-left: 3.3%;font-size: 0.8rem'>
                                    <div>
                                        <input type="date" class="form-control" style='font-size: 0.8rem'
                                            v-model="fecha_inicio"
                                            @click="listaHistorialMeseros(fecha_inicio, fecha_fin, criterio2, buscar2)"
                                            @change="listaHistorialMeseros(fecha_inicio, fecha_fin, criterio2, buscar2)">
                                        <!-- <input type="date" class="form-control"  v-model="datos.fecha_producto" @click="listarVenta(buscar,criterio)" @change="listarVenta(buscar,criterio)">   -->
                                    </div>
                                    &nbsp;&nbsp;&nbsp;
                                    <div>
                                        <input type="date" class="form-control" style='font-size: 0.8rem'
                                            v-model="fecha_fin"
                                            @click="listaHistorialMeseros(fecha_inicio, fecha_fin, criterio2, buscar2)"
                                            @change="listaHistorialMeseros(fecha_inicio, fecha_fin, criterio2, buscar2)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                &nbsp;&nbsp;<div class="input-group"
                                    style='width:96%;margin-left: 3.3%;font-size: 0.8rem'>

                                    &nbsp;
                                    <select class="form-select col-md-3" v-model="criterio2" style='font-size: 0.8rem'>
                                        <option value="users.name">Usuario</option>

                                    </select>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="text" v-model="buscar2"
                                        @keyup.enter="listaHistorialMeseros(fecha_inicio, fecha_fin, criterio2, buscar2)"
                                        @keyup="listaHistorialMeseros(fecha_inicio, fecha_fin, criterio2, buscar2)"
                                        class="form-control" placeholder="Texto a buscar" style='font-size: 0.8rem'>
                                    &nbsp;&nbsp;&nbsp;
                                    <button type="submit"
                                        @click="listaHistorialMeseros(fecha_inicio, fecha_fin, criterio2, buscar2)"
                                        class="btn btn-info text-white" style='font-size: 0.8rem'><i
                                            class="fa fa-search"></i> Buscar</button>
                                </div>

                            </div>

                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Total Comisión</th>
                                    <th>Total Venta</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(historialmesero, index) in arrayHistorialMeseros" :key="index">
                                    <td v-text="index+1"></td>
                                    <td v-text="historialmesero.nombre"></td>
                                    <td v-text="historialmesero.name"></td>
                                    <td v-text="historialmesero.fecha"></td>
                                    <td v-text="parseFloat(historialmesero.comision).toFixed(2)"></td>
                                    <td v-text="parseFloat(historialmesero.total_venta).toFixed(2)"></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white"
                            @click="cerrarModalHistorialPagoMeseros()">Salir</button>
                        <!--<button :disabled="arrayDetalleMesero.length==0?true:false" type="button"
                            class="btn bg-info text-white" @click="pagarListaMeseros()">Confirmar pagar</button>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modal confirmas pagos-->
        <!-- </div> -->
    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    import debounce from 'lodash/debounce'
    import moment from 'moment';
    export default {
        data() {
            return {
                datos: {
                    id: 0,
                    fecha_apertura: '',
                    fecha_cierre: '',
                    doscientos: 0,
                    cien: 0,
                    cincuenta: 0,
                    veinte: 0,
                    diez: 0,
                    cinco: 0,
                    dos: 0,
                    uno: 0,
                    cerocinco: 0,
                    ceroveinte: 0,
                    cien_dolar: 0,
                    registro_venta: 0,
                    alojamiento: 0,
                    apertura: 0,
                    total: 0,
                    gastos: 0,
                    gastos_deposito: 0,
                    registro_compra: 0,
                    saldo_sistema: 0,
                    saldo_efectivo: 0,
                    diferencia: 0,
                    id_usuario: 0,
                    estado: 'abierta',
                    grupo: 0,
                    total_efectivo: 0,
                    total_deposito: 0,
                    total_credito: 0,
                    total_credito_deposito: 0,
                    total_efectivo_compra: 0,
                    total_deposito_compra: 0,
                    total_credito_compra: 0,
                    total_credito_deposito_compra: 0,
                    total_pago_meseros: 0,
                    total_ingreso_efectivo: 0,
                    total_egreso_efectivo: 0,
                },
                mesProducto: moment().format('MM'),
                anio: moment().format('YYYY'),
                total_efec: 0,
                listado: 0,
                variable: 0,
                arrayimportacion: [],
                arrayCaja: [],
                arrayArqueo: [],
                arrayProducto: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                importacion_registro: 0,
                errorimportacion: 0,
                errorMostrarMsjimportacion: [],
                arrayProductoMeses: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'name',
                buscar: '',
                usuario: {},
                vista: 0,
                listadoMenu: 0,
                is_busy: 0,
                arrayMeseros: [],
                arrayDetalleMesero: [],
                arrayHistorialMeseros: [],
                selectAll: false,
                modalconfirmarpagos: 0,
                modalhistorialpagomeseros: 0,
                fecha_inicio: moment().format('YYYY-MM-DD'),
                fecha_fin: moment().format('YYYY-MM-DD'),
                criterio2: 'users.name',
                buscar2: '',
                fecha: moment().format('YYYY-MM-DD'),
                cantidad_cajas_abiertas: 0,
                efectivo_total:0,
            }
        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },

            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            volverMenu() {
                this.vista = 0;
                this.$emit('cerrarMenu', this.listadoMenu);
            },
            verificarSoloUnaCajaAbierta() {
                let me = this;
                axios.get('/arqueo/verificar_solo_una_caja_abierta/')
                    .then(function (response) {
                        me.cantidad_cajas_abiertas = response.data.cantidad_cajas_abiertas;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });

            },
            listaHistorialMeseros(fecha_inicio, fecha_fin, criterio, buscar) {
                let me = this;

                axios.get('/arqueo/historial_pago_meseros?fecha_inicio=' + fecha_inicio + '&fecha_final=' + fecha_fin +
                        '&criterio=' + criterio + '&buscar=' + buscar)
                    .then(function (response) {
                        //console.log(response.data.error);
                        me.arrayHistorialMeseros = response.data;

                    })
                    .catch(function (error) {
                        console.log(error);

                    });
            },
            pagarListaMeseros() {
                let me = this;
                Swal.fire({
                    title: 'Esta seguro de la operación?',
                    text: 'Esta acción no podra revertirse',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, hacerlo',
                    cancelButtonText: 'No, cancelar',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {
                        axios.post('/arqueo/pagar_lista_meseros', {
                                'detalle': me.arrayDetalleMesero,
                                'fecha': me.fecha
                            }).then(function (response) {
                                console.log(response.data.error);
                                me.cerrarModalConfirmarPagos();
                                setTimeout(() => {
                                    me.desplegarListaMeserosPagar('');
                                    me.traerArqueo();
                                }, 1000);
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Operación exitosa...',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                            })
                            .catch(function (error) {
                                console.log(error);
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Error...',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            });

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Cancelado',
                            'Tu acción ha sido cancelada :)',
                            'error'
                        )
                    }
                })

            },
            seleccionarMesero(mesero = [], index) {
                let me = this;
                let comision = parseFloat(mesero['total_comision']).toFixed(2);
                let total_ventas = parseFloat(mesero['total_ventas']).toFixed(2)
                let id_usuario = mesero['id_usuario'];
                Swal.fire({
                    title: 'Esta seguro del pago?\n' + 'Mesero: ' + mesero['nombre'] + '\n' + 'Monto Bs.: ' +
                        comision,
                    text: 'Esta acción no podra revertirse',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, hacerlo',
                    cancelButtonText: 'No, cancelar',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {
                        axios.post('/arqueo/pagar_mesero', {
                                'comision': comision,
                                'total_ventas': total_ventas,
                                'id_usuario': id_usuario,
                                'fecha': me.fecha,
                            }).then(function (response) {
                                setTimeout(() => {
                                    me.desplegarListaMeserosPagar('');
                                    me.traerArqueo();
                                    me.listado = 0;
                                }, 1000);

                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Pago realizado..',
                                    showConfirmButton: false,
                                    timer: 2000
                                })


                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        Swal.fire(
                            'Hecho!',
                            'Tu acción ha sido completada.',
                            'success'
                        )
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Cancelado',
                            'Tu acción ha sido cancelada :)',
                            'error'
                        )
                    }
                })
            },
            eliminarDetalle(index) {
                this.arrayDetalleMesero.splice(index, 1);
            },
            abrirModalConfirmarPagos() {
                this.modalconfirmarpagos = 1;
            },
            cerrarModalConfirmarPagos() {
                this.modalconfirmarpagos = 0;
                this.selectAll = false;
            },
            cerrarModalHistorialPagoMeseros() {
                this.modalhistorialpagomeseros = 0;
            },
            abrirModalHistorialPagoMeseros() {
                this.modalhistorialpagomeseros = 1;
                this.listaHistorialMeseros(this.fecha_inicio, this.fecha_fin, this.criterio2, this.buscar2);
            },
            seleccionarTodos() {
                this.arrayDetalleMesero = [];
                if (!this.selectAll) {
                    this.abrirModalConfirmarPagos();
                    for (let i in this.arrayMeseros) {
                        this.arrayDetalleMesero.push({
                            total_venta: this.arrayMeseros[i].total_ventas,
                            total_comision: this.arrayMeseros[i].total_comision,
                            id_usuario: this.arrayMeseros[i].id_usuario,
                            nombre: this.arrayMeseros[i].nombre,

                        });
                    }
                    //this.arrayMeseros = []
                }
            },
            desplegarListaMeserosPagar(buscar) {

                let me = this;
                var url = '/arqueo/lista_meseros_pagar?buscar=' + buscar;
                axios.get(url).then(function (response) {
                        me.arrayMeseros = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            seleccionarContenido(evento) {
                evento.target.select();
            },
            usuarioAuth() {
                let me = this;
                var url = '/usuario_auth';
                axios.get(url).then(function (response) {
                        me.usuario = response.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            downloadReport(milisecond) {
                let timerInterval
                Swal.fire({
                    title: 'Cargando Reporte!',
                    html: 'Por favor espere!! <b></b> milliseconds.',
                    timer: milisecond,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 300)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the timer')
                    }
                })
            },
            errorReport() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al Cargar el Reporte!...',
                    text: 'Comuniquese con el Administrador del Sistema',
                })
            },
            listarCaja(page, buscar, criterio) {
                let me = this;
                var url = '/importacion?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                        me.arrayimportacion = response.data.data;
                        me.pagination = {
                            total: response.data.total,
                            current_page: response.data.current_page,
                            per_page: response.data.per_page,
                            last_page: response.data.last_page,
                            from: response.data.from,
                            to: response.data.to
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            calcularArqueo: function () {
                var x1 = 0;
                var x2 = 0;
                var x3 = 0;
                var x4 = 0;
                var x5 = 0;
                var x6 = 0;
                var x7 = 0;
                var x8 = 0;
                var x9 = 0;
                var x10 = 0;
                var x11 = 0;
                var x11 = 0;
                var x12 = 0;
                var x13 = 0;
                var x14 = 0;
                var x15 = 0;
                var x16 = 0;
                var x17 = 0;
                var pago_meseros=0;
                x1 = parseFloat(this.datos.registro_venta);
                x2 = parseFloat(this.datos.apertura);
                x3 = x1 + x2;// this.datos.registro_venta+this.datos.apertura

                x4 = parseFloat(this.datos.gastos);
                x13 = parseFloat(this.datos.gastos_deposito);
                x5 = parseFloat(this.datos.registro_compra);
                pago_meseros = parseFloat(this.datos.total_pago_meseros);
                x6 = x4 + x5 + x13 + pago_meseros;// total_gastos (egresos)

                x7 = x3 - x6;//registros ingresos - registros egresos
                x8 = this.efectivo_total;
                x9 = x8 - x7;// efectivo_total - (ingresos - egresos)

                //total ingreso efectivo
                x10 = parseFloat(this.datos.total_efectivo);
                x11 = parseFloat(this.datos.total_credito);
                x12 = x10 + x11;

                //total egreso efectivo
                x14 = parseFloat(this.datos.total_efectivo_compra);
                x15 = parseFloat(this.datos.total_credito_compra);
                x17 = parseFloat(this.datos.gastos);
                x16 = x14 + x15 + x17 + pago_meseros;


                this.datos.total = x3;
                this.datos.saldo_sistema = x6;
                this.datos.saldo_efectivo = x7;
                this.datos.diferencia = x9;
                this.total_efec = x8;
                this.datos.total_ingreso_efectivo = x12;
                this.datos.total_egreso_efectivo = x16;
                return this.datos, this.total_efec;
            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarCajaAbierta;
            },
            registrosimportacion() {
                let me = this;
                var url = '/importacion/cantidad';
                axios.get(url).then(function (response) {
                        me.importacion_registro = response.data.nro;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            listarCajaAbierta() {
                let me = this;
                var url = '/arqueo_usuario';
                axios.get(url).then(function (response) {
                        me.arrayCaja = response.data;
                        me.datos.grupo = me.arrayCaja[0].grupo;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            traerArqueo() {
                let me = this;
                var url = '/arqueo2';
                axios.get(url).then(function (response) {
                        me.arrayArqueo = response.data;

                        me.datos.id = parseFloat(me.arrayArqueo[0].id);
                        me.datos.registro_venta = parseFloat(me.arrayArqueo[0].registro_venta);
                        me.datos.apertura = parseFloat(me.arrayArqueo[0].apertura);
                        me.datos.gastos = parseFloat(me.arrayArqueo[0].gastos);
                        me.datos.registro_compra = parseFloat(me.arrayArqueo[0].registro_compra);

                        me.datos.total_efectivo = parseFloat(me.arrayArqueo[0].total_efectivo);
                        me.datos.total_deposito = parseFloat(me.arrayArqueo[0].total_deposito);
                        me.datos.total_credito = parseFloat(me.arrayArqueo[0].total_credito);
                        me.datos.total_credito_deposito = parseFloat(me.arrayArqueo[0].total_credito_deposito);

                        me.datos.total_efectivo_compra = parseFloat(me.arrayArqueo[0].total_efectivo_compra);
                        me.datos.total_credito_compra = parseFloat(me.arrayArqueo[0].total_credito_compra);

                        me.datos.total_deposito_compra = parseFloat(me.arrayArqueo[0].total_deposito_compra);
                        me.datos.total_pago_meseros = parseFloat(me.arrayArqueo[0].pago_mesero);
                        me.datos.total_credito_deposito_compra = parseFloat(me.arrayArqueo[0]
                            .total_credito_deposito_compra);

                        me.datos.gastos_deposito = parseFloat(me.arrayArqueo[0].gastos_deposito);


                        if (isNaN(me.datos.total_efectivo)) {
                            me.datos.total_efectivo = 0;
                        }
                        if (isNaN(me.datos.total_deposito)) {
                            me.datos.total_deposito = 0;
                        }
                        if (isNaN(me.datos.total_credito)) {
                            me.datos.total_credito = 0;
                        }
                        if (isNaN(me.datos.total_credito_deposito)) {
                            me.datos.total_credito_deposito = 0;
                        }

                        if (isNaN(me.datos.total_efectivo_compra)) {
                            me.datos.total_efectivo_compra = 0;
                        }
                        if (isNaN(me.datos.total_credito_compra)) {
                            me.datos.total_credito_compra = 0;
                        }
                        if (isNaN(me.datos.total_deposito_compra)) {
                            me.datos.total_deposito_compra = 0;
                        }
                        if (isNaN(me.datos.total_credito_deposito_compra)) {
                            me.datos.total_credito_deposito_compra = 0;
                        }
                        if (isNaN(me.datos.total_pago_meseros)) {
                            me.datos.total_pago_meseros = 0;
                        }


                        if (isNaN(me.datos.gastos_deposito)) {
                            me.datos.gastos_deposito = 0;
                        }


                        me.calcularArqueo();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            ocultarListado1() {
                this.listado = 0;
            },

            aperturarCaja() {

                this.validarCajaAbierta();

                if (this.datos.apertura < 0) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'El monto no puede ser negativo...',
                        showConfirmButton: false,
                        timer: 1500
                    })

                } else {
                    if (this.is_busy == 0) {
                        if (this.errorimportacion == 0) {
                            let me = this;
                            axios.post('/arqueo/guardar', this.datos).then(function (response) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Registro agregado...',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    me.cerrarModal();
                                    me.listarCajaAbierta();
                                    me.verificarSoloUnaCajaAbierta();
                                    me.datos.apertura = 0;
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                        }
                    }
                    this.is_busy = 1;
                }
            },
            // aperturarC(){
            //     if(this.is_busy == 0){
            //         this.aperturarCaja();
            //         this.is_busy=1;
            //     }
            // },
            // async aperturarCaja(){

            //     try {

            //         //this.estadoCaja();
            //         this.listarCajaAbierta();
            //         this.validarCajaAbierta();

            //         let me = this;
            //         var url='/arqueo/estado';
            //         const res = await axios.get(url)
            //         me.estado_caja= res.data;

            //         console.log(me.arrayCaja);

            //         if(this.arrayCaja.length>0)
            //         {
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: 'Ya Existe una Caja Abierta...',
            //                 text: 'Cierre Caja!'
            //             })
            //         }else{
            //             if(this.errorimportacion==0){
            //                 //let me = this;
            //                 axios.post('/arqueo/guardar',this.datos).then(function(response){
            //                     Swal.fire({
            //                     position: 'top-end',
            //                     icon: 'success',
            //                     title: 'Registro agregado...',
            //                     showConfirmButton: false,
            //                     timer: 1500
            //                 })
            //                 // me.cerrarModal();
            //                 me.listarCajaAbierta();
            //                 me.datos.apertura=0;
            //                 })
            //                 .catch(function(error){
            //                     console.log(error);
            //                 });
            //             }
            //         }
            //     } catch (error) {
            //         if(error.response.data){
            //             this.errores=error.response.data.errors;
            //             this.is_busy=0;
            //         }
            //     }


            // },
            Limpiar() {
                this.datos = {
                        id: 0,
                        fecha_apertura: '',
                        fecha_cierre: '',
                        doscientos: 0,
                        cien: 0,
                        cincuenta: 0,
                        veinte: 0,
                        diez: 0,
                        cinco: 0,
                        dos: 0,
                        uno: 0,
                        cerocinco: 0,
                        ceroveinte: 0,
                        cien_dolar: 0,
                        registro_venta: 0,
                        alojamiento: 0,
                        apertura: 0,
                        total: 0,
                        gastos: 0,
                        registro_compra: 0,
                        saldo_sistema: 0,
                        saldo_efectivo: 0,
                        diferencia: 0,
                        id_usuario: 0,
                        estado: 'abierta',
                    },
                    this.total_efec = 0;
                this.listado = 0,
                    this.variable = 0,
                    this.arrayimportacion = [],
                    this.arrayCaja = [],
                    this.arrayArqueo = []
            },
            guardarimportacion() {
                if (this.validarCajaAbierta()) {
                    return;
                }
                let me = this;
                axios.post('/importacion/guardar', this.datos).then(function (response) {
                        if (response.data.error == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Este Nombre ya existe...',
                                text: 'Debe usar otro Nombre!'
                            })
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Registro agregado...',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            me.cerrarModal();
                            me.listarCajaAbierta();
                            me.verificarSoloUnaCajaAbierta();
                            me.registrosimportacion();
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            // cerrarCaja(){
            //     let me = this;
            //     axios.put('/arqueo/modificar',this.datos).then(function(response){
            //         Swal.fire({
            //             position: 'top-end',
            //             icon: 'success',
            //             title: 'Caja Cerrada Exitosamente',
            //             showConfirmButton: false,
            //             timer: 1500
            //         }) 
            //         me.cerrarModal();
            //         me.Limpiar();
            //         me.listarCajaAbierta();                    
            //     }).catch(function(error){
            //         console.log(error);
            //     });
            // },   
            actualizarVentasAlCerrarCaja() {
                axios.post('/arqueo/actualizar_ventas?id_caja=' + this.datos.id).then(function (response) {
                        console.log(response.data.error);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            cerrarCaja() {
                let me = this;

                if (me.datos.doscientos < 0) {
                    this.validacionError('200 No se permite monto negativo', 3000);
                } else if (me.datos.cien < 0) {
                    this.validacionError('100 No se permite monto negativo', 3000);
                } else if (me.datos.cincuenta < 0) {
                    this.validacionError('50 No se permite monto negativo', 3000);
                } else if (me.datos.veinte < 0) {
                    this.validacionError('20 No se permite monto negativo', 3000);
                } else if (me.datos.diez < 0) {
                    this.validacionError('10 No se permite monto negativo', 3000);
                } else if (me.datos.cinco < 0) {
                    this.validacionError('5 No se permite monto negativo', 3000);
                } else if (me.datos.dos < 0) {
                    this.validacionError('2 No se permite monto negativo', 3000);
                } else if (me.datos.uno < 0) {
                    this.validacionError('1 No se permite monto negativo', 3000);
                } else if (me.datos.cerocinco < 0) {
                    this.validacionError('0.50 No se permite monto negativo', 3000);
                } else if (me.datos.ceroveinte < 0) {
                    this.validacionError('0.2 No se permite monto negativo', 3000);
                } else if (me.datos.cien_dolar < 0) {
                    this.validacionError('100 Dólares No se permite monto negativo', 3000);
                } else {
                    this.cerrar();
                    this.actualizarVentasAlCerrarCaja();
                }

            },

            validacionError(nombreError, tiempo) {
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
                    title: '<span style="color: red; font-size: 15px">ERROR!!!</div><span style="color: black; font-size: 15px">...' +
                        nombreError + '</span>'
                })
            },
            cerrar() {
                let me = this;
                axios.put('/arqueo/modificar', this.datos).then(function (response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Caja Cerrada Exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    me.Limpiar();
                    me.listarCajaAbierta();
                    me.verificarSoloUnaCajaAbierta();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarCajaAbierta() {

                this.errorimportacion = 0;
                this.errorMostrarMsjimportacion = [];

                if (this.cantidad_cajas_abiertas > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Otro usuario ya tiene una caja abierta...',
                        text: 'Cierre Caja!'
                    })
                    this.errorimportacion = 1
                } else {
                    if (this.datos.apertura < 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'El monto no puede estar vacío...',
                            text: 'Ingrese Monto!'
                        })
                        this.errorimportacion = 1
                    } else {
                        if (this.arrayCaja.length > 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ya Existe una Caja Abierta...',
                                text: 'Cierre Caja!'
                            })
                            this.errorimportacion = 1
                        }
                    }
                }

                return this.errorimportacion;
            },
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.errorimportacion = 0;
                this.datos = {
                    id: 0,
                    nombre: '',
                    descripcion: '',
                    estado: '1',
                }
            },
            btnArqueo() {
                this.is_busy = 0;
                if (this.arrayCaja.length > 0) {
                    let me = this;
                    me.listado = 1;
                    me.datos = {
                        id: 0,
                        fecha_apertura: '',
                        fecha_cierre: '',
                        doscientos: 0,
                        cien: 0,
                        cincuenta: 0,
                        veinte: 0,
                        diez: 0,
                        cinco: 0,
                        dos: 0,
                        uno: 0,
                        cerocinco: 0,
                        ceroveinte: 0,
                        cien_dolar: 0,
                        total: 0,
                        gastos: 0,
                        saldo_efectivo: 0,
                        diferencia: 0,
                        id_usuario: 0,
                    };
                    me.traerArqueo();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'No hay ninguna caja abierta para este usuario',
                        text: 'Aperture Caja!'
                    })
                }

            },
            abrirModal(modelo, accion, data = []) {
                this.errorimportacion = 0;
                this.errorMostrarMsjimportacion = [];
                switch (modelo) {
                    case "importacion": {
                        switch (accion) {
                            case 'registrar': {
                                this.modal = 1;
                                this.tituloModal = 'Registro Importación'
                                this.datos = {
                                    id: 0,
                                    nombre: '',
                                    descripcion: '',
                                    estado: '1',
                                }
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'modificar': {
                                this.modal = 1;
                                this.tituloModal = 'Modificar Importación';
                                this.tipoAccion = 2;
                                this.datos.id = data['id'];
                                this.datos.nombre = data['nombre'];
                                this.datos.descripcion = data['descripcion'];
                                this.datos.estado = data['estado'];
                                break;
                            }
                        }
                    }
                }

            },
            desactivarimportacion(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Inhabilitar esta Importación??',
                    text: "Puede revertir esta decisión!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Inhabilitar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put('/importacion/desactivar', {
                            'id': id
                        }).then(function (response) {
                            me.listarCaja(1, '', 'name');
                            swalWithBootstrapButtons.fire(
                                'Inhabilitado!',
                                'Esta Importación se ha Inhabilitado.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'Esta Importación no ha tenido cambios :)',
                            'error'
                        )
                    }
                })
            },
            activarimportacion(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de Habilitar esta Importación??',
                    text: "Puede revertir esta decisión!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Habilitar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put('/importacion/activar', {
                            'id': id
                        }).then(function (response) {
                            me.listarCaja(1, '', 'name');
                            swalWithBootstrapButtons.fire(
                                'Habilitado!',
                                'Esta Importación se ha Habilitado.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'Esta Importación no ha tenido cambios :)',
                            'error'
                        )
                    }
                })
            }
        },
        mounted() {
            this.listarCajaAbierta();
            this.verificarSoloUnaCajaAbierta();
            this.registrosimportacion();
            this.usuarioAuth();
        }
    }

</script>
<style>
    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }

    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #d1cdcd7a !important;
    }

    .div-error {
        display: flex;
        justify-content: center;
    }

    .text-error {
        color: red !important;
        font-weight: bold;
    }

    .footer {
        position: relative !important;
        width: auto !important;
    }

    .AA {
        float: left;
        text-align: center;
    }

    .BB {
        float: left;
        text-align: center;
    }

    .cuadro {
        border-width: 1px;
        border-style: solid;
        border-color: black;
    }

    .tt {
        height: 33px;
    }

    #ttt {
        height: 25px;
        width: 100px;
    }

    .pp {
        height: 100%;
    }

    .border-detalle {
        width: 300px;
        height: 580px;
        border: 2px solid orange;
        box-sizing: border-box;
    }

    .border-apertura {
        width: 300px;
        height: 50px;
        border: 2px solid orange;
        box-sizing: border-box;
    }

    .border-registro {
        width: 300px;
        height: 525px;
        border: 2px solid #3399FF;
    }

    .border-efectivo {
        width: 300px;
        height: 200px;
        border: 2px solid #3399FF;
    }

    .size-div {
        width: 35% !important;
    }

    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #d1cdcd7a !important;
    }

</style>
