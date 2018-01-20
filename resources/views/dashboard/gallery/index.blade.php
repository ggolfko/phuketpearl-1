@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen">
<link rel="stylesheet" href="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen">
<style>
.ui-item {
    margin-bottom: 15px;
}
.ui-action {
	position: absolute;
	margin-top: -28px;
	margin-left: 6px;
}
.ui-title {
    display: inline-block;
    padding-top: 4px;
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
<section id="main-content" class="hidden" ng-controller="content">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-3" style="padding-left:20px;">{{trans('gallery.Gallery Management')}}</div>
							<div class="col-md-9">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/gallery.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#uploadModal">
										{{trans('_.Upload Images')}}
									</button>
                                    <a href="/dashboard/gallery/videos" class="btn btn-danger btn-sm">
										{{trans('gallery.Videos')}}
									</a>
								</form>
							</div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">
                        <div class="row">
                            @foreach($items as $item)
                            <div class="col-sm-4 ui-item" ng-controller="item" ng-class="{'hidden': deleted}" id="item-{{$item->imageid}}">
                                <a href="/app/gallery/{{$item->imageid}}.png" class="fancybox" rel="gallery">
                                    <img src="/app/gallery/{{$item->imageid}}_t.png" class="img-responsive">
                                </a>
                                <p class="ui-action">
                                    <button type="button" class="btn btn-xs btn-danger pull-right" ng-disabled="deleting" ng-click="delete('{{$item->imageid}}')">{{trans('_.Delete')}}</button>
                                </p>
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
					<div class="alert alert-success fade in" ng-class="{'hidden': !uploadSuccess}">
						{{trans('_.Upload images successfully.')}}
					</div>
					<div class="alert alert-danger fade in" ng-class="{'hidden': !uploadError}">
						<span class="msg">[[uploadError]]</span>
					</div>

					<form action="#" class="form-horizontal tasi-form">
						<div class="form-group">
							<div class="controls col-md-12">
								<div class="input-group m-bot15">
									<span class="input-group-btn">
										<button class="btn btn-white" type="button" ng-click="openFileInput()">{{trans('_.Browse')}}</button>
									</span>
									<input type="text" class="form-control ui-browse" ng-click="openFileInput()" ng-model="uploadText" readonly>
									<input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" ng-disabled="doing" id="uploadFile" multiple>
									<img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="doing">
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
					<button data-dismiss="modal" class="btn btn-default" type="button" ng-disabled="doing">{{trans('_.Close')}}</button>
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
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
app.controller('item', function($scope, $http, $window){
    $scope.delete = function(_id){
        if (confirm('{{trans('_.Are you sure?')}}'))
        {
            $scope.deleting = true;
            $http.post('/ajax/dashboard/gallery/' + _id + '/delete')
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.deleted = true;
                    $('#item-' + _id).remove();

                    if (resp.payload.refresh == true){
                        $window.location.reload();
                    }
                    else {
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
                }
                else {
                    alert(resp.message);
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
            })
            .finally(function(){
                $scope.deleting = false;
            });
        }
    };
});

app.controller('content', function($http, $window, $scope){
	$('#uploadFile').bind('change', function(e){
		if ( $(this).val().trim() != '' && e.target.files.length > 0 )
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
					$scope.uploadSuccess	= false;
					$scope.uploadError		= false;
					$scope.uploadText 		= text.join(', ');
					$scope.doing			= true;

					if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
						$scope.$apply();
					}

					var formData = new FormData();

					$.each(files, function(i, file){
						formData.append('image[]', file);
					});

					formData.append('_token', '{{csrf_token()}}');

					$.ajax({
						url: '/ajax/dashboard/gallery/upload',
						type: 'POST',
						processData: false,
						contentType: false,
						dataType: 'JSON',
						data: formData
					})
					.success(function(resp){
						if (resp.status == 'ok')
						{
							$http.post('/ajax/dashboard/gallery/images', {
								files: resp.payload.images
							})
							.success(function(data){
								if (data.status == 'ok')
								{
									$scope.uploadSuccess	= true;
									$scope.uploadText		= '';
								}
								else
								{
									$scope.uploadError = data.message;
								}
							})
							.error(function(){
								$scope.uploadError = '{{trans('error.image')}}';
							})
							.finally(function(){
								$scope.doing = false;
							});
						}
						else
						{
							$scope.doing = false;
							$scope.uploadError = resp.message;

							if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
								$scope.$apply();
							}
						}
					})
					.error(function(){
						$scope.doing = false;
						$scope.uploadError = '{{trans('error.general')}}';

						if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
							$scope.$apply();
						}
					});
				}
				else {
					$scope.uploadError = '{{trans('gallery.Upload images up to 10 files at a time.')}}';

					if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
						$scope.$apply();
					}
				}
			}
			else {
				$scope.uploadError = '{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}';

				if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
					$scope.$apply();
				}
			}
		}

		$(this).val('');
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

	$scope.openFileInput = function(){
		$('#uploadFile').trigger('click');
	}

	$('#uploadModal').on('hidden.bs.modal', function () {
		$window.location.reload();
	});
});
</script>
@endsection
