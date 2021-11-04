@extends('admin/layout')
@section('title_name','Color');
@section('color_select','active');
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
    <h1 class="mb10">Color</h1>
    <a href="{{route('color.manage_color')}}">
        <button type="button" class="btn btn-success">Add Color </button>
    </a>

<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Color</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                      @foreach($colors as $color)
                                        <tbody>
                                            <tr>
                                                <td>{{$color->id}}</td>
                                                <td>{{$color->color}}</td>
                                                
                                                <td>
                                                    <a href="{{route('color.edit',$color->id)}}">
                                                        <button type="button" class="btn btn-success">Edit</button>
                                                    </a>
                                                    
                                                    @if($color->status==1)
                                                        <a href="{{url('admin/color/status/0')}}/{{$color->id}}">
                                                            <button type="button" class="btn btn-primary">Active</button>
                                                        </a>

                                                    @elseif($color->status==0)
                                                        <a href="{{url('admin/color/status/1')}}/{{$color->id}}">
                                                            <button type="button" class="btn btn-secondary">Deactive</button>
                                                        </a>

                                                    @endif

                                                    <a href="{{route('color.delete',$color->id)}}">
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