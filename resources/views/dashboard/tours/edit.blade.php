@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" type="text/css" href="/static/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<link rel="stylesheet" type="text/css" href="/static/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
<style>
.bootstrap-tagsinput {
    width: 100%;
    padding-top: 2px;
    padding-bottom: 6px;
}
.tag.label.label-danger {
    padding-top: 2.5px !important;
    padding-bottom: 2.5px !important;
}
.ui-list-item {
    position: relative;
}
.ui-list-item a {
    position: absolute;
    right: 10px;
    top: 10px;
    color: #333;
}
.ui-map {
    width: 100%;
    margin-top: 12px;
}
.ui-map .marker-form {
    position: relative;
    margin-top: 8px;
}
.ui-map .marker-form textarea {
    max-width: 100%;
}
.ui-map .map {
    width: 100%;
    height: 450px;
    border: 1px solid #ccc;
    margin-top: 8px;
}
.ui-editmap-btn {
    margin-left: 15px;
    margin-bottom: -7px;
    padding: 0px 5px;
    font-size: 11px;
}
.ui-editmap-btn.second {
    margin-left: 3px !important;
}
.payments img {
    display: inline-block;
    margin-bottom: 5px;
    max-width: 100%;
	max-height: 85px;
}
.payments a.whatis {
    font-style: italic;
    font-size: 11.5px;
    margin-left: 15px;
}
.payments a.whatis:hover {
    text-decoration: underline;
}
</style>
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/froala_editor.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/froala_style.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/code_view.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/colors.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/image.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/line_breaker.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/table.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/char_counter.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/video.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/fullscreen.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/file.css">
<link rel="stylesheet" href="/static/bower_components/froala-wysiwyg-editor/css/plugins/quick_insert.css">
<link rel="stylesheet" href="/static/bower_components/codemirror/lib/codemirror.css">
<style>
.ui-editor {
    position: relative;
}
.ui-editor .bottom {
    position: absolute;
    width: 170px;
    height: 25px;
    background-color: #fff;
    z-index: 10000;
    margin-top: -25px;
}
.ui-browse {
    cursor: pointer;
    font-size: 12px;
    background-color: #fff !important;
}
.bank-image {
    position: relative;
    float: left;
    margin-right: 5px;
    width: 50px;
    padding: 7px;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.bank-image img {
    width: 100%;
}

.has-error.form-control {
  border-color: #a94442;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
}
.has-error.form-control:focus {
  border-color: #843534;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Form">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								<a href="/dashboard/tours/{{$tour->tourid}}" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('tour.Edit Package Information')}}</span>
							</div>
                            <div class="col-md-6">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="{{$request->fullUrl()}}">
									<button type="button" class="btn btn-danger btn-sm" id="save">
										{{trans('_.Save changes')}}
									</button>
								</form>
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

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('tour.About package')}}</label>
                                <div class="col-sm-10">
									<div class="checkboxes">
                                        <label class="label_check c_on">
											<input name="about_new" value="true" type="checkbox" data-plugin="icheck" @if($tour->new == '1') checked @endif> <span class="ui-icheck-text">{{trans('tour.New package')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="about_popular" value="true" type="checkbox" data-plugin="icheck" @if($tour->popular == '1') checked @endif> <span class="ui-icheck-text">{{trans('tour.Popular package')}}</span>
										</label>
                                        <label class="label_check c_on">
											<input name="about_recommend" value="true" type="checkbox" data-plugin="icheck" @if($tour->recommend == '1') checked @endif> <span class="ui-icheck-text">{{trans('tour.Recommended package')}}</span>
										</label>
									</div>
								</div>
                            </div>

                            <div class="form-group" data-group="title">
                                <label class="col-sm-2 control-label">{{trans('_.Title')}}</label>
                                <div class="col-sm-10">

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
                                                <input type="text" class="form-control" name="title[{{$locale['code']}}]" autocomplete="off" data-input-title="{{$locale['code']}}" value="{!! $tour->getTitle($locale['code']) !!}">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group" data-group="code">
                                <label class="col-sm-2 control-label">{{trans('product.Code')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="code" maxlength="50" autocomplete="off" value="{!! $tour->code !!}">
								</div>
                            </div>

							<div class="form-group" data-group="url">
                                <label class="col-sm-2 control-label">{{trans('_.URL')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="url" maxlength="128" autocomplete="off" value="{!! $tour->url !!}">
									<p class="help-block">
                                        <em>{{trans('category.Allowed characters A-Z a-z 0-9 and - only.')}}</em>
                                    </p>
                                    <p class="help-block">
                                        <em>{{trans('_.Example')}} : {{config('app.url')}}/tours/<strong>tour-alias</strong>.html</em>
                                    </p>
								</div>
                            </div>

                            <div class="form-group" data-group="price_type">
                                <label class="col-sm-2 control-label">{{trans('tour.Price type')}}</label>
                                <div class="col-sm-10">
                                    <label class="checkbox-inline" style="padding-left:0px;">
                                		<input type="radio" name="price_type" value="person" data-plugin="icheck-price" @if($tour->price_type == 'person') checked @endif> {{trans('tour.Single ticket')}}
									</label>
									<label class="checkbox-inline">
                                		<input type="radio" name="price_type" value="package" data-plugin="icheck-price" @if($tour->price_type == 'package') checked @endif> {{trans('tour.Bundle ticket')}}
									</label>
									<label class="checkbox-inline">
                                		<input type="radio" name="price_type" value="free" data-plugin="icheck-price" @if($tour->price_type == 'free') checked @endif> {{trans('tour.Free Transfer ticket')}}
									</label>
								</div>
                            </div>

                            <div class="form-group" data-group="price_per_person" @if($tour->price_type != 'person') style="display:none;" @endif>
                                <label class="col-sm-2 control-label">{{trans('_.Price')}}</label>
                                <div class="col-sm-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon">{{trans('_.Adult')}}</span>
                                        <input type="text" name="price_person_adult" class="form-control" placeholder="" data-plugin="price" @if($tour->price_type == 'person') value="{!! $tour->price_person_adult !!}" @endif>
                                        <span class="input-group-addon">THB</span>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">{{trans('_.Child')}}</span>
                                        <input type="text" name="price_person_child" class="form-control" placeholder="" data-plugin="price" @if($tour->price_type == 'person') value="{!! $tour->price_person_child !!}" @endif>
                                        <span class="input-group-addon">THB</span>
                                    </div>
								</div>
                            </div>

                            <div class="form-group" data-group="price_per_package" @if($tour->price_type != 'package') style="display:none;" @endif>
                                <label class="col-sm-2 control-label">{{trans('_.Price')}}</label>
                                <div class="col-sm-6">
                                    <div class="input-group m-bot15">
                                        <input type="text" name="price_package" class="form-control" data-plugin="price" @if($tour->price_type == 'package') value="{!! $tour->price_package !!}" @endif>
                                        <span class="input-group-addon">THB</span>
                                    </div>

                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon">{{trans('tour.Number of adult and child')}}</span>
                                        <input type="text" name="number_package_adult" class="form-control" placeholder="" data-plugin="number" @if($tour->price_type == 'package') value="{!! $tour->number_package_adult !!}" @endif>
                                    </div>

                                    <div class="input-group hidden">
                                        <span class="input-group-addon">{{trans('tour.Number of child')}}</span>
                                        <input type="text" name="number_package_child" class="form-control" placeholder="" data-plugin="number" @if($tour->price_type == 'package') value="{!! $tour->number_package_child !!}" @endif>
                                    </div>
								</div>
                            </div>

							<div class="form-group" ng-class="{'has-error': extraError}" data-group="price_per_package" @if($tour->price_type != 'package') style="display:none;" @endif>
                                <label class="col-sm-2 control-label">{{trans('tour.Extra visitors')}}</label>
                                <div class="col-sm-6">
									<div class="row">
										<div class="col-sm-5">
											<div class="input-group m-bot15">
		                                        <span class="input-group-addon">{{trans('tour.Number')}}</span>
		                                        <input type="text" class="form-control" placeholder="+" data-plugin="number" ng-model="extraNumber">
		                                    </div>
										</div>
										<div class="col-sm-5">
											<div class="input-group m-bot15">
		                                        <span class="input-group-addon">{{trans('_.Price')}}</span>
		                                        <input type="text" class="form-control" placeholder="+" data-plugin="price" ng-model="extraPrice">
												<span class="input-group-addon">THB</span>
		                                    </div>
										</div>
										<div class="col-sm-2">
											<button class="btn btn-white" type="button" ng-click="addExtra()" ng-disabled="addingExtra">{{trans('_.Add')}}</button>
										</div>
									</div>

									<div class="row" ng-show="extras.length > 0">
										<div class="col-sm-6">
											<ul class="list-group" style="margin-bottom: 0px;">
												<li class="list-group-item ui-list-item" ng-repeat="extra in extras track by $index" ng-controller="extraCtrl" ng-mouseenter="btn=true" ng-mouseleave="btn=false">
													+[[extra.number | number]] (+[[extra.price | number]] THB)
													<a href="#" ng-click="remove($event, $index)" ng-show="btn"><i class="fa fa-times"></i></a>
												</li>
											</ul>
										</div>
									</div>
								</div>
                            </div>

							<div class="form-group" data-group="price_free" @if($tour->price_type != 'free') style="display:none;" @endif>
                                <label class="col-sm-2 control-label">{{trans('tour.Maximum guests')}}</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
										<input type="text" name="maximum_guests" class="form-control" placeholder="" data-plugin="number" @if($tour->price_type == 'free') value="{!! $tour->maximum_guests !!}" @endif>
                                        <span class="input-group-addon">{{trans('tour.Adult/Child')}}</span>
                                    </div>
								</div>
                            </div>

                            <div class="form-group payments">
                                <label class="col-sm-2 control-label">{{trans('_.Payments')}}</label>
                                <div class="col-sm-10">
									<div class="checkboxes">
                                        @foreach($payments as $index => $payment)
                                        <label class="label_check c_on">
											<input name="payments[]" value="{{$payment->paymentid}}" type="checkbox" data-plugin="icheck" @if(in_array($payment->paymentid, $payment_maps)) checked @endif>
                                            <span class="ui-icheck-text">
                                                {{$payment->name}} @if($payment->link != '') <a href="{{$payment->link}}" target="_blank" class="whatis">(What is {{$payment->name}}?)</a> @endif
                                                @if($payment->code == 'thaibanks')
                                                <a href="/dashboard/payments?method=thaibanks" target="_blank" class="whatis">({{trans('tour.Manage bank accounts')}})</a>
                                                @endif
                                            </span>
										</label>
                                            <?php $paymentsImages = json_decode($payment->image); ?>
                                            @foreach($paymentsImages as $paymentsImage)
                                            <img src="{!! $paymentsImage !!}">
                                            @endforeach
                                            <div class="detail">{{$payment->detail}}</div>
                                            @if($index < $payments->count()-1)
                                            <hr>
                                            @endif

                                            @if($payment->code == 'thaibanks')
                                                @foreach($payment->banks()->groupBy('bank_id')->get() as $map)
                                                    @if($map->bank)
                                                    <div class="bank-image" style="background-color:{{$map->bank->color}}">
                                                        <img src="/static/plugins/banks-logo/th/{{$map->bank->acronym}}.svg">
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
									</div>
								</div>
                            </div>

							<div class="form-group">
                                <label class="col-sm-2 control-label">{{trans("tour.Show child's age")}}</label>
                                <div class="col-sm-10">
									<label class="checkbox-inline" style="padding-left:0px;">
                                		<input type="radio" name="show_child_age" value="yes" data-plugin="icheck" @if($tour->show_child_age == '1') checked @endif> {{trans('_.Yes')}}
									</label>
									<label class="checkbox-inline">
                                		<input type="radio" name="show_child_age" value="no" data-plugin="icheck" @if($tour->show_child_age == '0') checked @endif> {{trans('_.No')}}
									</label>
								</div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('_.Publish')}}</label>
                                <div class="col-sm-10">
									<label class="checkbox-inline" style="padding-left:0px;">
                                		<input type="radio" name="publish" value="yes" data-plugin="icheck" @if($tour->publish == '1') checked @endif> {{trans('_.Yes')}}
									</label>
									<label class="checkbox-inline">
                                		<input type="radio" name="publish" value="no" data-plugin="icheck" @if($tour->publish == '0') checked @endif> {{trans('_.No')}}
									</label>
								</div>
                            </div>

                            <div class="form-group" data-group="detail">
                                <div class="col-sm-12">
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
                                                <div class="ui-editor">
                                                    <textarea data-plugin="froala-editor" name="detail[{{$locale['code']}}]">{!! $tour->getDetail($locale['code']) !!}</textarea>
                                                    <div class="bottom"></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
							</div>

							<?php
								$disabled = json_decode($tour->disabled_days_week);
							?>

							<div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('tour.Closed day')}}</label>
                                <div class="col-sm-10">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
												<input type="checkbox" name="disabled_week[]" value="0" data-plugin="icheck" @if(in_array('0', $disabled)) checked="true" @endif> &nbsp; {{trans('_.Sunday')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_week[]" value="1" data-plugin="icheck" @if(in_array('1', $disabled)) checked="true" @endif> &nbsp; {{trans('_.Monday')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_week[]" value="2" data-plugin="icheck" @if(in_array('2', $disabled)) checked="true" @endif> &nbsp; {{trans('_.Tuesday')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_week[]" value="3" data-plugin="icheck" @if(in_array('3', $disabled)) checked="true" @endif> &nbsp; {{trans('_.Wednesday')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_week[]" value="4" data-plugin="icheck" @if(in_array('4', $disabled)) checked="true" @endif> &nbsp; {{trans('_.Thursday')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_week[]" value="5" data-plugin="icheck" @if(in_array('5', $disabled)) checked="true" @endif> &nbsp; {{trans('_.Friday')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_week[]" value="6" data-plugin="icheck" @if(in_array('6', $disabled)) checked="true" @endif> &nbsp; {{trans('_.Saturday')}}
											</label>
										</div>
									</div>
								</div>
                            </div>

							<?php
								$disabled = json_decode($tour->disabled_days_month);
							?>

							<div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('tour.Closed month')}}</label>
                                <div class="col-sm-10">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="1" data-plugin="icheck" @if(in_array('1', $disabled)) checked="true" @endif> &nbsp; {{trans('_.January')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="2" data-plugin="icheck" @if(in_array('2', $disabled)) checked="true" @endif> &nbsp; {{trans('_.February')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="3" data-plugin="icheck" @if(in_array('3', $disabled)) checked="true" @endif> &nbsp; {{trans('_.March')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="4" data-plugin="icheck" @if(in_array('4', $disabled)) checked="true" @endif> &nbsp; {{trans('_.April')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="5" data-plugin="icheck" @if(in_array('5', $disabled)) checked="true" @endif> &nbsp; {{trans('_.May')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="6" data-plugin="icheck" @if(in_array('6', $disabled)) checked="true" @endif> &nbsp; {{trans('_.June')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="7" data-plugin="icheck" @if(in_array('7', $disabled)) checked="true" @endif> &nbsp; {{trans('_.July')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="8" data-plugin="icheck" @if(in_array('8', $disabled)) checked="true" @endif> &nbsp; {{trans('_.August')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="9" data-plugin="icheck" @if(in_array('9', $disabled)) checked="true" @endif> &nbsp; {{trans('_.September')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="10" data-plugin="icheck" @if(in_array('10', $disabled)) checked="true" @endif> &nbsp; {{trans('_.October')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="11" data-plugin="icheck" @if(in_array('11', $disabled)) checked="true" @endif> &nbsp; {{trans('_.November')}}
											</label>
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
											<label class="checkbox-inline" style="padding-left:0px;">
		                                		<input type="checkbox" name="disabled_month[]" value="12" data-plugin="icheck" @if(in_array('12', $disabled)) checked="true" @endif> &nbsp; {{trans('_.December')}}
											</label>
										</div>
									</div>
								</div>
                            </div>

							<div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('_.Time')}}</label>
                                <div class="col-sm-10">
									<div class="row" ng-class="{'m-bot15': times.length > 0}">
										<div class="col-sm-3">
											<input type="text" class="form-control" placeholder="({{trans('_.optional')}})" ng-class="{'has-error': errTimeStart}" id="time-start">
										</div>
										<div class="col-sm-1 text-center">
											<p style="margin-top: 6.5px;">&mdash;</p>
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control" placeholder="({{trans('_.optional')}})" id="time-end">
										</div>
										<div class="col-sm-3">
											<button class="btn btn-white" type="button" ng-click="addTime()" ng-disabled="addingTime">{{trans('_.Add')}}</button>
										</div>
									</div>

									<div class="row" ng-show="times.length > 0">
										<div class="col-sm-3">
											<ul class="list-group">
												<li class="list-group-item ui-list-item" ng-repeat="time in times track by $index" ng-controller="timeCtrl" ng-mouseenter="btn=true" ng-mouseleave="btn=false">
													[[time.start]] [[time.end? '- '+time.end : '']]
													<a href="#" ng-click="remove($event, $index)" ng-show="btn"><i class="fa fa-times"></i></a>
												</li>
											</ul>
										</div>
									</div>
								</div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('_.Map')}}</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="map" style="resize: none;" data-plugin="autosize" placeholder="({{trans('_.optional')}})">{!! $tour->map_data !!}</textarea>
									<p style="margin-top: 5px;">
										<a href="/dashboard/howto/map" target="_blank">{{trans('setting.How to get Google Map URL data')}}</a>
									</p>
								</div>
                            </div>

                            <div class="form-group" data-group="highlight">
                                <label class="col-sm-2 control-label">{{trans('_.Highlight')}}</label>
                                <div class="col-sm-10">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#highlight-{{$locale['code']}}" aria-controls="highlight-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="highlight-{{$locale['code']}}">
                                                <div class="input-group m-bot15">
                                                    <input type="text" class="form-control" placeholder="({{trans('_.optional')}})" ng-model="highlightInput.{{$locale['code']}}" ng-keydown="keydownHightlight($event, '{{$locale['code']}}')">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-white" type="button" ng-click="addHightlight('{{$locale['code']}}')">{{trans('_.Add')}}</button>
                                                    </span>
                                                </div>
                                                <ul class="list-group">
                                                    <li class="list-group-item ui-list-item" ng-repeat="i in hightlight['{{$locale['code']}}'] track by $index" ng-controller="ListItem" ng-mouseenter="btn=true" ng-mouseleave="btn=false">
                                                        [[i]]
                                                        <a href="#" ng-click="remove($event, $index, '{{$locale['code']}}')" ng-show="btn"><i class="fa fa-times"></i></a>
                                                    </li>
                                                </ul>

                                                <p class="help-block">
                                                    <em>{{trans('tour.Enter the information that you want, and press Enter or press Add to add the entry.')}}</em>
                                                </p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group" data-group="note">
                                <label class="col-sm-2 control-label">{{trans('_.Note')}}</label>
                                <div class="col-sm-10">

                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($locales as $index => $locale)
                                            <li role="presentation" @if($index == 0) class="active" @endif>
                                                <a href="#note-{{$locale['code']}}" aria-controls="note-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach($locales as $index => $locale)
                                            <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="note-{{$locale['code']}}">
                                                <textarea class="form-control" name="note[{{$locale['code']}}]" placeholder="({{trans('_.optional')}})" data-input-note="{{$locale['code']}}" data-plugin="autosize" style="max-width:100%;">{!! $tour->getNote($locale['code']) !!}</textarea>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
							</div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('_.Keywords')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="keywords" placeholder="({{trans('_.optional')}})" class="form-control" autocomplete="off" id="ipt-keywords" value="{!! $keywords !!}">
								</div>
                            </div>

							<input type="hidden" name="times" value="" id="times">
							<input type="hidden" name="extras" value="" id="extras">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            @foreach($locales as $locale)
                            <input type="hidden" name="hightlight[{{$locale['code']}}]" id="hightlight-{{$locale['code']}}">
                            @endforeach
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
<script type="text/javascript" src="/static/bower_components/codemirror/lib/codemirror.js"></script>
<script type="text/javascript" src="/static/bower_components/codemirror/mode/xml/xml.js"></script>

<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/froala_editor.min.js" ></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/align.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/draggable.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/font_family.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/image.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/inline_style.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/link.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/quick_insert.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/table.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/save.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/url.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/plugins/video.min.js"></script>
<script type="text/javascript" src="/static/bower_components/froala-wysiwyg-editor/js/languages/{{$config['lang']['code']}}.js"></script>

<script src="/static/bower_components/angular-nl2br/angular-nl2br.min.js"></script>
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script src="/static/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="/static/bower_components/moment/moment.js"></script>
<script src="/static/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script>
app.requires.push('nl2br');
app.controller('Form', function($scope, $filter, $timeout){

    $(function(){
		$('#time-start').datetimepicker({
			format: 'hh:mm A',
			useStrict: true
		})
		.on('dp.change', function(e){
			var date = e.date;

			if (date){
				$scope.errTimeStart = false;

				if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
					$scope.$apply();
				}
			}
		});

		$('#time-end').datetimepicker({
			format: 'hh:mm A',
			useStrict: true
		});

        $('input[data-plugin=icheck-map]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        })
        .on('ifChecked', function(event){
            if ($(this).val() == 'yes'){
                $scope.map.show = true;
                $timeout(function(){
                    $scope.map.obj = new GMaps({
                        el: '#map',
                        center: {lat: $scope.map.lat, lng: $scope.map.lng},
                        zoom: $scope.map.zoom,
                        mapTypeId: $scope.map.type,
                        scrollwheel: false,
                        navigationControl: false,
                        mapTypeControl: false,
                        scaleControl: false,
                        draggable: false,
                        zoomControl: false,
                        disableDoubleClickZoom: true,
                    });
                    if ($scope.map.marker.obj){
                        $scope.map.marker.obj = $scope.map.obj.addMarker({
                            lat: $scope.map.marker.lat,
                            lng: $scope.map.marker.lng,
                            infoWindow: {
                                content : $filter('nl2br')($scope.map.marker.description? $scope.map.marker.description.trim(): '')
                            }
                        });
                    }
                }, 700);
                $scope.$apply();
            }
            else {
                $('#map').html('');
                $scope.map = {
                    obj: null,
                    show: false,
                    edit: false,
                    lat: 7.9124046,
                    lng: 98.3489446,
                    zoom: 12,
                    type: 'roadmap',
                    marker: {
                        obj: null,
                        edit: false,
                        lat: 0,
                        lng: 0,
                        description: ''
                    }
                };
                $scope.$apply();
            }
        });

        @if($tour->map == '1')
        $scope.map.show = true;
        $timeout(function(){
            $scope.map.obj = new GMaps({
                el: '#map',
                center: {lat: $scope.map.lat, lng: $scope.map.lng},
                zoom: $scope.map.zoom,
                mapTypeId: $scope.map.type,
                scrollwheel: false,
                navigationControl: false,
                mapTypeControl: false,
                scaleControl: false,
                draggable: false,
                zoomControl: false,
                disableDoubleClickZoom: true,
            });
            if ($scope.map.marker.obj){
                $scope.map.marker.obj = $scope.map.obj.addMarker({
                    lat: $scope.map.marker.lat,
                    lng: $scope.map.marker.lng,
                    infoWindow: {
                        content : $filter('nl2br')($scope.map.marker.description? $scope.map.marker.description.trim(): '')
                    }
                });
            }
        }, 700);
        $scope.$apply();
        @endif;

        autosize($('[data-plugin=autosize]'));

		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	        autosize.update($('[data-plugin=autosize]'));
	    });

        $('[data-plugin=froala-editor]').froalaEditor({
            heightMin: 300,
            placeholderText: '{{trans('_.Detail')}}...',
            language: '{{$config['lang']['code']}}',
            imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
            imageUploadParams: {
                imageid: '{{$tour->imageid}}',
                _token: '{{csrf_token()}}'
            },
            imageUploadURL: '/ajax/dashboard/tours/image',
            toolbarSticky: false
        });

        $('[data-plugin="number"]').bind('keydown', function(e){
            var keyCode = (e.keyCode ? e.keyCode : e.which);

            if ($.inArray(keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            (keyCode == 65 && (e.ctrlKey === true || e.metaKey === true )) ||
            (keyCode >= 35 && keyCode <= 40)) {
                return;
            }
            if ((e.shiftKey || (keyCode < 48 || keyCode > 57)) && (keyCode < 96 || keyCode > 105)) {
                e.preventDefault();
            }
        });

        $('[data-plugin="price"]').bind('keydown', function(e){
            var keyCode = (e.keyCode ? e.keyCode : e.which);

            if ($.inArray(keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (keyCode == 65 && (e.ctrlKey === true || e.metaKey === true )) ||
            (keyCode >= 35 && keyCode <= 40)) {
                return;
            }
            if ((e.shiftKey || (keyCode < 48 || keyCode > 57)) && (keyCode < 96 || keyCode > 105)) {
                e.preventDefault();
            }
        });

        $('input[data-plugin=icheck-price]').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        })
        .on('ifChecked', function(event){
            if ($(this).val() == 'person')
            {
                $('[data-group="price_per_package"]').hide();
				$('[data-group="price_free"]').hide();
                $('[data-group="price_per_person"]').slideDown(350);
            }
            else if ($(this).val() == 'package')
            {
                $('[data-group="price_per_person"]').hide();
				$('[data-group="price_free"]').hide();
                $('[data-group="price_per_package"]').slideDown(350);
            }
			else if ($(this).val() == 'free')
            {
				$('[data-group="price_per_person"]').hide();
				$('[data-group="price_per_package"]').hide();
                $('[data-group="price_free"]').slideDown(350);
            }
        });

        $("#ipt-keywords").tagsinput({
            tagClass: 'label label-danger',
            trimValue: true
        });

        $('#save').bind('click', function(){
            $('#form').submit();
        });

        $('#form').bind('submit', function(e){
            $(this).find('[data-group]').removeClass('has-error');

            var title       = true,
                url         = true,
                iptUrl      = $(this).find('input[name=url]'),
                code        = true,
                iptCode     = $(this).find('input[name=code]'),
                price_type  = $(this).find('input[name=price_type]:checked'),
                price       = false;

            $(this).find('input[data-input-title]').each(function(index, item){
                if ($(item).val().trim() == ''){
                    title = false;
                }
            });
            if (title == false){
                $(this).find('[data-group=title]').addClass('has-error');
            }

            if (iptUrl.val().trim() == '' || !/^[a-zA-Z0-9-]+$/.test(iptUrl.val())){
                $(this).find('[data-group=url]').addClass('has-error');
                url = false;
            }

            if (iptCode.val().trim() == ''){
                $(this).find('[data-group=code]').addClass('has-error');
                code = false;
            }

            if (price_type.val() == 'person')
            {
                if ($(this).find('input[name=price_person_adult]').val().trim() != '' && $(this).find('input[name=price_person_child]').val().trim() != ''){
                    price = true;
                }
                else {
                    price = false;
                }

                if (!price){
                    $(this).find('[data-group=price_per_person]').addClass('has-error');
                }
            }
            else if (price_type.val() == 'package')
            {
                if ($(this).find('input[name=price_package]').val().trim() != '' && $(this).find('input[name=number_package_adult]').val().trim() != ''){
                    price = true;
                }
                else {
                    price = false;
                }

                if (!price){
                    $(this).find('[data-group=price_per_package]').addClass('has-error');
                }
            }
			else if (price_type.val() == 'free')
            {
                if ($(this).find('input[name=maximum_guests]').val().trim() != ''){
                    price = true;
                }
                else {
                    price = false;
                }

                if (!price){
                    $(this).find('[data-group=price_free]').addClass('has-error');
                }
            }

            if (title && url && code && price){
                @foreach($locales as $locale)
                $('#hightlight-{{$locale['code']}}').val($scope.hightlight['{{$locale['code']}}']);
                @endforeach

                $('#times').val( JSON.stringify($scope.times) );
				$('#extras').val( JSON.stringify($scope.extras) );

                $('#save').attr('disabled', true);
                return true;
            }

            e.preventDefault();
        });
    });

	$scope.extras = [];

	@foreach($tour->extras as $extra)
	$scope.extras.push({
		number: {{$extra->number}},
		price: {{$extra->price}}
	});
	@endforeach

	$scope.addExtra = function(){
		if (!$scope.extraNumber || $scope.extraNumber.trim() == '' || !$scope.extraPrice || $scope.extraPrice.trim() == '') {
			$scope.extraError = true;
		}
		else
		{
			$scope.extraError = false;
			$scope.addingExtra = true;

			$scope.extras.push({
				number: $scope.extraNumber,
				price: $scope.extraPrice
			});

			$scope.addingExtra = false;

			$scope.extraNumber = '';
			$scope.extraPrice = '';
		}
	}

	$scope.times = [];

	<?php
		$times = json_decode($tour->times);
	?>
	@foreach($times as $time)
		@if( is_bool($time->end) )
			$scope.times.push({
				start: '{{$time->start}}',
				end: false
			});
		@else
			$scope.times.push({
				start: '{{$time->start}}',
				end: '{{$time->end}}'
			});
		@endif
	@endforeach

	$scope.addTime = function(){
		var timeStart = $('#time-start').val();

		if (timeStart && timeStart.trim() != '' && moment(timeStart.trim(), 'hh:mm A', true).isValid())
		{
			$scope.errTimeStart = false;
			$scope.addingTime = true;

			var _timeEnd = $('#time-end').val(),
				timeEnd = false;

			if (_timeEnd && _timeEnd.trim() != '' && moment(_timeEnd.trim(), 'hh:mm A', true).isValid())
			{
				timeEnd = _timeEnd.trim();
			}

			$scope.times.push({
				start: timeStart.trim(),
				end: timeEnd
			});

			$('#time-start').val('');
			$('#time-end').val('');

			$scope.addingTime = false;

			if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
				$scope.$apply();
			}
		}
		else {
			$scope.errTimeStart = true;
		}
	};

    $scope.hightlight = {};
    $scope.highlightInput = {};

    @foreach($locales as $locale)
    <?php
        $highlight = unserialize($tour->getHighlight($locale['code']));
        $arr = explode(',', $highlight);
    ?>
    @if(count($arr) > 0 && $highlight != '')
    $scope.hightlight['{{$locale['code']}}'] = {!! json_encode($arr) !!};
    @else
    $scope.hightlight['{{$locale['code']}}'] = [];
    @endif
    @endforeach

    $scope.keydownHightlight = function($event, locale){
        if ($event.keyCode == 13){
            $scope.addHightlight(locale);
            $event.preventDefault();
        }
    };

    $scope.addHightlight = function(locale){
        if ($scope.highlightInput[locale] && $scope.highlightInput[locale].trim() != ''){
            $scope.hightlight[locale].push($scope.highlightInput[locale].trim());
            $scope.highlightInput[locale] = null;
        }
    };
});

app.controller('extraCtrl', function($scope){
	$scope.remove = function($event, $index){
		$scope.extras.splice($index, 1);
        $event.preventDefault();
	};
});

app.controller('timeCtrl', function($scope){
	$scope.remove = function($event, $index){
		$scope.times.splice($index, 1);
        $event.preventDefault();
	};
});

app.controller('ListItem', function($scope){
    $scope.btn = false;

    $scope.remove = function($event, index, locale){
        $scope.hightlight[locale].splice(index, 1);
        $event.preventDefault();
    };
});
</script>
@endsection
