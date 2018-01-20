@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/opentip/css/opentip.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/contact.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-contact" ng-class="{'xs':screen == 'xs'}" ng-controller="Index">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="head">
                    <div class="line"></div>
                    <div class="title">
                        <span>{{trans('contact.Contact Us')}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- wrapper -->
            <div class="col-md-7 wrapper">
                <form method="post" name="contactForm" action="" ng-controller="Form" ng-submit="send($event)" id="form">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>{!! trans('contact.Contact us using the form below by filling out the form and we&apos;ll respond as soon as possible.') !!}</h3>
                        </div>
                    </div>

                    <div class="row form">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>{{trans('_.First name')}}*</label>
                                <input type="text" class="form-control" name="firstname" ng-model="firstname" maxlength="50" autocomplete="off" id="inputFirstname" placeholder="({{trans('_.required')}})">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>{{trans('_.Last name')}}*</label>
                                <input type="text" class="form-control" name="lastname" ng-model="lastname" maxlength="50" autocomplete="off" placeholder="({{trans('_.required')}})">
                            </div>
                        </div>
                    </div>

                    <div class="row form">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>{{trans('_.Email address')}}*</label>
                                <input type="text" class="form-control" name="email" ng-model="email" maxlength="256" autocomplete="off" placeholder="({{trans('_.required')}})">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>{{trans('_.Phone number')}}*</label>
                                <input type="text" class="form-control" name="phone" ng-model="phone" maxlength="25" autocomplete="off" placeholder="({{trans('_.required')}})">
                            </div>
                        </div>
                    </div>

                    <div class="row form">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>{{trans('_.Topic')}}*</label>
                                <input type="text" class="form-control" name="topic" ng-model="topic" maxlength="128" autocomplete="off" placeholder="({{trans('_.required')}})">
                            </div>
                        </div>
                    </div>

                    <div class="row form">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>{{trans('_.Message')}}*</label>
                                <textarea name="message" class="form-control" rows="4" ng-model="message" data-plugins='["autosize"]' placeholder="({{trans('_.required')}})"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row form">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-md btn-default" ng-disabled="continue">[[(continue)?'{{trans('contact.Sending Message...')}}':'{{trans('contact.Send Message')}}']]</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end wrapper -->

            <!-- right -->
            <div class="col-md-5 contactinfo">
                <div class="row">
                    <div class="col-xs-12">
                        <p class="address">
							<?php
								$addressLocale = isset($config['addresses']->{$config['lang']['code']})? $config['addresses']->{$config['lang']['code']}: '';
							?>
                            {!! $addressLocale !!}
                        </p>
                        <p class="emails">
							<span style="display: inline-block; width: 25px;"><i class="fa fa-envelope" aria-hidden="true"></i></span>
							{{ implode(', ', $config['emails']) }}
                        </p>
                        <p class="phones">
							<span style="display: inline-block; width: 25px;"><i class="fa fa-phone" aria-hidden="true" style="font-size: 19px;"></i></span>
							{{ implode(', ', $config['phones']) }}
                        </p>
						<p class="faxes">
							<span style="display: inline-block; width: 25px;"><i class="fa fa-fax" aria-hidden="true"></i></span>
							{{ implode(', ', $faxes) }}
                        </p>
                        <p class="follow">{{trans('contact.Follow Us On')}}</p>
                        <p class="socials">
                            @if(trim($config['facebook']) != '')
                            <a href="{!! $config['facebook'] !!}" target="_blank" rel="me" alt="{{ $config['facebook'] }}"><img src="/static/frontend/images/contacts/facebook.png" alt="{{ $config['facebook'] }}"></a>
                            @endif
                            @if(trim($config['instagram']) != '')
                            <a href="{!! $config['instagram'] !!}" target="_blank" rel="me" alt="{{ $config['instagram'] }}"><img src="/static/frontend/images/contacts/instagram.png" alt="{{ $config['instagram'] }}"></a>
                            @endif
                            @if(trim($config['googleplus']) != '')
                            <a href="{!! $config['googleplus'] !!}" target="_blank" rel="me" alt="{{ $config['googleplus'] }}"><img src="/static/frontend/images/contacts/googleplus.png" alt="{{ $config['googleplus'] }}"></a>
                            @endif
                            @if(trim($config['pinterest']) != '')
                            <a href="{!! $config['pinterest'] !!}" target="_blank" rel="me" alt="{{ $config['pinterest'] }}"><img src="/static/frontend/images/contacts/pinterest.png" alt="{{ $config['pinterest'] }}"></a>
                            @endif
                            @if(trim($config['youtube']) != '')
                            <a href="{!! $config['youtube'] !!}" target="_blank" rel="me" alt="{{ $config['youtube'] }}"><img src="/static/frontend/images/contacts/youtube.png" alt="{{ $config['youtube'] }}"></a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <!-- end right -->
        </div>

        <!-- start: random tours -->
        <div class="row ui-tour-random">
            <div class="title-head">{{trans('_.Booking Tour')}}</div>
            @foreach($tours as $index => $tour)
			<?php $title_ = $tour->getTitle($config['lang']['code']) ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow zoomIn">
                <div class="item @if($index == 3) visible-sm visible-xs @endif">
                    @if($tour->new == '1')
                    <div class="ribbon new"><span>NEW</span></div>
                    @elseif($tour->popular == '1')
                    <div class="ribbon popular"><span>POPULAR</span></div>
                    @elseif($tour->recommend == '1')
                    <div class="ribbon recommended"><span>RECOMMEND</span></div>
                    @endif
                    <div class="images">
                        <a href="/tours/{{$tour->url}}.html" alt="{{$title_}}">
                            <?php
                                $source = '/static/images/image-placeholder-622-415.png';

                                if ($tour->images->count() > 0){
                                    $image  = $tour->images->get(0);
                                    $source = "/app/tour/{$tour->tourid}/{$image->imageid}_t.png";
                                }
                            ?>
                            <div class="defer-image" ng-controller="DeferImage" image="{{$source}}" alt="{{$tour->getTitle($config['lang']['code'])}}">
                                <div class="image-showing">
                                    <img src="/static/images/preload-622-415.jpg" class="holder">
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
                            <a href="#" ng-click="showTourPreview($event, '{{$tour->tourid}}')"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
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
        <!-- end: random tours -->
    </div>
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/opentip.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/adapter-jquery.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/autosize/dist/autosize.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/ngSweetAlert/SweetAlert.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-fullscreen.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script>
app.requires.push('oitozero.ngSweetAlert');

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
app.controller('Index', function($scope){
    $scope.showTourPreview = function($event, tourid){
        $('.tour-preview[data-preview-tourid='+tourid+']').first().find('a').first().click();
        $event.preventDefault();
    };
    $(function(){
        $('[data-plugin=light-gallery]').lightGallery({
            download: false,
            counter: false,
            fullScreen: false,
            actualSize: false
        });
    });
});
app.controller('Form', function($scope, $http, $window, SweetAlert){
    $scope.form     = $('#form');
    $scope.alert    = {};
    $scope.continue = false;

    $scope.alert.firstname = new Opentip($('input[name=firstname]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.lastname  = new Opentip($('input[name=lastname]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.email     = new Opentip($('input[name=email]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.emailp    = new Opentip($('input[name=email]', $scope.form), "{{trans('tour.Email address format is invalid')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.phone     = new Opentip($('input[name=phone]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.topic     = new Opentip($('input[name=topic]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.message   = new Opentip($('textarea[name=message]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});

    $scope.alert.firstname.show();
    $scope.alert.lastname.show();
    $scope.alert.email.show();
    $scope.alert.emailp.show();
    $scope.alert.phone.show();
    $scope.alert.topic.show();
    $scope.alert.message.show();

    $.each(Opentip.tips, function(index, item){
        item.hide();
    });

    $scope.send = function($event){
        if (
            ($scope.firstname && $scope.firstname.trim() != '') &&
            ($scope.lastname && $scope.lastname.trim() != '') &&
            ($scope.email && $scope.email.trim() != '' && /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($scope.email)) &&
            ($scope.phone && $scope.phone.trim() != '') &&
            ($scope.topic && $scope.topic.trim() != '') &&
            ($scope.message && $scope.message.trim() != '')
        ){
            $.each(Opentip.tips, function(index, item){
                item.hide();
            });
            $scope.continue = true;

            var params = {
                firstname: $scope.firstname.trim(),
                lastname: $scope.lastname.trim(),
                email: $scope.email.trim(),
                phone: $scope.phone.trim(),
                topic: $scope.topic.trim(),
                message: $scope.message.trim()
            };

            $http.post('/ajax/contactus', params)
            .success(function(resp){
                if (resp.status == 'ok'){
                    SweetAlert.swal({
                        title: "",
                        text: "{{trans('contact.We have received your information successfully, we will answer any questions or concerns and will contact you as soon as possible.')}}",
                        type: "success",
                        confirmButtonColor: '#2A72B5',
                        customClass: 'ui-contact-success'
                    });

                    $scope.firstname    = null;
                    $scope.lastname     = null;
                    $scope.email        = null;
                    $scope.phone        = null;
                    $scope.topic        = null;
                    $scope.message      = null;
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
                $scope.continue = false;
            });
        }
        else
        {
            if (!$scope.firstname || $scope.firstname.trim() == ''){
                $scope.alert.firstname.show();
            }
            if (!$scope.lastname || $scope.lastname.trim() == ''){
                $scope.alert.lastname.show();
            }
            if (!$scope.email || $scope.email.trim() == ''){
                $scope.alert.email.show();
            }
            else if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($scope.email)){
                $scope.alert.emailp.show();
            }
            if (!$scope.phone || $scope.phone.trim() == ''){
                $scope.alert.phone.show();
            }
            if (!$scope.topic || $scope.topic.trim() == ''){
                $scope.alert.topic.show();
            }
            if (!$scope.message || $scope.message.trim() == ''){
                $scope.alert.message.show();
            }
        }
        $event.preventDefault();
    };
});
$(function(){
    $('[data-plugins]').each(function(index, item){
        var plugins = JSON.parse($(item).attr('data-plugins'));

        //autosize
        if ($.inArray('autosize', plugins) > -1){
            autosize($(item));
        }
    });

    $('#inputFirstname').focus();
});
</script>
@endsection
