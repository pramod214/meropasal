<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

//             check if users is already exist in our database
            $userCheck = User::where('email',$data['email'])->count();
            if($userCheck > 0){
                return redirect()->back()->with('flash_message_error', 'Email Already Exists');
            }

        }
        return view('frontend.user.index');
    }
}
