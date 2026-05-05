<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar" style="background-color: rgb(20, 20, 20)">

    <div class="sidebar-brand d-none d-md-flex" style="background-color: rgb(20, 20, 20)">

        <img src="{{ asset('img/logo/logo_sistema.png') }}" width=250px>



    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask" style="background-color: rgb(27, 21, 21)">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                        <div class="simplebar-content" style="padding: 0px;">

                            <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.sync') }}">&nbsp;<img
                                        src="{{asset('img/iconos/sincronizacion.png')}}"
                                        style="border: solid 3px #FF5733" class="rounded-circle"
                                        width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sincronización
                                </a>
                            </li>

                            <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.cufds') }}">&nbsp;<img
                                        src="{{asset('img/iconos/clientes.png')}}" style="border: solid 3px #FF5733"
                                        class="rounded-circle" width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CUFDs
                                </a>
                            </li>
                            {{-- <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.branches') }}">&nbsp;<img
                                        src="{{asset('img/iconos/sucursales.png')}}" style="border: solid 3px #FF5733"
                                        class="rounded-circle" width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sucursales
                                </a>
                            </li> --}}
                            <!--<li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.pointofsales') }}">&nbsp;<img
                                        src="{{asset('img/iconos/puntos_de_venta.png')}}"
                                        style="border: solid 3px #FF5733" class="rounded-circle"
                                        width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Puntos de Venta
                                </a>
                            </li>-->
                            @if( $siat_settings->show_customers_menu )
                            <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.clientes') }}">&nbsp;<img
                                        src="{{asset('img/iconos/clientes.png')}}" style="border: solid 3px #FF5733"
                                        class="rounded-circle" width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clientes
                                </a>
                            </li>
                            @endif
                            @if( $siat_settings->show_products_menu )
                            <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.productos') }}">&nbsp;<img
                                        src="{{asset('img/iconos/productos.png')}}" style="border: solid 3px #FF5733"
                                        class="rounded-circle" width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Listado
                                    Productos
                                </a>
                            </li>
                            @endif

                            <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.eventos') }}">&nbsp;<img
                                        src="{{asset('img/iconos/eventos.png')}}" style="border: solid 3px #FF5733"
                                        class="rounded-circle" width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eventos
                                </a>
                            </li>

                            <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.facturas') }}">&nbsp;<img
                                        src="{{asset('img/iconos/facturas.png')}}" style="border: solid 3px #FF5733"
                                        class="rounded-circle" width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Listado de
                                    facturas
                                </a>
                            </li>

                            <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.facturador') }}">&nbsp;<img
                                        src="{{asset('img/iconos/facturador.png')}}" style="border: solid 3px #FF5733"
                                        class="rounded-circle" width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Facturador
                                </a>
                            </li>

                            <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.config') }}">&nbsp;<img
                                        src="{{asset('img/iconos/configuracion.png')}}"
                                        style="border: solid 3px #FF5733" class="rounded-circle"
                                        width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Configuración
                                </a>
                            </li>
                            @if(auth()->user()->rol=='administrador' && auth()->user()->estado==1)
                            <li class="nav-item" style="border: solid 1px #393838">
                                <a class="nav-link" href="{{ route('siat.usuarios') }}">&nbsp;<img
                                        src="{{asset('img/iconos/usuarios.png')}}"
                                        style="border: solid 3px #FF5733" class="rounded-circle"
                                        width=30px>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Usuarios
                                </a>
                            </li>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: 256px; height: 1606px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar simplebar-visible" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar simplebar-visible"
                style="height: 367px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
