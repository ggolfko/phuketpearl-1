@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/froala_style.css">
<link rel="stylesheet" href="/static/bower_components/unslider/dist/css/unslider.css">
<link rel="stylesheet" href="/static/bower_components/unslider/dist/css/unslider-dots.css">
<style>
.ui-title {
    display: inline-block;
    padding-top: 2px;
}
.topic {
    position: relative;
    margin-bottom: 20px;
    font-size: 16px;
}
.image-slides {
    margin-bottom: 20px;
}
.image-slides img {
    max-width: 100%;
}
.content {
    line-height: 21px;
}
.content img {
    max-width: 100%;
}
.content iframe {
    max-width: 100%;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Item">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-10">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-2">
								<a href="/dashboard/news" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
		                    </div>
                            <div class="col-md-10">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/news/{{$news->newsid}}" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
                                    <a href="/dashboard/news/{{$news->newsid}}/images" class="btn btn-danger btn-sm">
										{{trans('news.News Images')}}
									</a>
                                    <a href="/dashboard/news/{{$news->newsid}}/edit" class="btn btn-danger btn-sm">
										{{trans('_.Edit')}}
									</a>
                                    <button type="button" class="btn btn-danger btn-sm" ng-disabled="deleting || deleted" ng-click="delete()">
                                        [[(deleting?'{{trans('_.Delete')}}':'{{trans('_.Delete')}}')]]
                                    </button>
								</form>
                            </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="topic">{{$news->getTopic($config['lang']['code'])}}</div>
                            </div>
                        </div>
						@if($news->images->count() > 0)
						<div class="row">
                            <div class="col-lg-7">
                                <div class="image-slides">
                                    <ul>
                                        @foreach($news->images as $image)
                                        <li><img src="/app/news/{{$news->newsid}}/{{$image->imageid}}_t.png"></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
						@endif
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="content fr-view">
                                    {!! $news->getDescription($config['lang']['code']) !!}
                                    <hr>
                                    {!! $news->getContent($config['lang']['code']) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/unslider/dist/js/unslider-min.js"></script>
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
app.controller('Item', function($scope, $http, $window){
    $scope.deleting = false;
    $scope.deleted  = false;

    $scope.delete = function(){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.deleting = true;

            $http.post('/ajax/dashboard/news/{{$news->newsid}}', {
                id: {{$news->id}}
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.deleted = true;
                    $window.location.href = '/dashboard/news';
                }
                else{
                    alert(resp.message);
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
                $window.location.reload();
            })
            .finally(function(){
                $scope.deleting = false;
            });
        }
    };
});

$(function(){
    $('.image-slides').unslider({
        autoplay: true,
        nav: false,
        arrows: false
    });

    @if(session()->has('sMessage'))
    noty({
        text: '{!!session('sMessage')!!}',
        layout: 'topRight',
        type: 'success',
        dismissQueue: true,
        template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
        animation: {
            open: {height: 'toggle'},
            close: {height: 'toggle'},
            easing: 'swing',
            speed: 300
        },
        timeout: 4500
    });
    @endif
});
</script>
@endsection
