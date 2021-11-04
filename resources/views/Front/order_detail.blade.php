@extends('Front/layout')
@section('title_name','Order Detail')
@section('container')

  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   
   <div class="aa-catg-head-banner-area">
     <div class="container">
    
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="cart-view">
   <div class="container">
     <div class="row">
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
          @if($order_details[0]->track_details!='')
         <b>track_details</b> : <br> {{$order_details[0]->track_details}}
          @endif 
       </div>
       <div class="col-md-12">
         <div class="cart-view-area">

           <div class="cart-view-table">
             <form action="">
             
               <div class="table-responsive">
                  <table class="table"> 
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
               
             </form>
             <!-- Cart Total view -->

           </div>
         </div>
       </div>
     </div>
   </div>
 </section>

@endsection