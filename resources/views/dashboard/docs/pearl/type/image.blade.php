@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen">
<link rel="stylesheet" href="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen">
<style>
.ui-item {
    margin-bottom: 10px;
}
.ui-caption {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 14px;
    padding-top: 8px;
    color: #333;
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
<section id="main-content" class="hidden" ng-controller="Images">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-6">
								<a href="/dashboard/docs/pearltype/{{$type->typeid}}" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
		                    </div>
                            <div class="col-md-6">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#uploadModal">
										{{trans('_.Upload Images')}}
									</button>
								</form>
                            </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">
                        <div class="row">
                            @foreach($type->images as $item)
                            <div class="col-sm-4 ui-item" ng-controller="Item" ng-class="{'hidden':deleted}" id="item-{{$item->imageid}}">
                                <a href="/app/pearltype/{{$type->typeid}}/{{$item->imageid}}.png" class="fancybox" rel="gallery">
                                    <img src="/app/pearltype/{{$type->typeid}}/{{$item->imageid}}_t.png" class="img-responsive">
                                </a>
                                <p class="ui-caption">
                                    <input type="radio" name="main" value="{{$item->imageid}}" data-id="{{$item->id}}" @if($item->id == $type->main_id) checked @endif> {{trans('pearl.Set as main image')}}
                                    <button type="button" class="btn btn-xs btn-danger pull-right" ng-disabled="deleting" ng-click="delete({{$item->id}},'{{$item->imageid}}')">{{trans('_.Delete')}}</button>
                                </p>
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
				<h5 class="modal-title">{{trans('_.Upload Images')}}</h5>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					{{trans('gallery.You can upload up to 10 files at a time and the size of the photo must be larger than the recommended 650px x 420px.')}}
				</div>
				<div class="alert alert-success fade in hidden" id="uploadSuccess">
					{{trans('gallery.Upload photos successfully.')}}
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
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.js"></script>
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
(function(){
    app.controller('Item', function($scope, $http, $window){
        $scope.delete = function(id, imageid){
            if (confirm('{{trans('_.Are you sure?')}}'))
            {
                $scope.deleting = true;
                $http.post('/ajax/dashboard/docs/pearltype/{{$type->typeid}}/'+imageid, {
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
                    $window.location.reload();
                })
                .finally(function(){
                    $scope.deleting = false;
                });
            }
        };
    });

    app.controller('Images', function($scope, $http, $window){

        $('#uploadModal').on('hidden.bs.modal', function () {
            window.location.reload();
        });

        $('#uploadButton, #uploadText').bind('click', function(){
            $('#uploadFile').trigger('click');
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

        $('input[name="main"]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        })
        .on('ifChecked', function(event){
            $http.post('/ajax/dashboard/docs/pearltype/{{$type->typeid}}/main', {
                id: $(this).attr('data-id'),
                imageid: $(this).val()
            })
            .success(function(resp){
                if (resp.status != 'ok'){
                    alert(resp.message);
                    $window.location.reload();
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
                $window.location.reload();
            });
        });

        $('#btn-delete').bind('click', function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $(this).attr('disabled', true);
                $('#form-delete').submit();
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
                            url: '/ajax/dashboard/docs/pearltype/{{$type->typeid}}/upload',
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
							$('#uploadFile').val('');
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
