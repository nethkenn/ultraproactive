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












Input the amount.
<form class="form-horizontal" method="POST">
	<input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
	<input type="number" name="amount" placeholder="Amount">
	<input type="password" name="password" placeholder="Password">
	<button type="submit" id="submit"> Submit </button>
</form>







<script src="/resources/assets/external/jquery.min.js"></script>
<script src="/resources/assets/external/bootstrap.min.js"></script>
<script src="/resources/assets/bootstrap/bootstrap-switch.js"></script>
<script src="/resources/assets/primia/primia-admin.js"></script>
<script src="/resources/assets/admin/global.js"></script>
<script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script type="text/javascript">
	$(document).ready(function()
	{	
		$('form').bind("keypress", function(e) {
		  if (e.keyCode == 13) {               
		    e.preventDefault();
		    return false;
		  }
		});
		$('#submit').click(function(){
			$("#submit").hide();
		});
	});
</script>