@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen">
<link rel="stylesheet" href="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen">
<style>
.ui-item {
    position: relative;
    margin-bottom: 20px;
}
.ui-item .options {
    position: absolute;
    top: 5px;
    right: 5px;
}
.ui-browse {
    cursor: pointer;
    font-size: 12px;
    background-color: #fff !important;
    padding-right: 33px;
}
.ui-process {
	position: absolute;
	width: 16px;
	right: 8px;
	top: 9.5px;
    z-index: 500;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Index">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-6">
								{{trans('_.Phuket Pearl’s pearl farm')}}
		                    </div>
                            <div class="col-md-6">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/pearl-farm.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#uploadModal">
										{{trans('_.Upload Images')}}
									</button>
                                    <a href="/dashboard/docs/pearlfarm/videos" class="btn btn-danger btn-sm">
                                        {{trans('pearl.Videos')}}
                                    </a>
								</form>
                            </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">
                        <div class="row">
                            @foreach($items as $item)
                            <div class="col-sm-4" ng-controller="Item" ng-class="{'hidden':deleted}" id="item-{{$item->imaged}}">
                                <div class="ui-item" ng-mouseenter="setHover(true)" ng-mouseleave="setHover(false)">
                                    <a href="/app/pearlfarm/{{$item->imageid}}.png" class="fancybox" rel="gallery">
                                        <img src="/app/pearlfarm/{{$item->imageid}}_t.png" class="img-responsive">
                                    </a>
                                    <div class="options" ng-class="{'hidden':!hover && !deleting}">
                                        <button type="button" class="btn btn-xs btn-danger" ng-click="delete({{$item->id}}, '{{$item->imageid}}')" ng-disabled="deleting">[[(deleting?'{{trans('_.Deleting...')}}':'{{trans('_.Delete')}}')]]</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <!-- Upload Modal -->
    <div class="modal fade ui_modal" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    	<div class="modal-dialog">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h5 class="modal-title">{{trans('_.Upload Images')}}</h5>
    			</div>
    			<div class="modal-body">
    				<div class="alert alert-warning">
    					{{trans('gallery.You can upload up to 10 files at a time and the size of the photo must be larger than the recommended 650px x 420px.')}}
    				</div>
                    <div class="alert alert-success fade in" ng-class="{'hidden':!sMessage}" ng-bind-html="sMessage"></div>
    				<div class="alert alert-danger fade in" ng-class="{'hidden':!eMessage}" ng-bind-html="eMessage"></div>

    				<form action="#" class="form-horizontal tasi-form">
    					<div class="form-group">
    						<div class="controls col-md-12">
    							<div class="input-group m-bot15">
    								<span class="input-group-btn">
    									<button class="btn btn-white" type="button" ng-click="browse()" ng-disabled="uploading">{{trans('_.Browse')}}</button>
    								</span>
    								<input type="text" class="form-control ui-browse" ng-model="text" ng-click="browse()" ng-disabled="uploading" readonly>
    								<input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" id="uploadFile" multiple>
    								<img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-class="{'hidden':!uploading}">
    							</div>
    							<div class="m-bot15">
    								<span class="label label-danger">{{trans('_.Note')}}!</span>
    								<span>{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}</span>
    							</div>
    						</div>
    					</div>
    				</form>

    			</div>
    			<div class="modal-footer">
    				<button data-dismiss="modal" class="btn btn-default" type="button">{{trans('_.Close')}}</button>
    			</div>
    		</div>
    	</div>
    </div>
    <!-- modal -->

</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.js"></script>
<script>
(function(){
    app.controller('Item', function($scope, $http, $window){
        $scope.deleting = false;
        $scope.deleted  = false;
        $scope.hover    = false;

        $scope.setHover = function(state){
            $scope.hover = state;
        };

        $scope.delete = function(id, imageid){
            if (confirm('{{trans('_.Are you sure?')}}'))
            {
                $scope.deleting = true;
                $http.post('/ajax/dashboard/docs/pearlfarm/delete', {
                    id: id,
                    imageid: imageid
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.deleted = true;
                        $('#item-'+imageid).remove();

                        $('.fancybox').fancybox({
                            closeBtn: false,
                            padding: 9,
                            helpers:  {
                                thumbs : {
                                    width: 50,
                                    height: 50
                                }
                            }
                        });
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
    });

    app.controller('Index', function($scope, $http, $log, $window, $timeout){
        $scope.text         = '';
        $scope.eMessage     = null;
        $scope.sMessage     = null;
        $scope.uploading    = false;

        $scope.browse = function(){
            $('#uploadFile').trigger('click');
        };

        $(function(){
            $('#uploadModal').on('hidden.bs.modal', function () {
                $window.location.reload();
            });

            $('#uploadFile').bind('change', function(e){
                if ($(this).val() != '' && e.target.files.length > 0)
                {
                    var files = e.target.files, valid = true, text = [];
                    $.each(files, function(i, file){
                        if ($.inArray(file.type.toLowerCase(), ['image/jpeg', 'image/gif', 'image/png']) < 0){
                            valid = false;
                        }
                        text.push(file.name);
                    });

                    if (valid)
                    {
                        if (files.length <= 10)
                        {
                            $scope.text         = text.join(', ');
                            $scope.eMessage     = null;
                            $scope.sMessage     = null;
                            $scope.uploading    = true;
                            $scope.$apply();

                            var formData = new FormData();
                            $.each(files, function(i, file){
                                formData.append('image[]', file);
                            });
                            formData.append('_token', '{{csrf_token()}}');

                            $.ajax({
                                url: '/ajax/dashboard/docs/pearlfarm/upload',
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                dataType: 'JSON',
                                data: formData
                            })
                            .success(function(resp){
                                if (resp.status == 'ok'){
                                    $scope.sMessage = '{{trans('pearl.Upload images successfully.')}}';
                                    $scope.text = null;
                                    $('#uploadFile').val('');

                                    $timeout(function(){
                                        $scope.sMessage = null;
                                        $scope.$apply();
                                    }, 6000);
                                }
                                else {
                                    $scope.eMessage = resp.message;
                                }
                            })
                            .error(function(){
                                $scope.eMessage = '{{trans('error.image')}}';
                            })
                            .complete(function(){
                                $scope.uploading = false;
                                $scope.$apply();
                            });
                        }
                        else {
                            $scope.eMessage = '{{trans('gallery.Upload images up to 10 files at a time.')}}';
                            $scope.$apply();
                        }
                    }
                    else {
                        $scope.eMessage = '{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}';
                        $scope.$apply();
                    }
                }
            });

            $('.fancybox').fancybox({
                closeBtn: false,
                padding: 9,
                helpers:  {
                    thumbs : {
                        width: 50,
                        height: 50
                    }
                }
            });
        });
    });
})();
</script>
@endsection
