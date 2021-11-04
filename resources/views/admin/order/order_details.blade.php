@extends('admin/layout')
@section('title_name','Order Details');
@section('order_select','active');
@section('container')

<h1 class="mb10">Order:- {{$order_details[0]->id}}</h1>

<div class="order_operation">
  <b>Update Order Status </b>
  <select class="form-control  m-b-10" id="order_status" onchange="update_order_status({{$order_details[0]->id}})">
    <?php
          foreach($orders_status as $list){
            if($order_details[0]->order_status==$list->id){
              echo "<option value='".$list->id."' selected>".$list->orders_status."</option>";
            }else{
              echo "<option value='".$list->id."'>".$list->orders_status."</option>";
            }
          } 
    ?>          
  </select>
  <b>Update Payment Status </b>
  <select class="form-control   m-b-10" id="payment_status" onchange="update_payment_status({{$order_details[0]->id}})"> 
    @foreach($payment_status as $list)
          @if($order_details[0]->payment_status==$list)
            <option value="{{$list}}" selected>{{$list}}</option>
          @else
            <option value="{{$list}}">{{$list}}</option>
          @endif  
    @endforeach

  </select>
  <b>Track Details</b>
  <form method="post">
    
    <textarea name="track_details" class="form-control m-b-10"  required>
          {{$order_details[0]->track_details}}
    </textarea>
    <button type="submit" class="btn btn-success">Update</button>
    @csrf
  </form>
</div>  

<div class="row m-t-30">
<div class="col-md-6">         
         <div class="order_detail">
           <h3>Details Address</h3>
           name :{{$order_details[0]->name}} <br> 
           phone:{{$order_details[0]->mobile}} <br> 
           address: {{$order_details[0]->address}} <br> 
           city:{{$order_details[0]->city}} <br>
           state:{{$order_details[0]->state}} <br>
           zip:{{$order_details[0]->pincode}}
         </div>
        </div>
       <div class="col-md-6">
        <div class="order_detail">
         <h3>Order Details</h3>
          Order Status: {{$order_details[0]->orders_status}}<br>
          Payment Status: {{$order_details[0]->payment_status}}<br>
          Payment Type: {{$order_details[0]->payment_type}}<br>
          @if($order_details[0]->payment_id!='')
            Payment Id: {{$order_details[0]->payment_id}}<br>
          @endif  
        </div> 
       </div>
       <div class="col-md-12">
         <div class="cart-view-area">

           <div class="cart-view-table">
               <div class="table-responsive">
                  <table class="table table-borderless table-data3 order_details"> 
                    <thead>
                      <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>qty</th>
                        <th>Total Amt</th>

                      </tr>
                    </thead>
    
                    <tbody>
                      @php
                        $total_amt =0;
                      @endphp
                      @foreach($order_details as $list)
                        @php
                          $total_amt =$total_amt+($list->price*$list->qty);
                        @endphp  
                        <tr>
                          <td>{{$list->pname}}</td>
                          <td><img src="{{asset('storage/media/'.$list->attr_image)}}" alt=""></td>  
                          <td>{{$list->color}}</td>
                          <td>{{$list->size}}</td>
                          <td>{{$list->price}}</td>
                          <td>{{$list->qty}}</td>
                          <td>{{$list->price*$list->qty}}</td>
                        </tr>
                      @endforeach
                        <tr>
                          <td colspan="5"></td>
                          <td> <b> Total Amount</b></td>
                          <td> <b>{{$total_amt}}</b></td>
                        </tr>
                        <!-- @if($order_details[0]->coupon_value>0)
                        <tr>
                          <td colspan="5"></td>
                          <td> <b> Coupon Amount</b></td>
                          <td> <b>{{$order_details[0]->coupon_value}}</b></td>
                        </tr>
                        <tr>
                        <tr>
                            <td colspan="5">  </td>
                            <td><b>Fainal Amount </b></td>
                            <td><b>{{$total_amt-$order_details[0]->coupon_value}} </b></td>
                        
                        </tr>
                        @endif -->
                      <?php
                        if($order_details[0]->coupon_value>0){
                        echo  '<tr>
                          <td colspan="5"></td>
                          <td> <b> Coupon Amount <span class="coupon_apply_txt">('.$order_details[0]->coupon_code.')</span></b></td>
                          <td> <b>'.$order_details[0]->coupon_value.'</b></td>
                        </tr>';

                          $final_amt =$total_amt-$order_details[0]->coupon_value;
                          echo '<tr>
                            <td colspan="5">  </td>
                            <td><b>Fainal Amount </b></td>
                            <td><b>'.$final_amt.' </b></td>
                          <tr>';
                        }
                        ?>
                    </tbody>        
                  </table>
                </div>
           </div>
         </div>
       </div>
</div>  
                    
@endsection



      <!-- foreach($payment_status as $list){
        if($order_details[0]->payment_status==$list){
          echo "<option value='$list' selected>$list</option>";
        }else{
          echo "<option value='$list'>$list</option>";
        }
      } -->
   