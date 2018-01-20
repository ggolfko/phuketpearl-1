<!DOCTYPE html>
<html lang="{{$config['lang']['code']}}" ng-app="app">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="_token" content="{{csrf_token()}}">
	<meta name="robots" content="noindex, nofollow">
    <title>{{$config['name']}}</title>
    <link href="/static/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/static/bower_components/components-font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="/static/dashboard/assets/css/bootstrap-reset.css" rel="stylesheet">
	<link href="/static/dashboard/assets/css/style.css?_t=1704270518" rel="stylesheet">
	<link href="/static/dashboard/assets/css/style-responsive.css" rel="stylesheet" />
    <!--[if lt IE 9]>
    <script src="/static/dashboard/assets/js/html5shiv.js"></script>
    <script src="/static/dashboard/assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="/static/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/static/bower_components/angular/angular.min.js"></script>
	<script src="/static/bower_components/angular-animate/angular-animate.min.js"></script>
	<script src="/static/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
    <script src="/static/dashboard/assets/js/app.js"></script>
	<script src="/static/dashboard/assets/js/core.js"></script>
    <script>
        app.controller('AppController', function($scope, $http, $window){
            $scope.lang = function(e, code){
                $http.post('/ajax/lang', {
                    code:code
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $window.location.reload();
                    }
                    else{
                        alert(resp.message);
                    }
                })
                .error(function(){
                    alert('{{trans("error.general")}}');
                });

                e.preventDefault();
            };
        });
    </script>
    @section('head')
    @show
</head>
<body class="login-body" ng-controller="AppController">
    @section('content')
    @show
</body>
</html>
