@extends('Front/layout')
@section('title_name','Order Placed Page')
@section('container')

<section id="aa-product-category">
    <div class="container">
        <div class="row" style="text-align:center;">
            <br><br><br>
                <h2>Your order has been placed.</h2>
                <h2>Order Id:-{{session()->has('ORDER_ID')}}</h2>
            <br><br><br>
        </div>
    </div>
</section>


@endsection