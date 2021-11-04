@extends('admin/layout')
@section('title_name','Product');
@section('product_select','active');
@section('container')

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
    <h1 class="mb10">Product</h1>
    <a href="{{route('product.manage_product')}}">
        <button type="button" class="btn btn-success">Add Product </button>
    </a>

<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                      @foreach($products as $product)
                                        <tbody>
                                            <tr>
                                                <td>{{$product->id}}</td>
                                                <td>{{$product->name}}</td>
                                                <td>{{$product->slug}}</td>
                                                <td>
                                                    @if($product->image!='')
                                                        <img width="50px" height="50px" src="{{asset('storage/media/'.$product->image)}}" alt="">
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    <!-- <a href="{{route('product.manage_product',$product->id)}}">
                                                        <button type="button" class="btn btn-success">Edit</button>
                                                    </a> -->

                                                    <a href="{{url('admin/product/manage_product/')}}/{{$product->id}}">
                                                        <button type="button" class="btn btn-success">Edit</button>
                                                    </a>
                                                    
                                                   
                                                    @if($product->status==1)
                                                        <a href="{{url('admin/product/status/0')}}/{{$product->id}}">
                                                            <button class="btn btn-primary" type="button">Active</button>
                                                        </a>
                                                    @elseif($product->status==0)
                                                        <a href="{{url('admin/product/status/1')}}/{{$product->id}}">
                                                            <button class="btn btn-secondary" type="button">Deactive</button>
                                                        </a>
                                                    @endif
                                                    <a href="{{route('product.delete',$product->id)}}">
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