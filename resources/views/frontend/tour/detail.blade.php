@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/tour.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/opentip/css/opentip.css" rel="stylesheet" type="text/css">
<style>
.jssora05l, .jssora05r {
    display: block;
    position: absolute;
    width: 40px;
    height: 40px;
    cursor: pointer;
    background: url('/static/bower_components/jssor-slider/img/a17.png') no-repeat;
    overflow: hidden;
}
.jssora05l { background-position: -10px -40px; }
.jssora05r { background-position: -70px -40px; }
.note-line {
	position: relative;
	padding-left: 15px;
}
.note-line::before {
	content: '*';
	font-size: 15px;
	position: absolute;
	width: 10px;
	height: 100%;
	top: 0;
	left: 0;
}
.style-ui-alert .opentip {
    padding: 7px 11px;
	max-width: 160px;
}
.style-ui-alert .ot-content {
    font-size: 11.5px;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif !important;
    color: #fff;
}
</style>
@endsection

@section('content')
<div class="ui-tour" ng-class="{'xs':screen == 'xs'}" ng-controller="form">
    <div class="container detail">
        <div class="row">
            <!-- main column -->
			<?php $title_ = $tour->getTitle($config['lang']['code']) ?>
            <div class="col-md-8 main">
                <div class="images">
                    <div class="top">
                        <div class="title">{!! $title_ !!}</div>
                    </div>

                    @if($tour->images->count() == 1)
                    <div class="defer-image" ng-controller="DeferImage" image="/app/tour/{{$tour->tourid}}/{{$tour->images->get(0)->imageid}}.png" alt="{{$title_}}">
                        <div class="image-showing">
                            <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$title_}}">
                        </div>
                        <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                    </div>
                    @elseif($tour->images->count() > 1)
                    <div id="slider" style="position: relative; top: 0px; left: 0px; width: 753px; height: 500px;">
                        <div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 753px; height: 500px;">
                            @foreach($tour->images as $index => $image)
                            <div class="defer-image" ng-controller="DeferImage" image="/app/tour/{{$tour->tourid}}/{{$image->imageid}}.png" alt="{{$title_}}">
                                <div class="image-showing">
                                    <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$title_}}">
                                </div>
                                <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                            </div>
                            @endforeach
                        </div>
                        <span data-u="arrowleft" class="jssora05l" style="top:0px;left:8px;width:40px;height:40px;" data-autocenter="2"></span>
                        <span data-u="arrowright" class="jssora05r" style="top:0px;right:8px;width:40px;height:40px;" data-autocenter="2"></span>
                    </div>
                    @else
                    <div class="defer-image" ng-controller="DeferImage" image="/static/images/image-placeholder-622-415.png" alt="{{$tour->getTitle($config['lang']['code'])}}">
                        <div class="image-showing">
                            <img src="/static/images/preload-622-415.jpg" class="holder">
                        </div>
                        <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                    </div>
                    @endif

                    <div class="bottom">
                        @if($tour->price_type == 'person')
                            <div class="price">{{number_format($tour->price_person_adult)}}</div>
                            <div class="price-type">
                                <div class="unit">THB</div>
                                <div class="type">{{trans('tour.price/single ticket')}}</div>
                            </div>
                        @elseif($tour->price_type == 'package')
                            <div class="price">{{number_format($tour->price_package)}}</div>
                            <div class="price-type">
                                <div class="unit">THB</div>
                                <div class="type">{{trans('tour.price/bundle ticket')}}</div>
                            </div>
						@elseif($tour->price_type == 'free')
                            <div class="free">{{trans('tour.Free shuttle')}}</div>
                        @endif
                    </div>
                </div>
                <div class="time">
                    <a href="{{ $config['url'] }}/tours"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                    Updated at {{$tour->updated_at->format('l, F d Y h:i A')}}
                </div>

                <hr>
                <div class="content">
                    {!! nl2br($tour->getDetail($config['lang']['code'])) !!}
                </div>

                @if($tour->map_enabled == '1')
                <div class="map">
                    <iframe
						class="map-frame"
						frameborder="0"
						width="100%"
						height="450px"
						src="{{$tour->map_src}}"
						allowfullscreen>
					</iframe>
                </div>
                @endif

                <?php
                    $highlight_arr  = unserialize($tour->getHighlight($config['lang']['code']));
                    $highlights     = explode(',', $highlight_arr);
                ?>
                @if(count($highlights) > 0 && $highlight_arr != '')
                <hr>
                <div class="row highlight">
                    <div class="col-md-3 head">{{trans('_.Highlight')}}</div>
                    <div class="col-md-9 text">
                        <ul>
                            @foreach($highlights as $highlight)
                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i> {{ $highlight }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <?php $note = $tour->getNote($config['lang']['code']); ?>
                @if($note && trim($note) != '')
				<?php $notes = explode("\n", $note); ?>
                <hr>
                <div class="row tour-note">
                    <div class="col-md-3 head">{{trans('_.Note')}}</div>
                    <div class="col-md-9 text">
						@foreach($notes as $line)
                        <div class="note-line">
							<span>
								{{$line}}
							</span>
						</div>
						@endforeach
                    </div>
                </div>
                @endif

                <?php $tags = $tour->getTags(); ?>
                @if($tags->count() > 0)
                <hr>
                <div class="row keywords">
                    <div class="col-md-3 head">{{trans('_.Keywords')}}</div>
                    <div class="col-md-9 text">
                        @foreach($tags as $map)
                            @if($map->tag)
                            <span class="label label-primary">{{$map->tag->text}}</span>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <!-- end: main column -->

            <!-- right column -->
            <div class="col-md-4">
                <div class="book">
                    <h3>- Booking -</h3>

                    @if($tour->price_type == 'package')
                    <div class="row price-type @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-xs-12">
							{{number_format($tour->price_package)}} THB/{{trans('tour.bundle ticket')}} ({{(intval($tour->number_package_adult)+intval($tour->number_package_child))}} {{trans('tour.passes')}})
						</div>
                    </div>
					<div class="row form @if($config['lang']['code'] == 'th') th @endif">
                        <hr>
                        <div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-calendar" aria-hidden="true"></i> {{trans('tour.Select date')}}</span>
                            <input type="text" class="form-control" placeholder="(GMT+7) TH" data-plugin="datepicker" id="date">
                        </div>
						<div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-clock-o" aria-hidden="true"></i> {{trans('tour.Pick-up time')}}</span>
                            <select class="form-control" ng-model="time" id="time" ng-change="changeTime()">
								@foreach(json_decode($tour->times) as $time)
								<?php
									if (!is_bool($time->end))
									{
										$timeText	= "{$time->start} - {$time->end}";
										$timeValue	= json_encode([$time->start, $time->end]);
									}
									else
									{
										$timeText	= $time->start;
										$timeValue	= json_encode([$time->start]);
									}
								?>
								<option value="{{$timeValue}}">{{$timeText}}</option>
								@endforeach
							</select>
                        </div>
                    </div>
                    <div class="row form @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-keyboard-o" aria-hidden="true"></i> {{trans('tour.Bundle ticket')}}</span>
							<div class="row">
								<div class="col-xs-12">
		                            <div class="input-group group">
		                                <span class="input-group-addon" ng-click="decPackage()">-</span>
		                                <input type="text" class="form-control" ng-model="packages" readonly>
		                                <span class="input-group-addon" ng-click="incPackage()">+</span>
		                            </div>
								</div>
							</div>
                        </div>
						<div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-user-plus" aria-hidden="true"></i> {{trans('tour.Extra visitors')}}</span>
                            <select class="form-control" ng-model="extra" id="extra" ng-change="changeExtra()">
								<option value="undefined"></option>
								@foreach($tour->extras as $extra)
								<option value="{{$extra->extraid}}">+{{$extra->number}} (+{{number_format($extra->price, 2)}} THB)</option>
								@endforeach
							</select>
                        </div>
                    </div>
                    <div class="row calc @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-lg-12">
                            <table>
                                <tr>
                                    <td>{{trans('tour.Number of buddle ticket')}}</td>
                                    <td>[[packages]]</td>
                                </tr>
                                <tr>
                                    <td>
										{{trans('tour.Adult/Child')}}
										@if($tour->show_child_age == '1')
										{{trans('tour.(Age 5-11)')}}
										@endif
									</td>
                                    <td>[[adults]]</td>
                                </tr>
								<tr class="hidden">
                                    <td>{{trans('_.Child')}} ({{trans('tour.Age 5-11')}})</td>
                                    <td>[[children]]</td>
                                </tr>
                                <tr>
                                    <td>{{trans('_.Calculate')}}</td>
                                    <td>[[packages]]x THB {{number_format($tour->price_package, 2)}}</td>
                                </tr>
                                <tr class="total">
                                    <td>{{trans('_.Total')}}</td>
                                    <td>[[total | number:2]] THB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @elseif($tour->price_type == 'person')
					<div class="row price-type @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-2">{{trans('tour.Price')}}</div>
						<div class="col-xs-10 text-right">{{number_format($tour->price_person_adult)}} THB/{{trans('tour.single ticket')}}</div>
                    </div>
                    <div class="row describe @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-6">{{trans('_.Adult')}}</div>
                        <div class="col-xs-6 text-right">{{number_format($tour->price_person_adult, 2)}} THB</div>
                    </div>
                    <div class="row describe @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-6">
							{{trans('_.Child')}}
							@if($tour->show_child_age == '1')
							{{trans('tour.(Age 5-11)')}}
							@endif
						</div>
                        <div class="col-xs-6 text-right">{{number_format($tour->price_person_child, 2)}} THB</div>
                    </div>
                    <div class="row form @if($config['lang']['code'] == 'th') th @endif">
                        <hr>
                        <div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-calendar" aria-hidden="true"></i> {{trans('tour.Select date')}}</span>
                            <input type="text" class="form-control" placeholder="(GMT+7) TH" data-plugin="datepicker" id="date">
                        </div>
						<div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-clock-o" aria-hidden="true"></i> {{trans('tour.Pick-up time')}}</span>
                            <select class="form-control" ng-model="time" id="time" ng-change="changeTime()">
								@foreach(json_decode($tour->times) as $time)
								<?php
									if (!is_bool($time->end))
									{
										$timeText	= "{$time->start} - {$time->end}";
										$timeValue	= json_encode([$time->start, $time->end]);
									}
									else
									{
										$timeText	= $time->start;
										$timeValue	= json_encode([$time->start]);
									}
								?>
								<option value="{{$timeValue}}">{{$timeText}}</option>
								@endforeach
							</select>
                        </div>
                    </div>
                    <div class="row form @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-male" aria-hidden="true"></i> {{trans('_.Adult')}}</span>
                            <div class="input-group group">
                                <span class="input-group-addon" ng-click="decAdult()">-</span>
                                <input type="text" class="form-control" ng-model="adults" readonly>
                                <span class="input-group-addon" ng-click="incAdult()">+</span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <span class="ui-label">
								<i class="fa fa-child" aria-hidden="true"></i>
								{{trans('_.Child')}}
								@if($tour->show_child_age == '1')
								{{trans('tour.(Age 5-11)')}}
								@endif
							</span>
                            <div class="input-group group">
                                <span class="input-group-addon" ng-click="decChild()">-</span>
                                <input type="text" class="form-control" ng-model="children" readonly>
                                <span class="input-group-addon" ng-click="incChild()">+</span>
                            </div>
                        </div>
                    </div>
                    <div class="row calc @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-lg-12">
                            <table>
                                <tr>
                                    <td>{{trans('_.Adult')}}</td>
                                    <td>[[adults]]</td>
                                </tr>
                                <tr>
                                    <td>
										{{trans('_.Child')}}
										@if($tour->show_child_age == '1')
										{{trans('tour.(Age 5-11)')}}
										@endif
									</td>
                                    <td>[[children]]</td>
                                </tr>
                                <tr>
                                    <td>{{trans('_.Calculate')}}</td>
                                    <td>[[adults]]x THB {{number_format($tour->price_person_adult, 2)}}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>[[children]]x THB {{number_format($tour->price_person_child, 2)}}</td>
                                </tr>
                                <tr class="total">
                                    <td>{{trans('_.Total')}}</td>
                                    <td>[[total | number:2]] THB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
					@elseif($tour->price_type == 'free')
					<div class="row price-type @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-12">{{trans('tour.MAXIMUM_GUESTS', ['number' => $tour->maximum_guests])}}</div>
                    </div>
                    <div class="row form @if($config['lang']['code'] == 'th') th @endif">
                        <hr>
                        <div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-calendar" aria-hidden="true"></i> {{trans('tour.Select date')}}</span>
                            <input type="text" class="form-control" placeholder="(GMT+7) TH" data-plugin="datepicker" id="date">
                        </div>
						<div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-clock-o" aria-hidden="true"></i> {{trans('tour.Pick-up time')}}</span>
                            <select class="form-control" ng-model="time" id="time" ng-change="changeTime()">
								@foreach(json_decode($tour->times) as $time)
								<?php
									if (!is_bool($time->end))
									{
										$timeText	= "{$time->start} - {$time->end}";
										$timeValue	= json_encode([$time->start, $time->end]);
									}
									else
									{
										$timeText	= $time->start;
										$timeValue	= json_encode([$time->start]);
									}
								?>
								<option value="{{$timeValue}}">{{$timeText}}</option>
								@endforeach
							</select>
                        </div>
                    </div>
                    <div class="row form @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-6">
                            <span class="ui-label"><i class="fa fa-male" aria-hidden="true"></i> {{trans('_.Adult')}}</span>
                            <div class="input-group group">
                                <span class="input-group-addon" ng-click="decAdult()">-</span>
                                <input type="text" class="form-control" ng-model="adults" readonly>
                                <span class="input-group-addon" ng-click="incAdult()">+</span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <span class="ui-label">
								<i class="fa fa-child" aria-hidden="true"></i>
								{{trans('_.Child')}}
								@if($tour->show_child_age == '1')
								{{trans('tour.(Age 5-11)')}}
								@endif
							</span>
                            <div class="input-group group">
                                <span class="input-group-addon" ng-click="decChild()">-</span>
                                <input type="text" class="form-control" ng-model="children" readonly>
                                <span class="input-group-addon" ng-click="incChild()">+</span>
                            </div>
                        </div>
                    </div>
                    <div class="row calc @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-lg-12">
                            <table>
                                <tr>
                                    <td>{{trans('_.Adult')}}</td>
                                    <td>[[adults]]</td>
                                </tr>
                                <tr>
                                    <td>
										{{trans('_.Child')}}
										@if($tour->show_child_age == '1')
										{{trans('tour.(Age 5-11)')}}
										@endif
									</td>
                                    <td>[[children]]</td>
                                </tr>
                                <tr class="total">
                                    <td>{{trans('_.Total')}}</td>
                                    <td>[[total | number:2]] THB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-12 book-now">
                            <button class="btn btn-primary btn-lg" ng-click="book()" ng-disabled="booking">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="randoms">
                    <div class="headline"><span>{{trans('tour.You may be interested')}}</span></div>
                    @foreach($randoms as $index => $random)
					<?php $title_ = $random->getTitle($config['lang']['code']) ?>
                    <div class="item">
                        @if($random->new == '1')
                        <div class="ribbon new"><span>NEW</span></div>
                        @elseif($random->popular == '1')
                        <div class="ribbon popular"><span>POPULAR</span></div>
                        @elseif($random->recommend == '1')
                        <div class="ribbon recommended"><span>RECOMMEND</span></div>
                        @endif
                        <div class="images">
                            <a href="/tours/{{$random->url}}.html">
                                <?php
                                    $source = '/static/images/image-placeholder-622-415.png';

                                    if ($random->images->count() > 0){
                                        $image  = $random->images->get(0);
                                        $source = "/app/tour/{$random->tourid}/{$image->imageid}_t.png";
                                    }
                                ?>
                                <div class="defer-image" ng-controller="DeferImage" image="{{$source}}" alt="{{$title_}}">
                                    <div class="image-showing">
                                        <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$title_}}">
                                    </div>
                                    <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                                </div>
                                <div class="description">
                                    <div class="price">
                                        @if($random->price_type == 'package')
                                        <span class="amount">{{number_format($random->price_package)}} THB</span>
                                        <span class="type">{{trans('tour.price/bundle ticket')}}</span>
                                        @elseif($random->price_type == 'person')
                                        <span class="amount">{{number_format($random->price_person_adult)}} THB</span>
                                        <span class="type">{{trans('tour.price/single ticket')}}</span>
										@elseif($random->price_type == 'free')
	                                    <span class="free">{{trans('tour.Free shuttle')}}</span>
	                                    @endif
                                    </div>
                                </div>
                            </a>
                            <div class="previews">
                                <a href="#" ng-click="showTourPreview($event, '{{$random->tourid}}')"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
                                @if($random->images->count() > 0)
                                <div class="tour-preview hidden" data-plugin="light-gallery" data-preview-tourid="{{$random->tourid}}">
                                    @foreach($random->images as $image)
                                    <a href="/app/tour/{{$random->tourid}}/{{$image->imageid}}.png" data-sub-html="{!! $title_ !!}" alt="{{$title_}}">
                                        <img src="/app/tour/{{$random->tourid}}/{{$image->imageid}}_t.png" class="img-responsive" alt="{{$title_}}">
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="info">
                            <div class="title">{!! str_limit($title_, $limit = 80, $end = '...') !!}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

				<div class="phone-contact">
                    <img src="/static/images/phone-contact.png">
                    <div class="text">{{trans('tour.Contact us')}}</div>
                    <div class="phone">{{$top_phone}}</div>
                    <div class="contact"><a href="/contactus.html" @if($config['lang']['code']) class="th" @endif>{{trans('tour.Contact us by other methods.')}}</a></div>
                </div>
            </div>
            <!-- end: right column -->
        </div>
    </div>
</div>

<form action="{{$request->fullUrl()}}" method="post" class="hidden" id="checkoutForm">
    @if($tour->price_type == 'person')
    <input type="hidden" name="adults" id="checkoutAdults">
    <input type="hidden" name="children" id="checkoutChildren">
    @elseif($tour->price_type == 'package')
    <input type="hidden" name="packages" id="checkoutPackages">
	<input type="hidden" name="extra" id="checkoutExtra">
	@elseif($tour->price_type == 'free')
    <input type="hidden" name="adults" id="checkoutAdults">
    <input type="hidden" name="children" id="checkoutChildren">
    @endif
    <input type="hidden" name="date" id="checkoutDate">
	<input type="hidden" name="time" id="checkoutTime">
    <input type="hidden" name="total" id="checkoutTotal">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/moment/moment.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/jssor-slider/js/jssor.slider.mini.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-fullscreen.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/opentip.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/adapter-jquery.js"></script>
<script>
app.controller('DeferImage', function($scope, $log, $attrs, $element){
    $scope.loaded = false;
    $scope.image = $('<img />', {
        src: $attrs.image,
        alt: $attrs.alt,
        class: 'transition'
    });
    $scope.image.bind('load', function(){
        $('.image-showing', $element).html($scope.image);
        $scope.loaded = true;
        $scope.$apply();
    });
});
app.controller('form', function($scope){
	$scope.alert = {};

	$scope.alert.date = new Opentip($('#date'), "{{trans('tour.Please book 24 hours in advance')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focus']});
	$scope.alert.time = new Opentip($('#time'), "{{trans('tour.Please book 24 hours in advance')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focus']});

	$scope.alert.date.show();
	$scope.alert.time.show();

	$scope.alert.date.hide();
	$scope.alert.time.hide();

    @if($tour->price_type == 'package')
    $scope.packages = 1;
    $scope.adults = {{intval($tour->number_package_adult)}}*$scope.packages;
    $scope.children = {{intval($tour->number_package_child)}}*$scope.packages;
    $scope.total = $scope.packages*{{floatval($tour->price_package)}};
    $scope.booking = false;

	$scope.extras = [];
	@foreach($tour->extras as $extra)
	$scope.extras.push({
		id: {{$extra->id}},
		_id: '{{$extra->extraid}}',
		number: {{$extra->number}},
		price: {{$extra->price}}
	});
	@endforeach
	$scope.extra = 'undefined';

	$scope.changeExtra = function(){
		var extra = false;

		if ($scope.extra)
		{
			angular.forEach($scope.extras, function(_extra){
				if (_extra._id == $scope.extra){
					extra = _extra;
				}
			});
		}

		$scope.adults = {{intval($tour->number_package_adult)}}*$scope.packages;
		$scope.children = {{intval($tour->number_package_child)}}*$scope.packages;
		$scope.total = $scope.packages*{{floatval($tour->price_package)}};

		if (extra)
		{
			$scope.total = $scope.total+extra.price;
		}
	}

    $scope.decPackage = function(){
        if ($scope.packages - 1 > 0)
		{
			var extra = false;

			if ($scope.extra)
			{
				angular.forEach($scope.extras, function(_extra){
					if (_extra._id == $scope.extra){
						extra = _extra;
					}
				});
			}

            $scope.packages--;
            $scope.adults = {{intval($tour->number_package_adult)}}*$scope.packages;
            $scope.children = {{intval($tour->number_package_child)}}*$scope.packages;
            $scope.total = $scope.packages*{{floatval($tour->price_package)}};

			if (extra)
			{
				$scope.total = $scope.total+extra.price;
			}
        }
    };
    $scope.incPackage = function(){
        if ($scope.packages + 1 <= 50)
		{
			var extra = false;

			if ($scope.extra)
			{
				angular.forEach($scope.extras, function(_extra){
					if (_extra._id == $scope.extra){
						extra = _extra;
					}
				});
			}

            $scope.packages++;
            $scope.adults = {{intval($tour->number_package_adult)}}*$scope.packages;
            $scope.children = {{intval($tour->number_package_child)}}*$scope.packages;
            $scope.total = $scope.packages*{{floatval($tour->price_package)}};

			if (extra)
			{
				$scope.total = $scope.total+extra.price;
			}
        }
    };
	$scope.changeTime = function(){
		var date = $('#date').val();

		if (date.trim() != '')
		{
			var times = JSON.parse($scope.time);
			var startTime = times[0];
			var time = moment(date.trim() + ' ' + startTime, 'DD MMMM YYYY hh:mm A');
			var now = moment();
			var hours = time.diff(now, 'hours');

			if (hours > 23)
			{
				$('#date, #time').removeClass('has-error');

				$scope.alert.date.hide();
				$scope.alert.time.hide();
			}
			else {
				$('#date, #time').addClass('has-error');

				$scope.alert.date.show();
				$scope.alert.time.show();
			}
		}
	};
    $scope.book = function(){
		$('#date, #time').removeClass('has-error');

        if ($('#date').val().trim() == '' || !$scope.time || $scope.time.trim() == '')
		{
			if ($('#date').val().trim() == '')
			{
				$('#date').addClass('has-error');
	            $('#date').focus();

				if (!$scope.time || $scope.time.trim() == ''){
					$('#time').addClass('has-error');
				}
			}
			else
			{
				if (!$scope.time || $scope.time.trim() == ''){
					$('#time').addClass('has-error');
					$('#time').focus();
				}
			}
        }
        else
		{
            var date = $('#date').val();
			var times = JSON.parse($scope.time);
			var startTime = times[0];
			var time = moment(date.trim() + ' ' + startTime, 'DD MMMM YYYY hh:mm A');
			var now = moment();
			var hours = time.diff(now, 'hours');

			if (hours > 23)
			{
				$('#date, #time').removeClass('has-error');

				$scope.alert.date.hide();
				$scope.alert.time.hide();

				var extra = false;
				if ($scope.extra)
				{
					angular.forEach($scope.extras, function(_extra){
						if (_extra._id == $scope.extra){
							extra = _extra;
						}
					});
				}
				if (extra) {
					$('#checkoutExtra').val($scope.extra);
				}
				else {
					$('#checkoutExtra').val('');
				}

				$scope.booking = true;
				$('#checkoutPackages').val( $scope.packages );
	            $('#checkoutTotal').val( $scope.total );
	            $('#checkoutDate').val( moment(new Date(date)).format('YYYY-MM-DD') );
				$('#checkoutTime').val( times.join(' - ') );
	            $('#checkoutForm').submit();
			}
			else {
				$('#date, #time').addClass('has-error');

				$scope.alert.date.show();
				$scope.alert.time.show();
			}
        }
    };
    @elseif($tour->price_type == 'person')
    $scope.adults = 1;
    $scope.children = 0;
    $scope.total = ($scope.adults*{{floatval($tour->price_person_adult)}})+($scope.children*{{floatval($tour->price_person_child)}});

    $scope.decAdult = function(){
        if ($scope.adults - 1 > 0){
            $scope.adults--;
            $scope.total = ($scope.adults*{{floatval($tour->price_person_adult)}})+($scope.children*{{floatval($tour->price_person_child)}});
        }
    };
    $scope.incAdult = function(){
        if ($scope.adults + 1 <= 100){
            $scope.adults++;
            $scope.total = ($scope.adults*{{floatval($tour->price_person_adult)}})+($scope.children*{{floatval($tour->price_person_child)}});
        }
    };
    $scope.decChild = function(){
        if ($scope.children - 1 >= 0){
            $scope.children--;
            $scope.total = ($scope.adults*{{floatval($tour->price_person_adult)}})+($scope.children*{{floatval($tour->price_person_child)}});
        }
    };
    $scope.incChild = function(){
        if ($scope.children + 1 <= 100){
            $scope.children++;
            $scope.total = ($scope.adults*{{floatval($tour->price_person_adult)}})+($scope.children*{{floatval($tour->price_person_child)}});
        }
    };
	$scope.changeTime = function(){
		var date = $('#date').val();

		if (date.trim() != '')
		{
			var times = JSON.parse($scope.time);
			var startTime = times[0];
			var time = moment(date.trim() + ' ' + startTime, 'DD MMMM YYYY hh:mm A');
			var now = moment();
			var hours = time.diff(now, 'hours');

			if (hours > 23)
			{
				$('#date, #time').removeClass('has-error');

				$scope.alert.date.hide();
				$scope.alert.time.hide();
			}
			else {
				$('#date, #time').addClass('has-error');

				$scope.alert.date.show();
				$scope.alert.time.show();
			}
		}
	};
    $scope.book = function(){
		$('#date, #time').removeClass('has-error');

        if ($('#date').val().trim() == '' || !$scope.time || $scope.time.trim() == '')
		{
			if ($('#date').val().trim() == '')
			{
				$('#date').addClass('has-error');
	            $('#date').focus();

				if (!$scope.time || $scope.time.trim() == ''){
					$('#time').addClass('has-error');
				}
			}
			else
			{
				if (!$scope.time || $scope.time.trim() == ''){
					$('#time').addClass('has-error');
					$('#time').focus();
				}
			}
        }
        else
		{
			var date = $('#date').val();
			var times = JSON.parse($scope.time);
			var startTime = times[0];
			var time = moment(date.trim() + ' ' + startTime, 'DD MMMM YYYY hh:mm A');
			var now = moment();
			var hours = time.diff(now, 'hours');

			if (hours > 23)
			{
				$('#date, #time').removeClass('has-error');

				$scope.alert.date.hide();
				$scope.alert.time.hide();

				$scope.booking = true;
				$('#checkoutAdults').val( $scope.adults );
				$('#checkoutChildren').val( $scope.children );
				$('#checkoutTotal').val( $scope.total );
				$('#checkoutDate').val( moment(new Date(date)).format('YYYY-MM-DD') );
				$('#checkoutTime').val( times.join(' - ') );
				$('#checkoutForm').submit();
			}
			else {
				$('#date, #time').addClass('has-error');

				$scope.alert.date.show();
				$scope.alert.time.show();
			}
        }
    };
	@elseif($tour->price_type == 'free')
    $scope.adults = 1;
    $scope.children = 0;
    $scope.total = 0;

    $scope.decAdult = function(){
        if ($scope.adults - 1 > 0){
            $scope.adults--;
        }
    };
    $scope.incAdult = function(){
        if ((($scope.adults + 1) + $scope.children) <= {{$tour->maximum_guests}}){
            $scope.adults++;
        }
    };
    $scope.decChild = function(){
        if ($scope.children - 1 >= 0){
            $scope.children--;
        }
    };
    $scope.incChild = function(){
        if ((($scope.children + 1) + $scope.adults) <= {{$tour->maximum_guests}}){
            $scope.children++;
        }
    };
	$scope.changeTime = function(){
		var date = $('#date').val();

		if (date.trim() != '')
		{
			var times = JSON.parse($scope.time);
			var startTime = times[0];
			var time = moment(date.trim() + ' ' + startTime, 'DD MMMM YYYY hh:mm A');
			var now = moment();
			var hours = time.diff(now, 'hours');

			if (hours > 23)
			{
				$('#date, #time').removeClass('has-error');

				$scope.alert.date.hide();
				$scope.alert.time.hide();
			}
			else {
				$('#date, #time').addClass('has-error');

				$scope.alert.date.show();
				$scope.alert.time.show();
			}
		}
	};
    $scope.book = function(){
		$('#date, #time').removeClass('has-error');

        if ($('#date').val().trim() == '' || !$scope.time || $scope.time.trim() == '')
		{
			if ($('#date').val().trim() == '')
			{
				$('#date').addClass('has-error');
	            $('#date').focus();

				if (!$scope.time || $scope.time.trim() == ''){
					$('#time').addClass('has-error');
				}
			}
			else
			{
				if (!$scope.time || $scope.time.trim() == ''){
					$('#time').addClass('has-error');
					$('#time').focus();
				}
			}
        }
        else
		{
			var date = $('#date').val();
			var times = JSON.parse($scope.time);
			var startTime = times[0];
			var time = moment(date.trim() + ' ' + startTime, 'DD MMMM YYYY hh:mm A');
			var now = moment();
			var hours = time.diff(now, 'hours');

			if (hours > 23)
			{
				$('#date, #time').removeClass('has-error');

				$scope.alert.date.hide();
				$scope.alert.time.hide();

				$scope.booking = true;
				$('#checkoutAdults').val( $scope.adults );
				$('#checkoutChildren').val( $scope.children );
				$('#checkoutTotal').val( $scope.total );
				$('#checkoutDate').val( moment(new Date(date)).format('YYYY-MM-DD') );
				$('#checkoutTime').val( times.join(' - ') );
				$('#checkoutForm').submit();
			}
			else {
				$('#date, #time').addClass('has-error');

				$scope.alert.date.show();
				$scope.alert.time.show();
			}
        }
    };
    @endif

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    $(function(){
		$('#date, #time').bind('focus', function(){
			$scope.alert.date.hide();
			$scope.alert.time.hide();
		});

		$('#date').bind('keydown', function(e){
			e.preventDefault();
		});

        $('[data-toggle="tooltip"]').tooltip();

		window.setDatesDisabled = function(e, init){
			var disabled_month = {!! $tour->disabled_days_month !!};

			if (typeof e.date != 'undefined' || init)
			{
				var _date		= init? moment(): moment(e.date);
				var _year		= _date.format('YYYY');
				var _disabled	= [];

				for (var i = 1; i <= 12; i++)
				{
					var _month_int	= i < 10? ('0'+i): i.toString();
					var _first_date	= _year + '-' + _month_int + '-01';

					if (disabled_month.indexOf( i.toString() ) > -1)
					{
						var _day	= moment(_first_date, 'YYYY-MM-DD');
						var _days	= _day.daysInMonth() - 1;
						var _month	= _day.startOf('month').add(-1, 'days');

						for (var j = 0; j <= _days; j++){
							_disabled.push( _month.add(1, 'days').format('DD-MM-YYYY') );
						}
					}
				}

				$('[data-plugin=datepicker]').datepicker('setDatesDisabled', _disabled);
			}
		}

		$('[data-plugin=datepicker]').datepicker({
			orientation: 'bottom left',
            autoclose: true,
            format: 'dd MM yyyy',
			startDate: new Date(),
			daysOfWeekDisabled: {!! $tour->disabled_days_week !!},
			disableTouchKeyboard: true,
			keyboardNavigation: false,
			immediateUpdates: true,
			keepEmptyValues: true,
        })
		.on('hide', function(e) {
			if (typeof e.date != 'undefined')
			{
				var disabled_week	= {!! $tour->disabled_days_week !!};
				var disabled_month	= {!! $tour->disabled_days_month !!};
				var _date	= moment(e.date);
				var _month	= _date.format('M');
				var _week	= _date.format('e');

				if (
					(disabled_week.indexOf( _week ) > -1) ||
					(disabled_month.indexOf( _month ) > -1)
				){
					$('#date').val('');
				}
			}
		})
		.on('show', function(e) {
			setDatesDisabled(e);
		})
		.on('changeDate', function(e) {
			var date = $('#date').val();

			if (date.trim() != '' && $scope.time && $scope.time.trim() != '')
			{
				var times = JSON.parse($scope.time);
				var startTime = times[0];
				var time = moment(date.trim() + ' ' + startTime, 'DD MMMM YYYY hh:mm A');
				var now = moment();
				var hours = time.diff(now, 'hours');

				if (hours > 23)
				{
					$('#date, #time').removeClass('has-error');
				}
				else {
					$('#date, #time').addClass('has-error');

					$scope.alert.date.show();
					$scope.alert.time.show();
				}
			}

			setDatesDisabled(e);
		})
		.on('changeMonth', function(e) {
			setDatesDisabled(e);
		})
		.on('changeYear', function(e) {
			setDatesDisabled(e);
		})
		.on('changeDecade', function(e) {
			setDatesDisabled(e);
		})
		.on('changeCentury', function(e) {
			setDatesDisabled(e);
		});

		setDatesDisabled([], true);

        $('[data-plugin=light-gallery]').lightGallery({
            download: false,
            counter: false,
            fullScreen: false,
            actualSize: false
        });

        @if($tour->images->count() > 0)
        var options = {
            $AutoPlay: true ,
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            }
        };
        var jssor_slider = new $JssorSlider$('slider', options);

        function ScaleSlider() {
            var refSize = jssor_slider.$Elmt.parentNode.clientWidth;
            if (refSize) {
                refSize = Math.min(refSize, 753);
                jssor_slider.$ScaleWidth(refSize);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }
        ScaleSlider();
        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        @endif
    });

    $scope.showTourPreview = function($event, tourid){
        $('.tour-preview[data-preview-tourid='+tourid+']').first().find('a').first().click();
        $event.preventDefault();
    };
});
</script>
@endsection
