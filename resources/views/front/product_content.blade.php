@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar" class="rw" style="margin: 0 -15px; background-image: none; background-color: #2774DA; margin-top: -70px;">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <h1>{{ $product->product_name }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section style="margin: 0 -15px; background-color: #fff">
        <div class="container">
            <div class="row">
                <div class="span8 content_with_right_sidebar">
                    <img src="{{ $product->image }}" class="portfolio_item_image" alt="" style="max-height: 500px; margin: auto;">                
                </div>
                <div id="portfolio_item_meta" class="span4">
                    <h2 class="column_title_left">Description</h2>
                    <p class="rw">
                        {{ $product->product_info }}
                    </p>
                    <h2 class="column_title_left">Details</h2>
                    <p class="portfolio_single_detail rw">
                        <span class="portfolio_item_meta_label">Date:</span>
                        <span class="portfolio_item_meta_data">{{ $product->month }} {{ $product->day }}, {{ $product->year }}</span>
                    </p>
                    <p class="portfolio_single_detail rw">
                        <span class="portfolio_item_meta_label">Price:</span>
                        <span class="portfolio_item_meta_data">{{ $product->price }}</span>
                    </p>
                    <p class="portfolio_single_detail rw">
                        <span class="portfolio_item_meta_label">Category:</span>
                        <span class="portfolio_item_meta_data">{{ $category->product_category_name }}</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="related_portfolio" style="margin: 0 -15px; background-color: #fff">
        <div class="container">
            <h3 class="column_title_left">Similar Products</h3>
            <div class="row">
                @foreach($_product as $products)
                <div class="portfolio_item portfolio_item_4 identity illustrations" style="height: 250px;">
                    <div class="overlayed" style="height: 250px;">
                        <img src="{{ $products->image }}" alt="" style="max-height: 250px;">
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
