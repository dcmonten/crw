@extends('layouts.layout')

@section('content')
    <div class="container">
        <br></br>
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Subida de archivo</div>

                <div class="card-body">
                    @if ($message = Session::get('success'))

                        <div class="alert alert-success alert-block">

                            <button type="button" class="close" data-dismiss="alert">×</button>

                            <strong>{{ $message }}</strong>

                        </div>

                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Oops!</strong> Hubo problemas al subir el archivo.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                        <form action="/upload-file" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" accept=".xlsx" class="form-control-file" name="fileToUpload" id="exampleInputFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">Por favor subir un archivo formato xlsx.</small>
                            </div>
                            <button id="upload-file-btn" type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection
