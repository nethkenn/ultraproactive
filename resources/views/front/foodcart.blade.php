@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar" class="rw" style="margin: 0 -15px; background-image: none; background-color: #2774DA; margin-top: -70px;">
	<div class="container">
		<div class="row">
			<div class="span12">
				<h1>FOODCART</h1>
			</div>
		</div>
	</div>
</section>
<section style="background-color: #fff; margin: 0 -15px;">
	<div class="container">
		<div class="row" style="margin-bottom: 30px;">
			<div class="blog_category_index span12 content_with_right_sidebar" id="slick">
				@foreach($_foodcart as $foodcart)
				<div><img src="{{ $foodcart->image }}" style="width: 100%;"></div>
				@endforeach
			</div>
		</div>
	</div>
</section>
@endsection
@section("script")
<script type="text/javascript" src="/resources/assets/slick/slick.min.js"></script>
<script type="text/javascript">
;(function($){
$('#slick').slick({
	autoplay: true,
	autoplaySpeed: 2000,
	dots: true,
	adaptiveHeight: true
}); 
})(jQuery);
</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/resources/assets/slick/slick.css">
<link rel="stylesheet" type="text/css" href="/resources/assets/slick/slick-theme.css">
@endsection
