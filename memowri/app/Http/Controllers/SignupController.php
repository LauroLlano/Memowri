<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Color;
use App\Models\Cursor;
use App\Models\Background;

use Illuminate\Database\QueryException;

class SignupController extends Controller
{
    public function store(Request $request){

        $request->validate([
                'username' => array('bail', 'required', 'min:6', 'max:30', 'not_regex:/ /'),
                'password' => array('bail', 'required', 'min:6', 'max:50', 'regex:/[0-9]/', 'regex:/[A-Z]/', 'regex:/[ `!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?~]/')
        ]);

        try{
            if(User::where('users.username', '=', $request->username)->exists()){
                return response()->json(['status' => "error",
                                    'message'=> "The username already has been taken"],
                                     200);
            }

            $user=new User();
            $user->username=$request->username;
            $user->password=$request->password;
            $user->save();

            $request->session()->put('user', $request->username);

            $color=new Color();
            $color->save();

            $cursor=new Cursor();
            $cursor->id_color=$color->id;
            $cursor->save();

            $background=new Background();
            $background->id_color=$color->id;
            $background->id_user=$request->username;
            $background->save();

            return response()->json(['status' => "success",
                                    'message'=> "User created successfully"],
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
