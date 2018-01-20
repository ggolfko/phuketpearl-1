@extends('dashboard.auth.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/iCheck/skins/flat/red.css">
<script src="/static/bower_components/iCheck/icheck.min.js"></script>
<script>
$(function(){
    $('.form-signin')
        .css('margin-top', (($(window).outerHeight(true)/2)-(($('.form-signin').outerHeight(true)/2)+20))+'px')
        .show();
});

app.controller('ResetController', function($scope){
    $scope.valid = {
        email: true,
        password: true,
        cpassword: true
    };

    $scope.helper       = {};
    $scope.submitted    = false;

    $scope.save = function(e){
        $scope.valid.email      = true;
        $scope.valid.password   = true;
        $scope.valid.cpassword  = true;

        if (!$scope.email || !/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test($scope.email)){
            $scope.valid.email = false;
        }
        if (!$scope.password || !/^[a-zA-Z0-9]+$/.test($scope.password) || $scope.password.length < 6){
            $scope.valid.password = false;
        }
        if (!$scope.cpassword || !/^[a-zA-Z0-9]+$/.test($scope.cpassword) || $scope.cpassword.length < 6 || $scope.cpassword != $scope.password){
            $scope.valid.cpassword = false;
        }

        if ($scope.valid.email == true && $scope.valid.password == true && $scope.valid.cpassword == true){
            $scope.submitted = true;
            return true;
        }
        e.preventDefault();
    };
});
</script>
@endsection

@section('content')
<style>
.has-error{border:1px solid #b50b00 !important;}
form input[type=text],
form input[type=password]{color:#666;}
</style>
<div class="container" ng-controller="ResetController">
    <form class="form-signin" method="post" action="{{$request->fullUrl()}}" name="resetForm" ng-submit="save($event)">
    <h2 class="form-signin-heading"><img src="/static/images/logo-200-100.png"></h2>
    <div class="login-wrap">
        <p>{{trans('auth.Reset your password')}}</p>
        @if(session()->has('eMessage'))
        <div class="alert alert-block alert-danger fade in">
            {{session('eMessage')}}
        </div>
        @endif
        <input
            type="text"
            name="email"
            class="form-control"
            placeholder="{{trans('_.Email address')}}"
            maxlength="128"
            autocomplete="off"
            autofocus
            ng-model="email"
            ng-class="{'has-error':!valid.email}">
        <input
            type="password"
            name="password"
            class="form-control"
            placeholder="{{trans('auth.New password')}}"
            autocomplete="off"
            ng-model="password"
            ng-class="{'has-error':!valid.password}"
            ng-focus="helper.password=true"
            ng-blur="helper.password=false">
        <span class="help-block" ng-show="helper.password" ng-init="helper.password=false" style="margin-top:-8px;">
            {{trans('auth.The password must contain the letters A-Z a-z 0-9 only, and must be at least 6 characters long.')}}
        </span>
        <input
            type="password"
            name="password_confirmation"
            class="form-control"
            placeholder="{{trans('auth.Confirm new password')}}"
            autocomplete="off"
            ng-model="cpassword"
            ng-class="{'has-error':!valid.cpassword}">
        <button class="btn btn-lg btn-login btn-block" type="submit" ng-disabled="submitted">{{trans('_.Save changes')}}</button>
        <div class="footer-section">
			<div class="pull-left" style="text-align: left; width: calc(100% - 40px);">
				<span style="font-size:12px;">{{$config['copyright']}}</span>
			</div>
			<div class="dropdown change-lang pull-right" style="width: 40px; padding-right: 1px;">
                <a data-toggle="dropdown" class="dropdown-toggle current pull-right" href="#">
                    <img src="/static/dashboard/assets/img/flags/{{$config['lang']['code']}}.png" alt="{{$config['lang']['title']}}">
                </a>
                <ul class="dropdown-menu pull-right">
                    <div class="log-arrow-up"></div>
                    @foreach($config['langs'] as $lang)
                    <li>
                        <a href="#" ng-click="lang($event, '{{$lang['code']}}')">
                            <img src="/static/dashboard/assets/img/flags/{{$lang['code']}}.png" alt="{{$lang['title']}}"> {{$lang['title']}}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
			<div style="clear: both"></div>
        </div>
    </div>
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
</div>
@endsection
