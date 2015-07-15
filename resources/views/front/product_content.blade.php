@extends('front.layout')
@section('content')
<div class="top_wrapper   no-transparent">
    <!-- .header -->
    <!-- Page Head -->
    <!-- Page Head -->
    <div class="header_page basic background_image" style="background-image:url(/resources/assets/ausart/assets/img/default_header.jpg);background-repeat: no-repeat; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; color:#2f383d; ">
        <div class="container">
            <style>
            .breadcrumbs_c {
                color: #fff;
                font-size: 13px;
            }
            
            h1.title {
                color: #fff !important;
                font-size: 50px
            }
            </style>
            <h1 class="title">Portfolio Sample Right</h1>
            <div class="breadcrumbss">

            </div>
        </div>
    </div>
    <!-- Main Content -->
    <section id="content" style="background:;">
        <div class="row-fluid">
            <div class="span12 portfolio_single" data-id="3388">
                <div class="container">
                    <div class="row-fluid single_content side_single">
                        <div class="row-fluid" style="margin-top:0px;">
                            
                            <div class="span8 slider_full with_thumbnails_container">
                                <div class="slideshow_container flexslider with_thumbnails slide_layout_" id="flex">
                                    <ul class="slides slide_flexslider_thumb">
                                        <li data-thumb='{{ $product->image }}' class=' slide_element slide3 frame3'><img src='{{ $product->image }}' title='shutterstock_185759639' alt='' /> </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="span4">
                                <div class="details_side">
                                    <h1>{{ $product->product_name }}</h1>
                                </div>
                                <div class="details_content">
                                    <p></p>
                                </div>
                                <div class="meta-content">
                                    <div class="meta">
                                        <h1>Date</h1>
                                        <span> {{ $product->month }} {{ $product->day }}, {{ $product->year }} </span>
                                    </div>
                                    <div class="meta">
                                        <span class="uppertitle">Our Crazy Skills</span>
                                        <h1>Things We are Good for</h1>
                                        <div class="custom_content">
                                            <p>Test this for your enjoy</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- #content -->
    <!-- Social Profiles -->
    <!-- Footer -->
</div>
@endsection
