@extends('admin/layout')
@section('title_name','Manage Brand');
@section('brand_select','active');
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


@error('image')
                              
    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
        {{$message}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    </div>
@enderror

    <h1 class="mb10">Manage Brand</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.brand')}}">
        <button type="button" class="btn btn-success"> Brand </button>
    </a>

<div class="row m-t-30">
  <div class="col-md-12">
    
                                 <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        <form action="{{route('brand.manage_brand_process')}}" enctype="multipart/form-data" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="brand" class="control-label mb-1">Brand Name</label>
                                                        <input id="name" name="name" value="{{$name}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                                    </div>
                                                    @error('name')
                                                    <div class="alert alert-danger">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                <br>
                                                    <label for="is_home" class="control-label mb-1">Show in Home Page &nbsp;</label>
                                                    <input id="is_home" name="is_home" type="checkbox" {{$is_home_selected}}>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="image" class="control-label mb-1">Image </label>
                                                <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}} >
                                            </div>

                                            @if($image!='')
                                                <img width="50px" height="50px" src="{{asset('storage/media/brand/'.$image)}}" alt="">
                                             @endif
                                            @error('image')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror

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

