@extends('admin/layout')
@section('title_name','Edit Category');
@section('category_select','active');
@section('container')

    <h1 class="mb10">Edit Category</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.category')}}">
        <button type="button" class="btn btn-success"> Category </button>
    </a>

<div class="row m-t-30">
  <div class="col-md-12">
    
                                 <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        <form action="{{route('category.update',$category->id)}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="category" class="control-label mb-1">Category</label>
                                                <input id="category" name="category_name" value="{{$category->category_name}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('category_name')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="category_slug" class="control-label mb-1">Category Slug</label>
                                                <input id="category_slug" name="category_slug" value="{{$category->category_slug}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('category_slug')
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

