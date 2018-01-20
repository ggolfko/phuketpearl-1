@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/dashboard/assets/css/table-responsive.css">
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Wrap">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-3" style="padding-left:20px;">{{trans('_.Package Tours')}}</div>
							<div class="col-md-9">
								<form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
									<a href="/dashboard/tours/terms" class="btn btn-default btn-sm">
    									{{trans('_.Terms and Conditions')}}
									</a>
                                    <a href="/dashboard/tours/create" class="btn btn-danger btn-sm">
										{{trans('tour.Create New Package')}}
									</a>
								</form>
							</div>
						</div>
                    </header>
                    <table class="table table-striped table-advance table-hover table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th>{{trans('product.Code')}}</th>
								<th>{{trans('_.Title')}}</th>
                                <th class="text-center" style="width:80px;">{{trans('tour.New')}}</th>
                                <th class="text-center" style="width:80px;">{{trans('tour.Popular')}}</th>
                                <th class="text-center" style="width:80px;">{{trans('tour.Recommend')}}</th>
                                <th class="text-center" style="width:80px;">{{trans('_.Publish')}}</th>
                                <th class="text-center" style="width:80px;">{{trans('_.Views')}}</th>
                                <th style="width:270px;"></th>
                            </tr>
                        </thead>
                        <tbody>
							@if($items->count() > 0)
								@foreach($items as $index => $item)
									<tr ng-controller="ItemController" ng-init="tourid='{{$item->tourid}}'">
										<td data-title="{{trans('product.Code')}}" style="min-width: 100px;">{{$item->code}}</td>
										<td data-title="{{trans('_.Title')}}">{{$item->getTitle($config['lang']['code'])}}</td>
                                        <td data-title="{{trans('tour.New package')}}" class="text-center">
                                            <input type="checkbox" data-property="new" data-tourid="{{$item->tourid}}" data-plugin="icheck-item" @if($item->new == '1') checked @endif>
                                        </td>
                                        <td data-title="{{trans('tour.Popular package')}}" class="text-center">
                                            <input type="checkbox" data-property="popular" data-tourid="{{$item->tourid}}" data-plugin="icheck-item" @if($item->popular == '1') checked @endif>
                                        </td>
                                        <td data-title="{{trans('tour.Recommended package')}}" class="text-center">
                                            <input type="checkbox" data-property="recommend" data-tourid="{{$item->tourid}}" data-plugin="icheck-item" @if($item->recommend == '1') checked @endif>
                                        </td>
                                        <td data-title="{{trans('_.Publish')}}" class="text-center">
                                            <input type="checkbox" data-property="publish" data-tourid="{{$item->tourid}}" data-plugin="icheck-item" @if($item->publish == '1') checked @endif>
                                        </td>
                                        <td data-title="{{trans('_.Views')}}" class="text-center">
                                            {{number_format($item->views)}}
                                        </td>
                                        <td class="text-right">
                                            <a href="/tours/{{$item->url}}.html" target="_blank" class="btn btn-default btn-xs">{{trans('_.View on Frontend')}}</a>
                                            <a href="/dashboard/tours/{{$item->tourid}}" class="btn btn-default btn-xs">{{trans('tour.View')}}</a>
                                            <a href="/dashboard/tours/{{$item->tourid}}/edit" class="btn btn-primary btn-xs">{{trans('_.Edit')}}</a>
                                            <button class="btn btn-danger btn-xs" ng-click="delete()" ng-disabled="deleting" ng-hide="deleting || complete">{{trans('_.Delete')}}</button>
                                            <img src="/static/dashboard/assets/img/process.gif" class="ui-process" ng-show="deleting && !complete">
										</td>
									</tr>
								@endforeach
							 @else
							 <tr>
							 	<td colspan="8" style="text-align:center;">{{trans('_.No record found.')}}</td>
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
    app.controller('Wrap', function($scope, $http, $window){
        $('input[data-plugin="icheck-item"]').iCheck({
            checkboxClass: 'icheckbox_flat-red'
        })
        .on('ifChecked', function(event){
            $scope.cb($(this).attr('data-property'), $(this).attr('data-tourid'), 'yes');
        })
        .on('ifUnchecked', function(event){
            $scope.cb($(this).attr('data-property'), $(this).attr('data-tourid'), 'no');
        });


        $scope.cb = function(property, tourid, set){
            $http.post('/ajax/dashboard/tours/'+tourid+'/'+property, {
                set: set
            })
            .success(function(resp){
                if (resp.status != 'ok'){
                    alert(resp.message);
                }
            })
            .error(function(){
                alert('{{trans('error.general')}}');
                $window.location.reload();
            });
        }
    });

    app.controller('ItemController', function($scope, $http, $timeout, $window){
        $scope.complete     = false;
        $scope.deleting     = false;

        $scope.delete = function(){
            if (confirm('{{trans('_.Are you sure?')}}')){
                $scope.deleting = true;

                $http.post('/ajax/dashboard/tours/'+$scope.tourid+'/delete')
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.complete = true;
                        $window.location.reload();
                    }
                    else{
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
