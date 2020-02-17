<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Coupon;

class CouponsController extends Controller
{
    public function addCoupon(Request $request)
    {
    	if($request->isMethod('post')) {
            Validator::make($request->all(), ['coupon_code' => 'required|unique:coupons,coupon_code'])->validate();

    		$coupon = new Coupon;
    		$coupon->coupon_code = $request->input('coupon_code');
    		$coupon->amount = $request->input('amount');
    		$coupon->amount_type = $request->input('amount_type');
    		$coupon->expiry_date = $request->input('expiry_date');
    		if($request->input('status') == 1) {
    			$coupon->status = 1;
    		} else {
    			$coupon->status = 0;
    		}
    		$coupon->save();
            return redirect()->action('Admin\CouponsController@viewCoupons')->withSuccess('Coupon successfully added');
    	}

    	return view('admin.coupons.add_coupon');
    }

    public function viewCoupons()
    {
        $coupons = Coupon::get();
        return view('admin.coupons.view_coupons')->with(compact('coupons'));
    }

    public function deleteCoupon($id)
    {
        $couponToDelete = Coupon::findOrFail($id);
        $couponToDelete->delete();
        return redirect(route('viewCoupons'));
    }

    public function editCoupon(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        // echo '<pre>'; echo print_r(json_decode(json_encode($coupon))); die;
        if($request->isMethod('post')) {
            // $data = $request->all();
            $coupon->coupon_code = $request->input('coupon_code');
            $coupon->amount = $request->input('amount');
            $coupon->amount_type = $request->input('amount_type');
            $coupon->expiry_date = $request->input('expiry_date');
            if($request->input('status') == 1) {
                $coupon->status = 1;
            } else {
                $coupon->status = 0;
            }
            $coupon->save();
            return redirect(route('viewCoupons'));
        }
        return view('admin.coupons.edit_coupon', ['coupon' => $coupon]);
    } 
}
