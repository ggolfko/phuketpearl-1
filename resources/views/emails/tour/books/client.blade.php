<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>


<style type="text/css">
img {
max-width: 100%;
}
body {
-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
}
body {
background-color: #f6f6f6;
}
@media only screen and (max-width: 640px) {
  body {
    padding: 0 !important;
  }
  h1 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h2 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h3 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h4 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h1 {
    font-size: 22px !important;
  }
  h2 {
    font-size: 18px !important;
  }
  h3 {
    font-size: 16px !important;
  }
  .container {
    padding: 0 !important; width: 100% !important;
  }
  .content {
    padding: 0 !important;
  }
  .content-wrap {
    padding: 10px !important;
  }
  .invoice {
    width: 100% !important;
  }
  .mobile-td {
	  width: 100% !important;
	  display: block !important;
	  box-sizing: border-box;
	  float: left;
  }
  .mobile-td.__property {
	  font-weight: bold !important;
  }
  .mobile-td.__value {
	  border-bottom: 1px solid #dfdfdf !important;
	  padding-bottom: 5px !important;
	  margin-bottom: 5px !important;
  }
}
</style>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

<table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
		<td class="container" width="600" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
			<div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <img src="{{ $message->embed('static/images/logo-200-100.png') }}" style="display: block; margin: 0 auto; width: 135px; height: auto; margin-bottom: 8px;">
				<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
							<meta itemprop="name" content="" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" /><table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        <span>{{trans('tour.Your booking is successful.')}}</span>
                                        <div style="width: 100%; height: 15px;"></div>
                                        <span style="font-weight: bold;">{{trans('tour.Important notice')}}:</span>
										<span>{{trans('tour.You will need to be at the indicated venue in a package trip by the time you booked.')}}</span>
									</td>
								</tr>
                                @if($book->tour)
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        <span style="text-decoration: underline; font-weight: 600;">{{trans('tour.Trip information')}}</span>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 10px;">
											@if($book->tour->price_type == 'person')
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Trip')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;"><a href="{{config('app.url')}}/tours/{{$book->tour->url}}.html" target="_blank">{{$book->tour->getTitle($config['lang']['code'])}}</a></td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Ticket type')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{trans('tour.Single ticket')}}</td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Adult')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->tour->price_person_adult, 2)}} THB</td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">
													{{trans('tour.Child')}}
													@if($book->tour->show_child_age == '1')
													{{trans('tour.(Age 5-11)')}}
													@endif
												</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->tour->price_person_child, 2)}} THB</td>
                                            </tr>
											@elseif($book->tour->price_type == 'package')
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Package trip')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;"><a href="{{config('app.url')}}/tours/{{$book->tour->url}}.html" target="_blank">{{$book->tour->getTitle($config['lang']['code'])}}</a></td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Ticket type')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{trans('tour.Bundle ticket')}}</td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Price')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->tour->price_package, 2)}} THB</td>
                                            </tr>
											@elseif($book->tour->price_type == 'free')
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Trip')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;"><a href="{{config('app.url')}}/tours/{{$book->tour->url}}.html" target="_blank">{{$book->tour->getTitle($config['lang']['code'])}}</a></td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Ticket type')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{trans('tour.Free Transfer ticket')}}</td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Maximum number of visitors')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->tour->maximum_guests)}}</td>
                                            </tr>
											@endif
                                        </table>
									</td>
								</tr>
                                @endif
                                @if($book->checkout)
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        <span style="text-decoration: underline; font-weight: 600;">{{trans('book.Booking information')}}</span>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 10px;">
                                            <tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Booking number')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{$book->bookid}}</td>
                                            </tr>
                                            <tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('_.Date')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{dateTime($book->checkout->date, 'd F Y')}}</td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('_.Time')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{$book->checkout->time}}</td>
                                            </tr>

											@if($book->tour && $book->tour->price_type == 'person')
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Number of adult')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->checkout->adults)}}</td>
                		                    </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">
													{{trans('tour.Number of child')}}
													@if($book->tour->show_child_age == '1')
													{{trans('tour.(Age 5-11)')}}
													@endif
												</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->checkout->children)}}</td>
                		                    </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">&nbsp;</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->checkout->adults)}}x {{number_format($book->tour->price_person_adult, 2)}} THB</td>
                		                    </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">&nbsp;</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->checkout->children)}}x {{number_format($book->tour->price_person_child, 2)}} THB</td>
                		                    </tr>
											@elseif($book->tour && $book->tour->price_type == 'package')
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Maximum number of adult and child')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{$book->tour->number_package_adult}}</td>
                		                    </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Number of package')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->checkout->packages)}}</td>
                		                    </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">&nbsp;</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->checkout->packages)}}x {{number_format($book->tour->price_package, 2)}} THB</td>
                		                    </tr>
											@if($book->checkout->extra)
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Extra visitors')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">
													+{{$book->checkout->extra->number}} (+{{number_format($book->checkout->extra->price, 2)}} THB)
												</td>
                		                    </tr>
											@endif

											@elseif($book->tour && $book->tour->price_type == 'free')
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Number of adult')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->checkout->adults)}}</td>
                		                    </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Number of child')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->checkout->children)}}</td>
                		                    </tr>
											@endif

											@if($book->tour && $book->tour->price_type != 'free')
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Total price')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{number_format($book->checkout->total, 2)}} THB</td>
                                            </tr>
											<tr>
												<td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Method of payment')}}</td>
												<td class="mobile-td __value" style="vertical-align: top;">
													@if($book->payment && $book->checkout)
														{{$book->payment->name}}
													@else
														-
													@endif
												</td>
											</tr>
											@endif
                                        </table>
									</td>
								</tr>
                                @endif
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        <span style="text-decoration: underline; font-weight: 600;">{{trans('book.Your information')}}</span>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 10px;">
                                            <tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('_.First name')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{$book->firstname}}</td>
                                            </tr>
                                            <tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('_.Last name')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{$book->lastname}}</td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Phuket area')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{$book->area}}</td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Hotel name or other accommodation address')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{$book->hotel}}</td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('tour.Room number')}}</td>
												<td class="mobile-td __value" style="vertical-align: top;">
                                                    @if(trim($book->room) == '')
                                                        -
                                                    @else
														{{$book->room}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('_.Email address')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">{{$book->email}}</td>
                                            </tr>
                                            <tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('_.Phone number')}}</td>
												<td class="mobile-td __value" style="vertical-align: top;">
                                                    @if(trim($book->phone) == '')
                                                        -
                                                    @else
														{{$book->phone}}
                                                    @endif
                                                </td>
                                            </tr>
											<tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('_.Country')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">
													@if($book->country)
														{{$book->country->country_name}}
													@else
														-
													@endif
												</td>
                                            </tr>
                                            <tr>
                                                <td class="mobile-td __property" style="width: 190px; vertical-align: top; padding-right: 15px;">{{trans('_.Note')}}</td>
                                                <td class="mobile-td __value" style="vertical-align: top;">
                                                    @if(trim($book->note) == '')
                                                        -
                                                    @else
                                                        {!! nl2br($book->note) !!}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
										<div style="margin-top: 10px;">
											<span style="color: #919191; font-size: 13.5px;">(Booking on {{$book->created_at->format('d F Y H:i:s')}})</span>
										</div>
									</td>
								</tr>

                                @if($book->payment && $book->checkout)
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0px; text-align: center;" valign="top">
                                        @if($book->payment->code == 'credit_debit')
										<a href="{{config('app.url')}}/books/{{$book->bookid}}/payment?transaction={{$book->checkout->transaction}}&checkoutid={{$book->checkout->checkoutid}}" target="_blank" itemprop="url" style="outline: none;"><img src="{!! $message->embed(public_path("static/images/payments/credit_debit.png")) !!}" style="outline: none; border: none; max-width: 100%; margin-top: 20px;" height="50"></a>
                                        @endif
                                        @if($book->payment->code == 'thaibanks')
                                        <a href="{{config('app.url')}}/books/{{$book->bookid}}/payment?transaction={{$book->checkout->transaction}}&checkoutid={{$book->checkout->checkoutid}}" target="_blank" class="btn-primary" itemprop="url" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 13.5px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: normal; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 5px 12px;">{{trans('book.Payment information')}}</a> <br><br>
                                        {{trans('book.When you paid your bill, please notify the payment')}}
                                        <div style="width: 100%; height: 10px;"></div>
                                        <a href="{{config('app.url')}}/books/{{$book->bookid}}/success?transaction={{$book->checkout->transaction}}&checkoutid={{$book->checkout->checkoutid}}" target="_blank" class="btn-primary" itemprop="url" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 13.5px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: normal; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 5px 12px;">{{trans('book.Inform transfer')}}</a>
                                        @endif
									</td>
								</tr>
                                @endif
                            </table>
                        </td>
					</tr>
                </table>
                <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0;">
                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12.5px; vertical-align: top; margin: 0; padding: 17px 70px; text-align: center; color: #797d83;" valign="top">
							<?php
								$addressLocale = isset($config['addresses'][$config['lang']['code']])? $config['addresses'][$config['lang']['code']]: '';
							?>
							<p>{!! $addressLocale !!}</p>
                        </td>
                    <tr>
                </table>
            </div>
		</td>
	</tr></table></body>
</html>
