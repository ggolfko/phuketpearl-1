@extends('dashboard.layout')

@section('head')
<style>
.ui-title {
    margin-left: 10px;
    vertical-align: middle;
}
.content span {
    line-height: 21px;
    font-size: 14px;
    padding-left: 20px;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Item">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-9">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-8">
								<a href="/dashboard/docs/pearltype" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
                                <span class="ui-title">
									{{$type->getTitle($config['lang']['code'])}}
									@if($type->bold == '1')
									<span style="padding-left: 5px; font-size: 14px;">({{trans('pearl.Bold text')}})</span>
									@endif
								</span>
		                    </div>
                            <div class="col-md-4">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/dashboard/docs/pearltype/{{$type->typeid}}/images" class="btn btn-danger btn-sm">
										{{trans('_.Images')}}
									</a>
                                    <a href="/dashboard/docs/pearltype/{{$type->typeid}}/edit" class="btn btn-danger btn-sm">
										{{trans('_.Edit')}}
									</a>
                                    <button type="button" class="btn btn-danger btn-sm" ng-click="delete()" ng-disabled="deleted || deleting">
                                        [[(deleting?'{{trans('_.Deleting...')}}':'{{trans('_.Delete')}}')]]
                                    </button>
								</form>
                            </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">

                        <div class="row">
                            <div class="col-lg-10">
                                <div class="content">
                                    <span>{!! nl2br($type->getDetail($config['lang']['code'])) !!}</span>
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
(function(){
    app.controller('Item', function($scope, $http, $window){
        $scope.delete = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/docs/pearltype/{{$type->typeid}}/delete')
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.deleted = true;
                        $window.location.href = '/dashboard/docs/pearltype';
                    }
                    else {
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
})();
</script>
@endsection
