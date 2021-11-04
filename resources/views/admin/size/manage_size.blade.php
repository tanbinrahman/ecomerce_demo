@extends('admin/layout')
@section('title_name','Manage Size');
@section('size_select','active');
@section('container')

    <h1 class="mb10">Manage Size</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.size')}}">
        <button type="button" class="btn btn-success"> Size </button>
    </a>

<div class="row m-t-30">
  <div class="col-md-12">
    
                                 <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        <form action="{{route('size.insert')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="size" class="control-label mb-1">Size</label>
                                                <input id="size" name="size" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                            </div>
                                            @error('size')
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

