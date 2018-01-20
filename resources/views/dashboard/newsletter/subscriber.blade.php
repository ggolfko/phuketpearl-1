@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/dashboard/assets/css/table-responsive.css">
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="content">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="row">
							<div class="col-md-5">
                                <a href="/dashboard/newsletter" class="btn btn-danger btn-sm" style="margin-right: 7px;">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
                                {{trans('subscribe.Subscribers')}}
								<span ng-if="items.length > 0">({{number_format($items->total)}})</span>
                            </div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="input-group pull-right pull-left-sm" style="margin-left: 10px;">
										<button type="button" class="btn btn-sm btn-danger" ng-show="deleteSelected" ng-click="deleteSelect()" ng-disabled="deleting">{{trans('_.Delete the selected')}}</button>
									</div>
									<div class="input-group pull-right pull-left-sm" style="width: 300px;">
										<input type="text" placeholder="{{trans('_.Search')}}..." class="form-control input-sm" ng-model="q" ng-keyup="search()">
										<span class="input-group-btn">
											<button type="button" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
										</span>
									</div>
								</div>
							</div>
						</div>
                    </header>
					<div class="table-responsive">
	                    <table class="table table-striped table-advance table-hover table-condensed cf">
	                        <thead class="cf">
	                            <tr>
	                                <th class="text-center" style="width: 60px;">#</th>
									<th>{{trans('_.Email address')}}</th>
	                                <th>{{trans('_.Status')}}</th>
									<th>{{trans('subscribe.Sign up date')}}</th>
	                                <th style="width: 90px;"></th>
	                            </tr>
	                        </thead>
	                        <tbody>
								<tr ng-if="items.length > 0" ng-controller="item" ng-repeat="item in items | filter: q as filt">
									<td data-title="#" class="text-center">[[$index+1+order]]</td>
									<td data-title="{{trans('_.Email address')}}">[[item.email_address]]</td>
									<td data-title="{{trans('_.Status')}}">
										<span class="label label-primary" style="font-weight: 400;" ng-if="item.status == 'subscribed'">Subscribed</span>
										<span class="label label-warning" style="font-weight: 400;" ng-if="item.status == 'unsubscribed'">Unsubscribed</span>
									</td>
									<td data-title="{{trans('subscribe.Sign up date')}}">
										<span ng-if="item.timestamp_opt">[[item.timestamp_opt | amDateFormat:'DD/MM/YYYY HH:mm:ss']]</span>
										<span ng-if="!item.timestamp_opt">-</span>
									</td>
									<td class="text-right" style="padding-right: 15px;">
										<button class="btn btn-danger btn-xs" ng-click="delete($index)" ng-disabled="deleting" ng-hide="deleting || deleted">{{trans('_.Delete')}}</button>
										<img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="deleting && !deleted">
									</td>
								</tr>
								<tr ng-if="items.length < 1 || filt.length < 1">
							   		<td colspan="5" style="text-align:center;">{{trans('_.No record found.')}}</td>
							    </tr>
	                        </tbody>
	                    </table>
					</div>
					<footer class="ui_pagination">
                        <div class="row">
                            <div class="col-lg-4" style="padding-left:20px;">
                                <div class="show_entry">
                                    <span>
										{{trans_choice('_.TABLE_SHOWING', $items->total, array(
											'showing' => ($items->count == 0? 0 :($items->currentPage*$items->perPage)-($items->perPage-1)),
											'to' => ($items->perPage*($items->currentPage-1))+$items->count,
											'of' => $items->total
										))}}
									 </span>
                                </div>
                            </div>
							<div class="col-lg-8">
                                <div class="dataTables_paginate paging_bootstrap pagination page_list">
                                    <ul>
								        @if($items->currentPage != 1)
                                        <li class="prev"><a href="/dashboard/newsletter/subscribers?page=1">← {{trans('_.First page')}}</a></li>
                                        @else
                                        <li class="prev disabled"><a href="javascript:;">← {{trans('_.First page')}}</a></li>
                                        @endif

										@for ($i = 1; $i <= $items->allPage; $i++)
                                            @if($items->allPage <= 15)
                                            <li @if($items->currentPage == $i) class="active" @endif><a href="/dashboard/newsletter/subscribers?page={{$i}}">{{ $i }}</a></li>
											@else
                                                @if($items->currentPage <= 5)
                                                    @if($i < 9 || $i > ($items->allPage-2))
                                                    <li @if($items->currentPage == $i) class="active" @endif><a href="/dashboard/newsletter/subscribers?page={{$i}}">{{ $i }}</a></li>
                                                    @elseif(($items->allPage-2) == $i)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @elseif($items->currentPage > $items->allPage-5)
                                                    @if($i < 3 || $i > ($items->allPage-8))
                                                    <li @if($items->currentPage == $i) class="active" @endif><a href="/dashboard/newsletter/subscribers?page={{$i}}">{{ $i }}</a></li>
                                                    @elseif($i == 3)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @else
                                                    @if(
                                                        $i < 3 ||
                                                        $i > $items->allPage-2 ||
                                                        ($i > $items->currentPage-3 && $i < $items->currentPage+3)
                                                    )
                                                    <li @if($items->currentPage == $i) class="active" @endif><a href="/dashboard/newsletter/subscribers?page={{$i}}">{{ $i }}</a></li>
                                                    @elseif($i == 3 || $items->allPage-2 == $i)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @endif
                                            @endif
                                        @endfor

										@if($items->currentPage != $items->allPage && $items->count != 0)
                                        <li class="next"><a href="/dashboard/newsletter/subscribers?page={{$items->allPage}}">{{trans('_.Last page')}} →</a></li>
                                        @else
                                        <li class="next disabled"><a href="javascript:;">{{trans('_.Last page')}} →</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </footer>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script src="/static/bower_components/moment/moment.js"></script>
<script src="/static/bower_components/angular-moment/angular-moment.min.js"></script>
<script>
(function(){
	app.requires.push('angularMoment');

    app.controller('content', function($scope, $http, $window){
		$scope.items = {!! json_encode($members) !!};
		$scope.order = {{($items->currentPage*$items->perPage)-$items->perPage}};
    });

    app.controller('item', function($scope, $http, $timeout, $window){
        $scope.complete = false;
        $scope.deletingitem = false;

        $scope.delete = function($index){
            if (confirm('{{trans('_.Are you sure?')}}'))
			{
                $scope.deleting = true;

                $http.post('/ajax/dashboard/newsletter/subscriber/delete', {
                    email: $scope.item.email_address
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.deleted = true;
						$scope.items.splice($index, 1);
                    }
                    else{
                        $timeout(function(){
                            alert(resp.message);
                        }, 100);
                    }
                })
                .error(function(){
                    $timeout(function(){
                        alert('{{trans('error.general')}}');
                        $window.location.reload();
                    }, 100);
                })
				.finally(function(){
					$scope.deleting = false;
				});
            }
        };
    });

    @if(session()->has('sMessage'))
    noty({
        text: '{!!session('sMessage')!!}',
        layout: 'topRight',
        type: 'success',
        dismissQueue: true,
        template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
        animation: {
            open: {height: 'toggle'},
            close: {height: 'toggle'},
            easing: 'swing',
            speed: 300
        },
        timeout: 4500
    });
    @endif
})();
</script>
@endsection
