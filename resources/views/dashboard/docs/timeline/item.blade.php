@extends('dashboard.layout')

@section('head')
<style>
.ui-title {
    margin-left: 10px;
    vertical-align: middle;
}
.image-slides {
    margin-bottom: 20px;
}
.image-slides img {
    max-width: 100%;
}
.content img {
    max-width: 100% !important;
}
.content p {
    width: 100%;
    margin-bottom: 10px;
}
.content span {
    line-height: 21px;
    font-size: 14px;
    padding-left: 19px;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-8">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-6">
								<a href="/dashboard/docs/timeline" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
                                <span class="ui-title">{{date("Y", strtotime($timeline->time))}}</span>
		                    </div>
                            <div class="col-md-6">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/dashboard/docs/timeline/{{$timeline->timelineid}}/images" class="btn btn-danger btn-sm">
										{{trans('timeline.Timeline Images')}}
									</a>
                                    <a href="/dashboard/docs/timeline/{{$timeline->timelineid}}/edit" class="btn btn-danger btn-sm">
										{{trans('_.Edit')}}
									</a>
								</form>
                            </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">

                        <div class="row">
                            <div class="col-lg-10">
                                <div class="content">
                                    <?php
                                        $str = $timeline->getDetail($config['lang']['code']);
                                        $str = explode("\r\n", $str);
                                    ?>
                                    @foreach($str as $line)
                                    <p><span>{!! $line !!}</span></p>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
$(function(){
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
</script>
@endsection
