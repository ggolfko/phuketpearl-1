@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/opentip/css/opentip.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/angular-animate-css/build/nga.all.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
@if($product->hook_status == '1')
<link href="{{ $config['url'] }}/static/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/iCheck/skins/square/square.css" rel="stylesheet" type="text/css">
@endif
<link href="{{ $config['url'] }}/static/frontend/css/jewels.css?_t=1705170036" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-jewels" ng-class="{'xs':screen == 'xs'}" ng-controller="Product">
    <div class="container product">

        <div class="row">
            <div class="col-xs-12">
                <div class="head" ng-class="{'xs':screen == 'xs'}">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{$name}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="images">
                    <div class="row">
                        <div class="col-xs-3 col-sm-2">
                            <div class="thumbs" ng-controller="Thumbs" id="ui-thumbs">
                                <a href="#" class="arrow-up hidden" ng-click="up($event)"><i class="ion-ios-arrow-up"></i></a>
                                <div class="list minimize">
                                    <div class="items" ng-class="{'nopointer':images.length <= appear}">
                                        <a href="#" class="thumb" ng-repeat="image in images track by $index" ng-click="showImage($event, $index, image)" ng-class="{'focus': display.imageid == image.imageid}" ng-controller="DeferImageThumb" alt="{{$name}}">
                                            <div class="defer-image" alt="{{$name}}">
                                                <div class="image-showing">
                                                    <img src="/static/images/preload-600-600.jpg" class="holder" alt="{{$name}}">
                                                </div>
                                                <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <a href="#" class="arrow-down hidden" ng-click="down($event)"><i class="ion-ios-arrow-down"></i></a>
                            </div>
                        </div>
                        <div class="col-xs-9 col-sm-10">
                            <div class="display">
                                <a href="#" ng-repeat="image in images track by $index" ng-click="showFullImage($event)" ng-controller="DeferImageDisplay" ng-show="display.imageid == image.imageid" ng-class="{'hidden':display.imageid != image.imageid}" alt="{{$name}}">
                                    <div class="defer-image">
                                        <div class="image-showing">
                                            <img src="/static/images/preload-622-415.jpg" class="holder" alt="{{$name}}">
                                        </div>
                                        <div class="is-loading" ng-class="{'hidden':loaded}"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info">
                    <div class="row text">
                        <div class="col-xs-4">{{trans('jewel.Code')}} :</div>
                        <div class="col-xs-8">{{$product->code}}</div>
                    </div>

                    <?php $data = $product->getPearltype($config['lang']['code']); ?>
                    @if(trim($data) != '')
                    <div class="row text">
                        <div class="col-xs-4">{{trans('jewel.Pearl Type')}} :</div>
                        <div class="col-xs-8">{!! nl2br($data) !!}</div>
                    </div>
                    @endif

                    <?php $data = $product->getBodytype($config['lang']['code']); ?>
                    @if(trim($data) != '')
                    <div class="row text">
                        <div class="col-xs-4">{{trans('jewel.Colour')}} :</div>
                        <div class="col-xs-8">{!! nl2br($data) !!}</div>
                    </div>
                    @endif

                    <?php $data = $product->getPearlsize($config['lang']['code']); ?>
                    @if(trim($data) != '')
                    <div class="row text">
                        <div class="col-xs-4">{{trans('jewel.Size')}} :</div>
                        <div class="col-xs-8">{!! nl2br($data) !!}</div>
                    </div>
                    @endif

                    <?php $data = $product->getMaterials($config['lang']['code']); ?>
                    @if(trim($data) != '')
                    <div class="row text">
                        <div class="col-xs-4">{{trans('jewel.Material')}} :</div>
                        <div class="col-xs-8">{!! nl2br($data) !!}</div>
                    </div>
                    @endif

                    <?php $data = $product->getMoredetails($config['lang']['code']); ?>
                    @if(trim($data) != '')
                    <div class="row text">
                        <div class="col-xs-4">{{trans('jewel.Description')}} :</div>
                        <div class="col-xs-8">{!! nl2br($data) !!}</div>
                    </div>
                    @endif

                    <div class="contact">
                        <a href="#" ng-click="makeEnquiry($event)"><i class="ion-clipboard"></i><span>{{trans('product.Make an enquiry')}}</span></a>
                        <a href="/contactus.html"><i class="ion-reply-all"></i><span>{{trans('_.Contact us')}}</span></a>
                    </div>
                </div>

				@if($qualities->count() == 1)
				<?php $quality = $qualities->get(0) ?>
				<div class="quality">
					<table class="table table-condensed __xs" ng-show="screen == 'xs' || screen == 'md'">
						<thead>
							<tr>
								<th style="width: 40%; text-align: left; padding-left: 0px; font-size: 13px;">
									<a href="/pearl-quality.html">Quality<span style="padding-left: 5px;">[?]</span></a>
								</th>
								<th style="width: 10%;">&nbsp;</th>
								<th style="width: 50%;">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Luster</td>
								<td>|</td>
								<td>{{$quality_levels[$quality->luster]}}</td>
							</tr>
							<tr>
								<td>Surface</td>
								<td>|</td>
								<td>{{$quality_levels[$quality->surface]}}</td>
							</tr>
							<tr>
								<td>Shape</td>
								<td>|</td>
								<td>{{$quality_shapes[$quality->shape]}}</td>
							</tr>
							<tr>
								<td>Colour</td>
								<td>|</td>
								<td>{{$quality_levels[$quality->colour]}}</td>
							</tr>
							@if($quality->display_matching == '1')
							<tr>
								<td>Matching</td>
								<td>|</td>
								<td>{{$quality_levels[$quality->matching]}}</td>
							</tr>
							@endif
						</tbody>
					</table>
					<table class="table table-condensed" ng-hide="screen == 'xs' || screen == 'md'">
						<thead>
							<tr>
								<th style="width: 80px; text-align: left; padding-left: 0px; font-size: 13px;">
									<a href="/pearl-quality.html">Quality<span style="padding-left: 5px;">[?]</span></a>
								</th>
								<th>Excellent</th>
								<th style="min-width: 100px;">Very Good</th>
								<th>Good</th>
								<th>Fair</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Luster</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="1" name="quality_luster" @if($quality->luster == '1') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="2" name="quality_luster" @if($quality->luster == '2') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="3" name="quality_luster" @if($quality->luster == '3') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="4" name="quality_luster" @if($quality->luster == '4') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
							</tr>
							<tr>
								<td>Surface</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="1" name="quality_surface" @if($quality->surface == '1') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="2" name="quality_surface" @if($quality->surface == '2') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="3" name="quality_surface" @if($quality->surface == '3') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="4" name="quality_surface" @if($quality->surface == '4') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
							</tr>
							<tr>
								<td>Shape</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="1" name="quality_shape" @if($quality->shape == '1') checked @endif>
				                        <label></label>
				                    </div>
									<span>Round&nbsp;&nbsp;</span>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="2" name="quality_shape" @if($quality->shape == '2') checked @endif>
				                        <label></label>
				                    </div>
									<span>Almost Round</span>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="3" name="quality_shape" @if($quality->shape == '3') checked @endif>
				                        <label></label>
				                    </div>
									<span>Drop&nbsp;&nbsp;</span>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="4" name="quality_shape" @if($quality->shape == '4') checked @endif>
				                        <label></label>
				                    </div>
									<span>Baroque&nbsp;&nbsp;</span>
									<div class="overlay"></div>
								</td>
							</tr>
							<tr>
								<td>Colour</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="1" name="quality_colour" @if($quality->colour == '1') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="2" name="quality_colour" @if($quality->colour == '2') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="3" name="quality_colour" @if($quality->colour == '3') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="4" name="quality_colour" @if($quality->colour == '4') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
							</tr>
							@if($quality->display_matching == '1')
							<tr>
								<td>Matching</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="1" name="quality_matching" @if($quality->matching == '1') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="2" name="quality_matching" @if($quality->matching == '2') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="3" name="quality_matching" @if($quality->matching == '3') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
				                        <input type="radio" value="4" name="quality_matching" @if($quality->matching == '4') checked @endif>
				                        <label></label>
				                    </div>
									<div class="overlay"></div>
								</td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
				@endif
            </div>
        </div>

		@if($qualities->count() > 1)
		<div class="row">
			@foreach($qualities as $index => $quality)
            <div class="col-md-6 col-lg-4">
				<div class="quality">
					<div class="element">
						<?php $qTitle = $quality->getTitle($config['lang']['code']) ?>
						@if($qTitle == '')
							&nbsp;
						@else
							<span>{{$qTitle}}</span>
						@endif
					</div>
					<table class="table table-condensed __xs" ng-show="screen == 'xs'">
						<thead>
							<tr>
								<th style="width: 40%; text-align: left; padding-left: 0px; font-size: 13px;">
									<a href="/pearl-quality.html">Quality<span style="padding-left: 5px;">[?]</span></a>
								</th>
								<th style="width: 10%;">&nbsp;</th>
								<th style="width: 50%;">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Luster</td>
								<td>|</td>
								<td>{{$quality_levels[$quality->luster]}}</td>
							</tr>
							<tr>
								<td>Surface</td>
								<td>|</td>
								<td>{{$quality_levels[$quality->surface]}}</td>
							</tr>
							<tr>
								<td>Shape</td>
								<td>|</td>
								<td>{{$quality_shapes[$quality->shape]}}</td>
							</tr>
							<tr>
								<td>Colour</td>
								<td>|</td>
								<td>{{$quality_levels[$quality->colour]}}</td>
							</tr>
							@if($quality->display_matching == '1')
							<tr>
								<td>Matching</td>
								<td>|</td>
								<td>{{$quality_levels[$quality->matching]}}</td>
							</tr>
							@endif
						</tbody>
					</table>
					<table class="table table-condensed" ng-hide="screen == 'xs'">
						<thead>
							<tr>
								<th style="width: 80px; text-align: left; padding-left: 0px; font-size: 13px;">
									<a href="/pearl-quality.html">Quality<span style="padding-left: 5px;">[?]</span></a>
								</th>
								<th>Excellent</th>
								<th style="min-width: 100px;">Very Good</th>
								<th>Good</th>
								<th>Fair</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Luster</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="1" name="quality_luster[{{$index}}]" @if($quality->luster == '1') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="2" name="quality_luster[{{$index}}]" @if($quality->luster == '2') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="3" name="quality_luster[{{$index}}]" @if($quality->luster == '3') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="4" name="quality_luster[{{$index}}]" @if($quality->luster == '4') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
							</tr>
							<tr>
								<td>Surface</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="1" name="quality_surface[{{$index}}]" @if($quality->surface == '1') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="2" name="quality_surface[{{$index}}]" @if($quality->surface == '2') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="3" name="quality_surface[{{$index}}]" @if($quality->surface == '3') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="4" name="quality_surface[{{$index}}]" @if($quality->surface == '4') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
							</tr>
							<tr>
								<td>Shape</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="1" name="quality_shape[{{$index}}]" @if($quality->shape == '1') checked @endif>
										<label></label>
									</div>
									<span>Round&nbsp;&nbsp;</span>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="2" name="quality_shape[{{$index}}]" @if($quality->shape == '2') checked @endif>
										<label></label>
									</div>
									<span>Almost Round</span>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="3" name="quality_shape[{{$index}}]" @if($quality->shape == '3') checked @endif>
										<label></label>
									</div>
									<span>Drop&nbsp;&nbsp;</span>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="4" name="quality_shape[{{$index}}]" @if($quality->shape == '4') checked @endif>
										<label></label>
									</div>
									<span>Baroque&nbsp;&nbsp;</span>
									<div class="overlay"></div>
								</td>
							</tr>
							<tr>
								<td>Colour</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="1" name="quality_colour[{{$index}}]" @if($quality->colour == '1') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="2" name="quality_colour[{{$index}}]" @if($quality->colour == '2') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="3" name="quality_colour[{{$index}}]" @if($quality->colour == '3') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="4" name="quality_colour[{{$index}}]" @if($quality->colour == '4') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
							</tr>
							@if($quality->display_matching == '1')
							<tr>
								<td>Matching</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="1" name="quality_matching[{{$index}}]" @if($quality->matching == '1') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="2" name="quality_matching[{{$index}}]" @if($quality->matching == '2') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="3" name="quality_matching[{{$index}}]" @if($quality->matching == '3') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
								<td>
									<div class="radio radio-gold">
										<input type="radio" value="4" name="quality_matching[{{$index}}]" @if($quality->matching == '4') checked @endif>
										<label></label>
									</div>
									<div class="overlay"></div>
								</td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
			@endforeach
        </div>
		@endif

        <div class="row">
            <div class="col-md-8">
                @if($product->hook_status == '1')
                <?php $hookImages = []; ?>
                <div class="hooks" id="ui-hooks">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>{{trans('product.Choose the hook')}}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="items">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            @foreach(json_decode($product->hook->columns) as $column)
                                            <th>
                                                <div class="item">
                                                    <div class="text top">
                                                        {!! nl2br($column->text) !!}
                                                    </div>
                                                </div>
                                            </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(json_decode($product->hook->items) as $row)
                                        <tr>
                                            @foreach($row as $index => $column)
                                                @if($index == 0)
                                                <td>
                                                    <div class="item">
                                                        <div class="text left">
                                                            {!! nl2br($column->text) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                                @else
                                                <td>
                                                    <div class="item">
                                                        @if($column->image != '' && isset($column->image->id) && isset($column->image->imageid))
                                                            <?php $image = App\HookImage::find($column->image->id); ?>
                                                            @if($image && $image->imageid == $column->image->imageid)
                                                            <?php $hookImages[] = [
                                                                    'text' => ((trim($column->text) != '')? $column->text: ''),
                                                                    'imageid' => $image->imageid
                                                                ]
                                                            ?>
                                                            <div class="image">
                                                                <a href="#" ng-click="showHookImage($event, '{{$image->imageid}}')">
                                                                    <img src="/app/product/{{$product->productid}}/{{$product->hook->hookid}}/{{$column->image->imageid}}_t.png">
                                                                </a>
                                                            </div>
                                                            @endif
                                                        @endif
                                                        <div class="input">
                                                            <input type="radio" name="hook" value="{{$column->id}}" data-plugin="icheck-hook">
                                                        </duv>
                                                        @if(trim($column->text) != '')
                                                        <div class="text">
                                                            {!! nl2br($column->text) !!}
                                                        </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="enquiry">
                    <form method="post" name="enquiryForm" action="" ng-controller="Form" ng-submit="send($event)" id="enquiryForm">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2>{{trans('product.Make an enquiry')}}</h2>
                            </div>
                        </div>

                        <div class="row form">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>{{trans('product.Jewel')}}</label>
                                    <input type="text" class="form-control" autocomplete="off" value="{!! $name !!}" readonly>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" ng-hide="langCode == 'th'">
                                <div class="form-group">
                                    <label>{{trans('_.Country')}}</label>
                                    <select class="form-control" name="country" ng-model="country">
                                        <option value="[[item.id]]" ng-value="[[item.id]]" ng-repeat="item in countries track by $index">[[item.country_name]]</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row form">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>{{trans('jewel.Full name')}} <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="fullname" ng-model="fullname" maxlength="100" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row form">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>{{trans('_.Email address')}} <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="email" ng-model="email" maxlength="256" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>{{trans('_.Phone number')}} <span class="required" ng-show="langCode == 'th'">*</span></label>
                                    <input type="text" class="form-control" name="phone" ng-model="phone" maxlength="25" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row form">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>{{trans('jewel.Your enquiry')}} <span class="required">*</span></label>
                                    <textarea name="detail" class="form-control" rows="4" ng-model="detail" data-plugin="autosize"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row form">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-md btn-default" ng-disabled="sending">[[(sending)?'{{trans('_.Sending...')}}':'{{trans('product.Send enquiry')}}']]</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden" id="ui-fullimages">
        <a href="/app/product/{{$product->productid}}/[[image.imageid]].png" data-imageid="[[image.imageid]]" data-sub-html="{!! $name !!}" ng-repeat="image in images track by $index">
            <img ng-src="/app/product/{{$product->productid}}/[[image.imageid]]_t.png">
        </a>
    </div>

    @if($product->hook_status == '1')
    <div class="hidden" id="ui-hookimages">
        @foreach($hookImages as $hookImage)
        <a href="/app/product/{{$product->productid}}/{{$product->hook->hookid}}/{{$hookImage['imageid']}}.png" data-imageid="{{$hookImage['imageid']}}" data-sub-html="{!! $hookImage['text'] !!}">
            <img src="/app/product/{{$product->productid}}/{{$product->hook->hookid}}/{{$hookImage['imageid']}}_t.png">
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/ng-onload/release/ng-onload.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/angular-animate/angular-animate.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-fullscreen.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/opentip.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/adapter-jquery.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/autosize/dist/autosize.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/ngSweetAlert/SweetAlert.min.js"></script>
@if($product->hook_status == '1')
<script src="{{ $config['url'] }}/static/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
@endif
<script>
app.requires.push('ngOnload');
app.requires.push('ngAnimate');
app.requires.push('oitozero.ngSweetAlert');

app.controller('Form', function($scope, $log, $window, $timeout, $http, SweetAlert){
    $scope.langCode     = '{{$config['lang']['code']}}';
    $scope.countries    = {!! json_encode($countries) !!};
    $scope.form         = $('#enquiryForm');
    $scope.alert        = {};
    $scope.sending      = false;

    if ($scope.langCode == 'th'){
        $scope.country = 216;
    }

    $scope.alert.fullname  = new Opentip($('input[name=fullname]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.phone     = new Opentip($('input[name=phone]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.email     = new Opentip($('input[name=email]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.emailp    = new Opentip($('input[name=email]', $scope.form), "{{trans('tour.Email address format is invalid')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.detail    = new Opentip($('textarea[name=detail]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});

    $scope.alert.fullname.show();
    $scope.alert.phone.show();
    $scope.alert.email.show();
    $scope.alert.emailp.show();
    $scope.alert.detail.show();

    $.each(Opentip.tips, function(index, item){
        item.hide();
    });

    $scope.send = function($event){
        @if($product->hook_status == '1')
            var inputs = $('input[name=hook]:checked', $('#ui-hooks'));
            if (inputs.length < 1){
                SweetAlert.swal({
                    title: "",
                    text: "{{trans('product.Please choose a hook for your jewel, then enter your information in the form for inquiry.')}}",
                    type: "error",
                    confirmButtonColor: '#2A72B5',
                    customClass: 'ui-jewels-sweetalert'
                },
                function(){
                    $('html, body').animate({
                        scrollTop: $("#ui-hooks").offset().top - 90
                    }, 450);
                });
            }
            else {
                $scope.execute(inputs.val());
            }
        @else
            $scope.execute('');
        @endif
        $event.preventDefault();
    };

    $scope.execute = function(hookid){
        if (
            ($scope.fullname && $scope.fullname.trim() != '') &&
            (($scope.langCode == 'th' && $scope.phone && $scope.phone.trim() != '') || ($scope.langCode != 'th')) &&
            ($scope.email && $scope.email.trim() != '' && /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($scope.email)) &&
            ($scope.detail && $scope.detail.trim() != '')
        )
        {
            $.each(Opentip.tips, function(index, item){
                item.hide();
            });
            $scope.sending = true;

            $http.post('/ajax/jewels/{{$product->productid}}/enquiry', {
                product_id: {{$product->id}},
                country_id: $scope.country? $scope.country: '',
                fullname: $scope.fullname.trim(),
                phone: $scope.phone? $scope.phone: '',
                email: $scope.email.trim(),
                detail: $scope.detail.trim(),
                hookid: hookid
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    SweetAlert.swal({
                        title: "",
                        text: "{{trans('product.We have received your information, we will contact you as soon as possible. Thank you for your trust in our products.')}}",
                        type: "success",
                        confirmButtonColor: '#2A72B5',
                        customClass: 'ui-jewels-sweetalert'
                    },
                    function(){
                        $window.location.reload();
                    });
                }
                else {
                    alert(resp.message);
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
                $window.location.reload();
            })
            .finally(function(){
                $scope.sending = false;
            });
        }
        else {
            if (!$scope.fullname || $scope.fullname.trim() == ''){
                $scope.alert.fullname.show();
            }
            if ($scope.langCode == 'th' && (!$scope.phone || $scope.phone.trim() == '')){
                $scope.alert.phone.show();
            }
            if (!$scope.email || $scope.email.trim() == ''){
                $scope.alert.email.show();
            }
            else if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($scope.email)){
                $scope.alert.emailp.show();
            }
            if (!$scope.detail || $scope.detail.trim() == ''){
                $scope.alert.detail.show();
            }
        }
    };
});

app.controller('DeferImageThumb', function($scope, $log, $attrs, $element){
    $scope.loaded = false;
    $scope.newImage = $('<img />', {
        src: '/app/product/{{$product->productid}}/'+$scope.image.imageid+'_t.png',
		alt: $attrs.alt
    });
    $scope.newImage.bind('load', function(){
        $('.image-showing', $element).html($scope.newImage);
        $scope.loaded = true;
        $scope.$apply();
    });
});
app.controller('DeferImageDisplay', function($scope, $log, $attrs, $element){
    $scope.loaded = false;
    $scope.newImage = $('<img />', {
        src: '/app/product/{{$product->productid}}/'+$scope.image.imageid+'.png',
		alt: $attrs.alt
    });
    $scope.newImage.bind('load', function(){
        $('.image-showing', $element).html($scope.newImage);
        $scope.loaded = true;
        $scope.$apply();
    });
});
app.controller('Thumbs', function($scope, $log){
    $scope.uiThumbs = $('#ui-thumbs');
    $scope.list     = $('.list', $scope.uiThumbs);
    $scope.items    = $('.items', $scope.list);
    $scope.topIndex = 0;
    $scope.appear   = 4;

    $scope.up = function($event){
        if ($scope.topIndex > 0){
            $scope.topIndex--;
            $scope.init('up');
        }
        $event.preventDefault();
    }
    $scope.down = function($event){
        if ($scope.topIndex < $scope.images.length-$scope.appear){
            $scope.topIndex++;
            $scope.init('down');
        }
        $event.preventDefault();
    }
    $scope.init = function(event){
        if ($scope.images.length > $scope.appear){
            var items   = $scope.list.find('a');
            var height  = 0;
            var top     = 0;
            $.each(items, function(index, item){
                if (index < $scope.topIndex){
                    top += $(item).outerHeight();
                }
                else if (index < $scope.appear){
                    height += $(item).outerHeight();
                }
            });
            if (typeof event != 'undefined'){
                if (event == 'up'){
                    $scope.items.animate({'top': -top+'px'}, 300);
                    var height = 0;
                    $.each(items, function(index, item){
                        if (index < $scope.appear){
                            height += $(item).outerHeight();
                            $scope.list.css('height', height+'px');
                        }
                    });
                }
                else if (event == 'down'){
                    $scope.items.animate({'top': -top+'px'}, 300);
                    var height = 0;
                    $.each(items, function(index, item){
                        if (index < $scope.appear){
                            height += $(item).outerHeight();
                            $scope.list.css('height', height+'px');
                        }
                    });
                }
            }
            else {
                $scope.list.css('height', height+'px');
            }
            $scope.uiThumbs.find('.arrow-up,.arrow-down').removeClass('hidden');
        }
        $scope.list.removeClass('minimize');
    }

    $(function(){
        $scope.uiThumbs.imagesLoaded(function(){
            $scope.init();
            $(window).bind('resize', function(){
                $scope.init();
            });
        });

		@if(session()->has('enquiryCompleted'))
		$('html, body').animate({'scrollTop': '0px'}, 500);
		@endif
    });
});
app.controller('Product', function($scope, $log, $timeout){
    $scope.images   = {!! json_encode($images) !!};
    $scope.display  = $scope.images.length > 0? $scope.images[0]: null;

    $scope.showImage = function($event, $index, image){
        if (image.imageid != $scope.display.imageid){
            $scope.display = $scope.images[$index];
        }
        $event.preventDefault();
    };
    $scope.showFullImage = function($event){
        var item = $('a[data-imageid="'+$scope.display.imageid+'"]', $('#ui-fullimages'));
        if (item.length > 0){
            item.trigger('click');
        }
        $event.preventDefault();
    };
    $scope.imageLoaded = function(){
        $scope.loaded = true;
        $scope.$apply();
    };
    $scope.makeEnquiry = function($event){
        $('html, body').animate({
            scrollTop: $("#enquiryForm").offset().top - 100
        }, 450);
        $event.preventDefault();
    };

    @if($product->hook_status == '1')
    $scope.showHookImage = function($event, imageid){
        var item = $('a[data-imageid="'+imageid+'"]', $('#ui-hookimages'));
        if (item.length > 0){
            item.trigger('click');
        }
        $event.preventDefault();
    };
    @endif

    $(function(){
        $('#ui-fullimages').lightGallery({
            download: false,
            counter: false,
            fullScreen: false,
            actualSize: false
        });
        autosize($('[data-plugin=autosize]'));

        @if($product->hook_status == '1')
        $("#ui-hooks .items").mCustomScrollbar({
            axis: 'x'
        });
        $('input[type="radio"]', $("#ui-hooks")).iCheck({
            radioClass: 'iradio_square'
        });
        $('#ui-hookimages').lightGallery({
            download: false,
            counter: false,
            fullScreen: false,
            actualSize: false
        });
        @endif
    });
});
</script>
@endsection
