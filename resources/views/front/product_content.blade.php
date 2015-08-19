@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar">
        <div class="container">
            <div class="row">
                <div class="span8">
                    <h1>{{ $product->product_name }}</h1>
                </div>
                <div class="span4 right_aligned">
                    <div class="breadcrumbs">
                     
                    </div>                                  
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="span8 content_with_right_sidebar">
                    <img src="{{ $product->image }}" class="portfolio_item_image" alt="">                
                </div>
                <div id="portfolio_item_meta" class="span4">
                    <h2 class="column_title_left">Description</h2>
                    <p>
                        {{ $product->product_info }}
                    </p>
                    <h2 class="column_title_left">Details</h2>
                    <p class="portfolio_single_detail">
                        <span class="portfolio_item_meta_label">Date:</span>
                        <span class="portfolio_item_meta_data">{{ $product->month }} {{ $product->day }}, {{ $product->year }}</span>
                    </p>
                    <p class="portfolio_single_detail">
                        <span class="portfolio_item_meta_label">Price:</span>
                        <span class="portfolio_item_meta_data">{{ $product->price }}</span>
                    </p>
                    <p class="portfolio_single_detail">
                        <span class="portfolio_item_meta_label">Category:</span>
                        <span class="portfolio_item_meta_data">{{ $category->product_category_name }}</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="related_portfolio">
        <div class="container">
            <h3 class="column_title_left">Similar Products</h3>
            <div class="row">
                @foreach($_product as $products)
                <div class="portfolio_item portfolio_item_4 identity illustrations">
                    <div class="overlayed">
                        <img src="{{ $products->image }}" alt="">
                        <a class="overlay" href="/product_content?id={{ $products->product_id }}">
                            <p class="overlay_title">{{ $products->product_name }}</p>
                            <p class="portfolio_item_tags"></p>
                        </a>
                    </div>
                </div>  
                @endforeach    
            </div>
            <div id="single_portfolio_pagination" class="clearfix">
                <!-- <span class="prev" style="{{ $product->product_id == '1' ? 'display: none;' : '' }}">
                    <a href="/product_content?id={{ $prev_id }}" rel="prev"><i class="ABdev_icon-chevron-left"></i> Prev Product</a>
                </span>
                <span class="next" style="{{ $product->product_id == $product_id ? 'display: none;' : '' }}">
                    <a href="/product_content?id={{ $next_id }}" rel="next"><i class="ABdev_icon-chevron-right"></i> Next Product</a>
                </span> -->
            </div>
        </div>
    </section>
@endsection
