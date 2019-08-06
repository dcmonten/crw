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

@section('content')
Para subir archivos, haga clic en Paginas Wiki
<section>
  <div id="heatmap"></div>
</section>
@endsection

@section('scripts')

<script src="../js/heatmap.js" type="text/javascript"></script>


@endsection
