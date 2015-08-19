@extends('front.layout')
@section('content')
<section id="title_breadcrumbs_bar">
	<div class="container">
		<div class="row">
			<div class="span8">
				<h1>Contact</h1>
			</div>
			<div class="span4 right_aligned">
				<div class="breadcrumbs">
					
				</div>									
			</div>
		</div>
	</div>
</section>

<section class="dzen_section_DD">
	<header>
		<div class="dzen_container">
			<h3>Get in touch with us</h3>
			<p>
				Questions or Concerns? Don't hesitate to get in touch.
			</p>
		</div>
	</header>
	<div class="dzen_section_content">
		<div class="dzen_container">
			<div class="dzen_column_DD_span6">
				<div class="dzencf" id="dzencf-wrapper" dir="ltr">
					<form action="#" method="post" class="contact-form">
							<input type="text" name="name" size="40" class="dzencf-text" placeholder="YOUR NAME (Required)">
							<input type="email" name="email" size="40" class="dzencf-text dzencf-email dzencf-validates-as-email" placeholder="YOUR EMAIL (Required)">
							<input type="text" name="subject" size="40" class="dzencf-text" placeholder="YOUR SUBJECT">
							<textarea name="message" cols="40" rows="10" class="dzencf-textarea" placeholder="YOUR MESSAGE"></textarea>
							<input type="submit" value="Send" class="dzencf-submit" id="dzencf-submit">
					</form>
					<div class="dzencf-response-output dzencf-display-none"></div>
				</div>
			</div>
			<div class="dzen_column_DD_span6">
				<h3 class="column_title_left">
					<span>Contact info
					</span>
				</h3>
				<table>
					<tbody>
						<tr>
							<td>
								<p class="contact_page_info">
									<span class=""><i class="ABdev_icon-envelope"></i></span>ultraproactive2014@gmail.com
								</p>
								<p class="contact_page_info">
									<span class=""><i class="ABdev_icon-home"></i></span>Second level, Metrowalk Commercial Complex, Meralco Avenue,Ortigas Business Center, 1605 Pasig City, Philippines
								</p>
								<p class="contact_page_info">
									<span class=""><i class="ABdev_icon-globe"></i></span>www.ultraproactive.net
								</p>
							</td>
							<td>
								<p class="contact_page_info">
									<span class=""><i class="ABdev_icon-phonealt"></i></span>+63 (02) 234-1993
								</p>
								<p class="contact_page_info">
									<span class=""><i class="ABdev_icon-draft"></i></span>0927-7447286
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				<h3 class="column_title_left">
					<span>Stay social</span>
				</h3>
				<div class="dzen_follow_us">
					<a title="Follow us on Facebook" class="dzen_socialicon_facebook dzen_tooltip" data-gravity="s" href="#" target="_blank"><i class="ABdev_icon-facebook"></i></a>
					<a title="Follow us on Twitter" class="dzen_socialicon_twitter dzen_tooltip" data-gravity="s" href="#" target="_blank"><i class="ABdev_icon-twitter"></i></a>
					<a title="Follow us on Google+" class="dzen_socialicon_googleplus dzen_tooltip" data-gravity="s" href="#" target="_blank"><i class="ABdev_icon-googleplus"></i></a>
					<a title="Follow us on Linkedin" class="dzen_socialicon_linkedin dzen_tooltip" data-gravity="s" href="#" target="_blank"><i class="ABdev_icon-linkedin"></i></a>
					<a title="Follow us on Youtube" class="dzen_socialicon_youtube dzen_tooltip" data-gravity="s" href="#" target="_blank"><i class="ABdev_icon-youtube"></i></a>
					<a title="Our RSS feed" class="dzen_socialicon_feed dzen_tooltip" data-gravity="s" href="#" target="_blank"><i class="ABdev_icon-rss"></i></a>
					<a title="Our Vimeo Profile" class="dzen_socialicon_vimeo dzen_tooltip" data-gravity="s" href="#" target="_blank"><i class="ABdev_icon-vimeo"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="dzen_section_DD no_padding section_body_fullwidth">
	<div class="dzen_section_content">
		<div class="dzen_container">
			<div class="dzen_column_DD_span12">
				<div id="dzen_google_map_1" 
					data-map_type="ROADMAP" 
					data-lat="14.586892" 
					data-lng="121.064550"
					data-zoom="17" 
					data-scrollwheel="0" 
					data-maptypecontrol="1" 
					data-pancontrol="1" 
					data-zoomcontrol="1" 
					data-scalecontrol="1" 
					data-markertitle="Our Company" 
					data-markericon="/resources/assets/path/images/map-pointer.png" 
					data-markercontent="Our Address" 
					data-markerlat="45.4385847" 
					data-markerlng="12.3284471" 
				 	class="dzen_google_map" style="height:400px;width:100%;">
				</div>
			</div>
		</div>
	</div>
</section>

<!-- <section class="dzen_section_DD no_padding">
	<div class="dzen_section_content">
		<div class="dzen_container">
			<div class="dzen_column_DD_span12 ">
				<div class="dzen-callout_box no_margin">
					<div class="dzen_container">
						<div class="dzen_column_DD_span9">
							<span class="dzen-callout_box_title">Ready to buy this theme? This is call to action
							</span>
							<p>
								Very easy to customize. Fully layered PSD with multi-purpose features. You can buy it right now
							</p>
						</div>
						<div class="dzen_column_DD_span3">
							<a href="#" target="_self" class="dzen-button dzen-button_blue dzen-button_normal dzen-button_large">Buy it now</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->
@endsection


