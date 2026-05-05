<!doctype html>
<html>

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parqueo Cañoto </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('css/plantilla.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #siat-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #siat-menu ul li {}

        #siat-menu ul li a {
            display: block;
            text-decoration: none;
            padding: 4px 6px;
        }

        #siat-menu ul li a:hover {
            background: #ececec;
        }

    </style>
</head>

<body>
    <div id="app">
        @includeIf('Siat::menu.siat')

        <div class="wrapper d-flex flex-column min-vh-100">

            <header class="header header-sticky mb-12">
                <div class="container-fluid">

                    <button class="header-toggler px-md-0 me-md-3" type="button"
                        onclick="coreui.Sidebar.getInstance(document.querySelector(&#39;#sidebar&#39;)).toggle()">
                        <i class="fa fa-list"></i><svg class="icon icon-lg">
                            <use xlink:href="icons/svg/free.svg#cil-menu"></use>
                        </svg>
                    </button>

                    <ul class="header-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#"><svg class="icon icon-lg">
                                    <use xlink:href="icons/svg/free.svg#cil-bell"></use>
                                </svg></a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><svg class="icon icon-lg">
                                    <use xlink:href="icons/svg/free.svg#cil-list-rich"></use>
                                </svg></a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><svg class="icon icon-lg">
                                    <use xlink:href="icons/svg/free.svg#cil-envelope-open"></use>
                                </svg></a></li>
                    </ul>

                    <ul class="header-nav ms-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link py-0 text-center" data-coreui-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false">

                                {{-- @if(file_exists('img/logo/'.$mi_empresa[0]->logo_sistema))
										<div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('img/logo/'.$mi_empresa[0]->logo_usuario) }}"
                                alt="tienda">
                </div>
                @else --}}
                <div class="avatar avatar-md"><img class="avatar-img" src="{{asset('img/logo/logo_usuario.png')}}">
                </div>
                {{-- @endif --}}



                </a>


                <div class="text-center pt-1 text-uppercase text-medium-emphasis small ">{{Auth::user()->name}}</div>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-1 text-uppercase text-center">
                        <strong>{{Auth::user()->name}}</strong>
                    </div>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-lock"></i><svg class="icon me-2">
                            <use xlink:href="icons/svg/free.svg#cil-account-logout"></use>
                        </svg> Salir</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>

                </li>
                </ul>
        </div>

        </header>

        {{-- <h2>Menu</h2> --}}

        <div class="container-fluid" style="background-color: white">
            {{-- @yield('content') --}}



            @yield('content')

        </div>

    </div>
    </div>

    @stack('javascript')
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.2.0/dist/js/coreui.bundle.min.js"
        integrity="sha384-n0qOYeB4ohUPebL1M9qb/hfYkTp4lvnZM6U6phkRofqsMzK29IdkBJPegsyfj/r4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://coreui.io/demo/free/3.4.0/js/main.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</body>

</html>
