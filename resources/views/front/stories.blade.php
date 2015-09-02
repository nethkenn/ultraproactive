@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar" style="margin: 0 -15px; background-image: none; background-color: #2774DA; margin-top: -70px;">
	<div class="container">
		<div class="row">
			<div class="span8">
				<h1>Stories</h1>
			</div>
			<div class="span4 right_aligned">
				<div class="breadcrumbs">
					
				</div>									
			</div>
		</div>
	</div>
</section>

<section style="background-color: #fff; margin: 0 -15px;">
	<div class="container">
		<div class="row">
			<div class="blog_category_index span12 content_with_right_sidebar">
				@foreach($_stories as $stories)
				<div class="post post_wrapper clearfix">
					<div class="post_content">
						<div class="post_main" style="margin: 0;">
							<h2 class="rw bold">
								<a href="javascript:">{{ $stories->stories_title }}</a>
							</h2>
							<div class="videoWrapper-youtube">
								<iframe src="https://www.youtube.com/embed/{{ $stories->stories_link }}" frameborder="0" allowfullscreen=""></iframe>
							</div>										
							<p class="rw">
								{{ $stories->stories_description }}
							</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			<!-- <aside class="span4 sidebar sidebar_right">
				<div class="widget widget_categories">
					<div class="sidebar-widget-heading">
						<h3>Categories</h3>
					</div>		
					<ul>
						<li><a href="/stories">All</a></li>
						<li><a href="/stories">Test Category</a></li>
						<li><a href="/stories">Test Category</a></li>
					</ul>
				</div>				
			</aside> -->
		</div>
		<!-- <section id="blog_pagination" class="clearfix">
			<div class="container">
				<div class="pagination"> 
					<a class="prev page-numbers" href="right_sidebar_blog.html"><i class="ABdev_icon-chevron-left"></i>Previous</a>
					<span class="page-numbers current">1</span> 
					<a class="page-numbers" href="right_sidebar_blog.html">2</a> 
					<a class="page-numbers" href="right_sidebar_blog.html">3</a> 
					<a class="next page-numbers" href="right_sidebar_blog.html">Next<i class="ABdev_icon-chevron-right"></i></a>
				</div>
			</div>
		</section>	 -->
	</div>
</section>
@endsection