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
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,300' rel='stylesheet' type='text/css'>
</head>
<div class="bg">
	<div class="wrapper container">
		<div class="header-nav">
			<div class="header">
				<div class="col-md-6 ubod">
                    <img src="/resources/assets/frontend/img/member-logo.png">
                </div>
                <div class="col-md-6 grabe">
                    <div class="header-text">Account Setting</div>
                    <div class="header-text">Guillermo Tabligan ( Logout )</div>
                </div>
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
			        <li class="{{ Request::segment(2) == '' ? 'active' : '' }}"><a href="/member">Dashboard</a></li>
			        <li class="{{ Request::segment(2) == 'slot' ? 'active' : '' }}"><a href="/member/slot">My Slots</a></li>
			        <li class="{{ Request::segment(2) == 'code_vault' ? 'active' : '' }}"><a href="/member/code_vault">Code Vault</a></li>
			        <li class="{{ Request::segment(2) == 'genealogy' ? 'active' : '' }}"><a href="/member/genealogy">Genealogy</a></li>
			        <li class="{{ Request::segment(2) == 'encashment' ? 'active' : '' }}"><a href="/member/encashment">Encashment</a></li>
			        <li class="{{ Request::segment(2) == 'product' ? 'active' : '' }}"><a href="/member/product">Product</a></li>
			        <li class="{{ Request::segment(2) == 'voucher' ? 'active' : '' }}"><a href="/member/voucher">Voucher</a></li>
			        <li class="{{ Request::segment(2) == 'leads' ? 'active' : '' }}"><a href="/member/leads">Leads</a></li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right" style="margin-right: 0;">
                    <li>
                        <div class="select-label">You are using</div>
                    </li>
			         <li>
                        <select class="form-control">
                            <option>Slot #5 (1,200.00)</option>
                         </select>
                     </li>
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
<script src='http://cdnjs.cloudflare.com/ajax/libs/es5-shim/2.3.0/es5-shim.js'></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/resources/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
<script type="text/javascript" src="/resources/assets/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="/resources/assets/stickyfloat/stickyfloat.js"></script>
@yield('script')
<div class="remodal create-slot" data-remodal-id="create_slot">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-plis.png">
        Create Slot
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="1" class="col-sm-3 control-label">Sponsor</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="1">
                </div>
            </div>
            <div class="form-group para">
                <label for="2" class="col-sm-3 control-label">Placement</label>
                <div class="col-sm-9">
                    <select class="form-control" id="2">
                        <option>Slot #8</option>
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="3" class="col-sm-3 control-label">Position</label>
                <div class="col-sm-9">
                    <select class="form-control" id="3">
                        <option>Left</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <br>
    <button data-remodal-action="cancel">Cancel</button>
    <button data-remodal-action="confirm">Create Slot</button>
</div>
<div class="remodal create-slot" data-remodal-id="transfer_code">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-transfer.png">
        Transfer Code
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="11" class="col-sm-3 control-label">Code</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="11">
                </div>
            </div>
            <div class="form-group para">
                <label for="22" class="col-sm-3 control-label">Recipient</label>
                <div class="col-sm-9">
                    <select class="form-control" id="22">
                        <option>Slot #8</option>
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="33" class="col-sm-3 control-label">Enter Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="33">
                </div>
            </div>
        </form>
    </div>
    <br>
    <button data-remodal-action="cancel">Cancel</button>
    <button data-remodal-action="confirm">Create Slot</button>
</div>
<div class="remodal create-slot" data-remodal-id="use_code">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-use.png">
        Use Code
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="111" class="col-sm-3 control-label">Points Recipient</label>
                <div class="col-sm-9">
                    <select class="form-control" id="111">
                        <option>Slot #8</option>
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="222" class="col-sm-3 control-label">Unilevel Points</label>
                <div class="col-sm-9">
                    <select class="form-control" id="222">
                        <option>Slot #8</option>
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="333" class="col-sm-3 control-label">Binary Points</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="333">
                </div>
            </div>
        </form>
    </div>
    <br>
    <button data-remodal-action="cancel">Cancel</button>
    <button data-remodal-action="confirm">Create Slot</button>
</div>
<div class="remodal create-slot" data-remodal-id="claim_code">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-claim.png">
        Claim Code
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="1111" class="col-sm-3 control-label">Pin Number</label>
                <div class="col-sm-9">
                    <select class="form-control" id="1111">
                        <option>Associate</option>
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="2222" class="col-sm-3 control-label">Code</label>
                <div class="col-sm-9">
                    <select class="form-control" id="2222">
                        <option>1,200.00</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <br>
    <button data-remodal-action="cancel">Cancel</button>
    <button data-remodal-action="confirm">Create Slot</button>
</div>
<div class="remodal create-slot" data-remodal-id="buy_code">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-buy.png">
        Buy Codes
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="111" class="col-sm-3 control-label">Membership</label>
                <div class="col-sm-9">
                    <select class="form-control" id="11111">
                        <option>Associate</option>
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="22222" class="col-sm-3 control-label">Wallet</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="22222">
                </div>
            </div>
            <div class="form-group para">
                <label for="33333" class="col-sm-3 control-label">Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="33333">
                </div>
            </div>
            <div class="form-group para">
                <label for="44444" class="col-sm-3 control-label">Remaining</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="44444" readonly style="background-color: #f47265; border: 0; color: white; text-align: center;" value="-180,000.00">
                </div>
            </div>
        </form>
    </div>
    <br>
    <button data-remodal-action="cancel">Cancel</button>
    <button data-remodal-action="confirm">Create Slot</button>
</div>
<div class="remodal create-slot" data-remodal-id="encashment_history">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-encashment.png">
        Encashment History
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-12 para">
        <table>
            <thead>
                <tr>
                    <td>#</td>
                    <td>Deduction</td>
                    <td>Status</td>
                    <td>Type</td>
                    <td>Amount</td>
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
<div class="remodal create-slot" data-remodal-id="encashment">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-encashments.png">
        Encashment
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="one" class="col-sm-3 control-label">Wallet</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="one">
                </div>
            </div>
            <div class="form-group para">
                <label for="two" class="col-sm-3 control-label">Encashment Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="two">
                </div>
            </div>
            <div class="form-group para">
                <label for="three" class="col-sm-3 control-label">Remaining</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="three">
                </div>
            </div>
            <div class="form-group para">
                <label for="four" class="col-sm-3 control-label">Tax Deduction</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="four">
                </div>
            </div>
            <div class="form-group para">
                <label for="five" class="col-sm-3 control-label">Service Charges</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="five">
                </div>
            </div>
            <div class="form-group para">
                <label for="six" class="col-sm-3 control-label">Receivables</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="six">
                </div>
            </div>
        </form>
    </div>
    <br>
    <button data-remodal-action="confirm" class="orange-btn">Confirm Encashment</button>
</div>
<div class="remodal create-slot" data-remodal-id="upgrade_member">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-membership.png">
        Claim Code
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="wan" class="col-sm-3 control-label">Choose Membership</label>
                <div class="col-sm-9">
                    <select class="form-control" id="wan">
                        <option>Director</option>
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="tu" class="col-sm-3 control-label">Your Wallet</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tu">
                </div>
            </div>
            <div class="form-group para">
                <label for="tri" class="col-sm-3 control-label">Upgrade Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tri">
                </div>
            </div>
            <div class="form-group para">
                <label for="por" class="col-sm-3 control-label">Enter Your Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="por">
                </div>
            </div>
        </form>
    </div>
    <br>
    <button data-remodal-action="cancel">Cancel</button>
    <button data-remodal-action="confirm">Submit Upgrade</button>
</div>
<div class="remodal create-slot" data-remodal-id="transfer_slot">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-transfer.png">
        Transfer Slot
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="isa" class="col-sm-3 control-label">Slot Being Transferred</label>
                <div class="col-sm-9">
                    <input type="text" value="Slot #8" class="form-control" id="isa">
                </div>
            </div>
            <div class="form-group para">
                <label for="dalawa" class="col-sm-3 control-label">Transfer to the account of</label>
                <div class="col-sm-9">
                    <select class="form-control" id="dalawa">
                        <option>primiaph@gmail.com</option>
                    </select>
                </div>
            </div>
            <div class="form-group para">
                <label for="tatlo" class="col-sm-3 control-label">Enter Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="tatlo">
                </div>
            </div>
        </form>
    </div>
    <br>
    <button data-remodal-action="cancel">Cancel</button>
    <button data-remodal-action="confirm">Initiate Transfer</button>
</div>
<div class="remodal create-slot" data-remodal-id="voucher">
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
        <table>
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sample Product 1</td>
                    <td>12,500.00</td>
                    <td>3</td>
                    <td>38,500.00</td>
                </tr>
                <tr>
                    <td>Sample Product 1</td>
                    <td>12,500.00</td>
                    <td>3</td>
                    <td>38,500.00</td>
                </tr>
                <tr>
                    <td>Sample Product 1</td>
                    <td>12,500.00</td>
                    <td>3</td>
                    <td>38,500.00</td>
                </tr>
                <tr>
                    <td>Sample Product 1</td>
                    <td>12,500.00</td>
                    <td>3</td>
                    <td>38,500.00</td>
                </tr>
                <tr>
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
</div>
<div class="remodal create-slot" data-remodal-id="generate_lead">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-how.png">
        How to Generate Leads
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div style="color: #77818e; font-size: 12p.5x;">You might invite people using this link. </br>People who gives their information using your link become your Leads</div>
    <div><input style="color: #f47265; font-size: 12.5px; width: 80%; margin: 20px auto; padding: 10px; text-align: center; border: 1px solid #eeeeee;" type="text" value="http://yourlink.yourcompanyurl.com"></div>
    <br>
    <button data-remodal-action="confirm">Close</button>
</div>
<div class="remodal create-slot" data-remodal-id="add_lead">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-plis.png">
        Add Leads
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal">
            <div class="form-group para">
                <label for="una" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="una">
                </div>
            </div>
            <div class="form-group para">
                <label for="pangalawa" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="pangalawa">
                </div>
            </div>
        </form>
    </div>
    <br>
    <button data-remodal-action="cancel">Cancel</button>
    <button data-remodal-action="confirm">Buy Code</button>
</div>
<div class="remodal message" data-remodal-id="message">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header para">
        <div class="col-md-6 nya">
            <img src="/resources/assets/frontend/img/icon-messages.png">
            Messages
        </div>
        <div class="col-md-6 nye">
            <a href="javascript:">
                <button type="button">+ Send New Message</button>
            </a>
        </div>
    </div>
    <div class="body">
        <div class="message-list">
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
    <button class="checkawt" data-remodal-action="confirm">Submit Checkout</button>
</div>
<div class="remodal referrals create-slot" data-remodal-id="referral">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-referral.png">
        Referrals
    </div>
    <div class="col-md-12">
        <table>
            <thead>
                <tr>
                    <td>#</td>
                    <td>Deduction</td>
                    <td>Status</td>
                    <td>Type</td>
                    <td>Amount</td>
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
</html>