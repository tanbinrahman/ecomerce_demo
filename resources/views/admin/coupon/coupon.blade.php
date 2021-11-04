@extends('admin/layout')
@section('title_name','Coupon');
@section('coupon_select','active');
@section('container')

    <!-- @if(Session::has('message'))
        <div class="alert alert-success">
            {{Session::get('message')}}
        </div>
    @endif     -->
    @if(Session::has('message'))
        <!-- <div class="alert alert-success">
            {{Session::get('message')}}
        </div> -->
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                {{Session::get('message')}}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>
		</div>
    @endif 
    <h1 class="mb10">Coupon</h1>
    <a href="{{route('coupon.manage_coupon')}}">
        <button type="button" class="btn btn-success">Add Coupon </button>
    </a>

<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Code </th>
                                                <th>Value </th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                      @foreach($coupons as $coupon)  
                                        <tbody>
                                            <tr>
                                                <td>{{$coupon->id}}</td>
                                                <td>{{$coupon->title}}</td>
                                                <td>{{$coupon->code}}</td>
                                                <td>{{$coupon->value}}</td>
                                                <td>
                                                
                                            
                                                    <a href="{{url('admin/coupon/manage_coupon/')}}/{{$coupon->id}}">
                                                        <button type="button" class="btn btn-success">Edit</button>
                                                    </a>
                                                    @if($coupon->status==1)
                                                    <a href="{{url('admin/coupon/status/0')}}/{{$coupon->id}}">
                                                        <button type="button" class="btn btn-primary">Active</button>
                                                    </a>

                                                    @elseif($coupon->status==0)

                                                    <a href="{{url('admin/coupon/status/1')}}/{{$coupon->id}}">
                                                        <button type="button" class="btn btn-secondary">Deactive</button>
                                                    </a>
                                                    @endif
                                                    <a href="{{route('coupon.delete',$coupon->id)}}">
                                                        <button type="button" class="btn btn-danger">Delete</button>
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                       @endforeach
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>
</div>                        
@endsection