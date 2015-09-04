<!DOCTYPE html>
<html lang="en-US" class="css3transitions">
<head>
	<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/member.css">
    @yield('css')
	<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/jquery.remodal.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/remodal-default-theme.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="/resources/assets/font-awesome/css/font-awesome.min.css">
    <link href="/resources/assets/footable/css/footable.core.css" rel="stylesheet" type="text/css" />
    <!-- <link href="/resources/assets/footable/css/footable.standalone.css" rel="stylesheet" type="text/css" /> -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,300' rel='stylesheet' type='text/css'>
    <!--<base href="{{$_SERVER['SERVER_NAME']}}">-->
    <base href="{{URL::to('/')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<div class="bg">
	<div class="wrapper">
		<div class="header-nav">
			<!-- <div class="header">
				<div class="col-md-6 ubod">
                    <img src="/resources/assets/frontend/img/member-logo.png">
                </div>
                <div class="col-md-6 grabe">    
                    <div class="header-text"><a href="/member/settings">Account Setting</a></div>
                    <div class="header-text"><a href="/member/logout">{{$member->account_name}} ( Logout )</a></div>
                </div>
			</div> -->
			<nav class="navbar navbar-default">
			  <div>
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
                <span class="hidden-bury visible-xs visible-sm hidden-lg hidden-md pull-left">
                    @if($slotnow)
                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 14px; font-weight: 700; color: #9BA0A7; display: block; padding: 15px 0;">SLOT #{{$slotnow->slot_id}} <span>{{ number_format($slotnow->slot_wallet, 2)}}</span> | GC <span>{{ number_format($slotnow->slot_gc, 2)}}</span>  <b class="caret"></b></a>
                    @else
                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 14px; font-weight: 700; color: #9BA0A7; display: block; padding: 15px 0;">NO SLOTS<b class="caret"></b></a>
                    @endif
                    <ul class="dropdown-menu scrollable-menu" style="text-transform: normal; font-size: 14px; font-weight: 700; color: #9BA0A7;">
                        @if($slot)                                                    
                            @foreach($slot as $slots)
                                   <li><a class="forslotchanging" slotid='{{$slots->slot_id}}' href="javascript:">SLOT #{{$slots->slot_id}} <span>{{ number_format($slots->slot_wallet, 2)}}</span> | GC <span>{{ number_format($slots->slot_gc, 2)}}</span> </a></li> 
                            @endforeach
                        @endif    
                        <li><a href="/member/settings">Account Settings</a></li>
                        <li><a href="/member/settings#cpass">Change Password</a></li>
                        <li><a href="/member/logout">Sign out</a></li>
                    </ul>
                </span>
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			    </div>

			    <!-- NAVIGATION -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="overflow: hidden;">
			      <ul class="nav navbar-nav">
			        <li class="{{ Request::segment(2) == '' ? 'active' : '' }}"><a href="/member">Dashboard</a></li>
			        <li class="{{ Request::segment(2) == 'slot' ? 'active' : '' }}"><a href="/member/slot">My Slots</a></li>
			        <li class="{{ Request::segment(2) == 'code_vault' ? 'active' : '' }}"><a href="/member/code_vault">Code Vault</a></li>
			        <li class="{{ Request::segment(2) == 'genealogy' ? 'active' : '' }} dropdown">
                        <a href="javascript:">Genealogy</a>
                        <ul class="dropdown-menu">
                            <li><a href="/member/genealogy/tree?mode=binary">Binary Genealogy</a></li>
                            <li><a href="/member/genealogy/tree?mode=sponsor">Sponsor Genealogy</a></li>
                        </ul>
                    </li>
			        <li class="{{ Request::segment(2) == 'encashment' ? 'active' : '' }}"><a href="/member/encashment">Encashment</a></li>
			        <li class="{{ Request::segment(2) == 'product' ? 'active' : '' }}"><a href="/member/product">Product</a></li>
			        <li class="{{ Request::segment(2) == 'voucher' ? 'active' : '' }}"><a href="/member/voucher">Voucher</a></li>
			        <li class="{{ Request::segment(2) == 'leads' ? 'active' : '' }}"><a href="/member/leads">Leads</a></li>
                   <li class="{{ Request::segment(2) == 'genealogy' ? 'active' : '' }} dropdown hide">
                        <!--<a href="/member/genealogy?mode=binary">E-payment</a>-->
                        <a href="member/e-payment/">E-payment</a>
                        <ul class="dropdown-menu">
                            <li><a href="member/e-payment/recipient">E-payment Recipient</a></li>
                            <li><a href="member/e-payment/transaction-log">E-payment Transaction</a></li>

                        </ul>
                    </li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right" style="margin-right: 0;">
			         <li>
                       <!--  @if($slotnow)
                            <form method="post" name="myform">
                                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                                <select class="form-control slot-number-container" onchange="this.form.submit()" name="slotnow"> 
                                        <option value="{{$slotnow->slot_id}}">SLOT #{{$slotnow->slot_id}} [ {{ number_format($slotnow->slot_wallet, 2)}} ]</option> 
                                        @if($slot)                                                    
                                            @foreach($slot as $slots)
                                            <option value="{{$slots->slot_id}}">SLOT #{{$slots->slot_id}} [ {{ number_format($slots->slot_wallet, 2)}} ]</option>
                                            @endforeach
                                        @endif    
                                 </select>
                            </form>
                        @else
                        <div class="select-label">You have no slots</div>   
                        @endif -->
                        @if($slotnow)
                        <a href="javascript:" class="dropdown-toggle hidden-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SLOT #{{$slotnow->slot_id}} <span>{{ number_format($slotnow->slot_wallet, 2)}}</span> | GC <span>{{ number_format($slotnow->slot_gc, 2)}}</span>  <b class="caret"></b></a>
                        @else
                        <a href="javascript:" class="dropdown-toggle hidden-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">NO SLOTS<b class="caret"></b></a>
                        @endif
                        <ul class="dropdown-menu scrollable-menu hidden-sm" style="text-transform: normal">
                            @if($slot)                                                    
                                @foreach($slot as $slots)
                                       <li><a class="forslotchanging" slotid='{{$slots->slot_id}}' href="javascript:">SLOT #{{$slots->slot_id}} <span>{{ number_format($slots->slot_wallet, 2)}}</span> |  GC <span>{{ number_format($slots->slot_gc, 2)}}</span></a></li> 
                                @endforeach
                            @endif      
                            <li><a href="/member/settings">Account Settings</a></li>
                            <li><a href="/member/settings#cpass">Change Password</a></li>
                            <li><a href="/member/logout">Sign out</a></li>
                        </ul>
                     </li>
			      </ul>
			    </div>
			  </div><!-- /.container-fluid -->
			</nav>
		</div>
		<div class="content para container">
		@yield('content')
		</div>
		<div class="footer">

		</div>
	</div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/es5-shim/2.3.0/es5-shim.js'></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/resources/assets/rutsen/js/global.js"></script>
<script type="text/javascript" src="/resources/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
<script type="text/javascript" src="/resources/assets/footable/js/footable.js"></script>
<script type="text/javascript" src="/resources/assets/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="/resources/assets/stickyfloat/stickyfloat.js"></script>
<script type="text/javascript" src="/resources/assets/members/js/layout.js"></script>
@yield('script')

</body>

 <!--   <div class="remodal create-slot" data-remodal-id="transfer_code" data-remodal-options="hashTracking: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div class="header">
            <img src="/resources/assets/frontend/img/icon-transfer.png">
            Transfer Code
        </div>
        <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
        <div class="col-md-10 col-md-offset-1 para">
            <form class="form-horizontal" method="POST">
                <div class="form-group para">
                    <label for="11" class="col-sm-3 control-label">Code</label>
                    <div class="col-sm-9">
                        <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" class="form-control" id="11s" name="code">
                        <input type="text" class="form-control" id="11" disabled>
                    </div>
                </div>
                <div class="form-group para">
                    <label for="22" class="col-sm-3 control-label">Recipient</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="22" name="account">
                            @if($accountlist)
                                @foreach($accountlist  as $a)
                                     <option value="{{$a->account_id}}">{{$a->account_email}}({{$a->account_name}})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group para">
                    <label for="33" class="col-sm-3 control-label">Enter Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="33" name="pass">
                    </div>
                </div>
        
        </div>
        <br>
        <button class="button" data-remodal-action="cancel">Cancel</button>
        <button class="button" type="submit" name="codesbmt">Initiate Transfer</button>
    </div>
</form> -->



<div class="remodal create-slot" data-remodal-id="claim_code" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-claim.png">
        Claim Code
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="POST">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="1111" class="col-sm-3 control-label">Pin Number</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="pin" id"1111">
                </div>
            </div>
            <div class="form-group para">
                <label for="2222" class="col-sm-3 control-label">Code</label>
                <div class="col-sm-9">
                    <input class="form-control" type="text" name="activation" id"2222">
                </div>
            </div>
    </div>
                <br>
                <button class="button" data-remodal-action="cancel">Cancel</button>
                <button class="button" type="submit" name="sbmtclaim">Claim Code</button>
        </form>
</div>



<!--<div class="remodal create-slot" data-remodal-id="voucher">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-vouchers.png">
        Vouchers
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="para wew">
        <div class="col-md-6 siyet text-left">
            <img src="/resources/assets/frontend/img/member-logo.png">
        </div>
        <div class="col-md-6 siyet text-right">
            <div>#18 M. Marcos Street</div>
            <div>Pandi, Bulacan</div>
            <div>Guillermo Tabligan</div>
        </div>
    </div>
    <div class="para epal">
        <div class="title">Ref. No. 14</div>
        <div class="sub para">
            <div class="tudaleft col-md-6 siyet">Code ( VL89M )</div>
            <div class="tudaright col-md-6 siyet">August 25, 2015</div>
        </div>
    </div>
    <div class="para tae">
        <table class="footable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th data-hide="phone">Price</th>
                    <th data-hide="phone">Quantity</th>
                    <th data-hide="phone">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="tibolru">
                    <td>Sample Product 1</td>
                    <td>12,500.00</td>
                    <td>3</td>
                    <td>38,500.00</td>
                </tr>
                <tr class="tibolru">
                    <td>Sample Product 1</td>
                    <td>12,500.00</td>
                    <td>3</td>
                    <td>38,500.00</td>
                </tr>
                <tr class="tibolru">
                    <td>Sample Product 1</td>
                    <td>12,500.00</td>
                    <td>3</td>
                    <td>38,500.00</td>
                </tr>
                <tr class="tibolru">
                    <td>Sample Product 1</td>
                    <td>12,500.00</td>
                    <td>3</td>
                    <td>38,500.00</td>
                </tr>
                <tr class="tibolru">
                    <td>Sample Product 1</td>
                    <td>12,500.00</td>
                    <td>3</td>
                    <td>38,500.00</td>
                </tr>
            </tbody>
        </table>
        <div class="potek">
            <a href="javascript:">
                <img src="/resources/assets/frontend/img/icon-print.png">
                Print Voucher
            </a>
        </div>
    </div>
</div>-->


<div class="remodal message" data-remodal-id="message">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header para">
        <div class="col-sm-6 nya">
            <img src="/resources/assets/frontend/img/icon-messages.png">
            Messages
        </div>
        <div class="col-sm-6 nye">
            <a href="javascript:">
                <button type="button">+ Send New Message</button>
            </a>
            <a href="javascript:" class="contactses">
                <button type="button">Show Contacts</button>
            </a>
        </div>
    </div>
    <div class="body">
        <div class="message-list nyek">
            <div class="overflows">
                <div class="holder">
                    <div class="linyanglinya"></div>
                    <div class="liness">
                    <div class="pix">
                      <img src="/resources/assets/frontend/img/pix.png">
                    </div>
                    <div class="text">
                      <div class="name">John Doe</div>
                      <div class="email">sample@gmail.com</div>
                    </div>
                    </div>
                </div>
                <div class="holder">
                    <div class="linyanglinya"></div>
                    <div class="liness">
                    <div class="pix">
                      <img src="/resources/assets/frontend/img/pix.png">
                    </div>
                    <div class="text">
                      <div class="name">John Doe</div>
                      <div class="email">sample@gmail.com</div>
                    </div>
                    </div>
                </div>
                <div class="holder">
                    <div class="linyanglinya"></div>
                    <div class="liness">
                    <div class="pix">
                      <img src="/resources/assets/frontend/img/pix.png">
                    </div>
                    <div class="text">
                      <div class="name">John Doe</div>
                      <div class="email">sample@gmail.com</div>
                    </div>
                    </div>
                </div>
                <div class="holder">
                    <div class="linyanglinya"></div>
                    <div class="liness">
                    <div class="pix">
                      <img src="/resources/assets/frontend/img/pix.png">
                    </div>
                    <div class="text">
                      <div class="name">John Doe</div>
                      <div class="email">sample@gmail.com</div>
                    </div>
                    </div>
                </div>
                <div class="holder">
                    <div class="linyanglinya"></div>
                    <div class="liness">
                    <div class="pix">
                      <img src="/resources/assets/frontend/img/pix.png">
                    </div>
                    <div class="text">
                      <div class="name">John Doe</div>
                      <div class="email">sample@gmail.com</div>
                    </div>
                    </div>
                </div>
                <div class="holder">
                    <div class="linyanglinya"></div>
                    <div class="liness">
                    <div class="pix">
                      <img src="/resources/assets/frontend/img/pix.png">
                    </div>
                    <div class="text">
                      <div class="name">John Doe</div>
                      <div class="email">sample@gmail.com</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="message-content">
            <div class="scrollpamore">
                <div class="holder">
                    <div class="pix">
                        <img src="/resources/assets/frontend/img/pix1.png">
                    </div>
                    <div class="text">
                        <div class="name">Guillermo Tabligan</div>
                        <div class="message">Hello there! I was wondering if you are free tomorrow?</div>
                    </div>
                    <div class="date">July 15, 2093</div>
                </div>
                <div class="holder">
                    <div class="pix">
                        <img src="/resources/assets/frontend/img/pix1.png">
                    </div>
                    <div class="text">
                        <div class="name">Guillermo Tabligan</div>
                        <div class="message">Hello there! I was wondering if you are free tomorrow?</div>
                    </div>
                    <div class="date">July 15, 2093</div>
                </div>
            </div>
            <div class="sulatan">
                <div class="mensahe">
                    <textarea placeholder="Enter your message here.."></textarea>
                </div>
                <div class="muntingpindutan">
                    <a href="javascript:">
                        <button type="button">
                            <img src="/resources/assets/frontend/img/icon-eroplano.png">
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="remodal create-slot" data-remodal-id="checkout">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-checkout.png">
        Checkout
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="a1" class="col-sm-3 control-label">Wallet</label>
                <div class="col-sm-9">
                    <input type="text" value="Slot #8" class="form-control" id="a1" value="1,200.00">
                </div>
            </div>
            <div class="form-group para">
                <label for="a2" class="col-sm-3 control-label">Total Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a2" value="800.00">
                </div>
            </div>
            <div class="form-group para">
                <label for="a3" class="col-sm-3 control-label">Remaining</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a3" value="400.00">
                </div>
            </div>
            <div class="form-group para">
                <label for="a4" class="col-sm-3 control-label">Total Unilevel Points</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a4" value="100.00">
                </div>
            </div>
            <div class="form-group para">
                <label for="a5" class="col-sm-3 control-label">Total Binary Points</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a5" value="120.00">
                </div>
            </div>
            <div class="form-group para">
                <label for="a6" class="col-sm-3 control-label">Points Recipient</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="a6" value="Slot #5">
                </div>
            </div>
        </form>
    </div>
    <br>
    <button class="checkawt button" data-remodal-action="confirm">Submit Checkout</button>
</div>
<div class="remodal referrals create-slot" data-remodal-id="referral">
    <button data-remodal-action="close" class="remodal-close" style="color: white;"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-referral.png">
        Referrals
    </div>
    <div class="col-md-12">
        <table class="footable">
            <thead>
                <tr>
                    <th>#</th>
                    <th data-hide="phone">Deduction</th>
                    <th data-hide="phone">Status</th>
                    <th data-hide="phone">Type</th>
                    <th data-hide="phone">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>13</td>
                    <td>100.00</td>
                    <td>Pending</td>
                    <td>Bank Deposit</td>
                    <td>462.00</td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>100.00</td>
                    <td>Pending</td>
                    <td>Bank Deposit</td>
                    <td>462.00</td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>100.00</td>
                    <td>Pending</td>
                    <td>Bank Deposit</td>
                    <td>462.00</td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>100.00</td>
                    <td>Pending</td>
                    <td>Bank Deposit</td>
                    <td>462.00</td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>100.00</td>
                    <td>Pending</td>
                    <td>Bank Deposit</td>
                    <td>462.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="remodal create-slot" data-remodal-id="required_pass" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-use.png">
        Unlock Code
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
    <form class="form-horizontal" method="POST">
            <input type="hidden" id="yuan" value="" name="yuan"> 
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="001" class="col-sm-3 control-label">Enter Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="001" name="pass">
                </div>
            </div>
    </div>
    <br>
    <button class="button" data-remodal-action="cancel">Cancel</button>
    <button class="button" name="unlockpass">Unlock</button>
    </form>
</div>


<div class="remodal create-slot" data-remodal-id="required_pass2" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-use.png">
        Unlock Code
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
    <form class="form-horizontal" method="POST">
            <input type="hidden" id="yuan2" value="" name="yuan2"> 
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="001" class="col-sm-3 control-label">Enter Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="001" name="pass">
                </div>
            </div>
    </div>
    <br>
    <button class="button" data-remodal-action="cancel">Cancel</button>
    <button class="button" name="unlockpass2">Unlock</button>
    </form>
</div>

<script type="text/javascript">
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
</script>
<script type="text/javascript">
    $( ".contactses" ).click(function(e) {
      $('.message-list').toggleClass('nyek');
    });
</script>
<script type="text/javascript">
    $(function () {

        $('.footable').footable({
            breakpoints: {
                phone: 480,
                phonie: 768,
                tablet: 1024
            }
        });
    });
</script>
<script type="text/javascript">
// setInterval(
//     function()
//     {
//         if( $(".remodal").hasClass('remodal-is-opened') ) {
//              $('.footable').trigger('footable_initialize');
//          }
//         else{
        
//         }
//     }, 1000);
$(document).ready(function()
{
    myTimeoutFunction();
  
});
function myTimeoutFunction()
{
    $('.footable').trigger('footable_initialize');
    timerId = setTimeout(myTimeoutFunction, 1000);
}

</script>

</html>
