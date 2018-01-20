@extends('frontend.layout')

@section('head')
<link href="{{ $config['url'] }}/static/bower_components/opentip/css/opentip.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="{{ $config['url'] }}/static/frontend/css/book.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-book" ng-class="{'xs':screen == 'xs'}" ng-controller="Book">
    <div class="container success">
        <div class="row">

            <!-- start: main -->
            <div class="col-md-8 main">
                <div class="title">
                    {!! $book->tour->getTitle($config['lang']['code']) !!}
                </div>
                <div class="wrap">
                    @if($book->payment->code == 'credit_debit')
                    <div class="head hidden-xs">{{trans('book.Your transaction is completed')}}</div>
                    <div class="head-xs visible-xs">{{trans('book.Your transaction is completed')}}</div>
                    @elseif($book->payment->code == 'thaibanks')
                    <div class="head hidden-xs">{{trans('book.Please inform your transfer')}}</div>
                    <div class="head-xs visible-xs">{{trans('book.Please inform your transfer')}}</div>
                    @endif

                    @if($book->payment->code == 'credit_debit')
                    <div class="completed">
                        <img src="/static/images/success-check.png">
                        <div class="text">
							<span>{{trans('book.The transaction is completed. However, we will verify the accuracy of your transaction again.')}}<span>
						</div>
                    </div>
                    @endif

                    @if($book->payment->code == 'thaibanks')
                    <div class="inform" ng-controller="Form">
                        <form method="post" name="informForm" action="" ng-submit="send($event)" id="inform">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{trans('book.Our bank account')}}*</label>
                                        <input type="text" name="bank" class="form-control" ng-model="selectedBank" ng-click="showOptions=!showOptions" readonly id="ui-bank" placeholder="({{trans('_.required')}})">
                                        <div class="ui-banks" click-outside="showOptions=false" outside-if-not="ui-bank">
                                            <div class="options" ng-class="{'hidden':!showOptions}">
                                                <div class="item" ng-repeat="item in banks track by $index" ng-click="selectBank($index)">
                                                    <div class="image" ng-style="{'background-color':item.bank.color}">
                                                        <img ng-src="/static/plugins/banks-logo/th/[[item.bank.acronym]].svg">
                                                    </div>
                                                    <div class="detail">
                                                        <span>[[item.bank.thai_name]]</span>
                                                        <small>[[item.bank.official_name]]</small>
                                                        <small class="account">[[item.map.account]]</small>
                                                        <small>[[item.map.number]]</small>
                                                        <small>[[item.map.type]]</small>
                                                        <small>[[item.map.branch]]</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{trans('book.Proof of payment')}}*</label>
                                        <input type="text" name="proof" class="form-control" ng-model="proof" ng-click="chooseImage()" placeholder="{{trans('book.Slips, receipts, photos from online banking')}}" readonly placeholder="({{trans('_.required')}})">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{trans('book.Transfer time')}}*</label>
                                        <input type="text" name="time" class="form-control" datetime="yyyy-MM-dd HH:mm:ss" ng-model="time" placeholder="({{trans('_.required')}})">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{trans('book.Amount transferred')}}*</label>
                                        <input type="text" name="amount" class="form-control" ng-model="amount" maxlength="30" autocomplete="off" currency-symbol="THB " ng-currency  placeholder="({{trans('_.required')}})">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{trans('_.Note')}}</label>
                                        <textarea class="form-control" rows="1" ng-model="note" data-plugin="autosize"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>&nbsp;</label>
                                    <input type="file" class="hidden" ng-model="image" accept="image/x-png, image/gif, image/jpeg" id="image">
                                    <button type="submit" class="btn btn-md btn-primary" ng-disabled="sending || completed">[[(sending?'{{trans('_.Sending...')}}':'{{trans('_.Send')}}')]]</button>
                                </div>
                            </div>
                        </form>
                        <div class="disabled" ng-show="sending"></div>
                    </div>
                    @endif
                </div>
            </div>
            <!-- end: main -->

            <!-- start: right -->
            <div class="col-md-4 right">
                <div class="tours">
                    <div class="headline"><span>{{trans('tour.You may be interested')}}</span></div>
                    <div class="row">
                        @foreach($tours as $index => $tour)
						<?php $title_ = $tour->getTitle($config['lang']['code']) ?>
                        <div class="col-xs-12 wow zoomIn">
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
                                        <a href="#" ng-click="showTourPreview($event, '{{$tour->tourid}}')" alt="{{$title_}}"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
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
            <!-- end: right -->

        </div>
    </div>
</div>
@endsection

@section('foot')
<script src="{{ $config['url'] }}/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-fullscreen.min.js"></script>
<script src="{{ $config['url'] }}/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script>
(function(){
    app.controller('Book', function($scope, $http){
        $scope.showTourPreview = function($event, tourid){
            $('.tour-preview[data-preview-tourid='+tourid+']').first().find('a').first().click();
            $event.preventDefault();
        };

        $(function(){
            $('[data-plugin=light-gallery]').lightGallery({
                download: false
            });
        });

        @if($book->payment->code == 'credit_debit')
        $http.post('/ajax/books/success', {
            bookid: '{{$book->bookid}}',
            checkoutid: '{{$book->checkout->checkoutid}}',
            transaction: '{{$book->checkout->transaction}}'
        });
        @endif
    });
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
})();
</script>

@if($book->payment->code == 'thaibanks')
<?php
    $banks = [];
    foreach ($book->payment->banks as $map){
        if ($map->bank){
            $banks[] = [
                'map'   => $map,
                'bank'  => $map->bank
            ];
        }
    }
?>
<script src="/static/bower_components/angular-click-outside/clickoutside.directive.js"></script>
<script src="/static/bower_components/angular-datetime/dist/datetime.js"></script>
<script src="/static/bower_components/ng-currency/dist/ng-currency.min.js"></script>
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script src="/static/bower_components/opentip/lib/opentip.js"></script>
<script src="/static/bower_components/opentip/lib/adapter-jquery.js"></script>
<script src="/static/bower_components/moment/moment.js"></script>
<script src="/static/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script src="/static/bower_components/ngSweetAlert/SweetAlert.min.js"></script>
<script>
app.requires.push('angular-click-outside');
app.requires.push('datetime');
app.requires.push('ng-currency');
app.requires.push('oitozero.ngSweetAlert');

app.controller('Form', function($scope, $timeout, $window, SweetAlert){
    $scope.banks        = {!! json_encode($banks) !!};
    $scope.bank         = null;
    $scope.sending      = false;
    $scope.selectedBank = null;
    $scope.showOptions  = false;
    $scope.image        = null;
    $scope.form         = $('#inform');
    $scope.alert        = {};

    $scope.alert.bank   = new Opentip($('input[name=bank]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.proof  = new Opentip($('input[name=proof]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.time   = new Opentip($('input[name=time]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});
    $scope.alert.amount = new Opentip($('input[name=amount]', $scope.form), "{{trans('_.Required information')}}", { style: "alert", target: true, tipJoint: 'bottom', targetJoint: 'top center', containInViewport: false, showOn: null, className: 'ui-alert', hideOn: ['focusout focus']});

    $scope.alert.bank.show();
    $scope.alert.proof.show();
    $scope.alert.time.show();
    $scope.alert.amount.show();

    $.each(Opentip.tips, function(index, item){
        item.hide();
    });

    $('input[name=proof]', $scope.form).bind('click', function(){
        $('#image').trigger('click');
    });

    $scope.selectBank = function(index){
        $scope.bank = $scope.banks[index];
        $scope.selectedBank = $scope.bank.bank.thai_name+' - '+$scope.bank.map.account;
    };

    $scope.send = function($event){
        if (
            $scope.bank &&
            ($('#image')[0].files.length == 1 && ($('#image')[0].files[0].type.toLowerCase() == 'image/jpg' || $('#image')[0].files[0].type.toLowerCase() == 'image/jpeg' || $('#image')[0].files[0].type.toLowerCase() == 'image/png' || $('#image')[0].files[0].type.toLowerCase() == 'image/gif')) &&
            $scope.time &&
            !isNaN($scope.amount)
        )
        {
            $scope.sending = true;

            var formData = new FormData();
            var file     = $('#image')[0].files[0];

            formData.append('_token', '{{csrf_token()}}');
            formData.append('bookid', '{{$book->bookid}}');
            formData.append('checkoutid', '{{$checkout->checkoutid}}');
            formData.append('transaction', '{{$checkout->transaction}}');
            formData.append('map_id', $scope.bank.map.id);
            formData.append('image', file);
            formData.append('time', moment($scope.time).format("YYYY-MM-DD HH:mm:ss"));
            formData.append('amount', $scope.amount);
            formData.append('note', ($scope.note? $scope.note.trim(): ''));

            $.ajax({
                url: '/ajax/books/inform',
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: 'JSON',
                data: formData
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.completed = true;
                    $scope.sending = false;
                    $scope.$apply();

                    SweetAlert.swal({
                        title: "",
                        text: "{{trans('book.We will verify your transaction and transfer evidence must be correct. After that, we will notify you via the email address back.')}}",
                        type: "success",
                        allowEscapeKey: false,
                        confirmButtonText: '{{trans('_.OK')}}',
                        confirmButtonColor: '#2A72B5',
                        customClass: 'ui-inform-success'
                    }, function(){
                        $window.location.href = '/tours/{{$book->tour->url}}.html';
                    });
                }
                else {
                    alert(resp.message);
                    $scope.sending = false;
                    $scope.$apply();
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
                $window.location.reload();
            });
        }
        else
        {
            if (!$scope.bank){
                $scope.alert.bank.show();
            }
            if ($('#image')[0].files.length < 1 || ($('#image')[0].files[0].type.toLowerCase() != 'image/jpg' && $('#image')[0].files[0].type.toLowerCase() != 'image/jpeg' && $('#image')[0].files[0].type.toLowerCase() != 'image/png' && $('#image')[0].files[0].type.toLowerCase() != 'image/gif')){
                $scope.alert.proof.show();
            }
            if (!$scope.time){
                $scope.alert.time.show();
            }
            if (isNaN($scope.amount)){
                $scope.alert.amount.show();
            }
        }

        $event.preventDefault();
    };

    $(function(){
        autosize($('textarea[data-plugin=autosize]'));

        $('#image').bind('change', function(e){
            $scope.proof = $(this).val();
            $scope.$apply();
        });
    });
});
</script>
@endif
@endsection
