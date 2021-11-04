@extends('admin/layout')
@section('title_name','Manage Category');
@section('category_select','active');
@section('container')

    <h1 class="mb10">Manage Category</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.category')}}">
        <button type="button" class="btn btn-success"> Category </button>
    </a>

<div class="row m-t-30">
  <div class="col-md-12">
    
                                 <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        <form action="{{route('category.manage_catagory_process')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="category" class="control-label mb-1">Category</label>
                                                        <input id="category" name="category_name" value="{{$category_name}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required> 
                                                        <!-- @error('category_name')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror       -->
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="category_slug" class="control-label mb-1">Category Slug</label>
                                                        <input id="category_slug" name="category_slug" value="{{$category_slug}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>

                                                        @error('category_slug')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="parent_category_id" class="control-label mb-1">Parent Category Id </label>
                                               
                                                        <select id="parent_category_id" name="parent_category_id" class="form-control" required>
                                                            <option value="0">Select Parent Categories</option>
                                                            @foreach($categorys as $category)
                                                                @if($parent_category_id==$category->id)
                                                                    <option selected value="{{$category->id}}">
                                                                @else
                                                                    <option value="{{$category->id}}">
                                                                @endif
                                                                    {{$category->category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <label for="category_image" class="control-label mb-1">Category Image </label>
                                                        <input id="category_image" name="category_image" type="file" class="form-control" aria-required="true" aria-invalid="false" >

                                                        @if($category_image!='')
                                                            <a href="{{asset('storage/media/category/'.$category_image)}}" target="_blank">
                                                            <img width="100px" height="100px" src="{{asset('storage/media/category/'.$category_image)}}" alt="">
                                                            </a> 
                                                        @endif

                                                        @error('category_image')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6">
                                                        <br>
                                                        <label for="is_home" class="control-label mb-1">Show in Home Page &nbsp;</label>
                                                        <input id="is_home" name="is_home" type="checkbox" {{$is_home_selected}}>

                                                    </div>

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
                            
                               
    </div>                       
</div>                        
@endsection

