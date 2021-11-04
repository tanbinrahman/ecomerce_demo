@extends('admin/layout')
@section('title_name','Order');
@section('order_select','active');
@section('container')

    <h1 class="mb10">Order</h1>

<div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>Order Id</th>
                                                <th>Coustomer Details</th>
                                                <th>Amount</th>
                                                <th>Order Status</th>
                                                <th>Payment Status</th>
                                                <th>Payment Type</th>
                                                <th>Order Date</th>
                                                
                                            </tr>
                                        </thead>
                                        @foreach($orders as $list)
                                        <tbody>
                                            <tr>
                                                <td><a href="{{url('/admin/order_details')}}/{{$list->id}}">{{$list->id}}</a> </td>
                                                <td>
                                                    {{$list->name}} <br>
                                                    {{$list->email}} <br>
                                                    {{$list->mobile}} <br>
                                                    {{$list->address}},{{$list->city}},{{$list->state}},{{$list->pincode}}
                                                </td>
                                                <td>{{$list->total_amt}}</td>
                                                <td>{{$list->order_status}}</td>
                                                <td>{{$list->payment_status}}</td>
                                                <td>{{$list->payment_type}}</td>
                                                <td>{{$list->added_on}}</td>
 
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