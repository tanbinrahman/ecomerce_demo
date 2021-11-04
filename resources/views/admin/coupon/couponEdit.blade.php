@extends('admin/layout')
@section('title_name','Edit Coupon');
@section('coupon_select','active');
@section('container')

    <h1 class="mb10">Edit Coupon</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.coupon')}}">
        <button type="button" class="btn btn-success"> Coupon </button>
    </a>

<div class="row m-t-30">
  <div class="col-md-12">
    
                                 <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        <form action="{{route('coupon.update',$coupon->id)}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="title" class="control-label mb-1">Title</label>
                                                <input id="title" name="title" value="{{$coupon->title}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('title')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="code" class="control-label mb-1">Code </label>
                                                <input id="code" name="code" value="{{$coupon->code}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('code')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div class="form-group">
                                                <label for="value" class="control-label mb-1">Value </label>
                                                <input id="value" name="value" value="{{$coupon->value}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('value')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            <div>
                                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                   Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            
                               
    </div>                       
</div>                        
@endsection

