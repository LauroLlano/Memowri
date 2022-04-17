<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Note;

use App\Models\Background;
use App\Models\Color;
use App\Models\Image;

use Illuminate\Database\QueryException;

class AddnoteController extends Controller
{
    public function create(){

        if(!session()->has('user'))
            return redirect()->route('/');

        try{
            $categories=Category::select('categories.id', 'categories.name')
                        ->join('users', 'categories.id_user', '=', 'users.username')
                        ->where('users.username', '=', session()->get('user'))
                        ->orderBy('categories.created_at', 'DESC')
                        ->get();


            if($categories->isEmpty())
                return redirect()->route('category.create');


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

            return view('addnote', compact('categories', 'background'));
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
            'id_category'=> 'bail|required|numeric',
            'text'=> 'bail|required|max:255'
        ]);

        try{
            $orderNumber=Note::select('notes.order')
                            ->join('categories', 'notes.id_category', '=', 'categories.id')
                            ->where('categories.id', '=', $request->id_category)
                            ->orderBy('notes.order', 'DESC')
                            ->value('notes.order');

            if($orderNumber==NULL)
                $orderNumber=0;

            $note=new Note();
            $note->text=$request->text;
            $note->order=$orderNumber+1;
            $note->id_user=$request->session()->get('user');
            $note->id_category=$request->id_category;
            $note->save();

            return response()->json(['status' => "success",
                                    'message'=> "Note has been added successfully"],
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
