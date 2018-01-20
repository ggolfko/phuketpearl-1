@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/dashboard/assets/css/table-responsive.css">
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Index">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
                        <div class="row">
							<div class="col-md-5">
                                @if($request->input('only') == 'unread')
                                <a href="/dashboard/booking" class="btn btn-danger btn-sm" style="margin-right: 10px;">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.All entries')}}
		                        </a>
                                @endif
                                {{trans('_.Tour Booking')}}
                                @if($notopen > 0)
                                ({{number_format($notopen)}})
                                @endif
                            </div>
                            @if($items->total() > 0 || $q != '')
							<div class="col-md-7">
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
                                    <button type="button" class="btn btn-sm btn-danger" ng-show="deleteSelected" ng-click="deleteSelect()" ng-disabled="deleting">{{trans('_.Delete the selected')}}</button>
                                    <button type="button" class="btn btn-danger btn-sm" ng-click="deleteAll()" ng-disabled="deleting">{{trans('_.Delete all')}}</button>
								</form>
							</div>
                            @endif
						</div>
                    </header>
                    <table class="table table-striped table-advance table-hover table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th><input type="checkbox" data-plugin="icheck-selectall"></th>
                                <th>{{trans('book.Package tour')}}</th>
                                <th>{{trans('_.Full name')}}</th>
                                <th>{{trans('book.Amount')}}</th>
                                <th>{{trans('book.Booking time')}}</th>
                                <th class="text-center">{{trans('book.Open')}}</th>
                                <th style="width:122px;"></th>
                            </tr>
                        </thead>
                        <tbody>
							@if($items->count() > 0)
								@foreach($items as $index => $item)
									<tr ng-controller="ItemController" ng-init="id={{$item->id}};bookid='{{$item->bookid}}'">
                                        <td data-title="{{trans('_.Select')}}"><input type="checkbox" data-plugin="icheck-select" data-id="{{$item->id}}" data-bookid="{{$item->bookid}}"></td>
										<td data-title="{{trans('book.Package tour')}}">
                                            @if($item->tour)
                                                {{str_limit($item->tour->getTitle($config['lang']['code']), $limit = 52, $end = '...')}}
                                            @endif
                                        </td>
                                        <td data-title="{{trans('_.Full name')}}">{{$item->firstname}} {{$item->lastname}}</td>
                                        <td data-title="{{trans('book.Amount')}}">
                                            @if($item->checkout)
                                                {{number_format($item->checkout->total, 2)}} THB
                                            @endif
                                        </td>
                                        <td data-title="{{trans('book.Booking time')}}">{{$item->created_at->format('d F Y H:i:s')}}</td>
                                        <td data-title="{{trans('book.Open')}}" class="text-center">
                                            @if($item->open == '0000-00-00 00:00:00')
                                                <span class="label label-danger">{{trans('_.No')}}</span>
                                            @else
                                                <span class="label label-default">{{trans('_.Yes')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a href="/dashboard/booking/{{$item->bookid}}" class="btn btn-default btn-xs">{{trans('_.Detail')}}</a>
                                            <button class="btn btn-danger btn-xs" ng-click="delete()" ng-disabled="deleting" ng-hide="deleting || complete">{{trans('_.Delete')}}</button>
                                            <img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="deleting && !complete">
										</td>
									</tr>
								@endforeach
							 @else
							 <tr>
							 	<td colspan="7" style="text-align:center;">{{trans('_.No record found.')}}</td>
							 </tr>
							 @endif
                        </tbody>
                    </table>
                    <footer class="ui_pagination">
                        <div class="row">
                            <div class="col-lg-4" style="padding-left:20px;">
                                <div class="show_entry">
                                    <span>
										{{trans_choice('_.TABLE_SHOWING', $items->total(), array(
											'showing' => ($items->count() == 0? 0 :($items->currentPage()*$items->perPage())-($items->perPage()-1)),
											'to' => ($items->perPage()*($items->currentPage()-1))+$items->count(),
											'of' => $items->total()
										))}}
									 </span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="dataTables_paginate paging_bootstrap pagination page_list">
                                    <ul>
								        @if($items->currentPage() != 1)
                                        <li class="prev"><a href="{{ $items->url(1) }}">← {{trans('_.First page')}}</a></li>
                                        @else
                                        <li class="prev disabled"><a href="javascript:;">← {{trans('_.First page')}}</a></li>
                                        @endif

                                        @for ($i = 1; $i <= $items->lastPage(); $i++)
                                            @if($items->lastPage() <= 15)
                                            <li @if($items->currentPage() == $i) class="active" @endif><a href="{{ $items->url($i) }}">{{ $i }}</a></li>
                                            @else
                                                @if($items->currentPage() <= 5)
                                                    @if($i < 9 || $i > ($items->lastPage()-2))
                                                    <li @if($items->currentPage() == $i) class="active" @endif><a href="{{ $items->url($i) }}">{{ $i }}</a></li>
                                                    @elseif(($items->lastPage()-2) == $i)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @elseif($items->currentPage() > $items->lastPage()-5)
                                                    @if($i < 3 || $i > ($items->lastPage()-8))
                                                    <li @if($items->currentPage() == $i) class="active" @endif><a href="{{ $items->url($i) }}">{{ $i }}</a></li>
                                                    @elseif($i == 3)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @else
                                                    @if(
                                                        $i < 3 ||
                                                        $i > $items->lastPage()-2 ||
                                                        ($i > $items->currentPage()-3 && $i < $items->currentPage()+3)
                                                    )
                                                    <li @if($items->currentPage() == $i) class="active" @endif><a href="{{ $items->url($i) }}">{{ $i }}</a></li>
                                                    @elseif($i == 3 || $items->lastPage()-2 == $i)
                                                    <li class="disabled"><a href="javascript:;">...</a></li>
                                                    @endif
                                                @endif
                                            @endif
                                        @endfor

                                        @if($items->currentPage() != $items->lastPage() && $items->count() != 0)
                                        <li class="next"><a href="{{ $items->url($items->lastPage()) }}">{{trans('_.Last page')}} →</a></li>
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
    app.controller('Index', function($scope, $http, $window){
        $scope.deleteSelected = false;
        $scope.deleting = false;

        $scope.deleteAll = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;
                $http.post('/ajax/dashboard/booking/deleteall')
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $window.location.reload();
                    }
                    else {
                        alert(resp.message);
                        $scope.deleting = false;
                    }
                })
                .error(function(){
                    alert('{{trans('error.general')}}');
                    $scope.deleting = false;
                    $window.location.reload();
                });
            }
        };

        $scope.deleteSelect = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                var items = [];
                $('input[data-plugin="icheck-select"]:checked').each(function(index, item){
                    items.push({
                        id: $(item).attr('data-id'),
                        bookid: $(item).attr('data-bookid')
                    });
                });
                if (items.length > 0)
                {
                    $scope.deleting = true;
                    $http.post('/ajax/dashboard/booking/deletes', {
                        items: items
                    })
                    .success(function(resp){
                        if (resp.status == 'ok'){
                            $window.location.reload();
                        }
                        else {
                            alert(resp.message);
                            $scope.deleting = false;
                        }
                    })
                    .error(function(){
                        alert('{{trans('error.general')}}');
                        $scope.deleting = false;
                        $window.location.reload();
                    });
                }
            }
        };

        $(function(){
            $('input[data-plugin="icheck-selectall"]').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass: 'iradio_flat-red'
            })
            .on('ifChecked', function(event){
                $('input[data-plugin="icheck-select"]').iCheck('check');
            })
            .on('ifUnchecked', function(event){
                $('input[data-plugin="icheck-select"]').iCheck('uncheck');
            });

            $('input[data-plugin="icheck-select"]').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass: 'iradio_flat-red'
            })
            .on('ifChecked', function(event){
                $scope.deleteSelected = true;
                $scope.$apply();
            })
            .on('ifUnchecked', function(event){
                var len = $('input[data-plugin="icheck-select"]:checked').length;
                if (len < 1){
                    $scope.deleteSelected = false;
                    $scope.$apply();
                }
            });
        });
    });

    app.controller('ItemController', function($scope, $http, $timeout, $window){
        $scope.complete = false;

        $scope.delete = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/booking/'+$scope.bookid+'/delete', {
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
                        $window.location.reload();
                    }, 100);
                })
				.finally(function(){
					$scope.deleting = false;
				});
            }
        };
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
        timeout: 4500
    });
    @endif
})();
</script>
@endsection
