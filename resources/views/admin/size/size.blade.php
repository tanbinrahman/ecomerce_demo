@extends('admin/layout')
@section('title_name','Size');
@section('size_select','active');
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
    <h1 class="mb10">Size</h1>
    <a href="{{route('size.manage_size')}}">
        <button type="button" class="btn btn-success">Add Size </button>
    </a>

<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Size</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                      @foreach($sizes as $size)
                                        <tbody>
                                            <tr>
                                                <td>{{$size->id}}</td>
                                                <td>{{$size->size}}</td>
                                                
                                                <td>
                                                    <a href="{{route('size.edit',$size->id)}}">
                                                        <button type="button" class="btn btn-success">Edit</button>
                                                    </a>

                                                    @if($size->status==1)
                                                        <a href="{{url('admin/size/status/0')}}/{{$size->id}}">
                                                            <button type="button" class="btn btn-primary">Active</button>      
                                                        </a>
                                                    @elseif($size->status==0)
                                                        <a href="{{url('admin/size/status/1')}}/{{$size->id}}">
                                                            <button type="button" class="btn btn-secondary">Deactive</button>
                                                        </a>
                                                    @endif
                                                   
                                                    <a href="{{route('size.delete',$size->id)}}">
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