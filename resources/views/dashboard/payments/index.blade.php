@extends('dashboard.layout')

@section('head')
<style>
.payment-images img {
    max-width: 100%;
    display: inline-block;
    margin-bottom: 5px;
}
.payment-detail {
    font-size: 12px;
}
.whatis {
    font-size: 12px;
    margin-left: 12px;
}
.addform div[class*='col-']{
    margin-top: 7px;
}
.addform .btn {
    margin-top: 2px;
}
.ui-has-error {
    border-color: rgb(132, 53, 52) !important;
}
.ui-bank {
    background-color: #fff !important;
    cursor: pointer;
}
.ui-banks {
    position: relative;
}
.ui-banks .options {
    position: absolute;
    width: 100%;
    height: 300px;
    background-color: #fff;
    top: 34px;
    z-index: 1000;
    overflow-x: hidden;
    overflow-y: auto;
    border: 1px solid #ccc;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    padding-top: 2px;
    padding-bottom: 2px;
}
.ui-banks .options .item {
    position: relative;
    float: left;
    width: 100%;
    cursor: pointer;
    padding: 3px 10px;
    border-bottom: 1px solid rgb(239, 242, 247);
}
.ui-banks .options .item:last-child {
    border-bottom: none;
}
.ui-banks .options .item:hover {
    background-color: #337ab7;
}
.ui-banks .options .item .image {
    position: relative;
    float: left;
    width: 40px;
    padding: 5px;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.ui-banks .options .item .image img {
    width: 100%;
}
.ui-banks .options .item .detail {
    position: relative;
    float: left;
    width: calc(100% - 40px);
    padding-left: 7px;
}
.ui-banks .options .item .detail span {
    display: block;
}
.ui-banks .options .item .detail small {
    display: block;
}
.ui-banks .options .item:hover .detail span,
.ui-banks .options .item:hover .detail small {
    color: #fff;
}

.highlight pre {
    overflow-x: hidden;
    word-break: break-all;
    white-space: normal;
    position: relative;
    color: #797979;
    font-family: 'Open Sans', sans-serif;
    font-size:13px;
}
.highlight pre .bank {
    position: relative;
    float: left;
    width: 100%;
    padding-bottom: 10px;
    margin-bottom: 5px;
    border-bottom: 1px solid #e9e9e9;
}
.highlight pre .bank .image {
    position: relative;
    float: left;
    width: 50px;
    padding: 7px;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.highlight pre .bank .image img {
    width: 100%;
}
.highlight pre .bank .detail {
    position: relative;
    float: left;
    width: calc(100% - 50px);
    padding-left: 10px;
}
.highlight pre .bank .detail span {
    display: block;
    font-size: 13.5px;
    margin-bottom: 2px;
}
.highlight pre .bank .detail small {
    display: block;
}
.highlight pre .bank .detail small em {
    text-transform: uppercase;
    font-style: normal;
}
.highlight pre .remove {
    position: absolute;
    top: 5px;
    right: 5px;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">

		<div class="row">
            <div class="col-md-8">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
                                {{$onsite->name}}
                            </div>
						</div>
                    </header>
                    <div class="panel-body">
						&mdash;
                    </div>
                </section>
            </div>
        </div>

		<div class="row">
            <div class="col-md-8">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
                                {{$credit->name}}
                            </div>
						</div>
                    </header>
                    <div class="panel-body">
						<?php $images = json_decode($credit->image); ?>
						@foreach($images as $image)
						<img src="{{$image}}" style="max-height: 85px;">
						@endforeach
                    </div>
                </section>
            </div>
        </div>

        <div class="row" style="margin-bottom: 200px;">
            <div class="col-md-8">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
                                {{trans('payment.Banks in Thailand')}}
                            </div>
						</div>
                    </header>
                    <div class="panel-body" id="ui-banks-wrapper">
                        @if(session()->has('eMessage_Banks'))
                        <div class="alert alert-danger fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('eMessage_Banks')}}
						</div>
                        @endif
                        @if(session()->has('sMessage_Banks'))
                        <div class="alert alert-success fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('sMessage_Banks')}}
						</div>
                        @endif

                        @foreach($bank->banks as $index => $item)
                        <figure class="highlight" ng-controller="Bank" ng-mouseenter="btn=true" ng-mouseleave="btn=false">
                            <pre>
                                @if($item->bank)
                                <div class="bank">
                                    <div class="image" style="background-color:{{$item->bank->color}};">
                                        <img src="/static/plugins/banks-logo/th/{{$item->bank->acronym}}.svg">
                                    </div>
                                    <div class="detail">
                                        <span>{{$item->bank->thai_name}}</span>
                                        <small>{{$item->bank->official_name}}</small>
                                        <small>{{$item->bank->nice_name}} <em>({{$item->bank->acronym}})</em></small>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-xs-6 col-sm-3">
                                        {{trans('payment.Account name')}}
                                    </div>
                                    <div class="col-xs-6 col-sm-9">
                                        {{$item->account}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-3">
                                        {{trans('payment.Account number')}}
                                    </div>
                                    <div class="col-xs-6 col-sm-9">
                                        {{$item->number}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-3">
                                        {{trans('payment.Account type')}}
                                    </div>
                                    <div class="col-xs-6 col-sm-9">
                                        {{$item->type}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-3">
                                        {{trans('payment.Branch')}}
                                    </div>
                                    <div class="col-xs-6 col-sm-9">
                                        {{$item->branch}}
                                    </div>
                                </div>
                                <div class="remove">
                                    <button type="button" class="btn btn-xs btn-danger" ng-click="remove({{$item->id}})" ng-disabled="removing" ng-class="{'hidden':!btn || removed}">{{trans('_.Remove')}}</button>
                                </div>
                            </pre>
                        </figure>
                        @endforeach

                        <form class="form-horizontal tasi-form addform" method="post" action="{{$request->fullUrl()}}" name="form" ng-controller="Banks" ng-submit="add($event)">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="ui-banks" click-outside="showOptions=false" outside-if-not="ui-bank">
                                        <div class="options" ng-class="{'hidden':!showOptions}">
                                            <div class="item" ng-repeat="item in banks track by $index" ng-click="selectBank($index)">
                                                <div class="image" ng-style="{'background-color':item.color}">
                                                    <img ng-src="/static/plugins/banks-logo/th/[[item.acronym]].svg">
                                                </div>
                                                <div class="detail">
                                                    <span>[[item.thai_name]]</span>
                                                    <small>[[item.official_name]]</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control ui-bank" placeholder="{{trans('payment.Select bank')}}" ng-model="bank.thai_name" ng-click="showOptions=!showOptions" ng-class="{'ui-has-error':error.bank}" readonly id="ui-bank">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="account" class="form-control" maxlength="50" placeholder="{{trans('payment.Account name')}}" ng-model="account" ng-class="{'ui-has-error':error.account}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" name="number" class="form-control" maxlength="50" placeholder="{{trans('payment.Account number')}}" ng-model="number" ng-class="{'ui-has-error':error.number}">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="type" class="form-control" maxlength="50" placeholder="{{trans('payment.Account type')}}" ng-model="type" ng-class="{'ui-has-error':error.type}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" name="branch" class="form-control" maxlength="50" placeholder="{{trans('payment.Branch')}}" ng-model="branch" ng-class="{'ui-has-error':error.branch}">
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-sm btn-danger" ng-disabled="passed">{{trans('payment.Add bank')}}</button>
                                    <input type="hidden" name="form" value="banks">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="bank_id" id="bank_id">
                                    <input type="hidden" name="bankid" id="bankid">
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
<script src="/static/bower_components/angular-click-outside/clickoutside.directive.js"></script>
<script>
app.requires.push('angular-click-outside');

app.controller('Bank', function($scope, $http, $window){
    $scope.btn = false;
    $scope.removed = false;

    $scope.remove = function(id){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.removing = true;

            $http.post('/ajax/dashboard/payments/removebankmap', {
                id: id
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.removed = true;
                    $window.location.href = '/dashboard/payments?method=thaibanks';
                }
                else {
                    alert(resp.message);
                    $scope.removing = false;
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
                $window.location.reload();
            });
        }
    };
});

app.controller('Banks', function($scope){
    @if(session()->has('sMessage_Banks') || session()->has('eMessage_Banks') || $request->input('method') == 'thaibanks')
    $(function(){
        $('html, body').animate({
            scrollTop: $("#ui-banks-wrapper").offset().top - 115
        }, 'fast');
    });
    @endif
    $scope.add = function($event){
        $scope.error = {
            bank: false,
            account: false,
            number: false,
            type: false,
            branch: false
        };

        if (!$scope.bank){
            $scope.error.bank = true;
        }
        if (!$scope.account || $scope.account.trim() == ''){
            $scope.error.account = true;
        }
        if (!$scope.number || $scope.number.trim() == ''){
            $scope.error.number = true;
        }
        if (!$scope.type || $scope.type.trim() == ''){
            $scope.error.type = true;
        }
        if (!$scope.branch || $scope.branch.trim() == ''){
            $scope.error.branch = true;
        }

        if (
            $scope.bank &&
            ($scope.account && $scope.account.trim() != '') &&
            ($scope.number && $scope.number.trim() != '') &&
            ($scope.type && $scope.type.trim() != '') &&
            ($scope.branch && $scope.branch.trim() != '')
        ){
            $('#bank_id').val($scope.bank.id);
            $('#bankid').val($scope.bank.bankid);
            $scope.passed = true;
            return true;
        }
        $event.preventDefault();
    };

    $scope.selectBank = function($index){
        $scope.bank = $scope.banks[$index];
    };

    $scope.showOptions = false;
    $scope.bank  = null;
    $scope.banks = {!! $banks !!};
    $scope.error = {
        bank: false,
        account: false,
        number: false,
        type: false,
        branch: false
    };
});
</script>
@endsection
