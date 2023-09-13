<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Session, Validator, DB, Str;


class PhotoController extends Controller
{
    public function image($fileName){
        $path = public_path().'/assets/upload_images/'.$fileName;
        return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $path));
        // return Response::download($path);
    }
    public function get_all_images()
    {
       $path = public_path().'/assets/upload_images';
        // return Response::download($path);
        return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $path));
    }
}
