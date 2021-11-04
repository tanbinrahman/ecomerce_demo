@extends('admin/layout')
@section('title_name','Customer');
@section('customer_select','active');
@section('container')

@if(Session::has('message'))

    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
        {{Session::get('message')}}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
			</button>
	</div>
@endif 

    <h1 class="mb10">Customer</h1>


<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>City</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        @foreach($Customers as $Customer)
                                        <tbody>
                                            <tr>
                                                <td>{{$Customer->id}}</td>
                                                <td>{{$Customer->name}}</td>
                                                <td>{{$Customer->email}}</td>
                                                <td>{{$Customer->mobile}}</td>
                                                <td>{{$Customer->city}}</td>
                                                <td>
                                                    <!-- route('category.edit',$category->id) --> 
                                                    <a href="{{url('admin/customer/show/')}}/{{$Customer->id}}">
                                                        <button type="button" class="btn btn-success">Show</button>
                                                    </a>
                                                    @if($Customer->status==1)
                                                    <a href="{{url('admin/customer/status/0')}}/{{$Customer->id}}">
                                                        <button type="button" class="btn btn-primary">Active</button>
                                                    </a>
                                                    @elseif($Customer->status==0)
                                                    <a href="{{url('admin/customer/status/1')}}/{{$Customer->id}}">
                                                        <button type="button" class="btn btn-secondary">Deactive</button>
                                                    </a>

                                                    @endif

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