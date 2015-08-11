<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="<?php echo "http://" . $_SERVER["SERVER_NAME"] ?>">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="_token" content="{{ csrf_token() }}">
		<title></title>
		<!-- GOOGLE FONT -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
		<!-- BOOTSTRAP -->
		<link href="resources/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="resources/assets/bootstrap/bootstrap-switch.css" rel="stylesheet">
		<!-- FONT AWESEOME -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/jquery.remodal.css">
		<link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/remodal-default-theme.css">
		<!-- Custom styles for this template -->
		<link href="resources/assets/admin/style.css" rel="stylesheet">
		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		var image_server = '{{ Config::get("app.image_server") }}';
		var source = '{{ $_SERVER["SERVER_NAME"] }}';
		</script>
		<link rel="icon" type="image/png" href="/resources/assets/frontend/img/favicon.png">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-65579552-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</head>
	<body style="overflow-y: scroll">
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
					</div>
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li class="{{ Request::segment(2) == '' ? 'active' : 'inactive' }}"><a href="stockist/">Dashboard</a></li>
							<li class="{{ Request::segment(2) == 'issue_stocks' ? 'active' : 'inactive' }}"><a href="stockist/issue_stocks">Issue Stocks</a></li>
							<li class="{{ Request::segment(2) == 'membership_code' ? 'active' : 'inactive' }}"><a href="/stockist/membership_code">Code</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown {{ Request::segment(2) == 'account' ? 'active' : 'inactive' }}">
								<a href="admin/utilities" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Account Settings <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="admin/account/settings/profile">Profile</a></li>
									<li><a href="admin/account/settings/change_pass">Change Password</a></li>
								</ul>
							</li>
							<li><a href="stockist/logout"> {{$user->stockist_un}} (Logout)</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<div>
				@yield('content')
			</div>
		</div>
		<div class="modal fade loading-effect">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header alert alert-warning">
						<h4 class="modal-title loading-effect-title"></h4>
					</div>
					<div class="modal-body text-center">
						<div class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></div>
						<div class="loading-effect-process">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade after-loading-message">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title after-loading-message-title">Archive Message</h4>
					</div>
					<div class="modal-body">
						<div class="after-loading-message-details">
							<p>Message successfully archived.</p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<script src="/resources/assets/external/jquery.min.js"></script>
		<script src="/resources/assets/external/bootstrap.min.js"></script>
		<script src="/resources/assets/bootstrap/bootstrap-switch.js"></script>
		<script src="/resources/assets/primia/primia-admin.js"></script>
		<script src="/resources/assets/admin/global.js"></script>
		<script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
		@yield('script')
	</body>
</html>