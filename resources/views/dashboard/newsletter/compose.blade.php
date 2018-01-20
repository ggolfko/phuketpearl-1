@extends('dashboard.layout')

@section('head')
<link href="/static/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet" type="text/css">
<link href="/static/bower_components/angular-tooltips/dist/angular-tooltips.min.css" rel="stylesheet" type="text/css">
<link href="/static/bower_components/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css">
<link href="/static/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css">
<style>
body {
    overflow-y: scroll !important;
}
.ui-iframe {
    position: relative;
    width: 100%;
    overflow: hidden;
    margin-bottom: 20px;
}
.ui-iframe iframe {
    border: 1px solid #ccc;
    overflow: hidden !important;
    width: 100%;
}
.options-head {
    color: #333;
    font-size: 13.5px;
    margin: 0px;
    margin-bottom: 10px;
}
.options-item {
    width: 100%;
    margin-bottom: 5px;
}
.modal-footer.small button {
    font-size: 12.5px;
}
.image-wrapper {
    position: relative;
    width: 100%;
    height: 350px;
}
.image-wrapper .disabled {
    position: absolute;;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    background-color: rgba(255,255,255,.5);
}
.image-items {
    position: relative;
    border: 1px solid #ccc;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: visible;
    padding: 2px;
    padding-bottom: 100px;
}
.image-items .item {
    position: relative;
    display: block;
    float: left;
    height: 102px;
    width: 102px;
    border: 1px solid #f4f4f4;
    border-radius: 2px;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    margin: 3px;
}
.image-items .item a {
    display: block;
    width: 100px;
    height: 100px;
}
.image-items .item img {
    display: block;
    width: 100px;
    height: 100px;
}
.image-items .item:hover {
    border-color: #ff6c60;
}
.image-items .item .fa {
    position: absolute;
    color: #ff6c60;
    font-size: 16px;
    cursor: pointer;
    display: none;
}
.image-items .item .fa._remove {
    bottom: 2px;
    right: 4px;
}
.image-items .item .fa._preview {
    bottom: 2px;
    left: 4px;
}
.image-items .item:hover .fa {
    display: block;
}
.select-subscriber-option {
    display: inline-block;
    margin-right: 30px;
}
.select-subscriber-option .iradio_flat-red {
    display: block;
    float: left;
}
.select-subscriber-option span {
    display: block;
    float: left;
    padding-left: 7px;
}
.select-subscriber {
    display: none;
}
.select-subscriber h3 {
    font-size: 13.5px;
    text-decoration: underline;
    text-align: center;
}
.select-subscriber-input {
    width: 100%;
    max-width: 100%;
}
.ms-list span {
    font-size: 12.5px;
}
.subscriber-link {
    font-weight: bold;
    color: #a94442;
    margin-left: 10px;
}
.subscriber-link:hover {
    text-decoration: underline;
    color: #a94442;
}

.ui-step {
	position: relative;
	margin-bottom: 115px;
	margin-top: 35px;
	z-index: 10;
}
.ui-step .ui-step-progressbar {
	margin: 0;
	padding: 0;
	counter-reset: step;
	position: relative;
}
.ui-step .ui-step-progressbar li {
	list-style-type: none;
	width: 33.33%;
	float: left;
	font-size: 12px;
	position: relative;
	text-align: center;
	text-transform: uppercase;
	color: #7d7d7d;
}
.ui-step .ui-step-progressbar li:before {
	width: 30px;
	height: 30px;
	content: counter(step);
	counter-increment: step;
	line-height: 28px;
	border: 2px solid #7d7d7d;
	display: block;
	text-align: center;
	margin: 0 auto 10px auto;
	border-radius: 50%;
	background-color: white;
}
.ui-step .ui-step-progressbar li:after {
	width: 100%;
	height: 2px;
	content: '';
	position: absolute;
	background-color: #7d7d7d;
	top: 15px;
	left: -50%;
	z-index: -1;
}
.ui-step .ui-step-progressbar li:first-child:after {
	content: none;
}
.ui-step .ui-step-progressbar li.is-active {
	color: green;
}
.ui-step .ui-step-progressbar li.is-active:before {
	border-color: #55b776;
}
.ui-step .ui-step-progressbar li.is-active + li:after {
	background-color: #55b776;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Builder">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-sm-12">
								<a href="/dashboard/newsletter" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('subscribe.Compose')}}</span>
                                <button type="button" class="btn btn-sm btn-danger pull-right" ng-click="send()" ng-disabled="!loadedSubscriber || errorSubscriber || subscriber < 1"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{trans('_.Send')}}</button>
                                <button type="button" class="btn btn-sm btn-danger pull-right" ng-click="preview()" style="margin-right: 5px;">{{trans('_.Preview')}}</button>
							</div>
						</div>
                    </header>
					<div class="panel-body" style="min-height:calc(100vh - 165px);">
                        <div class="row">
                            <div class="col-md-9">
								<div class="alert alert-warning" style="margin-bottom: 20px;">
                                    <strong>Warning!</strong> {{trans('subscribe.WARNING')}}&nbsp;
									<a href="https://mailchimp.com/pricing/entrepreneur/" target="_blank" class="btn btn-white btn-xs">{{trans('subscribe.More information')}}</a>
                                </div>
                                <div class="alert alert-danger" style="margin-bottom: 20px;" ng-if="loadedSubscriber && subscriber < 1 && !errorSubscriber">
                                    {{trans('subscribe.You can not send the newsletter now, because there is not yet subscribers.')}}
                                    <a href="/dashboard/newsletter/subscribers" class="subscriber-link">{{trans('subscribe.Subscribers')}}</a>
                                </div>
								<div class="alert alert-danger" style="margin-bottom: 20px;" ng-if="loadedSubscriber && subscriber < 1 && errorSubscriber">
                                    {{trans('subscribe.ERROR_LOAD_SUBSCRIBER')}} &nbsp;
                                    <button type="button" class="btn btn-xs btn-danger" ng-click="reload()" ng-disabled="disabled">{{trans('_.Reload')}}</button>
                                </div>
								<div class="row" style="margin-bottom: 30px;">
									<div class="form-group" ng-class="{'has-error': error}">
			                            <label class="col-sm-2 control-label" style="padding-top: 4.5px;">
											{{trans('subscribe.Subject')}}
										</label>
			                            <div class="col-sm-10">
			                                <input ng-model="subject" placeholder="({{trans('_.required')}})" type="text" class="form-control" maxlength="256" autocomplete="off" id="subject">
			                            </div>
			                        </div>
								</div>
                                <div class="ui-iframe">
                                    <iframe src="/ajax/dashboard/newsletter/builder" scrolling="no" class="hidden" ng-style="frameStyle" id="ui-iframe"></iframe>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <h2 class="options-head">{{trans('subscribe.Sections Appearance')}}</h2>
                                <div class="options-item">
                                    <input bs-switch ng-model="blocks.section1" type="checkbox" switch-change="switchHandler()" switch-on-text="Section 1" switch-off-text="Section 1" switch-size="small">
                                </div>
                                <div class="options-item">
                                    <input bs-switch ng-model="blocks.section2" type="checkbox" switch-change="switchHandler()" switch-on-text="Section 2" switch-off-text="Section 2" switch-size="small">
                                </div>
                                <div class="options-item">
                                    <input bs-switch ng-model="blocks.section3" type="checkbox" switch-change="switchHandler()" switch-on-text="Section 3" switch-off-text="Section 3" switch-size="small">
                                </div>
                                <div class="options-item">
                                    <input bs-switch ng-model="blocks.section4" type="checkbox" switch-change="switchHandler()" switch-on-text="Section 4" switch-off-text="Section 4" switch-size="small">
                                </div>
                                <div class="options-item">
                                    <input bs-switch ng-model="blocks.section5" type="checkbox" switch-change="switchHandler()" switch-on-text="Section 5" switch-off-text="Section 5" switch-size="small">
                                </div>
                                <div class="options-item">
                                    <input bs-switch ng-model="blocks.section6" type="checkbox" switch-change="switchHandler()" switch-on-text="Section 6" switch-off-text="Section 6" switch-size="small">
                                </div>
                                <div class="options-item">
                                    <input bs-switch ng-model="blocks.section7" type="checkbox" switch-change="switchHandler()" switch-on-text="Section 7" switch-off-text="Section 7" switch-size="small">
                                </div>
                                <div class="options-item">
                                    <input bs-switch ng-model="blocks.section8" type="checkbox" switch-change="switchHandler()" switch-on-text="Section 8" switch-off-text="Section 8" switch-size="small">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </section>

    <!-- Image Modal -->
    <div class="modal fade ui_modal" id="imageModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" ng-controller="Image">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{trans('subscribe.Choose an image')}}</h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger fade in" ng-class="{'hidden':!errorImage}">
                        <span ng-bind-html="errorImage"></span>
                    </div>

                    <form action="#" class="form-horizontal tasi-form">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="image-wrapper">
                                    <div class="image-items">
                                        <div class="item" tooltips tooltip-template="[[image.name]]" tooltip-side="bottom" tooltip-size="small" ng-repeat="image in imagesSource track by $index" ng-controller="ImageItem" ng-class="{'hidden':removed}">
                                            <a href="#" ng-click="choose($event, image.imageid)">
                                                <img ng-src="/app/newsletter/[[image.imageid]]_t.png">
                                            </a>
											<i class="fa fa-search-plus _preview" aria-hidden="true" ng-click="preview(image.imageid)"></i>
											<i class="fa fa-trash-o _remove" aria-hidden="true" ng-click="delete(image.imageid)"></i>
                                        </div>
                                    </div>
                                    <div class="disabled" ng-class="{'hidden':!process}"></div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer small">
                    <input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" id="imageFile" ng-disabled="process" multiple>
                    <button class="btn btn-danger pull-left" type="button" ng-disabled="process" ng-click="upload()"><i class="fa fa-picture-o" aria-hidden="true"></i> {{trans('subscribe.Upload images')}}</button>
                    <img src="/static/dashboard/assets/img/process.gif" class="ui-process pull-left" style="margin-top: 9px; margin-left: 12px;" ng-class="{'hidden': !process}">
                    <button data-dismiss="modal" class="btn btn-default" type="button" ng-disabled="process">{{trans('_.Close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <!-- Button Modal -->
    <div class="modal fade ui_modal" id="buttonModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" ng-controller="Button">
    	<div class="modal-dialog">
    		<div class="modal-content">
                <form action="#" class="form-horizontal tasi-form" ng-submit="done($event)">
        			<div class="modal-header">
        				<h5 class="modal-title">{{trans('subscribe.Button information')}}</h5>
        			</div>
        			<div class="modal-body">
                        <div class="form-group" ng-class="{'has-error':error.text}">
                            <label class="col-sm-2 control-label">{{trans('_.Text')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" maxlength="50" ng-model="button.text" id="buttonModalText" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group" ng-class="{'has-error':error.link}">
                            <label class="col-sm-2 control-label">{{trans('_.URL Link')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="{{trans('_.example')}}: http://google.co.th" ng-model="button.link" autocomplete="off">
                                <p class="help-block"><em>{{trans('subscribe.You can insert the link of this website by go to the web page, then copy the URL in the URL address.')}}</em></p>
                            </div>
                        </div>
        			</div>
        			<div class="modal-footer small">
                        <button class="btn btn-danger" type="submit">{{trans('_.Done')}}</button>
        				<button data-dismiss="modal" class="btn btn-default" type="button">{{trans('_.Cancel')}}</button>
        			</div>
                </form>
    		</div>
    	</div>
    </div>
    <!-- modal -->

    <!-- Text Modal -->
    <div class="modal fade ui_modal" id="textModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" ng-controller="Text">
    	<div class="modal-dialog">
    		<div class="modal-content">
                <form action="#" class="form-horizontal tasi-form" ng-submit="done($event)">
        			<div class="modal-header">
        				<h5 class="modal-title">{{trans('subscribe.Edit text')}}</h5>
        			</div>
        			<div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{trans('_.Text')}}</label>
                            <div class="col-sm-10" ng-class="{'hidden':displayInput != 'single'}">
                                <input type="text" class="form-control" maxlength="128" ng-model="edittext.single" id="textModalSingle" autocomplete="off">
                            </div>
                            <div class="col-sm-10" ng-class="{'hidden':displayInput != 'multiple'}">
                                <textarea class="form-control" data-plugin="autosize" style="max-width:100%;" ng-model="edittext.multiple" id="textModalMultiple"></textarea>
                            </div>
                        </div>
        			</div>
        			<div class="modal-footer small">
                        <button class="btn btn-danger" type="submit">{{trans('_.Done')}}</button>
        				<button data-dismiss="modal" class="btn btn-default" type="button">{{trans('_.Cancel')}}</button>
        			</div>
                </form>
    		</div>
    	</div>
    </div>
    <!-- modal -->

    <!-- Send Modal -->
    <div class="modal fade ui_modal" id="sendModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" ng-controller="Send">
    	<div class="modal-dialog">
    		<div class="modal-content">
                <form action="#" class="form-horizontal tasi-form" ng-submit="confirm($event)">
        			<div class="modal-header">
        				<h5 class="modal-title">{{trans('subscribe.Confirmation')}}</h5>
        			</div>
        			<div class="modal-body">
                        <div class="alert alert-warning" ng-if="!sent">
        					{{trans('subscribe.WARNING_SEND')}}
        				</div>
						<div class="alert alert-success" ng-if="sent">
        					{{trans('subscribe.DELIVERED')}}
        				</div>

						<div class="ui-step">
							<ul class="ui-step-progressbar">
								<li ng-class="{'is-active': step > 1}">
									<span ng-if="step < 1">{{trans('subscribe.Draft Message')}}</span>
									<span ng-if="step == 1">{{trans('subscribe.Drafting')}}</span>
									<span ng-controller="processing" ng-if="step == 1">[[content]]</span>
									<span ng-if="step > 1">{{trans('subscribe.Drafted')}}</span>
								</li>
								<li ng-class="{'is-active': step > 2}">
									<span ng-if="step < 2">{{trans('subscribe.Create Campaign')}}</span>
									<span ng-if="step == 2">{{trans('subscribe.Creating Campaign')}}</span>
									<span ng-controller="processing" ng-if="step == 2">[[content]]</span>
									<span ng-if="step > 2">{{trans('subscribe.Created Campaign')}}</span>
								</li>
								<li ng-class="{'is-active': step > 3}">
									<span ng-if="step < 3">{{trans('subscribe.Deliver')}}</span>
									<span ng-if="step == 3">{{trans('subscribe.Delivering')}}</span>
									<span ng-controller="processing" ng-if="step == 3">[[content]]</span>
									<span ng-if="step > 3">{{trans('subscribe.Delivered')}}</span>
								</li>
							</ul>
						</div>
        			</div>
        			<div class="modal-footer small">
						<button type="button" class="btn btn-sm btn-danger pull-left" ng-click="preview()" ng-disabled="sending || sent">{{trans('_.Preview')}}</button>
						<button data-dismiss="modal" class="btn btn-default" type="button" ng-disabled="sending || sent">{{trans('_.Cancel')}}</button>
        				<button class="btn btn-danger" type="submit" ng-disabled="sending || sent">[[(sending?'{{trans('_.Sending...')}}':'{{trans('_.Send')}}')]]</button>
        			</div>
                </form>
    		</div>
    	</div>
    </div>
    <!-- modal -->

</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
<script src="/static/bower_components/angular-bootstrap-switch/dist/angular-bootstrap-switch.min.js"></script>
<script src="/static/bower_components/angular-tooltips/dist/angular-tooltips.min.js"></script>
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script src="/static/bower_components/multiselect/js/jquery.multi-select.js"></script>
<script>
app.requires.push('frapontillo.bootstrap-switch');
app.requires.push('720kb.tooltips');
app.requires.push('ngSanitize');

app.controller('Send', function($scope, $http, $window, $timeout){
    $scope.sending = false;
    $scope.error = false;
	$scope.step = 0;

    $scope.confirm = function($event){
        $scope.sending = true;
		$scope.step = 1;
		$scope.stepDraft();

		$event.preventDefault();
    };

	//deliver
	$scope.stepDeliver = function(_id, campaign_id){
		$scope.step = 3;

		$http.post('/ajax/dashboard/newsletter/' + _id + '/deliver', {
			campaign_id: campaign_id
		})
		.success(function(data){
			if (data.status == 'ok')
			{
				$scope.step	= 4;
				$scope.sent	= true;

				$timeout(function(){
					$window.location.href = '/dashboard/newsletter/' + _id;
				}, 2000);
			}
			else {
				alert(data.message);
				$window.location.reload();
			}
		})
		.error(function(){
			alert('{{trans('error.general')}}');
			$window.location.reload();
		})
		.finally(function(){
			$scope.sending = false;
		});
	};

	//create campaign
	$scope.stepCampaign = function(_id){
		$scope.step = 2;

		$http.post('/ajax/dashboard/newsletter/' + _id + '/campaign')
		.success(function(data){
			if (data.status == 'ok') {
				$scope.stepDeliver(_id, data.payload.campaign_id);
			}
			else {
				alert(data.message);
				$window.location.reload();
			}
		})
		.error(function(){
			alert('{{trans('error.general')}}');
			$window.location.reload();
		});
	};

	//draft
	$scope.stepDraft = function(){
		$http.post('/ajax/dashboard/newsletter/send', {
			subject: $scope.subject.trim(),
			blocks: $scope.blocks,
			images: $scope.images,
			buttons: $scope.buttons,
			text: $scope.text
		})
		.success(function(data){
			if (data.status == 'ok') {
				$scope.stepCampaign(data.payload._id);
			}
			else {
				alert(data.message);
				$window.location.reload();
			}
		})
		.error(function(){
			alert('{{trans('error.general')}}');
			$window.location.reload();
		});
	};
});

app.controller('processing', function($scope, $timeout){
	$scope.content	= '.';
	$scope.count	= 2;

	$scope.loop = function(){
		$timeout(function(){
			if ($scope.count > 5){
				$scope.count = 1;
			}

			$scope.content = '';

			for (var i = 0; i < $scope.count; i++){
				$scope.content += '.';
			}

			$scope.count++;

			$scope.loop();
		}, 1000);
	}

	$scope.loop();
});

app.controller('ImageItem', function($scope, $http, $window, $timeout){
    $scope.removed = false;

    $scope.delete = function(imageid){
        $scope.removed = true;
		$http.post('/ajax/dashboard/newsletter/image/'+imageid+'/delete')
		.success(function(resp){
			if (resp.status != 'ok'){
				alert(resp.message);
				$scope.removed = false;
			}
		})
		.error(function(){
			alert('{{trans('error.general')}}');
			$window.location.reload();
		});
    };

    $scope.choose = function($event, imageid){
        $scope.images[$scope.section][$scope.index] = imageid;
        $scope.iframe.$apply();
        $('#imageModal').modal('hide');
        $event.preventDefault();
    };

    $scope.preview = function(imageid){
        $.fancybox('/app/newsletter/'+imageid+'.png', {
            padding: 0,
            closeBtn: false
        });
    };
});

app.controller('Image', function($scope){
    $scope.process = false;
    $scope.errorMessage = null;

    $scope.upload = function(){
        $('#imageFile').trigger('click');;
    };

    $('#imageFile').bind('change', function(e){
        if ($(this).val() != '' && e.target.files.length > 0)
        {
            var files = e.target.files, valid = true, validSize = true;

            $.each(files, function(i, file){

                if ($.inArray(file.type.toLowerCase(), ['image/jpeg', 'image/gif', 'image/png']) < 0) {
                    valid = false;
                }

				var size = file.size / (1024*1024);

				if (size > 1.2){
					validSize = false;
				}
            });

			if (!validSize){
				$scope.errorImage = '{{trans('newsletter.Each image must be no larger than 1 MB.')}}';
				$scope.$apply();
			}
            else if (valid)
            {
                if (files.length <= 10)
                {
                    $scope.process = true;
                    $scope.errorImage = null;
                    $scope.$apply();

                    var formData = new FormData();
                    $.each(files, function(i, file){
                        formData.append('image[]', file);
                    });
                    formData.append('_token', '{{csrf_token()}}');

                    $.ajax({
                        url: '/ajax/dashboard/newsletter/images',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                        data: formData
                    })
                    .success(function(resp){
                        if (resp.status == 'ok'){
                            $('#imageFile').val('');
                            $scope.fetchImages();
                        }
                        else {
                            $scope.errorImage = resp.message;
                        }
                    })
                    .error(function(){
                        $scope.errorImage = '{{trans('error.image')}}';
                    })
                    .complete(function(){
                        $scope.process = false;
                        $scope.$apply();
                    });
                }
                else {
                    $scope.errorImage = '{{trans('gallery.Upload images up to 10 files at a time.')}}';
                    $scope.$apply();
                }
            }
            else {
                $scope.errorImage = '{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}';
                $scope.$apply();
            }
        }
    });
});

app.controller('Button', function($scope){
    $scope.error    = {};
    $scope.button   = {};

    $scope.done = function($event){
        $scope.error = {};

        if (!$scope.button.text || $scope.button.text.trim() == ''){
            $scope.error.text = true;
        }
        if (!$scope.button.link || $scope.button.link.trim() == '' || !/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test($scope.button.link)){
            $scope.error.link = true;
        }

        if (($scope.button.text && $scope.button.text.trim() != '') && ($scope.button.link && $scope.button.link.trim() != '' && /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test($scope.button.link)))
        {
            $scope.buttons[$scope.section][$scope.index].text   = $scope.button.text.trim();
            $scope.buttons[$scope.section][$scope.index].link   = $scope.button.link.trim();
            $('#buttonModal').modal('hide');
        }
        $event.preventDefault();
    };

    $('#buttonModal').modal({
        show: false
    })
    .on('show.bs.modal', function(e){
        $scope.error = {};
        $scope.button.text  = $scope.buttons[$scope.section][$scope.index].text? $scope.buttons[$scope.section][$scope.index].text: null;
        $scope.button.link  = $scope.buttons[$scope.section][$scope.index].link? $scope.buttons[$scope.section][$scope.index].link: null;
        $scope.$apply();
    })
    .on('shown.bs.modal', function(e){
        $('#buttonModalText').focus();
    })
    .on('hidden.bs.modal', function(){
        var height = 0;
        $('#ui-iframe').contents().find('[data-table]').each(function(index, item){
            height += $(item).height();
        });
        $scope.frameStyle.height = height;
        $scope.$apply();
    });
});

app.controller('Text', function($scope, $timeout){
    $scope.edittext = {};

    $scope.done = function($event){
        if ($scope.text_type == 'single'){
            $scope.text[$scope.section][$scope.index] = $scope.edittext.single;
        }
        else if ($scope.text_type == 'multiple'){
            $scope.text[$scope.section][$scope.index] = $scope.edittext.multiple;
        }
        $('#textModal').modal('hide');

        $timeout(function(){
            $scope.$apply();
            $scope.iframe.$apply();
        }, 300);

        $event.preventDefault();
    };

    $('#textModal').modal({
        show: false
    })
    .on('show.bs.modal', function(e){
        $scope.displayInput = $scope.text_type;

        if ($scope.text_type == 'single'){
            $scope.edittext.single = $scope.text[$scope.section][$scope.index]? $scope.text[$scope.section][$scope.index]: '';
        }
        else if ($scope.text_type == 'multiple'){
            $scope.edittext.multiple = $scope.text[$scope.section][$scope.index]? $scope.text[$scope.section][$scope.index]: '';
        }
        $scope.$apply();
    })
    .on('shown.bs.modal', function(e){
        autosize.update($('[data-plugin=autosize]'));

        if ($scope.text_type == 'single'){
            $('#textModalSingle').focus();
        }
        else if ($scope.text_type == 'multiple'){
            $('#textModalMultiple').focus();
        }
    })
    .on('hidden.bs.modal', function(){
        var height = 0;
        $('#ui-iframe').contents().find('[data-table]').each(function(index, item){
            height += $(item).height();
        });
        $scope.frameStyle.height = height;
        $scope.$apply();
    });
});

app.controller('Builder', function($scope, $timeout, $window, $http){
	$scope.subscriber = 0;
	$scope.loadedSubscriber = false;
	$scope.errorSubscriber = false;

	$http.get('/ajax/dashboard/newsletter/subscribers')
	.success(function(data){
		if (data.status == 'ok'){
			$scope.subscriber = data.payload.members;
		}
	})
	.error(function(){
		$scope.errorSubscriber = true;
	})
	.finally(function(){
		$scope.loadedSubscriber = true;
	});

	$scope.reload = function(){
		$window.location.reload();
		$scope.disabled = true;
	};

    $scope.imagesSource = [];
    $scope.fetchImages = function(){
        $scope.imagesSource = [];

        $http.get('/ajax/dashboard/newsletter/images')
        .success(function(resp){
            if (resp.status == 'ok'){
                $scope.imagesSource = resp.payload.items;
            }
            else {
                alert(resp.message);
            }
        })
        .error(function(){
            alert('{{trans('error.general')}}');
            $window.location.reload();
        });
    };
    $('#imageModal').modal({
        backdrop: 'static',
        show: false
    })
    .on('show.bs.modal', function(e){
        $scope.fetchImages();
    })
    .on('hide.bs.modal', function(e){
        $http.get('/ajax/dashboard/newsletter/imagesid')
        .success(function(resp){
            if (resp.status == 'ok'){
                $.each($scope.images, function(index_i, section){
                    $.each(section, function(index_j, item){
                        if (item){
                            if ($.inArray(item, resp.payload.items) < 0){
                                $scope.images[index_i][index_j] = false;
                            }
                        }
                    });
                });
            }
        });
    })
    .on('hidden.bs.modal', function(){
        var height = 0;
        $('#ui-iframe').contents().find('[data-table]').each(function(index, item){
            height += $(item).height();
        });
        $scope.frameStyle.height = height;
        $scope.$apply();
    });
    $scope.editImage = function(section, index){
        $scope.section  = section;
        $scope.index    = index;
        $('#imageModal').modal('show');
    };
    $scope.editButton = function(section, index){
        $scope.section  = section;
        $scope.index    = index;
        $('#buttonModal').modal('show');
    };
    $scope.editText = function(section, index, text_type){
        $scope.section      = section;
        $scope.index        = index;
        $scope.text_type    = text_type;
        $('#textModal').modal('show');
    };

    $scope.preview = function(){
        $window.previewObject = {
            blocks: $scope.blocks,
            images: $scope.images,
            buttons: $scope.buttons,
            text: $scope.text
        };

        $.fancybox({
            'width'				: '75%',
            'height'			: '90%',
            'padding'           : 0,
            'autoScale'     	: false,
            'transitionIn'		: 'none',
            'transitionOut'		: 'none',
            'type'				: 'iframe',
            'href'              : '/ajax/dashboard/newsletter/preview'
        });
    };

    $('#sendModal').modal({
        backdrop: 'static',
        show: false
    })
    .on('shown.bs.modal', function(e){
        $('#sendModalSubject').focus();
    });
    $scope.send = function(){
		if (!$scope.subject || $scope.subject.trim() == '') {
			$scope.error = true;
			$('#subject').focus();
		}
		else
		{
			$scope.error = false;
			$('#sendModal').modal('show');
		}
    };

    $scope.frameStyle = {height: '100vh'};

    $(function(){
        $('#ui-iframe').bind('load', function(){
            $('#ui-iframe').removeClass('hidden');
            $scope.frameStyle.height = $(this).contents().height()+'px';
            $scope.iframe = $('#ui-iframe')[0].contentWindow.angular.element("#Frame").scope();
            $scope.$apply();
        });
        autosize($('[data-plugin=autosize]'));
    });

    $scope.blocks = {
        section1: true,
        section2: true,
        section3: true,
        section4: true,
        section5: true,
        section6: true,
        section7: true,
        section8: true,
        section9: true
    };
    $scope.images = {
        section1: [false],
        section2: [false],
        section4: [false],
        section5: [false, false],
        section6: [false, false, false],
        section7: [false],
        section8: [false]
    };
    $scope.buttons = {
        section3: [{text: false, link: false}],
        section7: [{text: false, link: false}],
        section8: [{text: false, link: false}]
    };
    $scope.text = {
        section3: [false],
        section4: [false],
        section5: [false, false],
        section6: [false, false, false],
        section7: [false, false],
        section8: [false, false]
    };

    $scope.switchHandler = function(){
        $scope.iframe.$apply();
        var height = 0;
        $('#ui-iframe').contents().find('[data-table]').each(function(index, item){
            height += $(item).height();
        });
        $scope.frameStyle.height = height;
    };

    $(window).bind('resize', function(){
        var height = 0;
        $('#ui-iframe').contents().find('[data-table]').each(function(index, item){
            height += $(item).height();
        });
        $scope.frameStyle.height = height;
        $scope.$apply();
    });
});
</script>
@endsection
