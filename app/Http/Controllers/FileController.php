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

        $files = $request->file('fileToUpload');

        $arrayFiles = array();

        if (empty($files)){

          return redirect()->route('inicio');

        }

        else {


          foreach($files as $file){
              $collection = Excel::toCollection(new ReporteImport, $file);
              array_push($arrayFiles, $collection);
          }

          return view('report', ['colecciones' => $arrayFiles]);


        }
    }
}
