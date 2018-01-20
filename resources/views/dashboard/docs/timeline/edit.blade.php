@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" />
@endsection

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
								<a href="/dashboard/docs/timeline/{{$timeline->timelineid}}" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('timeline.Edit Timeline')}}</span>
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
                            <div class="form-group" data-group="year">
                                <label class="col-sm-3 control-label">{{trans('_.Year')}}</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" name="year" class="form-control" style="background-color:#fff;cursor:pointer;" id="year" value="{{date("Y", strtotime($timeline->time))}}" readonly>
                                        <span class="input-group-btn">
                                            <button class="btn btn-white" type="button" id="year-btn"><i class="fa fa-calendar-check-o"></i></button>
                                        </span>
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
                                                <textarea class="form-control" rows="4" style="resize:none;" data-plugin="autosize" name="detail[{{$locale['code']}}]" data-input-detail="{{$locale['code']}}">{!! $timeline->getDetail($locale['code']) !!}</textarea>
                                                <p class="help-block"><em>{{trans('_.Please enter all information in each language.')}}</em></p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

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
<script src="/static/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script>
$(function(){
    autosize($('[data-plugin=autosize]'));

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        autosize.update($('[data-plugin=autosize]'));
    });

    $('#year').datepicker({
        autoclose: true,
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });

    $('#year-btn').bind('click', function(){
        $('#year').focus();
    });

    $('#form').bind('submit', function(e){
        $(this).find('[data-group]').removeClass('has-error');

        var detail  = true,
            year    = true;

        $(this).find('textarea[data-input-detail]').each(function(index, item){
            if ($(item).val().trim() == ''){
                detail = false;
            }
        });

        if (detail == false){
            $(this).find('[data-group=detail]').addClass('has-error');
        }
        if ($('#year').val().trim() == '' || !/^[0-9]+$/.test($('#year').val())){
            $(this).find('[data-group=year]').addClass('has-error');
            year = false;
        }

        if (detail && year){
            $(this).find('button[type=submit]').attr('disabled', true);
            return true;
        }

        e.preventDefault();
    });
});
</script>
@endsection
