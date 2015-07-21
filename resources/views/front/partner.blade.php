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
									<p style="word-break: keep-all !important; white-space: pre-wrap;">Do you want to buy a house or a condo unit? Travel and relax in a city of your choice with airline discount? Or simply dine in a recommended restaurant?
As a PROLIFE MEMBER,  you are entitled for exclusive discounts and privileges.
We have  various partners from different industries like, real estate developers, medical centers, travel and tours, restaurants, hotels and many more.
Just present your membership card and you can instantly avail  from 10% to 50% discounts.
Just click on our partner’s links for more details.

*Subject to the terms and conditions of the affiliated partners
									</p>
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
										<a href="{{ $partner->partner_link }}" title="">
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