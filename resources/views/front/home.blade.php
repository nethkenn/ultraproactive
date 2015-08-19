@extends('front.layout')
@section('content')
	<section id="dz_main_slider">
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
	<section id="our_team" class="dzen_section_DD ">
		<header>
			<div class="dzen_container">
				<h3>Featured Products and Programs</h3>
				<p>
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
							<span class="dzen_team_member_name">Mind Sync Project</span>
							<span class="dzen_team_member_position"></span>
						</a>
						<div class="dzen_team_member_modal">
							<h4 class="dzen_team_member_name">Mind Sync Project</h4>
							<p class="dzen_team_member_position">
							</p>
							<div class="dzen_container">
								<div class="dzen_column_DD_span6">
									<img src="/resources/assets/path/images/feature1.jpg" alt="Johny Knoxville">
								</div>
								<div class="dzen_column_DD_span6">
									Mind Sync allows your child to develop the use of his/her midbrain which iginites the potential genius of your child.
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
					<div class="aligncenter margin_bottom">Mind Sync allows your child to develop the use of his/her midbrain which iginites the potential genius of your child.
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
						<div class="dzen_team_member_modal">
							<h4 class="dzen_team_member_name">Ultra Nutrifit Meal</h4>
							<p class="dzen_team_member_position">
							</p>
							<div class="dzen_container">
								<div class="dzen_column_DD_span6">
									<img src="/resources/assets/path/images/feature2.jpg" alt="Johny Knoxville">
								</div>
								<div class="dzen_column_DD_span6">
									Stay healthy and slim with nurifit. It allows you to develop a healthy regimen which keep you away from all kinds of disease.
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
					<div class="aligncenter margin_bottom">Stay healthy and slim with nurifit. It allows you to develop a healthy regimen which keep you away from all kinds of disease.
					</div>
				</div>
				<div class="dzen_column_DD_span4  dzen-animo" data-animation="fadeInUp" data-duration="1000" data-delay="0">
					<div class="dzen_team_member">
						<div class="dzen_overlayed" style="border-radius: 0;">
							<img src="/resources/assets/path/images/feature3.jpg" style="border-radius: 0;">
						</div>
						<a class="dzen_team_member_link dzen_team_member_modal_link" href="#">
							<span class="dzen_team_member_name">Buffer System Booster</span>
							<span class="dzen_team_member_position"></span>
						</a>
						<div class="dzen_team_member_modal">
							<h4 class="dzen_team_member_name">Buffer System Booster</h4>
							<p class="dzen_team_member_position">
							</p>
							<div class="dzen_container">
								<div class="dzen_column_DD_span6">
									<img src="/resources/assets/path/images/feature3.jpg" alt="Johny Knoxville">
								</div>
								<div class="dzen_column_DD_span6">
									Gives you the perfect acid and alkaline blood pH of 7.4 to ensure optimum immune system
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
					<div class="aligncenter margin_bottom">Gives you the perfect acid and alkaline blood pH of 7.4 to ensure optimum immune system
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="about_us" class="dzen_section_DD " style="margin-top: -30px;">
		<header>
			<div class="dzen_container">
				<h3>About us</h3>
				<p>
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
						<div aria-hidden="true" aria-expanded="false" role="tabpanel" aria-labelledby="ui-accordion-1-header-1" id="ui-accordion-1-panel-1">
							ULTRA PROACTIVE MARKETING INC. believes in creating sustainable livelihood for people who need them most through the creation of economic opportunities that empower them. The company also believes in making available to ordinary people the opportunity to become millionaires through the commercialization of unique products and services that benefit end-users and buyers
						</div>
						<h3 tabindex="-1" aria-selected="false" aria-controls="ui-accordion-1-panel-2" id="ui-accordion-1-header-2" role="tab">
							<span class="ui-accordion-header-icon ui-icon-triangle-1-e"></span>Vision
						</h3>
						<div aria-hidden="true" aria-expanded="false" role="tabpanel" aria-labelledby="ui-accordion-1-header-2" id="ui-accordion-1-panel-2">
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

	<section id="our_work" class="dzen_section_DD " style="margin-top: -20px;">
		<header>
			<div class="dzen_container">
				<h3>Our Products</h3>
				<p>
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

	<section class="dzen_section_DD aligncenter pattern_overlayed dzen-parallax">
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
	</section>

	<section id="our_team" class="dzen_section_DD ">
		<header>
			<div class="dzen_container">
				<h3>Meet our team</h3>
				<p>
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

	<section class="dzen_section_DD section_from_blog">
		<header>
			<div class="dzen_container">
				<h3>Latest News and Announcements</h3>
				<p>
					News travels fast in places where nothing much ever happens.
				</p>
			</div>
		</header>
		<div class="dzen_section_content">
			<div class="dzen_container">
				<div class="dzen_column_DD_span12 ">
					@foreach($_news as $news)
					<div class="dzen_posts_shortcode clearfix dzen_column_DD_span6">
						<a class="dzen_latest_news_shortcode_thumb" href="/news_content?id={{ $news->news_id }}">
							<img src="{{ $news->image }}" alt="">
						</a>
						<div class="dzen_latest_news_shortcode_content">
							<h5>
								<a href="/news_content?id={{ $news->news_id }}">{{ $news->news_title }}</a>
							</h5>
							<p class="dzen_latest_news_time">
								<span class="month">{{ $news->month }}</span> 
								<span class="day">{{ $news->day }}</span>
								<span class="year">, {{ $news->year }}</span>
							</p>
							<p>
								{{ substr($news->news_description, 0, 195) . "..." }}
							</p>
						</div>
					</div>
					@endforeach
				</div>
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
	<style type="text/css">
		#dz_main_slider
		{
			-webkit-box-shadow: 0px 0px 8px 2px rgba(0,0,0,0.2);
			   -moz-box-shadow: 0px 0px 8px 2px rgba(0,0,0,0.2);
			        box-shadow: 0px 0px 8px 2px rgba(0,0,0,0.2);
		}
	</style>
@endsection
@section('script')
<script type="text/javascript">
;(function($){
    $('.single-item').slick({
	  	infinite: true,
	  	autoplay: true,
	  	autoplaySpeed: 2000,
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