@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/dashboard/assets/css/table-responsive.css" />
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-3" style="padding-left:20px;">{{trans('employee.Employee Management')}}</div>
							<div class="col-md-9">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="{{$request->fullUrl()}}">
									<div class="form-group">
										<div class="input-group pull-right" style="width:300px;">
											<input
												type="text"
												name="q"
												placeholder="{{trans('_.Search')}}..."
												class="form-control input-sm"
												value="{{$q}}">
											<span class="input-group-btn">
												<button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
											</span>
										</div>
									</div>
									<a href="/dashboard/employees/create" class="btn btn-danger btn-sm">
										{{trans('employee.Add New Employee')}}
									</a>
								</form>
							</div>
						</div>
                    </header>
                    <table class="table table-striped table-advance table-hover table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th>{{trans('_.First name')}}</th>
                                <th>{{trans('_.Last name')}}</th>
                                <th>{{trans('_.Username')}}</th>
                                <th>{{trans('_.Email address')}}</th>
                                <th>{{trans('_.Status')}}</th>
                                <th style="width:210px;"></th>
                            </tr>
                        </thead>
                        <tbody>
							@if($people->count() > 0)
								@foreach($people as $index => $person)
									<tr ng-controller="ItemController" ng-init="userid='{{$person->userid}}';id={{$person->id}}">
										<td data-title="{{trans('_.First name')}}">{{$person->firstname}}</td>
                                        <td data-title="{{trans('_.Last name')}}">{{$person->lastname}}</td>
                                        <td data-title="{{trans('_.Username')}}">{{$person->username}}</td>
                                        <td data-title="{{trans('_.Email address')}}"><a href="mailto:{{$person->email}}">{{$person->email}}</a></td>
                                        <td data-title="{{trans('_.Status')}}">
                                            @if($person->status == 'a')
                                            <span class="label label-default">{{trans('_.'.$person->getStatus())}}</span>
                                            @elseif($person->status == 'p')
                                            <span class="label label-warning"><em>{{trans('_.'.$person->getStatus())}}</em></span>
                                            @elseif($person->status == 'b')
                                            <span class="label label-danger"><em>{{trans('_.'.$person->getStatus())}}</em></span>
                                            @endif
                                        </td>
                                        <td class="text-right">
											<a href="/dashboard/employees/{{$person->userid}}" class="btn btn-default btn-xs">{{trans('employee.User info')}}</a>
                                            <a href="/dashboard/employees/{{$person->userid}}/edit" class="btn btn-primary btn-xs">{{trans('_.Edit')}}</a>
											<button class="btn btn-danger btn-xs" ng-click="delete()" ng-disabled="deleting">{{trans('_.Delete')}}</button>
											<img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="deleting && !complete">
										</td>
									</tr>
								@endforeach
							 @else
							 <tr>
							 	<td colspan="6" style="text-align:center;">{{trans('_.No record found.')}}</td>
							 </tr>
							 @endif
                        </tbody>
                    </table>
                    <footer class="ui_pagination">
                        <div class="row">
                            <div class="col-lg-4" style="padding-left:20px;">
                                <div class="show_entry">
                                    <span>
										{{trans_choice('_.TABLE_SHOWING', $people->total(), array(
											'showing' => ($people->count() == 0? 0 :($people->currentPage()*$people->perPage())-($people->perPage()-1)),
											'to' => ($people->perPage()*($people->currentPage()-1))+$people->count(),
											'of' => $people->total()
										))}}
									 </span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="dataTables_paginate paging_bootstrap pagination page_list">
                                    <ul>
								        @if($people->currentPage() != 1)
                                        <li class="prev"><a href="{{ $people->url(1) }}">← {{trans('_.First page')}}</a></li>
                                        @else
                                        <li class="prev disabled"><a href="javascript:;">← {{trans('_.First page')}}</a></li>
                                        @endif

                                        @for ($i = 1; $i <= $people->lastPage(); $i++)
                                            @if($people->lastPage() <= 15)
                                            <li @if($people->currentPage() == $i) class="active" @endif><a href="{{ $people->url($i) }}">{{ $i }}</a></li>
                                            @else
                                                @if($people->currentPage() <= 5)
                                                    @if($i < 9 || $i > ($people->lastPage()-2))
                                                    <li @if($people->currentPage() == $i) class="active" @endif><a href="{{ $people->url($i) }}">{{ $i }}</a></li>
                                                    @elseif(($people->lastPage()-2) == $i)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @elseif($people->currentPage() > $people->lastPage()-5)
                                                    @if($i < 3 || $i > ($people->lastPage()-8))
                                                    <li @if($people->currentPage() == $i) class="active" @endif><a href="{{ $people->url($i) }}">{{ $i }}</a></li>
                                                    @elseif($i == 3)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @else
                                                    @if(
                                                        $i < 3 ||
                                                        $i > $people->lastPage()-2 ||
                                                        ($i > $people->currentPage()-3 && $i < $people->currentPage()+3)
                                                    )
                                                    <li @if($people->currentPage() == $i) class="active" @endif><a href="{{ $people->url($i) }}">{{ $i }}</a></li>
                                                    @elseif($i == 3 || $people->lastPage()-2 == $i)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @endif
                                            @endif
                                        @endfor

                                        @if($people->currentPage() != $people->lastPage() && $people->count() != 0)
                                        <li class="next"><a href="{{ $people->url($people->lastPage()) }}">{{trans('_.Last page')}} →</a></li>
                                        @else
                                        <li class="next disabled"><a href="javascript:;">{{trans('_.Last page')}} →</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </footer>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script>
(function(){
	$(function(){
		$('#main-content').removeClass('hidden');
	});

    @if(session()->has('sMessage'))
	noty({
		text: '{!!session('sMessage')!!}',
		layout: 'topRight',
		type: 'success',
		dismissQueue: true,
		template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
		animation: {
			open: {height: 'toggle'},
			close: {height: 'toggle'},
			easing: 'swing',
			speed: 300
		},
		closeWith: ['button'],
		buttons: [
			{addClass: 'btn btn-xs btn-default', text: 'View', onClick: function($noty) {
					$noty.close();
					window.location.href = '/dashboard/employees/{{$request->get('uid')}}';
				}
			},
			{addClass: 'btn btn-xs btn-danger', text: 'Close', onClick: function($noty) {
					$noty.close();
				}
			}
		]
	});
    @endif

    app.controller('ItemController', function($scope, $http, $timeout, $window){
        $scope.complete     = false;
        $scope.deleting     = false;

        $scope.delete = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/employees/'+$scope.userid, {
                    id: $scope.id
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.complete = true;
                        $timeout(function(){
                            $window.location.reload();
                        }, 100);
                    }
                    else{
                        $timeout(function(){
                            alert(resp.message);
                        }, 100);
                    }
                })
                .error(function(){
                    $timeout(function(){
                        alert('{{trans('error.general')}}');
                    }, 100);
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
