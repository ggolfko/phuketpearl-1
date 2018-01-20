@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" type="text/css" href="/static/bower_components/iCheck/skins/flat/red.css">
<link rel="stylesheet" type="text/css" href="/static/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen">
<link rel="stylesheet" href="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen">
<style>
.bootstrap-tagsinput {
    width: 100%;
}
.tag.label.label-danger {
    padding-bottom: 2.5px !important;
}
.bootstrap-tagsinput input[type=text] {
    border: 1px solid #fff;
}
.bootstrap-tagsinput.has-error {
	border-color: #a94442;
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">

        <div class="row" ng-controller="setting">
            <div class="col-lg-9">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-6">
								{{trans('setting.General Settings')}}
							</div>
						</div>
                    </header>
                    <div class="panel-body">

						<form ng-controller="sitename" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.Site name')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="description" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.Site description')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="keywords" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.Site keywords')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<textarea ng-disabled="doing" class="form-control" style="resize:none;" rows="1" data-plugin="autosize" id="input-keyword">{!! implode(', ', $config['keywords']) !!}</textarea>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
									<p class="help-block">{{trans('_.If there is more than one, separate them with commas (,).')}}</p>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="hometitle" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.Home title')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="copyright" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.Copyright')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="defaultlang" ng-submit="execute($event)" class="form-horizontal tasi-form" id="default_lang">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.Default lang')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<div class="ui-default-lang">
											<input ng-disabled="doing" type="radio" name="default_lang" data-plugin="icheck" value="en" @if($config['default_lang'] == 'en') checked @endif> English
											&nbsp;&nbsp;&nbsp;
											<input ng-disabled="doing" type="radio" name="default_lang" data-plugin="icheck" value="th" @if($config['default_lang'] == 'th') checked @endif> ภาษาไทย
										</div>

										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

                    </div>
                </section>

				<section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-6">
								{{trans('setting.Facebook Settings')}}
							</div>
						</div>
                    </header>
                    <div class="panel-body">

						<form ng-controller="fb_appid" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.App Id')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="fb_title" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.Default title')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="fb_description" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.Default description')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="fb_image" class="form-horizontal tasi-form">
							<div class="form-group" ng-class="{'has-error':error}">
	                            <label class="col-sm-3 control-label">{{trans('setting.Default image')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<span class="input-group-btn">
											<button type="button" class="btn btn-default" ng-disabled="doing" ng-click="preview()">
												<i class="fa fa-picture-o"></i>
												{{trans('setting.Preview')}}
											</button>
										</span>
										<input ng-model="filename" type="text" class="form-control" style="background-color: #fff;" disabled="">
										<span class="input-group-btn">
											<button type="button" class="btn btn-danger" ng-disabled="doing" ng-click="browse()">
												<i class="fa fa-file-image-o"></i>
												[[doing? '{{trans('setting.Uploading...')}}': '{{trans('setting.Upload')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
							<input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" ng-disabled="doing" id="fbImageFile">

							<!-- Upload Modal -->
							<div class="modal fade ui_modal" data-backdrop="static" data-keyboard="false" id="fbImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">{{trans('setting.Default image')}}</h5>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<div class="controls col-md-12">
													<div class="m-bot15">
														<img ng-src="/[[temp.file]]" class="img-responsive">
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button data-dismiss="modal" class="btn btn-default" type="button" ng-disabled="doing">{{trans('_.Cancel')}}</button>
											<button class="btn btn-danger" type="button" ng-disabled="doing" ng-click="save()">{{trans('_.Save changes')}}</button>
										</div>
									</div>
								</div>
							</div>
							<!-- modal -->
						</form>

                    </div>
                </section>

				<section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-6">
								{{trans('setting.Contact Information')}}
							</div>
						</div>
                    </header>
                    <div class="panel-body">

						<form ng-controller="phone" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">{{trans('setting.Phone numbers')}}</label>
	                            <div class="col-sm-9">
	                                <div>
	                                    <ul class="nav nav-tabs" role="tablist">
	                                        @foreach($locales as $index => $locale)
	                                        <li role="presentation" @if($index == 0) class="active" @endif>
	                                            <a href="#phone-{{$locale['code']}}" aria-controls="phone-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
	                                        </li>
	                                        @endforeach
	                                    </ul>
	                                    <div class="tab-content">
	                                        @foreach($locales as $index => $locale)
											<?php
												$data = isset($config['phones']->{$locale['code']})? implode(', ', $config['phones']->{$locale['code']}): '';
											?>
	                                        <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="phone-{{$locale['code']}}">
												<div class="input-group" ng-init="init('{{$locale['code']}}', '{{$data}}')">
			                                        <input ng-model="inputs.{{$locale['code']}}" ng-disabled="doing" type="text" class="form-control">
													<span class="input-group-btn">
														<button type="submit" class="btn btn-danger" ng-disabled="doing">
															<i class="fa fa-save"></i>
															[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
														</button>
													</span>
												</div>
	                                        </div>
	                                        @endforeach
	                                    </div>
	                                </div>
									<p class="help-block">{{trans('_.If there is more than one, separate them with commas (,).')}}</p>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="fax" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">{{trans('setting.Fax')}}</label>
	                            <div class="col-sm-9">
	                                <div>
	                                    <ul class="nav nav-tabs" role="tablist">
	                                        @foreach($locales as $index => $locale)
	                                        <li role="presentation" @if($index == 0) class="active" @endif>
	                                            <a href="#fax-{{$locale['code']}}" aria-controls="fax-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
	                                        </li>
	                                        @endforeach
	                                    </ul>
	                                    <div class="tab-content">
	                                        @foreach($locales as $index => $locale)
											<?php
												$data = isset($config['faxes']->{$locale['code']})? implode(', ', $config['faxes']->{$locale['code']}): '';
											?>
	                                        <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="fax-{{$locale['code']}}">
												<div class="input-group" ng-init="init('{{$locale['code']}}', '{{$data}}')">
			                                        <input ng-model="inputs.{{$locale['code']}}" ng-disabled="doing" type="text" class="form-control">
													<span class="input-group-btn">
														<button type="submit" class="btn btn-danger" ng-disabled="doing">
															<i class="fa fa-save"></i>
															[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
														</button>
													</span>
												</div>
	                                        </div>
	                                        @endforeach
	                                    </div>
	                                </div>
									<p class="help-block">{{trans('_.If there is more than one, separate them with commas (,).')}}</p>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="email" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">{{trans('_.Email address')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
									<p class="help-block">{{trans('_.If there is more than one, separate them with commas (,).')}}</p>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="opening" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">{{trans('_.Opening hours')}}</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="address" ng-submit="execute($event)" class="form-horizontal tasi-form" id="address-wrap">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">{{trans('_.Address')}}</label>
	                            <div class="col-sm-9">
									<div>
	                                    <ul class="nav nav-tabs" role="tablist">
	                                        @foreach($locales as $index => $locale)
	                                        <li role="presentation" @if($index == 0) class="active" @endif>
	                                            <a href="#address-{{$locale['code']}}" aria-controls="address-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
	                                        </li>
	                                        @endforeach
	                                    </ul>
	                                    <div class="tab-content">
	                                        @foreach($locales as $index => $locale)
											<?php
												$data = isset($address->{$locale['code']})? $address->{$locale['code']}: '';
											?>
	                                        <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="address-{{$locale['code']}}">
												<div class="input-group">
													<textarea ng-disabled="doing" class="form-control" style="resize:none;" rows="1" data-plugin="autosize" data-locale="{{$locale['code']}}">{!! $data !!}</textarea>
													<span class="input-group-btn">
														<button type="submit" class="btn btn-danger" ng-disabled="doing">
															<i class="fa fa-save"></i>
															[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
														</button>
													</span>
												</div>
	                                        </div>
	                                        @endforeach
	                                    </div>
	                                </div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="map" ng-submit="execute($event)" class="form-horizontal tasi-form" id="map-wrap">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">{{trans('_.Map')}}</label>
	                            <div class="col-sm-9">
									<div>
	                                    <ul class="nav nav-tabs" role="tablist">
	                                        @foreach($locales as $index => $locale)
	                                        <li role="presentation" @if($index == 0) class="active" @endif>
	                                            <a href="#map-{{$locale['code']}}" aria-controls="map-{{$locale['code']}}" role="tab" data-toggle="tab">{{$locale['title']}}</a>
	                                        </li>
	                                        @endforeach
	                                    </ul>
	                                    <div class="tab-content">
	                                        @foreach($locales as $index => $locale)
											<?php
												$data = isset($map->{$locale['code']})? $map->{$locale['code']}: '';
											?>
	                                        <div role="tabpanel" class="tab-pane ui-tab-pane @if($index == 0) active @endif" id="map-{{$locale['code']}}">
												<div class="input-group">
													<textarea ng-disabled="doing" class="form-control" style="resize:none;" rows="1" data-plugin="autosize" data-locale="{{$locale['code']}}">{!! $data !!}</textarea>
													<span class="input-group-btn">
														<button type="submit" class="btn btn-danger" ng-disabled="doing">
															<i class="fa fa-save"></i>
															[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
														</button>
													</span>
												</div>
	                                        </div>
	                                        @endforeach
	                                    </div>
	                                </div>
									<p style="margin-top: 5px;">
										<a href="/dashboard/howto/map" target="_blank">{{trans('setting.How to get Google Map URL data')}}</a>
									</p>
								</div>
							</div>
						</form>

                    </div>
                </section>

				<section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								{{trans('setting.Social Network')}}
								<span style="font-size:13.5px;font-style:normal;margin-left:12px;">({{trans('setting.If you do not want users to see what information is available, leave field empty')}})</span>
							</div>
						</div>
                    </header>
                    <div class="panel-body">

						<form ng-controller="facebook" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">Facebook</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control" placeholder="({{trans('_.optional')}})">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="twitter" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">Twitter</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control" placeholder="({{trans('_.optional')}})">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="instagram" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">Instagram</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control" placeholder="({{trans('_.optional')}})">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="pinterest" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">Pinterest</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control" placeholder="({{trans('_.optional')}})">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="googleplus" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">Google Plus</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control" placeholder="({{trans('_.optional')}})">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>

						<hr>

						<form ng-controller="youtube" ng-submit="execute($event)" class="form-horizontal tasi-form">
							<div class="form-group">
	                            <label class="col-sm-3 control-label">Youtube</label>
	                            <div class="col-sm-9">
	                                <div class="input-group">
										<input ng-model="input" ng-disabled="doing" type="text" class="form-control" placeholder="({{trans('_.optional')}})">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-danger" ng-disabled="doing">
												<i class="fa fa-save"></i>
												[[doing? '{{trans('_.Saving...')}}': '{{trans('_.Save')}}']]
											</button>
										</span>
									</div>
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
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script src="/static/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script src="/static/bower_components/angular-nl2br/angular-nl2br.min.js"></script>
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="/static/bower_components/fancybox/source/helpers/jquery.fancybox-thumbs.js"></script>
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
$(function(){
    autosize($('[data-plugin=autosize]'));

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		autosize.update($('[data-plugin=autosize]'));
	});
});
app.requires.push('nl2br');

//facebook image
app.controller('fb_image', function($scope, $timeout){
	$scope.imageid = '{{$fb_image}}';

	$('#fbImageFile').bind('change', function(e){
		if ( $(this).val().trim() != '' && e.target.files.length == 1 )
		{
			var file = e.target.files[0];

			$scope.filename = file.name;

			if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
				$scope.$apply();
			}

			if ($.inArray(file.type.toLowerCase(), ['image/jpeg', 'image/gif', 'image/png']) >= 0)
			{
				$scope.doing = true;

				if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
					$scope.$apply();
				}

				var formData = new FormData();
				formData.append('file', file);
				formData.append('_token', '{{csrf_token()}}');

				$.ajax({
					url: '/ajax/dashboard/settings/fbimage',
					type: 'POST',
					processData: false,
					contentType: false,
					dataType: 'JSON',
					data: formData
				})
				.success(function(resp){
					if (resp.status == 'ok')
					{
						$scope.temp = resp.payload.image;

						if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
							$scope.$apply();
						}

						$('#fbImageModal').modal('show');

						$timeout(function(){
							$scope.doing = false;

							if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
								$scope.$apply();
							}
						}, 100);
					}
					else
					{
						$scope.doing = false;

						if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
							$scope.$apply();
						}

						noty({
							text: resp.message,
							layout: 'topRight',
							type: 'error',
							dismissQueue: true,
							timeout: 4500,
							template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
							animation: {
								open: {height: 'toggle'},
								close: {height: 'toggle'},
								easing: 'swing',
								speed: 300
							}
						});
					}
				})
				.error(function(){
					$scope.doing = false;

					if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
						$scope.$apply();
					}

					noty({
						text: '{{trans('error.general')}}',
						layout: 'topRight',
						type: 'error',
						dismissQueue: true,
						timeout: 4500,
						template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
						animation: {
							open: {height: 'toggle'},
							close: {height: 'toggle'},
							easing: 'swing',
							speed: 300
						}
					});
				});
			}
			else {
				alert('{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}');
			}
		}

		$(this).val('');
	});

	$scope.preview = function(){
		if (!$scope.doing){
			$.fancybox({
				autoScale: true,
				padding: 9,
				type: 'image',
				href: '/app/fbimage/' + $scope.imageid + '.png'
			});
		}
	}

	$scope.browse = function(){
		$('#fbImageFile').trigger('click');
	}

	$scope.save = function(){
		$scope.error = false;
		$scope.doing = true;

		if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest'){
			$scope.$apply();
		}

		$scope.update('fb_image', $scope.temp, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');

				$scope.filename	= '';
				$scope.imageid	= resp.payload.id;

				$('#fbImageModal').modal('hide');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});
	}
});

//facebook description
app.controller('fb_description', function($scope){
	$scope.input = '{{ $fb_description }}';

	$scope.execute = function($event){
		$scope.error = false;

		if (!$scope.input || $scope.input.trim() == '')
		{
			$scope.error = true;
		}
		else
		{
			$scope.doing = true;

			var data = $scope.input.trim();

			$scope.update('fb_description', data, function(resp){
				$scope.doing = false;

				if (resp.status == 'ok'){
					$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
				}
				else {
					$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
				}
			}, function(){
				$scope.doing = false;
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			});
		}

		$event.preventDefault();
	}
});

//facebook title
app.controller('fb_title', function($scope){
	$scope.input = '{{ $fb_title }}';

	$scope.execute = function($event){
		$scope.error = false;

		if (!$scope.input || $scope.input.trim() == '')
		{
			$scope.error = true;
		}
		else
		{
			$scope.doing = true;

			var data = $scope.input.trim();

			$scope.update('fb_title', data, function(resp){
				$scope.doing = false;

				if (resp.status == 'ok'){
					$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
				}
				else {
					$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
				}
			}, function(){
				$scope.doing = false;
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			});
		}

		$event.preventDefault();
	}
});

//facebook app id
app.controller('fb_appid', function($scope){
	$scope.input = '{{ $fb_appid }}';

	$scope.execute = function($event){
		$scope.error = false;

		if (!$scope.input || $scope.input.trim() == '')
		{
			$scope.error = true;
		}
		else
		{
			$scope.doing = true;

			var data = $scope.input.trim();

			$scope.update('fb_appid', data, function(resp){
				$scope.doing = false;

				if (resp.status == 'ok'){
					$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
				}
				else {
					$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
				}
			}, function(){
				$scope.doing = false;
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			});
		}

		$event.preventDefault();
	}
});

//home title
app.controller('hometitle', function($scope){
	$scope.input = '{{ $home_title }}';

	$scope.execute = function($event){
		$scope.error = false;

		if (!$scope.input || $scope.input.trim() == '')
		{
			$scope.error = true;
		}
		else
		{
			$scope.doing = true;

			var data = $scope.input.trim();

			$scope.update('home_title', data, function(resp){
				$scope.doing = false;

				if (resp.status == 'ok'){
					$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
				}
				else {
					$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
				}
			}, function(){
				$scope.doing = false;
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			});
		}

		$event.preventDefault();
	}
});

//defaultlang
app.controller('defaultlang', function($scope){

	$scope.execute = function($event){
		$scope.doing = true;

		var input = $('#default_lang').find('input[name=default_lang]:checked');

		$scope.update('defaultlang', input.val(), function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//copyright
app.controller('copyright', function($scope){
	$scope.input = '{{ $config['copyright'] }}';

	$scope.execute = function($event){
		$scope.error = false;

		if (!$scope.input || $scope.input.trim() == '')
		{
			$scope.error = true;
		}
		else
		{
			$scope.doing = true;

			var data = $scope.input.trim();

			$scope.update('copyright', data, function(resp){
				$scope.doing = false;

				if (resp.status == 'ok'){
					$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
				}
				else {
					$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
				}
			}, function(){
				$scope.doing = false;
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			});
		}

		$event.preventDefault();
	}
});

//keywords
app.controller('keywords', function($scope){

	$scope.execute = function($event){
		var val = $('#input-keyword').val();

		$scope.error = false;

		if (!val || val.trim() == '')
		{
			$scope.error = true;
		}
		else
		{
			$scope.doing = true;

			var data = val.trim();

			$scope.update('keywords', data, function(resp){
				$scope.doing = false;

				if (resp.status == 'ok'){
					$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
				}
				else {
					$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
				}
			}, function(){
				$scope.doing = false;
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			});
		}

		$event.preventDefault();
	}
});

//description
app.controller('description', function($scope){
	$scope.input = '{{ $config['description'] }}';

	$scope.execute = function($event){
		$scope.error = false;

		if (!$scope.input || $scope.input.trim() == '')
		{
			$scope.error = true;
		}
		else
		{
			$scope.doing = true;

			var data = $scope.input.trim();

			$scope.update('description', data, function(resp){
				$scope.doing = false;

				if (resp.status == 'ok'){
					$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
				}
				else {
					$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
				}
			}, function(){
				$scope.doing = false;
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			});
		}

		$event.preventDefault();
	}
});

//sitename
app.controller('sitename', function($scope){
	$scope.input = '{{ $config['name'] }}';

	$scope.execute = function($event){
		$scope.error = false;

		if (!$scope.input || $scope.input.trim() == '')
		{
			$scope.error = true;
		}
		else
		{
			$scope.doing = true;

			var data = $scope.input.trim();

			$scope.update('sitename', data, function(resp){
				$scope.doing = false;

				if (resp.status == 'ok'){
					$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
				}
				else {
					$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
				}
			}, function(){
				$scope.doing = false;
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			});
		}

		$event.preventDefault();
	}
});

//youtube
app.controller('youtube', function($scope){
	$scope.input = '{{ $config['youtube'] }}';

	$scope.execute = function($event){
		$scope.doing = true;

		var data = $scope.input? $scope.input.trim(): '';

		$scope.update('youtube', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//googleplus
app.controller('googleplus', function($scope){
	$scope.input = '{{ $config['googleplus'] }}';

	$scope.execute = function($event){
		$scope.doing = true;

		var data = $scope.input? $scope.input.trim(): '';

		$scope.update('googleplus', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//pinterest
app.controller('pinterest', function($scope){
	$scope.input = '{{ $config['pinterest'] }}';

	$scope.execute = function($event){
		$scope.doing = true;

		var data = $scope.input? $scope.input.trim(): '';

		$scope.update('pinterest', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//instagram
app.controller('instagram', function($scope){
	$scope.input = '{{ $config['instagram'] }}';

	$scope.execute = function($event){
		$scope.doing = true;

		var data = $scope.input? $scope.input.trim(): '';

		$scope.update('instagram', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//twitter
app.controller('twitter', function($scope){
	$scope.input = '{{ $config['twitter'] }}';

	$scope.execute = function($event){
		$scope.doing = true;

		var data = $scope.input? $scope.input.trim(): '';

		$scope.update('twitter', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//facebook
app.controller('facebook', function($scope){
	$scope.input = '{{ $config['facebook'] }}';

	$scope.execute = function($event){
		$scope.doing = true;

		var data = $scope.input? $scope.input.trim(): '';

		$scope.update('facebook', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//map
app.controller('map', function($scope){

	$scope.execute = function($event){
		$scope.doing = true;

		var data = [];

		$('#map-wrap').find('textarea').each(function(index, item){
			data.push({
				locale: $(item).attr('data-locale'),
				data: $(item).val().trim()
			});
		});

		$scope.update('map', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//address
app.controller('address', function($scope){

	$scope.execute = function($event){
		$scope.doing = true;

		var data = [];

		$('#address-wrap').find('textarea').each(function(index, item){
			data.push({
				locale: $(item).attr('data-locale'),
				data: $(item).val().trim()
			});
		});

		$scope.update('address', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//opening hours
app.controller('opening', function($scope){
	$scope.input = '{{ $opening_hours }}';

	$scope.execute = function($event){
		$scope.doing = true;

		var data = $scope.input? $scope.input.trim(): '';

		$scope.update('opening', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//email
app.controller('email', function($scope){
	$scope.input = '{{ implode(', ', $config['emails']) }}';

	$scope.execute = function($event){
		$scope.doing = true;

		var data = $scope.input? $scope.input.trim(): '';

		$scope.update('email', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//fax
app.controller('fax', function($scope){
	$scope.inputs = {};

	$scope.init = function(locale, data){
		$scope.inputs[locale] = data;
	}

	$scope.execute = function($event){
		$scope.doing = true;

		var data = []

		angular.forEach($scope.inputs, function(input, key){
			data.push({
				locale: key,
				data: input
			});
		});

		$scope.update('fax', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//phone
app.controller('phone', function($scope){
	$scope.inputs = {};

	$scope.init = function(locale, data){
		$scope.inputs[locale] = data;
	}

	$scope.execute = function($event){
		$scope.doing = true;

		var data = []

		angular.forEach($scope.inputs, function(input, key){
			data.push({
				locale: key,
				data: input
			});
		});

		$scope.update('phone', data, function(resp){
			$scope.doing = false;

			if (resp.status == 'ok'){
				$scope.alert.success('{{trans('_.The operation is completed.')}} {{trans('_.Save changes successfully.')}}');
			}
			else {
				$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
			}
		}, function(){
			$scope.doing = false;
			$scope.alert.error('{{trans('error.notcompleted')}} {{trans('error.general')}}');
		});

		$event.preventDefault();
	}
});

//parent
app.controller('setting', function($scope, $http){
	$scope.update = function(property, value, success, error){
		$http.post('/ajax/dashboard/settings/update', {
			property: property,
			value: value
		})
		.success(function(resp){
			if (typeof success == 'function') success(resp);
		})
		.error(function(){
			if (typeof error == 'function') error();
		});
	};

	$scope.alert = {
		error: function(message){
			noty({
				text: message,
				layout: 'topRight',
				type: 'error',
				dismissQueue: true,
				timeout: 4500,
				template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
				animation: {
					open: {height: 'toggle'},
					close: {height: 'toggle'},
					easing: 'swing',
					speed: 300
				}
			});
		},
		success: function(message){
			noty({
				text: message,
				layout: 'topRight',
				type: 'success',
				dismissQueue: true,
				timeout: 4500,
				template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
				animation: {
					open: {height: 'toggle'},
					close: {height: 'toggle'},
					easing: 'swing',
					speed: 300
				}
			});
		}
	};
});
</script>
@endsection
