@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/froala-wysiwyg-editor/css/froala_style.css" rel="stylesheet">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/pearl.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-pearl" ng-controller="Quality" ng-class="{'xs':screen == 'xs'}">
    <div class="container quality">
        <div class="row">
            <!-- wrapper -->
            <div class="col-md-12 wrapper">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="head">
                            <div class="line"></div>
                            <div class="title">
                                <span>{{trans('_.Pearl Quality')}}</span>
                            </div>
                        </div>
                    </div>
                </div>

				@foreach($items as $item)
				<?php $title_ = $item->getTitle($config['lang']['code']) ?>
				<div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="item" ng-controller="DeferImage" image="/app/pearlquality/{{$item->imageid}}.png" alt="{{$title_}}">
                            <div class="defer-image" ng-class="{'hidden':loaded}">
                                <div class="image-showing">
                                    <img src="/static/images/preload-512-288.jpg" class="holder" alt="{{$title_}}">
                                </div>
                                <div class="is-loading"></div>
                            </div>
                            <a href="#" ng-click="show($event, '{{$item->imageid}}')" ng-class="{'hidden':!loaded}"></a>
                        </div>
                    </div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="item-head">
							{{$title_}}
						</div>
						<div class="item-details">
							<span class="{{$config['lang']['code']}}">{!! nl2br($item->getDetails($config['lang']['code'])) !!}</span>
						</div>
					</div>
                </div>
				@endforeach
            </div>
            <!-- wrapper -->
        </div>
    </div>
</div>

<div class="hidden" id="light-gallery">
    @foreach($items as $item)
    <a href="/app/pearlquality/{{$item->imageid}}.png" data-imageid="{{$item->imageid}}"></a>
    @endforeach
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script>
(function(){
    app.controller('Quality', function($scope, $log){
        $scope.show = function($event, imageid){
            var item = $('a[data-imageid='+imageid+']', '#light-gallery');
            if (item){
                item.trigger('click');
            }
            $event.preventDefault();
        };

        $(function(){
            $('#light-gallery').lightGallery({
                download: false,
                counter: false,
                fullScreen: false,
                actualSize: false,
                thumbnail: false
            });
        });
    });
    app.controller('DeferImage', function($scope, $log, $attrs, $element){
        $scope.loaded = false;
        $scope.image = $('<img />', {
            src: $attrs.image,
			alt: $attrs.alt
        });
        $scope.image.bind('load', function(){
            $('a', $element).html($scope.image);
            $scope.loaded = true;
            $scope.$apply();
        });
    });
})();
</script>
@endsection
