@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
<style>
.ui-item {
    margin-bottom: 10px;
    position: relative;
}
.ui-caption {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 14px;
    padding-top: 8px;
    color: #333;
}
.ui-label {
    position: absolute;
}
.ui-action {
    position: absolute;
    z-index: 100;
    right: 15px;
}
</style>
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
							<div class="col-md-12">
                                <a href="/dashboard/docs/pearlfarm" class="btn btn-danger btn-sm" style="margin-right: 10px;">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
                                {{trans('video.Video Management')}}
                                <a href="/dashboard/docs/pearlfarm/videos/add" class="btn btn-danger btn-sm pull-right">
                                    {{trans('video.Add New Video')}}
                                </a>
                            </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">
                        <div class="row">
                            @foreach($items as $item)
                            <div class="col-sm-4 ui-item" ng-controller="ItemController" ng-mouseenter="visible=true" ng-mouseleave="visible=false">
                                <div class="ui-action" ng-show="visible">
                                    <a href="/dashboard/docs/pearlfarm/videos/{{$item->videoid}}" class="btn btn-xs btn-primary">{{trans('_.Edit')}}</a>
                                    <button type="button" class="btn btn-xs btn-danger" ng-click="delete({{$item->id}}, '{{$item->videoid}}')" ng-disabled="deleting">{{trans('_.Delete')}}</button>
                                </div>
                                <a href="{!! $item->youtube !!}" class="fancybox">
                                    @if($item->publish == '0')
                                    <span class="label label-danger ui-label">{{trans('_.Not publish')}}</span>
                                    @endif

                                    @if(
                                        $item->thumb_default == '1' ||
                                        $item->thumb_medium == '1' ||
                                        $item->thumb_high == '1' ||
                                        $item->thumb_standard == '1' ||
                                        $item->thumb_maxres == '1'
                                    )
                                    <img src="/app/pearlfarm_videos/{{$item->videoid}}/preview.png" class="img-responsive">
                                    @else
                                    <img src="/static/dashboard/assets/img/photo-placeholder.png" class="img-responsive">
                                    @endif

                                    <p class="ui-caption">{{$item->getTitle($config['lang']['code'])}}</p>
                                </a>
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
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="/static/bower_components/fancybox/source/helpers/jquery.fancybox-media.js"></script>
<script>
(function(){
    $(function(){
        $('.fancybox').fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            closeBtn: false,
            helpers : {
                media : {}
            }
        });
    });

    app.controller('ItemController', function($scope, $http, $window){
        $scope.visible  = false;
        $scope.deleting = false;

        $scope.delete = function(id, videoid){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/docs/pearlfarm/videos/'+videoid+'/delete', {
                    id: id
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
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
        timeout: 6500
	});
    @endif
})();
</script>
@endsection
