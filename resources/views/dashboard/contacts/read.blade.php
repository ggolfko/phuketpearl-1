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
.reply textarea {
    max-width: 100%;
}
.reply button {
    margin-top: 5px;
}
.reply .items {
    position: relative;
    margin-bottom: 10px;
}
.reply .room-box:first-child {
    margin-top: 0px;
}
.reply .room-box {
    padding-bottom: 2px;
}
.reply .room-box.receive {
    margin-left: 50px;
    width: calc(100% - 50px);
}
.reply .operation,
.reply .operation a {
    font-size: 12px;
}
.reply .room-box a {
    color: #797979;
    text-decoration: underline;
}
.reply .room-box.focus {
    border-color: #e3c100 !important;
    background-color: #fff3ae !important;
    color: #000 !important;
}
.reply .room-box.focus .text-muted,
.reply .room-box.focus a {
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
								<a href="/dashboard/contacts" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
                                <button type="button" class="btn btn-sm btn-danger pull-right" ng-controller="Option" ng-click="delete()" ng-disabled="deleting">{{trans('_.Delete')}}</button>
		                    </div>
		                </div>
		            </header>
		            <table class="table table-striped table-advance ui-table">
		                <thead></thead>
		                <tbody>
		                    <tr>
		                        <td><strong>{{trans('contact.Ref ID')}}</strong></td>
		                        <td>#{{$contact->contactid}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.First name')}}</strong></td>
		                        <td>{{$contact->firstname}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Last name')}}</strong></td>
		                        <td>{{$contact->lastname}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Email address')}}</strong></td>
		                        <td><a href="mailto:{{$contact->email}}">{{$contact->email}}</a></td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Phone number')}}</strong></td>
		                        <td>{{$contact->phone}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Topic')}}</strong></td>
		                        <td>{{$contact->topic}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Message')}}</strong></td>
		                        <td>{!! nl2br($contact->message) !!}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('contact.Contact time')}}</strong></td>
		                        <td>{{$contact->created_at->format('d F Y H:i:s')}}</td>
		                    </tr>
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
		                    <div class="col-sm-12">{{trans('_.Reply')}}</div>
		                </div>
		            </header>
		            <div class="panel-body reply">
                        <form class="form-horizontal tasi-form" method="post" action="" name="form" ng-controller="Reply" ng-submit="send($event)">
                            @if($contact->replies->count() > 0)
                            <div class="items">
                                @foreach($contact->replies as $reply)
                                @if($request->has('replyid') && $request->input('replyid') == $reply->replyid)
                                <div class="room-box focus @if($reply->type == 'r') receive @endif" ng-init="focusOn('{{$reply->replyid}}')" id="reply-{{$reply->replyid}}">
                                @else
                                <div class="room-box @if($reply->type == 'r') receive @endif">
                                @endif
                                    <p>{!! nl2br($reply->message) !!}</p>
                                    @if($reply->type == 's')
                                        <p class="operation"><span class="text-muted">{{trans('contact.Replied by')}} :</span>
                                            @if($reply->user)
                                                @if($user->role == 'a' && $reply->user->role == 'e' && $user->userid != $reply->user->userid)
                                                    <a href="/dashboard/employees/{{$reply->user->userid}}">{{$reply->user->firstname}} {{$reply->user->lastname}}</a>
                                                @else
                                                    {{$reply->user->firstname}} {{$reply->user->lastname}}
                                                @endif
                                            @else
                                                Unknown User
                                            @endif
                                        | <span class="text-muted">{{trans('_.Time')}} :</span> {{$reply->created_at->format('d F Y H:i:s')}}</p>
                                    @elseif($reply->type == 'r')
                                        <p class="operation"><span class="text-muted">{{trans('contact.Replied by')}} :</span>
                                            {{$contact->firstname}} {{$contact->lastname}}
                                        | <span class="text-muted">{{trans('_.Time')}} :</span> {{$reply->created_at->format('d F Y H:i:s')}}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <div class="form-group" ng-class="{'has-error':error}">
                                <div class="col-xs-12">
                                    <textarea class="form-control" rows="3" placeholder="{{trans('contact.Type the reply message...')}}" data-plugin="autosize" ng-model="message"></textarea>
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
$(function(){
    autosize($('[data-plugin=autosize]'));
});

app.controller('Reply', function($scope, $http, $window){
    $scope.sending  = false;
    $scope.error    = false;

    $scope.send = function($event){
        $scope.error = false;

        if (!$scope.message || $scope.message.trim() == ''){
            $scope.error = true;
        }
        else {
            $scope.sending = true;

            $http.post('/ajax/dashboard/contacts/{{$contact->contactid}}/reply', {
                message: $scope.message.trim()
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.message = null;
                    $window.location.href = '/dashboard/contacts/{{$contact->contactid}}?replyid='+resp.payload.replyid;
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
                $scope.sending = false;
            });
        }

        $event.preventDefault();
    };

    $scope.focusOn = function(replyid){
        $(function(){
            $('html, body').animate({
                scrollTop: $("#reply-"+replyid).offset().top - 70
            }, 'fast');
        });
    };
});

app.controller('Option', function($scope, $http, $window){
    $scope.deleting = false;

    $scope.delete = function(){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.deleting = true;

            $http.post('/ajax/dashboard/contacts/{{$contact->contactid}}/delete', {
                id: {{$contact->id}}
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    $window.location.href = '/dashboard/contacts';
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
