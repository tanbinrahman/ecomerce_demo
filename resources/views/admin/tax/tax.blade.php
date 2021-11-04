@extends('admin/layout')
@section('title_name','Tax');
@section('tax_select','active');
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
    <h1 class="mb10">Tax</h1>
    <!-- <a href="category/manage_catagory"> -->
    <a href="{{route('tax.manage_tax')}}">
        <button type="button" class="btn btn-success">Add Tax </button>
    </a>

<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tax Description</th>
                                                <th>Tax value</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        @foreach($taxes as $tax)
                                        <tbody>
                                            <tr>
                                                <td>{{$tax->id}}</td>
                                                <td>{{$tax->tax_desc}}</td>
                                                <td>{{$tax->tax_value}}</td>
                                                <td>
                                                    <!-- route('category.edit',$category->id) --> 
                                                    <a href="{{url('admin/tax/manage_tax/')}}/{{$tax->id}}">
                                                        <button type="button" class="btn btn-success">Edit</button>
                                                    </a>
                                                    @if($tax->status==1)
                                                    <a href="{{url('admin/tax/status/0')}}/{{$tax->id}}">
                                                        <button type="button" class="btn btn-primary">Active</button>
                                                    </a>
                                                    @elseif($tax->status==0)
                                                    <a href="{{url('admin/tax/status/1')}}/{{$tax->id}}">
                                                        <button type="button" class="btn btn-secondary">Deactive</button>
                                                    </a>

                                                    @endif
                                                    <a href="{{url('admin/tax/delete/')}}/{{$tax->id}}">
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