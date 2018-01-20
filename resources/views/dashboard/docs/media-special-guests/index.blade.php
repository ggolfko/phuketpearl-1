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
							<div class="col-md-6" style="padding-left:20px;">{{trans('_.Media & Special Guests')}}</div>
							<div class="col-md-6">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/media-special-guests.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
                                    <a href="/dashboard/docs/media-special-guests/add" class="btn btn-danger btn-sm">
                                        {{trans('_.Add New')}}
                                    </a>
								</form>
							</div>
						</div>
                    </header>
                    <table class="table table-striped table-advance table-hover table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th>{{trans('_.Topic')}}</th>
								<th class="text-center">{{trans('_.Images')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
							@if($items->count() > 0)
								@foreach($items as $index => $item)
									<tr ng-controller="item">
										<td data-title="{{trans('_.Topic')}}">
											{{$item->getTopic($config['lang']['code'])}}
										</td>
										<td data-title="{{trans('_.Images')}}" class="text-center">
											{{number_format($item->images->count())}}
										</td>
                                        <td class="text-right">
                                            <a href="/dashboard/docs/media-special-guests/{{$item->itemid}}/images" class="btn btn-default btn-xs">{{trans('_.Images')}}</a>
                                            <a href="/dashboard/docs/media-special-guests/{{$item->itemid}}" class="btn btn-primary btn-xs">{{trans('_.Edit')}}</a>
											<button class="btn btn-danger btn-xs" ng-click="delete('{{$item->itemid}}')" ng-disabled="deleting">{{trans('_.Delete')}}</button>
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

    app.controller('item', function($scope, $http, $timeout, $window){
        $scope.complete     = false;
        $scope.deleting     = false;

        $scope.delete = function(itemid){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/docs/media-special-guests/'+itemid+'/delete')
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
