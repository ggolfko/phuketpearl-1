@extends('dashboard.layout')

@section('head')
<link href="/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<style>
.ui-item {
    margin-top: 15px;
}
.ui-item.top {
    margin-top: 0px;
}
.ui-item a {
    display: block;
}
.ui-item a img {
    display: block;
    max-width: 100%;
}
.ui-item .options {
    position: absolute;
    display: none;
    top: 5px;
    right: 21px;
}
.ui-item:hover .options {
    display: block;
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
<section id="main-content" class="hidden" ng-controller="Content">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-sm-6">
								{{trans('_.Pearl Quality')}}
		                    </div>
                            <div class="col-sm-6">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/pearl-quality.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#uploadModal">
										{{trans('pearl.Upload Image')}}
									</button>
								</form>
                            </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">
                        <div class="row ui-item" ng-repeat="item in items track by $index" ng-controller="Item" ng-class="{'top':$index == 0}">
                            <div class="col-xs-12">
                                <a href="#" ng-click="show($event)">
                                    <img ng-src="/app/pearlquality/[[item.imageid]].[[item.extension]]" ng-onload="load()">
                                </a>
                                <div class="options" ng-class="{'hidden':!loaded || deleted}">
                                    <button type="button" class="btn btn-xs btn-danger" ng-disabled="deleting" ng-click="delete()">[[(deleting?'{{trans('_.Deleting...')}}':'{{trans('_.Delete')}}')]]</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </section>

    <div class="hidden" id="light-gallery">
        <a href="/app/pearlquality/[[item.imageid]].[[item.extension]]" ng-repeat="item in items track by $index" data-imageid="[[item.imageid]]"></a>
    </div>

</section>
<!--main content end-->

<!-- Upload Modal -->
<div class="modal fade ui_modal" id="uploadModal" ng-controller="Form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{trans('pearl.Upload Image')}}</h5>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger fade in" ng-show="eMessage" ng-bind-html="eMessage"></div>

				<form action="#" class="form-horizontal tasi-form">
					<div class="form-group">
						<div class="controls col-md-12">
							<div class="input-group m-bot15">
								<span class="input-group-btn">
									<button class="btn btn-white" type="button" ng-click="browse()" ng-disabled="uploading">{{trans('_.Browse')}}</button>
								</span>
								<input type="text" class="form-control ui-browse" ng-model="fileText" ng-click="browse()" ng-disabled="uploading" readonly>
								<input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" id="uploadFile">
								<img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="uploading">
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
@endsection

@section('foot')
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script src="/static/bower_components/ng-onload/release/ng-onload.min.js"></script>
<script src="/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script>
(function(){
    app.requires.push('ngOnload');

    app.controller('Content', function($scope, $rootScope, $log, $timeout){
        $rootScope.items = {!! json_encode($items) !!};

        $(function(){
            $rootScope.gallery = $('#light-gallery');

            $rootScope.gallery.lightGallery({
                download: false,
                counter: false,
                fullScreen: false,
                actualSize: false,
                thumbnail: false
            });
        });
    });

    app.controller('Form', function($scope, $rootScope, $log, $timeout){
        $scope.browse = function(){
            $('#uploadFile').trigger('click');
        };

        $('#uploadFile').bind('change', function(e){
            if ($(this).val() != '' && e.target.files.length == 1)
            {
                var file = e.target.files[0];

                if ($.inArray(file.type.toLowerCase(), ['image/jpeg', 'image/gif', 'image/png']) >= 0)
                {
                    $scope.fileText = file.name;
                    $scope.uploading = true;
                    $scope.eMessage = null;
                    $scope.$apply();

                    var formData = new FormData();
                    formData.append('image', file);
                    formData.append('_token', '{{csrf_token()}}');

                    $.ajax({
                        url: '/ajax/dashboard/docs/pearlquality/image',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                        data: formData
                    })
                    .success(function(resp){
                        if (resp.status == 'ok'){
                            $('#uploadFile').val('');
                            $('#uploadModal').modal('hide');
                            $scope.fileText = '';
                            $rootScope.items = resp.payload.items;

                            noty({
                        		text: '{!! trans('pearl.Upload an image successfully.') !!}',
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

                            $timeout(function(){
                                $rootScope.gallery.data('lightGallery').destroy(true);
                                $scope.$apply();

                                $timeout(function(){
                                    $rootScope.gallery.lightGallery({
                                        download: false,
                                        counter: false,
                                        fullScreen: false,
                                        actualSize: false,
                                        thumbnail: false
                                    });
                                });
                            });
                        }
                        else {
                            $scope.eMessage = resp.message;
                        }
                    })
                    .error(function(){
                        $scope.eMessage = '{{trans('error.general')}}';
                    })
                    .complete(function(){
                        $scope.uploading = false;
                        $scope.$apply();
                    });
                }
                else {
                    $scope.eMessage = '{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}';
                    $scope.$apply();
                }
            }
            else {
                $scope.fileText = '';
                $scope.$apply();
            }
        });
    });

    app.controller('Item', function($scope, $rootScope, $http, $window, $log, $timeout){
        $scope.load = function(){
            $scope.loaded = true;
            $scope.$apply();
        };

        $scope.show = function($event){
            var item = $('a[data-imageid='+$scope.item.imageid+']', '#light-gallery');
            if (item){
                item.trigger('click');
            }
            $event.preventDefault();
        };

        $scope.delete = function(){
            if (confirm('{{trans('_.Are you sure?')}}'))
            {
                $scope.deleting = true;
                $http.post('/ajax/dashboard/docs/pearlquality/'+$scope.item.imageid+'/delete', {
                    id: $scope.item.id
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.deleted = true;
                        $rootScope.items = [];
                        $timeout(function(){
                            $rootScope.items = resp.payload.items;
                        });

                        noty({
                            text: '{!! trans('pearl.Deleted an image successfully.') !!}',
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

                        $timeout(function(){
                            $rootScope.gallery.data('lightGallery').destroy(true);
                            $scope.$apply();

                            $timeout(function(){
                                $rootScope.gallery.lightGallery({
                                    download: false,
                                    counter: false,
                                    fullScreen: false,
                                    actualSize: false,
                                    thumbnail: false
                                });
                            });
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
})();
</script>
@endsection
