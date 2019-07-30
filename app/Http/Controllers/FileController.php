<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    /**Retorno de la vita */
    public function fileView(){
        return view('file');
    }

    /**Subida y manejo del archivo */
    public function uploadFile(Request $request){
        // $request->validate([
        //     'fileToUpload' => 'required|file|max:1024',
        // ]);
        
        $fileName = "fileName".time().'.'.request()->fileToUpload->getClientOriginalExtension();
        $request->fileToUpload->storeAs('prueba', $fileName);

        return back()
            ->with('Exitoso','Se ha guardado el archivo.');

        
    }
}

