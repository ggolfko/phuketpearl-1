@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen">
<link href="{{ $config['url'] }}/static/frontend/css/gallery.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/gallery.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-gallery" ng-class="{'xs':screen == 'xs'}" ng-controller="gallery">
    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('_.Gallery')}}</span>
                    </div>
                </div>
            </div>
        </div>

		<?php $alt = implode(',', $config['keywords']) ?>

        <div class="row">
			@foreach($videos as $index => $video)
			<?php $title_ = $video->getTitle($config['lang']['code']) ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 video">
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
                                $source = "/app/gallery_videos/{$video->videoid}/preview.png";
                            }
                        ?>
                        <div class="image">
                            <div class="defer-image" ng-controller="DeferImage" image="{{$source}}" alt="{{$title_}}">
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

			@foreach($images as $index => $image)
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 index" ng-controller="DeferImage" image="/app/gallery/{{$image->imageid}}_t.png" alt="{{$alt}}">
				<a href="#" ng-click="showGallery($event, '{{$image->imageid}}')" alt="{{$alt}}">
                    <div class="defer-image">
                        <div class="image-showing">
                            <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$alt}}">
                        </div>
                        <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                    </div>
                </a>
            </div>
			@endforeach
        </div>

		<div class="gallery-wrap hidden" id="light-gallery">
			@foreach($images as $index => $image)
            <a href="/app/gallery/{{$image->imageid}}.png" data-imageid="{{$image->imageid}}" alt="{{$alt}}">
                <img ng-src="/app/gallery/{{$image->imageid}}_t.png" alt="{{$alt}}">
            </a>
			@endforeach
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
                        <a href="/tours/{{$tour->url}}.html">
                            <?php
                                $source = '/static/images/image-placeholder-622-415.png';

                                if ($tour->images->count() > 0){
                                    $image  = $tour->images->get(0);
                                    $source = "/app/tour/{$tour->tourid}/{$image->imageid}_t.png";
                                }
                            ?>
                            <div class="defer-image" ng-controller="DeferImage" image="{{$source}}" alt="{{$tour->getTitle($config['lang']['code'])}}">
                                <div class="image-showing">
                                    <img src="/static/images/preload-622-415.jpg" class="holder">
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
                            <a href="#" ng-click="showTourPreview($event, '{{$tour->tourid}}')"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
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
<script src="{{ $config['url'] }}/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/fancybox/source/helpers/jquery.fancybox-media.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script>
(function(){
	app.controller('gallery', function($scope){
		$scope.showTourPreview = function($event, tourid){
	        $('.tour-preview[data-preview-tourid='+tourid+']').first().find('a').first().click();
	        $event.preventDefault();
	    };

		$scope.showGallery = function($event, _id){
            $('a[data-imageid=' + _id + ']', $('#light-gallery')).trigger('click');
            $event.preventDefault();
        };

        $(function(){
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
                actualSize: false
            });

			$('.fancybox').fancybox({
	            openEffect  : 'none',
	            closeEffect : 'none',
	            closeBtn: false,
	            padding: 4,
	            helpers : {
	                media : {}
	            }
	        });

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
