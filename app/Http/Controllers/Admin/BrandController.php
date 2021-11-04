<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use Session;
use Storage;
use Illuminate\Support\Facades\DB;


class BrandController extends Controller
{
    
    public function index()
    {   
        $brands =Brand::all();
        return view('admin.brand.brand',compact('brands'));
    }

    public function manage_brand(Request $request, $id=''){

        if($id>0){
            $arr=Brand::where(['id'=>$id])->get();
            $result['name']= $arr['0']->name;
            $result['image']= $arr['0']->image;
            $result['is_home']= $arr['0']->is_home;
            $result['is_home_selected']='';
            if($arr['0']->is_home==1){
                $result['is_home_selected']='checked';
            }
            $result['status']= $arr['0']->status;
            $result['id']= $arr['0']->id;
        }else{
            $result['name'] ='';
            $result['image'] ='';
            $result['is_home']='';
            $result['is_home_selected']='';
            $result['status'] ='';
            $result['id'] =0;
        }
        return view('admin.brand.manage_brand' ,$result);
    }

    public function manage_brand_process(Request $request){
        $request->validate([
            'name'=>'required|unique:brands,name,'.$request->post('id'),
            'image'=>'mimes:jpg,jpeg,png'
            
            
        ]);

        if($request->post('id')>0){
            $brands =Brand::find($request->post('id'));
            $msg ="Brand updated";
        }else{
            $brands =new Brand();
            $msg ="brand inserted";
        }




        if($request->hasfile('image')){
            if($request->post('id')>0){
                $arrImage = DB::table('brands')->where(['id'=>$request->post('id')])->get();
                if(Storage::exists('/public/media/brand/'.$arrImage[0]->image)){
                    Storage::delete('/public/media/brand/'.$arrImage[0]->image);
                }
            }
            $image =$request->file('image');
            $ext =$image->extension();
            $image_name =time().'.'.$ext;
            $image->storeAs('/public/media/brand',$image_name);
            $brands->image=$image_name;
        }
        $brands->name =$request->post('name');
        $brands->is_home =0; 
        if($request->post('is_home')!==null){
            $brands->is_home =1; 
        }
        // $brands->image =$request->post('image');
        $brands->status =1;

        // echo '<pre>';
        // print_r($brand);
        // die();

        $brands->save();


        Session::flash('message',$msg);
        return redirect('admin/brand');

    }


    public function delete(Request $request ,$id){

        $brand =Brand::findOrFail($id);
        $brand->delete();
        Session::flash('message','Brand data delete successfully');
        return redirect('admin/brand');
    
    }

    public function status(Request $request ,$status ,$id){
        $brand =Brand::findOrFail($id);
        $brand->status =$status;
        $brand->save();

        Session::flash('message','Status data updated');
        return redirect('admin/brand');
    }

    

}
