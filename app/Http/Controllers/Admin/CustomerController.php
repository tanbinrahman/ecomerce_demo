<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class CustomerController extends Controller
{

    public function index()
    {

        $Customers =Customer::all();

        return view('admin.customer.customer',compact('Customers'));
    }

    public function show(Request $request ,$id=''){
        $arr =Customer::where(['id'=>$id])->get();
        $result['customer_list'] =$arr['0'];

        return view('admin.customer.show_customer',$result);
    }

    public function status(Request $request,$status, $id){
        $customer =Customer::find($id);
        $customer->status = $status;
        $customer->save();
        Session::flash('message','Customer status update successfully');
        return redirect('admin/customer');  
    }

}
