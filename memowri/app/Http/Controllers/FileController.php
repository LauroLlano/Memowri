<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Image;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class FileController extends Controller
{
    public function images($filename){

        if(!session()->has('user'))
            return redirect('/');

        $path="backgrounds/{$filename}";
        $filepath = Storage::disk("private")->path($path);

        if (!Storage::disk("private")->exists($path))
            abort(404);

        try{
            if(!Image::join('backgrounds', 'images.id', 'backgrounds.id_image')
                ->join('users', 'backgrounds.id_user', '=', 'users.username')
                ->where('users.username', '=', session()->get('user'))
                ->where('images.name', '=', $filename)
                ->exists()
                )
                    abort(401);

                return response()->file($filepath);
        }
        catch(QueryException $ex){
            return response()->json(['status' => "error",
                                    'message'=> "Error ". $ex->getCode() . ": " . "Error in database connection. Try again later"],
                                     500);
        }
        catch(\Exception $ex){
            return response()->json(['status' => "error",
                                'message'=> "Error ". $ex->getCode() . ": Try again later"],
                                500);
        }

    }
}
