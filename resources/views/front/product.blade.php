@extends('front.layout')
@section('content')
<div class="top_wrapper   no-transparent">
    <!-- .header -->
    <!-- Page Head -->
    <div class="header_page basic background_image" style="background-image:url(/resources/assets/ausart/assets/uploads/2014/11/123122.jpg);background-repeat: no-repeat; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; color:#2f383d; ">
        <div class="container">
            <style>
            .breadcrumbs_c {
            color: #000000;
            font-size: 13px;
            }
            h1.title {
            color: #000000 !important;
            font-size: 50px
            }
            </style>
            <h1 class="title">Products</h1>
       
        </div>
    </div>
    <section id="content" class="content_portfolio layout-fullsize items-layout-boxed" style="background:#fff;">
        <h1 class="portfolio_big_title"></h1>
        <!-- Portfolio Filter -->
        <nav id="portfolio-filter" class="portfolio_page_nav v1">
            <div class="container">
                <ul class="filters_v1">
                    <li class="active all"><a href="#" data-filter="*"><i class="moon-grid-5"></i>View All</a></li>
                    @foreach($_category as $category)
                        <li class="other"><a href="#" data-filter=".category{{ $category->product_category_id }}">{{ $category->product_category_name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row-fluid">
                <section id="portfolio-preview-items" class="four-cols span12" data-nr="4">
                    <div class="row filterable">
                    <!-- Portfolio Normal Mode -->
                    <!-- item -->
                    @foreach($_product as $product)
                    <div class="portfolio-item v1 category{{ $product->product_category_id }}" data-category="category{{ $product->product_category_id }}">
                        <div class="he-wrap tpl2">
                            <img src="{{ $product->image }}" alt="">
                            <div class="shape4"></div>
                            <div class="overlay he-view">
                                <div class="bg a0" data-animate="fadeIn">
                                    <div class="center-bar v1">
                                        <div class="centered">
                                            <div class="portfolio_go a0" data-animate="zoomIn">
                                                <a href="port_2_col.html"><i class="moon-redo"></i></a>
                                            </div>
                                        </div>
                                        <a href="{{ $product->image }}" class="title a1 lightbox-gallery lightbox" data-animate="fadeInUp">{{ $product->product_name }}</a>
                                        <a href="#" class="categories a2" data-animate="zoomIn">{{ $product->price }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <h3><a href="port_2_col.html">{{ $product->product_name }}</a></h3>
                            <span class="categories">₱ {{ $product->price }}</span>
                        </div>
                    </div>
                    @endforeach
                    <!-- Portfolio Normal Mode End -->
                    <div class="p_pagination">
                        <div class="pull-right">
                            <div class="nav-previous"></div>
                            <div class="nav-next"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <!-- Social Profiles -->
    <!-- Footer -->
</div>
@endsection