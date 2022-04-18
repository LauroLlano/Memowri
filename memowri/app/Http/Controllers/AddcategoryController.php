<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

use App\Models\Background;
use App\Models\Color;
use App\Models\Image;

use Illuminate\Database\QueryException;

class AddcategoryController extends Controller
{

    public function index(){

        if(!session()->has('user'))
            return redirect()->route('/');

        try{
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
            return view('addcategory', compact('background'));
        }
        catch(QueryException $ex){
            abort(500, "Error ". $ex->getCode() . ": " . "Error in database connection. Try again later");
        }
        catch(\Exception $ex){
            abort(500, "Error ". $ex->getCode() . ": Try again later");
        }
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'bail|required|max:30'
        ]);

        try{
            if (Category::join('users', 'categories.id_user', '=', 'users.username')
                        ->where(DB::raw('lower(categories.name)'), '=', strtolower($request->name))
                        ->where('users.username', '=', session()->get('user'))
                        ->exists())
            {
                return response()->json(['status' => "warning",
                                        'message'=> "Category's name already exists in your categories"],
                                        200);
            }

            if(Category::join('users', 'categories.id_user', '=', 'users.username')
                        ->where('users.username', '=', session()->get('user'))
                        ->count()>=5)
            {
                return response()->json(['status' => "warning",
                                        'message'=> "You can only have 5 categories in your account."],
                                        200);
            }

            $category=new Category();
            $category->name=$request->name;
            $category->id_user=session()->get('user');
            $category->save();

            return response()->json(['status' => "success",
                                    'message'=> "Category created successfully"],
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
