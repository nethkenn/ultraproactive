<html>
    <head>
        <title></title>
        <base href="<?php echo "http://" . $_SERVER["SERVER_NAME"] ?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="_token" content="{{ csrf_token() }}">
        <title>Admin Panel - Intogadgets</title>
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
        <link rel="stylesheet" type="text/css" href="/resources/assets/frontend/css/login.css">
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
    </head>
    <body>
        <div class="login">
            <form class="form-horizontal" method="POST" action="admin/login">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="ribbon-holder">
                    <div class="ribbon">Admin Login</div>
                    <div class="likod"></div>
                </div>
                <div class="form-group">
                    @if($_error)
                    <div class="col-md-12 alert alert-danger">
                        {{$_error}}
                    </div>
                    @endif
                    <div class="col-sm-12 ediwow">
                        <div class="wowie"><img src="/resources/assets/frontend/img/user.png"></div>
                        <div class="wew"></div>
                        <input type="text" value="{{Request::input('username')}}" name="username" class="form-control" id="" placeholder="Username">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 ediwow">
                        <div class="wowie"><img src="/resources/assets/frontend/img/pass.png"></div>
                        <div class="wew"></div>
                        <input name="password" type="password" class="form-control" id="" placeholder="Password" value="{{Request::input('password')}}">
                    </div>
                </div>
                <div class="form-group hide">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember-login"> Remember me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="button-bottom">
                    <div>
                        <button type="submit" class="btn btn-default">Log-in</button>
                    </div>
                </div>
            </form>
        </div>
        <script src="/resources/assets/external/jquery.min.js"></script>
        <script src="/resources/assets/external/bootstrap.min.js"></script>
        <script src="/resources/assets/bootstrap/bootstrap-switch.js"></script>
        <script src="/resources/assets/primia/primia-admin.js"></script>
        <script src="/resources/assets/admin/global.js"></script>
        <script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    </body>
</html>