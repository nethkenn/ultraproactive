@extends('front.layout')
@section('content')
	<section id="dz_main_slider" style="border: 3px solid #fff;">
		<div>
			<div class="single-item">	
				@foreach($_slide as $slide)
				<div>
					<!-- MAIN IMAGE -->
					<img src="{{ $slide->image }}"  alt="{{ $slide->slide_image }}" style="width: 100%;">
				</div>
				@endforeach
			</div>
		</div>
	<!-- END REVOLUTION SLIDER -->	
	</section>

	<!-- <section class="dzen_section_DD ">
		<div class="dzen_section_content">
			<div class="dzen_container">
				 <div class="dzen_column_DD_span3 ">
					<div class="dzen_service_box dzen_service_box_round ">
						<div>
							<a href="#" target="_self" class="dzen_icon_boxed">
								<i class="ABdev_icon-leaf"></i>
							</a>
							<a href="#" target="_self">
								<h3>Test</h3>
							</a>
						</div>
						<p>
							Test
						</p>
					</div>
				</div>
				<div class="dzen_column_DD_span3 ">
					<div class="dzen_service_box dzen_service_box_round ">
						<div>
							<a href="#" target="_self" class="dzen_icon_boxed"><i class="ABdev_icon-tools"></i></a>
							<a href="#" target="_self">
								<h3>Test</h3>
							</a>
						</div>
						<p>
							Test
						</p>
					</div>
				</div>
				<div class="dzen_column_DD_span3 ">
					<div class="dzen_service_box dzen_service_box_round ">
						<div>
							<a href="#" target="_self" class="dzen_icon_boxed">
								<i class="ABdev_icon-barchartasc"></i>
							</a>
							<a href="#" target="_self">
								<h3>Test</h3>
							</a>
						</div>
						<p>
							Test
						</p>
					</div>
				</div>
				<div class="dzen_column_DD_span3 ">
					<div class="dzen_service_box dzen_service_box_round ">
						<div>
							<a href="#" target="_self" class="dzen_icon_boxed">
								<i class="ABdev_icon-analytics-piechart"></i>
							</a>
							<a href="#" target="_self">
								<h3>Test</h3>
							</a>
						</div>
						<p>
							Test
						</p>
					</div>
				</div>
			</div> 
		</div>
	</section> -->
	<div style="clear: both; overflow: auto;">
		<section class="dzen_section_DD section_from_blog col-md-12" style="background-color: #2774da; padding-top: 5px; border: 3px solid #fff; margin: 30px 0; padding: 5px 30px;">
			<header>
				<div>
					<div style="color: #fff0b8; font-size: 30px; font-weight: bold; padding: 20px 0 50px; font-family: 'Raleway', sans-serif;">News and Announcements</div>
				</div>
			</header>
			<div class="dzen_section_content">
				<div>
					<div>
						@foreach($_news as $news)
						<div class="dzen_posts_shortcode clearfix">
							<a class="dzen_latest_news_shortcode_thumb" href="/news_content?id={{ $news->news_id }}">
								<img src="{{ $news->image }}" alt="">
							</a>
							<div class="dzen_latest_news_shortcode_content">
								<h5 style="font-family: 'Raleway', sans-serif; font-size: 18px; font-weight: bold; margin: 0;">
									<a style="color: #fff;" href="/news_content?id={{ $news->news_id }}">{{ $news->news_title }}</a>
								</h5>
								<div style="font-family: 'Raleway', sans-serif; font-size: 12px; font-weight: 300; color: #80aef1; margin-bottom: 5px;">{{ $news->month }} {{ $news->day }}, {{ $news->year }} (2 Minutes Ago)</div>
								<p style="font-family: 'Raleway', sans-serif; font-size: 14px; font-weight: 400; color: #aacfff;">
									{{ substr($news->news_description, 0, 195) . "..." }}
								</p>
								<div class="pull-right">
									<a href="/news_content?id={{ $news->news_id }}" style="color: #fedb5a; font-size: 14px; font-weight: bold; font-family: 'Raleway', sans-serif;">» Read More</a>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</section>
		<!-- <section class="col-md-7" style="padding-top: 30px; text-align: center;">
			<img src="/resources/assets/frontend/img/puzzle.png" class="img-responsive" style="margin: auto;">
		</section> -->	
	</div>
	<section id="our_team" class="dzen_section_DD " style="background-color: #fff; margin: auto -15px;">
		<header>
			<div class="dzen_container">
				<div class="head-text">Featured Products and Programs</div>
				<p class="sub-text">
					We Promote High Quality Products
				</p>
			</div>
		</header>
		<div class="dzen_section_content">
			<div class="dzen_container">
				<div class="dzen_column_DD_span4  dzen-animo" data-animation="fadeInUp" data-duration="1000" data-delay="0">
					<div class="dzen_team_member">
						<div class="dzen_overlayed" style="border-radius: 0;">
							<img src="/resources/assets/path/images/feature1.jpg" style="border-radius: 0;">
						</div>
						<a class="dzen_team_member_link dzen_team_member_modal_link" href="#">
							<span class="dzen_team_member_name" style="font-family: 'Raleway', sans-serif;">Mind Sync Project</span>
							<span class="dzen_team_member_position"></span>
						</a>
					</div>
					<div class="aligncenter margin_bottom" style="font-family: 'Raleway', sans-serif;">Mind Sync allows your child to develop the use of his/her midbrain which iginites the potential genius of your child.
					</div>
				</div>
				<div class="dzen_column_DD_span4  dzen-animo" data-animation="fadeInUp" data-duration="1000" data-delay="0">
					<div class="dzen_team_member">
						<div class="dzen_overlayed" style="border-radius: 0;">
							<img src="/resources/assets/path/images/feature2.jpg" style="border-radius: 0;">
						</div>
						<a class="dzen_team_member_link dzen_team_member_modal_link" href="#">
							<span class="dzen_team_member_name">Ultra Nutrifit Meal</span>
							<span class="dzen_team_member_position"></span>
						</a>
					</div>
					<div class="aligncenter margin_bottom" style="font-family: 'Raleway', sans-serif;">Stay healthy and slim with nurifit. It allows you to develop a healthy regimen which keep you away from all kinds of disease.
					</div>
				</div>
				<div class="dzen_column_DD_span4  dzen-animo" data-animation="fadeInUp" data-duration="1000" data-delay="0">
					<div class="dzen_team_member">
						<div class="dzen_overlayed" style="border-radius: 0;">
							<img src="/resources/assets/path/images/feature3.jpg" style="border-radius: 0; height: 234px;">
						</div>
						<a class="dzen_team_member_link dzen_team_member_modal_link" href="#">
							<span class="dzen_team_member_name">Buffer System Booster</span>
							<span class="dzen_team_member_position"></span>
						</a>
					</div>
					<div class="aligncenter margin_bottom" style="font-family: 'Raleway', sans-serif;">Gives you the perfect acid and alkaline blood pH of 7.4 to ensure optimum immune system
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="about_us" class="dzen_section_DD " style="margin-left: -15px; margin-right: -15px;">
		<header>
			<div class="dzen_container">
				<div class="head-text">About Us</div>
				<p class="sub-text">
					Ultra Proactive Marketing Inc. was incorporated in 2014. The company made its mark in the MLM industry by introducing unique high quality products and services in the market. By now, the company is making a serious and aggresive bid to be one of the best MLM companies in the country. The management team is composed of professionals and experts from various fields, with a combined experienced of more than 30 years in corporate management, direct selling and network marketing industry.
				</p>
			</div>
		</header>
		<div class="dzen_section_content">
			<div class="dzen_container">
				<div class="dzen_column_DD_span12 ">
					<h3 class="column_title_left">
						<span>Why choose us?</span>
					</h3>
					<div role="tablist" class="dzen-accordion" data-expanded="1">
						<h3 tabindex="-1" aria-selected="false" aria-controls="ui-accordion-1-panel-1" id="ui-accordion-1-header-1" role="tab">
							<span class="ui-accordion-header-icon ui-icon-triangle-1-e"></span>Mission
						</h3>
						<div class="op" aria-hidden="true" aria-expanded="false" role="tabpanel" aria-labelledby="ui-accordion-1-header-1" id="ui-accordion-1-panel-1" >
							ULTRA PROACTIVE MARKETING INC. believes in creating sustainable livelihood for people who need them most through the creation of economic opportunities that empower them. The company also believes in making available to ordinary people the opportunity to become millionaires through the commercialization of unique products and services that benefit end-users and buyers
						</div>
						<h3 tabindex="-1" aria-selected="false" aria-controls="ui-accordion-1-panel-2" id="ui-accordion-1-header-2" role="tab">
							<span class="ui-accordion-header-icon ui-icon-triangle-1-e"></span>Vision
						</h3>
						<div class="op" aria-hidden="true" aria-expanded="false" role="tabpanel" aria-labelledby="ui-accordion-1-header-2" id="ui-accordion-1-panel-2">
							ULTRA PROACTIVE MARKETING INC. envisions itself to be a household name by becoming the top and most trusted company in the industry of personal care, health & wellness, unique & beneficial services, as well as to be one of the top companies in the multi-level-marketing business, not only in the Philippines, but also in the whole world
						</div>
					</div>
				</div>
				<!-- <div class="dzen_column_DD_span6 ">
					<h3 class="column_title_left">
						<span>Our crazy skills</span>
					</h3>
					<div class="dzen_progress_bar ">
						<span class="dzen_meter_label">Marketing</span>
						<div class="dzen_meter">
							<div class="dzen_meter_percentage dzen_meter_blue" data-percentage="80">
								<span>80%</span>
							</div>
						</div>
					</div>
					<div class="dzen_progress_bar ">
						<span class="dzen_meter_label">Management</span>
						<div class="dzen_meter">
							<div class="dzen_meter_percentage dzen_meter_dark_blue" data-percentage="90">
								<span>90%</span>
							</div>
						</div>
					</div>
					<div class="dzen_progress_bar ">
						<span class="dzen_meter_label">Design</span>
						<div class="dzen_meter">
							<div class="dzen_meter_percentage dzen_meter_green" data-percentage="68">
								<span>68%</span>
							</div>
						</div>
					</div>
					<div class="dzen_progress_bar ">
						<span class="dzen_meter_label">Great ideas</span>
						<div class="dzen_meter">
							<div class="dzen_meter_percentage dzen_meter_aquamarin" data-percentage="100">
								<span>100%</span>
							</div>
						</div>
					</div>
					<div class="dzen_progress_bar ">
						<span class="dzen_meter_label">Awesomeness</span>
						<div class="dzen_meter">
							<div class="dzen_meter_percentage dzen_meter_blue" data-percentage="100">
								<span>100%</span>
							</div>
						</div>
					</div>
				</div> -->
			</div>
		</div>		
	</section>

	<section id="our_work" class="dzen_section_DD " style="margin-left: -15px; margin-right: -15px; background-color: #fff;">
		<header>
			<div class="dzen_container">
				<div class="head-text">Our Products</div>
				<p class="sub-text">
					We assure and guarantee you that our products are all top quality and high end products.
				</p>
			</div>
		</header>
		<div class="dzen_section_content">
			<div class="dzen_container">
				<div class="dzen_column_DD_span12 ">
					<ul id="filters" class="portfolio_filter option-set clearfix" data-option-key="filter">
						<li><a href="javascript:" data-option-value="*" class="selected">All</a></li>
						@foreach($_category as $category)
							<li><a href="javascript:" data-option-value=".category{{ $category->product_category_id }}">{{ $category->product_category_name }}</a></li>
						@endforeach
					</ul>
					<div id="dz_latest_portfolio" class="clearfix isotope">
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
					<div class="more_portfolio_link">
						<a href="/product">See more products</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- <section class="dzen_section_DD aligncenter pattern_overlayed dzen-parallax" style="margin: 0 -15px;">
		<div class="dzen_section_content">
			<div class="dzen_container">
				<div class="dzen_column_DD_span12 ">
					<span class="clear"></span>
					<blockquote class="dzen_blockquote">
						<p>
							It is better to lead from behind and to put others in front, especially when you celebrate victory when nice things occur.<br>You take the front line when there is danger. Then people will appreciate your leadership.<small>Anonymous<small>CEO of UltraProactive</small> </small>
						</p>
					</blockquote>
					<span class="clear"></span>
				</div>
			</div>
		</div>
	</section> -->

	<section id="our_team" class="dzen_section_DD " style="background-color: #F2F4F5; margin: 0 -15px;">
		<header>
			<div class="dzen_container">
				<div class="head-text">Meet Our Team</div>
				<p class="sub-text">
					When a team outgrows individual performance and learns team confidence, excellence becomes a reality.
				</p>
			</div>
		</header>
		<div class="dzen_section_content">
			<div class="dzen_container">
				@foreach($_team as $team)
				<div class="dzen_column_DD_span3  dzen-animo" data-animation="fadeInUp" data-duration="1000" data-delay="0" style="margin: 0 7.5px;">
					<div class="dzen_team_member">
						<div class="dzen_overlayed">
							<img src="{{ $team->image }}" alt="{{ $team->team_title }}">
							<div class="dzen_overlay">
								<p>
									<a href="#" target="_self"><i class="ABdev_icon-twitter"></i></a>
									<a href="#" target="_self"><i class="ABdev_icon-linkedin"></i></a>
									<a href="#" target="_self"><i class="ABdev_icon-facebook"></i></a>
								</p>
							</div>
						</div>
						<a class="dzen_team_member_link dzen_team_member_modal_link" href="#">
							<span class="dzen_team_member_name">{{ $team->team_title }}</span>
							<span class="dzen_team_member_position">{{ $team->team_role }}</span>
						</a>
						<div class="dzen_team_member_modal">
							<h4 class="dzen_team_member_name">{{ $team->team_title }}</h4>
							<p class="dzen_team_member_position">
								{{ $team->team_role }}
							</p>
							<div class="dzen_container">
								<div class="dzen_column_DD_span6">
									<img src="{{ $team->image }}" alt="Johny Knoxville">
								</div>
								<div class="dzen_column_DD_span6">
									{{ $team->team_description }}
									<span class="clear"></span>
									<!-- <div class="dzen_progress_bar ">
										<span class="dzen_meter_label">PHP</span>
										<div class="dzen_meter">
											<div class="dzen_meter_percentage .dzen_meter_blue" data-percentage="90">
												<span>90%</span>
											</div>
										</div>
									</div>
									<div class="dzen_progress_bar ">
										<span class="dzen_meter_label">JavaScript</span>
										<div class="dzen_meter">
											<div class="dzen_meter_percentage .dzen_meter_blue" data-percentage="80">
												<span>80%</span>
											</div>
										</div>
									</div>
									<div class="dzen_progress_bar ">
										<span class="dzen_meter_label">Great Ideas</span>
										<div class="dzen_meter">
											<div class="dzen_meter_percentage .dzen_meter_blue" data-percentage="100">
												<span>100%</span>
											</div>
									</div>
									</div> -->
								</div>
							</div>
							<div class="dzen_team_member_modal_close">X
							</div>
						</div>
					</div>
					<div class="aligncenter margin_bottom">
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>

	

	<!-- <section class="dzen_section_DD no_padding callout_box_blue">
		<div class="dzen_section_content">
			<div class="dzen_container">
				<div class="dzen_column_DD_span12 ">
					<div class="dzen-callout_box color_white no_margin">
						<div class="dzen_container">
							<div class="dzen_column_DD_span9">
								<span class="dzen-callout_box_title">Ready to buy this theme? This is call to action</span>
								<p>
									Very easy to customize. Fully layered PSD with multi-purpose features. You can buy it right now
								</p>
							</div>
							<div class="dzen_column_DD_span3">
								<a href="#" target="_self" class="dzen-button dzen-button_light dzen-button_large">Buy it now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
@endsection
@section('script')
<script type="text/javascript">
;(function($){
    $('.single-item').slick({
	  	infinite: true,
	  	autoplay: true,
	  	autoplaySpeed: 2000,
	  	adaptiveHeight: true
    });
})(jQuery);
</script>
<script type="text/javascript">
;(function($){
	BackgroundCheck.init({
	  targets: '.slick-next'
	});
})(jQuery);
</script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/frontend/css/home.css">
@endsection
