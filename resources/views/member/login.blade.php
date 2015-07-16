<!DOCTYPE html>
<html lang="en-US" class="css3transitions">
<head>
	<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/login.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/jquery.remodal.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/remodal/src/remodal-default-theme.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/jquery-ui/jquery-ui.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,300' rel='stylesheet' type='text/css'>
</head>
<form method="POST">
    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
    <div class="bg">
    	<div class="wrapper">
    		<div class="content para">
                <div class="logo">
                    <img src="/resources/assets/frontend/img/big-logo.png">
                </div>
                <div class="input">
                    <input type="text" name="user">
                </div>
                <div class="input">
                    <input type="password" name="pass">
                </div>
                <div class="forgot"><a href="javascript:">Forgot Password?</a></div>
                <a href="javascript:">
                    <button type="submit" name="login" style="margin-top: 20px;">LOGIN</button>
                </a>
                <a href="/">
                    <button onClick="location.href='/'" style="margin-top: 5px;">GO BACK</button>
                </a>
                <div class="create">
                    <a href="register">New here? Create an account.</a>
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