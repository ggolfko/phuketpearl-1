@extends('dashboard.layout')

@section('head')
<style>
.ui-table tbody tr td:first-child{
	width:190px;
	padding-left:18px;
}
.ui-table tbody tr td ul{
	padding-left: 17px;
}
.ui-table tbody tr td ul li{
	list-style: circle;
    margin-top: 2px;
    margin-bottom: 2px;
}
.payment-images {
    margin-top: 5px;
}
.payment-images img {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
}

.sendMessage textarea {
    max-width: 100%;
}
.sendMessage button {
    margin-top: 5px;
}
.sendMessage .items {
    position: relative;
    margin-bottom: 10px;
}
.sendMessage .room-box:first-child {
    margin-top: 0px;
}
.sendMessage .room-box {
    padding-bottom: 2px;
}
.sendMessage .room-box.receive {
    margin-left: 50px;
    width: calc(100% - 50px);
}
.sendMessage .operation,
.sendMessage .operation a {
    font-size: 12px;
}
.sendMessage .room-box a {
    color: #797979;
    text-decoration: underline;
}
.sendMessage .room-box.focus {
    border-color: #e3c100 !important;
    background-color: #fff3ae !important;
    color: #000 !important;
}
.sendMessage .room-box.focus .text-muted,
.sendMessage .room-box.focus a {
    color: #000 !important;
}

.paid {
    border-color: #e3c100 !important;
    background-color: #fff3ae !important;
    color: #000 !important;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">
		<div class="row">
            <div class="col-lg-10">
		        <section class="panel">
		            <header class="panel-heading">
		                <div class="row">
		                    <div class="col-sm-12">
								<a href="/dashboard/booking" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
                                <button type="button" class="btn btn-sm btn-danger pull-right" ng-controller="Option" ng-click="delete()" ng-disabled="deleting">{{trans('_.Delete')}}</button>
                                @if($book->tour)
                                <a href="/dashboard/tours/{{$book->tour->tourid}}" class="btn btn-sm btn-danger pull-right" style="margin-right:4px;">{{trans('book.Package tour detail')}}</a>
                                @endif
		                    </div>
		                </div>
		            </header>
		            <table class="table table-striped table-advance ui-table">
		                <thead></thead>
		                <tbody>
                            @if($book->payment && $book->completed != '0000-00-00 00:00:00')
                                <tr>
                                    <td colspan="2" @if($request->input('focus') == 'success') class="paid" @endif>
                                        <span>
                                            <span class="label label-danger" style="line-height: 25px;">{{trans('_.Alert')}}!</span>
                                            {!! trans('book.PAID', ['fullname' => "$book->firstname $book->lastname", 'method' => $book->payment->name]) !!}
                                            ({{trans('_.Time')}}: {{dateTime($book->completed, 'd F Y H:i:s')}})
                                            @if($book->payment->code == 'thaibanks')
                                            <a href="/dashboard/booking/{{$book->bookid}}/proof" class="btn btn-primary btn-xs" style="margin-left: 5px;">{{trans('book.See the transfer proof')}}</a>
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @endif
                            @if($book->tour)
                                <tr>
    		                        <td><strong>{{trans('book.Package tour')}}</strong></td>
    		                        <td>{{$book->tour->getTitle($config['lang']['code'])}}</td>
    		                    </tr>
                                <tr>
    		                        <td><strong>{{trans('tour.Price type')}}</strong></td>
    		                        <td>
                                        @if($book->tour->price_type == 'person')
                                            {{trans('tour.Single ticket')}}
                                        @elseif($book->tour->price_type == 'package')
                                            {{trans('tour.Bundle ticket')}}
										@elseif($book->tour->price_type == 'free')
                                            {{trans('tour.Free Transfer ticket')}}
                                        @endif
                                    </td>
    		                    </tr>
								@if($book->tour->price_type == 'free')
                                <tr>
    		                        <td><strong>{{trans('tour.Maximum guests')}}</strong></td>
                                    <td>{{number_format($book->tour->maximum_guests)}}</td>
    		                    </tr>
                                @endif
                                @if($book->tour->price_type == 'person')
                                <tr>
    		                        <td><strong>{{trans('_.Price')}}</strong></td>
                                    <td>
                                        {{trans('_.Adult')}} {{number_format($book->tour->price_person_adult, 2)}} THB<br>
                                        {{trans('_.Child')}} {{number_format($book->tour->price_person_child, 2)}} THB
                                    </td>
    		                    </tr>
                                @endif
                                @if($book->tour->price_type == 'package')
                                <tr>
    		                        <td><strong>{{trans('_.Price')}}</strong></td>
    		                        <td>
                                        {{number_format($book->tour->price_package, 2)}} THB<br>
                                        {{trans('tour.Number of adult and child')}}: {{$book->tour->number_package_adult}}
										<span class="hidden">
											<br>
                                        	{{trans('tour.Number of child')}}: {{$book->tour->number_package_child}}
										</span>
                                    </td>
    		                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td class="text-center">
                                        <em>{{trans('book.This package does not exist or has been deleted.')}}</em>
                                    </td>
                                </tr>
                            @endif
		                </tbody>
		            </table>
		        </section>
			</div>
		</div>

        <div class="row">
            <div class="col-lg-10">
		        <section class="panel">
		            <header class="panel-heading">
		                <div class="row">
		                    <div class="col-sm-12">
								{{trans('book.Booking detail')}}
		                    </div>
		                </div>
		            </header>
		            <table class="table table-striped table-advance ui-table">
		                <thead></thead>
		                <tbody>
		                    <tr>
		                        <td><strong>{{trans('book.Ref ID')}}</strong></td>
		                        <td>{{$book->bookid}}</td>
		                    </tr>
                            @if($book->checkout)
                            <tr>
		                        <td><strong>{{trans('_.Date')}}</strong></td>
		                        <td>{{dateTime($book->checkout->date, 'd F Y')}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Time')}}</strong></td>
		                        <td>{{$book->checkout->time}}</td>
		                    </tr>
							@if($book->tour && $book->tour->price_type == 'free')
                            <tr>
		                        <td><strong>{{trans('tour.Adult')}}</strong></td>
                                <td>{{number_format($book->checkout->adults)}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('tour.Child')}}</strong></td>
                                <td>{{number_format($book->checkout->children)}}</td>
		                    </tr>
                            @endif
                            @if($book->tour && $book->tour->price_type == 'person')
                            <tr>
		                        <td><strong>{{trans('tour.Adult')}}</strong></td>
                                <td>{{number_format($book->checkout->adults)}}x THB {{number_format($book->tour->price_person_adult, 2)}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('tour.Child')}}</strong></td>
                                <td>{{number_format($book->checkout->children)}}x THB {{number_format($book->tour->price_person_children, 2)}}</td>
		                    </tr>
                            @endif
                            @if($book->tour && $book->tour->price_type == 'package')
                            <tr>
		                        <td><strong>{{trans('tour.Package')}}</strong></td>
                                <td>{{number_format($book->checkout->packages)}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Price')}}</strong></td>
                                <td>{{number_format($book->checkout->packages)}}x THB {{number_format($book->tour->price_package, 2)}}</td>
		                    </tr>
							@if($book->checkout->extra)
							<tr>
		                        <td><strong>{{trans('tour.Extra visitors')}}</strong></td>
                                <td>
									+{{$book->checkout->extra->number}} (+{{number_format($book->checkout->extra->price, 2)}} THB)
								</td>
		                    </tr>
							@endif
                            @endif
                            <tr>
		                        <td><strong>{{trans('_.Total amount')}}</strong></td>
		                        <td>{{number_format($book->checkout->total, 2)}} THB</td>
		                    </tr>
                            @endif
                            @if($book->payment)
                            <tr>
		                        <td><strong>{{trans('book.Payment')}}</strong></td>
		                        <td>
                                    {{$book->payment->name}}
                                    <?php $images = json_decode($book->payment->image); ?>
                                    @if(count($images) > 0)
                                    <div class="payment-images">
                                        @foreach($images as $image)
                                        <img src="{{$image}}" style="max-height: 85px;">
                                        @endforeach
                                    </div>
                                    @endif
                                </td>
		                    </tr>
                            @endif
                            <tr>
		                        <td><strong>{{trans('_.First name')}}</strong></td>
		                        <td>{{$book->firstname}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Last name')}}</strong></td>
		                        <td>{{$book->lastname}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('tour.Phuket Area')}}</strong></td>
		                        <td>{{$book->area}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('tour.Hotel Name or other accommodation address')}}</strong></td>
		                        <td>{{$book->hotel}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('tour.Room Number')}}</strong></td>
								<td>
                                    @if(trim($book->room) == '')
                                        -
                                    @else
                                        {{$book->room}}
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Email address')}}</strong></td>
		                        <td><a href="mailto:{{$book->email}}">{{$book->email}}</a></td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Phone number')}}</strong></td>
								<td>
                                    @if(trim($book->phone) == '')
                                        -
                                    @else
                                        {{$book->phone}}
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Country')}}</strong></td>
		                        <td>
                                    @if($book->country)
                                        {{$book->country->country_name}}
									@else
										-
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Note')}}</strong></td>
		                        <td>
                                    @if(trim($book->note) == '')
                                        -
                                    @else
                                        {!! nl2br($book->note) !!}
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('book.Booking time')}}</strong></td>
		                        <td>{{$book->created_at->format('d F Y H:i:s')}}</td>
		                    </tr>
		                </tbody>
		            </table>
		        </section>
			</div>
		</div>

        <div class="row hidden">
            <div class="col-lg-10">
                <hr style="border-color: #d1d1d1;">
            </div>
        </div>

        <div class="row sendMessage hidden">
            <div class="col-lg-10">
		        <section class="panel">
		            <header class="panel-heading">
                        <div class="row">
		                    <div class="col-sm-12">{{trans('book.Send Message')}}</div>
		                </div>
		            </header>
		            <div class="panel-body">
                        <form class="form-horizontal tasi-form" method="post" action="" name="form" ng-controller="SendMessage" ng-submit="send($event)">
                            @if($book->messages->count() > 0)
                            <div class="items">
                                @foreach($book->messages as $index => $message)

                                @if($request->has('messageid') && $request->input('messageid') == $message->messageid)
                                <div class="room-box focus" ng-init="focusOn('{{$message->messageid}}')" id="message-{{$message->messageid}}">
                                @else
                                <div class="room-box">
                                @endif

                                    <p>{!! nl2br($message->text) !!}</p>
                                    <p class="operation"><span class="text-muted">{{trans('book.Sent by')}} :</span>
                                        @if($message->user)
                                            @if($user->role == 'a' && $message->user->role == 'e' && $user->userid != $message->user->userid)
                                                <a href="/dashboard/employees/{{$message->user->userid}}">{{$message->user->firstname}} {{$message->user->lastname}}</a>
                                            @else
                                                {{$message->user->firstname}} {{$message->user->lastname}}
                                            @endif
                                        @else
                                            Unknown User
                                        @endif
                                    | <span class="text-muted">{{trans('_.Time')}} :</span> {{$message->created_at->format('d F Y H:i:s')}}</p>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <div class="form-group" ng-class="{'has-error':error}">
                                <div class="col-xs-12">
                                    <textarea class="form-control" rows="3" placeholder="{{trans('book.Approve the transaction result or any problems that occur.')}}" data-plugin="autosize" ng-model="message"></textarea>
                                    <button type="submit" class="btn btn-danger" ng-disabled="sending">[[(sending?'{{trans('_.Sending...')}}':'{{trans('_.Send')}}')]]</button>
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
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script>
app.controller('SendMessage', function($scope, $http, $window){
    $scope.sending  = false;
    $scope.error    = false;

    $scope.send = function($event){
        if (!$scope.message || $scope.message.trim() == ''){
            $scope.error = true;
        }
        else {
            $scope.sending  = true;
            $scope.error    = false;

            $http.post('/ajax/dashboard/booking/{{$book->bookid}}/sendmessage', {
                text: $scope.message.trim()
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.message = null;
                    $window.location.href = '/dashboard/booking/{{$book->bookid}}?messageid='+resp.payload.messageid;
                }
                else {
                    alert(resp.message);
                    $scope.sending = false;
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
                $window.location.reload();
            });
        }

        $event.preventDefault();
    };

    $scope.focusOn = function(messageid){
        $(function(){
            $('html, body').animate({
                scrollTop: $("#message-"+messageid).offset().top - 70
            }, 'fast');
        });
    };

    $(function(){
        autosize($('[data-plugin=autosize]'));
    });
});

app.controller('Option', function($scope, $http, $window){
    $scope.deleting = false;

    $scope.delete = function(){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.deleting = true;
            $http.post('/ajax/dashboard/booking/{{$book->bookid}}/delete', {
                id: {{$book->id}}
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    $window.location.href = '/dashboard/booking';
                }
                else {
                    alert(resp.message);
                    $scope.deleting = false;
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
                $window.location.reload();
            });
        }
    };
});
</script>
@endsection
