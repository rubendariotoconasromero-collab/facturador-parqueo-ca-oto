<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Central - Inicio de Sesion</title>
    <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="theme-color" content="#ffffff">
    <link href="css/plantilla.css" rel="stylesheet">
  </head>
  <body>
    <!-- <div class="bg-light min-vh-100 d-flex flex-row align-items-center"> -->
    <div class="min-vh-100 d-flex flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card-group d-block d-md-flex row">
              <div class="card col-md-7 p-4 mb-0">
                <div class="card-body">
                  <form role="form" method="POST" action="{{ route('usuario') }}">
                    @csrf
                    <h1>INICIO DE SESION</h1>
                    <p class="text-medium-emphasis">Ingrese sus Datos</p>
                    <div class="mb-3">
                      <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Usuario') }}" type="name" name="name" value="{{ old('name') }}" required autofocus>
                      </div>
                      @error('name')
                      <div class="text-danger">
                         {{$message}} 
                      </div>
                      @enderror
                    </div>
                    <div class="mb-4">
                      <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Contraseña') }}" type="password" required>
                      </div>
                      @error('password')
                      <div class="text-danger">
                         {{$message}} 
                      </div>
                      @enderror
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <button class="btn btn-success text-white px-4" type="submit">ACCEDER</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="card col-md-5 text-white bg-success py-5">
                <div class="card-body text-center">
                  <div>
                    <img src="img/sitnorte-centralcell.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="js/plantilla.js"></script>
  </body>
</html>

<style>

body{
    margin: 0;
    padding: 0;
    background: url("img/sitnorte-centralcellscz.png");   
    background-size: 100% 100%;
    background-position: center;
    font-family: sans-serif;
    background-attachment: relative;
}
</style>