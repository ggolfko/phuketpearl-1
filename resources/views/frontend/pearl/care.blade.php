@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/froala-wysiwyg-editor/css/froala_style.css" rel="stylesheet">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/pearl.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-pearl" ng-class="{'xs': screen == 'xs'}" ng-controller="Index">
    <div class="container care">
        <div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('_.Pearl Care')}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- wrapper -->
            <div class="col-md-12 wrapper">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="detail fr-view {{$config['lang']['code']}}">
                            {!! $item->getContent($config['lang']['code']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- wrapper -->
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
</script>
@endsection
