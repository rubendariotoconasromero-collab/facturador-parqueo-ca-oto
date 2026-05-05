<template>
    <main class="main">
        <!--BreadCrumb-->

        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-chart">
                                <div class="card-header text-white text-center" style="background-color: #e55353">
                                    <div style="font-size: 15px;">TOTAL VENTAS</div>
                                </div>
                                <div class="card-content">
                                    <h5 class="card-title" align="center">{{ totalVenta }} Bs</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-chart">
                                <div class="card-header text-white text-center" style="background-color: #f9b115">
                                    <div style="font-size: 15px;">TOTAL COMPRAS</div>
                                </div>
                                <div class="card-content">
                                    <h5 class="card-title" align="center">{{ totalCompra }} Bs</h5>
                                </div>
                            </div>
                        </div>
                       
                    </div>

                
                    <div class="col-md-12">
                        &nbsp;
                    </div>

                    <div class="row justify-content-between">
                        <div class="col-md-8 bg-success text-white card mr-1">
                            <div class="row d-flex align-items-end pb-1">
                                <div class="col-md-7">

                                    <div class="input-group">
                                        <p class="font-weight-bold"><b>Reporte por rango</b></p>
                                        <table width="100%" height="5%">
                                            <tr width="100%">
                                                <td style="width:10%;text-align:center">
                                                    Desde
                                                </td>
                                                <td style="width:15%;text-align:left">
                                                    <input type="date" class="form-control" v-model="datos.fecha_inicio"
                                                        @change="getVentaMontoTotal(),getCompraMontoTotal(),getActualizarGraficoVenta(datos.fecha_inicio,datos.fecha_fin, criterio),getActualizarGraficoCompra(datos.fecha_inicio,datos.fecha_fin, criterio)"
                                                        style='font-size: 0.8rem'>
                                                    <!--<input type="date" class="form-control"  v-model="datos.fecha_inicio" @change="getVentaMontoTotal(),getCompraMontoTotal(),refrescarGraficoVenta(),getCompra(datos.fecha_inicio,datos.fecha_fin, criterio)" style='font-size: 0.8rem'>-->
                                                </td>
                                                <td style="width:10%;text-align:center">
                                                    Hasta
                                                </td>
                                                <td style="width:15%;text-align:left">
                                                    <input type="date" class="form-control" v-model="datos.fecha_fin"
                                                        @change="getVentaMontoTotal(),getCompraMontoTotal(),getActualizarGraficoVenta(datos.fecha_inicio,datos.fecha_fin, criterio), getActualizarGraficoCompra(datos.fecha_inicio,datos.fecha_fin, criterio)"
                                                        style='font-size: 0.8rem'>
                                                    <!--<input type="date" class="form-control"  v-model="datos.fecha_fin" @change="getVentaMontoTotal(),getCompraMontoTotal(),refrescarGraficoVenta(), getCompra(datos.fecha_inicio,datos.fecha_fin, criterio)" style='font-size: 0.8rem'>-->
                                                </td>
                                                <td style="width:57%;text-align:left">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-4  d-flex align-items-end">
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input mb-2" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio1" value="1" v-model="criterio"
                                                @change="getActualizarGraficoVenta(datos.fecha_inicio,datos.fecha_fin, criterio),getActualizarGraficoCompra(datos.fecha_inicio,datos.fecha_fin, criterio)">
                                            <label class="form-check-label" for="inlineRadio1">Diario</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input mb-2" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio2" value="0" v-model="criterio"
                                                @change="getActualizarGraficoVenta(datos.fecha_inicio,datos.fecha_fin, criterio),getActualizarGraficoCompra(datos.fecha_inicio,datos.fecha_fin, criterio)">
                                            <label class="form-check-label" for="inlineRadio2">Mensual</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-md-3 d-flex flex-column align-items-start justify-content-end bg-success ml-1 text-white pb-1 card">
                            <div class="row ">
                                <div class="col-md-12 ">
                                    <p class="font-weight-bold"><b>Reporte solo por Mes</b></p>
                                    <select v-model="busqueda_mes" @change="busquedaMes()"
                                        class="form-select form-select-sm" aria-label=".form-select-lg example">
                                        <option value="0" selected>Seleccione un mes</option>
                                        <option value="1"> Enero</option>
                                        <option value="2"> Febrero</option>
                                        <option value="3"> Marzo</option>
                                        <option value="4"> Abril</option>
                                        <option value="5"> Mayo</option>
                                        <option value="6"> Junio</option>
                                        <option value="7"> Julio</option>
                                        <option value="8"> Agosto</option>
                                        <option value="9"> Septiembre</option>
                                        <option value="10"> Octubre</option>
                                        <option value="11"> Noviembre</option>
                                        <option value="12"> Diciembre</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header text-white" style="background-color: #e55353">
                                    <h4>VENTAS</h4>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mb-0"
                                    style="font-size:13px">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions1"
                                            id="inlineRadio3" value="bar" v-model="figura_venta"
                                            @change="cambiarFiguraVenta()">
                                        <label class="form-check-label" for="inlineRadio3">Barras</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions1"
                                            id="inlineRadio4" value="pie" v-model="figura_venta"
                                            @change="cambiarFiguraVenta()">
                                        <label class="form-check-label" for="inlineRadio4">Torta</label>
                                    </div>

                                </div>

                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="venta">
                                        </canvas>
                                    </div>
                                </div>
                                <div class="card-footer" style="background-color: #FFFF">
                                    <p>Ventas Generales.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header text-white" style="background-color: #f9b115">
                                    <h4>COMPRAS</h4>
                                </div>

                                <div class="d-flex justify-content-center align-items-center mb-0"
                                    style="font-size:13px">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions2"
                                            id="inlineRadio5" value="bar" v-model="figura_compra"
                                            @change="cambiarFiguraCompra()">
                                        <label class="form-check-label" for="inlineRadio5">Barras</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions2"
                                            id="inlineRadio6" value="pie" v-model="figura_compra"
                                            @change="cambiarFiguraCompra()">
                                        <label class="form-check-label" for="inlineRadio6">Torta</label>
                                    </div>

                                </div>
                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="compra">
                                        </canvas>
                                    </div>
                                </div>
                                <div class="card-footer" style="background-color: #FFFF">
                                    <p>Compras de los últimos meses.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
        </div>
        </div>

    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    import moment from 'moment';


    export default {
        data() {
            return {
                datos: {
                    fecha_inicio: moment().format('YYYY-MM-DD'),
                    fecha_fin: moment().format('YYYY-MM-DD'),


                },
                mesProducto: moment().format('MM'),
                anio: moment().format('YYYY'),

                totalVenta: 0,
                totalVentaD: 0,
                totalVentaS: 0,
                totalCompra: 0,
                totalAdministrador: 0,
                totalCajero: 0,

                varCompra: '',
                charCompra: null,
                compra: [],
                varTotalCompra: [],
                varMesCompra: [],
                varDiaCompra: [],

                varVenta: null,
                charVenta: null,
                venta: [],
                varTotalVenta: [],
                //varMesVenta:[],
                varTienda: [],

                ventaD: [],
                varVentaD: null,
                charVentaD: null,
                varTotalVentaD: [],
                varMesVentaD: [],

                varVentaDirecta: null,
                charVentaDirecta: null,
                ventaDirecta: [],
                varTotalVentaDirecta: [],
                varTiendaDirecta: [],

                varVentaServicio: null,
                charVentaServicio: null,
                ventaServicio: [],
                varTotalVentaServicio: [],
                varTiendaServicio: [],

                arrayProducto: [],
                arrayProductoMeses: [],
                criterio: 1,
                busqueda_mes: 0,
                figura_venta: 'bar',
                figura_compra: 'bar',

            }
        },
        methods: {
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
            cambiarFiguraVenta() {
                this.getActualizarGraficoVenta(this.datos.fecha_inicio, this.datos.fecha_fin, this.criterio);
                //this.getCompra(this.datos.fecha_inicio, this.datos.fecha_fin, this.criterio);
            },

            cambiarFiguraCompra() {
                //this.getVenta(this.datos.fecha_inicio, this.datos.fecha_fin, this.criterio);
                this.getActualizarGraficoCompra(this.datos.fecha_inicio, this.datos.fecha_fin, this.criterio);
            },

            getCompra(fecha_inicio, fecha_fin, criterio) {
                let me = this;
                var url = '/dashboard?fecha_inicio=' + fecha_inicio + '&fecha_fin=' + fecha_fin + '&criterio=' +
                    criterio;
                axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.compra = respuesta.compra;
                        // me.venta = respuesta.venta;
                        // me.ventaDirecta = respuesta.venta_directa;
                        // me.ventaServicio = respuesta.venta_servicio;
                        //cargamos los datos del chart
                        me.loadCompra();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            getVenta(fecha_inicio, fecha_fin, criterio) {
                let me = this;
                me.venta = [];
                // console.log(fecha_inicio);
                var url = '/dashboard?fecha_inicio= ' + me.datos.fecha_inicio + '&fecha_fin=' + me.datos.fecha_fin +
                    '&criterio=' + me.criterio;
                axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.venta = respuesta.venta;
                        //cargamos los datos del chart
                        //me.loadVenta();
                        me.refrescarGraficoVenta();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            busquedaMes() {
                let me = this;
                me.venta = [];
                var url = "/dashboard/reporte_mes?mes=" + me.busqueda_mes;
                axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.venta = respuesta.venta;
                        me.compra = respuesta.compra;
                        me.loadVentaPorMes();
                        me.loadCompraPorMes();
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                
            },
            getVentaDirecta() {
                let me = this;
                var url = '/dashboard';
                axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.ventaDirecta = respuesta.venta_directa;
                        //cargamos los datos del chart
                        me.loadVentaDirecta();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getVentaServicio() {
                let me = this;
                var url = '/dashboard';
                axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.ventaServicio = respuesta.venta_servicio;
                        //cargamos los datos del chart
                        me.loadVentaServicio();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getVentaMontoTotal() {
                let me = this;
                // var url='/notaventa/montoT?fecha_inicio= ' + me.datos.fecha_inicio + '&fecha_fin=' + me.datos.fecha_fin;
                var url = '/notaventa/montoT';
                axios.get(url).then(function (response) {
                        me.totalVenta = parseFloat(response.data[0].total) ? parseFloat(response.data[0].total) : 0;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getCompraMontoTotal() {
                let me = this;
                // var url='/notacompra/montoT?fecha_inicio= ' + me.datos.fecha_inicio + '&fecha_fin=' + me.datos.fecha_fin;
                var url = '/notacompra/montoT';
                axios.get(url).then(function (response) {
                        me.totalCompra = parseFloat(response.data[0].total) ? parseFloat(response.data[0].total) :
                            0;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getVentaMontoTotalD() {
                let me = this;
                var url = '/notaventa/montoD';
                axios.get(url).then(function (response) {
                        me.totalVentaD = parseFloat(response.data[0].total) ? parseFloat(response.data[0].total) :
                            0;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getVentaMontoTotalS() {
                let me = this;
                var url = '/notaventa/montoS';
                axios.get(url).then(function (response) {
                        me.totalVentaS = parseFloat(response.data[0].total) ? parseFloat(response.data[0].total) :
                            0;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },



            getAdministrador() {
                let me = this;
                var url = '/notaventa/montoUsuario';
                axios.get(url).then(function (response) {
                        me.totalAdministrador = parseFloat(response.data[0].usuario) ? parseFloat(response.data[0]
                            .usuario) : 0;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getCajeros() {
                let me = this;
                var url = '/notaventa/montoUsuario/Cajero';
                axios.get(url).then(function (response) {
                        me.totalCajero = parseFloat(response.data[0].usuario) ? parseFloat(response.data[0]
                            .usuario) : 0;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },


            loadCompra() {
                let me = this;
                if (me.criterio == 1) {
                    me.compra.map(function (x) {
                        me.varMesCompra.push(x.fecha_literal);
                        // me.varDiaCompra.push(x.dia);
                        me.varTotalCompra.push(x.total);
                    });
                } else {
                    if (me.criterio == 0) {
                        me.compra.map(function (x) {
                            me.varMesCompra.push(x.mes);
                            // me.varDiaCompra.push(x.dia);
                            me.varTotalCompra.push(x.total);
                        });
                    }
                }
                me.varCompra = document.getElementById('compra').getContext('2d');
                me.charCompra = new Chart(me.varCompra, {
                    type: me.figura_compra,
                    data: {
                        labels: me.varMesCompra,
                        // labels: me.varDiaCompra,
                        datasets: [{
                            label: 'Compras',
                            data: me.varTotalCompra,
                            backgroundColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                me.varMesCompra = [];
                me.varTotalCompra = [];
            },

            // GRAFICOS DE COMPRAS*************************************************************
            getActualizarGraficoCompra(fecha_inicio, fecha_fin, criterio) {
                let me = this;
                var url = '/dashboard?fecha_inicio=' + fecha_inicio + '&fecha_fin=' + fecha_fin + '&criterio=' +
                    criterio;
                axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.compra = respuesta.compra;
                        me.actualizarGraficoCompra();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            actualizarGraficoCompra(){
                let me = this;
                me.varMesCompra=[];
                me.varTotalCompra=[];
                if (me.criterio == 1) {
                    me.compra.map(function (x) {
                        me.varMesCompra.push(x.fecha_literal);
                        me.varTotalCompra.push(x.total);
                    });
                } else {
                    if (me.criterio == 0) {
                        me.compra.map(function (x) {
                            me.varMesCompra.push(x.mes);
                            me.varTotalCompra.push(x.total);
                        });
                    }
                }
                me.charCompra.config.type = me.figura_compra;
                me.charCompra.data.labels = me.varMesCompra;
                me.charCompra.data.datasets[0].data = me.varTotalCompra;
                me.charCompra.update();

            },

            getIniciarGraficoCompra(fecha_inicio, fecha_fin, criterio) {
                let me = this;
                var url = '/dashboard?fecha_inicio=' + fecha_inicio + '&fecha_fin=' + fecha_fin + '&criterio=' +
                    criterio;
                axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.compra = respuesta.compra;
                        me.iniciarGraficoCompra();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            iniciarGraficoCompra() {
                let me = this;
                if (me.criterio == 1) {
                    me.compra.map(function (x) {
                        me.varMesCompra.push(x.fecha_literal);
                        me.varTotalCompra.push(x.total);
                    });
                } else {
                    if (me.criterio == 0) {
                        me.compra.map(function (x) {
                            me.varMesCompra.push(x.mes);
                            me.varTotalCompra.push(x.total);
                        });
                    }
                }
                me.varCompra = document.getElementById('compra').getContext('2d');
                me.charCompra = new Chart(me.varCompra, {
                    type: me.figura_compra,
                    data: {
                        labels: me.varMesCompra,
                        // labels: me.varDiaCompra,
                        datasets: [{
                            label: 'Compras',
                            data: me.varTotalCompra,
                            backgroundColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                me.varMesCompra = [];
                me.varTotalCompra = [];
            },
            // FIN GRAFICOS DE COMPRAS*********************************************************


            // GRAFICOS DE VENTAS**************************************************************

            getIniciarGraficoVenta(fecha_inicio, fecha_fin, criterio) {
                let me = this;
                me.venta = [];
                // console.log(fecha_inicio);
                var url = '/dashboard?fecha_inicio= ' + me.datos.fecha_inicio + '&fecha_fin=' + me.datos.fecha_fin +
                    '&criterio=' + me.criterio;
                axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.venta = respuesta.venta;
                        //cargamos los datos del chart
                        //me.loadVenta();
                        me.iniciarGraficoVenta();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            iniciarGraficoVenta() { // Inicia el grafico una sola vez
                let me = this;
                me.varTienda = [];
                me.varTotalVenta = [];
                if (me.criterio == 1) {
                    me.venta.map(function (x) {
                        me.varTienda.push(x.fecha_literal);
                        //me.varMesVenta.push(x.mes);
                        me.varTotalVenta.push(x.total);
                    });
                } else {
                    if (me.criterio == 0) {
                        me.venta.map(function (x) {
                            me.varTienda.push(x.mes);
                            //me.varMesVenta.push(x.mes);
                            me.varTotalVenta.push(x.total);
                        });
                    }
                }
                me.varVenta = document.getElementById('venta').getContext('2d');
                me.charVenta = new Chart(me.varVenta, {
                    type: me.figura_venta, //bar //pie
                    data: {
                        labels: me.varTienda,
                        datasets: [{
                            // label: me.varTienda,
                            label: 'Venta',
                            data: me.varTotalVenta,
                            backgroundColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            },

            getActualizarGraficoVenta(fecha_inicio, fecha_fin, criterio) {
                let me = this;
                me.venta = [];
                var url = '/dashboard?fecha_inicio= ' + me.datos.fecha_inicio + '&fecha_fin=' + me.datos.fecha_fin +
                    '&criterio=' + me.criterio;
                axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.venta = respuesta.venta;
                        me.actualizarGraficoVenta();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            actualizarGraficoVenta() {
                let me = this;
                me.varTienda = [];
                me.varTotalVenta = [];
                if (me.criterio == 1) {
                    me.venta.map(function (x) {
                        me.varTienda.push(x.fecha_literal);
                        //me.varMesVenta.push(x.mes);
                        me.varTotalVenta.push(x.total);
                    });
                } else {
                    if (me.criterio == 0) {
                        me.venta.map(function (x) {
                            me.varTienda.push(x.mes);
                            //me.varMesVenta.push(x.mes);
                            me.varTotalVenta.push(x.total);
                        });
                    }
                }
                me.charVenta.config.type = me.figura_venta;
                me.charVenta.data.labels = me.varTienda;
                me.charVenta.data.datasets[0].data = me.varTotalVenta;
                me.charVenta.update();
            },

            // FIN ACTUALIZAR GRAFICO DE VENTAS******************************************

            refrescarGraficoVenta() {

                let me = this;


                me.varTienda = [];
                me.varTotalVenta = [];
                if (me.criterio == 1) {
                    me.venta.map(function (x) {
                        me.varTienda.push(x.fecha_literal);
                        //me.varMesVenta.push(x.mes);
                        me.varTotalVenta.push(x.total);
                    });
                } else {
                    if (me.criterio == 0) {
                        me.venta.map(function (x) {
                            me.varTienda.push(x.mes);
                            //me.varMesVenta.push(x.mes);
                            me.varTotalVenta.push(x.total);
                        });
                    }
                }


                me.varVenta = document.getElementById('venta').getContext('2d');

                me.charVenta = new Chart(me.varVenta, {
                    type: me.figura_venta, //bar //pie
                    data: {
                        labels: me.varTienda,
                        datasets: [{
                            // label: me.varTienda,
                            label: 'Venta',
                            data: me.varTotalVenta,
                            backgroundColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            },


            loadVenta() {
                let me = this;
                me.varTienda = [];
                me.varTotalVenta = [];
                if (me.criterio == 1) {
                    me.venta.map(function (x) {
                        me.varTienda.push(x.fecha_literal);
                        me.varTotalVenta.push(x.total);
                    });
                } else {
                    if (me.criterio == 0) {
                        me.venta.map(function (x) {
                            me.varTienda.push(x.mes);
                            //me.varMesVenta.push(x.mes);
                            me.varTotalVenta.push(x.total);
                        });
                    }
                }

                me.varVenta = document.getElementById('venta').getContext('2d');
                me.charVenta = new Chart(me.varVenta, {
                    type: me.figura_venta, //bar //pie
                    data: {
                        labels: me.varTienda,
                        datasets: [{
                            // label: me.varTienda,
                            label: 'Venta',
                            data: me.varTotalVenta,
                            backgroundColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderColor: ["#30E8AA", "#6291FF", "#B2C12C", "#FBBD43", "#E65E72"],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });

                //me.varVenta.clearRect(0, 0, me.varVenta.canvas.width, me.varVenta.canvas.height);
                //me.venta=[];

            },

            loadVentaPorMes() {
                let me = this;
                me.varTienda = [];
                me.varTotalVenta = [];
                me.venta.map(function (x) {
                    me.varTienda.push(x.mes);
                    me.varTotalVenta.push(x.total);
                });

                me.charVenta.data.labels = me.varTienda;
                me.charVenta.data.datasets[0].data = me.varTotalVenta;
                me.charVenta.update();

            },

            loadCompraPorMes() {
                let me = this;
                me.varMesCompra = [];
                me.varTotalCompra = [];
                me.compra.map(function (x) {
                    me.varMesCompra.push(x.mes);
                    // me.varDiaCompra.push(x.dia);
                    me.varTotalCompra.push(x.total);
                });

                me.charCompra.data.labels = me.varMesCompra;
                me.charCompra.data.datasets[0].data = me.varTotalCompra;
                me.charCompra.update();

            },
        },
        mounted() {
            // this.getCompra();
            // this.getVenta();

            // this.getVentaDirecta();
            // this.getVentaServicio();
            //this.iniciarGraficoVenta();
            this.getVentaMontoTotal();
            this.getCompraMontoTotal();
            //this.getVenta(this.datos.fecha_inicio, this.datos.fecha_fin, this.criterio);
            this.getIniciarGraficoCompra(this.datos.fecha_inicio, this.datos.fecha_fin, this.criterio);
            this.getIniciarGraficoVenta(this.datos.fecha_inicio, this.datos.fecha_fin, this.criterio);

            //this.getVentaMontoTotalD();
            // this.getVentaMontoTotalS();
            // this.getAdministrador();
            // this.getCajeros();

           

        },
        created() {

        }
    }

</script>
