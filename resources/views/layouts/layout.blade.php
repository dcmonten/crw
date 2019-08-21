
<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Plantilla: Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="author" content="Adaptación para reportes colaborativos: Grupo 1 - IHC - ESPOL">
    <meta name="generator" content="Jekyll v3.8.5">
     <link rel="shortcut icon" href="/icons/test.png" type="image/x-icon">

    <title>Asistente de Reportes Colaborativos</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="../css/layout.css" rel="stylesheet" type="text/css">

    @yield ('styles')
  </head>
  <body>
    @if (!Request::is('/'))

        <nav class="navbar navbar-expand-lg fixed-top">
          <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item mb-0">
                <button class="btn" id="btn-sidebar" type="button">
                  <span data-feather="menu"></span>
                </button><!-- /.navbar-toggler -->
              </li>
            </ul>
              <ul class="navbar-nav mr-auto ml-auto">
                <li class= "nav-item mb-0" id="profesor">Análisis de reportes</li>
              </ul><!-- /.navbar-nav .mr-auto -->
              <ul class="navbar-nav ml-auto d-flex align-items-center justify-content-center">
        		    <li class="nav-item mb-0">@yield('dd_paginas')</li>
            </ul><!-- /.navbar-nav .ml-auto -->

          </div> <!-- /#navbarSupportedContent -->
        </div><!-- /.container -->
      </nav><!-- /.navbar-laravel -->
      @endif

  <div class="container-fluid">
    <div class="row">
@if (!Request::is('/'))
      <nav class="col-md-2 bg-light sidebar" id="sidebar">
        <div class="sidebar-sticky">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            Actividades
          </h6>
          <ul class="nav flex-column">
              <li class="nav-item">
              <a class="nav-link" href="#charts">
                <span data-feather="users"></span>
                Ver reporte final del grupo
              </a>
            </li>
          </ul>

          @yield('pages')

        </div>
      </nav>


      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 top-p40">
      @yield('content')
      </main>

        @else
        <main role="main" class="ml-sm-auto col-lg-12 px-4 top-p40">
        @yield('content')
        </main>
        @endif


    </div>
  </div>

<div>
  @yield('test')
</div>

  <script
  			  src="https://code.jquery.com/jquery-3.4.1.js"
  			  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  			  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.8.3/apexcharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/6.1.0/math.js"></script>
    <script src="../js/dashboard.js" type="text/javascript"></script>

    @yield('scripts')
  </body>
</html>
