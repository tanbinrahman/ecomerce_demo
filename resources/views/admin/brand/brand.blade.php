@extends('admin/layout')
@section('title_name','Brand');
@section('brand_select','active');
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
    <h1 class="mb10">Brand</h1>
    <!-- <a href="category/manage_catagory"> -->
    <a href="{{route('brand.manage_brand')}}">
        <button type="button" class="btn btn-success">Add Brand </button>
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
                                                <th>Image</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
                                          @foreach($brands as $brand)
                                            <tr>
                                                <td>{{$brand->id}}</td>
                                                <td>{{$brand->name}}</td>
                                                <td> 
                                                     @if($brand->image!='')
                                                     <a href="{{asset('storage/media/brand/'.$brand->image)}}" target="_blank">
                                                        <img width="50px" height="50px" src="{{asset('storage/media/brand/'.$brand->image)}}" alt="">
                                                     </a>   
                                                     @endif
                                                </td>
                                                <td>
                                                    <!-- route('category.edit',$category->id) --> 
                                                    <a href="{{url('admin/brand/manage_brand/')}}/{{$brand->id}}">
                                                        <button type="button" class="btn btn-success">Edit</button>
                                                    </a>
                                                    @if($brand->status==1)
                                                    <a href="{{url('admin/brand/status/0')}}/{{$brand->id}}">
                                                        <button type="button" class="btn btn-primary">Active</button>
                                                    </a>
                                                    @elseif($brand->status==0)
                                                    <a href="{{url('admin/brand/status/1')}}/{{$brand->id}}">
                                                        <button type="button" class="btn btn-secondary">Deactive</button>
                                                    </a>

                                                    @endif
                                                    <a href="{{url('admin/brand/delete/')}}/{{$brand->id}}">
                                                        <button type="button" class="btn btn-danger">Delete</button>
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                          @endforeach  
                                        </tbody>
                                        
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>
</div>                        
@endsection