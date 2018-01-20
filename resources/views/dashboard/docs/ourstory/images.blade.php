@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen" />
<style>
.ui-item {
    position: relative;
    margin-bottom: 20px;
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
.action {
    position: absolute;
    right: 5px;
    top: 5px;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Images">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								{{trans('story.Our Story')}} <i class="fa fa-angle-right" aria-hidden="true" style="margin:0px 5px;"></i> {{trans('_.Images')}}
							</div>
                            <div class="col-md-6">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/our-story.html" target="_blank" class="btn btn-default btn-sm">
                                        {{trans('_.View on Frontend')}}
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#uploadModal">
										{{trans('timeline.Upload Images')}}
									</button>
                                </form>
                            </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">
                        <div class="row">
                            @foreach($items as $item)
                            <div class="col-sm-4" ng-controller="Image" ng-class="{'hidden':deleted}" id="item-{{$item->imageid}}">
                                <div class="ui-item">
                                    <a href="/app/ourstory/{{$item->imageid}}.png" class="fancybox" rel="gallery">
                                        <img src="/app/ourstory/{{$item->imageid}}_t.png" class="img-responsive">
                                    </a>
                                    <p class="action">
                                        <button type="button" class="btn btn-xs btn-danger pull-right" ng-disabled="deleting" ng-click="delete({{$item->id}},'{{$item->imageid}}')">{{trans('_.Delete')}}</button>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->

<!-- Upload Modal -->
<div class="modal fade ui_modal" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{trans('timeline.Upload Images')}}</h5>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					{{trans('timeline.You can upload up to 10 files at a time and the size of the image must be larger than the recommended 650px x 420px.')}}
				</div>
				<div class="alert alert-success fade in hidden" id="uploadSuccess">
					{{trans('timeline.Upload images successfully.')}}
				</div>
				<div class="alert alert-danger fade in hidden" id="uploadError">
					<span class="msg"></span>
				</div>

				<form action="#" class="form-horizontal tasi-form">
					<div class="form-group">
						<div class="controls col-md-12">
							<div class="input-group m-bot15">
								<span class="input-group-btn">
									<button class="btn btn-white" type="button" id="uploadButton">{{trans('_.Browse')}}</button>
								</span>
								<input type="text" class="form-control ui-browse" id="uploadText" readonly>
								<input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" id="uploadFile" multiple>
								<img src="/static/dashboard/assets/img/process.gif" class="ui-process hidden" id="uploadProcess">
							</div>
							<div class="m-bot15">
								<span class="label label-danger">{{trans('_.Note')}}!</span>
								<span>{!! trans('_.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}</span>
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
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.js"></script>
<script>
(function(){
    app.controller('Image', function($scope, $http, $window){
        $scope.delete = function(id, imageid){
            if (confirm('{{trans('_.Are you sure?')}}'))
            {
                $scope.deleting = true;
                $http.post('/ajax/dashboard/docs/ourstory/images/'+imageid, {
                    id: id
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.deleted = true;
                        $('#item-'+imageid).remove();

                        if (resp.payload.refresh == true){
                            $window.location.reload();
                        }
                        else {
                            $('.fancybox').fancybox({
                                closeBtn: false,
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
                    $window.location.reload();
                })
                .finally(function(){
                    $scope.deleting = false;
                });
            }
        };
    });

    app.controller('Images', function($http, $window){
        $(function(){
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

            $('#uploadFile').bind('change', function(e){
                if ($(this).val() != '' && e.target.files.length > 0)
                {
                    $('#uploadSuccess').addClass('hidden');

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
                            $('#uploadError').addClass('hidden');
                            $('#uploadProcess').removeClass('hidden');
                            $('#uploadFile').attr('disabled', true);
                            $('#uploadText').val(text.join(', '));

                            var formData = new FormData();
                            $.each(files, function(i, file){
                                formData.append('image[]', file);
                            });
                            formData.append('_token', '{{csrf_token()}}');

                            $.ajax({
                                url: '/ajax/dashboard/docs/ourstory/images/upload',
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                dataType: 'JSON',
                                data: formData
                            })
                            .success(function(resp){
                                if (resp.status == 'ok'){
                                    $('#uploadSuccess').removeClass('hidden');
                                    $('#uploadFile').val('');
                                    $('#uploadText').val('');
                                    setTimeout(function(){
                                        $('#uploadSuccess').addClass('hidden');
                                    }, 6000);
                                }
                                else {
                                    $('#uploadError').find('.msg').html(resp.message);
                                    $('#uploadError').removeClass('hidden');
                                }
                            })
                            .error(function(){
                                $('#uploadError').find('.msg').html('{{trans('error.image')}}');
                                $('#uploadError').removeClass('hidden');
                            })
                            .complete(function(){
                                $('#uploadProcess').addClass('hidden');
                                $('#uploadFile').attr('disabled', false);
                            });
                        }
                        else {
                            $('#uploadError').find('.msg').html('{{trans('gallery.Upload images up to 10 files at a time.')}}');
                            $('#uploadError').removeClass('hidden');
                        }
                    }
                    else {
                        $('#uploadError').find('.msg').html('{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}');
                        $('#uploadError').removeClass('hidden');
                    }
                }
            });

            $('#uploadModal').on('hidden.bs.modal', function () {
                window.location.reload();
            })

            $('#uploadButton, #uploadText').bind('click', function(){
                $('#uploadFile').trigger('click');
            });

            $('#btn-delete').bind('click', function(){
                if (confirm('{{trans('_.Are you sure?')}}')){
                    $(this).attr('disabled', true);
                    $('#form-delete').submit();
                }
            });
        });
    });
})();
</script>
@endsection
