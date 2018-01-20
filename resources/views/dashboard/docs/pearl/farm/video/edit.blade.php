@extends('dashboard.layout')

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-8">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<a href="/dashboard/docs/pearlfarm/videos" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('video.Edit Video')}}</span>
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
                                                <input type="text" class="form-control" name="title[{{$locale['code']}}]" maxlength="128" autocomplete="off" data-input-title="{{$locale['code']}}" value="{{$video->getTitle($locale['code'])}}">
                                                <p class="help-block"><em>{{trans('_.Please enter all information in each language.')}}</em></p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>
                            <div class="form-group" data-group="youtube">
                                <label class="col-sm-3 control-label">Youtube link</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="youtube" autocomplete="off" value="{!! $video->youtube !!}">
                                    <p class="help-block"><em>{{trans('_.Example')}} : https://www.youtube.com/watch?v=fmAEiuuoc_0</em></p>
                                </div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{trans('_.Publish')}}</label>
                                <div class="col-sm-9">
									<label class="checkbox-inline" style="padding-left:0px;">
                                		<input type="radio" name="publish" value="yes" data-plugin="icheck" @if($video->publish == '1') checked @endif> {{trans('_.Yes')}}
									</label>
									<label class="checkbox-inline">
                                		<input type="radio" name="publish" value="no" data-plugin="icheck" @if($video->publish == '0') checked @endif> {{trans('_.No')}}
									</label>
								</div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger">{{trans('_.Save changes')}}</button>
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
<script>
$(function(){
    $('#form').bind('submit', function(e){
        $(this).find('[data-group]').removeClass('has-error');

        var title = true, youtube = true,
            iptYt = $(this).find('input[name=youtube]');

        $(this).find('input[data-input-title]').each(function(index, item){
            if ($(item).val().trim() == ''){
                title = false;
            }
        });

        if (title == false){
            $(this).find('[data-group=title]').addClass('has-error');
        }

        if (iptYt.val() == '' || !/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((.|-){11})(?:\S+)?$/.test(iptYt.val())){
            $(this).find('[data-group=youtube]').addClass('has-error');
            youtube = false;
        }

        if (title && youtube){
            $(this).find('button[type=submit]').attr('disabled', true);
            return true;
        }

        e.preventDefault();
    });
});
</script>
@endsection
