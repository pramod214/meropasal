<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use DB;
use Session;

class CartController extends Controller
{
    public function addtoCart(Request $request)
    {
        if ($request->isMethod('post')) {

            Session::forget('CouponAmount');
            Session::forget('CouponCode');

            $data = $request->all();
            //dd($data);
            if (empty($data['user_email'])) {
                $data['user_email'] = "";
            }
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = str_random(40);
                Session::put('session_id', $session_id);
            }

            $sizeArr = explode('-', $data['size']);

            $countProducts = DB::table('carts')->where(['product_id' => $data['product_id'], 'product_color' => $data['product_color'], 'size' => $sizeArr[1], 'session_id' => $session_id])->count();
            if ($countProducts > 0) {
                return redirect()->back()->with('flash_message_success', 'Cart Item Already Exixts');
            } else {
                DB::table('carts')->insert([
                    'product_id' => $data['product_id'], 'product_name' => $data['product_name'], 'product_code' => $data['product_code'], 'product_color' => $data['product_color'], 'price' => $data['price'], 'size' => $sizeArr[1], 'quantity' => $data['quantity'], 'user_email' => $data['user_email'], 'session_id' => $session_id
                ]);
            }
            return redirect()->route('cart');


        }
    }

    public function cart(){
        $session_id = Session::get('session_id');
        $userCart = DB::table('carts')->where(['session_id'=>$session_id])->get();
        return view ('frontend.products.cart',compact('userCart'));
    }

    public function deleteCart($id){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->back()->with('flash_message_error','Cart Item Deleted');
    }

    public function updateCartQuantity($id,$quantity){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        DB::table('carts')->where('id',$id)->increment('quantity',$quantity);
        return redirect()->back()->with('flash_message_success', 'Cart Updated');
    }


}
