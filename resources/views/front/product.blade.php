@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar">
	<div class="container">
		<div class="row">
			<div class="span8">
				<h1>Product</h1>
			</div>
			<div class="span4 right_aligned">
				<div class="breadcrumbs">
					
				</div>									
			</div>
		</div>
	</div>
</section>

<section class="clearfix ">
	<div class="container">
		<ul id="filters" class="portfolio_filter option-set clearfix" data-option-key="filter">
			<li><a href="javascript:" data-option-value="*" class="selected">All</a></li>
			@foreach($_category as $category)
				<li><a href="javascript:" data-option-value=".category{{ $category->product_category_id }}">{{ $category->product_category_name }}</a></li>
			@endforeach
		</ul>
		<div id="dz_latest_portfolio" class="portfolio_items clearfix isotope">
			@foreach($_product as $product)
			<div class="portfolio_item portfolio_item_4 category{{ $product->product_category_id }} isotope-item">
				<div class="overlayed">
					<img src="{{ $product->image }}" alt="">
					<a class="overlay" href="/product_content?id={{ $product->product_id }}">
						<p class="overlay_title">{{ $product->product_name }}</p>
						<p class="portfolio_item_tags">&#8369; {{ $product->price }}</p>
					</a>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endsection
