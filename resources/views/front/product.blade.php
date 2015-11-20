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
			<div class="portfolio_item portfolio_item_4 category{{ $product->product_category_id }} isotope-item equal-height">
				<div class="overlayed equal-height">
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
@section("script")
<script type="text/javascript" src="/resources/assets/equal-height/equal-height.js"></script>
<script type="text/javascript">
jQuery(function ($) 
{
  $('.equal-height').matchHeight(
  	{
  		byRow: false,
  	}
  );
});
</script>
@endsection
@section("css")
<style type="text/css">
.portfolio_item img
{
	max-height: 250px;
}
</style>
@endsection
