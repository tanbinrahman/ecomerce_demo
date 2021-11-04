@extends('admin/layout')
@section('title_name','Product Review');
@section('product_review_select','active');
@section('container')


    <h1 class="mb10">Product Review</h1>

<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Product</th>
                                                <th>Rating</th>
                                                <th>Review</th>
                                                <th>Added On</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
                                            @foreach($products_review as $product_review)
                                            <tr>
                                                <td>{{$product_review->id}}</td>
                                                <td>{{$product_review->name}}</td>
                                                <td>{{$product_review->pname}}</td>
                                                <td>{{$product_review->rating}}</td>
                                                <td>{{$product_review->review}}</td>
                                                <td>{{$product_review->added_on}}</td>
                                                <td>
                                                    @if($product_review->status==1)
                                                        <a href="{{url('admin/product_review/status/0')}}/{{$product_review->id}}">
                                                            <button type="button" class="btn btn-success">Active</button>
                                                        </a>

                                                    @elseif($product_review->status==0)
                                                        <a href="{{url('admin/product_review/status/1')}}/{{$product_review->id}}">
                                                            <button type="button" class="btn btn-danger">Deactive</button>
                                                        </a>

                                                    @endif

                                                </td>
                                                
                                            </tr>
                                           @endforeach 
                                        </tbody>
                                       
                                    </table>
                                </div>
                               
                            </div>
                        </div>
</div>                        
@endsection