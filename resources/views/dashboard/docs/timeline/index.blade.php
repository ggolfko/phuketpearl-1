@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/dashboard/assets/css/table-responsive.css" />
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-6" style="padding-left:20px;">{{trans('_.Timeline')}}</div>
							<div class="col-md-6">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/our-story.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
                                    <a href="/dashboard/docs/timeline/add" class="btn btn-danger btn-sm">
                                        {{trans('timeline.Add Timeline')}}
                                    </a>
								</form>
							</div>
						</div>
                    </header>
                    <table class="table table-striped table-advance table-hover table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th style="width:140px;">{{trans('_.Year')}}</th>
                                <th>{{trans('_.Detail')}}</th>
                                <th style="width:175px;"></th>
                            </tr>
                        </thead>
                        <tbody>
							@if($items->count() > 0)
								@foreach($items as $index => $item)
									<tr ng-controller="ItemController" ng-init="timelineid='{{$item->timelineid}}';id={{$item->id}}">
										<td data-title="{{trans('_.Year')}}">{{date("Y", strtotime($item->time))}}</td>
                                        <td data-title="{{trans('_.Detail')}}">
                                            {{ str_limit($item->getDetail($config['lang']['code']), $limit = 100, $end = '...') }}
                                        </td>
                                        <td class="text-right">
                                            <a href="/dashboard/docs/timeline/{{$item->timelineid}}" class="btn btn-default btn-xs">{{trans('timeline.View')}}</a>
                                            <a href="/dashboard/docs/timeline/{{$item->timelineid}}/edit" class="btn btn-primary btn-xs">{{trans('_.Edit')}}</a>
											<button class="btn btn-danger btn-xs" ng-click="delete()" ng-disabled="deleting">{{trans('_.Delete')}}</button>
											<img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="deleting && !complete">
										</td>
									</tr>
								@endforeach
							 @else
							 <tr>
							 	<td colspan="3" style="text-align:center;">{{trans('_.No record found.')}}</td>
							 </tr>
							 @endif
                        </tbody>
                    </table>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
(function(){
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

    app.controller('ItemController', function($scope, $http, $timeout, $window){
        $scope.complete     = false;
        $scope.deleting     = false;

        $scope.delete = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/docs/timeline/'+$scope.timelineid+'/delete', {
                    id: $scope.id
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.complete = true;
                        $timeout(function(){
                            $window.location.reload();
                        }, 100);
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
                    }, 100);
                })
				.finally(function(){
					$scope.deleting = false;
				});
            }
        };
    });
})();
</script>
@endsection
