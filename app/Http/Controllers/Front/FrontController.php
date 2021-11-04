<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Crypt;
use Mail;
use Session;


class FrontController extends Controller
{

    public function index(Request $request)
    {
        $result['home_categories']=DB::table('categories')->where(['status'=>1])
        ->where(['is_home'=>1])->get();

        foreach($result['home_categories'] as $list){
            $result['home_categories_product'][$list->id]=DB::table('products')->where(['status'=>1])
            ->where(['category_id'=>$list->id])->get();

            foreach($result['home_categories_product'][$list->id] as $list1){
              $result['home_product_attr'][$list1->id]=DB::table('products_attr')
              ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
              ->leftJoin('colors','colors.id','=','products_attr.color_id')
              ->where(['products_attr.products_id'=>$list1->id])->get();

            }
        }

        // prx($result);


        $result['home_featured_product'][$list->id]=DB::table('products')->where(['status'=>1])
        ->where(['is_featured'=>1])->get();

        foreach($result['home_featured_product'][$list->id] as $list1){
          $result['home_featured_product_attr'][$list1->id]=DB::table('products_attr')
          ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
          ->leftJoin('colors','colors.id','=','products_attr.color_id')
          ->where(['products_attr.products_id'=>$list1->id])->get();

        }

        $result['home_discount_product'][$list->id]=DB::table('products')->where(['status'=>1])
        ->where(['is_discount'=>1])->get();

        foreach($result['home_discount_product'][$list->id] as $list1){
          $result['home_discount_product_attr'][$list1->id]=DB::table('products_attr')
          ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
          ->leftJoin('colors','colors.id','=','products_attr.color_id')
          ->where(['products_attr.products_id'=>$list1->id])->get();

        }

        $result['home_tranding_product'][$list->id]=DB::table('products')
        ->where(['status'=>1])
        ->where(['is_tranding'=>1])
        ->get();

        foreach($result['home_tranding_product'][$list->id] as $list1){
          $result['home_tranding_product_attr'][$list1->id]=DB::table('products_attr')
          ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
          ->leftJoin('colors','colors.id','=','products_attr.color_id')
          ->where(['products_attr.products_id'=>$list1->id])
          ->get();

        }
        // prx($result['home_tranding_product']);
        // echo "<pre>";
        // print_r($result);
        // die();

        $result['home_brands']=DB::table('brands')->where(['status'=>1])
        ->where(['is_home'=>1])->get();

        $result['home_banners']=DB::table('home_banners')
        ->where(['status'=>1])->get();

        return view('Front.index',$result);
    }

    public function product(Request $request, $slug){
      $result['product']=DB::table('products')->where(['status'=>1])
      ->where(['slug'=>$slug])->get();

      foreach($result['product'] as $list1){
        $result['product_attr'][$list1->id]=DB::table('products_attr')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['products_attr.products_id'=>$list1->id])->get();

      }

      foreach($result['product'] as $list1){
        $result['product_images'][$list1->id]=DB::table('product_images')
        ->where(['product_images.products_id'=>$list1->id])->get();

      }

      $result['related_products']=DB::table('products')->where(['status'=>1])
      ->where('slug','!=',$slug)->where(['category_id'=>$result['product'][0]->category_id])->get();

      foreach($result['related_products'] as $list1){
        $result['related_product_attr'][$list1->id]=DB::table('products_attr')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['products_attr.products_id'=>$list1->id])->get();

      }
      // prx($result['product'][0]->id);
      $result['product_review'] =DB::table('product_review')
          ->leftJoin('customers','customers.id','=','product_review.customer_id')
          ->where(['product_review.products_id'=>$result['product'][0]->id])
          ->where(['product_review.status'=>1])
          ->orderBy('product_review.id','desc')
          ->select('product_review.rating','product_review.review','product_review.added_on','customers.name')
          ->get();

    //  prx($result['product_review']);
      return view('Front.product',$result);
    }


    public function add_to_cart(Request $request){
       
        if($request->session()->has('FRONT_USER_LOGIN')){
          $uid =$request->session()->get('FRONT_USER_ID');
          $user_type='Reg';
        }else{
          $uid=getUserTempId();
          $user_type='Not-Reg';
        }
      
        $size_id =$request->post('size_id');
        $color_id=$request->post('color_id');
        $pqty =$request->post('pqty');
        $products_id=$request->post('product_id');

        $result =DB::table('products_attr')
        ->select('products_attr.id')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['products_id'=>$products_id])
        ->where(['sizes.size'=>$size_id])
        ->where(['colors.color'=>$color_id])
        ->get();

        $product_attr_id=$result[0]->id;


        $getAvaliableQty =getAvaliableQty($products_id ,$product_attr_id);
        // prx($getAvaliableQty);
        $finalAvaliable = $getAvaliableQty[0]->poqty - $getAvaliableQty[0]->qty ;

        if($pqty>$finalAvaliable){
          return response()->json(['msg'=>"Not_avaliable" ,'data'=>"Only $finalAvaliable left."]);
        }
        // prx($finalAvaliable);

        // $totalorder =0;
        // foreach($getAvaliableQtys as $getAvaliableQty){
        //   $totalorder =$totalorder + $getAvaliableQty->qty ;
        //   prx($totalorder);
        // }
          
 


        $check =DB::table('cart')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->where(['product_id'=>$products_id])
        ->where(['product_attr_id'=>$product_attr_id])
        ->get();

        if(isset($check[0])){
          $update_id =$check[0]->id;
          if($pqty==0){
            DB::table('cart')
            ->where(['id'=>$update_id])
            ->delete();
            $msg ="Remove";
          }else{
            DB::table('cart')
            ->where(['id'=>$update_id])
            ->update(['qty'=>$pqty]);
            $msg ="Updated";
          }


        }else{
          $id =DB::table('cart')->insertGetId([
            'user_id'=>$uid,
            'user_type'=>$user_type,
            'qty'=>$pqty,
            'product_id'=>$products_id,
            'product_attr_id'=>$product_attr_id,
            'added_on'=>date('Y-m-d h:i:s'),
          ]);
          $msg ="Added";
        }

      $result=DB::table('cart')
      ->leftJoin('products','products.id','=','cart.product_id')
      ->leftJoin('products_attr','products_attr.id','=','cart.product_attr_id')
      ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
      ->leftJoin('colors','colors.id','=','products_attr.color_id')
      ->where(['user_id'=>$uid])
      ->where(['user_type'=>$user_type])
      ->select('cart.qty','products.id as pid','products.name','products.image','sizes.size','colors.color','products_attr.id as attr_id','products_attr.price','products.slug')
      ->get();
      

        return response()->json(['msg'=>$msg ,'data'=>$result, 'totalItem'=>count($result)]);
        


    }


    public function cart(Request $request){

      if($request->session()->has('FRONT_USER_LOGIN')){
        $uid =$request->session()->get('FRONT_USER_ID');
        $user_type="Reg";
      }else{
        $uid=getUserTempId();
        $user_type="Not-Reg";
      }

      $result['list'] =DB::table('cart')
      ->leftJoin('products','products.id','=','cart.product_id')
      ->leftJoin('products_attr','products_attr.id','=','cart.product_attr_id')
      ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
      ->leftJoin('colors','colors.id','=','products_attr.color_id')
      ->where(['user_id'=>$uid])
      ->where(['user_type'=>$user_type])
      ->select('cart.qty','products.id as pid','products.name','products.image','sizes.size','colors.color','products_attr.id as attr_id','products_attr.price','products.slug')
      ->get();
      
      return view('Front.cart',$result);
    }

    public function category(Request $request, $slug){

      // $result['home_categories']=DB::table('categories')
      // ->where(['category_slug'=>$slug])
      // ->where(['status'=>1])
      // ->where(['is_home'=>1])
      // ->get();

      // foreach($result['home_categories'] as $list){
      //   $result['home_categories_product'][$list->id]=DB::table('products')
      //   ->where(['status'=>1])
      //   ->where(['category_id'=>$list->id])
      //   ->get();

      //   foreach($result['home_categories_product'][$list->id] as $list1){
      //     $result['home_product_attr'][$list1->id]=DB::table('products_attr')
      //     ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
      //     ->leftJoin('colors','colors.id','=','products_attr.color_id')
      //     ->where(['products_attr.products_id'=>$list1->id])
      //     ->get();

      //   }

      // }

        $sort_txt="";
        $sort="";
        $filter_price_start="";
        $filter_price_end="";
        $filter_color ="";
        $colorFilterAttr=[];

      if($request->get('sort')!==null){
          $sort=$request->get('sort');
      }
    
      $query= DB::table('products');
      $query= $query->leftJoin('categories','categories.id','=','products.category_id');
      $query= $query->leftJoin('products_attr','products_attr.products_id','=','products.id');
      $query= $query->where(['products.status'=>1]);
      $query= $query->where(['categories.category_slug'=>$slug]);
      
      if($sort=='name'){
        $query=$query->orderBy('products.name','desc');
        $sort_txt="Product Name";
      }
      if($sort=='date'){
        $query=$query->orderBy('products.id','asc');
        $sort_txt="Date";
      }
      if($sort=='price_desc'){
        $query=$query->orderBy('products_attr.price','desc');
        $sort_txt="Price Desc";
      }
      if($sort=='price_asc'){
        $query=$query->orderBy('products_attr.price','asc');
        $sort_txt="Product Asc";
      }
      if($request->get('filter_price_start')!==null && $request->get('filter_price_end')!==null){
        $filter_price_start =$request->get('filter_price_start');
        $filter_price_end =$request->get('filter_price_end');

        if($filter_price_start>=0 && $filter_price_end>0){
          $query= $query->whereBetween('products_attr.price',[$filter_price_start,$filter_price_end]);
        }
      }

      if($request->get('filter_color')!==null){
        $filter_color=$request->get('filter_color');
        $colorFilterAttr = explode(":",$filter_color);
        $colorFilterAttr =array_filter($colorFilterAttr);
       
        $query =$query->where(['products_attr.color_id'=>$filter_color]);
      }
      $query= $query->distinct()->select('products.*');
      $query= $query->get();


      $result['product']=$query;


      foreach($result['product'] as $list1){
        $query1 =DB::table('products_attr');
        $query1 = $query1->leftJoin('sizes','sizes.id','=','products_attr.size_id');
        $query1 = $query1->leftJoin('colors','colors.id','=','products_attr.color_id');
        $query1 = $query1->where(['products_attr.products_id'=>$list1->id]);

        $query1=$query1->get();
        $result['product_attr'][$list1->id] =$query1;
      }

      $result['colors']=DB::table('colors')
      ->where(['status'=>1])
      ->get();
      

      $result['categories'] =DB::table('categories')
      ->where(['status'=>1])
      ->get();
      // prx($result['categories']);

      $result['slug'] = $slug;
      $result['sort'] = $sort;
      $result['sort_txt'] = $sort_txt;
      $result['filter_price_start'] = $filter_price_start;
      $result['filter_price_end'] = $filter_price_end;
      $result['filter_color'] = $filter_color;
      $result['colorFilterAttr']=$colorFilterAttr;
      

  
      // prx($result);      
      return view('Front.category',$result);
    }


    public function search(Request $request, $str){

      $result['product']=DB::table('products')
      ->where(['status'=>1])

      ->get();

      $query= DB::table('products');
      $query= $query->leftJoin('categories','categories.id','=','products.category_id');
      $query= $query->leftJoin('products_attr','products_attr.products_id','=','products.id');
      $query= $query->where(['products.status'=>1]);
      $query= $query->where('name','like',"%$str%");
      $query= $query->orwhere('model','like',"%$str%");
      $query= $query->orwhere('short_desc','like',"%$str%");
      $query= $query->orwhere('desc','like',"%$str%");
      $query= $query ->orwhere('keywords','like',"%$str%");
      $query= $query->orwhere('technical_specification','like',"%$str%");
      $query= $query->distinct()->select('products.*');
      $query= $query->get();


      $result['product']=$query;


      foreach($result['product'] as $list1){
        $query1 =DB::table('products_attr');
        $query1 = $query1->leftJoin('sizes','sizes.id','=','products_attr.size_id');
        $query1 = $query1->leftJoin('colors','colors.id','=','products_attr.color_id');
        $query1 = $query1->where(['products_attr.products_id'=>$list1->id]);

        $query1=$query1->get();
        $result['product_attr'][$list1->id] =$query1;
      }

      // prx($result);
      return view('Front.search',$result);

    // echo $str;

    }

    public function registration(Request $request){
        if($request->session()->has('FRONT_USER_LOGIN')){
          return redirect('/');
        }
        $result=[];
        return view('Front.registration',$result);
    }


    public function registration_process(Request $request){
      $valid =Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|email|unique:customers,email',
        'password'=>'required',
        'mobile'=>'required|numeric|digits:10',
      ]);

      if(!$valid->passes()){
        return response()->json(['status'=>'error','error'=>$valid->errors()->toArray()]);
      }else{

        $rand_id =rand(111111111 ,999999999);
        $arr=[
          'name'=>$request->name,
          'email'=>$request->email,
          'password'=>Crypt::encrypt($request->password),
          'mobile'=>$request->mobile,
          'status'=>1,
          'is_verify'=>0,
          'rand_id'=>$rand_id,
          'created_at'=>date("Y-m-d h:i:s"), 
          'updated_at'=>date("Y-m-d h:i:s"), 
        ];
        $query= DB::table('customers')->insert($arr);

        if($query){
          $data=['name'=>$request->name,'rand_id'=>$rand_id];
          $user['to']=$request->email;
          Mail::send('Front/email_verification',$data,function($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('Email Id Verification.');
          });
          return response()->json(['status'=>'success','msg'=>"Registration successfully.Please check your email id for verification."]);
        }
      }
    }


    public function login_process(Request $request){
      
        $result= DB::table('customers')
        ->where(['email'=>$request->str_login_email])
        ->get();

      if(isset($result[0])){
        $db_pwd =Crypt::decrypt($result[0]->password);
        $status =$result[0]->status;
        $is_verify=$result[0]->is_verify;

        if($is_verify==0){
          return response()->json(['status'=>"error",'msg'=>"Please verify your email id."]);
        }

        if($status==0){
          return response()->json(['status'=>"error",'msg'=>"Your account is deactivate."]);
        }

        if($db_pwd==$request->str_login_password){
          if($request->rememberme===null){
            setcookie("login_email",$request->str_login_email,100);
            setcookie("login_password",$request->str_login_password,100);
          }else{
              setcookie("login_email",$request->str_login_email,time()+60*60*24*100);
              setcookie("login_password",$request->str_login_password,time()+60*60*24*100);
          }
         
          $request->session()->put('FRONT_USER_LOGIN',true);
          $request->session()->put('FRONT_USER_ID',$result[0]->id);
          $request->session()->put('FRONT_USER_NAME',$result[0]->name);
            $status ="success";
            $msg =" ";

          $getUserTempId =getUserTempId();
          DB::table('cart')
          ->where(['user_id'=>$getUserTempId,'user_type'=>'Not-Reg'])
          ->update(['user_id'=>$result[0]->id,'user_type'=>'Reg']);
          
          
        }else{
            $status ="error";
            $msg ="Please enter valid password.";
        }
      }else{
        $status="error";
        $msg ="please enter valid email id.";
      }

        return response()->json(['status'=>$status,'msg'=>$msg]);


    }

    public function email_verification(Request $request,$id){
      $result =DB::table('customers')
          ->where(['rand_id'=>$id])
          ->where(['is_verify'=>0])
          ->get();
        if(isset($result[0])){
          DB::table('customers')
              ->where(['id'=>$result[0]->id])
              ->update(['is_verify'=>1,'rand_id'=>'']);
              return view('Front.verification');
        }else{
          return redirect('/');
        }
          
    }

    public function forgot_password(Request $request){

      // echo $request->$_POST;
      // die();
      $result =DB::table('customers')
        ->where(['email'=>$request->str_forgot_email])
        ->get();
        $rand_id =rand(111111111,999999999);
        if(isset($result[0])){
            DB::table('customers')
            ->where(['email'=>$request->str_forgot_email])
            ->update(['is_forgot_password'=>1, 'rand_id'=>$rand_id]);

            $data=['name'=>$result[0]->name,'rand_id'=>$rand_id];
            $user['to']=$request->str_forgot_email;
            Mail::send('Front/forgot_email',$data,function($message) use ($user){
              $message->to($user['to']);
              $message->subject('Forgot Password');
            });
            return response()->json(['status'=>'success','msg'=>'please check your email id for change password.']);
          }else{
            return response()->json(['status'=>'error','msg'=>'Email id not registered']);
        }

    }

    public function forgot_password_change(Request $request,$id){
      $result=DB::table('customers')
          ->where(['is_forgot_password'=>1])
          ->where(['rand_id'=>$id])
          ->get();

          if(isset($result[0])){
              $request->session()->put('FORGOT_PASSWORD_USER_ID', $result[0]->id);

            return view('Front.forgot_password_change');
          }else{
            return redirect('/');
          }
    }

    public function forgot_password_change_process(Request $request){

      $result =DB::table('customers')
          ->where(['id'=>$request->session()->get('FORGOT_PASSWORD_USER_ID')])
          ->update([
            'is_forgot_password'=>0,
            'rand_id'=>'',
            'password'=>Crypt::encrypt($request->password),

          ]);

          return response()->json(['status'=>'success','msg'=>'Password update successfully.']);
      
    }

    public function CheckOut(Request $request){
      $result['cart_item'] =getAddToCartTotalItem();
      // prx($result['cart_item']['0']);
      if(isset($result['cart_item'][0])){
        if($request->session()->has('FRONT_USER_LOGIN')){
          $uid =$request->session()->get('FRONT_USER_ID');
          $customer_info = DB::table('customers')
                          ->where(['id'=>$uid])
                          ->get();
                    // prx($customer_info);

          $result['customers']['name']= $customer_info[0]->name;
          $result['customers']['email']= $customer_info[0]->email;
          $result['customers']['mobile']= $customer_info[0]->mobile;
          $result['customers']['address']= $customer_info[0]->address;        
          $result['customers']['city']= $customer_info[0]->city;
          $result['customers']['state']= $customer_info[0]->state;
          $result['customers']['zip']= $customer_info[0]->zip;
        }else{
          $result['customers']['name']= '';
          $result['customers']['email']= '';
          $result['customers']['mobile']= '';
          $result['customers']['address']= '';        
          $result['customers']['city']= '';
          $result['customers']['state']= '';
          $result['customers']['zip']= '';
        }

        return view('Front.checkout',$result);
      }else{
        return redirect('/');
      }
    }

    public function apply_coupon_code(Request $request){
     $arr =apply_coupon_code($request->coupon_code);
     $arr =json_decode($arr,true);
     
     return response()->json(['status'=>$arr['status'],'msg'=>$arr['msg'],'totalprice'=>$arr['totalprice']]);
    }


    public function remove_coupon_code(Request $request){

      $result =DB::table('coupons')
              ->where(['code'=>$request->coupon_code])
              ->get();
    
        $getAddToCartTotalItem =getAddToCartTotalItem();
        $totalprice =0;
        foreach($getAddToCartTotalItem as $list){
          $totalprice =$totalprice+($list->qty*$list->price);
        }     
      return response()->json(['status'=>'success','msg'=>'Coupon code removed' ,'totalprice'=>$totalprice]);
    }

    public function place_order(Request $request){
      $payment_url ="";         
      $rand_id =rand(111111111 ,999999999);

      if($request->session()->has('FRONT_USER_LOGIN')){
        
      }else{
        $valid =Validator::make($request->all(),[
          'email'=>'required|email|unique:customers,email', 
        ]);
  
        if(!$valid->passes()){
          return response()->json(['status'=>'error','msg'=>"The email has already been taken."]);
        }else{

          $arr=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Crypt::encrypt($rand_id),
            // 'password'=>$rand_id1,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
            'city'=>$request->city,
            'state'=>$request->state,
            'zip'=>$request->zip,
            'status'=>1,
            'is_verify'=>1,
            'rand_id'=>$rand_id,
            'created_at'=>date("Y-m-d h:i:s"), 
            'updated_at'=>date("Y-m-d h:i:s"), 
          ];
          $user_id= DB::table('customers')->insertGetId($arr);
          $request->session()->put('FRONT_USER_LOGIN',true);
          $request->session()->put('FRONT_USER_ID',$user_id);
          $request->session()->put('FRONT_USER_NAME',$request->name);

          $data=['name'=>$request->name,'password'=>$rand_id];
          $user['to']=$request->email;
          Mail::send('Front/password_send',$data,function($message) use ($user){
            $message->to($user['to']);
            $message->subject('Forgot Password');
          });

          $getUserTempId =getUserTempId();
          DB::table('cart')
          ->where(['user_id'=>$getUserTempId,'user_type'=>'Not-Reg'])
          ->update(['user_id'=>$user_id,'user_type'=>'Reg']);

          
        }
      } 
        $coupon_value=0;
        if($request->coupon_code!=''){
          $arr =apply_coupon_code($request->coupon_code);
          $arr =json_decode($arr,true);
          if($arr['status']=='success'){
            $coupon_value=$arr['coupon_code_value'];
          }else{
              return response()->json(['status'=>'false','msg'=>$arr['msg']]);
          }
        }

        $uid =$request->session()->get('FRONT_USER_ID');

        $totalprice =0;
        $getAddToCartTotalItem =getAddToCartTotalItem();
        foreach($getAddToCartTotalItem as $list){
          $totalprice =$totalprice+($list->qty*$list->price);
          // $final_amt = $totalprice-$coupon_value;
        }
        $arr=[
          'customers_id'=> $uid,
          'name'=>$request->name,
          'email'=>$request->email,
          'mobile'=>$request->mobile,
          'address'=>$request->address,
          'city'=>$request->city,
          'state'=>$request->state,
          'pincode'=>$request->zip,
          'coupon_code'=>$request->coupon_code,
          'coupon_value'=>$coupon_value,
          'payment_type'=>$request->payment_type,
          'payment_status'=>"Pending",
          'total_amt'=>$totalprice,
          'order_status'=>1,
          'added_on'=>date("Y-m-d h:i:s"), 
        ];
        $order_id= DB::table('orders')->insertGetId($arr);

        if($order_id>0){
          $getAddToCartTotalItem =getAddToCartTotalItem();
          foreach($getAddToCartTotalItem as $list){
            $productDetailsArr['orders_id']=$order_id;
            $productDetailsArr['product_id']=$list->pid;
            $productDetailsArr['products_attr_id']=$list->attr_id;
            $productDetailsArr['price']=$list->price;
            $productDetailsArr['qty']=$list->qty;
            DB::table('orders_details')->insert($productDetailsArr);
          }

            if($request->payment_type=='Gateway'){
              $final_amt = $totalprice-$coupon_value;
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
              curl_setopt($ch, CURLOPT_HEADER, FALSE);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
              curl_setopt($ch, CURLOPT_HTTPHEADER,
                          array("X-Api-Key:test_a4be5327ccc29994ee9256deb3b",
                                "X-Auth-Token:test_8250d6bc3b1536f92057dcb2f30"));
              $payload = Array(
                  'purpose' => 'Buy Product',
                  'amount' => $final_amt,
                  'phone' => $request->mobile,
                  'buyer_name' => $request->name,
                  'redirect_url' => 'http://127.0.0.1:8000/instamojo_payment_redirect',
                  'send_email' => true,
                  'send_sms' => true,
                  'email' => $request->email,
                  'allow_repeated_payments' => false,
              );
              curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
              $response = curl_exec($ch);
              curl_close($ch);
              $response=json_decode($response);

              // prx($response->payment_request->id);
              if(isset($response->payment_request->id)){

                  $tnx_id=$response->payment_request->id;
                  DB::table('orders')
                  ->where(['id'=>$order_id])
                  ->update(['txn_id'=>$tnx_id]);   
                  $payment_url=$response->payment_request->longurl;
              }else{
                  $msg="";
                  foreach($response->message as $key=>$val){
                    $msg.=strtoupper($key).": ".$val[0].'<br/>';
                  }
                  return response()->json(['status'=>'error' ,'msg'=>$msg ,'payment_url'=>'']);
              }

              

            }
          
          DB::table('cart')
          ->where(['user_id'=>$uid,'user_type'=>'Reg'])
          ->delete();
  
          $request->session()->put('ORDER_ID',$order_id);

            $status ="success";
            $msg ="Order placed.";

        }else{
            $status ="false";
            $msg ="Please try after sometimes.";
        }
      // }else{
      //   $status ="false";
      //   $msg ="Please login to place order.";
      // }

      return response()->json(['status'=>$status ,'msg'=>$msg ,'payment_url'=>$payment_url]);
    }

    public function order_placed(Request $request){

      if($request->session()->has('ORDER_ID')){
        return view('Front.order_placed');
      }else{
        return redirect('/');
      }
    }

    public function order_fail(Request $request){

      if($request->session()->has('ORDER_ID')){
        return view('Front.order_fail');
      }else{
        return redirect('/');
      }
    }
    
 
    public function instamojo_payment_redirect(Request $request){
      
        if($request->get('payment_id')!==null && $request->get('payment_status')!==null && $request->get('payment_request_id')!==null){
          if($request->get('payment_status')=='Credit'){
              $status = 'Success';
              $redirect_url='/order_placed';
          }else{
              $status = 'Fail';
              $redirect_url='/order_fail';
          }
          $request->session()->put('ORDER_STATUS',$status);
          DB::table('orders')
          ->where(['txn_id'=>$request->get('payment_request_id')])
          ->update(['payment_id'=>$request->get('payment_id'),'payment_status'=>$status]);
          return redirect($redirect_url);
          
        }else{
          die('Something want wrong');
        }
    }
    
    public function order(Request $request){

        $result['orders']= DB::table('orders')
        ->select('orders.*','orders_status.orders_status')
        ->leftJoin('orders_status','orders_status.id','=','orders.order_status')
        ->where(['orders.customers_id'=>$request->session()->get('FRONT_USER_ID')])
        ->get();
      
      return view('Front.order',$result);
    }

    public function order_detail(Request $request, $id){

      $result['order_details']=DB::table('orders_details')
        ->select('orders.*','orders_details.price','orders_details.qty','products.name as pname','products_attr.attr_image','colors.color','sizes.size','orders_status.orders_status')
        ->leftJoin('orders','orders.id','=','orders_details.orders_id')
        ->leftJoin('products_attr','products_attr.id','=','orders_details.products_attr_id')
        ->leftJoin('products','products.id','=','products_attr.products_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('orders_status','orders_status.id','=','orders.order_status')
        ->where(['orders.id'=>$id])
        ->where(['orders.customers_id'=>$request->session()->get('FRONT_USER_ID')])
        ->get();
      if(!isset($result['order_details'][0])){
        return redirect('/');
      }
    // prx();
     return view('Front.order_detail',$result);
    }

    public function product_review_process(Request $request){

        if($request->session()->has('FRONT_USER_LOGIN')){
          $uid=$request->session()->get('FRONT_USER_ID');
          $arr=[
            'rating'=>$request->rating,
            'review'=>$request->review,
            'products_id'=>$request->product_id,
            'status'=>1,
            'customer_id'=>$uid,
            'added_on'=>date('Y-m-d h:i:s'),
          ];
          $query=DB::table('product_review')->insert($arr);
          $status ='success';
          $msg ='Thank you for providing your review.';
        }else{
          $status ='error';
          $msg ='Please log in then submit review.';
        }
        return response()->json(['status'=>$status ,'msg'=>$msg]);
      // prx($_POST);
    }


    
}







