@extends('layouts.layout')
@section('styles')
<link href="../css/reporte.css" rel="stylesheet" type="text/css">
@endsection

@php


$collection = $colecciones[0];

/*Este arreglo contendrá todos los reportes*/
$arreglo_de_reportes = array();
$mapa_aporte = array();

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
  $aportes_en_cifras=array();

  foreach ($colaboradores as $persona)
  {
    $arreglo_de_aportes=array();
    $num_palabras_mas=0;
    $num_palabras_menos=0;
    $num_img_mas=0;
    $num_img_menos=0;

    foreach ($aportes as $value)
    {
      if ($persona==$value[0])
      {
        $arreglo_de_aportes[$value[2]]= $value[3];//fecha: aporte

        $out_mas_palabras=array();
        $out_menos_palabras=array();
        $out_mas_tag = array();
        $out_menos_tag = array();

        //Condicional para obtener [+] y buscar img
        if (preg_match_all("/\[\+\]([^\[]*)*/", $value[3], $out_mas_tag))
        {
          foreach ($out_mas_tag[0] as $aporte_tag)
          {
            $out_img = array();
            if (preg_match_all("/<img[^>]* src=\"([^\"]*)\"[^>]*>/", $aporte_tag, $out_img)){
              foreach ($out_img[0] as $img_tag){
                //@dump($img_tag); -> Para ver que imprime
                $num_img_mas=$num_img_mas+1;
              }
            }
          }
        };

        //Condicional para obtener [-] y buscar img
        if (preg_match_all("/\[\-\]([^\[]*)*/", $value[3], $out_menos_tag))
        {
          foreach ($out_menos_tag[0] as $aporte_tag)
          {
            $out_img = array();
            if (preg_match_all("/<img[^>]* src=\"([^\"]*)\"[^>]*>/", $aporte_tag, $out_img)){
              foreach ($out_img[0] as $img_tag){
                //@dump($img_tag); -> Para ver que imprime
                $num_img_menos=$num_img_menos+1;
              }
            }
          }
        };

        //Condicional para obtener [+] y contar palabras
        if (preg_match_all("/\[\+\](?!  style)([^\[]*)*/", strip_tags($value[3]), $out_mas_palabras))
        {
          foreach ($out_mas_palabras[0] as $aporte_sin_estilos_mas)
          {
            //@dump($aporte_sin_estilos_mas); -> Para ver que imprime
            //Conteo de palabras anadidas
            $num_palabras_mas=$num_palabras_mas+str_word_count($aporte_sin_estilos_mas);
          }
        };

        //Condicional para obtener [-] y contar palabras
        if (preg_match_all("/\[\-\](?!  style)([^\[]*)*/", strip_tags($value[3]), $out_menos_palabras))
        {
          foreach ($out_menos_palabras[0] as $aporte_sin_estilos_menos)
          {
            //@dump($aporte_sin_estilos_menos); -> Para ver que imprime
            //Conteo de palabras eliminadas
            $num_palabras_menos=$num_palabras_menos+str_word_count($aporte_sin_estilos_menos);
          }
        };
      }
      $aportes_individuales[$persona]=$arreglo_de_aportes;
    }

    $array_conteo_palabras = array(
    "palabras_mas" => $num_palabras_mas,
    "palabras_menos" => $num_palabras_menos,
    "img_mas" => $num_img_mas,
    "img_menos" => $num_img_menos
    );
    $aportes_en_cifras[$persona]=$array_conteo_palabras;
  }

  /*Este arreglo contendrá estos elementos:
  0 - Título del Reporte
  1 - Aportes individuales ($aportes_individuales)
  2 - Colaboradores
  3 - Versión final del reporte ($version_final)
  4 - Aportes Individuales, en cifras
  */
  $reporte = array();

  //Se agregan los elementos al reporte
  array_push($reporte, $collection[0][0][0], $aportes_individuales, $colaboradores, $version_final, $aportes_en_cifras);

  //Se agrega el reporte a la lista de reportes
  array_push($arreglo_de_reportes, $reporte);

  /*Aquí se crea un arreglo de mapas los cuales contienen:
  Clave = Nombre del colaborador
  Valor = Arreglo de palabras agregadas
  */
  array_shift($aportes);

  foreach($colaboradores as $colaborador){
    //Arreglo para las palabras agregadas por cada estudiante
    $arreglo_de_palabras_agregadas = array();

    /*Mapa que contiene:
    [0] - Nombre del estudiante
    [1] - Arreglo de palabras agregadas (vacío por ahora)
    */
    $mapa_aporte[$clave][$colaborador] = $arreglo_de_palabras_agregadas;
  }

  foreach($aportes as $value){
    $out_menos_palabras = array();
    $out_mas_palabras = array();

    if ( preg_match_all("/\[\-\](?!  style)([^\[]*)*/", strip_tags($value[3]), $out_menos_palabras) )
    {

      foreach ($out_menos_palabras[0] as $aporte_sin_estilos_menos)
      {
        //Quitar los [-] y los \n
        $aporte_sin_estilos_menos = str_replace('[-]', '', $aporte_sin_estilos_menos);
        $aporte_sin_estilos_menos = trim(preg_replace('/\s\s+/', '', $aporte_sin_estilos_menos));
        $lista_palabras_eliminadas = preg_split('/[\n]/', $aporte_sin_estilos_menos);


        //Eliminar de las listas de todos los colaboradores
        foreach($mapa_aporte[$clave] as $colaborador=>$palabras){

          foreach ($lista_palabras_eliminadas as $palabra_a_eliminar){

            $key = array_search($palabra_a_eliminar, $palabras);
            if ($key !== false) {

              unset($palabras[$key]);

              $mapa_aporte[$clave][$colaborador] = $palabras;
            }
          }
        }
      }
    };

    //Condicional para obtener [+]
    if (preg_match_all("/\[\+\](?!  style)([^\[]*)*/", strip_tags($value[3]), $out_mas_palabras))
    {
      //@dump($value[0]);
      foreach ($out_mas_palabras[0] as $aporte_sin_estilos_mas)
      {
        //@dump($aporte_sin_estilos_mas);
        $aporte_sin_estilos_mas = str_replace('[+]', '', $aporte_sin_estilos_mas);
        //@dump($aporte_sin_estilos_mas);
        $aporte_sin_estilos_mas = trim(preg_replace('/\s\s+/', PHP_EOL, $aporte_sin_estilos_mas));
        //@dump($aporte_sin_estilos_mas);

        $lista_palabras_agregadas = preg_split('/[\n]/', $aporte_sin_estilos_mas);

        //@dump($aporte_sin_estilos_mas);
        //@dump($lista_palabras_agregadas);

        //Agregar a la lista
        foreach($lista_palabras_agregadas as $palabra){
          if( !empty($palabra) ){
            if( empty($mapa_aporte[$clave][$value[0]]) )
              $mapa_aporte[$clave][$value[0]] = array();
            array_push($mapa_aporte[$clave][$value[0]], $palabra);
          }
        }
       }
    }
  }


}//end foreach exterior

/*
Para revisar el contenido de la lista oculta

foreach($mapa_aporte[$clave] as $colaborador=>$palabras){
 @dump($colaborador);
 @dump($palabras);
}
*/
//Ahora se tiene cada usuario como clave de los aportes, y cada fecha como clave del aporte

@endphp



@section('pages')
<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
  <span>Páginas wiki</span>

  <a class="btn d-flex align-items-center" href="/">
    <span data-feather="x-circle"></span>
  </a>

</h6>
<ul class="nav flex-column mb-2">
  @foreach( $arreglo_de_reportes as $numero => $reporte)
  <li class="nav-item">
    <a class="nav-link pag-link" id={{'titulo'.$numero}} href="#">
      <span data-feather="file"></span>
      {{$reporte[0]}}
    </a>
  </li>
  @endforeach
</ul>
@endsection



@section('content')

<div class="d-none" id="aportaciones_de_palabras">
  @foreach($colecciones as $clave => $collection)

    <div id={{'aportaciones_del_reporte_'.$clave}}>
    @if(!empty($mapa_aporte[$clave]))
        @foreach($mapa_aporte[$clave] as $estudiante => $arreglo_palabras)
          @php
            $nombre_sin_espacios = str_replace(' ', '', $estudiante);
          @endphp
          <div id={{$nombre_sin_espacios."_".$clave}} class="estudiante_palabras">
            @foreach($arreglo_palabras as $key => $palabra)
            <div id={{$nombre_sin_espacios."_".$clave."_".$key}}>
              {{$palabra}}
            </div>
            @endforeach
          </div>
        @endforeach
    @endif
    </div>

  @endforeach
</div>

<article class='container dis-60' id="pag-container">

  @php
  $map_added = new ArrayObject();
  $map_deleted = new ArrayObject();
  $map_adim = new ArrayObject();
  $map_delim=new ArrayObject();
  $map_ids = new ArrayObject();
  $map_dates = new ArrayObject();
  $map_dates_per_people = new ArrayObject();

  @endphp
  <section id={{'reporte'.$numero}} class="row">
    @foreach( $arreglo_de_reportes as $numero => $reporte)
    <section id={{'pagina'.$numero}} class="row">

      {{--
        Titulo de la Página: $reporte[0]
        Aportes Individuales: $reporte[1]
        Colaboradores: $reporte[2]
        Versión Final: $reporte[3]
        Aportes individuales en cifras: $reporte[4]
        --}}
        @php
        $temp_palabras_agregadas = 0;
        $temp_palabras_eliminadas = 0;
        $temp_imagenes_agregadas = 0;
        $temp_imagenes_eliminadas = 0;
        @endphp
        <h2 class="col-12 text-center">{{$reporte[0]}}</h2> </span>
        <h3 class="col-12">Colaboradores: </h3>
          @forelse( $reporte[2] as $key=>$persona )

          @php
          $temp_palabras_agregadas = $temp_palabras_agregadas + $reporte[4][$persona]["palabras_mas"];
          $temp_palabras_eliminadas = $temp_palabras_eliminadas + $reporte[4][$persona]["palabras_menos"];
          $temp_imagenes_agregadas = $temp_imagenes_agregadas + $reporte[4][$persona]["img_mas"];
          $temp_imagenes_eliminadas = $temp_imagenes_eliminadas + $reporte[4][$persona]["img_menos"];

          if (array_key_exists ( $persona , $map_added )){

            $map_added[$persona] = $map_added[$persona]+$reporte[4][$persona]["palabras_mas"];
            $map_deleted[$persona] = $map_deleted[$persona]+$reporte[4][$persona]["palabras_menos"];
            $map_adim[$persona] = $map_adim[$persona]+$reporte[4][$persona]["img_mas"];
            $map_delim[$persona] = $map_delim[$persona]+$reporte[4][$persona]["img_menos"];


          }else{
            $map_ids[$persona] = $key;
            $map_added[$persona] = $reporte[4][$persona]["palabras_mas"];
            $map_deleted[$persona] = $reporte[4][$persona]["palabras_menos"];
            $map_adim[$persona] = $reporte[4][$persona]["img_mas"];
            $map_delim[$persona] = $reporte[4][$persona]["img_menos"];
          }

          @endphp
          @empty
          @endforelse
          @php
          $total_grupal= $temp_palabras_agregadas + $temp_palabras_eliminadas + $temp_imagenes_agregadas + $temp_imagenes_eliminadas
          @endphp
        <div class="col-12 row  d-flex flex-wrap justify-content-center align-items-between">
          @forelse( $reporte[2] as $key=>$persona )
          @php
          $temp_added= $reporte[4][$persona]["palabras_mas"] + $reporte[4][$persona]["img_mas"];
          $temp_del= $reporte[4][$persona]["palabras_menos"] + $reporte[4][$persona]["img_menos"];
          $total_pe=$temp_added+$temp_del;
          $porc_pe=$total_pe/$total_grupal;
          @endphp


          <div class="col-md-3 d-flex flex-wrap justify-content-center">
            <div class="card mb-4 shadow-sm d-flex flex-wrap justify-content-center">
              <div id={{'cuadroDeAporte'.$key}} class="card-body text-center d-flex flex-wrap justify-content-center">
                <p id={{'nombre_'.$numero.'_'.$key}} class="card-text">{{$persona}}</p>
                <p class="porcentajes"> {{round($porc_pe*100,2,PHP_ROUND_HALF_ODD)}} %</p>
                <div>
                  <small id={{'anadio'.$key}}>Añadió {{$reporte[4][$persona]["palabras_mas"]}} palabras y {{$reporte[4][$persona]["img_mas"]}} imágenes</small>
                </div>
                <br>
                <div>
                  <small id={{'elimino'.$key}}>Corrigió {{$reporte[4][$persona]["palabras_menos"]}} palabras y {{$reporte[4][$persona]["img_menos"]}} imágenes</small>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                  <div class="btn-group">
                    <button id={{'resaltar_'.$numero.'_'.$key}} class="btn btn-success ml-12">
                      Resaltar aporte
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @empty
          <p class="col-12">No hay contribuciones en esta página</p>
          @endforelse
          <div class="col-12">
            <p id="p-a">Palabras añadidas (total): {{$temp_palabras_agregadas}}</p>
            <p id="p-e">Palabras corregidas o eliminadas(total): {{$temp_palabras_eliminadas}}</p>
            <p id="i-a">Imagenes añadidas (total): {{$temp_imagenes_agregadas}}</p>
            <p id="i-e">Imagenes corregidas o eliminadas (total): {{$temp_imagenes_eliminadas}}</p>
          </div>
        </div>

        <div class="col-12 row">
          <div class="col-lg-6 text-center">
            <h3>Última edición por</h3>
            <p>{{$reporte[3][0]}}</p>
          </div>
          <div class="col-lg-6 text-center">
            <h3>Fecha</h3>
            <p>{{$reporte[3][2]}}</p>
          </div>
        </div>

        {{--
          Este div de acá abajo es donde se encuentra la versión final de la página wiki
          --}}
          <div class="reportes_finales" id={{'final'.$numero}}>{{$reporte[3][4]}}</div>

        </section>


        <section id={{'aporte'.$numero}}>
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#aporte_por_estudiante" aria-expanded="false" aria-controls="#aporte_por_estudiante">
              Mostrar aportes en cuadricula
          </button>
          <div id="aporte_por_estudiante" class="collape">
            <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Miembro del grupo
            </button>

            <div class="dropdown-menu">
              @foreach( array_keys($reporte[1]) as $persona)
              <a class="dropdown-item" href={{"#contribucion".str_replace(' ', '', $persona).str_replace(' ', '', $reporte[0])}}>{{$persona}}</a>
              @endforeach
            </div>

          </div>
          @foreach( $reporte[1] as $persona=>$contribuciones )
          <div class="dis-60" id={{"contribucion".str_replace(' ', '', $persona).str_replace(' ', '', $reporte[0])}}>
            <hr/>
          </div>
          <div class="dis-60">
            <h3 class="col-6">{{$persona}}</h3>
            @php
            //array_push();
            array_keys($contribuciones);
            @endphp

            <ul class="timeline">
            @foreach(array_keys($contribuciones) as $fecha)
              <li><a class= "col-6" href={{"#".str_replace(' ', '', $fecha)}}>{{$fecha}}</a></li>
            @endforeach
            </ul>
            @foreach( $contribuciones as $fecha=>$contribucion )

            @php

            $fechahora=explode(",", $fecha);
            $fecha_ex=$fechahora[0];

            if (array_key_exists ( $fecha_ex , $map_dates ))
            {
              $map_dates[$fecha_ex]=$map_dates[$fecha_ex]+1;

            }
            else
            {
              $map_dates[$fecha_ex]=1;

            }

            $contribucion_sin_tags_de_estilo=preg_replace('/style="([^"]*)"/',NULL,$contribucion);

            $contribucion_positiva = preg_split('/\[\+\]/', preg_replace('/\[\+\]/','[+]<div class="col-6-lg added_content"><h4 class="after">Contenido añadido: </h4>', $contribucion_sin_tags_de_estilo));

              $contribuciones_divididas = array();

              foreach ($contribucion_positiva as $extracto):

                $contrib = array(preg_replace('/\[-\]/', '</div><hr/><h4 class="before">Contenido corregido o eliminado: </h4>', $extracto));

                array_push($contribuciones_divididas, ...$contrib);

              endforeach;

              @endphp
              <div id={{str_replace(' ', '', $fecha)}}>
              <hr/>
              </div>
              <div class="row dis-60">
                <h3 class="col-lg-12">Fecha de publicación: {{$fecha}}</h3>
                @foreach(array_filter($contribuciones_divididas) as $key=>$cont)
                <div class="col-lg-6 card medium-par toHTML">{{$cont}}</div>
                @endforeach

              </div>
              @endforeach
            </div>
              @endforeach

            </div>
          </section>
          @endforeach
        </section>

      </article>
      <div class="dis-60" id="charts">
        <hr/>
      </div>

      <section>
        <h1 class="text-center">Reporte Final del Grupo</h1>
        <div class="d-none final_maps">
          @foreach ($map_added as $persona => $palabras_agregadas)
          <div class="map" id={{'estudiante'.$map_ids[$persona]}}>
            <h4 id={{'nom'.$map_ids[$persona]}}>{{$persona}}</h4>
              <p id={{'pal_mas'.$map_ids[$persona]}}>{{$palabras_agregadas}}</p>
              <p id={{'pal_menos'.$map_ids[$persona]}}>{{$map_deleted[$persona]}}</p>
              <p id={{'im_mas'.$map_ids[$persona]}}>{{$map_adim[$persona]}}</p>
              <p id={{'im_menos'.$map_ids[$persona]}}>{{$map_delim[$persona]}}</p>

          </div>
          @endforeach
        </div>
        <div class="dis-60">
          <h2 class="text-center">Detalle de aportes individuales</h2>
          <div class="dis-60" id="barchart"></div>
        </div>
        <div class="dis-60">
          <h2 class="text-center">Detalle de aportes grupales</h2>
          <div class="dis-60" id="piechart"></div>
        </div>
        <div class="dis-60">
          <h2 class="text-center">Frecuencia de las contribuciones como grupo</h2>
          <p>La frecuencia de contribuciones indica la cantidad de "guardados" de contenido que se hicieron en una fecha determinada.</p>
        </div>
@php
$qts=array();
@endphp
        <div class="d-none" id="info">
          @foreach ($map_dates as $date => $contribs)
          <p class="date" id={{"date".$date}}>{{$date}}</p>
          <p class= "qt">
            {{$contribs}}
          </p>
          @php
          if ($contribs!=null)array_push($qts, $contribs);

          @endphp
          @endforeach
          <p id="min_val">{{min(array_values($qts))}}</p>
          <p id="max_val">{{max(array_values($qts))}}</p>
          <p id="qts_array">{{json_encode($qts)}}</p>
        </div>

        <div class="dis-60" id="heatmap"></div>
      </section>


      @endsection

      @section('scripts')
      <script src="../js/jquery.mark.min.js" type="text/javascript"></script>
      <script src="../js/cargaReportes.js" type="text/javascript"></script>
      <script src="../js/heatmap.js" type="text/javascript"></script>
      <script src="../js/stacked_barchart.js" type="text/javascript"></script>
      <script src="../js/pie_chart.js" type="text/javascript"></script>
      @endsection
