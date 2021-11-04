<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Color;
use Illuminate\Http\Request;
use Session;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors =Color::get();
        return view('admin.color.color',compact('colors'));
    }

    public function manage_color(){
        return view('admin.color.manage_color');
    }

    public function manage_color_process(Request $request){
        $request->validate([
            'color'=>'required|unique:colors',
        ]);

        $colors =new Color();
        $colors->color =$request->post('color');
        $colors->status =1;
        $colors->save();

        Session::flash('message','Color data insert successfully');
        return redirect('admin/color');
        
    }

    public function delete(Request $request,$id){

        $color =Color::findOrFail($id);
        $color->delete();

        Session::flash('message','Color data delete successfully');
        return redirect('admin/color');

    }

    public function edit($id){
        $color= Color::findOrFail($id);
        return view('admin.color.colorEdit',compact('color'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'color'=>'required|unique:colors,color,'.$id,
        ]);

        $color =Color::findOrFail($id);
        $color->color =$request->post('color');
        $color->save();


        Session::flash('message','Color data update successfully');
        return redirect('admin/color');
    }

    public function status(Request $request ,$status,$id){
        $color =Color::findOrFail($id);
        $color->status= $status;
        $color->save();

        Session::flash('message','Color stutas update successfully');
        return redirect('admin/color');
    }
   
}
