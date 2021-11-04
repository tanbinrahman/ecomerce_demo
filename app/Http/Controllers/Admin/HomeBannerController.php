<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\HomeBanner;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Storage;

class HomeBannerController extends Controller
{
    
    public function index()
    {

        $homebanners =HomeBanner::all();

        return view('admin.home_banner.home_banner',compact('homebanners'));
    }


     public function manage_home_banner(Request $request, $id ='')
    {
        if($id>0){
            $arr=HomeBanner::where(['id'=>$id])->get();

            $result['image'] =$arr['0']->image;
            $result['btn_txt'] =$arr['0']->btn_txt;
            $result['btn_link'] =$arr['0']->btn_link;
            $result['id']= $arr['0']->id;
        }else{
            $result['image']='';
            $result['btn_txt']='';
            $result['btn_link']='';
            $result['id']=0;

            $result['home_banners']= DB::table('home_banners')->where(['status'=>1])->get();
        }
        // echo '<pre>';
        // print_r($result['data'][0]->category_name);
        // die();
        

        return view('admin.home_banner.manage_home_banner',$result);
    }



    public function manage_home_banner_process(Request $request){
        // return $request->post();

        $request->validate([
            
            'image'=>'required|mimes:jpg,jpeg,png',
            
        ]);
        if($request->post('id')>0){
            $home_banner =HomeBanner::find($request->post('id'));
            $msg ='HomeBanner update successfully';
        }else{
            $home_banner =new HomeBanner();
            $msg ='HomeBanner insert successfully' ;
        }
        // $category =new Category();
        if($request->hasfile('image')){
            if($request->post('id')>0){
                $arrImage = DB::table('home_banners')->where(['id'=>$request->post('id')])->get();
                if(Storage::exists('/public/media/home_banner/'.$arrImage[0]->image)){
                    Storage::delete('/public/media/home_banner/'.$arrImage[0]->image);
                }
            }
            $image =$request->file('image');
            $ext =$image->extension();
            $image_name =time().'.'.$ext;
            $image->storeAs('/public/media/home_banner',$image_name);
            $home_banner->image=$image_name;
        }

        $home_banner->btn_txt = $request->post('btn_txt');
        $home_banner->btn_link = $request->post('btn_link');
        $home_banner->status =1;
        $home_banner->save();

        Session::flash('message',$msg);
        return redirect('admin/home_banner');

    }

    public function delete(Request $request, $id){
        $home_banner =HomeBanner::find($id);
        $home_banner->delete();
        Session::flash('message','Banner data delete successfully');
        return redirect('admin/home_banner');
    }

    public function status(Request $request,$status, $id){
        $home_banner =HomeBanner::find($id);
        $home_banner->status = $status;
        $home_banner->save();
        Session::flash('message','Banner status update successfully');
        return redirect('admin/home_banner');  
    }
}
