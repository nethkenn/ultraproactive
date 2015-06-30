<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Prolife</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
<!--[if lt IE 9]>
<script src="/resources/assets/slider_style/http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="/resources/assets/slider_style/js/jquery.js"></script>
<script src="/resources/assets/slider_style/js/jquery-migrate.js"></script>
<script src="/resources/assets/slider_style/js/modernizr.custom.js"></script>
<link href="/resources/assets/slider_style/css/bootstrap.css" rel="stylesheet">
<link href="/resources/assets/slider_style/css/style.css" rel="stylesheet">
<link href="/resources/assets/slider_style/css/color/yellow.css" rel="stylesheet">
<link href="/resources/assets/slider_style/css/media.css" rel="stylesheet">
<link rel="stylesheet" href="/resources/assets/slider_style/css/colorbox.css" />
<link rel="stylesheet" href="/resources/assets/slider_style/css/animate.css" />
</head>
<body data-spy="scroll">
	<div id="0"></div>
	<!--/menu-->
	<div id="nav">
		<nav class="navbar menudesktopcolor navbar-default navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">
				<img src="/resources/assets/slider_style/images/logo_yellow.png" alt="logo"/></a>
			</div>
			<div class="collapse navbar-collapse navbar-ex1-collapse ">
				<nav class="cl-effect-12">
					<ul class="nav navbar-nav pull-right">
						<li><a href="#0">Home</a></li>
						<li><a href="#1">Earn</a></li>
						<li><a href="#2">Services</a></li>
						<li><a href="#3">Gallery</a></li>
						<li><a href="#4">About Us</a></li>
						<li><a href="#5">News</a></li>
						<li><a href="#6">Contact</a></li>
					</ul>
				</nav>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div>
	<!--/menu end-->
	@yield('content')
	<footer>
		<section class="blackpart5">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<img src="/resources/assets/slider_style/images/iconaddress.png" alt=""/>
						<h5>Address</h5>
						<p>Your Street 123, Your City 123</p>
					</div>
					<div class="col-lg-4">
						<img src="/resources/assets/slider_style/images/iconphone.png" alt=""/>
						<h5>Telephone</h5>
						<p>+123/333-3333, 09am-17pm, monday-friday</p>
					</div>
					<div class="col-lg-4 bottomicons">
						<a href="#" class="iconfacebook"></a>
						<a href="#" class="icontwitter"></a>
						<a href="#" class="iconlinkedin"></a>
					</div>
				</div>
			</div>
			</section><!--/blackpart5 end-->
			<section class="bottom">
				<div class="copyrightwrapper">
					<p class="copyright">&copy; <a href="http://primiaworks.com">Primia IT Solutions </a> 2015 All rights reserved</p>
				</div>
				<div class="scrollbutton">  <!--/scrollbutton-->
				<a href="javascript:scrollToTop()" title="go to top"></a>
				</div><!--/scrollbutton end-->
			</section><!--/bottom end-->
	</footer>
</div> <!--/wrapperall end-->
<script src="/resources/assets/slider_style/js/smoothscroll.js"></script>
<script src="/resources/assets/slider_style/js/bootstrap.js"></script>
<script src="/resources/assets/slider_style/js/jquery.sequence.js"></script>
<script src="/resources/assets/slider_style/js/jquery.isotope.min.js"></script>
<script src="/resources/assets/slider_style/js/jquery.colorbox.js"></script>
<script src="/resources/assets/slider_style/js/imagesloaded.js"></script>
<script src="/resources/assets/slider_style/js/retina.js"></script>
<script src="/resources/assets/slider_style/js/jquery.bxslider.js"></script>
<script src="/resources/assets/slider_style/js/toucheffects.js"></script>
<script src="/resources/assets/slider_style/js/jquery.backstretch.js"></script>
<script>
$.backstretch([
"/resources/assets/slider_style/images/1.jpg",
"/resources/assets/slider_style/images/2.jpg",
"/resources/assets/slider_style/images/3.jpg"
], {
fade: 750,
duration: 5000
});
</script>
<script src="/resources/assets/slider_style/js/scripts.js"></script>
</body>
</html>