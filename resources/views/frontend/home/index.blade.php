@extends('frontend.layout') @section('head')
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/jquery.camera.css" rel="stylesheet" type="text/css" media="all">
<link href="{{ $config['url'] }}/static/frontend/css/jquery.owl.carousel.css" rel="stylesheet" type="text/css" media="all">
<link href="{{ $config['url'] }}/static/frontend/css/animate.css" rel="stylesheet" type="text/css" media="all">
<link href="{{ $config['url'] }}/static/frontend/css/font.css" rel="stylesheet" type="text/css" media="all">
<link href="{{ $config['url'] }}/static/frontend/css/home.css?_t=1705092117" rel="stylesheet" type="text/css" media="all"> @endsection @section('content')
<link href="{{ $config['url'] }}/static/bower_components/opentip/css/opentip.css" rel="stylesheet" type="text/css">


<div class="hidden-xs">
	<div class="home-slider-wrapper">
		<div class="camera_wrap __loading" id="home-slider">
			@foreach($slides as $slide)
			<?php
				if ($slide->link_set == '1'){
					$link = ($slide->link_internal == '1')? $config['url'] . $slide->link: $slide->link;
				}
				else {
					$link = '';
				}
			?>
				<div data-src="/app/slide/{{$slide->slideid}}/{{$slide->imageid}}.png" data-link="{{$link}}"></div>
				@endforeach()
		</div>
	</div>
</div>
<div class="clearfix"></div>

	<div class="home-banner-wrapper">
		<div class="container">
			<div id="home-banner" class="text-center clearfix">
				<img class="pulse img-banner-caption" src="/static/images/logo-200-100.png" alt="With more than 40 years of experience on pearl farming. The knowledge of pearl farming and cultivation is inherited from our ancestor which passes down to new generation.">
				<div class="home-banner-caption">
					<p style="color: #000000;">
						With more than 40 years of experience on pearl farming.
						<br> The knowledge of pearl farming and cultivation is inherited from our ancestor which passes down to new generation.
					</p>
				</div>
			</div>
		</div>
	</div>
</div>


	
<div class="award">
	<img src="/static/frontend/images/home/award.jpg">
</div>
			


 @if($tours->count() > 0)
<div class="tour-widget" ng-controller="TourWidget">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<div class="booking-box">
					<h3>- Booking Tour -</h3>
					<div class="row packages @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-xs-12">
							<select ng-model="input.tour" ng-change="changed()" class="form-control">
								<option value="[[ tour.tourid ]]" ng-repeat="tour in tours">
									[[ tour.title_ ]]
								</option>
							</select>
						</div>
					</div>
			
					<hr>


					<div ng-if="tour && tour.price_type == 'person'" class="row detail @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-xs-12">
						<div class="col-xs-6"><h4>{{trans('_.Adult')}}</h4></div>
						<div class="col-xs-6"><h4>[[ tour.price_person_adult]] {{trans('_.TH฿/ticket')}}  </h4></div>
						</div>
						<div class="col-xs-12">
						<div class="col-xs-6"><h4>{{trans('_.Child')}} {{trans('tour.(Age 5-11)')}}</h4></div>
						<div class="col-xs-6"><h4>[[ tour.price_person_child]] {{trans('_.TH฿/ticket')}}</h4></div>
						</div>

						
						<div class="col-xs-12">
							<table>
								<tr>
									<td>{{trans('_.Includes:')}}</td>
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.Transport to and from your Phuket accommodation')}}</td>
									<td>&nbsp;</td>	
																										
								</tr>
								<tr>
									<td>- {{trans('_.Long Tail boat transfer')}}</td>
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.Guided Tour')}}</td>									
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.Snack Set')}}</td>									
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.Insurance')}}</td>									
									<td>&nbsp;</td>
								</tr> 

								<tr>
									<td><a href="/tours/[[tour.url]].html">{{trans('_.See More Information')}}</a></td>									
									<td>&nbsp;</td>
								</tr> 

							</table>
						</div>

		
						
					</div>
					

					<div ng-if="tour && tour.price_type == 'package'" class="row detail @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-xs-12">
						
						<div class="col-xs-4"><h4>{{trans('_.Price')}}</h4></div>
						<div class="col-xs-8"><h4>[[ tour.price_package ]] {{trans('_.TH฿/group ticket (max. 3 people)')}}</h4></div>
					
						</div>
						<div class="col-xs-12">
							<table>
								<tr>
									<td>{{trans('_.Includes:')}}</td>
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.Free choice of your selection transportation schedule')}}</td>
									<td>&nbsp;</td>	
																										
								</tr>

								<tr>
									<td>- {{trans('_.Private Transport to and from your Phuket accommodation')}}</td>
									<td>&nbsp;</td>	
																										
								</tr>
								<tr>
									<td>- {{trans('_.Private Long Tail boat transport')}}</td>
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.Guided Tour')}}</td>									
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.High Tea Set')}}</td>									
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.Phuket Pearl souvenir')}}</td>									
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.Insurance')}}</td>									
									<td>&nbsp;</td>
								</tr> 

								<tr>
									<td><a href="/tours/[[tour.url]].html">{{trans('_.See More Information')}}</a></td>									
									<td>&nbsp;</td>
									<br>
								</tr> 

							</table>
						</div>
						
					
						
										
					</div>

					
					<div ng-if="tour && tour.price_type == 'free'" class="row detail @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-xs-12">
						<div class="col-xs-6"><h4>{{trans('_.Price')}}</h4></div>
						<div class="col-xs-6"><h4> 0 {{trans('_.TH฿')}} ({{trans('_.Free Transfer')}})</h4></div>
						</div>

						<div class="col-xs-12">
							<table>
							<tr>
									<td>{{trans('_.Includes:')}}</td>
									<td>&nbsp;</td>
								</tr>

								<tr>
									<td>- {{trans('_.Transport to and from your Phuket accommodation')}}</td>
									<td>&nbsp;</td>	
																										
								</tr>
								
								<!-- <tr>
									<td>- {{trans('_.Guided about pearls')}}</td>									
									<td>&nbsp;</td>
								</tr> -->

								<!-- <tr>
									<td>- {{trans('_.Find out our boutique and showroom.')}}</td>									
									<td>&nbsp;</td>
								</tr> -->


								<tr>
									<td><a href="/tours/[[tour.url]].html">{{trans('_.See More Information')}}</a></td>									
									<td>&nbsp;</td>
								</tr> 

							</table>
						</div>


					
						
					</div>
					


					<div class="row form @if($config['lang']['code'] == 'th') th @endif">
						
						<div class="col-xs-6">
							<span class="ui-label">
								<i class="fa fa-calendar" aria-hidden="true"></i> {{trans('tour.Select date')}}</span>
							<input type="text" class="form-control" placeholder="(GMT+7) TH" data-plugin="datepicker" id="date">
						</div>
						<div class="col-xs-6">
							<span class="ui-label">
								<i class="fa fa-clock-o" aria-hidden="true"></i> {{trans('tour.Pick-up time')}}</span>
							<select class="form-control" ng-model="input.time" ng-change="changedTime()" id="time">
								<option ng-repeat="time in times" value="[[ time.value ]]">
									[[ time.text ]]
								</option>
							</select>
						</div>
					</div>




					<!-- start: person -->
					<div ng-if="tour && tour.price_type == 'person'" class="row form @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-xs-6">
							<span class="ui-label">
								<i class="fa fa-male" aria-hidden="true"></i> {{trans('_.Adult')}}</span>
							<div class="input-group group">
								<span class="input-group-addon" ng-click="decAdult()">-</span>
								<input type="text" class="form-control" ng-model="input.adults" readonly>
								<span class="input-group-addon" ng-click="incAdult()">+</span>
							</div>
						</div>
						<div class="col-xs-6">
							<span class="ui-label">
								<i class="fa fa-child" aria-hidden="true"></i>
								{{trans('_.Child')}}
								<span ng-if="tour.show_child_age == '1'">{{trans('tour.(Age 5-11)')}}</span>
							</span>
							<div class="input-group group">
								<span class="input-group-addon" ng-click="decChild()">-</span>
								<input type="text" class="form-control" ng-model="input.children" readonly>
								<span class="input-group-addon" ng-click="incChild()">+</span>
							</div>
						</div>
					</div>
					<div ng-if="tour && tour.price_type == 'person'" class="row calc @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-lg-12">
							<table>
								<tr class="total">
									<td>{{trans('_.Total')}}</td>
									<td>[[ input.total  ]] THB</td>
								</tr>
							</table>
						</div>
					</div>
					<!-- end: person -->


					<!-- start: package -->
					<div ng-if="tour && tour.price_type == 'package'" class="row form @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-xs-6">
							<span class="ui-label">
								<i class="fa fa-keyboard-o" aria-hidden="true"></i> {{trans('tour.Bundle ticket')}}</span>
							<div class="row">
								<div class="col-xs-12">
									<div class="input-group group">
										<span class="input-group-addon" ng-click="decPackage()">-</span>
										<input type="text" class="form-control" ng-model="input.packages" readonly>
										<span class="input-group-addon" ng-click="incPackage()">+</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<span class="ui-label">
								<i class="fa fa-user-plus" aria-hidden="true"></i> {{trans('tour.Extra visitors')}}</span>
							<select class="form-control" ng-model="input.extra" ng-change="changeExtra()" id="extra">
								<option ng-repeat="extra in tour.extras" value="[[ extra.extraid ]]">
									+[[ extra.number ]] (+[[ extra.price ]] THB)
								</option>
							</select>
						</div>
					</div>
					<div ng-if="tour && tour.price_type == 'package'" class="row calc @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-lg-12">
							<table>
								<tr class="total">
									<td>{{trans('_.Total')}}</td>
									<td>[[ input.total ]] THB</td>
								</tr>
							</table>
						</div>
					</div>
					<!-- end: package -->


					<!-- start: free -->
					<div ng-if="tour && tour.price_type == 'free'" class="row form @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-xs-6">
							<span class="ui-label">
								<i class="fa fa-male" aria-hidden="true"></i> {{trans('_.Adult')}}</span>
							<div class="input-group group">
								<span class="input-group-addon" ng-click="decAdult()">-</span>
								<input type="text" class="form-control" ng-model="input.adults" readonly>
								<span class="input-group-addon" ng-click="incAdult()">+</span>
							</div>
						</div>
						<div class="col-xs-6">
							<span class="ui-label">
								<i class="fa fa-child" aria-hidden="true"></i>
								{{trans('_.Child')}}
								<span ng-if="tour.show_child_age == '1'">{{trans('tour.(Age 5-11)')}}</span>
							</span>
							<div class="input-group group">
								<span class="input-group-addon" ng-click="decChild()">-</span>
								<input type="text" class="form-control" ng-model="input.children" readonly>
								<span class="input-group-addon" ng-click="incChild()">+</span>
							</div>
						</div>
					</div>
					<div ng-if="tour && tour.price_type == 'free'" class="row calc @if($config['lang']['code'] == 'th') th @endif">
						<div class="col-lg-12">
							<table>
								<tr class="total">
									<td>{{trans('_.Total')}}</td>
									<td> 0 THB</td>
								</tr>
							</table>
						</div>
					</div>
					<!-- end: free -->




					<div class="row">
						<div class="col-lg-12 book-now">
							<button ng-click="book()" class="btn btn-primary btn-lg" ng-disabled="booking">
								Book Now
							</button>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>
<div class="home-tour" ng-controller="Tour">
	<div class="container">
	<br><br>
		<div class="ui-tour-random row">
			<!-- <div class="col-xs-12 text-center">
				<div class="__head __light">
					<div class="__title {{$config['lang']['code']}}">{{trans('_.Booking Tour')}}</div>
					<img src="/static/images/home_line.png">
				</div>
			</div> -->
			@foreach($tours as $index => $tour)
			<?php $title_ = $tour->getTitle($config['lang']['code']) ?>
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow zoomIn">
				<div class="item @if($index == 3) visible-sm visible-xs @endif">
					@if($tour->new == '1')
					<div class="ribbon new">
						<span>NEW</span>
					</div>
					@elseif($tour->popular == '1')
					<div class="ribbon popular">
						<span>POPULAR</span>
					</div>
					@elseif($tour->recommend == '1')
					<div class="ribbon recommended">
						<span>RECOMMEND</span>
					</div>
					@endif
					<div class="images">
						<a href="/tours/{{$tour->url}}.html">
							<?php
                                $source = '/static/images/image-placeholder-622-415.png';

                                if ($tour->images->count() > 0){
                                    $image  = $tour->images->get(0);
                                    $source = "/app/tour/{$tour->tourid}/{$image->imageid}_t.png";
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
										@if($tour->price_type == 'package')
										<span class="amount">{{number_format($tour->price_package)}} THB</span>
										<span class="type">{{trans('tour.price/bundle ticket')}}</span>
										@elseif($tour->price_type == 'person')
										<span class="amount">{{number_format($tour->price_person_adult)}} THB</span>
										<span class="type">{{trans('tour.price/single ticket')}}</span>
										@elseif($tour->price_type == 'free')
										<span class="free">{{trans('tour.Free shuttle')}}</span>
										@endif
									</div>
								</div>
						</a>
						<div class="previews">
							<a href="#" ng-click="showTourPreview($event, '{{$tour->tourid}}')" alt="{{$title_}}">
								<i class="fa fa-picture-o" aria-hidden="true"></i>
							</a>
							@if($tour->images->count() > 0)
							<div class="tour-preview hidden" data-plugin="light-gallery" data-preview-tourid="{{$tour->tourid}}">
								@foreach($tour->images as $image)
								<a href="/app/tour/{{$tour->tourid}}/{{$image->imageid}}.png" data-sub-html="{!! $title_ !!}" alt="{{$title_}}">
									<img src="/app/tour/{{$tour->tourid}}/{{$image->imageid}}_t.png" class="img-responsive" alt="{{$title_}}">
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
			</div>
			@endforeach
		</div>
	</div>
</div>
<form action="{{$request->fullUrl()}}" method="post" class="hidden" id="checkoutForm">
    @if('[[tour.price_type]]' == 'person')
    <input type="hidden" name="adults" id="checkoutAdults">
    <input type="hidden" name="children" id="checkoutChildren">
    @elseif('[[tour.price_type]]' == 'package')
    <input type="hidden" name="packages" id="checkoutPackages">
	<input type="hidden" name="extra" id="checkoutExtra">
	 @elseif('[[tour.price_type]]' == 'free')
    <input type="hidden" name="adults" id="checkoutAdults">
    <input type="hidden" name="children" id="checkoutChildren">
    @endif
    <input type="hidden" name="date" id="checkoutDate">
	<input type="hidden" name="time" id="checkoutTime">
    <input type="hidden" name="total" id="checkoutTotal">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
@endif 
@if ($jewels->count() > 0)
<div class="home-popular-collections">
	<div class="container">
		<div class="group_home_collections row">
			<div class="col-xs-12 text-center">
				<div class="__head __light">
					<div class="__title {{$config['lang']['code']}}">{{trans('_.Collections')}}</div>
					<img src="/static/images/home_line.png">
				</div>
			</div>
			<div class="col-md-12">
				<div class="home_collections hidden">
					<div class="home_collections_wrapper">
						<div id="home_collections">
							@foreach($collections as $collection)
							<?php $title_ = $collection->getTitle($config['lang']['code']) ?>
							<div class="home_collections_item">
								<div class="home_collections_item_inner">
									<div class="collection-details">
										<a href="/jewels/{{$collection->url}}" rel="me" alt="{{$title_}}">
											<img src="/app/category/{{$collection->categoryid}}/{{$collection->imageid}}.png" alt="{{$title_}}">
										</a>
									</div>
									<div class="hover-overlay">
										<span class="col-name">
											<a href="/jewels/{{$collection->url}}" rel="me" alt="{{$title_}}">{{$title_}}</a>
										</span>
										<div class="collection-action">
											<a href="/jewels/{{$collection->url}}" class="{{$config['lang']['code']}}" rel="me" alt="{{$title_}}">{{trans('_.See the Collection')}}</a>
										</div>
									</div>
								</div>
							</div>
							@endforeach

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif @if($jewels->count() > 0)
<div class="home-newproduct home-jewels">
	<div class="container">
		<div class="group_home_products row">
			<div class="col-xs-12 text-center">
				<div class="__head">
					<div class="__title {{$config['lang']['code']}}">{{trans('_.Pearl Jewels')}}</div>
					<img src="/static/images/home_line.png">
				</div>
			</div>
			@foreach($jewels as $index => $jewel)
			<?php $title_ = $jewel->getTitle($config['lang']['code']) ?>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<div class="jewel-item">
					<a href="/jewels/{{$jewel->url}}.html" class="anchor" rel="me" alt="{{$title_}}">
						{{-- */ $source = '/static/images/product-not-image.jpg'; /* --}} @if($jewel->images->count() > 0) {{-- */ $image = $jewel->images()->where('cover',
						'1')->first(); /* --}} @if($image) {{-- */ $source = "/app/product/{$jewel->productid}/{$image->imageid}_t.png"; /*
						--}} @endif @endif
						<img src="{{$source}}" alt="{{$title_}}">
						<h4>{{$title_}}</h4>
					</a>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endif




@endsection @section('foot')
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-fullscreen.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script src="{{ $config['url'] }}/static/frontend/js/jquery.imagesloaded.min.js"></script>
<script src="{{ $config['url'] }}/static/frontend/js/jquery.easing.1.3.js"></script>
<script src="{{ $config['url'] }}/static/frontend/js/jquery.camera.min.js"></script>
<script src="{{ $config['url'] }}/static/frontend/js/modernizr.js"></script>
<script src="{{ $config['url'] }}/static/frontend/js/jquery.owl.carousel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/moment/moment.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/opentip.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/adapter-jquery.js"></script>
<script>
	app.controller('DeferImage', function ($scope, $log, $attrs, $element) {
		$scope.loaded = false;
		$scope.image = $('<img />', {
			src: $attrs.image,
			alt: $attrs.alt,
			class: 'transition'
		});
		$scope.image.bind('load', function () {
			$('.image-showing', $element).html($scope.image);
			$scope.loaded = true;
			$scope.$apply();
		});
	});

	app.controller('Tour', function ($scope) {
		$scope.showTourPreview = function ($event, tourid) {
			$('.tour-preview[data-preview-tourid=' + tourid + ']').first().find('a').first().click();
			$event.preventDefault();
		};
	});

	$(function () {
		$('[data-plugin=light-gallery]').lightGallery({
			download: false,
			counter: false,
			fullScreen: false,
			actualSize: false
		});

		if ($(window), innerWidth >= 1200) {
			var k = $(window).innerHeight() + 'px';
		} else {
			if ($(window), innerWidth >= 768) {
				var k = "50%";
			} else {
				var k = "30%";
			}
		}

		$('#home-slider').camera({
			height: k,
			playPause: false,
			pagination: false,
			autoAdvance: true,
			hover: false,
			time: 1000,
			fx: 'simpleFade',
			pauseOnClick: false,
			onLoaded: function () {
				$('.camera_wrap').removeClass('__loading');
			}
		});

		imagesLoaded('#home_collections', function () {
			$('.home_collections').removeClass('hidden');
			$("#home_collections").owlCarousel({
				navigation: false,
				pagination: false,
				autoPlay: true,
				stopOnHover: false,
				items: 4,
				itemsDesktop: [1199, 4],
				itemsDesktopSmall: [979, 3],
				itemsTablet: [768, 3],
				itemsTabletSmall: [540, 2],
				itemsMobile: [360, 1],
				scrollPerPage: true
			});
		});

		imagesLoaded('#home_awards', function () {
			$('.home_awards').removeClass('hidden');
			$("#home_awards").owlCarousel({
				navigation: false,
				pagination: false,
				autoPlay: true,
				stopOnHover: false,
				items: 5,
				itemsDesktop: [1199, 4],
				itemsDesktopSmall: [979, 3],
				itemsTablet: [768, 3],
				itemsTabletSmall: [540, 2],
				itemsMobile: [360, 1],
				scrollPerPage: true
			});
		});
	});
</script>
<script>
	app.controller('TourWidget', function($scope){
	$scope.alert = {};

	$scope.alert.date = new Opentip($('#date'), "{{trans('tour.Please book 24 hours in advance')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focus']});
	$scope.alert.time = new Opentip($('#time'), "{{trans('tour.Please book 24 hours in advance')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focus']});

	$scope.alert.date.show();
	$scope.alert.time.show();

	$scope.alert.date.hide();
	$scope.alert.time.hide();

	$scope.tours = [];
	$scope.times = [];
	$scope.extras = [];
	$scope.tour = null;
	$scope.booking = false;
	$scope.token = '{{csrf_token()}}';

	$scope.input = {
		tour: '',
		time: '',
		adults: 1,
		children: 0,
		total: 0,
		packages: 1,
		extra: undefined
	};

	// book now
	$scope.book = function(){
		$('#date, #time').removeClass('has-error');

		if ($('#date').val().trim() == '' || !$scope.input.time || $scope.input.time.trim() == '')
		{
			if ($('#date').val().trim() == '')
			{
				$('#date').addClass('has-error');
	            $('#date').focus();

				if (!$scope.input.time || $scope.input.time.trim() == ''){
					$('#time').addClass('has-error');
				}
			}
			else
			{
				if (!$scope.input.time || $scope.input.time.trim() == ''){
					$('#time').addClass('has-error');
					$('#time').focus();
				}
			}
        }
		else
		{
			var date = $('#date').val();
			var times = JSON.parse($scope.input.time);
			var startTime = times[0];
			var time = moment(date.trim() + ' ' + startTime, 'DD MMMM YYYY hh:mm A');
			var now = moment();
			var hours = time.diff(now, 'hours');

			if (hours > 23)
			{
				$('#date, #time').removeClass('has-error');

				$scope.alert.date.hide();
				$scope.alert.time.hide();

				var form = $('#checkoutForm');
				form.attr('action', '/tours/' + $scope.tour.url + '.html');

				var inputDate = $('<input />');
				inputDate.attr('name', 'date');
				inputDate.attr('type', 'hidden');
				inputDate.attr('value', moment(new Date(date)).format('YYYY-MM-DD'));
				form.append(inputDate);

				var inputTime = $('<input />');
				inputTime.attr('name', 'time');
				inputTime.attr('type', 'hidden');
				inputTime.attr('value', times.join(' - '));
				form.append(inputTime);

				var inputTotal = $('<input />');
				inputTotal.attr('name', 'total');
				inputTotal.attr('type', 'hidden');
				inputTotal.attr('value', $scope.input.total);
				form.append(inputTotal);

				var inputToken = $('<input />');
				inputToken.attr('name', '_token');
				inputToken.attr('type', 'hidden');
				inputToken.attr('value', $scope.token);
				form.append(inputToken);

				if ($scope.tour.price_type == 'person')
				{
					var inputAdults = $('<input />');
					inputAdults.attr('name', 'adults');
					inputAdults.attr('type', 'hidden');
					inputAdults.attr('value', $scope.input.adults);
					form.append(inputAdults);

					var inputChildren = $('<input />');
					inputChildren.attr('name', 'children');
					inputChildren.attr('type', 'hidden');
					inputChildren.attr('value', $scope.input.children);
					form.append(inputChildren);
				}

				if ($scope.tour.price_type == 'package')
				{
					var extra = false;

					if ($scope.input.extra)
					{
						angular.forEach($scope.extras, function(_extra){
							if (_extra._id == $scope.input.extra){
								extra = _extra;
							}
						});
					}

					var inputExtra = $('<input />');
					inputExtra.attr('name', 'extra');
					inputExtra.attr('type', 'hidden');
					inputExtra.attr('value', (extra? $scope.input.extra: ''));
					form.append(inputExtra);

					var inputPackage = $('<input />');
					inputPackage.attr('name', 'packages');
					inputPackage.attr('type', 'hidden');
					inputPackage.attr('value', $scope.input.packages);
					form.append(inputPackage);
				}

				if ($scope.tour.price_type == 'free')
				{
					var inputAdults = $('<input />');
					inputAdults.attr('name', 'adults');
					inputAdults.attr('type', 'hidden');
					inputAdults.attr('value', $scope.input.adults);
					form.append(inputAdults);

					var inputChildren = $('<input />');
					inputChildren.attr('name', 'children');
					inputChildren.attr('type', 'hidden');
					inputChildren.attr('value', $scope.input.children);
					form.append(inputChildren);
				}

				$scope.booking = true;
				form.submit();
			}
			else {
				$('#date, #time').addClass('has-error');

				$scope.alert.date.show();
				$scope.alert.time.show();
			}
        }
	};

	// changed tour
	$scope.changed = function(){
		$scope.alert.date.hide();
		$scope.alert.time.hide();

		$('#date, #time').removeClass('has-error');

		var tour = null;

		$scope.tours.forEach(function(tour_){
			if (tour_.tourid == $scope.input.tour){
				tour = tour_
			}
		});

		if (tour)
		{
			$scope.tour = tour

			var times = JSON.parse(tour.times);
			$scope.times = [];

			$scope.input.time		= '';
			$scope.input.adults		= 1;
			$scope.input.children	= 0;
			$scope.input.total		= 0;
			$scope.input.packages	= 1;
			$scope.input.extra		= undefined;

			if ($scope.tour.price_type == 'person')
			{
				$scope.input.total = ($scope.input.adults*$scope.tour.price_person_adult)+($scope.input.children*$scope.tour.price_person_child);
			}

			if ($scope.tour.price_type == 'package')
			{
				$scope.input.adults = $scope.tour.number_package_adult*$scope.input.packages;
				$scope.input.children = $scope.tour.number_package_child*$scope.input.packages;
				$scope.input.total = $scope.input.packages*$scope.tour.price_package;
			}

			$scope.extras = [];
			$scope.tour.extras.forEach(function(extra_){
				$scope.extras.push({
					id: extra_.id,
					_id: extra_.extraid,
					number: extra_.number,
					price: extra_.price
				});
			});

			times.forEach(function(time){
				if (typeof time.end == 'boolean')
				{
					$scope.times.push({
						value: JSON.stringify([time.start]),
						text: time.start
					});
				}
				else
				{
					$scope.times.push({
						value: JSON.stringify([time.start, time.end]),
						text: time.start + ' - ' + time.end
					});
				}
			});

			window.setDatesDisabled = function(e, init){
				var disabled_month = JSON.parse($scope.tour.disabled_days_month);

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
			};

			$('[data-plugin=datepicker]').datepicker('destroy');

			$('[data-plugin=datepicker]').datepicker({
				orientation: 'bottom left',
	            autoclose: true,
	            format: 'dd MM yyyy',
				startDate: new Date(),
				daysOfWeekDisabled: JSON.parse(tour.disabled_days_week),
				disableTouchKeyboard: true,
				keyboardNavigation: false,
				immediateUpdates: true,
				keepEmptyValues: true,
	        })
			.on('show', function(e) {
				setDatesDisabled(e);
			})
			.on('changeDate', function(e) {
				var date = $('#date').val();

				if (date.trim() != '' && $scope.input.time && $scope.input.time.trim() != '')
				{
					var times = JSON.parse($scope.input.time);
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

			$('input[type=hidden]', '#checkoutForm').each(function(index, input){
				$(input).remove()
			});
		}
	}

	// changed time
	$scope.changedTime = function(){
		var date = $('#date').val();

		if (date.trim() != '')
		{
			var times = JSON.parse($scope.input.time);
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

	$scope.decAdult = function(){
		if ($scope.tour && $scope.tour.price_type == 'free')
		{
			if ($scope.input.adults - 1 > 0){
	            $scope.input.adults--;
	        }
		}
		else if ($scope.tour && $scope.tour.price_type == 'person')
		{
			if ($scope.input.adults - 1 > 0){
	            $scope.input.adults--;
				$scope.input.total = ($scope.input.adults*$scope.tour.price_person_adult)+($scope.input.children*$scope.tour.price_person_child);
	        }
		}
    };
    $scope.incAdult = function(){
        if ($scope.tour && $scope.tour.price_type == 'free')
		{
			if ((($scope.input.adults + 1) + $scope.input.children) <= $scope.tour.maximum_guests){
	            $scope.input.adults++;
	        }
		}
		else if ($scope.tour && $scope.tour.price_type == 'person')
		{
			if ($scope.input.adults + 1 <= 100){
	            $scope.input.adults++;
	            $scope.input.total = ($scope.input.adults*$scope.tour.price_person_adult)+($scope.input.children*$scope.tour.price_person_child);
	        }
		}
    };
	$scope.decChild = function(){
		if ($scope.tour && $scope.tour.price_type == 'free')
		{
			if ($scope.input.children - 1 >= 0){
	            $scope.input.children--;
	        }
		}
		else if ($scope.tour && $scope.tour.price_type == 'person')
		{
			if ($scope.input.children - 1 >= 0){
	            $scope.input.children--;
				$scope.input.total = ($scope.input.adults*$scope.tour.price_person_adult)+($scope.input.children*$scope.tour.price_person_child);
	        }
		}
    };
    $scope.incChild = function(){
		if ($scope.tour && $scope.tour.price_type == 'free')
		{
			if ((($scope.input.children + 1) + $scope.input.adults) <= $scope.tour.maximum_guests){
	            $scope.input.children++;
	        }
		}
		else if ($scope.tour && $scope.tour.price_type == 'person')
		{
			if ($scope.input.children + 1 <= 100){
	            $scope.input.children++;
				$scope.input.total = ($scope.input.adults*$scope.tour.price_person_adult)+($scope.input.children*$scope.tour.price_person_child);
	        }
		}
    };
	$scope.decPackage = function(){
        if ($scope.tour && $scope.tour.price_type == 'package')
		{
			if ($scope.input.packages - 1 > 0)
			{
				var extra = false;

				if ($scope.input.extra)
				{
					angular.forEach($scope.extras, function(_extra){
						if (_extra._id == $scope.input.extra){
							extra = _extra;
						}
					});
				}

				$scope.input.packages--;
				$scope.input.adults = $scope.tour.number_package_adult*$scope.input.packages;
	            $scope.input.children = $scope.tour.number_package_child*$scope.input.packages;
	            $scope.input.total = $scope.input.packages*$scope.tour.price_package;

				if (extra)
				{
					$scope.input.total = $scope.input.total+extra.price;
				}
	        }
		}
    };
	$scope.incPackage = function(){
		if ($scope.tour && $scope.tour.price_type == 'package')
		{
			if ($scope.input.packages + 1 <= 50)
			{
				var extra = false;

				if ($scope.input.extra)
				{
					angular.forEach($scope.extras, function(_extra){
						if (_extra._id == $scope.input.extra){
							extra = _extra;
						}
					});
				}

	            $scope.input.packages++;
	            $scope.input.adults = $scope.tour.number_package_adult*$scope.input.packages;
	            $scope.input.children = $scope.tour.number_package_child*$scope.input.packages;
	            $scope.input.total = $scope.input.packages*$scope.tour.price_package;

				if (extra)
				{
					$scope.input.total = $scope.input.total+extra.price;
				}
			}
		}
	}
	$scope.changeExtra = function(){
		if ($scope.tour && $scope.tour.price_type == 'package')
		{
			var extra = false;

			if ($scope.input.extra)
			{
				angular.forEach($scope.extras, function(_extra){
					if (_extra._id == $scope.input.extra){
						extra = _extra;
					}
				});
			}

			$scope.input.adults = $scope.tour.number_package_adult*$scope.input.packages;
			$scope.input.children = $scope.tour.number_package_child*$scope.input.packages;
			$scope.input.total = $scope.input.packages*$scope.tour.price_package;

			if (extra)
			{
				$scope.input.total = $scope.input.total+extra.price;
			}
		}
	}

	// tour list
	@foreach($tours as $tour)
	var tour = {!! $tour->toJson() !!}

	tour.title_ = '{!! $tour->getTitle($config['lang']['code']) !!}';

	$scope.tours.push(tour)
	@endforeach

	if ($scope.tours.length > 0)
	{
		$scope.tour = $scope.tours[0]
		$scope.input.tour = $scope.tours[0].tourid
		$scope.changed()
	}

	$(function(){
		$('#date').bind('keydown', function(e){
			e.preventDefault();
		});

		$('[data-toggle="tooltip"]').tooltip();
	});
});
</script>

@endsection