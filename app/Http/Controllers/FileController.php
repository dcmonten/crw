<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;

use App\Imports\ReporteImport;

class FileController extends Controller
{
    /**Retorno de la vista */
    public function fileView(){
        return view('file');
    }

    /**Subida y manejo del archivo */
    public function uploadFile(Request $request){
        // $request->validate([
        //     'fileToUpload' => 'required|mimes:xlsx',
        // ]);

        $collection = Excel::toCollection(new ReporteImport, request()->file('fileToUpload'));
        return $collection;

    }
}

