@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/frontend/css/news.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-news" ng-class="{'xs':screen == 'xs'}">
    <div class="container index">
        <div class="row">
            @foreach($news as $index => $new)
				<?php $topic_ = $new->getTopic($config['lang']['code']) ?>
                @if($index == 0 || $index == 1)
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" ng-class="{'top-lg':screen == 'lg', 'md':screen == 'md', 'sm':screen == 'sm'}">
                @else
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" ng-class="{'lg':screen == 'lg', 'md':screen == 'md', 'sm':screen == 'sm'}">
                @endif
                    <a href="/news/{{$new->newsid}}.html" class="item" alt="{{$topic_}}">
                        <?php
                            $source = '/static/images/image-placeholder-512-288.png';

                            if ($new->images->count() > 0){
                                $image  = $new->images->get(0);
                                $source = "/app/news/{$new->newsid}/{$image->imageid}_t.png";
                            }
                        ?>
                        <div class="defer-image" ng-controller="DeferImage" image="{{$source}}" alt="{{$topic_}}">
                            <div class="image-showing">
                                <img src="/static/images/preload-512-288.jpg" class="image holder" alt="{{$topic_}}">
                            </div>
                            <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                        </div>
                        <div class="time">{{dateTime($new->published, 'l, F d Y')}}</div>
                        <div class="topic">{{$topic_}}</div>
                        <div class="description">{{$new->getDescription($config['lang']['code'])}}</div>
                        <div class="more">{{trans('_.Read more')}} <i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-12">
                {!! $news->links() !!}
            </div>
        </div>
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
