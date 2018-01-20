@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen">
<link rel="stylesheet" href="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/froala_style.css">
<style>
.ui-item {
    margin-bottom: 20px;
}
.ui-options {
    position: absolute;
	top: 8px;
	right: 25px;
}
.ui-description {
	position: relative;
	padding: 10px 1px 0px 1px;
	height: 75px;
	overflow: hidden;
	text-overflow: ellipsis;
	border-radius: 0px 0px 4px 4px;
	-webkit-border-radius: 0px 0px 4px 4px;
	-moz-border-radius: 0px 0px 4px 4px;
}
.ui-description span {
}
.ui-description .bottom-placeholder {
	width: 100%;
	height: 10px;
	background-color: #fff;
	position: absolute;
	bottom: 0px;
	left: 0px;
}
.image-responsive {
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
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-12">
								<a href="/dashboard/docs/pearlfarming/{{$farming->farmingid}}" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
                                <a href="/dashboard/docs/pearlfarming/{{$farming->farmingid}}/slides/add" class="btn btn-danger btn-sm pull-right">
									{{trans('pearl.Add Slide')}}
								</a>
		                    </div>
						</div>
                    </header>
					<div class="panel-body" style="min-height:calc(100vh - 165px);">
                        <div class="row">
                            @foreach($farming->slides as $slide)
                            <div class="col-sm-4 ui-item" ng-controller="slide" ng-mouseenter="visible=true" ng-mouseleave="visible=false">
                                <a href="/app/pearlfarming/{{$farming->farmingid}}/{{$slide->imageid}}.png" class="fancybox" rel="gallery">
                                    <img src="/app/pearlfarming/{{$farming->farmingid}}/{{$slide->imageid}}_t.png" class="img-responsive image-responsive">
                                </a>
								<div class="ui-description">
									<span>{!! nl2br($slide->getDescription($config['lang']['code'])) !!}</span>
									<div class="bottom-placeholder"></div>
								</div>
                                <div class="ui-options" ng-show="visible">
                                    <a href="/dashboard/docs/pearlfarming/{{$farming->farmingid}}/slides/{{$slide->slideid}}" class="btn btn-xs btn-primary" ng-disabled="deleting || deleted">
										{{trans('_.Edit')}}
									</a>
									<button type="button" class="btn btn-xs btn-danger" ng-click="delete('{{$slide->slideid}}')" ng-disabled="deleting || deleted">
										[[deleting? '{{trans('_.Deleting...')}}': '{{trans('_.Delete')}}']]
									</button>
                                </div>
                            </div>
                            @endforeach
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
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.js"></script>
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
app.controller('slide', function($scope, $http, $window){
	$scope.visible  = false;
	$scope.deleting	= false;
	$scope.deleted	= false;

	$scope.delete = function(slideid){
		if (confirm('{{trans('_.Are you sure?')}}'))
		{
			$scope.deleting = true;

			$http.post('/ajax/dashboard/docs/pearlfarming/{{$farming->farmingid}}/slides/' + slideid + '/delete')
			.success(function(data){
				$scope.deleting = false;

				if (data.status == 'ok'){
					$scope.deleted = true;
					$window.location.reload();
				}
				else {
					alert(data.message);
				}
			})
			.error(function(){
				$scope.deleting = false;
				alert('{{trans('error.general')}}');
				$window.location.reload();
			});
		}
	}
});

app.controller('item', function($scope, $http, $window){
	$(function(){
		$('.fancybox').fancybox({
            closeBtn: false,
            padding: 5,
            helpers:  {
                thumbs : {
                    width: 50,
                    height: 50
                }
            }
        });
	});
});

$(function(){
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
});
</script>
@endsection
