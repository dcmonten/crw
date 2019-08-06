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
  @php
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

//Ahora se tiene cada usuario como clave de los aportes, y cada fecha como clave del aporte

@endphp

  <section id="pagina" class="row">


    <h2 class="col-12 text-center">{{$collection[0][0][0]}}</h2>
    <h3 class="col-12">Colaboradores: </h3>
    <ul class="col-12">
      @forelse( $colaboradores as $persona )

        <li class="col-12">{{$persona}}</li>

      @empty

        <li class="col-12">No hay colaboradores</li>

      @endforelse
    </ul>
    <div class="col-lg-6 text-center">
      <h3>Última edición por</h3>
      <p>{{$version_final[0]}}</p>
    </div>
    <div class="col-lg-6 text-center">
      <h3>Fecha</h3>
      <p>{{$version_final[2]}}</p>
    </div>

    <div id="final">{{$version_final[4]}}</div>

  </section>

  <section id="aportes">
    <div id="aporte_por_estudiante">

      @foreach( $aportes_individuales as $persona=>$contribuciones )

        <h3 class="col-6">{{$persona}}</h3>

        @foreach( $contribuciones as $fecha=>$contribucion )

        <small>{{$fecha}}</small>
        <p>{{$contribucion}}</p>

        @endforeach

      @endforeach

    </div>
  </section>

</article>

@endsection
@section('scripts')
<script src="../js/temporal.js" type="text/javascript"></script>
@endsection
