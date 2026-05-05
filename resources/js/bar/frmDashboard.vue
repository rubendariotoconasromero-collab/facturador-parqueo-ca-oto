<template>
    <main class="main">
        <!-- <div class="container"> -->
            <div class="row">
                <div class="col">
                &nbsp;
                <!--<template v-if="!isLoading">-->
                    <template v-if="vista==0">
                        <div class="container">
                            <div class="row">

                                <!--<div v-for="(item, index) in formularios" :key="index" class="card px-0 m-3" style="max-width: 7rem;border-color: white;">-->
                                <div class="card px-0 m-3" style="max-width: 7rem;border-color: white;">

                                    <div class="card-body">
                                        <div class="text-center img-container">

                                            <!--<template v-if="item.frm_formulario == 'principal-component' || item.frm_formulario == 'frm-tp1-venta' || item.frm_formulario == 'frm-tp1-venta-mesero' || item.frm_formulario == 'frm-tp1-historialventa' || item.frm_formulario == 'frm-tp1-historialventa-mesero' || item.frm_formulario == 'frm-compra' || item.frm_formulario == 'frm-historialcompra' || item.frm_formulario == 'frm-historial' || item.frm_formulario == 'frm-inventario' || item.frm_formulario == 'frm-articulo' || item.frm_formulario == 'frm-categoria' || item.frm_formulario == 'frm-ajuste' || item.frm_formulario == 'frm-salon' || item.frm_formulario == 'frm-mesa' || item.frm_formulario == 'frm-tp1-paquete' || item.frm_formulario == 'frm-tp1-historialpaquete' || item.frm_formulario == 'frm-motivo-gasto' || item.frm_formulario == 'frm-gasto' || item.frm_formulario == 'frm-cliente' || item.frm_formulario == 'frm-proveedor'  || item.frm_formulario == 'frm-personal' || item.frm_formulario == 'frm-miempresa'   || item.frm_formulario == 'frm-usuario'   || item.frm_formulario == 'frm-permiso' || item.frm_formulario == 'frm-configuracion-impresora' || item.frm_formulario == 'frm-contrasena'  || item.frm_formulario == 'frm-reportes'">-->

                                                <!--<button type="button" class="btn"><img :src="item.imagen" @click="frmFormularios(item)" width=70px></button>-->
                                            <!--</template>-->

                                            <button @click="menu=100" type="button" class="btn"><img src="img/menu/cliente.png" width=70px></button>

                                        </div>
                                        <!--<div class="text-center" style="padding-left:15px">
                                            <label for="exampleInputPassword1" class="form-label"><strong>{{ item.nombre_vista }}</strong></label>
                                        </div>-->




                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- </div> -->
                        <!--Modal Formulario Pago al Crédito-->
                        <div class="modal fade" id="modalPrincipal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
                                <div class="modal-content">
                                    <div class="modal-header  text-white background" style="background-color: #46546c">
                                        <h4 class="modal-title ">{{ nombre_frm }}</h4>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" @clic="volverMenu()"></button>
                                    </div>

                                    <div class="modal-body">




                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal" @click="limpiarCXCobrar()">Cerrar</button>
                                        <button type="button" class="btn text-white" style="background-color: #0173C7"  data-bs-dismiss="modal" @click="guardarAmortizacion()">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                <!--</template>-->
                <!--<template v-if="isLoading">
                    <div class="contenedor loading">
                        <div class="d-flex justify-content-center text-info">
                            <div class="spinner-border" role="status" style="height: 75px; width: 75px; font-size: 40px">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center text-info" style="padding-top: 20px">
                            <span>Cargando Vista...Por Favor Espere!!!</span>
                        </div>
                    </div>
                </template>-->
    </div>
</div>
        <!--Fin modal Formulario Pago al credito-->
        <template v-if="vista==1">
            <template v-if="frm=='principal-component'">
                <principal-component @cerrarMenu="listadoPrincipal"></principal-component>
            </template>
            <template v-if="frm=='frm-tp1-venta'">
                <frm-venta-escritorio @cerrarMenu="listadoPrincipal"></frm-venta-escritorio>
            </template>
            <template v-if="frm=='frm-tp1-venta-mesero'">
                <frm-venta-nueva @cerrarMenu="listadoPrincipal"></frm-venta-nueva>
            </template>
            <template v-if="frm=='frm-tp1-historialventa'">
                <frm-tp1-historialventa @cerrarMenu="listadoPrincipal"></frm-tp1-historialventa>
            </template>
            <template v-if="frm=='frm-tp1-historialventa-mesero'">
                <frm-tp1-historialventa-mesero @cerrarMenu="listadoPrincipal"></frm-tp1-historialventa-mesero>
            </template>
            <template v-if="frm=='frm-tp1-pago'">
                <frm-tp1-pago @cerrarMenu="listadoPrincipal"></frm-tp1-pago>
            </template>
            <template v-if="frm=='frm-compra'">
                <frm-compra @cerrarMenu="listadoPrincipal"></frm-compra>
            </template>
            <template v-if="frm=='frm-historialcompra'">
                <frm-historialcompra @cerrarMenu="listadoPrincipal"></frm-historialcompra>
            </template>
            <template v-if="frm=='frm-pago-compra'">
                <frm-pago-compra @cerrarMenu="listadoPrincipal"></frm-pago-compra>
            </template>
            <template v-if="frm=='frm-historial'">
                <frm-historial @cerrarMenu="listadoPrincipal"></frm-historial>
            </template>
            <template v-if="frm=='frm-inventario'">
                <frm-inventario @cerrarMenu="listadoPrincipal"></frm-inventario>
            </template>
            <template v-if="frm=='frm-articulo'">
                <frm-articulo @cerrarMenu="listadoPrincipal"></frm-articulo>
            </template>
            <template v-if="frm=='frm-categoria'">
                <frm-categoria @cerrarMenu="listadoPrincipal"></frm-categoria>
            </template>
            <!-- <template v-if="frm=='frm-unidad'">
                <frm-unidad @cerrarMenu="listadoPrincipal"></frm-unidad>
            </template> -->
            <template v-if="frm=='frm-ajuste'">
                <frm-ajuste @cerrarMenu="listadoPrincipal"></frm-ajuste>
            </template>
            <template v-if="frm=='frm-salon'">
                <frm-salon @cerrarMenu="listadoPrincipal"></frm-salon>
            </template>
            <template v-if="frm=='frm-mesa'">
                <frm-mesa @cerrarMenu="listadoPrincipal"></frm-mesa>
            </template>
            <template v-if="frm=='frm-tp1-paquete'">
                <frm-tp1-paquete @cerrarMenu="listadoPrincipal"></frm-tp1-paquete>
            </template>
            <template v-if="frm=='frm-tp1-historialpaquete'">
                <frm-tp1-historialpaquete @cerrarMenu="listadoPrincipal"></frm-tp1-historialpaquete>
            </template>
            <template v-if="frm=='frm-motivo-gasto'">
                <frm-motivo-gasto @cerrarMenu="listadoPrincipal"></frm-motivo-gasto>
            </template>
            <template v-if="frm=='frm-gasto'">
                <frm-gasto @cerrarMenu="listadoPrincipal"></frm-gasto>
            </template>
            <template v-if="frm=='frm-cliente'">
                <frm-cliente @cerrarMenu="listadoPrincipal"></frm-cliente>
            </template>
            <template v-if="frm=='frm-proveedor'">
                <frm-proveedor @cerrarMenu="listadoPrincipal"></frm-proveedor>
            </template>
            <template v-if="frm=='frm-personal'">
                <frm-personal @cerrarMenu="listadoPrincipal"></frm-personal>
            </template>
            <!-- <template v-if="frm=='frm-cliente-relacionador'">
                <frm-cliente-relacionador @cerrarMenu="listadoPrincipal"></frm-cliente-relacionador>
            </template> -->
            <template v-if="frm=='frm-miempresa'">
                <frm-miempresa @cerrarMenu="listadoPrincipal"></frm-miempresa>
            </template>
            <template v-if="frm=='frm-usuario'">
                <frm-usuario @cerrarMenu="listadoPrincipal"></frm-usuario>
            </template>
            <template v-if="frm=='frm-permiso'">
                <frm-permiso @cerrarMenu="listadoPrincipal"></frm-permiso>
            </template>
            <template v-if="frm=='frm-configuracion-impresora'">
                <frm-configuracion-impresora @cerrarMenu="listadoPrincipal"></frm-configuracion-impresora>
            </template>
            <template v-if="frm=='frm-contrasena'">
                <frm-contrasena @cerrarMenu="listadoPrincipal"></frm-contrasena>
            </template>
            <template v-if="frm=='frm-reportes'">
                <frm-reportes @cerrarMenu="listadoPrincipal"></frm-reportes>
            </template>
        </template>

    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    export default {
        created(){
            this.listarFormularios();
            this.verificarCaja();
            this.verificarCajaMesero();
            this.usuarioAuth();
        },
        data(){
            return {

                formularios: [],
                frm:'',
                nombre_frm:'',
                vista: 0,
                estadoCaja :'',
                estadoCajaMesero :'',
                usuario : {},
                arqueo : 0,
                isLoading: true,
            }
        },

        methods : {
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
            listadoPrincipal(listadoInicial){
                let me=this;
                me.vista = listadoInicial;
                me.verificarCaja();
                me.verificarCajaMesero();
            },
            listarFormularios(){
                let me=this;
                setTimeout(()=> {
                        if(me.formulario== []){
                            me.isLoading=true;
                        }
                        me.isLoading=false;
                    },1000);
                var url='/formulario';
                axios.get(url).then(function(response){
                    me.formularios=response.data;
                })
                .catch(function(error){
                    console.log(error)
                });
            },
            frmFormularios(item){
                if(this.usuario.id_grupo == 1){
                    if(item.frm_formulario == 'frm-tp1-venta' || item.frm_formulario == 'frm-tp1-venta-mesero' || item.frm_formulario == 'frm-compra'|| item.frm_formulario == 'frm-gasto'){
                        if(this.estadoCaja == 'Cerrada')
                        {
                            this.validacionError('Requiere Aperturar Caja!',3000);

                        }else{
                            setTimeout(()=> {
                            this.frm = item.frm_formulario;
                            this.nombre_frm = item.nombre;
                            this.vista=1;
                            },200);
                        }
                    }else{
                        setTimeout(()=> {
                            this.frm = item.frm_formulario;
                            this.nombre_frm = item.nombre;
                            this.vista=1;
                            },200);
                    }

                }else
                {
                    if(item.frm_formulario == 'frm-tp1-venta-mesero')
                    {
                        if(this.estadoCajaMesero == 'Cerrada')
                            {
                                this.validacionError('Requiere Aperturar Caja!',3000);

                            }else{
                                setTimeout(()=> {
                                this.frm = item.frm_formulario;
                                this.nombre_frm = item.nombre;
                                this.vista=1;
                                },200);
                        }
                    }else{
                        setTimeout(()=> {
                            this.frm = item.frm_formulario;
                            this.nombre_frm = item.nombre;
                            this.vista=1;
                            },200);
                    }
                }
            },
            verificarCaja(){
                let me = this;
                var url='/arqueo_caja/estado_caja';
                axios.get(url).then(function(response){
                    me.estadoCaja = response.data.estado;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            verificarCajaMesero(){
                let me = this;
                var url='/arqueo_caja/estado_caja/mesero';
                axios.get(url).then(function(response){
                    me.estadoCajaMesero = response.data.estado;
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

        },
        // mounted() {
        //     this.verificarCaja();
        //     this.verificarCajaMesero();
        //     this.usuarioAuth();
        // }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }

    .footer{
        position:relative !important;
        width: auto !important;
    }

    .redes-container{
        display: flex;
        height: 100vh;
        align-items: center;
        justify-content: center;
    }

    .redes-container ul li{
        display: inline-block;
        margin: 0 5px;
        width: 50px;
        height: 50px;
        text-align: center;
    }

    .redes-container ul li a{
        display: block;
        padding: 0 10px;
        background: #333;
        color: #fff;
        line-height: 50px;
        font-size: 18 px;
        box-shadow: 0 3px 5px 0px rgba(0, 0, 0, .2);
        transition: .2s
    }

    .img-container button:hover a{
        filter: blur(2px);
    }

    .img-container button:hover, .img-container button:focus, .img-container button:active {
        transform: translateY(-3px) scale(1.20);
        box-shadow: 0 5px 5px 0px rgba(0, 0, 0, .4);
        filter: none;
        background: #ff6700;
    }


</style>
