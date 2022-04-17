<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

use App\Models\Background;
use App\Models\Color;
use App\Models\Image;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

class EditcategoryController extends Controller
{
    public function edit($id){
        if(!session()->has('user'))
            return redirect('/');

        try{
            if(!Category::join('users', 'categories.id_user', '=', 'users.username')
                ->where('users.username', '=', session()->get('user'))
                ->where('categories.id', '=', $id)
                ->exists()
                )
                    abort(404, "Could not find this resource");

            $category=Category::find($id);

            $background=Background::select('backgrounds.id')
                                ->join('users', 'backgrounds.id_user', '=', 'users.username')
                                ->where('users.username', '=', session()->get('user'))
                                ->get()->first();

            $background->image=Image::select('images.id', 'images.route', 'images.opacity')
                                    ->join('backgrounds', 'images.id', 'backgrounds.id_image')
                                    ->where('backgrounds.id', '=', $background->id)
                                    ->get()->first();

            $background->color=Color::select('colors.id', 'colors.hex_code')
                                    ->join('backgrounds', 'colors.id', '=', 'backgrounds.id_color')
                                    ->where('backgrounds.id', '=', $background->id)
                                    ->get()->first();

            $hex      = $background->color->hex_code;
            $length   = strlen($hex);
            $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
            $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
            $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));


            $background->color->rgb=$rgb;

            return view('editcategory', compact('category', 'background'));
        }
        catch(QueryException $ex){
            abort(500, "Error ". $ex->getCode() . ": " . "Error in database connection. Try again later");
        }
        catch(\Exception $ex){
            abort(500, "Error ". $ex->getCode() . ": Try again later");
        }
    }

    public function update($id, Request $request){

        if(!session()->has('user'))
            return response()->json(['status' => "error",
                                'message'=> "Session has expired. Please try reloading the page."],
                                 200);

        $request->validate([
            'name' => 'bail|required|max:30'
        ]);

        try{

            if(!Category::join('users', 'categories.id_user', '=', 'users.username')
                ->where('users.username', '=', session()->get('user'))
                ->where('categories.id', '=', $id)
                ->exists()
                )
                    return response()->json(['status' => "error",
                                    'message'=> "Category does not match with current user. Please try reloading the page"],
                                     200);



            $category=Category::find($id);
            $categoryFound=Category::join('users', 'categories.id_user', '=', 'users.username')
                        ->where(DB::raw('lower(categories.name)'), '=', strtolower($request->name))
                        ->where('users.username', '=', $request->session()->get('user'))
                        ->get()->first();

            if ($categoryFound!=NULL && $category->name != $categoryFound->name){
                return response()->json(['status' => "warning",
                                        'message'=> "Category's name already exists in your categories"],
                                        200);
            }

            $category->name=$request->name;
            $category->save();

            return response()->json(['status' => "success",
                                    'message'=> "Category updated successfully"],
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
