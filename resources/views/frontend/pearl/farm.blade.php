@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/pearl.css" rel="stylesheet" type="text/css">
<style>
.jssora05l, .jssora05r {
    display: block;
    position: absolute;
    width: 40px;
    height: 40px;
    cursor: pointer;
    background: url('/static/bower_components/jssor-slider/img/a17.png') no-repeat;
    overflow: hidden;
}
.jssora05l { background-position: -10px -40px; }
.jssora05r { background-position: -70px -40px; }
</style>
@endsection

@section('content')
<div class="ui-pearl" ng-class="{'xs':screen == 'xs'}" ng-controller="index">
    <div class="container farm">
        <div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('_.Phuket Pearl’s pearl farm')}}</span>
                    </div>
                </div>
            </div>
        </div>

		<?php $alt = implode(',', $config['keywords']) ?>

        <div class="row">
            <div class="col-md-8">
                <div class="wrapper">

                    <div id="slider" style="position: relative; top: 0px; left: 0px; width: 753px; height: 500px;">
                        <div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 753px; height: 500px;">
                            @foreach($items as $index => $item)
                            <div class="defer-image" ng-controller="DeferImage" image="/app/pearlfarm/{{$item->imageid}}.png" alt="{{$alt}}">
                                <div class="image-showing">
                                    <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$alt}}">
                                </div>
                                <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                            </div>
                            @endforeach
                        </div>
                        <span data-u="arrowleft" class="jssora05l" style="top:0px;left:8px;width:40px;height:40px;" data-autocenter="2"></span>
                        <span data-u="arrowright" class="jssora05r" style="top:0px;right:8px;width:40px;height:40px;" data-autocenter="2"></span>
                    </div>

                    <div class="video">
                        <div class="row">
                            @foreach($videos as $video)
							<?php $title_ = $video->getTitle($config['lang']['code']) ?>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="item">
                                    <a href="{{$video->youtube}}" class="fancybox" alt="{{$title_}}" id="video-{{$video->videoid}}">
                                        <?php
                                            $source = '/static/dashboard/assets/img/photo-placeholder.png';

                                            if (
                                                $video->thumb_default == '1' ||
                                                $video->thumb_medium == '1' ||
                                                $video->thumb_high == '1' ||
                                                $video->thumb_standard == '1' ||
                                                $video->thumb_maxres == '1'
                                            )
                                            {
                                                $source = "/app/pearlfarm_videos/{$video->videoid}/preview.png";
                                            }
                                        ?>
                                        <div class="image">
                                            <div class="defer-image" ng-controller="DeferImageVideo" image="{{$source}}" alt="{{$title_}}">
                                                <div class="image-showing">
                                                    <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$title_}}">
                                                </div>
                                                <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                                            </div>
                                        </div>
                                        <img src="/static/images/playbutton.png" class="play">
                                        <div class="title">
                                            <div class="text">{{$title_}}</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="thumbs">
                        <div class="row">
                            @foreach($items as $item)
                            <div class="col-sm-3">
                                <div class="thumb" ng-controller="DeferImageThumb" image="/app/pearlfarm/{{$item->imageid}}_t.png" alt="{{$alt}}">
                                    <div class="defer-image" ng-class="{'hidden':loaded}">
                                        <div class="image-showing">
                                            <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$alt}}">
                                        </div>
                                        <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                                    </div>
                                    <a href="#" ng-class="{'hidden':!loaded}" ng-click="show($event, '{{$item->imageid}}')"></a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 ui-tour-random">
                <div class="row">
                    @foreach($tours as $index => $tour)
					<?php $title_ = $tour->getTitle($config['lang']['code']) ?>
                    <div class="col-xs-12 wow zoomIn">
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
                                    <div class="defer-image" ng-controller="DeferImageTour" image="{{$source}}" alt="{{$title_}}">
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
            </div>
        </div>
    </div>
</div>

<div class="hidden" id="light-gallery">
    @foreach($items as $item)
    <a href="/app/pearlfarm/{{$item->imageid}}.png" data-imageid="{{$item->imageid}}"></a>
    @endforeach
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/jssor-slider/js/jssor.slider.mini.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/fancybox/source/helpers/jquery.fancybox-media.js"></script>
<script>
(function(){
    app.controller('DeferImageTour', function($scope, $log, $attrs, $element){
        $scope.loaded = false;
        $scope.image = $('<img />', {
            src: $attrs.image,
            alt: $attrs.alt,
            class: 'transition'
        });
        $scope.image.bind('load', function(){
            $('.image-showing', $element).html($scope.image);
            $scope.loaded = true;
            $scope.$apply();
        });
    });
    app.controller('DeferImageThumb', function($scope, $log, $attrs, $element){
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
    app.controller('DeferImageVideo', function($scope, $log, $attrs, $element){
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
    app.controller('index', function($scope){
        $scope.show = function($event, imageid){
            var item = $('a[data-imageid='+imageid+']', '#light-gallery');
            if (item){
                item.trigger('click');
            }
            $event.preventDefault();
        };

        $scope.showTourPreview = function($event, tourid){
            $('.tour-preview[data-preview-tourid='+tourid+']').first().find('a').first().click();
            $event.preventDefault();
        };

        $(function(){
            $('.fancybox').fancybox({
                openEffect  : 'none',
                closeEffect : 'none',
                closeBtn: false,
                padding: 4,
                helpers : {
                    media : {}
                }
            });

            $('[data-plugin=light-gallery]').lightGallery({
                download: false,
                counter: false,
                fullScreen: false,
                actualSize: false
            });

            $('#light-gallery').lightGallery({
                download: false,
                counter: false,
                fullScreen: false,
                actualSize: false,
                thumbnail: false
            });

            @if($items->count() > 0)
            var options = {
                $AutoPlay: true ,
                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$
                }
            };
            var jssor_slider = new $JssorSlider$('slider', options);

            function ScaleSlider() {
                var refSize = jssor_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 753);
                    jssor_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            @endif

			@if(isset($id) && is_numeric($id) && strlen($id) == 16)
			var _image = $('a[data-imageid={{$id}}]', $('#light-gallery'));
			if (_image.length == 1){
				setTimeout(function(){
					_image.trigger('click');
				}, 100);
			}

			var _video = $('#video-{{$id}}');
			if (_video.length == 1){
				setTimeout(function(){
					_video.trigger('click');
				}, 100);
			}
			@endif
        });
    });
})();
</script>
@endsection
