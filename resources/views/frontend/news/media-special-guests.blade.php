@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/frontend/css/news.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-news" ng-class="{'xs':screen == 'xs'}">
    <div class="container media">
		<div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('_.Media & Special Guests')}}</span>
                    </div>
                </div>
            </div>
        </div>

		@foreach($medias as $index => $media)
		<?php
			$topic = $media->getTopic($config['lang']['code']);
		?>
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1">
				<div class="item @if($index == 0) __first @endif">
					<h2>{{$topic}}</h2>
					<div class="row">
						@foreach($media->images as $image)
						<div class="col-md-6 image">
							<div class="defer-image" ng-controller="DeferImage" image="/app/media_special_guests/{{$media->itemid}}/{{$image->imageid}}.png" alt="{{$topic}}">
	                            <div class="image-showing">
	                                <img src="/static/images/preload-512-288.jpg" class="image holder" alt="{{$topic}}">
	                            </div>
	                            <div class="is-loading" ng-class="{'hidden':loaded}"></div>
	                        </div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		@endforeach

    </div>
</div>
@endsection

@section('foot')
<script>
(function(){
    app.controller('DeferImage', function($scope, $log, $attrs, $element){
        $scope.loaded = false;
        $scope.image = $('<img />', {
            src: $attrs.image,
            alt: $attrs.alt,
            class: 'image'
        });
        $scope.image.bind('load', function(){
            $('.image-showing', $element).html($scope.image);
            $scope.loaded = true;
            $scope.$apply();
        });
    });
})();
</script>
@endsection
