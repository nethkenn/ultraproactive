@extends('front.layout')
@section('content')
<div class="top_wrapper   no-transparent">
	<div id="fws_556827e0349e4" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 80px !important; padding-bottom: 0px !important; ">
		<div class="bg-overlay" style="background:rgba(, , , 0.5);z-index:1;"></div>
		<div class="container  dark">
			<div class="section_clear">
				<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
					<div class="wpb_wrapper">
						<div class="dynamic_slideshow wpb_content_element">
							<div class="slideshow_container flexslider slide_layout_fixed" id="flex">
								<ul class="slides slide_flexslider">
									@foreach($_slide as $slide)
									<li class="slide_element slide3 frame3"><img src='{{ $slide->image }}' /> </li>
									@endforeach
								</ul>
							</div>
						</div>
						<div style='margin-top:-35px' class="divider__ big_shadow"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="flexslider">
		<ul class="slides">
			@foreach($_slide as $slide)
			<li>
				<img src="{{ $slide->image }}" />
			</li>
			@endforeach
		</ul>
	</div>-->
	<!-- .header -->
	<section id="content" style="" class="composer_content">
		<div id="fws_5559b27a6e0af" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 80px !important; padding-bottom: 0px !important; ">
			<div class="container  dark">
				<div class="section_clear">
					<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
						<div class="wpb_wrapper">
							<div class="wpb_content_element dynamic_page_header style_3">
								<h1 style="font-size:36px; color:#009dcd">Welcome to PROLIFE Family!</h1>
								<div class="line_under">
									<div class="line_center"></div>
								</div>
								<div class="line_under below_line">
									<div class="line_center"></div>
								</div>
								<p class="description style_3">PROLIFE NWT believes in Family, the fundamental unit of a society. It is the living treasure of gold. It is made strong not by the headcounts but by the root of valued culture, commitment of time and harmony.
									Just like in Prolife Family, we want the best and all the convenience we can share to our members.
									Together, we have established a company that delivers high quality products and excellent e-services that brings each home the benefits of our natural environment and the comfort of technology.
									Prolife NWT  has strategically ventured with trusted and reputed companies for our associates to enjoy hassle-free online services  and privileges at their fingertips.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="fws_5559b27a6ecce" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 0px !important; padding-bottom: 60px !important; ">
			<div class="container  dark">
				<div class="section_clear">
					<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
						<div class="wpb_wrapper">
							<div class=" services_medium wpb_content_element ">
								<div class="icon_wrapper">
									<div class="overlay"></div><i class="fa fa-pagelines"></i></div>
									<h4><a href="#">NATURE</a></h4>
									<p>We offer various lines of natural and organic beauty products that keeps you beautiful and healthy inside and out.
										PROLIFE wants to bring out the best in you! Our essential beauty products can help you achieve what you want. Fairer and beautiful skin is not only for the few. Regular use of PROLIFE beauty soaps will help you achieve that radiant and supple skin .
										Start your day with our herbal power drinks, from green coffee to  chocolate to the very healthy  and revitalizing juice!
									</p>
									<div class="read_more"><a href="/about" class="readmore">BE HEALTHY.</a></div>
								</div>
							</div>
						</div>
						<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
							<div class="wpb_wrapper">
								<div class=" services_medium wpb_content_element ">
									<div class="icon_wrapper">
										<div class="overlay"></div><i class="fa fa-money"></i></div>
										<h4><a href="#">WEALTH</a></h4>
										<p>Unravel the mystery of financial freedom. Unlock your ability to earn more money, save and get what you dream. We can show you how it can be done.
											Everybody wishes of alleviating their financial status. Venture into a world wherein you can have the chance to break free from financial lock-ups.
											Build your dream house, buy a new car or travel as often as you want. Everything is possible. All you need to do is just to invest your time. Act now!
										</p>
										<div class="read_more"><a href="/about" class="readmore">BE FREE.</a></div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
								<div class="wpb_wrapper">
									<div class=" services_medium wpb_content_element ">
										<div class="icon_wrapper">
											<div class="overlay"></div><i class="moon-mobile-2"></i></div>
											<h4><a href="#">TECHNOLOGY</a></h4>
											<p>Experience the speed and comfort at your fingertips through our fast and reliable on –line services.
												PROLIFE is your one-stop shop from sending your remittances to booking your flights.
												We want you to avoid the long queue to send money.
												Move out of the line and do all these at the comfort of your home.
											</p>
											<div class="read_more"><a href="/about" class="readmore">BE CONNECTED.</a></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5559b27a70671" class="wpb_row animate_onoffset  vc_row-fluid   row-dynamic-el section-style parallax_section   " style="background-repeat: no-repeat; padding-top: 90px !important; padding-bottom: 90px !important; ">
						<div class="parallax_bg" style="background-image: url(/resources/assets/ausart/assets/uploads/2015/01/4-1-copy.jpg); background-position: 50% 0px; background-attachment:fixed !important"></div>
						<div class="container animate_onoffset light">
							<div class="section_clear" style="opacity: 0;">
								<div class="vc_col-sm-3 wpb_column column_container" style="" data-animation="" data-delay="0">
									<div class="wpb_wrapper">
										<div class="animated_counter">
											<div class="icons"><i class="moon-users-3"></i></div>
											<div class="count_to animate_onoffset">
												<div class="odometer" data-number="235" data-duration="2000"></div>
											</div>
											<div class="title_counter">
											<h4>Clients</h4></div>
										</div>
									</div>
								</div>
								<div class="vc_col-sm-3 wpb_column column_container" style="" data-animation="" data-delay="0">
									<div class="wpb_wrapper">
										<div class="animated_counter">
											<div class="icons"><i class="moon-file-3"></i></div>
											<div class="count_to animate_onoffset">
												<div class="odometer" data-number="145" data-duration="2000"></div>
											</div>
											<div class="title_counter">
											<h4>Projects</h4></div>
										</div>
									</div>
								</div>
								<div class="vc_col-sm-3 wpb_column column_container" style="" data-animation="" data-delay="0">
									<div class="wpb_wrapper">
										<div class="animated_counter">
											<div class="icons"><i class="steadysets-icon-coffee"></i></div>
											<div class="count_to animate_onoffset">
												<div class="odometer" data-number="2357" data-duration="2000"></div>
											</div>
											<div class="title_counter">
											<h4>Cups of Caffe</h4></div>
										</div>
									</div>
								</div>
								<div class="vc_col-sm-3 wpb_column column_container" style="" data-animation="" data-delay="0">
									<div class="wpb_wrapper">
										<div class="animated_counter">
											<div class="icons"><i class="moon-code"></i></div>
											<div class="count_to animate_onoffset">
												<div class="odometer" data-number="8234" data-duration="2000"></div>
											</div>
											<div class="title_counter">
											<h4>Lines of Code</h4></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="container  dark">
						<div class="section_clear">
							<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
								<div class="wpb_wrapper">
									<div class="wpb_content_element services_media">
										<div class="img_div port3"><img src="/resources/assets/ausart/assets/uploads/picture/healthy.jpg" alt="" /></div>
										<h1><a href="#">Be Healthy</a></h1>
										<div class="serv_content">
											<p></p>
											<div class="col_one_third nobottommargin">
												<div class="feature-box media-box">
													<div class="fbox-desc">
														<p>“Live a life of beauty and youth.”</p>
													</div>
												</div>
											</div>
											<div class="col_one_third nobottommargin"></div>
											<p></p>
											</div><span class="read_more"><a href="/about">Learn More</a></span></div>
										</div>
									</div>
									<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
										<div class="wpb_wrapper">
											<div class="wpb_content_element services_media">
												<div class="img_div port3"><img src="/resources/assets/ausart/assets/uploads/picture/house.jpg" alt="" /></div>
												<h1><a href="#">Be Free</a></h1>
												<div class="serv_content">
													<p></p>
													<div class="col_one_third nobottommargin">
														<div class="feature-box media-box">
															<div class="fbox-desc">
																<p>“Enjoy financial freedom. Earn more, save more... for a better future. “</p>
															</div>
														</div>
													</div>
													<div class="col_one_third nobottommargin"></div>
													<p></p>
													</div><span class="read_more"><a href="/about">Learn More</a></span></div>
												</div>
											</div>
											<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
												<div class="wpb_wrapper">
													<div class="wpb_content_element services_media">
														<div class="img_div port3"><img src="/resources/assets/ausart/assets/uploads/picture/technology.jpg" alt="" /></div>
														<h1><a href="#">Be Connected</a></h1>
														<div class="serv_content">
															<p></p>
															<div class="col_one_third nobottommargin">
																<div class="feature-box media-box">
																	<div class="fbox-desc">
																		<p>“Your e-services at your fingertips”.</p>
																	</div>
																</div>
															</div>
															<div class="col_one_third nobottommargin"></div>
															<p></p>
															</div><span class="read_more"><a href="/about">Learn More</a></span></div>
														</div>
													</div>
												</div>
											</div>
											<div id="fws_5559b27a71986" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el full-width-content section-style    " style="background-color: #f6f6f6; padding-top: 90px !important; padding-bottom: 0px !important; ">
												<div class="col span_12  dark">
													<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
														<div class="wpb_wrapper">
															<div class="wpb_content_element dynamic_page_header style_3">
																<h1 style="font-size:36px; color:#3d3d3d">Our Products</h1>
																<div class="line_under">
																	<div class="line_center"></div>
																</div>
																<div class="line_under below_line">
																	<div class="line_center"></div>
																</div>
																<p class="description style_3">NATURE’S MASTERPIECE. “Take advantage of nature’s gift to us”.</p>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div id="fws_5559b27a72219" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el full-width-content section-style    " style="background-color: #f6f6f6; padding-top: 0px !important; padding-bottom: 0px !important; ">
												<div class="col span_12  dark">
													<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
														<div class="wpb_wrapper">
															<div class="home_portfolio ">
																<div class="">
																	<section id="portfolio-preview-items" class="four-cols animate_onoffset" data-nr="4">
																		<!-- Portfolio Normal Mode -->
																		<!-- item -->
																		@foreach($_product as $product)
																		<div class="portfolio-item html java  v2" data-id="3537">
																			<div class="he-wrap tpl2">
																				<img src="{{ $product->image }}" alt="">
																				<div class="overlay he-view">
																					<div class="bg a0" data-animate="fadeIn">
																						<div class="center-bar v1">
																							<div class="centered">
																								<div class="portfolio_go a0" data-animate="zoomIn">
																									<a href="port_single_left.html"><i class="moon-redo"></i></a>
																								</div>
																							</div>
																							<a href="/resources/assets/ausart/assets/uploads/2015/01/pink_planet_full.png" class="title a1 lightbox-gallery lightbox" data-animate="fadeInUp">{{ $product->product_name }}</a>
																							<a href="#" class="categories a2" data-animate="zoomIn">₱ {{ $product->price }}</a>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		@endforeach
																		<!-- Portfolio Normal Mode End -->
																		<!-- Portfolio Normal Mode -->
																	</section>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div id="fws_5559b27a89da7" class="wpb_row animate_onoffset  vc_row-fluid   row-dynamic-el section-style parallax_section   borders  " style="background-repeat: no-repeat; padding-top: 100px !important; padding-bottom: 100px !important; ">
												<div class="parallax_bg" style="background-image: url(/resources/assets/ausart/assets/uploads/2015/01/yteydf67y.jpg); background-position: 50% 0px; background-attachment:fixed !important"></div>
												<div class="container animate_onoffset light">
													<div class="section_clear">
														<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
															<div class="wpb_wrapper">
																<div class="wpb_content_element full_testimonials full">
																	<div class="row">
																		<h2>What they say</h2>
																		<div class="header style_3">
																			<div class="line_under">
																				<div class="line_center"></div>
																			</div>
																			<div class="line_under below_line">
																				<div class="line_center"></div>
																			</div>
																		</div>
																		<div class="carousel carousel_single_testimonial">
																		@foreach($_testimony as $testimony)
																		<div class="single_testimonial ">
																			<div class="content">
																				<p>{{ $testimony->testimony_text }}</p>
																				<div class="data">
																					<h6>{{ $testimony->testimony_person }}, <span class="position"> {{ $testimony->testimony_position }}</span></h6>
																				</div>
																			</div>
																			<span class="img_testimonial">
																				<img width="65" height="65" src="/resources/assets/ausart/assets/uploads/2015/01/shutterstock_95201956.min-1-150x150.jpg" class="attachment-65x65 wp-post-image" alt="shutterstock_95201956.min (1)" />
																			</span>
																		</div>
																		@endforeach
																											</div>
																										</div>
																										<div class="controls">
																											<a href="#" class="prev"></a>
																											<a href="#" class="next"></a>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				{{-- <div id="fws_5559b27a8caaf" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="background-color: #f6f6f6; padding-top: 60px !important; padding-bottom: 60px !important; ">
																					<div class="container  dark">
																						<div class="section_clear">
																							<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
																								<div class="wpb_wrapper">
																									<div id="fws_5559b27a8d3ae" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el standard_section    " style="padding-top: 0px !important; padding-bottom: 0px !important; ">
																										<div class="container  dark">
																											<div class="section_clear">
																												<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
																													<div class="wpb_wrapper">
																														<div class=" services_small wpb_content_element">
																															<div class="services_small_container">
																																<div class=" services_small_icon " style=""><i class="moon-pencil-6" style="color:;"></i> </div>
																																<div class="services_small_title">
																																	<h4><a href="#">POWER OF FLEXIBILITY</a></h4>
																																	<p>Nulla consequat massa quis enim. Veronum versus designus Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
																																</div>
																															</div>
																														</div>
																														<div class=" services_small wpb_content_element">
																															<div class="services_small_container">
																																<div class=" services_small_icon " style=""><i class="moon-cloud-upload" style="color:;"></i> </div>
																																<div class="services_small_title">
																																	<h4><a href="#">BEST BUY THEME</a></h4>
																																	<p>Nulla consequat massa quis enim. Veronum versus designus Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
																																</div>
																															</div>
																														</div>
																													</div>
																												</div>
																												<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
																													<div class="wpb_wrapper">
																														<div class=" services_small wpb_content_element">
																															<div class="services_small_container">
																																<div class=" services_small_icon " style=""><i class="moon-earth" style="color:;"></i> </div>
																																<div class="services_small_title">
																																	<h4><a href="#">Translation Ready</a></h4>
																																	<p>Nulla consequat massa quis enim. Veronum versus designus Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
																																</div>
																															</div>
																														</div>
																														<div class=" services_small wpb_content_element">
																															<div class="services_small_container">
																																<div class=" services_small_icon " style=""><i class="moon-pen-3" style="color:;"></i> </div>
																																<div class="services_small_title">
																																	<h4><a href="#">Great Design Layout</a></h4>
																																	<p>Nulla consequat massa quis enim. Veronum versus designus Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
																																</div>
																															</div>
																														</div>
																													</div>
																												</div>
																												<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
																													<div class="wpb_wrapper">
																														<div class=" services_small wpb_content_element">
																															<div class="services_small_container">
																																<div class=" services_small_icon " style=""><i class="linecon-icon-phone" style="color:;"></i> </div>
																																<div class="services_small_title">
																																	<h4><a href="#">Fully Responsive</a></h4>
																																	<p>Nulla consequat massa quis enim. Veronum versus designus Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
																																</div>
																															</div>
																														</div>
																														<div class=" services_small wpb_content_element">
																															<div class="services_small_container">
																																<div class=" services_small_icon " style=""><i class="moon-eye-8" style="color:;"></i> </div>
																																<div class="services_small_title">
																																	<h4><a href="#">100% Ready</a></h4>
																																	<p>Nulla consequat massa quis enim. Veronum versus designus Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
																																</div>
																															</div>
																														</div>
																													</div>
																												</div>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div> --}}
																				<div id="fws_5559b27a8eabd" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el full-width-content section-style    " style="padding-top: 90px !important; padding-bottom: 0px !important; ">
																					<div class="col span_12  dark">
																						<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
																							<div class="wpb_wrapper">
																								<div class="wpb_content_element dynamic_page_header style_3">
																									<h1 style="font-size:36px; color:#3d3d3d">Our Recent News</h1>
																									<div class="line_under">
																										<div class="line_center"></div>
																									</div>
																									<div class="line_under below_line">
																										<div class="line_center"></div>
																									</div>
																									<p class="description style_3">Showcase Your Work with Prolife It will be an Awesome Experience.</p>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div id="fws_5559b27a8f33b" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 30px !important; padding-bottom: 30px !important; ">
																					<div class="container  dark">
																						<div class="section_clear">
																							@foreach($_news as $news)
																							<div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
																								<div class="wpb_wrapper">
																									<div class="latest_blog wpb_content_element">
																										<div class="blog_posts">
																											<div class="posts">
																												<div class="blog-article grid"><img alt="image_blog" src="{{ $news->image }}">
																													<div class="blog_content">
																														<dl>
																															<dt class="dt_latest_blog">
																															<div class="date_divs">{{ $news->day }}</div>
																															<div class="month_div">{{ $news->month }}</div>
																															<div class="post_type"><i class="moon-pencil"></i></div>
																															</dt>
																															<dd>
																															<div class="content">
																																<h5><a href="/news_content?id={{ $news->news_id }}">{{ $news->news_title }}</a></h5>
																																<ul class="overlay">
																																	<li class="author">by Prolife</li>
																																</ul>
																																<p>{!! substr($news->news_description, 0, 170) !!}</p><a class="readmore" href="/news_content?id={{ $news->news_id }}">Read More</a>
																															</div>
																															</dd>
																														</dl>
																													</div>
																												</div>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																							@endforeach
																						</div>
																					</div>
																				</div>
																				<!-- <div id="fws_5559b27a9503d" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    borders  " style="background-image: url(/resources/assets/ausart/assets/uploads/2015/01/slider7.jpg); background-position: center top; background-repeat: no-repeat; padding-top: 90px !important; padding-bottom: 90px !important; ">
																					<div class="bg-overlay" style="background:rgba(, , , 0.7);z-index:1;"></div>
																					<div class="container  light">
																						<div class="section_clear">
																							<div class="vc_col-sm-6 wpb_column column_container" style="" data-animation="" data-delay="0">
																								<div class="wpb_wrapper">
																									<div class="wpb_content_element media media_el animate_onoffset"><img src="/resources/assets/ausart/assets/uploads/2015/01/imacoik.png" alt="" class="type_image media_animation animation_left alignment_left" style="" /></div>
																								</div>
																							</div>
																							<div class="vc_col-sm-6 wpb_column column_container" style="" data-animation="" data-delay="0">
																								<div class="wpb_wrapper">
																									<div class="header " style="">
																									<h2>WHAT IS IMPORTANT FOR US?</h2></div>
																									<div class="wpb_text_column wpb_content_element ">
																										<div class="wpb_wrapper">
																											<p>Lorem ipsum dolor slo onsec designs pretium. Tueraliquet nel Morbi nec In Curabitur nel. Morbi nec In Curabitur nel dolor slo onsec designs dolor slo onsec designs . Nulla consequat massa quis enim. Donec pede justo. Fringilla vel, aliquet nec,</p>
																										</div>
																									</div>
																									<div id="fws_5559b27a964ff" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el standard_section    " style="padding-top: 0px !important; padding-bottom: 0px !important; ">
																										<div class="container  dark">
																											<div class="section_clear">
																												<div class="vc_col-sm-6 wpb_column column_container" style="" data-animation="" data-delay="0">
																													<div class="wpb_wrapper">
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Lorem ipsum dolor onsec. </h4>
																															<p></p>
																															</dd>
																														</dl>
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Lorem ipsum dolor onsec. </h4>
																															<p></p>
																															</dd>
																														</dl>
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Lorem ipsum dolor </h4>
																															<p></p>
																															</dd>
																														</dl>
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Lorem ipsum dolor onsec. </h4>
																															<p></p>
																															</dd>
																														</dl>
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Lorem ipsum dolor onsec. </h4>
																															<p></p>
																															</dd>
																														</dl>
																													</div>
																												</div>
																												<div class="vc_col-sm-6 wpb_column column_container" style="" data-animation="" data-delay="0">
																													<div class="wpb_wrapper">
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Morbi lorem ipsum dolor</h4>
																															<p></p>
																															</dd>
																														</dl>
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Vorbi Inrurabitur dolor </h4>
																															<p></p>
																															</dd>
																														</dl>
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Morbi Inrurabitur dolor </h4>
																															<p></p>
																															</dd>
																														</dl>
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Tueraliquet nel desirus </h4>
																															<p></p>
																															</dd>
																														</dl>
																														<dl class="dl-horizontal list">
																															<dt>
																															<div class="overlay"></div>
																															<div class="circle"><i class="moon-checkmark"></i></div>
																															</dt>
																															<dd>
																															<h4>Tueraliquet nel desirus </h4>
																															<p></p>
																															</dd>
																														</dl>
																													</div>
																												</div>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div id="fws_5559b27a97e49" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 90px !important; padding-bottom: 60px !important; ">
																					<div class="container  dark">
																						<div class="section_clear">
																							<div class="vc_col-sm-6 wpb_column column_container" style="" data-animation="" data-delay="0">
																								<div class="wpb_wrapper">
																									<div class="header " style="">
																									<h2>Our Skills</h2></div>
																									<div class="wpb_text_column wpb_content_element ">
																										<div class="wpb_wrapper">
																											<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
																										</div>
																									</div>
																									<div class="wpb_content_element block_skill">
																										<div class="skill animate_onoffset" data-percentage="75">
																											<h6 class="skill_title">User Interface Design</h6>
																											<div class="prog" style="width:0%; background:#94e0fe;"><span style="float:right">75%</span></div>
																										</div>
																										<div class="skill animate_onoffset" data-percentage="90">
																											<h6 class="skill_title">Branding &amp; Indentity</h6>
																											<div class="prog" style="width:0%; background:#23d5ff;"><span style="float:right">90%</span></div>
																										</div>
																										<div class="skill animate_onoffset" data-percentage="50">
																											<h6 class="skill_title">Project Managment</h6>
																											<div class="prog" style="width:0%; background:#0baaff;"><span style="float:right">50%</span></div>
																										</div>
																										<div class="skill animate_onoffset" data-percentage="60">
																											<h6 class="skill_title">Project Managment</h6>
																											<div class="prog" style="width:0%; background:#0a81cd;"><span style="float:right">60%</span></div>
																										</div>
																									</div>
																								</div>
																							</div>
																							<div class="vc_col-sm-6 wpb_column column_container" style="" data-animation="" data-delay="0">
																								<div class="wpb_wrapper">
																									<div class="header " style="">
																									<h2>Why Choose Us</h2></div>
																									<div class="wpb_accordion wpb_content_element not-column-inherit">
																										<div class="accordion " id="accordion1" data-active-tab="">
																											<div class="accordion-group wpb_accordion_section group">
																												<div class="accordion-heading in_head"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#toggle19724">5 Stars Support</a></div>
																												<div id="toggle19724" class="accordion-body collapse in">
																													<div class="accordion-inner">
																														<div class="wpb_text_column wpb_content_element ">
																															<div class="wpb_wrapper">
																																<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
																															</div>
																														</div>
																													</div>
																												</div>
																											</div>
																											<div class="accordion-group wpb_accordion_section group">
																												<div class="accordion-heading "><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#toggle34392">Great Page Builder</a>
																											</div>
																											<div id="toggle34392" class="accordion-body collapse ">
																												<div class="accordion-inner">
																													<div class="wpb_text_column wpb_content_element ">
																														<div class="wpb_wrapper">
																															<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
																														</div>
																													</div>
																												</div>
																											</div>
																										</div>
																										<div class="accordion-group wpb_accordion_section group">
																											<div class="accordion-heading "><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#toggle12498">Awesome Design Layout</a></div>
																											<div id="toggle12498" class="accordion-body collapse ">
																												<div class="accordion-inner">
																													<div class="wpb_text_column wpb_content_element ">
																														<div class="wpb_wrapper">
																															<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
																														</div>
																													</div>
																												</div>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div> -->
																			<div id="fws_5559b27a9a709" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="background-color: #f6f6f6; padding-top: 90px !important; padding-bottom: 60px !important; ">
																				<div class="container  dark">
																					<div class="section_clear">
																						<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
																							<div class="wpb_wrapper">
																								<div class="header " style="">
																								<h2>Team Members</h2></div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																			<div id="fws_5559b27a9af50" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="background-color: #f6f6f6; padding-top: 0px !important; padding-bottom: 90px !important; ">
																				<div class="container  dark">
																					<div class="section_clear">
																						@foreach($_team as $team)
																						<div class="vc_col-sm-3 wpb_column column_container" style="" data-animation="" data-delay="0">
																							<div class="wpb_wrapper">
																								<div class="wpb_content_element">
																									<div class="one-staff">
																										<div class="img_staff"><img src="{{ $team->image }}" alt=""></div>
																										<div class="content ">
																											<h6>{{ $team->team_title }}</h6>
																											<div class="position_title"><span class="position">{{ $team->team_role }}</span></div>
																											<p>{{ $team->team_description }}</p>
																										</div>
																										<div class="social_widget">
																											<ul>
																												<li class="facebook"><a href="#" title="Facebook"><i class="moon-facebook"></i></a></li>
																												<li class="twitter"><a href="#" title="Twitter"><i class="moon-twitter"></i></a></li>
																												<li class="google_plus"><a href="#" title="Google Plus"><i class="moon-google_plus"></i></a></li>
																												<li class="pinterest"><a href="#" title="Pinterest"><i class="moon-pinterest"></i></a></li>
																												<li class="linkedin"><a href="#" title="Linkedin"><i class="moon-linkedin"></i></a></li>
																												<li class="main"><a href="#" title="Mail"><i class="moon-mail"></i></a></li>
																											</ul>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																						@endforeach
																					</div>
																				</div>
																			</div>
																			<div id="fws_5559b27aa3ff1" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el standard_section    " style="padding-top: 0px !important; padding-bottom: 0px !important; ">
																				<div class="container  dark">
																					<div class="section_clear">
																						<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
																							<div class="wpb_wrapper">
																								<div class="dark_clients clients_el ">
																									<div class="header">
																									<h2>Our Partners</h2></div>
																									<section class="row clients clients_caro">
																										<div class="item">
																											<a href="#" title="">
																												<img src="/resources/assets/ausart/assets/uploads/2014/11/Untitled-26.png" alt="">
																											</a>
																										</div>
																										<div class="item">
																											<a href="#" title="">
																												<img src="/resources/assets/ausart/assets/uploads/2014/11/Untitled-212.png" alt="">
																											</a>
																										</div>
																										<div class="item">
																											<a href="#" title="">
																												<img src="/resources/assets/ausart/assets/uploads/2014/11/Untitled-222.png" alt="">
																											</a>
																										</div>
																										<div class="separator"></div>
																										<div class="item">
																											<a href="#" title="">
																												<img src="/resources/assets/ausart/assets/uploads/2014/11/Untitled-242.png" alt="">
																											</a>
																										</div>
																										<div class="item">
																											<a href="#" title="">
																												<img src="/resources/assets/ausart/assets/uploads/2014/11/Untitled-252.png" alt="">
																											</a>
																										</div>
																										<div class="item">
																											<a href="#" title="">
																												<img src="/resources/assets/ausart/assets/uploads/2014/11/Untitled-252.png" alt="">
																											</a>
																										</div>
																										<div class="item">
																											<a href="#" title="">
																												<img src="/resources/assets/ausart/assets/uploads/2014/11/Untitled-222.png" alt="">
																											</a>
																										</div>
																										<div class="item">
																											<a href="#" title="">
																												<img src="/resources/assets/ausart/assets/uploads/2014/11/Untitled-212.png" alt="">
																											</a>
																										</div>
																									</section>
																									<div class="controls">
																										<a class="prev"></a>
																										<a class="next"></a>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</section>
																		<!-- Social Profiles -->
																		<!-- Footer -->
																	</div>
@endsection