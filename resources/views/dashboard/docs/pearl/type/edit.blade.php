@extends('dashboard.layout')

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Form">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-9">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<a href="/dashboard/docs/pearltype/{{$type->typeid}}" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
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
                                                <input type="text" class="form-control" name="title[{{$locale['code']}}]" maxlength="128" autocomplete="off" data-input-title="{{$locale['code']}}" value="{{$type->getTitle($locale['code'])}}">
                                                <p class="help-block"><em>{{trans('_.Please enter all information in each language.')}}</em></p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>
                            <div class="form-group" data-group="detail">
                                <label class="col-sm-3 control-label">{{trans('_.Detail')}}</label>
                                <div class="col-sm-9">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#detail-{{$locale['code']}}" aria-controls="detail-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="detail-{{$locale['code']}}">
                                                <textarea class="form-control" rows="4" style="resize:none;" data-plugin="autosize" name="detail[{{$locale['code']}}]" data-input-detail="{{$locale['code']}}">{!! $type->getDetail($locale['code']) !!}</textarea>
                                                <p class="help-block"><em>{{trans('_.Please enter all information in each language.')}}</em></p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>
							<div class="form-group">
                                <label class="col-sm-3 control-label">{{trans('pearl.Main type')}}</label>
                                <div class="col-sm-9">
									<label class="checkbox-inline" style="padding-left:0px;">
                                		<input type="radio" name="main" value="yes" data-plugin="icheck" @if($type->main == '1') checked @endif> {{trans('_.Yes')}}
									</label>
									<label class="checkbox-inline">
                                		<input type="radio" name="main" value="no" data-plugin="icheck" @if($type->main == '0') checked @endif> {{trans('_.No')}}
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
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script>
(function(){
    app.controller('Form', function($scope, $log){
        $(function(){
            autosize($('[data-plugin=autosize]'));

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                autosize.update($('[data-plugin=autosize]'));
            });

            $('#form').bind('submit', function(e){
                $(this).find('[data-group]').removeClass('has-error');

                var title   = true,
                    detail  = true;

                $(this).find('input[data-input-title]').each(function(index, item){
                    if ($(item).val().trim() == ''){
                        title = false;
                    }
                });
                if (title == false){
                    $(this).find('[data-group=title]').addClass('has-error');
                }

                $(this).find('textarea[data-input-detail]').each(function(index, item){
                    if ($(item).val().trim() == ''){
                        detail = false;
                    }
                });
                if (detail == false){
                    $(this).find('[data-group=detail]').addClass('has-error');
                }

                if (title && detail){
                    $(this).find('button[type=submit]').attr('disabled', true);
                    return true;
                }

                e.preventDefault();
            });
        });
    });
})();
</script>
@endsection
