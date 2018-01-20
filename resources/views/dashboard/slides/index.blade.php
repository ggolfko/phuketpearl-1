@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="index">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-3" style="padding-left:20px;">{{trans('slide.Home Slides')}}</div>
							<div class="col-md-9">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="{{$request->fullUrl()}}">
									<a href="/dashboard/slides/add" class="btn btn-danger btn-sm">
										{{trans('slide.Add New Slide')}}
									</a>
								</form>
							</div>
						</div>
                    </header>
                    <div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center" style="min-width: 80px; width: 80px;">{{trans('slide.Order')}}</th>
									<th>{{trans('slide.Image')}}</th>
									<th style="max-width: 350px;">{{trans('slide.URL link')}}</th>
									<th class="text-center" style="min-width: 80px; width: 80px;">{{trans('_.Publish')}}</th>
									<th class="text-center" style="min-width: 90px; width: 90px;">{{trans('slide.Sort')}}</th>
									<th style="min-width: 120px; width: 120px;"></th>
								</tr>
							</thead>
							<tbody>
								<?php $count = $items->count() ?>
								@if($count > 0)
									@foreach($items as $index => $item)
									<tr ng-controller="item">
										<td class="text-center" style="vertical-align: middle;">{{$index+1}}</td>
										<td style="vertical-align: middle;">
											<a href="/app/slide/{{$item->slideid}}/{{$item->imageid}}.png" class="fancybox">
												<img src="/app/slide/{{$item->slideid}}/{{$item->imageid}}_t.png" class="img-thumbnail" style="min-width: 230px; width: 230px; height: 153px;">
											</a>
										</td>
										<td style="vertical-align: middle; max-width: 350px; word-wrap: break-word; overflow-wrap: break-word;">
											@if($item->link_set == '1')
												@if($item->link_internal == '1')
												<a href="{{$config['url']}}{{$item->link}}" target="_blank">{{$config['url']}}{{$item->link}}</a>
												@else
												<a href="{{$item->link}}" target="_blank">{{$item->link}}</a>
												@endif
											@else
												<em>({{trans('slide.Not Set')}})</em>
											@endif
										</td>
										<td class="text-center" style="vertical-align: middle;">
											<input type="checkbox" data-id="{{$item->slideid}}" data-plugin="icheck-item" @if($item->publish == '1') checked @endif>
										</td>
										<td class="text-center" style="vertical-align: middle;">
											@if($index == 0 && $count - 1 == $index)
												-
											@else
											<div class="btn-group" role="group">
												<button @if($index == 0) style="visibility: hidden;" @endif ng-click="sort('{{$item->slideid}}', 'up')" ng-disabled="sorting" type="button" class="btn btn-xs btn-white">
													<i class="fa fa-angle-up" aria-hidden="true" style="font-size: 15px; padding-left: 3px; padding-right: 3px;"></i>
												</button>
												<button @if($count - 1 == $index) style="visibility: hidden;" @endif ng-click="sort('{{$item->slideid}}', 'down')" ng-disabled="sorting" type="button" class="btn btn-xs btn-white">
													<i class="fa fa-angle-down" aria-hidden="true" style="font-size: 15px; padding-left: 3px; padding-right: 3px;"></i>
												</button>
											</div>
											@endif
										</td>
										<td class="text-right" style="vertical-align: middle;">
											<a href="/dashboard/slides/{{$item->slideid}}" class="btn btn-default btn-xs" ng-hide="doing || done">{{trans('_.Edit')}}</a>
											<button class="btn btn-danger btn-xs" ng-click="delete('{{$item->slideid}}')" ng-disabled="doing || done">{{trans('_.Delete')}}</button>
											<img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="doing && !done">
										</td>
									</tr>
									@endforeach
								@else
								<tr>
									<td class="text-center" colspan="6">{{trans('_.No record found.')}}</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="/static/bower_components/fancybox/source/helpers/jquery.fancybox-media.js"></script>
<script>
app.controller('item', function($rootScope, $scope, $http, $window){
	$scope.sort = function(_id, type){
		$rootScope.sorting = true;
		$scope.doing = true;

		$http.post('/ajax/dashboard/slides/' + _id + '/sort', {
			type: type
		})
		.success(function(resp){
			if (resp.status == 'ok'){
				$scope.done = true;
				$window.location.reload();
			}
			else{
				$rootScope.sorting = false;
				$scope.doing = false;
				alert(resp.message);
			}
		})
		.error(function(){
			alert('{{trans('error.general')}}');
			$window.location.reload();
		});
	}

	$scope.delete = function(_id){
		if (confirm('{{trans('_.Are you sure?')}}')){
			$scope.doing = true;

			$http.post('/ajax/dashboard/slides/' + _id + '/delete')
			.success(function(resp){
				if (resp.status == 'ok'){
					$scope.done = true;
					$window.location.reload();
				}
				else{
					$scope.doing = false;
					alert(resp.message);
				}
			})
			.error(function(){
				alert('{{trans('error.general')}}');
				$window.location.reload();
			});
		}
	}
});

app.controller('index', function($rootScope, $scope, $http, $window){
	$rootScope.sorting = false;

	$scope.publish = function(_id, set){
		$http.post('/ajax/dashboard/slides/' + _id + '/publish', {
			set: set
		})
		.success(function(resp){
			if (resp.status != 'ok'){
				alert(resp.message);
				$window.location.reload();
			}
		})
		.error(function(){
			alert('{{trans('error.general')}}');
			$window.location.reload();
		});
	}

	$(function(){
		$('input[data-plugin="icheck-item"]').iCheck({
            checkboxClass: 'icheckbox_flat-red'
        })
        .on('ifChecked', function(event){
			$scope.publish($(this).attr('data-id'), 'yes');
        })
        .on('ifUnchecked', function(event){
			$scope.publish($(this).attr('data-id'), 'no');
        });

        $('.fancybox').fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            closeBtn: false,
            padding: 9,
            helpers : {
                media : {}
            }
        });
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
        timeout: 6500
	});
    @endif
});
</script>
@endsection
