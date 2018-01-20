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
								<a href="/dashboard/docs/media-special-guests" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('_.Edit Item')}}</span>
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

							<div class="form-group" data-group="topic">
                                <label class="col-sm-3 control-label">{{trans('_.Topic')}}</label>
                                <div class="col-sm-9">
                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#topic-{{$locale['code']}}" aria-controls="topic-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="topic-{{$locale['code']}}">
                                                <input type="text" class="form-control" name="topic[{{$locale['code']}}]" maxlength="256" autocomplete="off" data-input-topic="{{$locale['code']}}"  value="{{$item->getTopic($locale['code'])}}">
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
<script>
$(function(){

    $('#form').bind('submit', function(e){
        $(this).find('[data-group]').removeClass('has-error');

        var topic = true;

        $(this).find('input[data-input-topic]').each(function(index, item){
            if ($(item).val().trim() == ''){
                topic = false;
            }
        });

        if (topic == false){
            $(this).find('[data-group=topic]').addClass('has-error');
        }

        if (topic){
            $(this).find('button[type=submit]').attr('disabled', true);
            return true;
        }

        e.preventDefault();
    });
});
</script>
@endsection
