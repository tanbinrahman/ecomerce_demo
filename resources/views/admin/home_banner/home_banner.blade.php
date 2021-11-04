@extends('admin/layout')
@section('title_name','Home Banner');
@section('home_banner_select','active');
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
    <h1 class="mb10">Home Banner</h1>
    <!-- <a href="category/manage_catagory"> -->
    <a href="{{route('home_banner.manage_home_banner')}}">
        <button type="button" class="btn btn-success">Add Home Banner </button>
    </a>

<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Btn Text</th>
                                                <th>Btn Link</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        @foreach($homebanners as $homebanner)
                                        <tbody>
                                            <tr>
                                                <td>{{$homebanner->id}}</td>
                                                <td>{{$homebanner->btn_txt}}</td>
                                                <td>{{$homebanner->btn_link}}</td>
                                                <td>
                                                    <a href="{{asset('storage/media/home_banner/'.$homebanner->image)}}" target="_blank">
                                                        <img width="100px" height="100px" src="{{asset('storage/media/home_banner/'.$homebanner->image)}}" alt="">
                                                    </a>
                                                </td>
                                                <td>
                                                    <!-- route('category.edit',$category->id) --> 
                                                    <a href="{{url('admin/home_banner/manage_home_banner/')}}/{{$homebanner->id}}">
                                                        <button type="button" class="btn btn-success">Edit</button>
                                                    </a>
                                                    @if($homebanner->status==1)
                                                    <a href="{{url('admin/home_banner/status/0')}}/{{$homebanner->id}}">
                                                        <button type="button" class="btn btn-primary">Active</button>
                                                    </a>
                                                    @elseif($homebanner->status==0)
                                                    <a href="{{url('admin/home_banner/status/1')}}/{{$homebanner->id}}">
                                                        <button type="button" class="btn btn-secondary">Deactive</button>
                                                    </a>

                                                    @endif
                                                    <a href="{{url('admin/home_banner/delete/')}}/{{$homebanner->id}}">
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