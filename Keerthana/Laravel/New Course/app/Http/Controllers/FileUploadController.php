<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as HandleFile;
use App\Models\File;

class FileUploadController extends Controller
{
    function index(){
        // $files = Storage::disk('public')->files('/');

// // delete in uploads and db
//         $file = File::find(4);
//         HandleFile::delete(public_path("$file->file_path"));
//         $file->delete();

        $files = File::all();
        return view("fileUpload", ['files'=>$files]);
    }

    function filesubmit(Request $request){
//validation
        $request->validate(
            [ 'file' => 'required|image']
        );
        
        // $file = Storage::disk('local')->put('/', $request->file('file'));

        // $file = $request->file("file")->store('/', 'local');     //--------------->storage\app\private
        // $file = $request->file("file")->store('/', 'public');    //--------------->storage\app\public
        $file = $request->file("file")->store('/', 'real_public');//--------------->public\uploads
        
        // File::create($file); //not working
        $fileStore = new File();
        $fileStore->file_path = '/uploads/'.$file;
        $fileStore->save();
        dd($file);
    }

    // function fileDownload(){
    //     return Storage::disk('public')->download('Ru9zYmKzd9WzwTwyZWN2qjlFBQJtQ16rQoUh3b2P.png');
    // }
}
