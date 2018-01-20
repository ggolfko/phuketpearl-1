@extends('dashboard.layout')

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="FormController">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-8">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<a href="/dashboard/employees" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('employee.Add New Employee')}}</span>
							</div>
						</div>
                    </header>
                    <div class="panel-body">
                        @if(session()->has('eMessage'))
                        <div class="alert alert-danger fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('eMessage')}}
						</div>
                        @endif
                        <form class="form-horizontal tasi-form" method="post" action="{{$request->fullUrl()}}" name="createForm" ng-submit="form($event)">
							<div class="form-group" ng-class="{'has-error':error.name}">
                                <label class="col-sm-3 control-label">{{trans('_.Name')}}</label>
                                <div class="col-sm-9 no-padding">
                                	<div class="col-xs-6 no-padding-item">
										<input type="text" class="form-control" name="firstname" maxlength="100" autocomplete="off" placeholder="{{trans('_.First name')}}" ng-model="firstname" autofocus>
									</div>
									<div class="col-xs-6 no-padding-item">
										<input type="text" class="form-control" name="lastname" maxlength="100" autocomplete="off" placeholder="{{trans('_.Last name')}}" ng-model="lastname">
									</div>
                                </div>
                            </div>
							<div class="form-group" ng-class="{'has-error':error.username||error.ajax.username}">
                                <label class="col-sm-3 control-label">{{trans('_.Username')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="username" maxlength="32" autocomplete="off" ng-model="username" ng-keyup="checkUsername($event)">
									<img src="/static/dashboard/assets/img/process.gif" class="ui-process input" ng-show="process.username">
									<p class="help-block" ng-show="error.ajax.username">
										<em>{{trans('auth.This username is already in use, please choose another username.')}}</em>
									</p>
									<p class="help-block"><em>{{trans('auth.The username must contain the letters A-Z a-z 0-9 _ . only, and must be at least 5 characters long.')}}</em></p>
								</div>
                            </div>
							<div class="form-group" ng-class="{'has-error':error.email||error.ajax.email}">
                                <label class="col-sm-3 control-label">{{trans('_.Email address')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" maxlength="128" autocomplete="off" ng-model="email" ng-keyup="checkEmail($event)">
									<img src="/static/dashboard/assets/img/process.gif" class="ui-process input" ng-show="process.email">
									 <p class="help-block" ng-show="error.ajax.email">
									 	<em>{{trans('auth.This email address is already in use, please choose another email address.')}}</em>
									 </p>
                                </div>
							</div>
							<div class="form-group">
                                <label class="col-sm-3 control-label">{{trans('_.Permissions')}}</label>
                                <div class="col-sm-9">
									<div class="checkboxes">
                                        <label class="label_check c_on">
											<input name="permission_product" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('employee.Product management')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="permission_enquiry" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('_.Jewel enquiry')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="permission_tour" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('_.Package tours')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="permission_book" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('_.Tour booking')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="permission_newsletter" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('_.Newsletter')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="permission_news" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('_.News')}}</span>
										</label>
                                        <label class="label_check c_on hidden">
											<input name="permission_contact" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('_.Contacts')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="permission_document" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('_.Documents')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="permission_payment" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('payment.Payments')}}</span>
										</label>
										<label class="label_check c_on">
											<input name="permission_setting" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('employee.The settings of the site')}}</span>
										</label>
										<label class="label_check c_on">
											<input name="permission_employee" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('employee.Employee management')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="permission_gallery" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('_.Gallery')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="permission_video" value="true" type="checkbox" data-plugin="icheck"> <span class="ui-icheck-text">{{trans('_.Videos')}}</span>
										</label>
									</div>
								</div>
                            </div>
							<div class="form-group">
                                <label class="col-sm-3 control-label">{{trans('_.Status')}}</label>
                                <div class="col-sm-9">
									<label class="checkbox-inline" style="padding-left:0px;">
                                		<input type="radio" name="status" value="a" data-plugin="icheck" checked> {{trans('_.Active')}}
									</label>
									<label class="checkbox-inline">
                                		<input type="radio" name="status" value="b" data-plugin="icheck"> {{trans('_.Block')}}
									</label>
								</div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger" ng-disabled="passed">{{trans('_.Add')}}</button>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </div>
                            </div>
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
(function(){
	app.controller('FormController', function($scope, $http, $window){
		$scope.error = {
			ajax: {
				username: false,
				email: false
			},
			name: false,
			username: false,
			email: false
		};
		$scope.success = {
			username: false,
			email: false
		};
		$scope.process = {
			username: false,
			email: false
		};
		$scope.temp = {
			username: null,
			email: null
		};
		$scope.passed		= false;
		$scope.interrupt	= false;

		$scope.checkUsername = function($event){
			$scope.error.ajax.username	= false;
			$scope.process.username		= false;
			$scope.success.username		= false;

			if ($scope.username && $scope.username.length > 4 && /^[a-zA-Z0-9_.]+$/.test($scope.username) && $scope.temp.username != $scope.username)
			{
				$scope.temp.username	= $scope.username;
				$scope.process.username	= true;

				$http.post('/ajax/dashboard/employees/exists/username', {
					username: $scope.username
				})
				.success(function(resp){
					if (resp.status == 'ok')
					{
						if (resp.payload.exists == true){
							$scope.error.ajax.username = true;
						}
						else{
							$scope.success.username = true;
						}
					}
					else {
						if ($scope.interrupt == false){
							$scope.interrupt = true;
							alert(resp.message);
							$window.location.reload();
						}
					}
				})
				.error(function(){
					if ($scope.interrupt == false){
						$scope.interrupt = true;
						alert('{{trans('error.general')}}');
						$window.location.reload();
					}
				})
				.finally(function(){
					$scope.process.username = false;
				});
			}
		};

		$scope.checkEmail = function($event){
			$scope.error.ajax.email		= false;
			$scope.process.email		= false;
			$scope.success.email		= false;

			if ($scope.email && /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test($scope.email) && $scope.temp.email != $scope.email)
			{
				$scope.temp.email		= $scope.email;
				$scope.process.email	= true;

				$http.post('/ajax/dashboard/employees/exists/email', {
					email: $scope.email
				})
				.success(function(resp){
					if (resp.status == 'ok')
					{
						if (resp.payload.exists == true){
							$scope.error.ajax.email = true;
						}
						else{
							$scope.success.email = true;
						}
					}
					else{
						if ($scope.interrupt == false){
							$scope.interrupt = true;
							alert(resp.message);
							$window.location.reload();
						}
					}
				})
				.error(function(){
					if ($scope.interrupt == false){
						$scope.interrupt = true;
						alert('{{trans('error.general')}}');
						$window.location.reload();
					}
				})
				.finally(function(){
					$scope.process.email = false;
				});
			}
		};

		$scope.form = function($event){
			$scope.error.name			= false;
			$scope.error.username		= false;
			$scope.error.email			= false;

			$scope.passed = false;

			if (!$scope.firstname || !$scope.lastname){
				$scope.error.name = true;
			}
			if (!$scope.username || $scope.username.length < 5 || !/^[a-zA-Z0-9_.]+$/.test($scope.username) || $scope.success.username == false){
				$scope.error.username = true;
			}
			if (!$scope.email || !/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test($scope.email) || $scope.success.email == false){
				$scope.error.email = true;
			}

			if (
				$scope.error.name == false &&
				$scope.error.username == false &&
				$scope.error.email == false &&
				$scope.success.username == true &&
				$scope.success.email == true &&
				$scope.error.ajax.username == false &&
				$scope.error.ajax.email == false
			){
				$scope.passed = true;
				return true;
			}

			$event.preventDefault();
		};
	});
})();
</script>
@endsection
