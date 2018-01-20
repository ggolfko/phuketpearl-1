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
iframe {
    width: 100%;
    border: none;
    overflow: hidden;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="item">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-10">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-12">
								<a href="/dashboard/newsletter" class="btn btn-danger btn-sm">
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
		                        <td><strong>{{trans('subscribe.Subject')}}</strong></td>
		                        <td>
                                    {{$letter->subject}}
                                </td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Status')}}</strong></td>
		                        <td>
									<span class="label label-danger" ng-if="item.status != 'sending' && item.status != 'sent'">{{trans('subscribe.Problem occurred')}}</span>
									<span class="label label-warning" ng-if="item.status == 'sending'">{{trans('subscribe.Sending')}}</span>
									<span class="label label-success" ng-if="item.status == 'sent'">{{trans('subscribe.Sent')}}</span>
                                </td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('subscribe.Recipients')}}</strong></td>
		                        <td>
									<span ng-if="item.status != 'sent'">-</span>
									<span ng-if="item.status == 'sent'">[[item.emails_sent | number]]</span>
                                </td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('subscribe.Sent time')}}</strong></td>
		                        <td>
									<span ng-if="item.status != 'sent'">-</span>
									<span ng-if="item.status == 'sent'">[[item.deliver_time | amDateFormat:'DD MMMM YYYY HH:mm:ss']]</span>
                                </td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('subscribe.Compose time')}}</strong></td>
		                        <td>
									[[item.created_at | amDateFormat:'DD MMMM YYYY HH:mm:ss']]
                                </td>
		                    </tr>
		                </tbody>
		            </table>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10">
                <iframe src="/ajax/dashboard/newsletter/{{$letter->letterid}}/sent" class="hidden" id="sent-frame"></iframe>
            </div>
        </div>
    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/moment/moment.js"></script>
<script src="/static/bower_components/angular-moment/angular-moment.min.js"></script>
<script>
app.requires.push('angularMoment');

app.controller('item', function($scope, $http, $window, $timeout){
	$scope.item = {!! json_encode($letter) !!};

	if ($scope.item.status == 'sending')
	{
		$http.get('/ajax/dashboard/newsletter/' + $scope.item.letterid + '/status')
		.success(function(data){
			if (data.status == 'ok'){
				$scope.item.deliver_time	= data.payload.deliver_time;
				$scope.item.emails_sent		= data.payload.emails_sent;
				$scope.item.status			= data.payload.status;
			}
		});
	}

    $scope.deleting = false;
    $scope.deleted = false;

    $scope.delete = function(){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.deleting = true;

            $http.post('/ajax/dashboard/newsletter/{{$letter->letterid}}/delete', {
                id: {{$letter->id}}
            })
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.deleted = true;
                    $window.location.href = '/dashboard/newsletter';
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

$(function(){
    $('#sent-frame').bind('load', function(){
        $(this).removeClass('hidden');
        $(this).css('height', $(this).contents().height()+'px');
    });
});
</script>
@endsection
