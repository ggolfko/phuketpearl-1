@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/frontend/css/company.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/pages/award-certificate/lunar_assets/lunar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{ $config['url'] }}/static/frontend/pages/award-certificate/lunar_assets/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="{{ $config['url'] }}/static/frontend/pages/award-certificate/lunar_assets/TweenMax.min.js"></script>
<script type="text/javascript" src="{{ $config['url'] }}/static/frontend/pages/award-certificate/lunar_assets/packery.pkgd.min.js"></script>
@endsection

@section('content')
<div class="ui-company" ng-class="{'xs':screen == 'xs'}">
    <div class="container award-certificate">

        <div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('_.Awards')}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">

                <div class="row award">
                    @foreach($awards as $award)
					<?php $title_ = $award->getTitle($config['lang']['code']) ?>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                        <div class="item">
							<div class="image">
								<div ng-controller="DeferImage" image="/app/award/{{$award->awardid}}/{{$award->imageid}}_t.png" alt="{{$title_}}">
									<div class="defer-image" ng-class="{'hidden':loaded}">
										<div class="image-showing">
											<img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$title_}}">
										</div>
										<div class="is-loading" ng-class="{'hidden':loaded}"></div>
									</div>
									<a href="#" ng-click="$event.preventDefault();" ng-class="{'hidden':!loaded}" style="cursor: default !important;"></a>
								</div>
							</div>
							<div class="caption">
								{{$title_}}
							</div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('_.Certificates')}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">

                <div class="row cer">
                    @foreach($cers as $cer)
					<?php $title_ = $cer->getTitle($config['lang']['code']) ?>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="item">
                            <div class="image">
								<div ng-controller="DeferImage" image="/app/certificate/{{$cer->certificateid}}/{{$cer->imageid}}_t.png" alt="{{$title_}}">
									<div class="defer-image" ng-class="{'hidden':loaded}">
										<div class="image-showing">
											<img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$title_}}">
										</div>
										<div class="is-loading" ng-class="{'hidden':loaded}"></div>
									</div>
									<a href="#" ng-click="$event.preventDefault();" ng-class="{'hidden':!loaded}" style="cursor: default !important;"></a>
								</div>
							</div>
                            <div class="caption">
                                {{$title_}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('foot')
<script type="text/javascript" src="{{ $config['url'] }}/static/frontend/pages/award-certificate/lunar_assets/lunar.js"></script>
<script>
(function(){
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
})();
</script>
@endsection
