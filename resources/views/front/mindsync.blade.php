@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar">
	<div class="container">
		<div class="row">
			<div class="span8">
				<h1>Mind Sync Project</h1>
			</div>
			<div class="span4 right_aligned">
				
			</div>
		</div>
	</div>
</section>
<section>
	<div class="container">
		<div class="row" style="margin-bottom: 30px;">
			<div class="blog_category_index span12 content_with_right_sidebar" id="slick">
				@foreach($_image as $image)
				<div><img src="{{ $image->image }}" style="width: 100%;"></div>
				@endforeach
			</div>
		</div>
		<div class="dzen_section_DD section_title_left" style="padding-top: 30px;">
			<header>
				<div class="dzen_container">
					<h3 style="margin-bottom: 0;">Videos</h3>
				</div>
			</header>
		</div>
		<div class="row" style="margin-bottom: 30px;">
			<div class="blog_category_index span12 content_with_right_sidebar">
				<div class="post post_wrapper clearfix" style="border: 0; margin: 0;">
					<div class="post_content" style="padding: 0;">
						<div class="post_main" style="margin-left: 0;">
							<div class="row" style="margin-bottom: 50px;">
								@foreach($_video as $video)
								<div class="span6" style="float: left; padding: 0 7.5px; margin: 0; margin-bottom: 15px;">
									<div class="videoWrapper-youtube">
										<iframe width="100%" src="http://www.youtube.com/embed/{{ $video->mindsync_video }}?showinfo=0&amp;autohide=1&amp;related=0" frameborder="0" allowfullscreen=""></iframe>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="dzen_section_DD section_title_left" style="padding-top: 0; padding-bottom: 0;"> 
			<header>
				<div class="dzen_container">
					<h3 style="margin-bottom: 0;">Testimonials</h3>
				</div>
			</header>
		</div>
		<div class="row">
			<section class="dzen_section_DD section_title_left no_padding_bottom" style="padding-top: 30px;">
				<div class="dzen_section_content">
					<div class="dzen_container">
						<div class="dzen_column_DD_span12">
							@foreach($_testimony as $testimony)
							<blockquote class="dzen_blockquote">
								<p>
									{{ $testimony->mindsync_description }} <small>{{ $testimony->mindsync_title }} </small>
								</p>
							</blockquote>
							@endforeach
						</div>
					</div>
				</div>
			</section>
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