@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/opentip/css/opentip.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/iCheck/skins/square/blue.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/tour.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-tour" ng-class="{'xs':screen == 'xs'}" ng-controller="form">
    <div class="container detail checkout">
        <div class="row">
            <!-- main column -->
            <div class="col-md-8 main">
                <div class="alert alert-danger alert-dismissible hidden @if($config['lang']['code'] == 'th') th @endif " role="alert" id="eMessage">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span class="text"></span>
                </div>

                <form method="post" action="" name="form" ng-submit="checkout($event)" id="form">
                    <div class="title">
                        <a href="/tours/{{$tour->url}}.html"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                        {!! $tour->getTitle($config['lang']['code']) !!}
                    </div>
					<div class="step">
                        <div class="section">
                            <div class="head">
                                <div class="number">
                                    <span>1</span>
                                </div>
                                <div class="text">
                                    <h2 @if($config['lang']['code'] == 'th') class="th" @endif>{{trans('tour.Pick-up information')}}</h2>
                                    <h3>{{trans('tour.Please fill your information')}}</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{trans('tour.Phuket Area')}}*</label>
                                        <select class="form-control" name="area" ng-model="area" ng-class="{'disabled': !area || area == ''}">
											<option value="" disabled="" selected="">({{trans('_.required')}})</option>
                                            @foreach($tour->areas as $area)
                                            <option value="{{$area}}">{{trans('tour.'.$area)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
        								<label>{{trans('tour.Hotel Name or other accommodation address')}}*</label>
        								<input type="text" class="form-control" name="hotel" ng-model="hotel" maxlength="100" autocomplete="off" placeholder="({{trans('_.required')}})">
        							</div>
                                </div>
                            </div>

							<div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
        								<label>{{trans('tour.Room Number')}}</label>
        								<input type="text" class="form-control" name="room" ng-model="room" maxlength="30" autocomplete="off">
        							</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step">
                        <div class="section">
                            <div class="head">
                                <div class="number">
                                    <span>2</span>
                                </div>
                                <div class="text">
                                    <h2 @if($config['lang']['code'] == 'th') class="th" @endif>{{trans('tour.Your Detail')}}</h2>
                                    <h3>{{trans('tour.Please fill your detail')}}</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
        								<label>{{trans('_.First name')}}*</label>
        								<input type="text" class="form-control" name="firstname" ng-model="firstname" maxlength="50" autocomplete="off" placeholder="({{trans('_.required')}})">
        							</div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
        								<label>{{trans('_.Last name')}}*</label>
        								<input type="text" class="form-control" name="lastname" ng-model="lastname" maxlength="50" autocomplete="off" placeholder="({{trans('_.required')}})">
        							</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{trans('_.Email address')}}*</label>
                                        <input type="text" class="form-control" name="email" ng-model="email" maxlength="256" autocomplete="off" placeholder="({{trans('_.required')}})">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
        								<label>{{trans('tour.Thailand phone number')}}</label>
        								<input type="text" class="form-control" name="phone" ng-model="phone" maxlength="20" autocomplete="off">
        							</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{trans('_.Country')}}</label>
                                        <select class="form-control" name="country" ng-model="country">
                                            @foreach(App\Country::all() as $country)
                                            <option value="{{$country->id}}">{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
        								<label>{{trans('_.Note')}}</label>
        								<textarea class="form-control" rows="1" data-plugin="autosize" ng-model="note"></textarea>
        							</div>
                                </div>
                            </div>
                        </div>
                    </div>

					@if( count($tour->getPayments()) > 0 )
                    <div class="step">
                        <div class="section">
                            <div class="head">
                                <div class="number">
                                    <span>3</span>
                                </div>
                                <div class="text">
                                    <h2 @if($config['lang']['code'] == 'th') class="th" @endif>{{trans('tour.Method of Payment')}}</h2>
                                    <h3>{{trans('tour.Onsite payment by cash or credit card')}}</h3>
                                </div>
                            </div>

                            <div class="payments">
                            <?php $firstPayment = true; ?>
                            @foreach($tour->getPayments() as $map)
                                @if($map->payment)
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="radio" name="payment" value="{{$map->payment->paymentid}}" data-plugin="icheck-payments" @if($firstPayment) checked @endif>
                                        <span class="payment-name">{{$map->payment->name}}</span>
                                        @if($map->payment->link != '')
                                        <a href="{{$map->payment->link}}" target="_blank" class="whatis">(What is {{$map->payment->name}}?)</a>
                                        @endif
                                        <div class="payment-images">
                                            <?php $images = json_decode($map->payment->image); ?>
                                            @foreach($images as $image)
                                            <img src="{{$image}}" style="max-height: 85px;">
                                            @endforeach
                                        </div>
                                        <div class="payment-detail">
                                            {{$map->payment->detail}}
                                        </div>

                                        @if($map->payment->code == 'thaibanks')
                                        <div class="thaibanks">
                                            @foreach($map->payment->banks()->groupBy('bank_id')->get() as $mapBank)
                                                @if($mapBank->bank)
                                                <div class="bank-image" style="background-color:{{$mapBank->bank->color}}">
                                                    <img src="/static/plugins/banks-logo/th/{{$mapBank->bank->acronym}}.svg">
                                                </div>
                                                @endif
                                            @endforeach
                                            <div class="_note">
                                                <em>({{trans('tour.The only payment method within Thailand.')}})</em>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <?php $firstPayment = false; ?>
                                @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
					@endif

                    <button type="submit" class="hidden"></button>
                </form>
            </div>
            <!-- end: main column -->

            <!-- right column -->
            <div class="col-md-4">
                <div class="book">
                    <h3>- Summary -</h3>

                    @if($tour->price_type == 'package')
					<div class="row price-type @if($config['lang']['code'] == 'th') th @endif" style="margin-bottom: 6px;">
                        <div class="col-xs-12" style="text-transform: capitalize;">{{trans('tour.price/bundle ticket')}}</div>
                    </div>
					<div class="row describe @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-8" style="text-transform: capitalize;">{{trans('tour.Bundle ticket')}} ({{(intval($tour->number_package_adult)+intval($tour->number_package_child))}} {{trans('tour.passes')}})</div>
						<div class="col-xs-4 text-right"><strong>{{number_format($tour->price_package)}}</strong> THB</div>
                    </div>
                    <div class="row describe @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-8">
							{{trans('tour.Adult/Child')}}
							@if($tour->show_child_age == '1')
							{{trans('tour.(Age 5-11)')}}
							@endif
						</div>
                        <div class="col-xs-4 text-right">
							@if($checkout->extra)
								{{ number_format( (intval($tour->number_package_adult) * intval($checkout->packages)) + intval($checkout->extra->number)) }}
							@else
								{{ number_format( (intval($tour->number_package_adult) * intval($checkout->packages)) ) }}
							@endif
						</div>
                    </div>
                    <div class="hidden row describe @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-6">{{trans('_.Child')}} ({{trans('tour.Age 5-11')}})</div>
                        <div class="col-xs-6 text-right">{{$tour->number_package_child}}</div>
                    </div>
                    <div class="row calc @if($config['lang']['code'] == 'th') th @endif" style="margin-top:17px;">
                        <div class="col-lg-12">
                            <table>
                                <tr>
                                    <td>{{trans('_.Date')}}</td>
                                    <td>{{dateTime($checkout->date, 'd F Y')}}</td>
                                </tr>
								<tr>
                                    <td>{{trans('_.Time')}}</td>
                                    <td>{{$checkout->time}}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('tour.Number of buddle ticket')}}</td>
                                    <td>{{number_format($checkout->packages)}}</td>
                                </tr>
								@if($checkout->extra)
								<tr>
                                    <td>{{trans('tour.Extra visitors')}}</td>
                                    <td>
										+{{$checkout->extra->number}} (+{{number_format($checkout->extra->price, 2)}} THB)
									</td>
                                </tr>
								@endif
                                <tr>
                                    <td>{{trans('_.Calculate')}}</td>
                                    <td>{{number_format($checkout->packages)}}x THB {{number_format($tour->price_package, 2)}}</td>
                                </tr>
                                <tr class="total">
                                    <td>{{trans('_.Total')}}</td>
                                    <td>{{number_format($checkout->total)}} THB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @elseif($tour->price_type == 'person')
                    <div class="row price-type @if($config['lang']['code'] == 'th') th @endif" style="margin-bottom: 6px;">
                        <div class="col-xs-12" style="text-transform: capitalize;">{{trans('tour.price/single ticket')}}</div>
                    </div>
                    <div class="row describe @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-6">{{trans('_.Adult')}}</div>
                        <div class="col-xs-6 text-right">{{number_format($tour->price_person_adult, 2)}} THB</div>
                    </div>
                    <div class="row describe @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-xs-6">
							{{trans('tour.Adult/Child')}}
							@if($tour->show_child_age == '1')
							{{trans('tour.(Age 5-11)')}}
							@endif
						</div>
                        <div class="col-xs-6 text-right">{{number_format($tour->price_person_child, 2)}} THB</div>
                    </div>
                    <div class="row calc @if($config['lang']['code'] == 'th') th @endif" style="margin-top:17px;">
                        <div class="col-lg-12">
                            <table>
                                <tr>
                                    <td>{{trans('_.Date')}}</td>
                                    <td>{{dateTime($checkout->date, 'd F Y')}}</td>
                                </tr>
								<tr>
                                    <td>{{trans('_.Time')}}</td>
                                    <td>{{$checkout->time}}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('_.Adult')}}</td>
                                    <td>{{number_format($checkout->adults)}}</td>
                                </tr>
                                <tr>
                                    <td>
										{{trans('tour.Adult/Child')}}
										@if($tour->show_child_age == '1')
										{{trans('tour.(Age 5-11)')}}
										@endif
									</td>
                                    <td>{{number_format($checkout->children)}}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('_.Calculate')}}</td>
                                    <td>{{number_format($checkout->adults)}}x THB {{number_format($tour->price_person_adult, 2)}}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>{{number_format($checkout->children)}}x THB {{number_format($tour->price_person_child, 2)}}</td>
                                </tr>
                                <tr class="total">
                                    <td>{{trans('_.Total')}}</td>
                                    <td>{{number_format($checkout->total)}} THB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
					@elseif($tour->price_type == 'free')
                    <div class="row calc @if($config['lang']['code'] == 'th') th @endif">
                        <div class="col-lg-12">
                            <table>
                                <tr>
                                    <td>{{trans('_.Date')}}</td>
                                    <td>{{dateTime($checkout->date, 'd F Y')}}</td>
                                </tr>
								<tr>
                                    <td>{{trans('_.Time')}}</td>
                                    <td>{{$checkout->time}}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('_.Adult')}}</td>
                                    <td>{{number_format($checkout->adults)}}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('_.Child')}}</td>
                                    <td>{{number_format($checkout->children)}}</td>
                                </tr>
                                <tr class="total">
                                    <td>{{trans('_.Total')}}</td>
                                    <td>{{number_format($checkout->total)}} THB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-12 book-now">
                            <div class="terms hidden" id="terms">
                                <input type="checkbox" id="terms-checkbox" checked="">
                                <a href="/ajax/docs/tour-terms.html" id="terms-btn">{{trans('tour.I agree terms and conditions of trip booking.')}}</a>
                            </div>
                            <button class="btn btn-primary btn-lg" ng-click="checkout($event)" ng-disabled="continue">[[(continue?'Please wait...':'BOOK NOW')]]</button>
                            <button class="btn btn-primary btn-lg cancel" ng-disabled="continue" ng-click="cancel()"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Cancel</button>
                        </div>
                    </div>
                </div>

                <div class="phone-contact">
                    <img src="/static/images/phone-contact.png">
					<div class="text">{{trans('tour.Contact us')}}</div>
                    <div class="phone">{{$top_phone}}</div>
                </div>
            </div>
            <!-- end: right column -->
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade termsModal" ng-class="{'xs':screen == 'xs', 'sm':screen == 'sm'}" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{trans('_.Terms and Conditions')}}</h4>
            </div>
            <div class="modal-body">
                <iframe src="/ajax/docs/tour-terms.html"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/autosize/dist/autosize.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/opentip.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/opentip/lib/adapter-jquery.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/iCheck/icheck.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/ngSweetAlert/SweetAlert.min.js"></script>
<script>
app.requires.push('oitozero.ngSweetAlert');

app.controller('form', function($scope, $window, $http, SweetAlert){
    var form = $('#form'), alert = {};

    $(function(){
        autosize($('[data-plugin=autosize]'));

        $('input[data-plugin=icheck-payments]').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });

        $('#terms-checkbox').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });

        $('#termsModal').on('show.bs.modal', function () {
            $('html').addClass('fixed');
        })
        .on('hidden.bs.modal', function () {
            $('html').removeClass('fixed');
        });
        $('#terms-btn').bind('click', function(e){
            $('#termsModal').modal('show');
            e.preventDefault();
        });

        alert.firstname = new Opentip($('input[name=firstname]', form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
        alert.lastname  = new Opentip($('input[name=lastname]', form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
        alert.email     = new Opentip($('input[name=email]', form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
        alert.emailp    = new Opentip($('input[name=email]', form), "{{trans('tour.Email address format is invalid')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
		alert.area		= new Opentip($('select[name=area]', form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
		alert.hotel		= new Opentip($('input[name=hotel]', form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
        $scope.terms    = new Opentip($('#terms'), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert'});
    });

    $scope.continue = false;
    $scope.checkout = function($event)
    {
        if (
			($scope.area && $scope.area.trim() != '') &&
			($scope.hotel && $scope.hotel.trim() != '') &&
            ($scope.firstname && $scope.firstname.trim() != '') &&
            ($scope.lastname && $scope.lastname.trim() != '') &&
            ($scope.email && $scope.email.trim() != '' && /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($scope.email))
        ){
            if (!$('#terms-checkbox').is(':checked')){
                $scope.terms.show();
            }
            else {
                $.each(Opentip.tips, function(index, item){
                    item.hide();
                });
                $('#eMessage').addClass('hidden');
                $scope.continue = true;

                var params = {
                    token: '{{$checkout->token}}',
                    cid: {{$checkout->id}},
                    checkoutid: '{{$checkout->checkoutid}}',
                    tid: {{$tour->id}},
                    tourid: '{{$tour->tourid}}',
                    firstname: $scope.firstname,
                    lastname: $scope.lastname,
                    email: $scope.email,
                    phone: $scope.phone? $scope.phone.trim(): '',
                    country_id: $scope.country? $scope.country.trim(): '',
                    note: $scope.note? $scope.note.trim(): '',
                    paymentid: form.find('input[name=payment]:checked').val(),
					area: $scope.area.trim(),
					hotel: $scope.hotel.trim(),
					room: $scope.room? $scope.room.trim(): ''
                };

                $http.post('/ajax/tours/booking', params)
                .success(function(resp){
                    if (resp.status == 'ok'){
                        SweetAlert.swal({
                            title: "",
                            text: "{{trans('tour.TRANSACTION_COMPLETED')}}",
                            type: "success",
                            allowEscapeKey: false,
                            confirmButtonText: '{{trans('tour.Continue')}}',
                            confirmButtonColor: '#2A72B5',
                            customClass: 'ui-tour-checkout-success'
                        }, function(){
                            if (resp.payload.payment == true){
                                $window.location.href = '/books/'+resp.payload.bookid+'/payment?transaction='+resp.payload.checkout.transaction+'&checkoutid='+resp.payload.checkout.checkoutid;
                            }
                            else {
                                $window.location.href = '/tours/{{$tour->url}}.html';
                            }
                        });
                    }
                    else
					{
						if (resp.payload.error_code == 'repeat')
						{
							$window.alert('{{trans('book.Procedure of the transaction is incorrect, please try again.')}}');
							$window.location.href = '/tours/{{$tour->url}}.html';
						}
						else
						{
							$('#eMessage').find('.text').html(resp.message);
	                        $('#eMessage').removeClass('hidden');
	                        $('html, body').animate({
	                            scrollTop: $('#eMessage').offset().top - 120
	                        }, 'fast');
	                        $scope.continue = false;
						}
                    }
                })
                .error(function(){
                    $('#eMessage').find('.text').html('{{trans('error.general')}}');
                    $('#eMessage').removeClass('hidden');
                    $('html, body').animate({
                        scrollTop: $('#eMessage').offset().top - 120
                    }, 'fast');
                    $scope.continue = false;
                });
            }
        }
        else
        {
            if (!$scope.area || $scope.area.trim() == ''){
                alert.area.show();
            }
			if (!$scope.hotel || $scope.hotel.trim() == ''){
                alert.hotel.show();
            }
			if (!$scope.firstname || $scope.firstname.trim() == ''){
                alert.firstname.show();
            }
            if (!$scope.lastname || $scope.lastname.trim() == ''){
                alert.lastname.show();
            }
            if (!$scope.email || $scope.email.trim() == ''){
                alert.email.show();
            }
            else if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($scope.email)){
                alert.emailp.show();
            }
        }
        $event.preventDefault();
    };

    $scope.cancel = function(){
        $window.location.href = '/tours/{{$tour->url}}.html';
    };
});
</script>
@endsection
