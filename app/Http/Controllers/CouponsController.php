<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Session;

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
        $data = $request->all();

        $couponCount = Coupon::where('coupon_code',$data['coupon_code'])->count();
        if($couponCount == 0){
            return redirect()->back()->with('flash_message_error','Coupon Is Invalid');
        }else{
            echo'success'; die;
        }

    }
}
