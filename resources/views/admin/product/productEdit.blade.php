@extends('admin/layout')
@section('title_name','Manage Product');
@section('product_select','active');
@section('container')

    <h1 class="mb10">Edit Product</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.product')}}">
        <button type="button" class="btn btn-success"> Product </button>
    </a>

<div class="row m-t-30">
  <div class="col-md-12">
    
                                 <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        <form action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data" >
                                            @csrf
                                            <div class="form-group">
                                                <label for="name" class="control-label mb-1">Name</label>
                                                <input id="name" name="name" value="{{$product->name}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('name')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="slug" class="control-label mb-1">Slug </label>
                                                <input id="slug" name="slug" value="{{$product->slug}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('slug')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="image" class="control-label mb-1">Image </label>
                                                <input id="image" name="image"  type="file" class="form-control" aria-required="true" aria-invalid="false" >
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
                                                                @foreach($categories as $category)
                                                                    <!-- <option value="{{$category->id}}">{{$category->category_name}}</option> -->
                                                                @if($product->category_id == $category->id)
                                                                    <option selected value="{{$category->id}}">
                                                                @else  
                                                                    <option  value="{{$category->id}}">   
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
                                                        <input id="brand" name="brand" value="{{$product->brand}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>

                                                        @error('brand')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                            <label for="model" class="control-label mb-1">Model </label>
                                                            <input id="model" name="model" value="{{$product->model}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>

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
                                                
                                                <textarea name="short_desc" id="short_desc"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>
                                                    {{$product->short_desc}}
                                                </textarea>
                                            </div>
                                            @error('short_desc')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="desc" class="control-label mb-1">Description </label>
                                                
                                                <textarea name="desc" id="desc"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>
                                                    {{$product->desc}}
                                                </textarea>
                                            </div>
                                            @error('desc')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="keywords" class="control-label mb-1">Keywords </label>
                                                
                                                <textarea name="keywords" id="keywords"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>
                                                    {{$product->keywords}}
                                                </textarea>
                                            </div>
                                            @error('keywords')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="technical_specification" class="control-label mb-1">Technical Specification </label>
                                                
                                                <textarea name="technical_specification" id="technical_specification"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>
                                                    {{$product->technical_specification}}
                                                </textarea>
                                            </div>
                                            @error('technical_specification')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="uses" class="control-label mb-1">Uses </label>
                                                
                                                <textarea name="uses" id="uses"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>
                                                        {{$product->uses}}
                                                </textarea>
                                            </div>
                                            @error('user')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="warranty" class="control-label mb-1">Warranty </label>
                                                
                                                <textarea name="warranty" id="warranty"  type="text" rows="" class="form-control" aria-required="true" aria-invalid="false" required>
                                                        {{$product->warranty}}
                                                </textarea>
                                            </div>
                                            @error('warranty')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div>
                                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                   Submit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            
                               
    </div>                       
</div>                        
@endsection

