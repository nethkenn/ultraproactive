@extends('front.layout')
@section('content')
<div class="top_wrapper   no-transparent">
	<!-- .header -->
	<!-- Page Head -->
	<div class="header_page basic background_image colored_bg" style="background-image:url();background-repeat: no-repeat;background:#f6f6f6; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; color:#2f383d; ">
		<div class="container">
			<h1 class="title">Partners</h1>
		</div>
	</div>
	<section id="content" class="composer_content">
		<div id="fws_556c47c7c0707" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el standard_section    " style="padding-top: 0px !important; padding-bottom: 0px !important; ">
			<div class="container  dark">
				<div class="section_clear">
					<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
						<div class="wpb_wrapper">
							<div class="wpb_content_element dynamic_page_header style_2">
								<h1 style="font-size:30px; color:#3a3a3a">What is in store for you?</h1>
							</div>
							<div class="wpb_text_column wpb_content_element ">
								<div class="wpb_wrapper">
									<p style="word-break: keep-all !important; white-space: pre-wrap;">{{ $partner->about_description }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="fws_556c48d32ea98" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 0px !important; padding-bottom: 80px !important; ">
            <div class="bg-overlay" style="background:rgba(, , , 0.5);z-index:1;"></div>
            <div class="container  dark">
                <div class="section_clear">
                    <div class="vc_col-sm-4 wpb_column column_container" style="" data-animation="" data-delay="0">
                        <div class="wpb_wrapper">
                            <div class="header " style="">
                                <h2>We Provide</h2></div>
                            <div class="wpb_content_element block_skill">
                               <ul style="padding-left: 20px;">
                               		<li>Beauty Products</li>
                               		<li>Health Drinks</li>
                               		<li>Hygienic Products</li>
                               		<li>On line remittance 24/7</li>
                               		<li>E- learning</li>
                               		<li>E-payments</li>
                               		<li>Airline ticket discounts</li>
                               </ul>
                            </div>
                        </div>
                    </div>
                    <div class="vc_col-sm-8 wpb_column column_container" style="" data-animation="" data-delay="0">
                        <div class="wpb_wrapper">
                            <div class="header " style="margin-top: 13px;">
                                <h2>Testimonials</h2></div>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper">
                                    <div class="wpb_text_column wpb_content_element ">
                                        <div class="wpb_wrapper">
                                        	@foreach($_testimony as $testimony)
                                            <div class="testi-holder">
                                            	<div class="testi-text">
                                            		{{ $testimony->testimony_text }}
                                            	</div>
                                            	<div class="testi-name">
                                            		- {{ $testimony->testimony_person }}, {{ $testimony->testimony_position }}
                                            	</div>	
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div id="fws_556c48d32ff40" class="wpb_row animate_onoffset  vc_row-fluid  animate_onoffset row-dynamic-el section-style    " style="padding-top: 0px !important; padding-bottom: 60px !important; ">
			<div class="container  dark">
				<div class="section_clear">
					<div class="vc_col-sm-12 wpb_column column_container" style="" data-animation="" data-delay="0">
						<div class="wpb_wrapper">
							<div class="dark_clients clients_el ">
								<div class="header">
								<h2>Our Partners</h2></div>
								<section class="row clients clients_caro weaktype">
									@foreach($_partner as $partner)
									<div class="item">
										<a href="{{ $partner->partner_link }}" title="" target="_blank">
											<img src="{{ $partner->image }}" alt="">
										</a>
									</div>
									@endforeach
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
	</div>
</section>
<!-- Social Profiles -->
<!-- Footer -->
</div>
@endsection