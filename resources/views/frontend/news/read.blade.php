@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/froala-wysiwyg-editor/css/froala_style.css" rel="stylesheet">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/news.css" rel="stylesheet" type="text/css">
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
<div class="ui-news" ng-class="{'xs':screen == 'xs'}" ng-controller="Read">
    <div class="container">

        <div class="row">
            <!-- main column -->
            <div class="col-md-8 read">
                @if($news->images->count() > 0)
                <?php $newsTopic = $news->getTopic($config['lang']['code']); ?>
                <div class="images">
                    @if($news->images->count() == 1)
                        <div class="defer-image" ng-controller="DeferImage" image="/app/news/{{$news->newsid}}/{{$news->images->get(0)->imageid}}.png" alt="{{$newsTopic}}">
                            <div class="image-showing">
                                <img src="/static/images/preload-512-288.jpg" class="holder" alt="{{$newsTopic}}">
                            </div>
                            <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                        </div>
                    @else
                        <div id="slider" style="position: relative; top: 0px; left: 0px; width: 753px; height: 400px;">
                            <div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 753px; height: 400px;">
                                @foreach($news->images as $index => $image)
                                <div class="defer-image" ng-controller="DeferImage" image="/app/news/{{$news->newsid}}/{{$image->imageid}}.png" alt="{{$newsTopic}}">
                                    <div class="image-showing">
                                        <img src="/static/images/preload-512-288.jpg" class="holder" alt="{{$newsTopic}}">
                                    </div>
                                    <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                                </div>
                                @endforeach
                            </div>
                            <span data-u="arrowleft" class="jssora05l" style="top:0px;left:8px;width:40px;height:40px;" data-autocenter="2"></span>
                            <span data-u="arrowright" class="jssora05r" style="top:0px;right:8px;width:40px;height:40px;" data-autocenter="2"></span>
                        </div>
                    @endif
                </div>
                @endif
                <div class="time">
                    <a href="{{ $config['url'] }}/news.html"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
					{{dateTime($news->published, 'l, F d Y')}}
                </div>
                <div class="topic">{!! $news->getTopic($config['lang']['code']) !!}</div>
                <div class="description">{{$news->getDescription($config['lang']['code'])}}</div>
                <div class="detail fr-view">
                    {!! nl2br($news->getContent($config['lang']['code'])) !!}
                </div>
            </div>
            <!-- end: main column -->

            
        </div>

    </div>
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/jssor-slider/js/jssor.slider.mini.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-fullscreen.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script>
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
app.controller('DeferImageNews', function($scope, $log, $attrs, $element){
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
app.controller('Read', function($scope){
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

        @if($news->images->count() > 1)
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
    });
});
</script>
@endsection
