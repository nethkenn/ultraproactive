@extends('member.layout')
@section('content')
<div class="cart col-md-5 hidden-lg hidden-md" style="margin-bottom: 25px;">
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-cart.png">
        Shopping Cart
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 10px auto">
    <div class="col-md-12 body">
    <div class="cart_relative">
            <table class="footable">
                <img class="cart_preloader" src="/resources/assets/img/preloader_cart.gif" style="width: 60px; height: 64px;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product</th>
                        <th data-hide="phone">Price</th>
                        <th data-hide="phone">Quantity</th>
                        <th data-hide="phone">Total</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody class="cart_container ">
                </tbody>
            </table>
        </div>
        <a href="#checkout">
            <button type="button">
                Checkout Now!
            </button>
        </a>
    </div>
</div>
<input type="hidden" class="tokens" value="{{Session::get('currentslot')}}">
<div class="encashment product col-md-7">
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-products.png">
        Products
    </div>
    <div class="body">

        @if ($_product)
            @foreach ($_product as $product)
                <div class="holder para">
                    <div class="pix">
                        <img src="{{$product->image_file}}">
                    </div>
                    <div class="text">
                        <div class="name">{{$product->product_name}}</div>
                        <div class="price">Wallet Price {{$product->price}}</div>
                        <div class="description">Unilevel Points : {{$product->unilevel_pts}}</div>
                        <div class="description">Binary Points : {{$product->binary_pts}}</div>
                        <div class="description">{{$product->product_info}}</div>

                        <div class="boton">
                            <a href="#" class="add-to-cart" product-id="{{$product->product_id}}">
                                <button>Add to Cart</button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
<div class="cart tsk col-md-5 hidden-sm hidden-xs">
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-cart.png" >
        Shopping Cart
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 10px auto">
    <div class="col-md-12 body">
        <div class="cart_relative">
            <table>
                <img class="cart_preloader" src="/resources/assets/img/preloader_cart.gif" style="width: 60px; height: 64px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th data-hide="phone">Price</th>
                        <th data-hide="phone">Quantity</th>
                        <th data-hide="phone">Total</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody class="cart_container ">
                </tbody>
            </table>
        </div>
        <a id="checkout-cart" href="#checkout">
            <button type="button">
                Checkout Now!
            </button>
        </a>
    </div>
</div>
<div class="remodal create-slot" data-remodal-id="check-out-modal" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
    <img class="checkout_preloader" src="/resources/assets/img/preloader_cart.gif" style="width: 60px; height: 64px;">
    <div id="checkout-form-container">
    </div>
</div>
<style type="text/css">
    .cart_relative
    {
        position: relative;
    }
    .cart_opacity
    {
        opacity: 0.5;
    }
    .cart_preloader,.checkout_preloader
    {
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        z-index: 99;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
          -o-transform: translateY(-50%);
             transform: translateY(-50%);
    }

    div[data-remodal-id="check-out-modal"]
    {
        min-height:  491px;
    }

    .checkout_preloader{
        display: none;
        -ms-interpolation-mode:bicubic;
    }
    .asdasd
    {
        margin-top: 50px;
    }
</style>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/product.css">
@endsection
@section('script')
<script type="text/javascript">
    jQuery('.tsk').stickyfloat(
        {
            duration: 400
        });
</script>
<script type="text/javascript" language="javascript">
     $(function () {
         var $win = $(window);

         $win.scroll(function () {
             if ($win.scrollTop() == 0)
                 $(".cart").removeClass("asdasd");
             else if ($win.scrollTop() != 0)
                 $(".cart").addClass("asdasd");
         });
     });
</script>
<script type="text/javascript" src="/resources/assets/members/js/members_product.js"></script>
@endsection