<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Ultra Proactive</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="description" content="UltraProactive">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="/resources/assets/frontend/img/logo.png">
	<!--[if lt IE 9]>
	<script src="/resources/assets/path///html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,700,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/resources/assets/path/rs-plugin/css/settings.css" type="text/css" media="all">
	<link rel="stylesheet" href="/resources/assets/path/css/whhg.css" type="text/css" media="all">
	<link rel="stylesheet" href="/resources/assets/path/css/scripts.css" type="text/css" media="all">
	<link rel="stylesheet" href="/resources/assets/path/css/style.css" type="text/css" media="all">
	<link rel="stylesheet" type="text/css" href="/resources/assets/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/slick/slick-theme.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/frontend/css/global.css">
	@yield('css')
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-65579552-3', 'auto');
	  ga('send', 'pageview');

	</script>
</head>

<body style="overflow-x: hidden; margin-left: 15px; margin-right: 15px; position: relative;">
	<!-- <header id="dz_main_header" class="clearfix">
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
					<li class="{{ Request::segment(1) == 'faq' ? 'current-menu-item' : '' }}">
						<a href="javascript:">F.A.Q.</a>
						<ul>
							<li><a href="/faq?type=product">Products</a></li>
							<li><a href="/faq?type=mindsync">Mind Sync Project</a></li>
							<li><a href="/faq?type=opportunity">Opportunity</a></li>
						</ul>
					</li>
					<li class="{{ Request::segment(1) == 'contact' ? 'current-menu-item' : '' }}"><a href="/contact">Contact us</a></li>
				</ul>		
			</nav>
			<div id="ABdev_menu_toggle">
				<i class="ABdev_icon-menu"></i>
			</div>
		</div>
	</header> -->
	<div class="account">
		<a href="/member/login"><div class="text">LOGIN</div></a>
		<span>|</span>
		<a href="/member/register"><div class="text">REGISTER</div></a>
	</div>
	<nav class="navbar navbar-default">
	   <div>
	      <!-- Brand and toggle get grouped for better mobile display -->
	      <div class="navbar-header">
	         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	         <span class="sr-only">Toggle navigation</span>
	         <span class="icon-bar"></span>
	         <span class="icon-bar"></span>
	         <span class="icon-bar"></span>
	         </button>
	         <!-- <a class="navbar-brand" href="#">Brand</a> -->
	      </div>
	      <!-- Collect the nav links, forms, and other content for toggling -->
	      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="border: 0;">
	         <ul class="nav navbar-nav">
	            <li class="nav-inside active"><a href="/">HOME</a></li>
	            <li class="nav-inside"><a href="/product">PRODUCT</a></li>
	            <li class="nav-inside dropdown">
	               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">MINDSYNC</span></a>
	               <ul class="dropdown-menu">
	                  <li><a href="/mindsync">MIND SYNC PROJECT</a></li>
	                  <li><a href="/foodcart">FOOD CART</a></li>
	               </ul>
	            </li>
	            <li class="nav-inside"><a href="/stories">STORIES</a></li>
	            <li class="nav-inside logo-holder"><img class="logo" src="/resources/assets/frontend/img/logo.png"></li>
	            <li class="nav-inside"><a href="/about">ABOUT</a></li>
	            <li class="nav-inside"><a href="/opportunity">OPPORTUNITY</a></li>
	            <li class="nav-inside dropdown">
	               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">FAQs</span></a>
	               <ul class="dropdown-menu">
	               	  <li><a href="/faq?type=glossary">Glossary</a></li>
	                  <li><a href="/faq?type=product">Products</a></li>
	                  <li><a href="/faq?type=mindsync">Mind Sync Project</a></li>
	                  <li><a href="/faq?type=opportunity">Opportunity</a></li>
	               </ul>
	            </li>
	            <li class="nav-inside"><a href="/contact">CONTACT US</a></li>
	            <!-- <li class="dropdown">
	               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	               <ul class="dropdown-menu">
	                  <li><a href="#">Action</a></li>
	                  <li><a href="#">Another action</a></li>
	                  <li><a href="#">Something else here</a></li>
	                  <li role="separator" class="divider"></li>
	                  <li><a href="#">Separated link</a></li>
	                  <li role="separator" class="divider"></li>
	                  <li><a href="#">One more separated link</a></li>
	               </ul>
	            </li> -->
	         </ul>
	         <!-- <ul class="nav navbar-nav navbar-right">
	            <li><a href="#">Link</a></li>
	            <li class="dropdown">
	               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	               <ul class="dropdown-menu">
	                  <li><a href="#">Action</a></li>
	                  <li><a href="#">Another action</a></li>
	                  <li><a href="#">Something else here</a></li>
	                  <li role="separator" class="divider"></li>
	                  <li><a href="#">Separated link</a></li>
	               </ul>
	            </li>
	         </ul> -->
	      </div>
	      <!-- /.navbar-collapse -->
	   </div>
	   <!-- /.container-fluid -->
	</nav>
	<div style="margin-top: 70px" id="wazzup">
	@yield('content')
	</div>
	<footer id="dz_main_footer" style="margin: 0 -15px;">
		<div id="footer_columns">
			<div class="container">
				<div class="row">
					<div class="span3 clearfix">
						<div class="widget">
							<h3 class="rw">About us</h3>			
							<div class="textwidget op">
								Ultra Proactive Marketing Inc. was incorporated in 2014. The company made its mark in the MLM industry by introducing unique high quality products and services in the market. By now, the company is making a serious and aggresive bid to be one of the best MLM companies in the country. 
							</div>
						</div>						
					</div>
					<div class="span3 clearfix">
						<div class="widget rpwe_widget">
							<h3 class="rw">Recent News</h3>
							<div class="rpwe-block">
								<ul>
									@foreach($_newsfooter as $newsfooter)
									<li class="op">
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
							<h3 class="rw">Stay in touch</h3>		
							<div class="contact_info_widget op">
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
							<h3 class="rw">Recent Products</h3>
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
						© 2015, UltraProactive, All Rights Reserved<a href="http://www.ultraproactive.net"></a>
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
	<script type="text/javascript" src="/resources/assets/bootstrap/js/bootstrap.min.js"></script>
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
	<script type="text/javascript">
	;(function($){
		var $document = $(document),
        $element = $('.navbar'),
        className = 'stickies';

        $document.scroll(function() {
          if ($document.scrollTop() >= 150) 
          {
            // user scrolled 50 pixels or more;
            // do stuff
            $element.addClass(className);
        	$("#wazzup").addClass("mtop");
          } 
          else 
          {
            $element.removeClass(className);
           	$("#wazzup").removeClass("mtop");
          }
        });
	})(jQuery);
	</script>
</body>
</html>