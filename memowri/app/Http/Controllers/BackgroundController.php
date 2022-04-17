<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Background;
use App\Models\Color;
use App\Models\Cursor;
use App\Models\Image;

use Illuminate\Support\Facades\Storage;

use Illuminate\Database\QueryException;

class BackgroundController extends Controller
{
    public function edit(){
        if(!session()->has('user'))
            return redirect('/');

        try{
            $background=Background::select('id')
                                    ->join('users', 'backgrounds.id_user', '=', 'users.username')
                                    ->where('users.username', '=', session()->get('user'))
                                    ->get()->first();

            $background->image=Image::select('images.name', 'images.route', 'images.extension', 'images.type', 'images.opacity')
                                ->join('backgrounds', 'backgrounds.id_image', '=', 'images.id')
                                ->where('backgrounds.id', '=', $background->id)
                                ->get()->first();

            $background->color=Color::select('colors.id', 'colors.hex_code')
                        ->join('backgrounds', 'colors.id', '=', 'backgrounds.id_color')
                        ->join('users', 'backgrounds.id_user', '=', 'users.username')
                        ->where('users.username', '=', session()->get('user'))
                        ->get()->first();

            $background->cursor=Cursor::select('cursors.color_x', 'cursors.color_y', 'cursors.gradient_x', 'cursors.gradient_y')
                            ->join('colors', 'cursors.id_color', '=', 'colors.id')
                            ->join('backgrounds', 'colors.id', '=', 'backgrounds.id_color')
                            ->where('backgrounds.id', '=', $background->id)
                            ->get()->first();

            $hex      = $background->color->hex_code;
            $length   = strlen($hex);
            $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
            $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
            $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

            $background->color->rgb=$rgb;

            return view('background', compact('background'));
        }
        catch(QueryException $ex){
            abort(500, "Error ". $ex->getCode() . ": " . "Error in database connection. Try again later");
        }
        catch(\Exception $ex){
            abort(500, "Error ". $ex->getCode() . ": Try again later");
        }
    }

    public function update(Request $request){

        $request->gradient_cursor=json_decode($request->gradient_cursor);
        $request->color_cursor=json_decode($request->color_cursor);

        $request->validate([
            'background_color' => array('bail', 'required', 'min:3', 'max:6', 'regex:/^(?:[0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/'),
            'opacity' => 'sometimes|nullable|numeric|between:0.0,1.0',
            'gradient_cursor.*' => 'bail|required|numeric|between:0.0,1.0',
            'color_cursor.*' => 'bail|required|numeric|between:0.0,1.0',
            'is_image_loaded' => 'required|boolean',
            'image_data' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,bmp|max:16000'

        ]);

        try{
            $background=Background::select("backgrounds.id", "backgrounds.id_image")
                                    ->join('users', 'backgrounds.id_user', '=', 'users.username')
                                    ->where('users.username', '=', session()->get('user'))
                                    ->get()->first();

            $color=Color::select("colors.id", "colors.hex_code")
                        ->join('backgrounds', 'colors.id', '=', 'backgrounds.id_color')
                        ->where('backgrounds.id', '=', $background->id)
                        ->get()->first();

            $cursor=Cursor::select("cursors.id", "cursors.color_x", "cursors.color_y", "cursors.gradient_x", "cursors.gradient_y")
                            ->join('colors', 'cursors.id_color', '=', 'colors.id')
                            ->where('colors.id', '=', $color->id)
                            ->get()->first();

            $image=NULL;

            if($background->id_image!=NULL){
                $image=Image::select("images.id", "images.name", 'images.route', 'images.extension', 'images.type', 'images.opacity')
                        ->join('backgrounds', 'images.id', '=', 'backgrounds.id_image')
                        ->where('backgrounds.id', '=', $background->id)
                        ->get()->first();
            }

            $color->hex_code=$request->background_color;
            $color->save();

            $cursor->color_x=$request->color_cursor->x;
            $cursor->color_y=$request->color_cursor->y;
            $cursor->gradient_x=$request->gradient_cursor->x;
            $cursor->gradient_y=$request->gradient_cursor->y;
            $cursor->save();

            if($request->image_data!=NULL)
            {
                if($background->id_image!=NULL){
                    Storage::disk('private')->delete($image->route);

                    $background->id_image=NULL;
                    $background->save();
                    $image->delete();
                }

                $newImage=new Image();

                $newImage->extension=$request->file('image_data')->getClientOriginalExtension();
                $newImage->name=time().".".$newImage->extension;

                $newImage->route="backgrounds/".$newImage->name;

                Storage::disk("private")->putFileAs('backgrounds', $request->file('image_data'), $newImage->name);

                $newImage->type=$request->file('image_data')->getClientMimeType();
                $newImage->opacity=$request->opacity;
                $newImage->save();

                $background->id_image=$newImage->id;
                $background->save();
            }
            else if($background->id_image!=NULL){

                if(!$request->is_image_loaded){
                    Storage::disk('private')->delete($image->route);

                    $background->id_image=NULL;
                    $background->save();
                    $image->delete();
                }
                else{
                    $image->opacity=$request->opacity;
                    $image->save();
                }
            }

            return response()->json(['status' => "success",
                                    'message'=> "Background updated successfully"],
                                     200);
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
