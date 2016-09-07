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
		<link rel="shortcut icon" type="image/x-icon" href="/resources/assets/frontend/img/logo.png">
		<title>Admin Panel - UltraProactive</title>
		<!-- GOOGLE FONT -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
		<!-- BOOTSTRAP -->
		<link href="resources/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="resources/assets/bootstrap/bootstrap-switch.css" rel="stylesheet">
		@yield("css")
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

		  ga('create', 'UA-65579552-3', 'auto');
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
							<!-- DASHBOARD -->
							<li class="{{ Request::segment(2) == '' ? 'active' : 'inactive' }}"><a href="admin/">Dashboard</a></li>
							<!-- TRANSACTION -->
							<li class="dropdown {{ Request::segment(2) == 'transaction' ? 'active' : 'inactive' }}">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Transaction <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="admin/transaction/redeem">Redeems</a></li>
									<li><a href="admin/transaction/sales">Process Sales</a></li>
									<li><a href="admin/transaction/claims">Process Claims</a></li>
									<li><a href="admin/transaction/payout">Process Payout</a></li>
									<li><a href="admin/transaction/view_voucher_codes">Code Transactions</a></li>
									<!--<li><a href="admin/transaction/unilevel-distribution">Unilevel Distribution</a></li> -->
									<!-- <li><a href="admin/transaction/unilevel-distribution/dynamic">Dynamic Compression</a></li> -->
									<li><a href="admin/transaction/global_pool_sharing">Global Pool Sharing</a></li>
									<li><a href="admin/transaction/sales/transfer_slot_request">Transfer Request Slot</a></li>
								</ul>
							</li> 
							<!-- MAINTENANCE -->
							<li class="dropdown {{ Request::segment(2) == 'maintenance' ? 'active' : 'inactive' }}">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Maintenance <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="admin/maintenance/accounts">Account</a></li>
									<li><a href="admin/maintenance/slots">Account Slots</a></li>
									<li><a href="admin/maintenance/account_block">Account Block</a></li>
									<li class="divider" role="separator"></li>
									<li><a href="admin/maintenance/product">Product</a></li>
									<li><a href="admin/maintenance/product_package">Product Package</a></li>
									<li><a href="admin/maintenance/product_category">Product Categories</a></li>
									<li><a href="admin/maintenance/inventory">Product Inventory</a></li>
									<li class="divider" role="separator"></li>
									<li><a href="admin/maintenance/membership">Membership</a></li>
									<li><a href="admin/maintenance/codes">Membership Codes</a></li>
									<li class="divider" role="separator"></li>
									<li><a href="admin/maintenance/country">Country</a></li>
									<li><a href="admin/maintenance/deduction">Deductions</a></li>
									<li><a href="admin/maintenance/ranking">Ranking</a></li>
									<li class="divider" role="separator"></li>
									<li><a href="admin/admin_stockist">Stockist</a></li>
									<li><a href="admin/admin_stockist_user">Stockist Users</a></li>
									<li><a href="admin/stockist_type">Stockist Type</a></li>
									<li><a href="admin/stockist_inventory">Stockist Inventory</a></li>
									<li><a href="admin/stockist_wallet">Stockist Refill Wallet</a></li>
									<li><a href="admin/stockist_request">Stockist Order Request</a></li>
								</ul>
							</li>
							<!-- UTILITIES -->
							<li class="dropdown {{ Request::segment(2) == 'utilities' ? 'active' : 'inactive' }}">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Utilities <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="admin/utilities/admin_maintenance">Admin</a></li>
									<li><a href="admin/utilities/position">Admin Positions</a></li>
									<li><a href="admin/utilities/setting">Company Settings</a></li>
									<li class="divider" role="separator"></li>
									<li><a href="admin/utilities/binary">Binary Computation</a></li>
									<li><a href="admin/utilities/direct">Direct Sponsorship Bonus</a></li>
									<li><a href="admin/utilities/indirect">Indirect Sponsorship Bonus</a></li>		
									<li><a href="admin/utilities/matching">Mentor Bonus Computation</a></li>
									<li><a href="admin/utilities/unilevel_check_match">Unilevel Check Match</a></li>
									<li><a href="admin/utilities/unilevel">Unilevel Computation</a></li>
									<li class="divider" role="separator"></li>
									<li><a href="admin/utilities/breakaway_bonus">Breakaway Bonus</a></li>
									<li><a href="admin/utilities/leadership_bonus">Leadership Bonus</a></li>
									<li class="divider" role="separator"></li>
									<li><a href="admin/utilities/travel_qualification">Travel And Car Bonus Qualification</a></li>
									<li><a href="admin/utilities/travel_reward">Travel And Car Bonus Reward</a></li>
									<li class="divider" role="separator"></li>
									<li><a href="admin/utilities/rank">Promotion Settings</a></li>
									<!--<li class="divider" role="separator"></li>
									<li><a href="admin/utilities/recompute">Recomputation</a></li>
									<li class="divider" role="separator"></li>
									 <li><a href="admin/e-payment-settings">E-payment / E-Remit Settings</a></li>
									<li><a href="admin/e-payment-profile-form-settings">E-payment Form Settings</a></li> -->
								</ul>
							</li> 
							<!-- REPORTS -->
							<li class="dropdown {{ Request::segment(2) == 'reports' ? 'active' : 'inactive' }}">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reports <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="admin/reports/product_sales">Product Sales Report</a></li>
									<li><a href="admin/reports/membership_sales">Membership Sales Report</a></li>
									<li><a href="admin/reports/audit_trail">Audit Trail</a></li>
									<li><a href="admin/reports/prod_inventory">Product Inventory Report</a></li>
									<li><a href="admin/reports/bonus_summary">Bonus Summary</a></li>
									<li><a href="admin/reports/gc_summary">GC Summary</a></li>
									<li><a href="admin/reports/top_earner">Top Earner</a></li>
									<li><a href="admin/reports/top_recruiter">Top Recruiter</a></li>
									<li><a href="admin/reports/other_reports">Other Reports</a></li>
									<li><a href="admin/reports/check_gc">MATCHING BONUS COUNT</a></li>
								</ul>
							</li> 

							<!-- CONTENT -->
							<li class="dropdown {{ Request::segment(2) == 'content' ? 'active' : 'inactive' }}">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Content <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="admin/content/news">News</a></li>
									<li><a href="admin/content/stories">Stories</a></li>
									<li><a href="admin/content/slide">Slide</a></li>
									<li><a href="admin/content/team">Team</a></li>
									<li><a href="admin/content/faq">F.A.Q.</a></li>
									<li><a href="admin/content/mindsync">MindSync</a></li>
									<li><a href="admin/content/foodcart">FoodCart</a></li>
									<!-- <li><a href="admin/content/partner">Partners</a></li>
									<li><a href="admin/content/service">Services</a></li> -->
									<li><a href="admin/content/about">About Us</a></li>
								</ul>
							</li>

								<!-- DEVELOPERS AREA -->
								@if($access_to_product_codes == 0)
								<li class="dropdown {{ Request::segment(2) == 'developer' ? 'active' : 'inactive' }}">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Developer<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
											<li><a href="admin/migration">Migrations</a></li>
											<li><a href="admin/migration/disable">Disable Area</a></li>
											<li><a href="admin/developer/re_entry">Re Entry (CD to PS)</a></li>
											<li><a href="admin/developer/re_adjust_cd">Re Adjust CD</a></li>
									</ul>
								</li>
								@endif
						</ul>



						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown {{ Request::segment(2) == 'account' ? 'active' : 'inactive' }}">
								<a href="admin/utilities" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Account Settings <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="admin/account/settings/profile">Profile</a></li>
									<li><a href="admin/account/settings/change_pass">Change Password</a></li>
								</ul>
							</li>
							<li><a href="admin/account/logout"> {{$admin->account_username}} (Logout)</a></li>
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