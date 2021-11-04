@extends('admin/layout')
@section('title_name','Manage Home Banner');
@section('home_banner_select','active');
@section('container')

    <h1 class="mb10">Manage Home banner</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.home_banner')}}">
        <button type="button" class="btn btn-success"> Home Banner </button>
    </a>

<div class="row m-t-30">
  <div class="col-md-12">
    
                                 <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        <form action="{{route('home_banner.manage_home_banner_process')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="btn_txt" class="control-label mb-1">Btn Text</label>
                                                        <input id="btn_txt" name="btn_txt" value="{{$btn_txt}}" type="text" class="form-control" aria-required="true" aria-invalid="false" > 
                                                        <!-- @error('category_name')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror       -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="btn_link" class="control-label mb-1">Btn Link</label>
                                                        <input id="btn_link" name="btn_link" value="{{$btn_link}}" type="text" class="form-control" aria-required="true" aria-invalid="false" >

                                                        @error('btn_link')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <label for="image" class="control-label mb-1">Image </label>
                                                        <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" >

                                                        @if($image!='')
                                                            <a href="{{asset('storage/media/home_banner/'.$image)}}" target="_blank">
                                                            <img width="100px" height="100px" src="{{asset('storage/media/home_banner/'.$image)}}" alt="">
                                                            </a> 
                                                        @endif

                                                        @error('image')
                                                            <div class="alert alert-danger">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
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

