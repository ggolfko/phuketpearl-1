@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/lightslider/dist/css/lightslider.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/froala-wysiwyg-editor/css/froala_style.css" rel="stylesheet">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/plugins/ztabs/css/zozo.tabs.min.css?_t=1705251656" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/pearl.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-pearl" ng-class="{'xs':screen == 'xs'}" ng-controller="page">
    <div class="container farming">

        <div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('_.Pearl farming')}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- wrapper -->
            <div class="col-md-12 wrapper">
                <div class="row tabs">
                    <div class="col-xs-12">

                        <div id="tabbed">
                            <ul>
                                @foreach($items as $item)
                                <li>
                                    <a class="ui-anchor @if($config['lang']['code'] == 'th') th @endif">
                                        <span>{{$item['title']}}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <div>
                                @foreach($items as $item)
                                <div class="ui-content fr-view">
                                    <div class="row">
                                        <div class="col-md-12">
											@if($item['object']->slides->count() > 0)
											<?php $firstSlide = $item['object']->slides->get(0); ?>
											<div class="slide-item" style="min-height: {{intval($firstSlide->height)+72}}px">
												<ul id="slide-item-{{$item['farmingid']}}">
						                            @foreach($item['object']->slides as $slide)
						                            <li style="width: {{$slide->width}}px">
														<img src="/app/pearlfarming/{{$item['farmingid']}}/{{$slide->imageid}}_s.png" alt="{{$item['title']}}">
														<div class="caption">
															{{$slide->getDescription($config['lang']['code'])}}
														</div>
													</li>
						                            @endforeach
						                        </ul>
											</div>
											@endif
                                            <div class="detail">
                                                {!! nl2br($item['content']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- wrapper -->
        </div>

		<!-- start: random tours -->
        <div class="row ui-tour-random">
            <div class="title-head">{{trans('_.Booking Tour')}}</div>
            @foreach($tours as $index => $tour)
			<?php $title_ = $tour->getTitle($config['lang']['code']) ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow zoomIn">
                <div class="item @if($index == 3) visible-sm visible-xs @endif">
                    @if($tour->new == '1')
                    <div class="ribbon new"><span>NEW</span></div>
                    @elseif($tour->popular == '1')
                    <div class="ribbon popular"><span>POPULAR</span></div>
                    @elseif($tour->recommend == '1')
                    <div class="ribbon recommended"><span>RECOMMEND</span></div>
                    @endif
                    <div class="images">
                        <a href="/tours/{{$tour->url}}.html" alt="{{$title_}}">
                            <?php
                                $source = '/static/images/image-placeholder-622-415.png';

                                if ($tour->images->count() > 0){
                                    $image  = $tour->images->get(0);
                                    $source = "/app/tour/{$tour->tourid}/{$image->imageid}_t.png";
                                }
                            ?>
                            <div class="defer-image" ng-controller="DeferImage" image="{{$source}}" alt="{{$title_}}">
                                <div class="image-showing">
                                    <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$title_}}">
                                </div>
                                <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                            </div>
                            <div class="description">
                                <div class="price">
                                    @if($tour->price_type == 'package')
                                    <span class="amount">{{number_format($tour->price_package)}} THB</span>
                                    <span class="type">{{trans('tour.price/bundle ticket')}}</span>
                                    @elseif($tour->price_type == 'person')
                                    <span class="amount">{{number_format($tour->price_person_adult)}} THB</span>
                                    <span class="type">{{trans('tour.price/single ticket')}}</span>
									@elseif($tour->price_type == 'free')
                                    <span class="free">{{trans('tour.Free shuttle')}}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div class="previews">
                            <a href="#" ng-click="showTourPreview($event, '{{$tour->tourid}}')" alt="{{$title_}}"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
                            @if($tour->images->count() > 0)
                            <div class="tour-preview hidden" data-plugin="light-gallery" data-preview-tourid="{{$tour->tourid}}">
                                @foreach($tour->images as $image)
                                <a href="/app/tour/{{$tour->tourid}}/{{$image->imageid}}.png" data-sub-html="{!! $title_ !!}" alt="{{$title_}}">
                                    <img src="/app/tour/{{$tour->tourid}}/{{$image->imageid}}_t.png" class="img-responsive" alt="{{$title_}}">
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="info">
                        <div class="title">{!! str_limit($title_, $limit = 80, $end = '...') !!}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- end: random tours -->

    </div>
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/lightslider/dist/js/lightslider.min.js"></script>
<script src="{{ $config['url'] }}/static/plugins/ztabs/js/zozo.tabs.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-fullscreen.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script>
(function(){
	app.controller('page', function($scope){
		$scope.sliders = [];

		$scope.showTourPreview = function($event, tourid){
	        $('.tour-preview[data-preview-tourid='+tourid+']').first().find('a').first().click();
	        $event.preventDefault();
	    };

		$(function(){
			$('[data-plugin=light-gallery]').lightGallery({
 	            download: false,
 	            counter: false,
 	            fullScreen: false,
 	            actualSize: false
 	        });

			@foreach($items as $item)
				@if($item['object']->slides->count() > 0)
				var slider_{{$item['farmingid']}} = $('#slide-item-{{$item['farmingid']}}').lightSlider({
				    gallery: false,
				    item: 3,
				    loop: false,
				    auto: false,
				    speed: 800,
				    pager: false,
					autoWidth: true,
					slideMargin: 10,
					responsive : [
						{
							breakpoint: 800,
							settings: {
								item: 2,
								slideMove: 1,
								slideMargin: 6,
							}
						},
						{
							breakpoint: 480,
							settings: {
								item: 1,
								slideMove: 1
							}
						}
					]
				});
				$scope.sliders.push(slider_{{$item['farmingid']}});
				@endif
			@endforeach

	        $('#tabbed').zozoTabs({
	            position: 'top-left',
	            multiline: false,
	            theme: 'black2',
	            rounded: false,
	            bordered: true,
	            shadows: true,
	            orientation: 'horizontal',
	            style: 'pills',
	            size: 'medium',
	            animation: {
	                easing: 'easeInOutExpo',
	                duration: 400,
	                effects: 'slideH'
	            },
				select: function(event, item){
					angular.forEach($scope.sliders, function(slider){
						slider.refresh();
					});
				}
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
            $('.image-showing', $element).html($scope.image);
            $scope.loaded = true;
            $scope.$apply();
        });
    });
})();
</script>
@endsection
