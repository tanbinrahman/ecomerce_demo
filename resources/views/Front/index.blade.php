@extends('Front/layout')
@section('title_name','Home Page')
@section('container')

<section id="aa-slider">
    <div class="aa-slider-area">
      <div id="sequence" class="seq">
        <div class="seq-screen">
          <ul class="seq-canvas">
            <!-- single slide item -->
            @foreach($home_banners as $home_banner)
            <li>
              <div class="seq-model">
                <img data-seq src="{{asset('storage/media/home_banner/'.$home_banner->image)}}" alt="Men slide img" />
              </div>
              @if($home_banner->btn_txt!="")
              <div class="seq-title">
                <a data-seq target="_blank" href="{{$home_banner->btn_link}}" class="aa-shop-now-btn aa-secondary-btn">{{$home_banner->btn_txt}}</a>
              </div>
              @endif
            </li>
            @endforeach                   
          </ul>
        </div>
        <!-- slider navigation btn -->
        <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
          <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
          <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
        </fieldset>
      </div>
    </div>
  </section>
  <!-- / slider -->
  <!-- Start Promo section -->
  <section id="aa-promo">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-promo-area">
            <div class="row">

              <!-- promo right -->
              <div class="col-md-12 no-padding">
                <div class="aa-promo-right">
                    @foreach($home_categories as $home_categorie)
                  <div class="aa-single-promo-right">
                    <div class="aa-promo-banner">                      
                      <img src="{{asset('storage/media/category/'.$home_categorie->category_image)}}" alt="img">                      
                      <div class="aa-prom-content">
                        
                        <h4><a href="{{url('category/'.$home_categorie->category_slug)}}">{{$home_categorie->category_name}}</a></h4>                        
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Promo section -->
  <!-- Products section -->
  <section id="aa-product">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-product-area">
              <div class="aa-product-inner">
                <!-- start prduct navigation -->
                 <ul class="nav nav-tabs aa-products-tab">
                 @foreach($home_categories as $home_categorie)
                    <li class=""><a href="#cat{{$home_categorie->id}}" data-toggle="tab">{{$home_categorie->category_name}}</a></li>
                 @endforeach   
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <!-- Start men product category -->
                    @php
                      $loop_count=1;
                    @endphp
                    @foreach($home_categories as $home_categorie)
                    @php
                    $cat_class="";
                    if($loop_count==1){
                      $cat_class="in active";
                      $loop_count++;
                    }
                    @endphp
                    <div class="tab-pane fade {{$cat_class}}" id="cat{{$home_categorie->id}}">
                      <ul class="aa-product-catg">

                      @if(isset($home_categories_product[$home_categorie->id][0])) 
                      @foreach($home_categories_product[$home_categorie->id] as $home_product)
                        <!-- start single product item -->

                        <li>
                          <figure> 
                            <a class="aa-product-img" href="{{url('product/'.$home_product->slug)}}"><img src="{{asset('storage/media/'.$home_product->image)}}" alt="{{$home_product->name}}"></a>
                            <a class="aa-add-card-btn"href="javascript:void(0)" onclick="home_add_to_cart('{{$home_product->id}}','{{$home_product_attr[$home_product->id][0]->size}}','{{$home_product_attr[$home_product->id][0]->color}}')" ><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="#">{{$home_product->name}}</a></h4>
                              <span class="aa-product-price"><del>BDT {{$home_product_attr[$home_product->id][0]->mrp}}</del></span>
                              <span class="aa-product-price">BDT {{$home_product_attr[$home_product->id][0]->price}}</span>
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
                    @endforeach
                    <!-- / men product category -->
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Products section -->
  <!-- banner section -->
  <section id="aa-banner">
    <div class="container">
      <div class="row">
        <div class="col-md-12">        
          <div class="row">
            <div class="aa-banner-area">
            <a href="#"><img src="{{asset('front_assets/img/fashion-banner.jpg')}}" alt="fashion banner img"></a>
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- popular section -->
  <section id="aa-popular-category">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-popular-category-area">
              <!-- start prduct navigation -->
             <ul class="nav nav-tabs aa-products-tab">
                <li class="active"><a href="#featured" data-toggle="tab">Featured</a></li>
                <li><a href="#tranding" data-toggle="tab">Tranding</a></li>
                <li><a href="#discounted" data-toggle="tab">Discounted</a></li>                    
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Start men featured category -->
                <div class="tab-pane fade in active" id="featured">
                  <ul class="aa-product-catg aa-featured-slider">
                    <!-- start single product item -->
                    @if(isset($home_featured_product[$home_categorie->id][0]))  
                      @foreach($home_featured_product[$home_categorie->id] as $home_product)

                        <!-- start single product item -->
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$home_product->slug)}}"><img src="{{asset('storage/media/'.$home_product->image)}}" alt="{{$home_product->name}}"></a>
                            <a class="aa-add-card-btn" href="javascript:void(0)" onclick="home_add_to_cart('{{$home_product->id}}','{{$home_featured_product_attr[$home_product->id][0]->size}}','{{$home_featured_product_attr[$home_product->id][0]->color}}')"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="#">{{$home_product->name}}</a></h4>
                              <span class="aa-product-price">RS {{$home_featured_product_attr[$home_product->id][0]->mrp}}</span>
                              <span class="aa-product-price"><del>RS {{$home_featured_product_attr[$home_product->id][0]->mrp}}</del></span>
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
                     <!-- start single product item -->                                                              
                  </ul>
                  
                </div>
                <!-- / popular product category -->
                
                <!-- start tranding product category -->
                <div class="tab-pane fade" id="tranding">
                 <ul class="aa-product-catg aa-tranding-slider">
                    <!-- start single product item -->
                    @if(isset($home_tranding_product[$home_categorie->id][0])) 
                      @foreach($home_tranding_product[$home_categorie->id] as $home_product)
                        <!-- start single product item -->
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$home_product->slug)}}"><img src="{{asset('storage/media/'.$home_product->image)}}" alt="{{$home_product->name}}"></a>
                            <a class="aa-add-card-btn" href="javascript:void(0)" onclick="home_add_to_cart('{{$home_product->id}}','{{$home_tranding_product_attr[$home_product->id][0]->size}}','{{$home_tranding_product_attr[$home_product->id][0]->color}}')"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="#">{{$home_product->name}}</a></h4>
                              <span class="aa-product-price">BDT {{$home_tranding_product_attr[$home_product->id][0]->mrp}}</span>
                              <span class="aa-product-price"><del>BDT {{$home_tranding_product_attr[$home_product->id][0]->mrp}}</del></span>
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
                <!-- / tranding product category -->

                <!-- start discounted product category -->
                <div class="tab-pane fade" id="discounted">
                  <ul class="aa-product-catg aa-discounted-slider">
                    <!-- start single product item -->
                    @if(isset($home_discount_product[$home_categorie->id][0]))  
                      @foreach($home_discount_product[$home_categorie->id] as $home_product)
                        <!-- start single product item -->
                        <li>
                          <figure>
                            <a class="aa-product-img" href="{{url('product/'.$home_product->slug)}}"><img src="{{asset('storage/media/'.$home_product->image)}}" alt="{{$home_product->name}}"></a>
                            <a class="aa-add-card-btn" href="javascript:void(0)" onclick="home_add_to_cart('{{$home_product->id}}','{{$home_discount_product_attr[$home_product->id][0]->size}}','{{$home_discount_product_attr[$home_product->id][0]->color}}')"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                            <figcaption>
                              <h4 class="aa-product-title"><a href="#">{{$home_product->name}}</a></h4>
                              <span class="aa-product-price">RS {{$home_discount_product_attr[$home_product->id][0]->mrp}}</span>
                              <span class="aa-product-price"><del>RS {{$home_discount_product_attr[$home_product->id][0]->mrp}}</del></span>
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
                <!-- / discounted product category -->              
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
  </section>
  <!-- / popular section -->
  <!-- Support section -->
  <section id="aa-support">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-support-area">
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-truck"></span>
                <h4>FREE SHIPPING</h4>
                <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
              </div>
            </div>
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-clock-o"></span>
                <h4>30 DAYS MONEY BACK</h4>
                <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
              </div>
            </div>
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-phone"></span>
                <h4>SUPPORT 24/7</h4>
                <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Support section -->

  <!-- Client Brand -->
  <section id="aa-client-brand">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-client-brand-area">
            <ul class="aa-client-brand-slider"> 
            @foreach($home_brands as $home_brand)
              <li><a href="#"><img hight="100px" src="{{asset('storage/media/brand/'.$home_brand->image)}}" alt="{{$home_brand->name}}"></a>
            </li>
            @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Client Brand -->

  <!-- Subscribe section -->
  <section id="aa-subscribe">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-subscribe-area">
            <h3>Subscribe our newsletter </h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, velit!</p>
            <form action="" class="aa-subscribe-form">
              <input type="email" name="" id="" placeholder="Enter your Email">
              <input type="submit" value="Subscribe">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Subscribe section -->
  <input type="hidden" id="qty" value="1">
  <form id="frmAddToCart">
     <input type="hidden" id="size_id" name="size_id"/>
     <input type="hidden" id="color_id" name="color_id"/>
     <input type="hidden" id="product_id" name="product_id">
     <input type="hidden" id="pqty" name="pqty">
     @csrf
   </form>



@endsection