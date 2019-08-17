@extends('layouts.layout')
@section('styles')
    <link href="../css/reporte.css" rel="stylesheet" type="text/css">
@endsection

{{--que_funcione_solo_1_elemento_del_arreglo--}}
  @php
  $collection = $colecciones[0]
 @endphp


   {{--
     Metadata:
     $collection[X] es el archivo X
     $collection[X][n] es la fila n del archivo X
     $collection[X][n][m] es el dato de la fila n de la columna m del archivo X
     --}}

   @php
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
            $arreglo_de_aportes[$value[2]]= strip_tags($value[3]);//fecha: aporte

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

   }//end foreach exterior

   //Ahora se tiene cada usuario como clave de los aportes, y cada fecha como clave del aporte
   @endphp
@section('test')


@endsection
@section('pages')
   <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
     <span>Páginas wiki</span>

     <button type="button" class="btn d-flex align-items-center">
       <span data-feather="plus-circle"></span>
     </button>

   </h6>
   <ul class="nav flex-column mb-2">
      @foreach( $arreglo_de_reportes as $numero => $reporte)
       <li class="nav-item">
         <a class="nav-link" id={{'titulo'.$numero}} href="#">
           <span data-feather="file"></span>
             {{$reporte[0]}}
         </a>
       </li>
      @endforeach
   </ul>

@endsection
@section('content')

<article class='container'>


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

    <h2 class="col-12 text-center">{{$reporte[0]}}</h2> </span>
    <h3 class="col-12">Colaboradores: </h3>
    <div class="col-12 row">
      @forelse( $reporte[2] as $persona )

        <div class="col-md-3 d-flex flex-wrap justify-content-center">
         <div class="card mb-4 shadow-sm">
           <div class="card-body text-center">
             <p class="card-text">{{$persona}}</p>
             <p class="card-text">%%%%</p>
             <div style="background: #2d8e2d">
              <small style="color: white">Añadió {{$reporte[4][$persona]["palabras_mas"]}} palabras y {{$reporte[4][$persona]["img_mas"]}} imágenes</small>
             </div>
             <br>
             <div style="background: #e44242">
              <small style="color: white">Eliminó {{$reporte[4][$persona]["palabras_menos"]}} palabras y {{$reporte[4][$persona]["img_menos"]}} imágenes</small>
             </div>
             <br>
             <div class="d-flex justify-content-center">
               <div class="btn-group">
                 <button class="btn btn-info ml-12">
                   Resaltar aporte
                 </button>
               </div>
             </div>
           </div>
         </div>
       </div>

      @empty

        <p class="col-12">No hay colaboradores</p>

      @endforelse
    </div>

    <div class="col-12 row">
    <div class="col-lg-4 text-center">
      <h3>Última edición por</h3>
      <p>{{$reporte[3][0]}}</p>
    </div>
    <div class="col-lg-4 text-center">
      <h3>Fecha</h3>
      <p>{{$reporte[3][2]}}</p>
    </div>
    <div class="col-lg-4 text-center">
      <button class="btn">
          <span data-feather="layers"></span>
        Mostrar el Historial de Versiones
      </button>
    </div>
  </div>
    <div class="reportes_finales" id={{'final'.$numero}}>{{$reporte[3][4]}}</div>

  </section>

  <section id={{'aporte'.$numero}}>
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

<div id="charts">
<hr/>
</div>
<section>
  <h1>Reporte Final del Grupo</h1>

  <h2>Valor porcentual a detalle</h2>
  <div id="barchart"></div>
  <h2>Valor porcentual final</h2>
  <div id="piechart"></div>
  <h2>Frecuencia de las aportaciones como grupo</h2>
  <div id="heatmap"></div>
</section>

</article>

@endsection
@section('scripts')
<script src="../js/cargaReportes.js" type="text/javascript"></script>
<script src="../js/heatmap.js" type="text/javascript"></script>
<script src="../js/stacked_barchart.js" type="text/javascript"></script>
<script src="../js/pie_chart.js" type="text/javascript"></script>
@endsection
