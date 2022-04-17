<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Note;

use App\Models\Background;
use App\Models\Color;
use App\Models\Image;

class DashboardController extends Controller
{
    public function index(){

        if(!session()->has('user'))
            return view('index');

        try{
            $categories = Category::select('categories.id', 'categories.name')
                        ->join('users', 'categories.id_user', '=', 'users.username')
                        ->where('users.username', '=', session()->get('user'))
                        ->orderBy("categories.created_at", 'ASC')
                        ->get();

            foreach($categories as $category)
            {
                $category->notes=Note::select('notes.id', 'notes.text', 'notes.order')
                        ->join('categories', 'notes.id_category', '=', 'categories.id')
                        ->join('users', 'categories.id_user', '=', 'users.username')
                        ->where('users.username', '=', session()->get('user'))
                        ->where('categories.id', '=', $category->id)
                        ->orderBy("notes.order", 'ASC')
                        ->get();
            }

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
            return view('dashboard', compact('categories', 'background'));
        }
        catch(QueryException $ex){
            abort(500, "Error ". $ex->getCode() . ": " . "Error in database connection. Try again later");
        }
        catch(\Exception $ex){
            abort(500, "Error ". $ex->getCode() . ": Try again later");
        }
    }

    public function destroyNote($id){

        if(!session()->has('user'))
            return response()->json(['status' => "error",
                                'message'=> "Session has expired. Please try reloading the page."],
                                 200);

        try{
            if(!Note::join('users', 'notes.id_user', '=', 'users.username')
                ->where('users.username', '=', session()->get('user'))
                ->where('notes.id', '=', $id)
                ->exists()
                )
                    return response()->json(['status' => "error",
                                    'message'=> "Note does not match with current user. Please try reloading the page"],
                                     200);

            $note=Note::find($id);
            $note->delete();

            return response()->json(['status' => "success",
                                    'message'=> "Note removed successfully!"],
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

    public function destroyCategory($id){

        if(!session()->has('user'))
            return response()->json(['status' => "error",
                                'message'=> "Session has expired. Please try reloading the page."],
                                 200);

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

            Note::join('categories', 'notes.id_category', "=", "categories.id")
                        ->where('categories.id', '=', $id)
                        ->delete();

            $category->delete();

            return response()->json(['status' => "success",
                                    'message'=> "Category removed successfully!"],
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

    public function update($id, Request $request){

        if(!session()->has('user'))
            return response()->json(['status' => "error",
                                'message'=> "Session has expired. Please try reloading the page."],
                                 200);

        try{
            if(!Note::join('users', 'notes.id_user', '=', 'users.username')
                ->where('users.username', '=', session()->get('user'))
                ->where('notes.id', '=', $id)
                ->exists()
                )
                    return response()->json(['status' => "error",
                                    'message'=> "Note does not match with current user. Please try reloading the page"],
                                     200);


            $sourceNote=Note::find($id);
            $sourceCategory=Category::find($request->id_category);
            $afterNote=NULL;
            if($request->id_after!=0)
                $afterNote=Note::find($request->id_after);



            $categorySize=Note::select("notes.order")
                                ->join('categories', 'notes.id_category', '=', 'categories.id')
                                ->where('categories.id', '=', $sourceCategory->id)
                                ->orderBy('notes.order', 'DESC')
                                ->value('notes.order');

            if($categorySize==NULL)
                $categorySize=0;

            $sourceNote->id_category=$sourceCategory->id;

            if($request->position=="after"){
                $sourceNote->order=$categorySize+1;
            }
            else{
                $sourceNote->order=$afterNote->order;

            }

            $sourceNote->save();


            $idNotes=Note::select('notes.id')->join('categories', 'notes.id_category', '=', 'categories.id')->where('categories.id', '=', $sourceNote->id_category)->orderBy('notes.order', 'ASC')->orderBy('notes.updated_at', 'DESC')->get();
            $counter=0;


            foreach($idNotes as $container){
                $counter+=1;
                $singleNote=Note::find($container->id);
                $singleNote->order=$counter;
                $singleNote->save();
            }

            return response()->json(['status' => "success",
                                    'message'=> "Notes updated successfully"],
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
