@extends('dashboard.layout')

@section('head')
<style>
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
<section id="main-content" class="hidden" ng-controller="add">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-8">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<a href="/dashboard/slides" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('slide.Edit Slide')}}</span>
							</div>
						</div>
                    </header>
                    <div class="panel-body">
                        @if(session()->has('eMessage'))
                        <div class="alert alert-danger fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('eMessage')}}
						</div>
                        @endif

						<?php
							if ($item->link_set == '1'){
								$link = ($item->link_internal == '1')? $config['url'] . $item->link: $item->link;
							}
							else {
								$link = '';
							}
						?>

                        <form class="form-horizontal tasi-form" method="post" action="{{$request->fullUrl()}}" name="form" id="form">
                            <div class="form-group" data-group="image">
                                <label class="col-sm-3 control-label">{{trans('_.Image')}}</label>
                                <div class="col-sm-9">
                                    <div class="input-group m-bot15">
        								<span class="input-group-btn">
        									<button class="btn btn-white" type="button" id="uploadButton">{{trans('_.Browse')}}</button>
        								</span>
        								<input type="text" class="form-control ui-browse" id="uploadText" style="background-color:#fff;cursor:pointer;" readonly>
        								<input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" id="uploadFile">
        								<img src="/static/dashboard/assets/img/process.gif" class="ui-process hidden" id="uploadProcess">
        							</div>
                                    <div class="m-bot15">
        								<span class="label label-danger">{{trans('_.Note')}}!</span>
        								<span>{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}</span>
        							</div>
                                    <div id="img-preview">
										<img src="/app/slide/{{$item->slideid}}/{{$item->imageid}}.png" class="img-thumbnail">
									</div>
								</div>
                            </div>

							<div class="form-group" data-group="link">
                                <label class="col-sm-3 control-label">{{trans('slide.URL link')}}</label>
                                <div class="col-sm-9">
									<textarea class="form-control" rows="1" name="link" data-plugin="autosize" style="max-width: 100%;">{!! $link !!}</textarea>
									<p class="help-block">
                                        <em>{{trans('slide.Can put a link on this site or a link to different sites.')}}</em>
                                    </p>
                                    <p class="help-block">
                                        <em>{{trans('_.Example')}} : {{$config['url']}}/our-story.html</em>
                                    </p>
								</div>
                            </div>

							<div class="form-group">
                                <label class="col-sm-3 control-label">{{trans('_.Publish')}}</label>
                                <div class="col-sm-9">
									<label class="checkbox-inline" style="padding-left: 0px;">
                                		<input type="radio" name="publish" value="yes" data-plugin="icheck" @if($item->publish == '1') checked @endif> {{trans('_.Yes')}}
									</label>
									<label class="checkbox-inline">
                                		<input type="radio" name="publish" value="no" data-plugin="icheck" @if($item->publish == '0') checked @endif> {{trans('_.No')}}
									</label>
								</div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger">{{trans('_.Save changes')}}</button>
                                    <input type="hidden" name="imageid" value="{{$item->imageid}}" id="ipt-imageid">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script>
app.controller('add', function($http, $window){
    $(function(){
		autosize($('[data-plugin=autosize]'));

        $('#form').bind('submit', function(e){
            $(this).find('[data-group]').removeClass('has-error');

            var link		= true,
                image		= true,
				iptLink		= $(this).find('textarea[name=link]');

            if (iptLink.val().trim() != '' && !validateUrl(iptLink.val().trim())){
	            $(this).find('[data-group=link]').addClass('has-error');
	            link = false;
	        }

			if ($('#ipt-imageid').val().trim() == ''){
				$(this).find('[data-group=image]').addClass('has-error');
				image = false;
			}

			if (link && image){
				$(this).find('button[type=submit]').attr('disabled', true);
				return true;
			}

            e.preventDefault();
        });

        $('#uploadFile').bind('change', function(e){
            if ($(this).val() != '' && e.target.files.length == 1)
            {
                var file = e.target.files[0];
                if ($.inArray(file.type.toLowerCase(), ['image/jpeg', 'image/gif', 'image/png']) >=  0)
                {
                    $('#uploadProcess').removeClass('hidden');
                    $('#uploadFile').attr('disabled', true);
                    $('#uploadText').val(file.name);

                    var formData = new FormData();
                    formData.append('image', file);
                    formData.append('_token', '{{csrf_token()}}');

                    $.ajax({
                        url: '/ajax/dashboard/slides/image',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        dataType: "JSON",
                        data: formData
                    })
                    .success(function(resp){
                        if (resp.status == 'ok'){
                            $('#form').find('[data-group=image]').removeClass('has-error');
                            $('#ipt-imageid').val(resp.payload.imageid);
                            var preview = $('#img-preview');
                            var img = $('<img />');
                            img.attr('src', '/app/slide/temp/'+resp.payload.imageid+'.png');
                            img.addClass('img-thumbnail');
                            img.bind('load', function(){
                                preview.html(img);
                                preview.removeClass('hidden');
                            });
                        }
                        else {
                            $('#form').find('[data-group=image]').addClass('has-error');
                            alert(resp.message);
                        }
                    })
                    .error(function(){
                        $('#form').find('[data-group=image]').addClass('has-error');
                        alert('{!! trans('error.image') !!}');
                        $window.location.reload();
                    })
                    .complete(function(){
                        $('#uploadProcess').addClass('hidden');
                        $('#uploadFile').attr('disabled', false);
                    });
                }
                else {
                    $('#form').find('[data-group=image]').addClass('has-error');
                    alert('{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}');
                }
            }
        });

        $('#uploadButton, #uploadText').bind('click', function(){
            $('#uploadFile').trigger('click');
        });
    });
});

function validateUrl(value) {
	return /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(value);
}
</script>
@endsection
