<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories =Category::all();

        return view('admin.category',compact('categories'));
    }


    // public function manage_catagory()
    // {
    //     return view('admin.manage_catagory');
    // }


     public function manage_catagory(Request $request, $id ='')
    {
        if($id>0){
            $arr=Category::where(['id'=>$id])->get();

            $result['category_name'] =$arr['0']->category_name;
            $result['category_slug'] =$arr['0']->category_slug;
            $result['parent_category_id'] =$arr['0']->parent_category_id;
            $result['category_image'] =$arr['0']->category_image;
            $result['is_home']= $arr['0']->is_home;
            $result['is_home_selected']='';
            if($arr['0']->is_home==1){
                $result['is_home_selected']='checked';
            } 
            $result['id']= $arr['0']->id;

            $result['categorys']= DB::table('categories')->where(['status'=>1])->where('id','!=',$id)->get();
        }else{
            $result['category_name']='';
            $result['category_slug']='';
            $result['parent_category_id']='';
            $result['category_image']='';
            $result['is_home']='';
            $result['is_home_selected']='';
            $result['id']=0;

            $result['categorys']= DB::table('categories')->where(['status'=>1])->get();
        }
        // echo '<pre>';
        // print_r($result['data'][0]->category_name);
        // die();
        

        return view('admin.manage_catagory',$result);
    }



    public function manage_catagory_process(Request $request){
        // return $request->post();

        $request->validate([
            'category_name' =>'required',
            'category_image'=>'mimes:jpg,jpeg,png',
            'category_slug' =>'required|unique:categories,category_slug,'.$request->post('id'),
        ]);
        if($request->post('id')>0){
            $category =Category::find($request->post('id'));
            $msg ='Category update successfully';
        }else{
            $category =new Category();
            $msg ='Category insert successfully' ;
        }
        // $category =new Category();
        if($request->hasfile('category_image')){
            if($request->post('id')>0){
                $arrImage = DB::table('categories')->where(['id'=>$request->post('id')])->get();
                if(Storage::exists('/public/media/category/'.$arrImage[0]->category_image)){
                    Storage::delete('/public/media/category/'.$arrImage[0]->category_image);
                }
            }
            $image =$request->file('category_image');
            $ext =$image->extension();
            $image_name =time().'.'.$ext;
            $image->storeAs('/public/media/category',$image_name);
            $category->category_image=$image_name;
        }

        $category->category_name = $request->post('category_name');
        $category->category_slug = $request->post('category_slug');
        $category->parent_category_id = $request->post('parent_category_id');
        $category->is_home =0; 
        if($request->post('is_home')!==null){
            $category->is_home =1; 
        }
        $category->status =1;
        $category->save();

        Session::flash('message',$msg);
        return redirect('admin/category');

    }

    public function delete(Request $request, $id){
        $category =Category::find($id);
        $category->delete();
        Session::flash('message','Category data delete successfully');
        return redirect('admin/category');
    }

/*
    public function edit($id){

        $category =Category::findOrFail($id);
        return view('admin.categoryEdit',compact('category'));

    }
*/
    // public function update(Request $request ,$id){
    //     // return $request->post();

    //     $request->validate([
    //         'category_name' =>'required',
    //         'category_slug' =>'required|unique:categories,category_slug,'.$id,
    //     ]);
    //     $category =Category::findOrFail($id);
    //     // $category =new Category();
    //     $category->category_name = $request->post('category_name');
    //     $category->category_slug = $request->post('category_slug');
    //     $category->save();

    //     Session::flash('message','Category updated successfully');
    //     return redirect('admin/category');

    // }

    public function status(Request $request,$status, $id){
        $category =Category::find($id);
        $category->status = $status;
        $category->save();
        Session::flash('message','Category status update successfully');
        return redirect('admin/category');  
    }


}
