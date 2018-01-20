@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/lightslider/dist/css/lightslider.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/company.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-company" ng-class="{'xs':screen == 'xs'}">
    <div class="container story">

        <div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('_.Our story')}}</span>
                    </div>
                </div>
            </div>
        </div>

		<?php $str = $story->getDetail($config['lang']['code']) ?>

        <div class="row info">
            <div class="col-xs-12">
                <div class="col-md-7">
                    <div class="images">
                        <ul id="lightSlider">
                            @foreach($images as $image)
                            <li style="cursor: default;"><img src="/app/ourstory/{{$image->imageid}}.png" alt="{{$str}}"></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="detail">
						<?php $str = explode("\r\n", $str) ?>
                        @foreach($str as $line)
                        <div><span>{!! $line !!}</span></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
            </div>
        </div>

		<div class="row">
            <div class="col-xs-12">
				<div class="history-timeline">
					@foreach($timelines as $index => $timeline)
					<div class="item-block">
						<div class="year" ng-class="{'md': screen == 'md', 'sm': screen == 'sm', 'xs': screen == 'xs'}">
							<h4>
								@if($config['lang']['code'] == 'th')
									{{ (intval(dateTime($timeline->time, 'Y'))+543) }}
								@else
									{{dateTime($timeline->time, 'Y')}}
								@endif
							</h4>
						</div>
						<div class="item-content" ng-class="{'md': screen == 'md', 'sm': screen == 'sm', 'xs': screen == 'xs'}">
							<div class="item-badge">
	                            <a><i class="fa fa-circle"></i></a>
	                        </div>
							<div class="item-body">
								<div class="item-details">
									<?php
										$str = $timeline->getDetail($config['lang']['code']);
										$str = explode("\r\n", $str);
									?>
									@foreach($str as $line)
									<p><span>{!! $line !!}</span></p>
									@endforeach
								</div>
								<div class="item-images">
	                                @foreach($timeline->images as $image)
	                                <img src="/app/timeline/{{$timeline->timelineid}}/{{$image->imageid}}.png">
	                                @endforeach
	                            </div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					@endforeach
				</div>
			</div>
        </div>

    </div>
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/lightslider/dist/js/lightslider.min.js"></script>
<script>
$('#lightSlider').lightSlider({
    gallery: false,
    item: 1,
    loop: true,
    slideMargin: 0,
    auto: true,
    speed: 600,
    pager: false
});
</script>
@endsection
