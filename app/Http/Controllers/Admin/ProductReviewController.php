<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function product_review(Request $request){
        $result['products_review']=DB::table('product_review')
            ->leftJoin('customers','customers.id','=','product_review.customer_id')
            ->leftJoin('products','products.id','=','product_review.products_id')
            ->orderBy('product_review.id','desc')
            ->select('product_review.id','product_review.rating','product_review.review','product_review.status','product_review.added_on','customers.name','products.name as pname')
            ->get();

        // prx($result['products_review']);
        return view('admin.review.product_review',$result);
    }

    public function status(Request $request, $status ,$id){
        DB::table('product_review')
            ->where(['id'=>$id])
            ->update(['status'=>$status]);

          return redirect('/admin/product_review');  
    }
}
