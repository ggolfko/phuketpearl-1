@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/frontend/css/pearl.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/pages/crown/lunar_assets/lunar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{ $config['url'] }}/static/frontend/pages/crown/lunar_assets/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="{{ $config['url'] }}/static/frontend/pages/crown/lunar_assets/TweenMax.min.js"></script>
<script type="text/javascript" src="{{ $config['url'] }}/static/frontend/pages/crown/lunar_assets/packery.pkgd.min.js"></script>
<script type="text/javascript" src="{{ $config['url'] }}/static/frontend/pages/crown/lunar_assets/lunar.js"></script>
<style>
.specialAlbumUI {
	padding-top: 15px !important;
}
</style>
@endsection

@section('content')
<div class="ui-pearl" ng-class="{'xs':screen == 'xs'}">
    <div class="container crown">

        <div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('_.Pearl Crowns')}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="sk_wrapper">
                    <div class="lunar-gallery-ui">
                        @foreach($items as $index => $item)
                        <div class="lunar-album" data-width="50" data-thumbimage="/app/crown/{{$item->crownid}}/{{$item->imageid}}_m.png" data-is-special="true" data-special-side="{{$index%2==0?'left':'right'}}">
                            <div class="lunar-albumcover-content">
                                <h3 class="lunar-album-title">{!! $item->getTitle($config['lang']['code']) !!}</h3>
                                <div class="lunar-album-about">{!! nl2br($item->getDetail($config['lang']['code'])) !!}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
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
            src: $attrs.image
        });
        $scope.image.bind('load', function(){
            $($element).parent().prepend($scope.image);
            $scope.loaded = true;
            $($element).remove();
            $scope.$apply();
        });
    });
    app.controller('DeferImageFull', function($scope, $log, $attrs, $element){
        $scope.loaded = false;
        $scope.image = $('<img />', {
            src: $attrs.image,
            class: 'content__item-img'
        });
        $scope.image.bind('load', function(){
            $($element).parent().prepend($scope.image);
            $scope.loaded = true;
            $($element).remove();
            $scope.$apply();
        });
    });
})();
</script>
@endsection
