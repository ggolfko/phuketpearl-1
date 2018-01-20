@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/tour.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-tour" ng-class="{'xs':screen == 'xs'}" ng-controller="Index">
    <div class="container index">
        <div class="row">
            @foreach($tours as $index => $tour)
			<?php $title_ = $tour->getTitle($config['lang']['code']) ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow zoomIn">
                <div class="item">
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
                    <div class="info" ng-class="{'xs':screen == 'xs'}">
                        <div class="title">{!! str_limit($title_, $limit = 80, $end = '...') !!}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-12">
                {!! $tours->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-fullscreen.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script>
(function(){
    app.controller('Index', function($scope){
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
        });
    });
    app.controller('DeferImage', function($scope, $log, $attrs, $element){
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
})();
</script>
@endsection
