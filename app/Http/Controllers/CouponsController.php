<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Session;
use DB;

class CouponsController extends Controller
{
    public function addCoupon(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $coupon = new Coupon;
            $coupon->coupon_code = strtoupper($data['coupon_code']);
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if(empty($data['status'])){
                $coupon->status = 0;
            } else {
                $coupon->status = 1;
            }
            $coupon->save();
            Session::flash('success', 'Coupon Created Successfully');
            return redirect()->route('view.coupons');
        }
        return view ('admin.products.add_coupon');
    }
    public function viewCoupons(){
        $coupons = Coupon::latest()->get();
        return view ('admin.products.view_coupons', compact('coupons'));
    }
    public function editCoupon(Request $request, $id){
        $coupon = Coupon::find($id);
        if($request->isMethod('post')){
            $data = $request->all();
            $coupon->coupon_code = strtoupper($data['coupon_code']);
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if(empty($data['status'])){
                $coupon->status = 0;
            } else {
                $coupon->status = 1;
            }
            $coupon->save();
            Session::flash('success', 'Coupon Updated Successfully');
            return redirect()->route('view.coupons');
        }
        return view ('admin.products.edit_coupon', compact('coupon'));
    }
    public function deleteCoupon($id){
        $coupon = Coupon::find($id);
        $coupon->delete();
        Session::flash('error', 'Coupon Deleted Successfully');
        return redirect()->route('view.coupons');

    }
    public function applyCoupon(Request $request){

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
        $couponCount = Coupon::where('coupon_code',$data['coupon_code'])->count();
        if($couponCount == 0){
            return redirect()->back()->with('flash_message_error','Coupon Is Invalid');
        }else{
            $couponDetails = Coupon::where('coupon_code',$data['coupon_code'])->first();

//            checking status
            if($couponDetails -> status == 0){
                return redirect()->back()->with('flash_message_error', 'Coupon Is Not Active');
            }

//            checking coupon expiry date
            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('Y-m-d');
            if($expiry_date<$current_date){
                return redirect()->back()->with('flash_message_error', 'Coupon Is Expired');
            }

            $session_id = Session::get('session_id');
            $userCart = DB::table('carts')->where(['session_id' => $session_id])->get();
            $total_amount = 0;

            foreach ($userCart as $item){
                $total_amount = $total_amount + ($item->price * $item->quantity);
            }

            if($couponDetails->amount_type == "Fixed"){
                $couponAmount = $couponDetails->amount;
            } else {
                $couponAmount = $total_amount * ($couponDetails->amount / 100);
            }
            Session::put('CouponAmount', $couponAmount);
            Session::put('CouponCode', $data['coupon_code']);

            return redirect()->back()->with('flash_message_success', 'Coupon Applied Successfully');

        }

    }
}
