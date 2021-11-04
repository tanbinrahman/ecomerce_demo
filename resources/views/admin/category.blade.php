@extends('admin/layout')
@section('title_name','Category');
@section('category_select','active');
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
    <h1 class="mb10">Category</h1>
    <!-- <a href="category/manage_catagory"> -->
    <a href="{{route('category.manage_catagory')}}">
        <button type="button" class="btn btn-success">Add Category </button>
    </a>

<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Category Name</th>
                                                <th>Category Slug</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        @foreach($categories as $category)
                                        <tbody>
                                            <tr>
                                                <td>{{$category->id}}</td>
                                                <td>{{$category->category_name}}</td>
                                                <td>{{$category->category_slug}}</td>
                                                <td>
                                                    <!-- route('category.edit',$category->id) --> 
                                                    <a href="{{url('admin/category/manage_catagory/')}}/{{$category->id}}">
                                                        <button type="button" class="btn btn-success">Edit</button>
                                                    </a>
                                                    @if($category->status==1)
                                                    <a href="{{url('admin/category/status/0')}}/{{$category->id}}">
                                                        <button type="button" class="btn btn-primary">Active</button>
                                                    </a>
                                                    @elseif($category->status==0)
                                                    <a href="{{url('admin/category/status/1')}}/{{$category->id}}">
                                                        <button type="button" class="btn btn-secondary">Deactive</button>
                                                    </a>

                                                    @endif
                                                    <a href="{{url('admin/category/delete/')}}/{{$category->id}}">
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