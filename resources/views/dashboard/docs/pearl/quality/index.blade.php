@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/dashboard/assets/css/table-responsive.css">
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Index">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-8">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-3" style="padding-left:20px;">{{trans('_.Pearl Quality')}}</div>
							<div class="col-md-9">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/pearl-quality.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
                                    <a href="/dashboard/docs/pearlquality/add" class="btn btn-danger btn-sm">
										{{trans('pearl.Add New')}}
									</a>
								</form>
							</div>
						</div>
                    </header>
                    <table class="table table-striped table-advance table-hover table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th>{{trans('_.Title')}}</th>
                                <th style="width:170px;"></th>
                            </tr>
                        </thead>
                        <tbody>
							@if($items->count() > 0)
								@foreach($items as $index => $item)
									<tr ng-controller="item">
										<td data-title="{{trans('_.Title')}}">
											<?php
												$title = $item->getTitle($config['lang']['code']);
											?>
											@if(trim($title) == '')
												-
											@else
												{{$title}}
											@endif
										</td>
                                        <td class="text-right">
                                            <a href="/dashboard/docs/pearlquality/{{$item->itemid}}" class="btn btn-default btn-xs">{{trans('tour.View')}}</a>
                                            <a href="/dashboard/docs/pearlquality/{{$item->itemid}}/edit" class="btn btn-primary btn-xs">{{trans('_.Edit')}}</a>
                                            <button class="btn btn-danger btn-xs" ng-click="delete('{{$item->itemid}}')" ng-hide="deleting || deleted">{{trans('_.Delete')}}</button>
                                            <img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="deleting && !deleted">
										</td>
									</tr>
								@endforeach
							 @else
							 <tr>
							 	<td colspan="2" style="text-align:center;">{{trans('_.No record found.')}}</td>
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
    app.controller('Index', function($scope){
    });

    app.controller('item', function($scope, $timeout, $http, $window){
        $scope.deleted  = false;
        $scope.deleting = false;

        $scope.delete = function(_id){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/docs/pearlquality/'+_id+'/delete', {
                    id: $scope.id
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.deleted = true;
                        $window.location.reload();
                    }
                    else{
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
