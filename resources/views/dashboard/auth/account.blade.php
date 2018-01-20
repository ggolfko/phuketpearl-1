@extends('dashboard.layout')

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
	<section class="wrapper">
        <div class="row">

            <div class="col-lg-6">
                <section class="panel" ng-controller="ChangePersonal">
                    <header class="panel-heading">
                        {{trans('auth.Change personal information')}}
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="{{$request->fullUrl()}}" name="personalForm" ng-submit="save($event)">
							@if(session()->has('sMessagePersonal'))
							<div class="alert alert-success fade in">
								<button data-dismiss="alert" class="close close-sm" type="button">
									<i class="fa fa-times"></i>
								</button>
								{{session('sMessagePersonal')}}
							</div>
							@endif
							@if(session()->has('eMessagePersonal'))
							<div class="alert alert-block alert-danger fade in">
								<button data-dismiss="alert" class="close close-sm" type="button">
									<i class="fa fa-times"></i>
								</button>
								{{session('eMessagePersonal')}}
							</div>
							@endif
                            <div class="form-group" ng-class="{'has-error':!valid.firstname}">
                                <label class="col-lg-3 control-label">{{trans('_.First name')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="firstname" class="form-control" ng-model="firstname" maxlength="32">
				                </div>
                            </div>
							<div class="form-group" ng-class="{'has-error':!valid.lastname}">
                                <label class="col-lg-3 control-label">{{trans('_.Last name')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="lastname" class="form-control" ng-model="lastname" maxlength="32">
				                </div>
                            </div>
							<div class="form-group" ng-class="{'has-error':!valid.username}">
                                <label class="col-lg-3 control-label">{{trans('_.Username')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="username" class="form-control" maxlength="32" ng-model="username" ng-focus="helper.username=true" ng-blur="helper.username=false">
									 <span class="help-block" ng-show="helper.username" ng-init="helper.username=false">
									    {{trans('auth.The username must contain the letters A-Z a-z 0-9 _ . only, and must be at least 5 characters long.')}}
								     </span>
				                </div>
                            </div>
							<div class="form-group" ng-class="{'has-error':!valid.email}">
                                <label class="col-lg-3 control-label">{{trans('_.Email address')}}</label>
                                <div class="col-lg-9">
                                    <input type="text" name="email" class="form-control" ng-model="email" maxlength="128">
				                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <button type="submit" class="btn btn-danger" ng-disabled="submitted"><i class="fa fa-save"></i> {{trans('_.Save changes')}}</button>
                                </div>
                            </div>
							<input type="hidden" name="form" value="personal">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                    </div>
                </section>
            </div>

            <div class="col-lg-6">
                <section class="panel" ng-controller="ChangePassword">
                    <header class="panel-heading">
                        {{trans('auth.Change password')}}
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="{{$request->fullUrl()}}" ng-submit="save($event)">
							@if(session()->has('sMessagePassword'))
							<div class="alert alert-success fade in">
								<button data-dismiss="alert" class="close close-sm" type="button">
									<i class="fa fa-times"></i>
								</button>
								{{session('sMessagePassword')}}
							</div>
							@endif
							@if(session()->has('eMessagePassword'))
							<div class="alert alert-block alert-danger fade in">
								<button data-dismiss="alert" class="close close-sm" type="button">
									<i class="fa fa-times"></i>
								</button>
								{{session('eMessagePassword')}}
							</div>
							@endif
                            <div class="form-group" ng-class="{'has-error':!valid.opassword}">
                                <label class="col-lg-3 control-label">{{trans('auth.Old password')}}</label>
                                <div class="col-lg-9">
                                    <div class="iconic-input right">
                                        <i class="fa fa-key"></i>
                                        <input type="password" name="opassword" class="form-control" ng-model="opassword">
                                    </div>
				                </div>
                            </div>
                            <div class="form-group" ng-class="{'has-error':!valid.password}">
                                <label class="col-lg-3 control-label">{{trans('auth.New password')}}</label>
                                <div class="col-lg-9">
                                    <div class="iconic-input right">
                                        <i class="fa fa-key"></i>
                                        <input type="password" name="password" class="form-control" ng-model="password" ng-focus="helper.password=true" ng-blur="helper.password=false">
										<span class="help-block" ng-show="helper.password" ng-init="helper.password=false;">
										{{trans('auth.The password must contain the letters A-Z a-z 0-9 only, and must be at least 6 characters long.')}}
										</span>
                                    </div>
				                </div>
                            </div>
                            <div class="form-group" ng-class="{'has-error':!valid.cpassword}">
                                <label class="col-lg-3 control-label">{{trans('auth.Confirm again')}}</label>
                                <div class="col-lg-9">
                                    <div class="iconic-input right">
                                        <i class="fa fa-key"></i>
                                        <input type="password" name="cpassword" class="form-control" ng-model="cpassword">
                                    </div>
				                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <button type="submit" class="btn btn-danger" ng-disabled="submitted"><i class="fa fa-save"></i> {{trans('_.Save changes')}}</button>
                                </div>
                            </div>
							<input type="hidden" name="form" value="password">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                    </div>
                </section>
            </div>

        </div>
	</section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script>
$(function(){
	$('#main-content').removeClass('hidden');
});

app.controller('ChangePassword', function($scope){
	$scope.valid = {
		opassword: true,
		password: true,
		cpassword: true
	};

	$scope.helper = {};
	$scope.submitted = false;

	$scope.save = function(e){
		$scope.valid.opassword	= true;
		$scope.valid.password	= true;
		$scope.valid.cpassword	= true;

		if (!$scope.opassword){
			$scope.valid.opassword = false;
		}
		if (!$scope.password || !/^[a-zA-Z0-9]+$/.test($scope.password) || $scope.password.length < 6){
			$scope.valid.password = false;
		}
		if (!$scope.cpassword || !/^[a-zA-Z0-9]+$/.test($scope.cpassword) || $scope.cpassword.length < 6 || $scope.cpassword != $scope.password){
			$scope.valid.cpassword = false;
		}

		if ($scope.valid.opassword == true && $scope.valid.password == true && $scope.valid.cpassword == true){
			$scope.submitted = true;
			return true;
		}
		e.preventDefault();
	};
});

app.controller('ChangePersonal', function($scope){
	$scope.valid = {
		firstname: true,
		lastname: true,
		username: true,
		email: true
	};
	$scope.helper = {};
	$scope.submitted = false;

	$scope.firstname	= '{{$user->firstname}}';
	$scope.lastname		= '{{$user->lastname}}';
	$scope.username		= '{{$user->username}}';
	$scope.email		= '{{$user->email}}';

	$scope.save = function(e){
		$scope.valid.firstname	= true;
		$scope.valid.lastname	= true;
		$scope.valid.username	= true;
		$scope.valid.email		= true;

		if (!$scope.firstname || $scope.firstname.trim().replace(/ /g,'') == ''){
			$scope.valid.firstname = false;
		}
		if (!$scope.lastname || $scope.lastname.trim().replace(/ /g,'') == ''){
			$scope.valid.lastname = false;
		}
		if (!$scope.username || $scope.username.trim().replace(/ /g,'') == '' || !/^[a-zA-Z0-9_.]+$/.test($scope.username) || $scope.username.length < 5){
			$scope.valid.username = false;
		}
		if (!$scope.email || $scope.email.trim().replace(/ /g,'') == '' || !/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test($scope.email)){
			$scope.valid.email = false;
		}

		if ($scope.valid.firstname == true && $scope.valid.lastname == true && $scope.valid.username == true && $scope.valid.email == true){
			$scope.submitted = true;
			return true;
		}
		e.preventDefault();
	};
});
</script>
@endsection
