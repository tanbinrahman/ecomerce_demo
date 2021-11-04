<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Size;
use Illuminate\Http\Request;
use Session;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $sizes =Size::all();
        return view('admin.size.size',compact('sizes'));
    }

    public function manage_size(){
        return view('admin.size.manage_size');
    }


    public function manage_size_process(Request $request){
        $request->validate([
            'size'=> 'required',
        ]);

        $size =new Size();
        $size->size =$request->post('size');
        $size->status =1;
        $size->save();

        Session::flash('message','Size data insert Successfully');
        return redirect('admin/size');

    }

    public function delete(Request $request, $id){
        $size =Size::findOrFail($id);
        $size->delete();

        Session::flash('message','Size data delete Successfully');
        return redirect('admin/size');

    }

    public function edit($id){
        $size =Size::findOrFail($id);
        return view('admin.size.sizeEdit',compact('size'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'size'=> 'required',
        ]);

        $size =Size::findOrFail($id);
        $size->size =$request->post('size');
        $size->save();

        Session::flash('message','Size data update Successfully');
        return redirect('admin/size');


    }

    public function status(Request $request,$status, $id){

        $size =Size::findOrFail($id);
        $size->status =$status;
        $size->save();


        Session::flash('message','Size status update successfully');
        return redirect('admin/size');

    }

   
}
