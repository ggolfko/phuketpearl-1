@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/plugins/ztabs/css/zozo.tabs.min.css?_t=1705251718" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/pearl.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-pearl" ng-class="{'xs':screen == 'xs'}" ng-controller="page">
    <div class="container type">

        <div class="row">
            <!-- wrapper -->
            <div class="col-md-12 wrapper">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="head">
                            <div class="line"></div>
                            <div class="title">
                                <span>{{trans('_.Type of pearl')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row tabs">
                    <div class="col-xs-12">

                        <div id="tabbed">
                            <ul>
                                @foreach($items as $item)
                                <li><a class="ui-anchor @if($config['lang']['code'] == 'th') th @endif @if($item['main']) is-main @endif">{{$item['title']}}</a></li>
                                @endforeach
                            </ul>
                            <div>
                                @foreach($items as $item)
                                <div class="ui-content">
                                    <div class="row">
										@if($item['object']->images->count() > 0)
                                        <div class="col-md-6">
                                            <div class="main-image" id="image-wrap-{{$item['typeid']}}">
												@foreach($item['object']->images as $index => $image)
                                                <div @if($index != 0) class="hidden" @endif data-imageid="{{$image->imageid}}">
													<div class="defer-image" ng-controller="DeferImage" image="/app/pearltype/{{$item['typeid']}}/{{$image->imageid}}.png" alt="{{$item['title']}}">
	                                                    <div class="image-showing">
	                                                        <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$item['title']}}">
	                                                    </div>
	                                                    <div class="is-loading" ng-class="{'hidden':loaded}"></div>
	                                                </div>
												</div>
												@endforeach
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                            <h4>{{$item['title']}}</h4>
                                            <div class="detail">
                                                {!! nl2br($item['detail']) !!}
                                            </div>
                                            @if($item['object']->images->count() > 1)
                                            <div class="images">
                                                <div class="row">
													@foreach($item['object']->images as $image)
                                                    <div class="col-sm-4">
                                                        <div class="image" ng-controller="DeferImageChild" image="/app/pearltype/{{$item['typeid']}}/{{$image->imageid}}_t.png" alt="{{$item['title']}}">
                                                            <div class="defer-image" ng-class="{'hidden':loaded}">
                                                                <div class="image-showing">
                                                                    <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$item['title']}}">
                                                                </div>
                                                                <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                                                            </div>
                                                            <a href="#" ng-click="show($event, '{{$item['typeid']}}', '{{$image->imageid}}')" ng-class="{'hidden':!loaded}"></a>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
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
                                <a href="/app/tour/{{$tour->tourid}}/{{$image->imageid}}.png" data-sub-html="{!! $title_ !!}">
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
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script src="{{ $config['url'] }}/static/plugins/ztabs/js/zozo.tabs.min.js"></script>
<script>
(function(){
	app.controller('page', function($scope){
		$scope.sliders = [];

		$scope.showTourPreview = function($event, tourid){
	        $('.tour-preview[data-preview-tourid='+tourid+']').first().find('a').first().click();
	        $event.preventDefault();
	    };
	});
    app.controller('DeferImage', function($scope, $log, $attrs, $element){
        $scope.loaded = false;
        $scope.image = $('<img />', {
            src: $attrs.image,
			alt: $attrs.alt
        });
        $scope.image.bind('load', function(){
            $($element).parent().prepend($scope.image);
            $scope.loaded = true;
            $($element).remove();
            $scope.$apply();
        });
    });
    app.controller('DeferImageChild', function($scope, $log, $attrs, $element){
        $scope.loaded = false;
        $scope.image = $('<img />', {
            src: $attrs.image,
			alt: $attrs.alt
        });
        $scope.image.bind('load', function(){
            $($element).find('a').html($scope.image);
            $scope.loaded = true;
            $scope.$apply();
        });

        $scope.show = function($event, typeid, imageid){
			/*
            var type = $('[data-typeid='+typeid+']', '#tabbed');
            if (type.length > 0){
                var image = $('[data-imageid='+imageid+']', type);
                if (image.length > 0){
                    image.trigger('click');
                }
            }*/

			$('#image-wrap-' + typeid).find('[data-imageid]').each(function(index, item){
				if ($(item).attr('data-imageid') == imageid) {
					$(item).removeClass('hidden');
				}
				else {
					$(item).addClass('hidden');
				}
			});

            $event.preventDefault();
        };
    });
    $(function(){
		$('[data-plugin=light-gallery]').lightGallery({
			download: false,
			counter: false,
			fullScreen: false,
			actualSize: false
		});

        $('#tabbed').zozoTabs({
            position: 'top-compact',
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
        });

        $('[data-plugin=light-gallery]').lightGallery({
            download: false,
            counter: false,
            fullScreen: false,
            actualSize: false
        });
    });
})();
</script>
@endsection
