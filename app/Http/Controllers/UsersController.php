<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

//             check if users is already exist in our database
            $userCheck = User::where('email',$data['email'])->count();
            if($userCheck > 0){
                return redirect()->back()->with('flash_message_error', 'Email Already Exists');
            }else{
                $user = new User();
                $user->name = ucwords(strtolower($data['name']));
                $user->email = strtolower($data['email']);
                $user->password = bcrypt($data['password']);
                $user->admin = "0";
                $user->save();

              if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                  return redirect()->route('cart');
              }
            }

        }
        return view('frontend.user.index');
    }

    public function login(Request $request){
        if($request->isMethod('post')) {
            $data = $request->all();

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    return redirect('cart');
            }else{
                return redirect()->back()->with('flash_message_error','Invalid');
            }
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('indexpage');
    }
}
