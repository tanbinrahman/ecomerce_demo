@extends('admin/layout')
@section('title_name','Manage Tax');
@section('tax_select','active');
@section('container')

    <h1 class="mb10">Manage Tax</h1>
    <!-- <a href="{{url('admin/category')}}"> -->
    <a href="{{route('admin.tax')}}">
        <button type="button" class="btn btn-success"> Tax </button>
    </a>

<div class="row m-t-30">
  <div class="col-md-12">
    
                                 <div class="card">
                                    
                                    <div class="card-body">
                                       
                                        <form action="{{route('tax.manage_tax_process')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                
                                                <label for="tax_desc" class="control-label mb-1">Tax Description</label>
                                                <input id="tax_desc" name="tax_desc" value="{{$tax_desc}}"  type="text" class="form-control" aria-required="true" aria-invalid="false" required> 
                                                    @error('tax_desc')
                                                        <div class="alert alert-danger">
                                                            {{$message}}
                                                        </div>
                                                    @enderror      
                                            </div>
                                            <div class="form-group">
                                                <label for="tax_value" class="control-label mb-1">Tax Value</label>
                                                <input id="tax_value" name="tax_value" value="{{$tax_value}}" type="text" class="form-control" aria-required="true" aria-invalid="false" required>

                                                    @error('tax_value')
                                                        <div class="alert alert-danger">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
                                            </div>
                                                
                                            <div>
                                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                   Submit
                                                </button>
                                            </div>

                                            <input type="hidden" name="id" value="{{$id}}"/>
                                        </form>
                                    </div>
                                </div>
                            
                               
    </div>                       
</div>                        
@endsection

