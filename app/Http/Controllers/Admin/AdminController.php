<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  Simple index page:-
    // public function index()
    // {
    //     return view('admin.login');
    // }

    public function index(Request $request)
    {
        if($request->session()->has('ADMIN_LOGIN')){
            return redirect('admin/dashboard');
        }else{
            Session::flash('error','Access denied');
            // $request->session()->flash('error','Access denied');
            return view('admin.login');
        }
        return view('admin.login');
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

// LOGIN AR JONNO CODE (PASSWORD ENCRIPT AR AGA )

     public function auth(Request $request)
     {   
         // return $request->post();
         $email =$request->post('email');
         $password =$request->post('password');

         $result =Admin::where(['email'=>$email ])->first();

         // echo '<pre>';
        // print_r($result);

        if($result){
            if(Hash::check($request->post('password'),$result->password)){
                $request->session()->put('ADMIN_LOGIN',true);
                $request->session()->put('ADMIN_ID',$result->id);
                return redirect('admin/dashboard'); 
            }else{
                Session::flash('error','please input correct password');
            //  $request->session()->flash('error','please input correct email and password');
             return redirect('admin');
            }
        }else{
              Session::flash('error','please input correct email and password');
            //  $request->session()->flash('error','please input correct email and password');
             return redirect('admin');
         }

     }

    //  public function auth(Request $request)
    //  {   
    //      // return $request->post();
    //      $email =$request->post('email');
    //      $password =$request->post('password');

    //      $result =Admin::where(['email'=>$email ,'password'=>$password])->get();

    //      // echo '<pre>';
    //     // print_r($result);

    //     if(isset($result['0']->id)){
    //          $request->session()->put('ADMIN_LOGIN',true);
    //          $request->session()->put('ADMIN_ID',$result['0']->id);
    //          return redirect('admin/dashboard');

    //      }else{
    //           Session::flash('error','please input correct email and password');
    //         //  $request->session()->flash('error','please input correct email and password');
    //          return redirect('admin');
    //      }


    //  }

    public function dashboard()
    {
        return view('admin.dashboard');
    }


    // public function updatepassword(){
    //     $r =Admin::find(1);
    //     $r->password =Hash::make('123456789');
    //     // $r->email =Hash::make('admin@gmail.com');
    //     $r->save();
    // }
   
}
