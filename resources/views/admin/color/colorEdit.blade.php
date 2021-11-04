@extends('admin/layout')
@section('title_name','Manage Color');
@section('color_select','active');
@section('container')

    <h1 class="mb10">Manage Color</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.color')}}">
        <button type="button" class="btn btn-success"> Color </button>
    </a>

<div class="row m-t-30">
  <div class="col-md-12">
    
                                 <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        <form action="{{route('color.update',$color->id)}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="color" class="control-label mb-1">Color</label>
                                                <input id="color" name="color" value="{{$color->color}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('color')
                                                <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                            
                                            <div>
                                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                   Submit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            
                               
    </div>                       
</div>                        
@endsection

