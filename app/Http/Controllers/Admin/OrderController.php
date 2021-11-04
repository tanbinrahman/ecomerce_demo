<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $result['orders']= DB::table('orders')
        ->select('orders.*','orders_status.orders_status')
        ->leftJoin('orders_status','orders_status.id','=','orders.order_status')
        ->get();
    //   prx($result);
      return view('admin.order.order',$result);
    }

    

    public function order_details(Request $request ,$id){
        $result['order_details']=DB::table('orders_details')
        ->select('orders.*','orders_details.price','orders_details.qty','products.name as pname','products_attr.attr_image','colors.color','sizes.size','orders_status.orders_status')
        ->leftJoin('orders','orders.id','=','orders_details.orders_id')
        ->leftJoin('products_attr','products_attr.id','=','orders_details.products_attr_id')
        ->leftJoin('products','products.id','=','products_attr.products_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('orders_status','orders_status.id','=','orders.order_status')
        ->where(['orders.id'=>$id])->get();

       $result['orders_status']=DB::table('orders_status')->get(); 
    //    prx($result);

        $result['payment_status']=['Pending','Success','Fail'];
        // prx($result);
     return view('admin.order.order_details',$result);
    }

    public function update_payment_status(Request $request ,$status, $id){
        DB::table('orders')
        ->where(['id'=>$id])
        ->update(['payment_status'=>$status]);
        return redirect('/admin/order_details/'.$id);
    }

    public function update_order_status(Request $request ,$status, $id){
        DB::table('orders')
        ->where(['id'=>$id])
        ->update(['order_status'=>$status]);
        return redirect('/admin/order_details/'.$id);
    }

    
    public function update_track_details(Request $request,$id){
        
        DB::table('orders')
        ->where(['id'=>$id])
        ->update(['track_details'=>$request->post('track_details')]);
        return redirect('/admin/order_details/'.$id);
    }
    
}
