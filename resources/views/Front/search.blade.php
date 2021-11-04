@extends('Front/layout')
@section('title_name','Search Page')
@section('container')

  <!-- product category -->
  <section id="aa-product-category">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="aa-product-catg-content">

            <div class="aa-product-catg-body">
              <ul class="aa-product-catg">
                @if(isset($product[0])) 
                  @foreach($product as $home_product)
                        <!-- start single product item -->
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$home_product->slug)}}"><img src="{{asset('storage/media/'.$home_product->image)}}" alt="{{$home_product->name}}"></a>
                            <a class="aa-add-card-btn" href="javascript:void(0)" onclick="home_add_to_cart('{{$home_product->id}}','{{$product_attr[$home_product->id][0]->size}}','{{$product_attr[$home_product->id][0]->color}}')"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="#">{{$home_product->name}}</a></h4>
                              <span class="aa-product-price">BDT {{$product_attr[$home_product->id][0]->price}}</span>
                              <span class="aa-product-price"><del>BDT {{$product_attr[$home_product->id][0]->mrp}}</del></span>
                            </figcaption>
                          </figure>                         
                        </li>
                        @endforeach
                        @else 
                        <li>
                          <figure> 
                            No Data Found
                          </figure>                         
                        </li>
                        @endif         
              </ul>

              
            </div>

          </div>
        </div>

       
      </div>
    </div>
  </section>
  <!-- / product category -->


   


  <input type="hidden" id="qty" value="1">
  <form id="frmAddToCart">
     <input type="hidden" id="size_id" name="size_id"/>
     <input type="hidden" id="color_id" name="color_id"/>
     <input type="hidden" id="product_id" name="product_id">
     <input type="hidden" id="pqty" name="pqty">
     @csrf
   </form>


@endsection