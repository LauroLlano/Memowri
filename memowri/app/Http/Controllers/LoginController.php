<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Database\QueryException;

class LoginController extends Controller
{
    public function show(Request $request){

        $request->validate([
            'username' => 'bail|required',
            'password' => 'bail|required'
        ]);

        try{
            $user=User::select(['users.username AS id'])
                ->where('users.username', '=', $request->username)
                ->where('users.password', '=', $request->password)
                ->get()
                ->first();

            if ($user==NULL)
                return response()->json(['status' => "error",
                                    'message'=> "The user and/or password are invalid"],
                                     200);

            session()->put('user', $user->id);

            return response()->json(['status' => "success",
                                    'message'=> "User logged in successfully"],
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
