@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar" class="rw" style="margin: 0 -15px; background-image: none; background-color: #2774DA; margin-top: -70px;">
		<div class="container">
			<div class="row">
				<div class="span12">
					<h1>About us</h1>
				</div>
			</div>
		</div>
	</section>

	<section class="dzen_section_DD " style="background-color: #fff; margin: 0 -15px;">
		<div class="dzen_section_content">
			<div class="dzen_container">
				<div style="overflow: auto; clear: both;">
					<div class="dzen_column_DD_span6 about_us_introducton">
						<h3 class="rw bold">
							<span>Mission</span>
						</h3>
						<div class="margin_bottom rb">
							<div>
								<span>
									{{ $mission->about_description }}
								</span>
							</div>
						</div>
					</div>
					<div class="dzen_column_DD_span6 about_us_introducton">
						<h3 class="rw bold">
							<span>Vision</span>
						</h3>
						<div class="margin_bottom rb">
							<div>
								<span>
									{{ $vision->about_description }}
								</span>
							</div>
						</div>
					</div>
				</div>
				<div style="overflow: auto; clear: both; margin-top: 30px;">
					<div class="dzen_column_DD_span12 about_us_introducton">
						<h3 class="rw bold">
							<span>The People Behind</span>
						</h3>
						<h5 class="rw">
							<span>Team of Experts and Entrepreneurs</span>
						</h5>
						<div class="margin_bottom rb">
							<div>
								<span>
									{{ $about->about_description }}
								</span>
							</div>
						</div>
					</div>
				</div>
				<div style="overflow: auto; clear: both; margin-top: 30px;">
					<div class="dzen_column_DD_span12 about_us_introducton">
						<h3 class="rw bold">
							<span>Company Core Values</span>
						</h3>
						<h4 class="rw bold" style="margin-top: 25px;">
							<span>Distinction</span>
						</h4>
						<div class="margin_bottom rb">
							<div>
								<span style="white-space: pre-wrap;">A cut from a different cloth, UPMI offers what the competition can only dream of. Premium quality products & service you can exclusively purchase and avail of from the company.</span>
							</div>
						</div>
						</h3>
						<h4 class="rw bold" style="margin-top: 25px;">
							<span>Integrity</span>
						</h4>
						<div class="margin_bottom rb">
							<div>
								<span style="white-space: pre-wrap;">Offer honest to goodness products which work and does what it's specified to do.
Best value for Money
Product costs are proportionate to the suggested retail value and purpose it was created for.</span>
							</div>
						</div>
						</h3>
						<h4 class="rw bold" style="margin-top: 25px;">
							<span>Sharing</span>
						</h4>
						<div class="margin_bottom rb">
							<div>
								<span style="white-space: pre-wrap;">A world of wealth is out for everyone. UPMI being a firm believer of this mantra, shares its means and methods that is not limited to acquiring affluence, but from a wholistic standpoint. Comapny equips those in its sphere of influence to pursue health, wellness, knowledge, sense of community and ultimately financial independence.</span>
							</div>
						</div>
						<h4 class="rw bold" style="margin-top: 25px;">
							<span>Filipino Ingenuity</span>
						</h4>
						<div class="margin_bottom rb">
							<div>
								<span style="white-space: pre-wrap;">Strategies and products pay tribute to the Filipino business acumen, conceptualized by Filipinos, made by Filipinos to serve a thriving Filipino market, together with the global audience.</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- <section class="dzen_section_DD section_with_gray_body ">
		<header>
			<div class="dzen_container">
				<h3>Our skills</h3>
				<p>
					Lorem ipsum 
					dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod 
					tempor invidunt ut labore.Consetetur sadipscing elitr, sed diam nonumy 
					eirmod tempor invidunt ut labore.
				</p>
			</div>
		</header>
		<div class="dzen_section_content">
			<div class="dzen_container">
				<div class="dzen_column_DD_span3 ">
					<div class="dzen_knob_wrapper ">
						<div class="dzen_knob_inner_wrap">
							<div class="dzen_knob_number_sign">
								<span class="dzen_knob_number">78</span>%
							</div>
							<input class="dzen_knob" value="78" data-width="100%" data-number="78" data-fgcolor="#128ae0" data-bgcolor="#e1e7eb" data-innercolor="" data-linecap="default" data-thickness="0.1" data-anglearc="" data-angleoffset="" data-hidenumber="" data-innercircledistance="" type="text">
						</div>
						<h3>Photoshop</h3>
					</div>
				</div>
				<div class="dzen_column_DD_span3 ">
					<div class="dzen_knob_wrapper ">
						<div class="dzen_knob_inner_wrap">
							<div class="dzen_knob_number_sign">
								<span class="dzen_knob_number">32</span>%
							</div>
							<input class="dzen_knob" value="32" data-width="100%" data-number="32" data-fgcolor="#25bf80" data-bgcolor="#e1e7eb" data-innercolor="" data-linecap="default" data-thickness="0.1" data-anglearc="" data-angleoffset="" data-hidenumber="" data-innercircledistance="" type="text">
						</div>
						<h3>WordPress</h3>
					</div>
				</div>
				<div class="dzen_column_DD_span3 ">
					<div class="dzen_knob_wrapper ">
						<div class="dzen_knob_inner_wrap">
							<div class="dzen_knob_number_sign">
								<span class="dzen_knob_number">64</span>%
							</div>
							<input class="dzen_knob" value="64" data-width="100%" data-number="64" data-fgcolor="#056ab2" data-bgcolor="#e1e7eb" data-innercolor="" data-linecap="default" data-thickness="0.1" data-anglearc="" data-angleoffset="" data-hidenumber="" data-innercircledistance="" type="text">
						</div>
						<h3>SEO Services</h3>
					</div>
				</div>
				<div class="dzen_column_DD_span3 ">
					<div class="dzen_knob_wrapper ">
						<div class="dzen_knob_inner_wrap">
							<div class="dzen_knob_number_sign">
								<span class="dzen_knob_number">99</span>%
							</div>
							<input class="dzen_knob" value="99" data-width="100%" data-number="100" data-fgcolor="#25bfba" data-bgcolor="#e1e7eb" data-innercolor="" data-linecap="default" data-thickness="0.1" data-anglearc="" data-angleoffset="" data-hidenumber="" data-innercircledistance="" type="text">
						</div>
						<h3>Awesomeness</h3>
					</div>
				</div>
			</div>
		</div>
	</section> -->

	<section id="our_team" class="dzen_section_DD " style="background-color: #F2F4F5; margin: 0 -15px;">
		<header>
			<div class="dzen_container">
				<h3 class="bold">Meet our team</h3>
				<p class="rw">
					When a team outgrows individual performance and learns team confidence, excellence becomes a reality. 
				</p>
			</div>
		</header>
		<div class="dzen_section_content">
			<div class="dzen_container">
				@foreach($_team as $team)
				<div class="dzen_column_DD_span3 " style="margin: 0 7.5px">
					<div class="dzen_team_member">
						<div class="dzen_overlayed">
							<img src="{{ $team->image }}" alt="Johny Knoxville">
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
							<p class="dzen_team_member_position">{{ $team->team_role }}</p>
							<div class="dzen_container">
								<div class="dzen_column_DD_span6">
									<img src="{{ $team->image }}" alt="Johny Knoxville">
								</div>
								<div class="dzen_column_DD_span6">
									{{ $team->team_description }}
									<span class="clear"></span>
									<!-- <div class="dzen_progress_bar ">
										<span class="dzen_meter_label">PHP
										</span>
										<div class="dzen_meter">
											<div class="dzen_meter_percentage dzen_meter_blue" data-percentage="90">
												<span>90%</span>
											</div>
										</div>
									</div>
									<div class="dzen_progress_bar ">
										<span class="dzen_meter_label">JavaScript
										</span>
										<div class="dzen_meter">
											<div class="dzen_meter_percentage dzen_meter_blue" data-percentage="80">
												<span>80%</span>
											</div>
										</div>
									</div>
									<div class="dzen_progress_bar ">
										<span class="dzen_meter_label">Great Ideas
										</span>
										<div class="dzen_meter">
											<div class="dzen_meter_percentage dzen_meter_blue" data-percentage="100">
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
					<div class="aligncenter margin_bottom">{{ $team->team_description }}
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- <section class="dzen_section_DD pattern_overlayed dzen-parallax our_partners_section" data-background_image="images/people.jpg" data-parallax="0.5">
		<header>
			<div class="dzen_container">
				<h3>Our partners</h3>
			</div>
		</header>
		<div class="dzen_section_content">
			<div class="dzen_container">
				<div class="dzen_column_DD_span2 aligncenter">
					<span class="clear">
					</span>
					<div class="dzen-animo " data-animation="flipInY" data-duration="1000" data-delay="0">
						<img src="/resources/assets/path/images/tf.jpg" alt="">
					</div>
					<span class="clear">
					</span>
				</div>
				<div class="dzen_column_DD_span2 aligncenter">
					<span class="clear">
					</span>
					<div class="dzen-animo " data-animation="flipInY" data-duration="1000" data-delay="200">
						<img src="/resources/assets/path/images/cc.jpg" alt="">
					</div>
					<span class="clear">
					</span>
				</div>
				<div class="dzen_column_DD_span2 aligncenter">
					<span class="clear">
					</span>
					<div class="dzen-animo " data-animation="flipInY" data-duration="1000" data-delay="400">
						<img src="/resources/assets/path/images/pd.jpg" alt="">
					</div>
					<span class="clear">
					</span>
				</div>
				<div class="dzen_column_DD_span2 aligncenter">
					<span class="clear">
					</span>
					<div class="dzen-animo " data-animation="flipInY" data-duration="1000" data-delay="600">
						<img src="/resources/assets/path/images/gr.jpg" alt="">
					</div>
					<span class="clear">
					</span>
				</div>
				<div class="dzen_column_DD_span2 aligncenter">
					<span class="clear">
					</span>
					<div class="dzen-animo " data-animation="flipInY" data-duration="1000" data-delay="800">
						<img src="/resources/assets/path/images/aj.jpg" alt="">
					</div>
					<span class="clear">
					</span>
				</div>
				<div class="dzen_column_DD_span2 aligncenter">
					<span class="clear">
					</span>
					<div class="dzen-animo " data-animation="flipInY" data-duration="1000" data-delay="1000">
						<img src="/resources/assets/path/images/ad.jpg" alt="">
					</div>
					<span class="clear">
					</span>
				</div>
			</div>
		</div>
	</section> -->

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
