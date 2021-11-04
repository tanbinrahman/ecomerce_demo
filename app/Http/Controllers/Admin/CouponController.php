<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;
use Session;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons =Coupon::get();
        return view('admin.coupon.coupon',compact('coupons'));
    }

    public function manage_coupon(Request $request, $id ='')
    {
        if($id>0){
            $arr =Coupon::where(['id'=>$id])->get();
            
            $result['title'] =$arr['0']->title;
            $result['code'] =$arr['0']->code;
            $result['value'] =$arr['0']->value;
            $result['type'] =$arr['0']->type;
            $result['min_order_amt'] =$arr['0']->min_order_amt;
            $result['is_one_time'] =$arr['0']->is_one_time;
            $result['id']= $arr['0']->id;
        }else{
            $result['title'] ='';
            $result['code']='';
            $result['value']='';
            $result['type']='';
            $result['min_order_amt']='';
            $result['is_one_time']='';
            $result['id']=0;

        }

        return view('admin.coupon.manage_coupon',$result);
    }

    public function manage_coupon_process(Request $request){

        $request->validate([
            'title' => 'required',
            'code' => 'required|unique:coupons,code,'.$request->post('id'),
            'value' => 'required',
        ]);

        if($request->post('id')>0){
            $coupons =Coupon::find($request->post('id'));
            $msg ="Coupos data Update successfully.";
        }else{
            $coupons =new Coupon();
            $msg ="Coupos data insert successfully.";
        }

        
        $coupons->title = $request->post('title');
        $coupons->code = $request->post('code');
        $coupons->value = $request->post('value');
        $coupons->type = $request->post('type');
        $coupons->min_order_amt = $request->post('min_order_amt');
        $coupons->is_one_time = $request->post('is_one_time');
        $coupons->status =1;
        $coupons->save();

        Session::flash('message',$msg);
        return redirect('admin/coupon');
    }

    public function delete(Request $request, $id){
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        Session::flash('message','Coupun data delete successfully');
        return redirect('admin/coupon');

    }

    // public function edit($id){
    //     $coupon =Coupon::findOrFail($id);
    //     return view('admin.coupon.couponEdit',compact('coupon'));
    // }

    // public function update(Request $request ,$id){
    //     $request->validate([
    //         'title' => 'required',
    //         'code' => 'required|unique:coupons,code,'.$id,
    //         'value' => 'required',
    //     ]);

    //     $coupon =Coupon::findOrFail($id);
    //     $coupon->title = $request->post('title');
    //     $coupon->code = $request->post('code');
    //     $coupon->value = $request->post('value');
    //     $coupon->save();

    //     Session::flash('message','Coupon update successfully');
    //     return redirect('admin/coupon');
    // }

    public function status(Request $request,$status, $id){
        $coupon = Coupon::findOrFail($id);
        $coupon->status =$status;
        $coupon->save();

        Session::flash('message','Coupun status update successfully');
        return redirect('admin/coupon');

    }
    
}

