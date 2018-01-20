@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/dashboard/assets/css/table-responsive.css">
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="index">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
                        <div class="row">
							<div class="col-md-2">
                                {{trans('_.Newsletter')}}
                            </div>
							<div class="col-md-10">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="{{$request->fullUrl()}}">
									<div class="form-group">
										<div class="input-group pull-right" style="width:300px;">
											<input
												type="text"
												name="q"
												placeholder="{{trans('_.Search')}}..."
												class="form-control input-sm"
												value="{{$q}}">
											<span class="input-group-btn">
												<button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
											</span>
										</div>
									</div>
                                    <a href="/dashboard/newsletter/compose" class="btn btn-danger btn-sm"><i class="fa fa-pencil"></i> {{trans('subscribe.Compose')}}</a>
                                    <a href="/dashboard/newsletter/subscribers" class="btn btn-danger btn-sm"><i class="fa fa-users"></i> {{trans('subscribe.Subscribers')}} ([[subscribers | number]])</a>
								</form>
							</div>
						</div>
                    </header>
                    <table class="table table-striped table-advance table-hover table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th>{{trans('subscribe.Subject')}}</th>
								<th>{{trans('_.Status')}}</th>
								<th class="text-center">{{trans('subscribe.Recipients')}}</th>
                                <th>{{trans('subscribe.Sent time')}}</th>
								<th>{{trans('subscribe.Compose time')}}</th>
                                <th style="width:114px;"></th>
                            </tr>
                        </thead>
                        <tbody>
							@if($items->count() > 0)
								<tr ng-controller="item" ng-repeat="item in items">
									<td data-title="{{trans('subscribe.Subject')}}">[[item.subject]]</td>
									<td data-title="{{trans('_.Status')}}">
										<span class="label label-danger" ng-if="item.status != 'sending' && item.status != 'sent'">{{trans('subscribe.Problem occurred')}}</span>
										<span class="label label-warning" ng-if="item.status == 'sending'">{{trans('subscribe.Sending')}}</span>
										<span class="label label-success" ng-if="item.status == 'sent'">{{trans('subscribe.Sent')}}</span>
									</td>
									<td data-title="{{trans('subscribe.Recipients')}}" class="text-center">
										<span ng-if="item.status != 'sent'">-</span>
										<span ng-if="item.status == 'sent'">[[item.emails_sent | number]]</span>
									</td>
									<td data-title="{{trans('subscribe.Sent time')}}">
										<span ng-if="item.status != 'sent'" style="padding-left: 5px;">-</span>
										<span ng-if="item.status == 'sent'">[[item.deliver_time | amDateFormat:'DD MMMM YYYY HH:mm:ss']]</span>
									</td>
									<td data-title="{{trans('subscribe.Compose time')}}">
										[[item.created_at | amDateFormat:'DD MMMM YYYY HH:mm:ss']]
									</td>
									<td class="text-right">
										<a href="/dashboard/newsletter/[[item.letterid]]" class="btn btn-default btn-xs" ng-hide="deleting || deleted">{{trans('subscribe.View')}}</a>
										<button class="btn btn-danger btn-xs" ng-click="delete()" ng-disabled="deleting || deleted">{{trans('_.Delete')}}</button>
										<img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="deleting && !deleted">
									</td>
								</tr>
							 @else
							 <tr>
							 	<td colspan="6" style="text-align:center;">{{trans('_.No record found.')}}</td>
							 </tr>
							 @endif
                        </tbody>
                    </table>
                    <footer class="ui_pagination">
                        <div class="row">
                            <div class="col-lg-4" style="padding-left:20px;">
                                <div class="show_entry">
                                    <span>
										{{trans_choice('_.TABLE_SHOWING', $items->total(), array(
											'showing' => ($items->count() == 0? 0 :($items->currentPage()*$items->perPage())-($items->perPage()-1)),
											'to' => ($items->perPage()*($items->currentPage()-1))+$items->count(),
											'of' => $items->total()
										))}}
									 </span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="dataTables_paginate paging_bootstrap pagination page_list">
                                    <ul>
								        @if($items->currentPage() != 1)
                                        <li class="prev"><a href="{{ $items->url(1) }}">← {{trans('_.First page')}}</a></li>
                                        @else
                                        <li class="prev disabled"><a href="javascript:;">← {{trans('_.First page')}}</a></li>
                                        @endif

                                        @for ($i = 1; $i <= $items->lastPage(); $i++)
                                            @if($items->lastPage() <= 15)
                                            <li @if($items->currentPage() == $i) class="active" @endif><a href="{{ $items->url($i) }}">{{ $i }}</a></li>
                                            @else
                                                @if($items->currentPage() <= 5)
                                                    @if($i < 9 || $i > ($items->lastPage()-2))
                                                    <li @if($items->currentPage() == $i) class="active" @endif><a href="{{ $items->url($i) }}">{{ $i }}</a></li>
                                                    @elseif(($items->lastPage()-2) == $i)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @elseif($items->currentPage() > $items->lastPage()-5)
                                                    @if($i < 3 || $i > ($items->lastPage()-8))
                                                    <li @if($items->currentPage() == $i) class="active" @endif><a href="{{ $items->url($i) }}">{{ $i }}</a></li>
                                                    @elseif($i == 3)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @else
                                                    @if(
                                                        $i < 3 ||
                                                        $i > $items->lastPage()-2 ||
                                                        ($i > $items->currentPage()-3 && $i < $items->currentPage()+3)
                                                    )
                                                    <li @if($items->currentPage() == $i) class="active" @endif><a href="{{ $items->url($i) }}">{{ $i }}</a></li>
                                                    @elseif($i == 3 || $items->lastPage()-2 == $i)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @endif
                                            @endif
                                        @endfor

                                        @if($items->currentPage() != $items->lastPage() && $items->count() != 0)
                                        <li class="next"><a href="{{ $items->url($items->lastPage()) }}">{{trans('_.Last page')}} →</a></li>
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

	app.controller('index', function($scope, $http){
		$scope.items = {!! json_encode($items->items()) !!};

		$scope.subscribers = 0;

		$http.get('/ajax/dashboard/newsletter/subscribers')
		.success(function(data){
			if (data.status == 'ok'){
				$scope.subscribers = data.payload.members;
			}
		});
	});

    app.controller('item', function($scope, $http, $timeout, $window){

		if ($scope.item.status == 'sending')
		{
			$http.get('/ajax/dashboard/newsletter/' + $scope.item.letterid + '/status')
			.success(function(data){
				if (data.status == 'ok'){
					$scope.item.deliver_time	= data.payload.deliver_time;
					$scope.item.emails_sent		= data.payload.emails_sent;
					$scope.item.status			= data.payload.status;
				}
			});
		}

		$scope.delete = function(){
			if (confirm('{{trans('_.Are you sure?')}}')){
				$scope.deleting = true;

				$http.post('/ajax/dashboard/newsletter/' + $scope.item.letterid + '/delete', {
					id: $scope.item.id
				})
				.success(function(resp){
					if (resp.status == 'ok'){
						$scope.deleted = true;
						$window.location.reload();
					}
					else {
						alert(resp.message);
					}
				})
				.error(function(){
					alert('{{trans('error.general')}}');
					$window.location.reload();
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
