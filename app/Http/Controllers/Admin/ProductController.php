<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products =Product::get();
       return view('admin.product.product',compact('products'));
    }

    // public function manage_product(){

    //     $categories =DB::table('categories')->where(['status'=>1])->get();

    //     // echo '<pre>';
    //     // print_r($categories);
    //     // die();
    //     return view('admin.product.manage_product',compact('categories'));
    // }

    
    public function manage_product(Request $request, $id ='')
    {
        if($id>0){
            
            $arr =Product::where(['id'=>$id])->get();

            $result['category_id'] =$arr['0']->category_id ;
            $result['name'] =$arr['0']->name ;
            $result['slug'] =$arr['0']->slug ;
            $result['image'] =$arr['0']->image ;
            $result['brand'] =$arr['0']->brand ;
            $result['model'] =$arr['0']->model ;
            $result['short_desc'] =$arr['0']->short_desc ;
            $result['desc'] =$arr['0']->desc ;
            $result['keywords'] =$arr['0']->keywords ;
            $result['technical_specification'] =$arr['0']->technical_specification ;
            $result['uses'] =$arr['0']->uses ;
            $result['warranty'] =$arr['0']->warranty ;
            $result['lead_time'] =$arr['0']->lead_time ;
            $result['tax_id'] =$arr['0']->tax_id ;
            $result['is_promo'] =$arr['0']->is_promo ;
            $result['is_featured'] =$arr['0']->is_featured ;
            $result['is_discount'] =$arr['0']->is_discount ;
            $result['is_tranding'] =$arr['0']->is_tranding ;
            $result['status'] =$arr['0']->status ;
            $result['id']= $arr['0']->id;

            $result['productAttrArr']=DB::table('products_attr')->where(['products_id'=>$id])->get();

            $productImagesArr =DB::table('product_images')->where(['products_id'=>$id])->get();

            if(!isset($productImagesArr[0])){
                $result['productImagesArr']['0']['id']='';
                $result['productImagesArr']['0']['images']='';
            }else{
                $result['productImagesArr']=$productImagesArr;
            }
            // echo '<pre>';
            // print_r($result);
            // die();
        }else{
            $result['category_id']='';
            $result['name']='';
            $result['slug']='';
            $result['image']='';
            $result['brand']='';
            $result['model']='';
            $result['short_desc']='';
            $result['desc']='';
            $result['keywords']='';
            $result['technical_specification']='';
            $result['uses']='';
            $result['warranty']='';
            $result['lead_time']='';
            $result['tax_id']='';
            $result['is_promo']='';
            $result['is_featured']='';
            $result['is_discount']='';
            $result['is_tranding']='';
            $result['status']='';
            $result['id']=0;

            $result['productAttrArr'][0]['id'] ='';
            $result['productAttrArr'][0]['products_id'] ='';
            $result['productAttrArr'][0]['sku'] ='';
            $result['productAttrArr'][0]['attr_image'] ='';
            $result['productAttrArr'][0]['mrp'] ='';
            $result['productAttrArr'][0]['price'] ='';
            $result['productAttrArr'][0]['qty'] ='';
            $result['productAttrArr'][0]['size_id'] ='';
            $result['productAttrArr'][0]['color_id'] ='';

            $result['productImagesArr']['0']['id'] ='';
            $result['productImagesArr']['0']['images'] ='';
            
            // echo '<pre>';
            // print_r($result['productAttrArr']);
            // die();
        }

            // echo '<pre>';
            // print_r($result);
            // die();

        $result['categorys']= DB::table('categories')->where(['status'=>1])->get();
        $result['sizes']= DB::table('sizes')->where(['status'=>1])->get();
        $result['colors']=DB::table('colors')->where(['status'=>1])->get();
        $result['brands']=DB::table('brands')->where(['status'=>1])->get();
        $result['taxs']=DB::table('taxes')->where(['status'=>1])->get();
        
        
        // echo '<pre>';
        // print_r($result['category']);
        // die();
        return view('admin.product.manage_product',$result);
    }


    public function manage_product_process(Request $request){
        // echo "<pre>";
        // print_r($request->post());
        // die();
        // return $request->post();
        if($request->post('id')>0){
            $image_validation ="mimes:jpg,jpeg,png";
        }else{
            $image_validation ="required|mimes:jpg,jpeg,png";
        }
        $request->validate([
            'name' =>'required',
            'image' => $image_validation,
            'slug' =>'required|unique:products,slug,'.$request->post('id') ,
            'attr_image.*'=>'mimes:jpg,jpeg,png',
            'images.*'=>'mimes:jpg,jpeg,png'
        ]);

        // product attr validation start
        $paidArr= $request->post('paid');
        $skuArr= $request->post('sku');
        $mrpArr= $request->post('mrp');
        $priceArr= $request->post('price');
        $qtyArr= $request->post('qty');
        $size_idArr= $request->post('size_id');
        $color_idArr= $request->post('color_id');
        
       
        
        foreach($skuArr  as $key=>$val){
            $check =DB::table('products_attr')->
            where('sku','=',$skuArr[$key])->
            where('id','!=',$paidArr[$key])->get();

            if(isset($check[0])){
                $request->session()->flash('sku_error',$skuArr[$key].' SKU already used');

                return redirect(request()->headers->get('referer'));
            }
        }  

        // product attr validation end
        if($request->post('id')>0){
            $products =Product::find($request->post('id'));
            $msg ='Product update successfully';
        }else{
            $products =new Product();
            $msg ='Product insert successfully' ;
        }
        
        if($request->hasfile('image')){
            if($request->post('id')>0){
            $arrImage = DB::table('products')->where(['id'=>$request->post('id')])->get();
            if(Storage::exists('/public/media/'.$arrImage[0]->image)){
                Storage::delete('/public/media/'.$arrImage[0]->image);
            }
        }
            $image =$request->file('image');
            $ext =$image->extension();
            $image_name =time().'.'.$ext;
            $image->storeAs('/public/media',$image_name);
            $products->image=$image_name;
           
        }    

        $products->category_id = $request->post('category_id');
        $products->name = $request->post('name');
        $products->slug = $request->post('slug');
        $products->brand = $request->post('brand');
        $products->model = $request->post('model');
        $products->short_desc = $request->post('short_desc');
        $products->desc = $request->post('desc');
        $products->keywords = $request->post('keywords');
        $products->technical_specification = $request->post('technical_specification');
        $products->uses = $request->post('uses');
        $products->warranty = $request->post('warranty');
        $products->lead_time = $request->post('lead_time');
        $products->tax_id = $request->post('tax_id');
        $products->is_promo = $request->post('is_promo');
        $products->is_featured = $request->post('is_featured');
        $products->is_discount = $request->post('is_discount');
        $products->is_tranding = $request->post('is_tranding');
        $products->status =1;
        $products->save();
        $pid =$products->id;

 
        // product attr start
        foreach($skuArr  as $key=>$val){
            $productAttrArr =[];
            $productAttrArr['products_id']=$pid;
            $productAttrArr['sku']=$skuArr[$key];
            $productAttrArr['mrp']=(int)$mrpArr[$key];
            $productAttrArr['price']=(int)$priceArr[$key];
            $productAttrArr['qty']=(int)$qtyArr[$key];
            if($size_idArr[$key]==''){
                $productAttrArr['size_id']=0;
            }else{
                $productAttrArr['size_id']=$size_idArr[$key];
            }

            if($color_idArr[$key]==''){
                $productAttrArr['color_id']=0;
            }else{
                $productAttrArr['color_id'] = $color_idArr[$key];
            }
            if($request->hasFile("attr_image.$key")){
                if($paidArr[$key]!=''){
                    $arrImage = DB::table('products_attr')->where(['id'=>$paidArr[$key]])->get();
                    if(Storage::exists('/public/media/'.$arrImage[0]->attr_image)){
                        Storage::delete('/public/media/'.$arrImage[0]->attr_image);
                    }
                }    
                $rand =rand('111111111','999999999');
                $attr_image =$request->file("attr_image.$key");
                $ext = $attr_image->extension();
                $image_name =$rand.'.'.$ext;
                $request->file("attr_image.$key")->storeAs('/public/media',$image_name);
                $productAttrArr['attr_image'] =$image_name;
            } 
           
            if($paidArr[$key]!=''){
                DB::table('products_attr')->where(['id'=>$paidArr[$key]])->update($productAttrArr);
            }else{
                DB::table('products_attr')->insert($productAttrArr);
            }

           
        }

        // product arrt end

        // Product Image start
        
        $piidArr =$request->post('piid');
       
        foreach($piidArr as $key=>$val){
            $productImagesArr['products_id']=$pid;
            if($request->hasFile("images.$key")){
                if($piidArr[$key]!=''){
                    $arrImage = DB::table('product_images')->where(['id'=>$piidArr[$key]])->get();
                    if(Storage::exists('/public/media/'.$arrImage[0]->images)){
                        Storage::delete('/public/media/'.$arrImage[0]->images);
                    }
                }
                $rand =rand('111111111','999999999');
                $images =$request->file("images.$key");
                $ext =$images->extension();
                $image_name =$rand.'.'.$ext;
                $request->file("images.$key")->storeAs('/public/media',$image_name);

                $productImagesArr['images']=$image_name;
            }
            if($piidArr[$key]!=''){
                DB::table('product_images')->where(['id'=>$piidArr[$key]])->update($productImagesArr);
            }else{
                DB::table('product_images')->insert($productImagesArr);
            }

        }
        // echo "<pre>";
        // print_r($productImagesArr['images']);
        // die();

        

        // product image end

        Session::flash('message',$msg);
        return redirect('admin/product');

    }

    // public function manage_product_process(Request $request ){

    //     $request->validate([
    //         'name'=>'required',
    //         'image'=>'mimes:jpeg,jpg,png',
    //         'slug'=>'required|unique:products',
    //     ]);

    //     $products =new Product();

    //     if($request->hasfile('image')){
    //         $image =$request->file('image');
    //         $ext =$image->extension();
    //         $image_name =time().'.'.$ext;
    //         $image->storeAs('/public/media',$image_name);
    //         $products->image=$image_name;
    //     }

    //     $products->name = $request->post('name');
    //     $products->slug = $request->post('slug');
    //     $products->category_id = $request->post('category_id');
    //     // $products->image = $request->post('image');
    //     $products->brand = $request->post('brand');
    //     $products->model = $request->post('model');
    //     $products->short_desc = $request->post('short_desc');
    //     $products->desc = $request->post('desc');
    //     $products->keywords = $request->post('keywords');
    //     $products->technical_specification = $request->post('technical_specification');
    //     $products->uses = $request->post('uses');
    //     $products->warranty = $request->post('warranty');
    //     $products->status =1;
    //     $products->save();

    //     Session::flash('message','Product data insert successfully');
    //     return redirect('admin/product');


    // }

    // public function edit($id){
    //     $product =Product::findOrFail($id);
    //     $categories =DB::table('categories')->where(['status'=>1])->get();
    //     return view('admin.product.productEdit',compact('product','categories'));
    // }

    // public function update(Request $request, $id){
    //     $request->validate([
    //         'name'=>'required',
    //         'image'=>'mimes:jpeg,jpg,png',
    //         'slug'=>'required|unique:products,slug,'.$id,
    //     ]);



    //     $product =Product::findOrFail($id);

    //     if($request->hasfile('image')){
    //         $image =$request->file('image');
    //         $ext =$image->extension();
    //         $image_name =time().'.'.$ext;
    //         $image->storeAs('/public/media',$image_name);
    //         $product->image=$image_name;
    //     }

    //     $product->name = $request->post('name');
    //     $product->slug = $request->post('slug');
    //     $product->category_id = $request->post('category_id');
    //     // $product->image = $request->post('image');
    //     $product->brand = $request->post('brand');
    //     $product->model = $request->post('model');
    //     $product->short_desc = $request->post('short_desc');
    //     $product->desc = $request->post('desc');
    //     $product->keywords = $request->post('keywords');
    //     $product->technical_specification = $request->post('technical_specification');
    //     $product->uses = $request->post('uses');
    //     $product->warranty = $request->post('warranty');
        
    //     $product->save();

    //     Session::flash('message','Product data update successfully');
    //     return redirect('admin/product');
    // }

    public function delete(Request $request,$id){
        $product =Product::findOrFail($id);
        $product->delete();

        Session::flash('message','Product data delete successfully.');
        return redirect('admin/product');
    }

    public function product_attr_delete(Request $request,$paid ,$pid){

        $arrImage = DB::table('products_attr')->where(['id'=>$paid])->get();
        if(Storage::exists('/public/media/'.$arrImage[0]->attr_image)){
            Storage::delete('/public/media/'.$arrImage[0]->attr_image);
        }

        DB::table('products_attr')->where(['id'=>$paid])->delete();
        return redirect('admin/product/manage_product/'.$pid);
    }

    public function product_images_delete(Request $request,$paid ,$pid){

        $arrImage = DB::table('product_images')->where(['id'=>$paid])->get();
        // echo '<pre>';
        // print_r($arrImage[0]->images);
        // die();
        if(Storage::exists('/public/media/'.$arrImage[0]->images)){
            Storage::delete('/public/media/'.$arrImage[0]->images);
        }
        

        DB::table('product_images')->where(['id'=>$paid])->delete();
        return redirect('admin/product/manage_product/'.$pid);
    }
    


    public function status(Request $request ,$status ,$id){

        $product =Product::findOrFail($id);
        $product->status =$status;
        $product->save();

        Session::flash('message','Product status update successfully');
        return redirect('admin/product'); 
    
    }
}
