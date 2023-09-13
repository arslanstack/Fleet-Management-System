<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\FineType;
use Session, Validator, DB, Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;


class PhotoController extends Controller
{
    public function image($fileName){
        $path = public_path().'assets/upload_images/'.$fileName;
        return Response::download($path);
    }
}
