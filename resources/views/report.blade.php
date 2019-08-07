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


@section('que_funcione_solo_1_elemento_del_arreglo')
@<?php
  $collection = $colecciones[0]

 ?>
@endsection

@section('nombre_del_profesor')
{{$collection[0][2][0]}}
@endsection


@section('content')

<article class='container'>
  <header>
    <h1 class="text-center">
    Reporte Colaborativo
    <h1>
  </header>

  {{--
    Metadata:
    $collection[X] es el archivo X
    $collection[X][n] es la fila n del archivo X
    $collection[X][n][m] es el dato de la fila n de la columna m del archivo X
    --}}

  <?php
  /*Este arreglo contendrá todos los reportes*/
  $arreglo_de_reportes = array();

  //Foreach que se encargará de guardar todo en su lugar correcto
  foreach ($colecciones as $clave => $collection) {

    //ignorando las dos primeras filas, que contienen los headers
    $aportes = array_slice(json_decode($collection[0], true), 2);

    //seleccionando solamente la última línea
    $version_final = end($aportes);


    //obtener los colaboradores únicos por fuerza bruta
    $colaboradores=array();

    foreach ($aportes as $key=>$value)
    {
      $colaboradores[$key]=$value[0];
    }

    $colaboradores=array_unique($colaboradores);


    //Elimino al primer colabolador, porque es el profesor
    array_shift($colaboradores);


    //ahora, con los colaboradores únicos, se almacena cada aporte por colaborador
    $aportes_individuales=array();

    foreach ($colaboradores as $persona)
    {
      $arreglo_de_aportes=array();
      foreach ($aportes as $value)
      {
        if ($persona==$value[0])
        {
          $arreglo_de_aportes[$value[2]]= strip_tags($value[3]);
        }
      $aportes_individuales[$persona]=$arreglo_de_aportes;
      }
    }

    /*Este arreglo contendrá 2 elementos
    0 - Título del Reporte
    1 - Aportes individuales ($aportes_individuales)
    2 - Colaboradores
    3 - Versión final del reporte ($version_final)
    */
    $reporte = array();

    //Se agregan los elementos al reporte
    array_push($reporte, $collection[0][0][0], $aportes_individuales, $colaboradores, $version_final);

    //Se agrega el reporte a la lista de reportes
    array_push($arreglo_de_reportes, $reporte);

  }//end foreach exterior

  //Ahora se tiene cada usuario como clave de los aportes, y cada fecha como clave del aporte
  ?>

  <section id="seleccion_reportes" class="row">
    @foreach( $arreglo_de_reportes as $numero => $reporte)
      <h5 id={{'titulo'.$numero}}>{{$reporte[0]}}</h5>
    @endforeach
  </section>

<section id="reporte" class="row">
  @foreach( $arreglo_de_reportes as $numero => $reporte)
  <section id={{'pagina'.$numero}}} class="row">

    <!--
    Titulo de la Página: $reporte[0]
    Aportes Individuales: $reporte[1]
    Colaboradores: $reporte[2]
    Versión Final: $reporte[3]
    -->

    <h2 class="col-12 text-center">{{$reporte[0]}}</h2>
    <h3 class="col-12">Colaboradores: </h3>
    <ul class="col-12">
      @forelse( $reporte[2] as $persona )

        <li class="col-12">{{$persona}}</li>

      @empty

        <li class="col-12">No hay colaboradores</li>

      @endforelse
    </ul>

    <div class="col-lg-6 text-center">
      <h3>Última edición por</h3>
      <p>{{$reporte[3][0]}}</p>
    </div>
    <div class="col-lg-6 text-center">
      <h3>Fecha</h3>
      <p>{{$reporte[3][2]}}</p>
    </div>

    <div class="reportes_finales" id="final">{{$reporte[3][4]}}</div>

  </section>

  <section id="aportes">
    <div id="aporte_por_estudiante">

      @foreach( $reporte[1] as $persona=>$contribuciones )

        <h3 class="col-6">{{$persona}}</h3>

        @foreach( $contribuciones as $fecha=>$contribucion )

        <small>{{$fecha}}</small>
        <p>{{$contribucion}}</p>

        @endforeach

      @endforeach

    </div>
  </section>
@endforeach
</section>

<section id="charts">
  <div id="heatmap"></div>
  <div id="barchart"></div>
  <div id="piechart"></div>
</section>

</article>

@endsection
@section('scripts')
<script src="../js/temporal.js" type="text/javascript"></script>
<script src="../js/heatmap.js" type="text/javascript"></script>
<script src="../js/stacked_barchart.js" type="text/javascript"></script>
<script src="../js/pie_chart.js" type="text/javascript"></script>
@endsection
