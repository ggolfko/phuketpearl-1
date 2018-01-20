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

    app.controller('LoginController', function($scope, $http, $window){
        $scope.error = {username:false, password:false};
        $scope.submited = false;
        $scope.login = function(e){
            $scope.error = {username:false, password:false};

            if (!$scope.username || $scope.username.replace(/ /g, '') == ''){
                $scope.error.username = true;
            }

            if (!$scope.password || $scope.password == ''){
                $scope.error.password = true;
            }

            if ($scope.error.username == true){
                $('#username').focus();
            }
            else if ($scope.error.password == true){
                $('#password').focus();
            }

            if ($scope.error.username == false && $scope.error.password == false){
                $scope.submited = true;
                return true;
            }
            e.preventDefault();
        };
    });

    app.controller('ReminderController', function($scope, $http){
        $scope.valid    = true;
        $scope.btn      = '{{trans('auth.Reset password')}}';
        $scope.sending  = false;
        $scope.errorMessage     = null;
        $scope.successMessage   = null;

        $scope.send = function(e){
            $scope.valid    = true;
            $scope.errorMessage     = null;
            $scope.successMessage   = null;

            if (!$scope.email || !/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test($scope.email)){
                $scope.valid = false;
                $('#reminder-email').focus();
            }
            else{
                $scope.btn      = '{{trans('auth.Sending to your email...')}}';
                $scope.sending  = true;

                $http.post('/ajax/dashboard/auth/reminder', {
                    email:$scope.email.trim()
                })
                .success(function(resp){
                    if (resp.status == 'ok')
                    {
                        $scope.successMessage = resp.message;
                        $scope.btn      = '{{trans('auth.Reset password')}}';
                        $scope.sending  = false;
                        $scope.email    = null;
                    }
                    else{
                        $scope.errorMessage = resp.message;
                        $scope.btn      = '{{trans('auth.Reset password')}}';
                        $scope.sending  = false;
                    }
                })
                .error(function(){
                    $scope.errorMessage = '{{trans("error.general")}}';
                    $scope.btn      = '{{trans('auth.Reset password')}}';
                    $scope.sending  = false;
                });
            }

            e.preventDefault();
        };

        $('#myModal').on('shown.bs.modal', function(e){
            $('#reminder-email').focus();
        });
    });

    $(function(){
        $('input[type=checkbox]').iCheck({
             checkboxClass: 'icheckbox_flat-red'
        });
    });
</script>
@endsection

@section('content')
<style>
.has-error{border:1px solid #dc0e00 !important;}
form input[type=text],
form input[type=password]{color:#666;}
</style>
<div class="container">
    <div ng-controller="LoginController">
        <form class="form-signin" method="post" action="{{$request->fullUrl()}}" name="loginForm" ng-submit="login($event)">
        <h2 class="form-signin-heading"><img src="/static/images/logo-200-100.png"></h2>
        <div class="login-wrap">
            @if(session()->has('eMessage'))
            <div class="alert alert-block alert-danger fade in">
                {{session('eMessage')}}
            </div>
            @endif
            @if(session()->has('sMessage'))
            <div class="alert alert-block alert-success fade in">
                {{session('sMessage')}}
            </div>
            @endif
            <input
                type="text"
                name="username"
                id="username"
                class="form-control"
                placeholder="{{trans('_.Username')}}"
                autofocus
                ng-model="username"
                ng-class="{'has-error':error.username}">
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                placeholder="{{trans('_.Password')}}"
                ng-model="password"
                ng-class="{'has-error':error.password}">
            <label class="checkbox">
                <input type="checkbox" value="true" name="remember" checked> {{trans('auth.Remember me')}}
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> {{trans('auth.Forgot Password')}}?</a>
                </span>
            </label>
            <button
                class="btn btn-lg btn-login btn-block"
                type="submit"
                ng-disabled="submited">
            {{trans('auth.Log In')}}</button>

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
                            <a href="#" ng-click="lang($event,'{{$lang['code']}}')">
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
		<input type="hidden" name="_rdi" value="{{$redirect}}">
        </form>
    </div>

    <!-- Reminder Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:2px !important;">
                <form ng-controller="ReminderController" ng-submit="send($event)">
                    <div class="modal-header" style="border-radius:1px 1px 0 0!important;background-color:#35404d;padding-left:24px;padding-right:22px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:#fff;">&times;</button>
                        <h6 class="modal-title">{{trans('auth.Forgot Password')}}?</h6>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-block alert-danger fade in" ng-show="errorMessage != null">[[errorMessage]]</div>
                        <div class="alert alert-block alert-success fade in" ng-show="successMessage != null" ng-bind-html="successMessage"></div>
                        <p style="font-size:14px;">{{trans('auth.Enter your e-mail address below to reset your password.')}}</p>
                        <input
                            type="text"
                            name="email"
                            id="reminder-email"
                            placeholder="{{trans('_.Email address')}}"
                            autocomplete="off"
                            class="form-control placeholder-no-fix"
                            style="color:#666;"
                            ng-model="email"
                            ng-class="{'has-error':!valid}"
                            ng-disabled="sending">
                    </div>
                    <div class="modal-footer" style="padding-top:7px;padding-bottom:7px;">
                        <button
                            data-dismiss="modal"
                            class="btn btn-default"
                            type="button"
                            style="border-radius:1px !important;">{{trans('_.Close')}}</button>
                        <button
                            class="btn btn-primary active"
                            type="submit"
                            style="border-radius:1px !important;background-color:#3d4a59;border-color:#000;"
                            onmouseover="this.style.backgroundColor='#35404d';"
                            onmouseout="this.style.backgroundColor='#3d4a59';"
                            ng-disabled="sending">[[btn]]</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Reminder Modal -->
</div>
@endsection
