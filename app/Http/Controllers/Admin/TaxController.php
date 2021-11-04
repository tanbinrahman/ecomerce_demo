<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tax;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $taxes =Tax::all();

        return view('admin.tax.tax',compact('taxes'));
    }

    public function manage_tax(Request $request, $id ='')
    {
        if($id>0){
            $arr=Tax::where(['id'=>$id])->get();

            $result['tax_desc'] =$arr['0']->tax_desc;
            $result['tax_value'] =$arr['0']->tax_value;
            $result['status'] =$arr['0']->status;
            $result['id']= $arr['0']->id;

           
        }else{
            $result['tax_desc']='';
            $result['tax_value']='';
            $result['status'] ='';
            $result['id']=0;

        }
        // echo '<pre>';
        // print_r($result['data'][0]->category_name);
        // die();
        

        return view('admin.tax.manage_tax',$result);
    }

    
    public function manage_tax_process(Request $request){
        // return $request->post();

        $request->validate([

            'tax_value' =>'required|unique:taxes,tax_value,'.$request->post('id'),
        ]);
        if($request->post('id')>0){
            $tax =Tax::find($request->post('id'));
            $msg ='Tax update successfully';
        }else{
            $tax =new Tax();
            $msg ='Tax insert successfully' ;
        }


        $tax->tax_desc = $request->post('tax_desc');
        $tax->tax_value = $request->post('tax_value');
        $tax->status =1;
        $tax->save();

        Session::flash('message',$msg);
        return redirect('admin/tax');

    }

    public function delete(Request $request, $id){
        $tax =Tax::find($id);
        $tax->delete();
        Session::flash('message','Tax data delete successfully');
        return redirect('admin/tax');
    }

    public function status(Request $request,$status, $id){
        $tax =Tax::find($id);
        $tax->status = $status;
        $tax->save();
        Session::flash('message','Tax status update successfully');
        return redirect('admin/tax');  
    }

}
