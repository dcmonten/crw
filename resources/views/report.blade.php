@extends('layouts.layout')
@section('styles')

@endsection

@section('groups')
<li class="nav-item">
  <a class="nav-link" href="#">
    <span data-feather="file-text"></span>
    1. Amigos por el mundo
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="#">
    <span data-feather="file-text"></span>
    2. Amantes del teatro
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="#">
    <span data-feather="file-text"></span>
    3. Recicladores Extremos
  </a>
</li>
@endsection

@section('nombre_del_profesor')
{{$collection[0][2][0]}}
@endsection


@section('content')

<article class='container'>
  <header>
    <h1>
    Reporte Colaborativo
    <h1>
  </header>
  <div>
    {{--
      Metadata:
      $collection[X] es el archivo X
      $collection[X][n] es la fila n del archivo X
      $collection[X][n][m] es el dato de la fila n de la columna m del archivo X
      --}}
    <h3>Título de la página</h3>
    <p>{{$collection[0][0][0]}}<p>
  <div>

  @php

  $aportes = array_slice(json_decode($collection[0], true), 2);
  $version_final = end($aportes);

  @endphp

  <div id="final" class="hidden">{{$version_final[4]}}</div>

  <section>

    <div class="table-responsive">

      <table class="table table-striped table-sm hidden">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Nº Version</th>
            <th>Fecha</th>
            <th>Cambios</th>

          </tr>
        </thead>
        <tbody>

          @foreach( $aportes as $data )

          <tr>
            <td>{{$data[0]}}</td>
            <td>{{$data[1]}}</td>
            <td>{{$data[2]}}</td>
            <td>{{strip_tags($data[3])}}</td>
          </tr>

          @endforeach

        </tbody>
      </table>
    </div>


  </section>
  <section id="pagina" class="row">

    <h1 class="col-12">Reporte Final</h1>

    <div class="col-lg-6">
      <h2>Última edición por</h2>
      <p>{{$version_final[0]}}</p>
    </div>
    <div class="col-lg-6">
      <h2>Fecha</h2>
      <p>{{$version_final[2]}}</p>
    </div>
  </section>

</article>

@endsection
@section('scripts')
<script src="../js/temporal.js" type="text/javascript"></script>
@endsection
