@extends('dashboard.layout')

@section('head')
<link href="/static/bower_components/titatoggle/dist/titatoggle-dist.css?_t=1705150911" rel="stylesheet">
<style>
.blind-column {
	display: none;
}
.blind-row td {
	position: relative;
}
.blind-row .blind-column {
	display: block !important;
}
.blind-row .blind-column {
	background-color:rgba(0, 0, 0, 0.15);
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 10;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="content">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-8">

				<!-- start: block 1 -->
				<?php $block1 = $product->qualities()->where('block', 1)->first();?>

                <section class="panel" style="border: 1px solid #f4f4f4;" id="b1">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-xs-12">
								<a href="/dashboard/products/{{$product->productid}}" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>

								<button type="button" class="btn btn-danger btn-sm pull-right" ng-click="save()" ng-disabled="doing">
		                            {{trans('_.Save changes')}}[[doing? '...': '']]
		                        </button>
		                    </div>
						</div>
                    </header>

					<div class="row" style="padding: 10px 15px;">
						<div class="col-lg-12">
							<div class="checkbox checkbox-slider-md checkbox-slider--b checkbox-slider-success">
								<label>
									<input type="checkbox" name="b1_show" @if($block1 && $block1->display == '1') checked @endif><span>{{trans('product.Show this quality block')}}</span>
								</label>
							</div>
						</div>
						<div class="col-lg-12">
							<form class="form-horizontal tasi-form" style="margin-top: 10px;">
								<div class="form-group" data-group="title">
	                                <div class="col-sm-12">

	                                    <div>
	                                        <ul class="nav nav-tabs" role="tablist">
	                                            @foreach($locales as $index => $locale)
	                                            <li role="presentation" @if($index == 0) class="active" @endif>
	                                                <a href="#b1_title-{{$locale['code']}}" aria-controls="b1_title-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
	                                            </li>
	                                            @endforeach
	                                        </ul>
	                                        <div class="tab-content">
	                                            @foreach($locales as $index => $locale)
	                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="b1_title-{{$locale['code']}}">
	                                                <input type="text" class="form-control" name="title" autocomplete="off" data-locale="{{$locale['code']}}" placeholder="{{trans('product.Item title')}} ({{trans('_.optional')}})" value="{{($block1)? $block1->getTitle($locale['code']): ''}}">
	                                            </div>
	                                            @endforeach
	                                        </div>
	                                    </div>

	                                </div>
								</div>
							</form>
						</div>
					</div>
					<div class="table-responsive" style="padding-top: 3px; border-bottom: 1px solid #e0e0e0;">
						<div>
							<table class="table table-striped" style="margin-bottom: 0px;">
								<thead>
									<tr>
										<th>&nbsp;</th>
										<th class="text-center">Excellent</th>
										<th class="text-center">Very Good</th>
										<th class="text-center">Good</th>
										<th class="text-center">Fair</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Luster</td>
										<td class="text-center">
											<input type="radio" value="1" name="b1_luster" data-plugin="icheck" @if((!$block1) || ($block1 && $block1->luster == '1')) checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b1_luster" data-plugin="icheck" @if($block1 && $block1->luster == '2') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b1_luster" data-plugin="icheck" @if($block1 && $block1->luster == '3') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b1_luster" data-plugin="icheck" @if($block1 && $block1->luster == '4') checked @endif>
										</td>
									</tr>
									<tr>
										<td>Surface</td>
										<td class="text-center">
											<input type="radio" value="1" name="b1_surface" data-plugin="icheck" @if((!$block1) || ($block1 && $block1->surface == '1')) checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b1_surface" data-plugin="icheck" @if($block1 && $block1->surface == '2') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b1_surface" data-plugin="icheck" @if($block1 && $block1->surface == '3') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b1_surface" data-plugin="icheck" @if($block1 && $block1->surface == '4') checked @endif>
										</td>
									</tr>
									<tr>
										<td>Shape</td>
										<td class="text-center">
											<input type="radio" value="1" name="b1_shape" data-plugin="icheck" @if((!$block1) || ($block1 && $block1->shape == '1')) checked @endif>
											<div style="margin-top: 5px;">Round</div>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b1_shape" data-plugin="icheck" @if($block1 && $block1->shape == '2') checked @endif>
											<div style="margin-top: 5px;">Almost Round</div>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b1_shape" data-plugin="icheck" @if($block1 && $block1->shape == '3') checked @endif>
											<div style="margin-top: 5px;">Drop</div>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b1_shape" data-plugin="icheck" @if($block1 && $block1->shape == '4') checked @endif>
											<div style="margin-top: 5px;">Baroque</div>
										</td>
									</tr>
									<tr>
										<td>Colour</td>
										<td class="text-center">
											<input type="radio" value="1" name="b1_colour" data-plugin="icheck" @if((!$block1) || ($block1 && $block1->colour == '1')) checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b1_colour" data-plugin="icheck" @if($block1 && $block1->colour == '2') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b1_colour" data-plugin="icheck" @if($block1 && $block1->colour == '3') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b1_colour" data-plugin="icheck" @if($block1 && $block1->colour == '4') checked @endif>
										</td>
									</tr>
									<tr data-row="matching" @if($block1 && $block1->display_matching == '0') class="blind-row" @endif>
										<td>
											Matching
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="1" name="b1_matching" data-plugin="icheck" @if((!$block1) || ($block1 && $block1->matching == '1')) checked @endif>
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b1_matching" data-plugin="icheck" @if($block1 && $block1->matching == '2') checked @endif>
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b1_matching" data-plugin="icheck" @if($block1 && $block1->matching == '3') checked @endif>
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b1_matching" data-plugin="icheck" @if($block1 && $block1->matching == '4') checked @endif>
											<div class="blind-column"></div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
                    </div>
					<div class="row" style="padding: 10px 15px;">
						<div class="col-md-12">
							<div style="padding-top: 6px; padding-bottom: 5px;">
								<input type="checkbox" name="b1_hide_matching" @if($block1 && $block1->display_matching == '0') checked @endif> &nbsp; {{trans('product.Hide Matching')}}
							</div>
						</div>
					</div>
                </section>
				<!-- end: block 1 -->

				<!-- start: block 2 -->
				<?php $block2 = $product->qualities()->where('block', 2)->first();?>

                <section class="panel" style="border: 1px solid #f4f4f4;" id="b2">
					<div class="row" style="padding: 10px 15px;">
						<div class="col-lg-12">
							<div class="checkbox checkbox-slider-md checkbox-slider--b checkbox-slider-success">
								<label>
									<input type="checkbox" name="b2_show" @if($block2 && $block2->display == '1') checked @endif><span>{{trans('product.Show this quality block')}}</span>
								</label>
							</div>
						</div>
						<div class="col-lg-12">
							<form class="form-horizontal tasi-form" style="margin-top: 10px;">
								<div class="form-group" data-group="title">
	                                <div class="col-sm-12">

	                                    <div>
	                                        <ul class="nav nav-tabs" role="tablist">
	                                            @foreach($locales as $index => $locale)
	                                            <li role="presentation" @if($index == 0) class="active" @endif>
	                                                <a href="#b2_title-{{$locale['code']}}" aria-controls="b2_title-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
	                                            </li>
	                                            @endforeach
	                                        </ul>
	                                        <div class="tab-content">
	                                            @foreach($locales as $index => $locale)
	                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="b2_title-{{$locale['code']}}">
	                                                <input type="text" class="form-control" name="title" autocomplete="off" data-locale="{{$locale['code']}}" placeholder="{{trans('product.Item title')}} ({{trans('_.optional')}})" value="{{($block2)? $block2->getTitle($locale['code']): ''}}">
	                                            </div>
	                                            @endforeach
	                                        </div>
	                                    </div>

	                                </div>
								</div>
							</form>
						</div>
					</div>
					<div class="table-responsive" style="padding-top: 3px; border-bottom: 1px solid #e0e0e0;">
						<div>
							<table class="table table-striped" style="margin-bottom: 0px;">
								<thead>
									<tr>
										<th>&nbsp;</th>
										<th class="text-center">Excellent</th>
										<th class="text-center">Very Good</th>
										<th class="text-center">Good</th>
										<th class="text-center">Fair</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Luster</td>
										<td class="text-center">
											<input type="radio" value="1" name="b2_luster" data-plugin="icheck" @if((!$block2) || ($block2 && $block2->luster == '1')) checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b2_luster" data-plugin="icheck" @if($block2 && $block2->luster == '2') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b2_luster" data-plugin="icheck" @if($block2 && $block2->luster == '3') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b2_luster" data-plugin="icheck" @if($block2 && $block2->luster == '4') checked @endif>
										</td>
									</tr>
									<tr>
										<td>Surface</td>
										<td class="text-center">
											<input type="radio" value="1" name="b2_surface" data-plugin="icheck" @if((!$block2) || ($block2 && $block2->surface == '1')) checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b2_surface" data-plugin="icheck" @if($block2 && $block2->surface == '2') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b2_surface" data-plugin="icheck" @if($block2 && $block2->surface == '3') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b2_surface" data-plugin="icheck" @if($block2 && $block2->surface == '4') checked @endif>
										</td>
									</tr>
									<tr>
										<td>Shape</td>
										<td class="text-center">
											<input type="radio" value="1" name="b2_shape" data-plugin="icheck" @if((!$block2) || ($block2 && $block2->shape == '1')) checked @endif>
											<div style="margin-top: 5px;">Round</div>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b2_shape" data-plugin="icheck" @if($block2 && $block2->shape == '2') checked @endif>
											<div style="margin-top: 5px;">Almost Round</div>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b2_shape" data-plugin="icheck" @if($block2 && $block2->shape == '3') checked @endif>
											<div style="margin-top: 5px;">Drop</div>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b2_shape" data-plugin="icheck" @if($block2 && $block2->shape == '4') checked @endif>
											<div style="margin-top: 5px;">Baroque</div>
										</td>
									</tr>
									<tr>
										<td>Colour</td>
										<td class="text-center">
											<input type="radio" value="1" name="b2_colour" data-plugin="icheck" @if((!$block2) || ($block2 && $block2->colour == '1')) checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b2_colour" data-plugin="icheck" @if($block2 && $block2->colour == '2') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b2_colour" data-plugin="icheck" @if($block2 && $block2->colour == '3') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b2_colour" data-plugin="icheck" @if($block2 && $block2->colour == '4') checked @endif>
										</td>
									</tr>
									<tr data-row="matching" @if($block2 && $block2->display_matching == '0') class="blind-row" @endif>
										<td>
											Matching
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="1" name="b2_matching" data-plugin="icheck" @if((!$block2) || ($block2 && $block2->matching == '1')) checked @endif>
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b2_matching" data-plugin="icheck" @if($block2 && $block2->matching == '2') checked @endif>
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b2_matching" data-plugin="icheck" @if($block2 && $block2->matching == '3') checked @endif>
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b2_matching" data-plugin="icheck" @if($block2 && $block2->matching == '4') checked @endif>
											<div class="blind-column"></div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
                    </div>
					<div class="row" style="padding: 10px 15px;">
						<div class="col-md-12">
							<div style="padding-top: 6px; padding-bottom: 5px;">
								<input type="checkbox" name="b2_hide_matching" @if($block2 && $block2->display_matching == '0') checked @endif> &nbsp; {{trans('product.Hide Matching')}}
							</div>
						</div>
					</div>
                </section>
				<!-- end: block 2 -->

				<!-- start: block 3 -->
				<?php $block3 = $product->qualities()->where('block', 3)->first();?>

                <section class="panel" style="border: 1px solid #f4f4f4;" id="b3">
					<div class="row" style="padding: 10px 15px;">
						<div class="col-lg-12">
							<div class="checkbox checkbox-slider-md checkbox-slider--b checkbox-slider-success">
								<label>
									<input type="checkbox" name="b3_show" @if($block3 && $block3->display == '1') checked @endif><span>{{trans('product.Show this quality block')}}</span>
								</label>
							</div>
						</div>
						<div class="col-lg-12">
							<form class="form-horizontal tasi-form" style="margin-top: 10px;">
								<div class="form-group" data-group="title">
	                                <div class="col-sm-12">

	                                    <div>
	                                        <ul class="nav nav-tabs" role="tablist">
	                                            @foreach($locales as $index => $locale)
	                                            <li role="presentation" @if($index == 0) class="active" @endif>
	                                                <a href="#b3_title-{{$locale['code']}}" aria-controls="b3_title-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
	                                            </li>
	                                            @endforeach
	                                        </ul>
	                                        <div class="tab-content">
	                                            @foreach($locales as $index => $locale)
	                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="b3_title-{{$locale['code']}}">
	                                                <input type="text" class="form-control" name="title" autocomplete="off" data-locale="{{$locale['code']}}" placeholder="{{trans('product.Item title')}} ({{trans('_.optional')}})" value="{{($block3)? $block3->getTitle($locale['code']): ''}}">
	                                            </div>
	                                            @endforeach
	                                        </div>
	                                    </div>

	                                </div>
								</div>
							</form>
						</div>
					</div>
					<div class="table-responsive" style="padding-top: 3px; border-bottom: 1px solid #e0e0e0;">
						<div>
							<table class="table table-striped" style="margin-bottom: 0px;">
								<thead>
									<tr>
										<th>&nbsp;</th>
										<th class="text-center">Excellent</th>
										<th class="text-center">Very Good</th>
										<th class="text-center">Good</th>
										<th class="text-center">Fair</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Luster</td>
										<td class="text-center">
											<input type="radio" value="1" name="b3_luster" data-plugin="icheck" @if((!$block3) || ($block3 && $block3->luster == '1')) checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b3_luster" data-plugin="icheck" @if($block3 && $block3->luster == '2') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b3_luster" data-plugin="icheck" @if($block3 && $block3->luster == '3') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b3_luster" data-plugin="icheck" @if($block3 && $block3->luster == '4') checked @endif>
										</td>
									</tr>
									<tr>
										<td>Surface</td>
										<td class="text-center">
											<input type="radio" value="1" name="b3_surface" data-plugin="icheck" @if((!$block3) || ($block3 && $block3->surface == '1')) checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b3_surface" data-plugin="icheck" @if($block3 && $block3->surface == '2') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b3_surface" data-plugin="icheck" @if($block3 && $block3->surface == '3') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b3_surface" data-plugin="icheck" @if($block3 && $block3->surface == '4') checked @endif>
										</td>
									</tr>
									<tr>
										<td>Shape</td>
										<td class="text-center">
											<input type="radio" value="1" name="b3_shape" data-plugin="icheck" @if((!$block3) || ($block3 && $block3->shape == '1')) checked @endif>
											<div style="margin-top: 5px;">Round</div>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b3_shape" data-plugin="icheck" @if($block3 && $block3->shape == '2') checked @endif>
											<div style="margin-top: 5px;">Almost Round</div>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b3_shape" data-plugin="icheck" @if($block3 && $block3->shape == '3') checked @endif>
											<div style="margin-top: 5px;">Drop</div>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b3_shape" data-plugin="icheck" @if($block3 && $block3->shape == '4') checked @endif>
											<div style="margin-top: 5px;">Baroque</div>
										</td>
									</tr>
									<tr>
										<td>Colour</td>
										<td class="text-center">
											<input type="radio" value="1" name="b3_colour" data-plugin="icheck" @if((!$block3) || ($block3 && $block3->colour == '1')) checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b3_colour" data-plugin="icheck" @if($block3 && $block3->colour == '2') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b3_colour" data-plugin="icheck" @if($block3 && $block3->colour == '3') checked @endif>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b3_colour" data-plugin="icheck" @if($block3 && $block3->colour == '4') checked @endif>
										</td>
									</tr>
									<tr data-row="matching" @if($block3 && $block3->display_matching == '0') class="blind-row" @endif>
										<td>
											Matching
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="1" name="b3_matching" data-plugin="icheck" @if((!$block3) || ($block3 && $block3->matching == '1')) checked @endif>
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="2" name="b3_matching" data-plugin="icheck" @if($block3 && $block3->matching == '2') checked @endif>
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="3" name="b3_matching" data-plugin="icheck" @if($block3 && $block3->matching == '3') checked @endif>
											<div class="blind-column"></div>
										</td>
										<td class="text-center">
											<input type="radio" value="4" name="b3_matching" data-plugin="icheck" @if($block3 && $block3->matching == '4') checked @endif>
											<div class="blind-column"></div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
                    </div>
					<div class="row" style="padding: 10px 15px;">
						<div class="col-md-12">
							<div style="padding-top: 6px; padding-bottom: 5px;">
								<input type="checkbox" name="b3_hide_matching" @if($block3 && $block3->display_matching == '0') checked @endif> &nbsp; {{trans('product.Hide Matching')}}
							</div>
						</div>
					</div>
                </section>
				<!-- end: block 3 -->

            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
app.controller('content', function($scope, $http, $window){

	$scope.save = function()
	{
		$scope.doing = true;

		//block 1
		var b1_node = $('#b1');
		var b1 = {
			show: b1_node.find('input[name=b1_show]').is(":checked")? 'yes': 'no',
			show_matching: b1_node.find('input[name=b1_hide_matching]').is(":checked")? 'no': 'yes',
			title: {},
			luster: b1_node.find('input[name=b1_luster]:checked').val(),
			surface: b1_node.find('input[name=b1_surface]:checked').val(),
			shape: b1_node.find('input[name=b1_shape]:checked').val(),
			colour: b1_node.find('input[name=b1_colour]:checked').val(),
			matching: b1_node.find('input[name=b1_matching]:checked').val()
		};

		b1_node.find('input[name=title]').each(function(index, item){
			b1.title[$(item).attr('data-locale')] = $(item).val().trim();
        });

		//block 2
		var b2_node = $('#b2');
		var b2 = {
			show: b2_node.find('input[name=b2_show]').is(":checked")? 'yes': 'no',
			show_matching: b2_node.find('input[name=b2_hide_matching]').is(":checked")? 'no': 'yes',
			title: {},
			luster: b2_node.find('input[name=b2_luster]:checked').val(),
			surface: b2_node.find('input[name=b2_surface]:checked').val(),
			shape: b2_node.find('input[name=b2_shape]:checked').val(),
			colour: b2_node.find('input[name=b2_colour]:checked').val(),
			matching: b2_node.find('input[name=b2_matching]:checked').val()
		};

		b2_node.find('input[name=title]').each(function(index, item){
			b2.title[$(item).attr('data-locale')] = $(item).val().trim();
        });

		//block 3
		var b3_node = $('#b3');
		var b3 = {
			show: b3_node.find('input[name=b3_show]').is(":checked")? 'yes': 'no',
			show_matching: b3_node.find('input[name=b3_hide_matching]').is(":checked")? 'no': 'yes',
			title: {},
			luster: b3_node.find('input[name=b3_luster]:checked').val(),
			surface: b3_node.find('input[name=b3_surface]:checked').val(),
			shape: b3_node.find('input[name=b3_shape]:checked').val(),
			colour: b3_node.find('input[name=b3_colour]:checked').val(),
			matching: b3_node.find('input[name=b3_matching]:checked').val()
		};

		b3_node.find('input[name=title]').each(function(index, item){
			b3.title[$(item).attr('data-locale')] = $(item).val().trim();
        });

		//saving data
		$http.post('/ajax/dashboard/products/{{$product->productid}}/quality', {
			b1: JSON.stringify(b1),
			b2: JSON.stringify(b2),
			b3: JSON.stringify(b3)
		})
		.success(function(data){
			$scope.doing = false;

			if (data.status == 'ok'){
				noty({
					text: '{{trans('_.Save changes successfully.')}}',
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
					timeout: 2000
				});
			}
			else {
				alert(data.message);
			}
		})
		.error(function(){
			alert('{{trans('error.general')}}');
			$window.location.reload();
		});
	}

	$(function(){
		//block 1
	    $('input[name=b1_hide_matching]', '#b1').iCheck({
	        checkboxClass: 'icheckbox_flat-red',
	        radioClass: 'iradio_flat-red'
	    })
		.on('ifChecked', function(event){
			$('tr[data-row=matching]', '#b1').addClass('blind-row');
		})
		.on('ifUnchecked', function(event){
			$('tr[data-row=matching]', '#b1').removeClass('blind-row');
		});

		//block 2
	    $('input[name=b2_hide_matching]', '#b2').iCheck({
	        checkboxClass: 'icheckbox_flat-red',
	        radioClass: 'iradio_flat-red'
	    })
		.on('ifChecked', function(event){
			$('tr[data-row=matching]', '#b2').addClass('blind-row');
		})
		.on('ifUnchecked', function(event){
			$('tr[data-row=matching]', '#b2').removeClass('blind-row');
		});

		//block 3
	    $('input[name=b3_hide_matching]', '#b3').iCheck({
	        checkboxClass: 'icheckbox_flat-red',
	        radioClass: 'iradio_flat-red'
	    })
		.on('ifChecked', function(event){
			$('tr[data-row=matching]', '#b3').addClass('blind-row');
		})
		.on('ifUnchecked', function(event){
			$('tr[data-row=matching]', '#b3').removeClass('blind-row');
		});
	});
});
</script>
@endsection
