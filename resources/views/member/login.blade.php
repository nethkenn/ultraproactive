<!DOCTYPE html>
<html lang="en-US" class="css3transitions">
<head>
    <link rel="shortcut icon" type="image/x-icon" href="/resources/assets/frontend/img/logo.png">
    <title>UltraProactive - Member Login</title>
	<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/login.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/jquery.remodal.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/remodal-default-theme.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/jquery-ui/jquery-ui.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,300' rel='stylesheet' type='text/css'>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-65579552-3', 'auto');
      ga('send', 'pageview');

    </script>
</head>

<form method="POST">
    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
    <div class="bg">
    	<div class="wrapper" style="position: static; top: auto; bottom: auto; left: auto; right: auto; transform: none;">
    		<div class="content para">
                <div class="logo">
                    <img style="max-width: 400px; margin-top: 50px;" src="https://digima.sgp1.digitaloceanspaces.com/ultraproactive/UPMI%20New%20Logo%20Final%20Text.png">
                </div>
                @if(Session::has('errored'))
                    <div class="alert alert-danger">
                        <ul>
                            {{ $error }}
                        </ul>
                    </div>
                 @endif
                 @if(Session::has('greened'))
                    <div class="alert alert-success">
                        <ul>
                            {{ $success }}
                        </ul>
                    </div>
                 @endif
                <div style="font-size: 14px; text-align: left;">Username</div>
                <div class="input">
                    <input type="text" name="user" style="height: 40px;">
                </div>
                <div style="font-size: 14px; text-align: left;">Password</div>
                <div class="input">
                    <input type="password" name="pass" style="height: 40px;">
                </div>
                {{--<div class="forgot"><a href="javascript:" style="color: #0000A7; font-style: normal; font-weight: 600;">Forgot Password?</a></div>--}}
                <a href="javascript:">
                    <button style="background-color: #FFC200; margin-top: 20px; height: 40px; font-size: 18px;" type="submit" name="login">LOGIN</button>
                </a>
                {{--<a href="/">--}}
                    {{--<button type="button" style="height: 40px; margin-top: 5px; background-color: #FFC200; ">GO BACK</button>--}}
                {{--</a>--}}
                <div class="create">
                    <a href="register" style="color: #0000A7;">New here? Create an account.</a>
                </div>
    		</div>
    	</div>
    </div>
</form>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/resources/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
<script type="text/javascript" src="/resources/assets/jquery-ui/jquery-ui.js"></script>
</html>