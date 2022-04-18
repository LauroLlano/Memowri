<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Background;
use App\Models\Color;
use App\Models\Image;

use Illuminate\Database\QueryException;

class EditaccountController extends Controller
{
    public function edit()
    {
        if(!session()->has('user'))
            return redirect('index.show');

        try{
            $user=User::select('users.username as id')
                        ->where('users.username', '=', session()->get('user'))
                        ->get()->first();

            $background=Background::select('backgrounds.id')
                                ->join('users', 'backgrounds.id_user', '=', 'users.username')
                                ->where('users.username', '=', $user->id)
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

            return view('editaccount', compact('user', 'background'));
        }
        catch(QueryException $ex){
            abort(500, "Error ". $ex->getCode() . ": " . "Error in database connection. Try again later");
        }
        catch(\Exception $ex){
            abort(500, "Error ". $ex->getCode() . ": Try again later");
        }
    }

    public function update(Request $request){
        $request->validate([
            'passwordOld' => array('bail', 'required'),
            'passwordNew' => array('bail', 'required', 'min:6', 'max:50', 'regex:/[0-9]/', 'regex:/[A-Z]/', 'regex:/[ `!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?~]/')
        ]);

        try{
            $user=User::where('username', '=', session()->get('user'))->get()->first();


            if($user->password!=$request->passwordOld){
                return response()->json(['status' => "warning",
                                        'message'=> "Old password does not match with current password"],
                                        200);
            }

            $user->password=$request->passwordNew;
            $user->save();

            return response()->json(['status' => "success",
                                    'message'=> "User updated successfully"],
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
