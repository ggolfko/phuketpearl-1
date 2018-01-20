@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen">
<link rel="stylesheet" href="/static/dashboard/assets/css/table-responsive.css" />
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-8">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-6">
                                <a href="/dashboard/products" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('category.Category Management')}}</span>
                            </div>
							<div class="col-md-6">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/dashboard/products/category/create" class="btn btn-danger btn-sm">
                                        {{trans('category.Create New Category')}}
                                    </a>
								</form>
							</div>
						</div>
                    </header>
                    <table class="table table-striped table-advance table-hover table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th>{{trans('_.Title')}}</th>
                                <th>{{trans('_.URL')}}</th>
								<th>{{trans('_.Image')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
							@if($items->count() > 0)
								@foreach($items as $index => $item)
									<tr ng-controller="ItemController" ng-init="categoryid='{{$item->categoryid}}';id={{$item->id}}">
										<td data-title="{{trans('_.Title')}}">{{$item->getTitle($config['lang']['code'])}}</td>
                                        <td data-title="{{trans('_.URL')}}">{{$item->url}}</td>
									    <td data-title="{{trans('_.Image')}}">
											@if($item->imageid != '' && strlen($item->imageid) == 16)
												<a href="/app/category/{{$item->categoryid}}/{{$item->imageid}}.png" class="btn btn-default btn-xs fancybox">{{trans('_.View Image')}}</a>
											@else
												{{trans('category.Not set')}}
											@endif
										</td>
                                        <td class="text-right">
                                            <a href="/dashboard/products/category/{{$item->categoryid}}" class="btn btn-primary btn-xs">{{trans('_.Edit')}}</a>
											<a href="/dashboard/products/category/{{$item->categoryid}}/image" class="btn btn-default btn-xs">{{trans('_.Image')}}</a>
											<button class="btn btn-danger btn-xs" ng-click="delete()" ng-disabled="deleting">{{trans('_.Delete')}}</button>
											<img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="deleting && !complete">
										</td>
									</tr>
								@endforeach
							 @else
							 <tr>
							 	<td colspan="4" style="text-align:center;">{{trans('_.No record found.')}}</td>
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
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
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

	$(document).ready(function() {
        $('.fancybox').fancybox();
    });

    app.controller('ItemController', function($scope, $http, $timeout, $window){
        $scope.complete     = false;
        $scope.deleting     = false;

        $scope.delete = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/products/category/'+$scope.categoryid+'/delete', {
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
