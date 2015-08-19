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
		<div class="row">
			<div class="blog_category_index span12 content_with_right_sidebar">
				@foreach($_mindsync as $mindsync)
				<div class="post post_wrapper clearfix">
					<div class="post_content">
						<div class="post_main" style="margin-left: 0;">
							<div class="row" style="margin-bottom: 50px;">
								<div class="span4" style="float: left;">
									<h2>
									<a href="javascript:">{{ $mindsync->mindsync_title }}</a>
									</h2>
									<p>
										{{ $mindsync->mindsync_description }}
									</p>
								</div>
								<div class="span8" style="float: left;">
									<div class="videoWrapper-youtube">
										<iframe src="http://www.youtube.com/embed/{{ $mindsync->mindsync_video }}?showinfo=0&amp;autohide=1&amp;related=0" frameborder="0" allowfullscreen=""></iframe>
									</div>
								</div>
							</div>
							<div class="row">
								@foreach($mindsync->image as $images)
								<div class="span3">
									<img src="{{ $images }}" alt="" style="max-width: 100%; margin: auto;">
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</section>
@endsection