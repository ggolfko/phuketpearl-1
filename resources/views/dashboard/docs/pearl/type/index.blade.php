@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/dashboard/assets/css/table-responsive.css">
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Index">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-3" style="padding-left:20px;">{{trans('pearl.Type Of Pearl')}}</div>
							<div class="col-md-9">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/pearl-type.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
                                    <a href="/dashboard/docs/pearltype/add" class="btn btn-danger btn-sm">
										{{trans('pearl.Add New')}}
									</a>
								</form>
							</div>
						</div>
                    </header>
                    <table class="table table-striped table-advance table-hover table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th style="width:230px;">{{trans('_.Title')}}</th>
                                <th>{{trans('_.Detail')}}</th>
								<th class="text-center">{{trans('pearl.Main type')}}</th>
                                <th style="width:170px;"></th>
                            </tr>
                        </thead>
                        <tbody>
							@if($items->count() > 0)
								@foreach($items as $index => $item)
									<tr ng-controller="Item" ng-init="id={{$item->id}};typeid='{{$item->typeid}}'">
										<td data-title="{{trans('_.Title')}}">{{$item->getTitle($config['lang']['code'])}}</td>
                                        <td data-title="{{trans('_.Detail')}}">
                                            {{str_limit($item->getDetail($config['lang']['code']), $limit = 70, $end = '...')}}
                                        </td>
										<td data-title="{{trans('pearl.Main type')}}" class="text-center">
											@if($item->main == '1')
											<span class="label label-danger">{{trans('_.Yes')}}</span>
											@else
											<span class="label label-default">{{trans('_.No')}}</span>
											@endif
                                        </td>
                                        <td class="text-right" style="min-width: 250px;">
                                            <a href="/dashboard/docs/pearltype/{{$item->typeid}}" class="btn btn-default btn-xs">{{trans('tour.View')}}</a>
											<a href="/dashboard/docs/pearltype/{{$item->typeid}}/images" class="btn btn-default btn-xs">{{trans('_.Images')}}</a>
                                            <a href="/dashboard/docs/pearltype/{{$item->typeid}}/edit" class="btn btn-primary btn-xs">{{trans('_.Edit')}}</a>
                                            <button class="btn btn-danger btn-xs" ng-click="delete()" ng-hide="deleting || deleted">{{trans('_.Delete')}}</button>
                                            <img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="deleting && !deleted">
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
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
(function(){
    app.controller('Index', function($scope){
    });

    app.controller('Item', function($scope, $timeout, $http, $window){
        $scope.deleted  = false;
        $scope.deleting = false;

        $scope.delete = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/docs/pearltype/'+$scope.typeid+'/delete')
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
})();
</script>
@endsection
