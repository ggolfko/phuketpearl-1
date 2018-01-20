@extends('dashboard.layout')

@section('head')
<link href="/static/bower_components/froala-wysiwyg-editor/css/froala_style.css" rel="stylesheet">
<style>
.title {
    position: relative;
    margin-bottom: 15px;
    font-size: 16px;
}
.ui-title {
    display: inline-block;
    padding-top: 4px;
	padding-left: 10px;
}
.content {
    line-height: 21px;
	padding-top: 10px;
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
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-12">
								<a href="/dashboard/docs/pearlfarming" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-title">{{$farming->getTitle($config['lang']['code'])}}</span>
                                <button type="button" class="btn btn-sm btn-danger pull-right" style="margin-left: 5px;" ng-click="delete()" ng-disabled="deleting || deleted">
                                    [[(deleting?'{{trans('_.Deleting...')}}':'{{trans('_.Delete')}}')]]
                                </button>
                                <a href="/dashboard/docs/pearlfarming/{{$farming->farmingid}}/edit" class="btn btn-danger btn-sm pull-right" style="margin-left: 5px;">
                                    {{trans('_.Edit')}}
                                </a>
								<a href="/dashboard/docs/pearlfarming/{{$farming->farmingid}}/slides" class="btn btn-danger btn-sm pull-right">
                                    {{trans('pearl.Images Slide')}}
                                </a>
		                    </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="content fr-view">
                                    {!! $farming->getContent($config['lang']['code']) !!}
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
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
app.controller('Item', function($scope, $http, $window){
    $scope.deleting = false;
    $scope.deleted  = false;

    $scope.delete = function(){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.deleting = true;

            $http.post('/ajax/dashboard/docs/pearlfarming/{{$farming->farmingid}}/delete', {
                id: {{$farming->id}}
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.deleted = true;
                    $window.location.href = '/dashboard/docs/pearlfarming';
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
