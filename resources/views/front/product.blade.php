@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar" class="rw" style="margin: 0 -15px; background-image: none; background-color: #2774DA; margin-top: -70px;">
	<div class="container">
		<div class="row">
			<div class="span12">
				<h1>Product</h1>
			</div>
		</div>
	</div>
</section>

<section class="clearfix " style="background-color: #fff; margin: 0 -15px;">
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
				<div class="wowe"></div>
				<div class="lalagyanan">
					<div class="overlayed">
						<img src="{{ $product->image }}" alt="">
						<a class="overlay" href="/product_content?id={{ $product->product_id }}">
							<p class="overlay_title">{{ $product->product_name }}</p>
							<p class="portfolio_item_tags">&#8369; {{ $product->price }}</p>
						</a>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endsection
@section("script")
{{-- <script type="text/javascript" src="/resources/assets/equal-height/equal-height.js"></script> --}}
<script type="text/javascript">
// jQuery(function ($) 
// {
//   $('.equal-height').matchHeight(
//   	{
//   		byRow: false,
//   	}
//   );
// });
</script>
@endsection
@section("css")
<style type="text/css">
.portfolio_item
{
	position: relative;
}
.portfolio_item .wowe
{
	padding-top: 100%;
}
.portfolio_item .lalagyanan
{
	position: absolute;
	height: 100%;
	width: 100%;
	top: 0;
}
.portfolio_item .overlayed
{
	width: 100%;
	height: 100%;
}
.portfolio_item img
{
	height: 100%;
	width: 100%;
}
</style>
@endsection
