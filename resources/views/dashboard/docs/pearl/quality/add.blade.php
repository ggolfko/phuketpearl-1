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
<section id="main-content" class="hidden" ng-controller="ContentController">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-10">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<a href="/dashboard/docs/pearlquality" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('_.Add New')}}</span>
							</div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height: calc(100vh - 150px);">
                        @if(session()->has('eMessage'))
                        <div class="alert alert-danger fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('eMessage')}}
						</div>
                        @endif
                        <form class="form-horizontal tasi-form" method="post" action="{{$request->fullUrl()}}" name="form" id="form">
							<div class="form-group" data-group="title">
                                <label class="col-sm-3 control-label">{{trans('_.Title')}}</label>
                                <div class="col-sm-9">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#title-{{$locale['code']}}" aria-controls="title-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="title-{{$locale['code']}}">
                                                <input type="text" class="form-control" name="title[{{$locale['code']}}]" maxlength="128" autocomplete="off" data-input-title="{{$locale['code']}}">
                                                <p class="help-block"><em>{{trans('_.Please enter all information in each language.')}}</em></p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group" data-group="details">
								<label class="col-sm-3 control-label">{{trans('_.Details')}}</label>
                                <div class="col-sm-9">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#details-{{$locale['code']}}" aria-controls="details-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="details-{{$locale['code']}}">
												<textarea rows="3" name="details[{{$locale['code']}}]" data-input-details="{{$locale['code']}}" class="form-control" data-plugin="autosize" style="resize: none;"></textarea>
												<p class="help-block"><em>{{trans('_.Please enter all information in each language.')}}</em></p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

							<div class="form-group" data-group="image">
								<label class="col-sm-3 control-label">{{trans('_.Image')}}</label>
                                <div class="col-sm-9">
                                    <div class="input-group m-bot15">
        								<span class="input-group-btn">
        									<button class="btn btn-white" type="button" id="uploadButton">{{trans('_.Browse')}}</button>
        								</span>
        								<input type="text" class="form-control ui-browse" id="uploadText" style="background-color:#fff;cursor:pointer;" placeholder='{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}' readonly>
        								<input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" id="uploadFile">
        								<img src="/static/dashboard/assets/img/process.gif" class="ui-process hidden" id="uploadProcess">
        							</div>
                                    <div class="hidden" id="img-preview"></div>
								</div>
                            </div>

							<div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger">{{trans('_.Add')}}</button>
                                    <input type="hidden" name="imageid" value="" id="ipt-imageid">
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
app.controller('ContentController', function($scope, $http, $window){
    $(function(){
		autosize($('[data-plugin=autosize]'));

		$('#form').bind('submit', function($event){
			$(this).find('[data-group]').removeClass('has-error');

            var image = true;

            if ($('#ipt-imageid').val().trim() == ''){
                $(this).find('[data-group=image]').addClass('has-error');
                image = false;
            }

            if (image){
                $(this).find('button[type=submit]').attr('disabled', true);
                return true;
            }

			$event.preventDefault();
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
                        url: '/ajax/dashboard/docs/pearlquality/image',
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
                            img.attr('src', '/app/pearlquality/'+resp.payload.imageid+'.png');
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
</script>
@endsection
