@extends('frontend.layout')

@section('head')
<link href="/static/bower_components/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css">
<link href="/static/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
<link href="/static/frontend/css/book.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="ui-book" ng-class="{'xs':screen == 'xs'}" ng-controller="Book">
    <div class="container payment">
        <div class="row">

            <!-- start: main -->
            <div class="col-md-8 main">
                <div class="title">
                    {!! $book->tour->getTitle($config['lang']['code']) !!}
                </div>
                <div class="wrap">
                    <div class="head hidden-xs">{{trans('book.Please make payment via the method you have selected')}}</div>
                    <div class="head-xs visible-xs">{{trans('book.Please make payment via the method you have selected')}}</div>

                    <div class="form">

						@if($book->payment->code == 'onsite')
                        <div class="onsite">
                            <span>{{trans('book.ONSITE_PAYMENT', ['amount' => number_format($book->checkout->total)])}}</span> <br>
							<a href="/tours/{{$book->tour->url}}.html" class="btn btn-primary">{{trans('_.Done')}}</a>
                        </div>
                        @endif

                        @if($book->payment->code == 'credit_debit')
                        <div class="credit_debit">
                            <img src="/static/images/payments/credit_debit.png" style="max-height: 85px; max-width: 100%;">
                            <span>{{trans('book.Click the button above to go to the Paypal website for complete your payment.')}}</span>
                        </div>
                        @endif

                        @if($book->payment->code == 'paysbuy')
                        <div class="paypal">
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                <!-- Identify your business so that you can collect the payments. -->
                                <input type="hidden" name="business" value="{!! $book->payment->email !!}">

                                <!-- Specify a Buy Now button. -->
                                <input type="hidden" name="cmd" value="_xclick">

                                <!-- Specify details about the item that buyers will purchase. -->
                                <input type="hidden" name="item_name" value="{{$book->tour->getTitle($config['lang']['code'])}}">
                                <input type="hidden" name="amount" value="{{$checkout->total}}">
                                <input type="hidden" name="currency_code" value="THB">

                                <input type="hidden" name="invoice" value="{{$book->bookid}}">
                                <input type="hidden" name="return" value="{{config('app.url')}}/books/{{$book->bookid}}/success?transaction={{$checkout->transaction}}&checkoutid={{$checkout->checkoutid}}">

                                <!-- Display the payment button. -->
                                <input type="image" name="submit" border="0"
                                src="/static/images/payments/paypal_paynow-button.png"
                                alt="PayPal - The safer, easier way to pay online">
                                <img alt="" border="0" width="1" height="1"
                                src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
                            </form>
                            <span>{{trans('book.Click the button above to go to the Paypal website for complete your payment.')}}</span>
                        </div>
                        @endif

                        @if($book->payment->code == 'thaibanks')
                        <div class="thaibanks">
                            <span class="intro">
                                {!! trans('book.TRANSFER_MONEY', ['amount' => number_format($checkout->total)]) !!}
                                <a href="/books/{{$book->bookid}}/success?transaction={{$checkout->transaction}}&checkoutid={{$checkout->checkoutid}}">{{trans('book.Inform transfer')}}</a>
                            </span>
                            <div class="banks">
                                @foreach($book->payment->banks as $index => $map)
                                    @if($map->bank)
                                    <div class="bank">
                                        <div class="bank-image" style="background-color:{{$map->bank->color}};">
                                            <img src="/static/plugins/banks-logo/th/{{$map->bank->acronym}}.svg">
                                        </div>
                                        <div class="bank-detail">
                                            <span>{{$map->bank->thai_name}}</span>
                                            <small>{{$map->bank->official_name}}</small>
                                            <small>{{$map->bank->nice_name}} <em>({{$map->bank->acronym}})</em></small>
                                        </div>
                                        <div class="map">
                                            <div class="row">
                                                <div class="col-md-4 col-xs-6">{{trans('payment.Account name')}}</div>
                                                <div class="col-md-8 col-xs-6">{{$map->account}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-xs-6">{{trans('payment.Account number')}}</div>
                                                <div class="col-md-8 col-xs-6">{{$map->number}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-xs-6">{{trans('payment.Account type')}}</div>
                                                <div class="col-md-8 col-xs-6">{{$map->type}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-xs-6">{{trans('payment.Branch')}}</div>
                                                <div class="col-md-8 col-xs-6">{{$map->branch}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                <div class="_note">({{trans('book.You can transfer money to our account, an account in any bank at your convenience.')}})</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- end: main -->

            <!-- start: right -->
            <div class="col-md-4 right">
                <div class="tours">
                    <div class="headline"><span>{{trans('tour.You may be interested')}}</span></div>
                    <div class="row">
                        @foreach($tours as $index => $tour)
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
                                    <a href="/tours/{{$tour->url}}.html">
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
                                        <?php $name = $tour->getTitle($config['lang']['code']) ?>
                                        <div class="tour-preview hidden" data-plugin="light-gallery" data-preview-tourid="{{$tour->tourid}}">
                                            @foreach($tour->images as $image)
                                            <a href="/app/tour/{{$tour->tourid}}/{{$image->imageid}}.png" data-sub-html="{!! $name !!}">
                                                <img src="/app/tour/{{$tour->tourid}}/{{$image->imageid}}_t.png" class="img-responsive" alt="{{$name}}">
                                            </a>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="title">{!! str_limit($tour->getTitle($config['lang']['code']), $limit = 80, $end = '...') !!}</div>
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
<script src="/static/bower_components/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="/static/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
<script src="/static/bower_components/lightgallery/dist/js/lg-thumbnail.min.js"></script>
<script src="/static/bower_components/lightgallery/dist/js/lg-fullscreen.min.js"></script>
<script src="/static/bower_components/lightgallery/dist/js/lg-zoom.min.js"></script>
<script>
(function(){
    app.controller('Book', function($scope){
        $scope.showTourPreview = function($event, tourid){
            $('.tour-preview[data-preview-tourid='+tourid+']').first().find('a').first().click();
            $event.preventDefault();
        };

        $(function(){
            $('[data-plugin=light-gallery]').lightGallery({
                download: false
            });
        });
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
@endsection
