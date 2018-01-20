@extends('dashboard.layout')

@section('head')
<link href="/static/bower_components/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css">
<style>
.ui-table tbody tr td:first-child{
	width:150px;
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
.hook-image {
    position: relative;
    width: 100%;
    margin-bottom: 5px;
}
.hook-image a {
    position: relative;
    display: block;
    width: 80px;
    height: 80px;
}
.hook-image a img {
    display: block;
    width: 100%;
    height: 100%;
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
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Enquiry">
    <section class="wrapper">
		<div class="row">
            <div class="col-lg-10">
		        <section class="panel">
		            <header class="panel-heading">
		                <div class="row">
		                    <div class="col-sm-12">
								<a href="/dashboard/enquiry" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
                                <button type="button" class="btn btn-sm btn-danger pull-right" ng-click="delete()" ng-disabled="deleting || deleted">[[(deleting?'{{trans('_.Deleting...')}}':'{{trans('_.Delete')}}')]]</button>
		                    </div>
		                </div>
		            </header>
		            <table class="table table-striped table-advance ui-table">
		                <thead></thead>
		                <tbody>
		                    <tr>
		                        <td><strong>{{trans('enquiry.Ref ID')}}</strong></td>
		                        <td>{{$enquiry->enquiryid}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('enquiry.Jewel code')}}</strong></td>
		                        <td>
									@if($enquiry->product)
										<a href="/dashboard/products/{{$enquiry->product->productid}}">{{$enquiry->product->code}}</a>
									@else
										-
									@endif
								</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('enquiry.Jewel')}}</strong></td>
		                        <td>
									@if($enquiry->product)
										{{str_limit($enquiry->product->getTitle($config['lang']['code']), $limit = 52, $end = '...')}}
									@else
										-
									@endif
								</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Full name')}}</strong></td>
		                        <td>{{$enquiry->fullname}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Country')}}</strong></td>
		                        <td>
									@if($enquiry->country)
		                            	{{$enquiry->country->country_name}}
									@else
										-
		                            @endif
								</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Phone number')}}</strong></td>
		                        <td>
									@if(trim($enquiry->phone) != '')
										{{$enquiry->phone}}
									@else
										-
		                            @endif

								</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Email address')}}</strong></td>
		                        <td><a href="mailto:{{$enquiry->email}}">{{$enquiry->email}}</a></td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Detail')}}</strong></td>
		                        <td>{!! nl2br($enquiry->detail) !!}</td>
		                    </tr>
                            @if($enquiry->product && $enquiry->product->hook_status == '1' && $enquiry->hookid != '')
                                <?php $items = json_decode($enquiry->product->hook->items) ?>
                                @foreach($items as $row)
                                    @foreach($row as $column)
                                        @if(isset($column->id) && $column->id == $enquiry->hookid)
                                        <tr>
            		                        <td><strong>{{trans('enquiry.Hook')}}</strong></td>
            		                        <td>
                                                @if(isset($column->image) && $column->image != '' && isset($column->image->id) && isset($column->image->imageid))
                                                    <?php $image = App\HookImage::find($column->image->id); ?>
                                                    @if($image && $image->imageid == $column->image->imageid)
                                                    <div class="hook-image">
                                                        <a href="#" ng-click="showHookImage($event, '{{$image->imageid}}')">
                                                            <img src="/app/product/{{$enquiry->product->productid}}/{{$enquiry->product->hook->hookid}}/{{$image->imageid}}_t.png">
                                                        </a>
                                                    </div>
                                                    @endif
                                                @endif
                                                @if(isset($column->text) && trim($column->text) != '')
                                                    {!! nl2br($column->text) !!}
                                                @endif
                                            </td>
            		                    </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
							<tr>
		                        <td><strong>{{trans('enquiry.Sent time')}}</strong></td>
		                        <td>{{$enquiry->created_at->format('d F Y H:i:s')}}</td>
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
		                    <div class="col-sm-12">{{trans('enquiry.Send Message')}}</div>
		                </div>
		            </header>
		            <div class="panel-body">
                        <form class="form-horizontal tasi-form" method="post" action="" name="form" ng-controller="SendMessage" ng-submit="send($event)">
                            @if($enquiry->messages->count() > 0)
                            <div class="items">
                                @foreach($enquiry->messages as $index => $message)

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
                                    <textarea class="form-control" rows="3" placeholder="{{trans('enquiry.The message will be sent to the email address of the customer.')}}" data-plugin="autosize" ng-model="message"></textarea>
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
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="/static/bower_components/autosize/dist/autosize.min.js"></script>
<script>
(function(){
	$(function(){
		$('#main-content').removeClass('hidden');
        autosize($('[data-plugin=autosize]'));
	});

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

                $http.post('/ajax/dashboard/enquiry/{{$enquiry->enquiryid}}/sendmessage', {
                    id: {{$enquiry->id}},
                    text: $scope.message.trim()
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.message = null;
                        $window.location.href = '/dashboard/enquiry/{{$enquiry->enquiryid}}?messageid='+resp.payload.messageid;
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
    });

	app.controller('Enquiry', function($scope, $http, $window){
        $scope.showHookImage = function($event, imageid){
            @if($enquiry->product)
            $.fancybox({
                href: '/app/product/{{$enquiry->product->productid}}/{{$enquiry->product->hook->hookid}}/'+imageid+'.png',
                padding: 9
            });
            @endif
            $event.preventDefault();
        };

        $scope.delete = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/enquiry/{{$enquiry->enquiryid}}/delete', {
                    id: {{$enquiry->id}}
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.deleted = true;
                        $window.location.href = '/dashboard/enquiry';
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
                    $scope.deleting = false;
                });
            }
        };
	});
})();
</script>
@endsection
