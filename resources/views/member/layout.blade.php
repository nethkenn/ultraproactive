<!DOCTYPE html>
<html lang="en-US" class="css3transitions">
<head>
	<link rel="stylesheet" type="text/css" href="/resources/assets/frontend/css/member.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap-theme.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,300' rel='stylesheet' type='text/css'>
</head>
<div class="bg">
	<div class="wrapper container">
		<div class="header-nav">
			<div class="header pull-right">
				<div class="header-text">Account Setting</div>
				<div class="header-text">Guillermo Tabligan ( Logout )</div>
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
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			        <li class="active"><a href="#">Dashboard</a></li>
			        <li><a href="#">My Slots</a></li>
			        <li><a href="#">Code Vault</a></li>
			        <li><a href="#">Genealogy</a></li>
			        <li><a href="#">Encashment</a></li>
			        <li><a href="#">Product</a></li>
			        <li><a href="#">Voucher</a></li>
			        <li><a href="#">Leads</a></li>
			      </ul>
			      <form class="navbar-form navbar-left" role="search">
			    
			      <ul class="nav navbar-nav navbar-right">
			     
			      </ul>
			    </div><!-- /.navbar-collapse -->
			    <div class="shadow"></div>
			  </div><!-- /.container-fluid -->
			</nav>
		</div>
		<div class="content para">
		@yield('content')
		</div>
		<div class="footer">

		</div>
	</div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/resources/assets/bootstrap/js/bootstrap.min.js"></script>
</html>