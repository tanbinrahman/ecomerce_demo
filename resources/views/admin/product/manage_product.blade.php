@extends('admin/layout')
@section('title_name','Manage Product');
@section('product_select','active');
@section('container')

@if($id>0)
    @php
      $image_required ="";
    @endphp    
@else
    @php
      $image_required ="required";
    @endphp
@endif

   
    @if(Session::has('sku_error'))
                              
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
             {{Session::get('sku_error')}}
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">×</span>
             </button>
        </div>
    @endif 

    @error('attr_image.*')
                              
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            {{$message}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
            </div>
    @enderror 
    @error('images.*')
                              
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            {{$message}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        </div>
    @enderror
    
    <h1 class="mb10">Manage Product</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.product')}}">
        <button type="button" class="btn btn-success"> Product </button>
    </a>
    <script src="{{asset('asset/ckeditor.js')}}"></script>
<div class="row m-t-30">
  <div class="col-md-12">

                    <form action="{{route('product.manage_product_process')}}" method="post" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-lg-12">

                                <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        
                                            @csrf
                                            <div class="form-group">
                                                <label for="name" class="control-label mb-1">Name</label>
                                                <input id="name" name="name" value="{{$name}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('name')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="slug" class="control-label mb-1">Slug </label>
                                                <input id="slug" name="slug" value="{{$slug}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('slug')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="image" class="control-label mb-1">Image </label>
                                                <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}} >
                                                @if($image!='')
                                                    <a href="{{asset('storage/media/'.$image)}}" target="_blank">
                                                        <img width="50px" height="50px" src="{{asset('storage/media/'.$image)}}" alt="">
                                                    </a>
                                                @endif
                                            </div>
                                            @error('image')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                      <label for="category_id" class="control-label mb-1">Category Id </label>
                                               
                                                        <select id="category_id" name="category_id" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                            <option value="">Select Categories</option>
                                                            @foreach($categorys as $category)
                                                                @if($category_id==$category->id)
                                                                    <option selected value="{{$category->id}}">
                                                                @else
                                                                    <option value="{{$category->id}}">
                                                                @endif
                                                                    {{$category->category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                        <div class="alert alert-danger">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="brand" class="control-label mb-1">Brand </label>
                                                        <select id="brand" name="brand" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                            <option value="">Select Brand</option>
                                                            @foreach($brands as $brad)
                                                                @if($brand==$brad->id)
                                                                    <option selected value="{{$brad->id}}">
                                                                @else
                                                                    <option value="{{$brad->id}}">
                                                                @endif
                                                                    {{$brad->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('brand')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="model" class="control-label mb-1">Model </label>
                                                        <input id="model" name="model" value="{{$model}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                        @error('model')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                             
                                            </div>
                                           
                                           
                                            <div class="form-group">
                                                <label for="short_desc" class="control-label mb-1">Short Description </label>
                                                
                                                <textarea name="short_desc"  id="short_desc"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>{{$short_desc}}</textarea>
                                            </div>
                                            @error('short_desc')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="desc" class="control-label mb-1">Description </label>
                                                
                                                <textarea name="desc"  id="desc"   type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required> {{$desc}}</textarea>
                                            </div>
                                            @error('desc')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="keywords" class="control-label mb-1">Keywords </label>
                                                
                                                <textarea name="keywords"  id="keywords"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required> {{$keywords}} </textarea>
                                            </div>
                                            @error('keywords')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="technical_specification" class="control-label mb-1">Technical Specification </label>
                                                
                                                <textarea name="technical_specification" id="technical_specification"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>{{$technical_specification}} </textarea>
                                            </div>
                                            @error('technical_specification')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="uses" class="control-label mb-1">Uses </label>
                                                
                                                <textarea name="uses" id="uses"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>{{$uses}} </textarea>
                                            </div>
                                            @error('user')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="warranty" class="control-label mb-1">Warranty </label>
                                                
                                                <textarea name="warranty" id="warranty"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>{{$warranty}}</textarea>
                                            </div>
                                            @error('warranty')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="lead_time" class="control-label mb-1">Lead Time </label>
                                                        <input id="lead_time" name="lead_time" value="{{$lead_time}}" type="text" class="form-control" aria-required="true" aria-invalid="false" >          

                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="tax_id" class="control-label mb-1">Tax ID </label>
                                                        <select id="tax_id" name="tax_id" class="form-control" aria-required="true" aria-invalid="false">
                                                            <option value="">Select Tax</option>
                                                            @foreach($taxs as $tax)
                                                                @if($tax_id==$tax->id)
                                                                    <option selected value="{{$tax->id}}">
                                                                @else
                                                                    <option value="{{$tax->id}}">
                                                                @endif
                                                                    {{$tax->tax_desc}}</option>
                                                            @endforeach
                                                        </select>        

                                                    </div>

                                                </div>  
                                            </div>   
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="is_promo" class="control-label mb-1">Is Promo </label>
                                                        <select id="is_promo" name="is_promo"  class="form-control"  required>
                                                            @if($is_promo=='1')
                                                                <option selected value="1">Yes</option>
                                                                <option value="0">No</option>
                                                            @else 
                                                                <option  value="1">Yes</option>
                                                                <option selected value="0">No</option>
                                                            @endif 
                                                        </select>    
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="is_featured" class="control-label mb-1">Is Featured</label>
                                                        <select id="is_featured" name="is_featured"  class="form-control"  required>
                                                           @if($is_featured=='1')
                                                                <option selected value="1">Yes</option>
                                                                <option value="0">No</option>
                                                           @else 
                                                                <option  value="1">Yes</option>
                                                                <option selected value="0">No</option>
                                                            @endif    
                                                        </select> 

                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <label for="is_discount" class="control-label mb-1">Is Discount </label>
                                                        <select id="is_discount" name="is_discount"  class="form-control"  required>
                                                            @if($is_discount=='1')
                                                                <option selected value="1">Yes</option>
                                                                <option value="0">No</option>
                                                            @else 
                                                                <option  value="1">Yes</option>
                                                                <option selected value="0">No</option>
                                                            @endif
                                                        </select> 

                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="is_tranding" class="control-label mb-1">Is Tranding </label>
                                                        <select id="is_tranding" name="is_tranding"  class="form-control"  required>
                                                            @if($is_tranding=='1')
                                                                <option selected value="1">Yes</option>
                                                                <option value="0">No</option>
                                                            @else 
                                                                <option  value="1">Yes</option>
                                                                <option selected value="0">No</option>
                                                            @endif
                                                        </select> 

                                                    </div>

                                                </div>  
                                            </div>
                                    </div>
                                </div>
                            </div> 
                            <h2 class="mb10" >Product Image</h2>
                            <div class="col-lg-12" > 
                                
                                <div class="card">  
                                    <div class="card-body">
                                            <div class="form-group">
                                                <div class="row" id="product_image_box" >
                                                    @php
                                                        $loop_count_num =1;
                                                    @endphp
                                                    @foreach($productImagesArr as $key=>$val)
                                                    
                                                    @php
                                                        $loop_count_prev =$loop_count_num;
                                                        $pIArr =(array)$val;
                                                       
                                                    @endphp
                                                    <input id="piid" type="hidden" name="piid[]" value="{{$pIArr['id']}}" >
                                                    <div class="col-md-4 product_images_{{$loop_count_num++}}">
                                                        <label for="images" class="control-label mb-1"> Image </label>
                                                        <input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}}>
                                                            @if($pIArr['images']!='')
                                                            <a href="{{asset('storage/media/'.$pIArr['images'])}}" target="_blank">
                                                            <img width="50px" height="50px" src="{{asset('storage/media/'.$pIArr['images'])}}" alt="">
                                                            </a> 
                                                            @endif
                                                        @error('images')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                    <label for="images" class="control-label mb-1">&nbsp; &nbsp; &nbsp; </label>
                                                    @if($loop_count_num==2)
                                                        <button type="button" class="btn btn-success btn-lg" onclick="add_image_more()">
                                                            <i class="fa fa-plus">&nbsp; ADD</i>
                                                        </button>
                                                    @else
                                                        <a href="{{url('admin/product/product_images_delete/')}}/{{$pIArr['id']}}/{{$id}}">
                                                        <button type="button" class="btn btn-danger btn-lg">
                                                            <i class="fa fa-minus">&nbsp; Remove</i>
                                                        </button>
                                                        </a>
                                                    @endif    
                                                    </div>
                                                  @endforeach
                                                </div>
                                                
                                            </div>
                                     
                                    </div>  
                                </div>
                                
                            </div>  
                            <h2 class="mb10" >Product Attributes</h2>
                            <div class="col-lg-12" id="product_attr_box"> 
                                <?php
                                    $loop_count_num =1;
                                ?>
                                @foreach($productAttrArr as $key=>$val)
                                  
                                  <?php
                                      $loop_count_prev =$loop_count_num;
                                      $pAArr =(array)$val;
                                      // echo '<pre>';
                                      // print_r($pAArr);
                                  ?>
                                  <input id="paid" type="hidden" name="paid[]" value="{{$pAArr['id']}}" >
                                <div class="card" id="product_attr_{{$loop_count_num++}}">  
                                    <div class="card-body">
                                            <div class="form-group">
                                                <div class="row">
                                                   
                                                    <div class="col-md-2">
                                                        <label for="sku" class="control-label mb-1">SKU </label>
                                                        <input id="sku" name="sku[]" value="{{$pAArr['sku']}}"  type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                        @error('sku')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="mrp" class="control-label mb-1">MRP </label>
                                                        <input id="mrp" name="mrp[]" value="{{$pAArr['mrp']}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                        @error('mrp')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="price" class="control-label mb-1">Price </label>
                                                        <input id="price" name="price[]" value="{{$pAArr['price']}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                        @error('price')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-3">
                                                      <label for="size_id" class="control-label mb-1">Size </label>
                                               
                                                        <select id="size_id" name="size_id[]" type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                                            <option value="">Select Size</option>
                                                            @foreach($sizes as $size)
                                                               @if($pAArr['size_id']==$size->id)
                                                                    <option selected value="{{$size->id}}"> {{$size->size}}</option>
                                                               @else
                                                                    <option  value="{{$size->id}}"> {{$size->size}}</option>
                                                               @endif
                                                                
                                                            @endforeach
                                                        </select>
                                                        @error('size_id')
                                                        <div class="alert alert-danger">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                      <label for="color_id" class="control-label mb-1">Color </label>
                                               
                                                        <select id="color_id" name="color_id[]" type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                                            <option value="">Select Color</option>
                                                            @foreach($colors as $color)
                                                               @if($pAArr['color_id']==$color->id)
                                                                <option selected value="{{$color->id}}"> {{$color->color}}</option>
                                                               @else 
                                                                <option  value="{{$color->id}}"> {{$color->color}}</option>
                                                               @endif 
                                                            @endforeach
                                                        </select>
                                                        @error('color_id')
                                                        <div class="alert alert-danger">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="attr_image" class="control-label mb-1">Attr Image </label>
                                                        <input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" >
                                                            @if($pAArr['attr_image']!='')
                                                            <a href="{{asset('storage/media/'.$pAArr['attr_image'])}}" target="_blank">
                                                                <img width="50px" height="50px" src="{{asset('storage/media/'.$pAArr['attr_image'])}}" alt="">
                                                            </a>
                                                            @endif
                                                        @error('attr_image')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="qty" class="control-label mb-1">QTY </label>
                                                        <input id="qty" name="qty[]" value="{{$pAArr['qty']}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                        @error('qty')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                    <label for="" class="control-label mb-1">&nbsp; &nbsp; &nbsp; </label>
                                                    @if($loop_count_num==2)
                                                        <button type="button" class="btn btn-success btn-lg" onclick="add_more()">
                                                            <i class="fa fa-plus">&nbsp; ADD</i>
                                                        </button>
                                                    @else
                                                        <a href="{{url('admin/product/product_attr_delete/')}}/{{$pAArr['id']}}/{{$id}}">
                                                        <button type="button" class="btn btn-danger btn-lg">
                                                            <i class="fa fa-minus">&nbsp; Remove</i>
                                                        </button>
                                                        </a>
                                                    @endif    
                                                    </div>

                                                </div>
                                             
                                            </div>
                                     
                                    </div>  
                                </div>
                                @endforeach
                            </div>       
                            
                        </div>
                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                Submit
                            </button>
                        </div>
                        <input type="hidden" name="id" value="{{$id}}"/>
                    </form>                           
                               
    </div>                       
</div>   
<script>

    var loop_count =1;

    function add_more(){
        loop_count++;
       
        var html='<input id="paid" type="hidden" name="paid[]"><div class="card" id="product_attr_'+loop_count+'"><div class="card-body"><div class="form-group"><div class="row">';

        html+='<div class="col-md-2"><label for="sku" class="control-label mb-1">SKU </label><input id="sku" name="sku[]"  type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';

        html+='<div class="col-md-2"><label for="mrp" class="control-label mb-1">MRP </label><input id="mrp" name="mrp[]"  type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';

        html+='<div class="col-md-2"><label for="price" class="control-label mb-1">Price </label><input id="price" name="price[]"  type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';

        var size_id_html =jQuery('#size_id').html();
        size_id_html =size_id_html.replace("selected" ,"")
        html+='<div class="col-md-3"><label for="size_id" class="control-label mb-1">Size </label><select id="size_id" name="size_id[]" type="text" class="form-control" aria-required="true" aria-invalid="false" >'+size_id_html+'</select></div>';


        var color_id_html =jQuery('#color_id').html();
        color_id_html=color_id_html.replace("selected","")
        html+='<div class="col-md-3"><label for="color_id" class="control-label mb-1">Color </label><select id="color_id" name="color_id[]" type="text" class="form-control" aria-required="true" aria-invalid="false" >'+color_id_html+'</select></div>';
        html+='<div class="col-md-4"><label for="attr_image" class="control-label mb-1">Attr Image </label><input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" ></div>';

        html+='<div class="col-md-2"><label for="qty" class="control-label mb-1">QTY </label><input id="qty" name="qty[]"  type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';

        html+='<div class="col-md-2"><label for="" class="control-label mb-1">&nbsp; &nbsp; &nbsp; </label><button type="button" class="btn btn-danger btn-lg" onclick=remove_more("'+loop_count+'")><i class="fa fa-minus">&nbsp; REMOVE</i></button></div>'

        html+='</div></div></div></div>';
        jQuery('#product_attr_box').append(html)
    }

    function remove_more(loop_count){
        jQuery('#product_attr_'+loop_count).remove();
    }

    var loop_image_count =1;    
    function add_image_more(){
        loop_image_count++;
        var html='<input id="piid" type="hidden" name="piid[]" value=""><div class="col-md-4 product_images_'+loop_image_count+'"><label for="images" class="control-label mb-1"> Image </label><input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}}></div>';

        html+='<div class="col-md-2 product_images_'+loop_image_count+'""><label for="images" class="control-label mb-1">&nbsp; &nbsp; &nbsp; </label><button type="button" class="btn btn-danger btn-lg" onclick=remove_image_more("'+loop_image_count+'")><i class="fa fa-minus"></i>&nbsp; REMOVE</button></div>'

        jQuery('#product_image_box').append(html)
    }

    function remove_image_more(loop_image_count){
        jQuery('.product_images_'+loop_image_count).remove();
    }

    CKEDITOR.replace('short_desc');
    CKEDITOR.replace('desc');
    CKEDITOR.replace('technical_specification');
    
</script>
@endsection

