<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Ultra Proactive</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="description" content="Dzen HTML5 premium template">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="/resources/assets/path/images/favicon.png">
	<!--[if lt IE 9]>
	<script src="/resources/assets/path///html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="/resources/assets/frontend/css/branch.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400%7COpen+Sans:400" type="text/css">
	<link rel="stylesheet" href="/resources/assets/path/rs-plugin/css/settings.css" type="text/css" media="all">
	<link rel="stylesheet" href="/resources/assets/path/css/whhg.css" type="text/css" media="all">
	<link rel="stylesheet" href="/resources/assets/path/css/scripts.css" type="text/css" media="all">
	<link rel="stylesheet" href="/resources/assets/path/css/style.css" type="text/css" media="all">
	<link rel="stylesheet" type="text/css" href="/resources/assets/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/slick/slick-theme.css">
	@yield('css')
</head>

<body style="overflow-x: hidden;">
	<header id="dz_main_header" class="clearfix">
		<div class="container">
			<div id="logo">
				<a href="/"><img src="/resources/assets/path/images/logo.png" style="height: 60px; margin-top: -10px; margin-bottom: -10px;"></a>
			</div>
			<nav>
				<ul id="main_menu">
					<li class="{{ Request::segment(1) == '' ? 'current-menu-item' : '' }}"><a href="/">Home</a></li>
					<li class="{{ Request::segment(1) == 'product' ? 'current-menu-item' : '' }}"><a href="/product">Product</a></li>
					<li class="{{ Request::segment(1) == 'mindsync' ? 'current-menu-item' : '' }}"><a href="/mindsync">Mind Sync Project</a></li>
					<li class="{{ Request::segment(1) == 'stories' ? 'current-menu-item' : '' }}"><a href="/stories">Stories</a></li>
					<li class="{{ Request::segment(1) == 'about' ? 'current-menu-item' : '' }}"><a href="/about">About us</a></li>
					<li class="{{ Request::segment(1) == 'opportunity' ? 'current-menu-item' : '' }}"><a href="/opportunity">Opportunity</a></li>
					<li class="{{ Request::segment(1) == 'contact' ? 'current-menu-item' : '' }}"><a href="/contact">Contact us</a></li>
				</ul>		
			</nav>
			<div id="ABdev_menu_toggle">
				<i class="ABdev_icon-menu"></i>
			</div>
		</div>
	</header>
	<div id="dz_header_spacer">
	</div>
	@yield('content')
	<footer id="dz_main_footer">
		<div id="footer_columns">
			<div class="container">
				<div class="row">
					<div class="span3 clearfix">
						<div class="widget">
							<h3>About us</h3>			
							<div class="textwidget">
								Ultra Proactive Marketing Inc. was incorporated in 2014. The company made its mark in the MLM industry by introducing unique high quality products and services in the market. By now, the company is making a serious and aggresive bid to be one of the best MLM companies in the country. 
							</div>
						</div>						
					</div>
					<div class="span3 clearfix">
						<div class="widget rpwe_widget">
							<h3>Recent News</h3>
							<div class="rpwe-block">
								<ul>
									@foreach($_newsfooter as $newsfooter)
									<li>
										<a href="/news_content?id={{ $newsfooter->news_id }}">
											<img src="{{ $newsfooter->image }}" class="rpwe-thumb">			
										</a>
										<h3 class="rpwe-title">
											<a href="/news_content?id={{ $newsfooter->news_id }}" title="Permalink to Created especially for you" rel="bookmark">{{ $newsfooter->news_title }}</a>
										</h3>
										<time class="rpwe-time published">{{ $newsfooter->month }} {{ $newsfooter->day }}, {{ $newsfooter->year }}</time>
									</li>
									@endforeach
								</ul>
							</div>
						</div>						
					</div>
					<div class="span3 clearfix">
						<div class="widget">
							<h3>Stay in touch</h3>		
							<div class="contact_info_widget">
								<p><i class="ABdev_icon-envelope"></i><a href="mailto:@if(isset($_setting->company_email)){{ $_setting->company_email }}@endif">@if(isset($_setting->company_email)){{ $_setting->company_email }}@endif</a></p>
								<p><i class="ABdev_icon-phonealt"></i>
									@if(isset($_setting->company_telephone)){{ $_setting->company_telephone }}@endif 
									</br>
									@if(isset($_setting->company_mobile)){{ $_setting->company_mobile }}@endif 
								</p>
								<p><i class="ABdev_icon-home"></i>@if(isset($_setting->company_address)){{ $_setting->company_address }}@endif</p>
								<!-- <p><i class="ABdev_icon-globe"></i><a href="/resources/assets/path/#">Show on map</a></p> -->
							</div>
						</div>						
					</div>
					<div class="span3 clearfix">
						<div class="widget flickr-stream">
							<h3>Recent Products</h3>
							<div class="flickr_stream">
								@foreach($_productfooter as $productfooter)
								<a class="link-middle-image" href="/product_content?id={{ $productfooter->product_id }}"><img src="{{ $productfooter->image }}" alt=""></a>
								@endforeach
							</div>
						</div>						
					</div>
				</div>
			</div>
		</div>
		<div id="footer_copyright">
			<div class="container">
				<div class="row">
					<div class="span7 footer_copyright">
						© 2015, Primia It Solutions, All Rights Reserved<a href="/resources/assets/path/#"></a>
					</div>
					<div class="span5 footer_social">
						<!-- <a href="/resources/assets/path/#" target="_self"><i class="ABdev_icon-linkedin"></i></a> -->
						<a href="https://www.facebook.com/UltraNutrifitMeal?ref=ts&fref=ts" target="_blank"><i class="ABdev_icon-facebook"></i></a>
						<!-- <a href="/resources/assets/path/#" target="_self"><i class="ABdev_icon-skype"></i></a>
						<a href="/resources/assets/path/#" target="_self"><i class="ABdev_icon-googleplus"></i></a> -->
						<a href="https://twitter.com/NutrifitMeal" target="_self"><i class="ABdev_icon-twitter"></i></a>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<script type="text/javascript" src="/resources/assets/path/js/jquery.js"></script>
	<script type="text/javascript" src="/resources/assets/path/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/resources/assets/path/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
	<script type="text/javascript" src="/resources/assets/path/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;ver=4.0.1"></script>
	<script type="text/javascript" src="/resources/assets/path/js/scripts.js"></script>
	<script type="text/javascript" src="/resources/assets/path/js/custom.js"></script>
	@yield('script')
	<script type="text/javascript">
	;(function($){
        $("img").load(function(){
        
	    })
	    .error(function(){
	        // in this case you must reload image with jQuery
	        var imgSrc = $(this).attr('src');
	        $(this).attr('src',imgSrc);
		});
    })(jQuery);
	</script>
</body>
</html>