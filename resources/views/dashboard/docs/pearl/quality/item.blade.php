@extends('dashboard.layout')

@section('head')
<style>
.item {
	margin-bottom: 30px;
}
.image-item {
	width: 100%;
	max-width: 100%;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="item">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-10">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<a href="/dashboard/docs/pearlquality" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{$item->getTitle($config['lang']['code'])}}</span>
								<button type="button" class="btn btn-danger btn-sm pull-right" style="margin-left: 5px;" ng-disabled="doing || done" ng-click="delete()">
		                            [[doing? '{{trans('_.Deleting...')}}': '{{trans('_.Delete')}}']]
		                        </button>
								<a href="/dashboard/docs/pearlquality/{{$item->itemid}}/edit" class="btn btn-danger btn-sm pull-right" ng-disabled="doing || done">
		                            {{trans('_.Edit')}}
		                        </a>
							</div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height: calc(100vh - 150px);">
                        @if(session()->has('eMessage'))
                        <div class="alert alert-danger fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('eMessage')}}
						</div>
                        @endif
						@if(session()->has('sMessage'))
                        <div class="alert alert-success fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('sMessage')}}
						</div>
                        @endif
						<?php
							$details = $item->getDetails($config['lang']['code']);
						?>
						<div class="row @if(trim($details) != '') item @endif">
							<div class="col-sm-12">
								{!! nl2br($details) !!}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<img src="/app/pearlquality/{{$item->imageid}}.png" class="image-item">
							</div>
						</div>
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
app.controller('item', function($scope, $http, $window){
	$scope.delete = function(){
		if (confirm('{{trans('_.Are you sure?')}}'))
		{
			$scope.doing = true;

			$http.post('/ajax/dashboard/docs/pearlquality/{{$item->itemid}}/delete')
			.success(function(data){
				if (data.status == 'ok'){
					$scope.done = true;
					$window.location.href = '/dashboard/docs/pearlquality';
				}
				else {
					alert(data.message);
				}
			})
			.error(function(){
				alert('{{trans('error.general')}}');
				$window.location.reload();
			})
			.finally(function(){
				$scope.doing = false;
			});
		}
	}
});
</script>
@endsection
