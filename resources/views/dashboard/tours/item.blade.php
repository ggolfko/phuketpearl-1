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
.ui-detail {
    line-height: 21px;
}
.ui-detail img,
.ui-detail iframe {
    max-width: 100%;
}
.map {
	position: relative;
	width: 100%;
    max-width: 100%;
    height: 450px;
    border: 1px solid #ccc;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
}
.map .map-frame {
	border: none;
	position: relative;
}
.note-line {
	position: relative;
	padding-left: 15px;
}
.note-line::before {
	content: '*';
	font-size: 14px;
	position: absolute;
	width: 10px;
	height: 100%;
	top: 0;
	left: 0;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Item">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-10">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-md-4">
								<a href="/dashboard/tours" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
		                    </div>
                            <div class="col-md-8">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="get" action="">
                                    <a href="/tours/{{$tour->url}}.html" target="_blank" class="btn btn-default btn-sm">
										{{trans('_.View on Frontend')}}
									</a>
                                    <a href="/dashboard/tours/{{$tour->tourid}}/images" class="btn btn-danger btn-sm">
										{{trans('tour.Package Images')}}
									</a>
                                    <a href="/dashboard/tours/{{$tour->tourid}}/disabled" class="btn btn-danger btn-sm hidden">
										{{trans('tour.Disabled Dates')}}
									</a>
                                    <a href="/dashboard/tours/{{$tour->tourid}}/edit" class="btn btn-danger btn-sm">
										{{trans('_.Edit')}}
									</a>
								</form>
                            </div>
						</div>
                    </header>
                    <table class="table table-striped table-advance ui-table">
		                <thead></thead>
		                <tbody>
                            <tr>
		                        <td><strong>{{trans('_.Publish')}}</strong></td>
		                        <td>
                                    @if($tour->publish == '1')
									<span class="label label-default">{{trans('_.Yes')}}</span>
									@elseif($tour->publish == '0')
									<span class="label label-danger"><em>{{trans('_.No')}}</em></span>
									@endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Views')}}</strong></td>
		                        <td>
                                    {{number_format($tour->views)}}
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Title')}}</strong></td>
		                        <td>{!! $tour->getTitle($config['lang']['code']) !!}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('product.Code')}}</strong></td>
		                        <td>{{$tour->code}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.URL')}}</strong></td>
		                        <td>{{config('app.url')}}/tours/<strong>{{$tour->url}}</strong>.html</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('tour.New package')}}</strong></td>
		                        <td>
                                    @if($tour->new == '1')
									<span class="label label-default">{{trans('_.Yes')}}</span>
									@elseif($tour->new == '0')
									<span class="label label-danger"><em>{{trans('_.No')}}</em></span>
									@endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('tour.Popular package')}}</strong></td>
		                        <td>
                                    @if($tour->popular == '1')
									<span class="label label-default">{{trans('_.Yes')}}</span>
									@elseif($tour->popular == '0')
									<span class="label label-danger"><em>{{trans('_.No')}}</em></span>
									@endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('tour.Recommended package')}}</strong></td>
		                        <td>
                                    @if($tour->recommend == '1')
									<span class="label label-default">{{trans('_.Yes')}}</span>
									@elseif($tour->recommend == '0')
									<span class="label label-danger"><em>{{trans('_.No')}}</em></span>
									@endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('tour.Price type')}}</strong></td>
		                        <td>
                                    @if($tour->price_type == 'person')
                                        {{trans('tour.Single ticket')}}
                                    @elseif($tour->price_type == 'package')
                                        {{trans('tour.Bundle ticket')}}
									@elseif($tour->price_type == 'free')
                                        {{trans('tour.Free Transfer ticket')}}
                                    @endif
                                </td>
		                    </tr>
							@if($tour->price_type == 'free')
                            <tr>
		                        <td><strong>{{trans('tour.Maximum guests')}}</strong></td>
                                <td>{{number_format($tour->maximum_guests)}}</td>
		                    </tr>
                            @endif
                            <tr>
                                <td><strong>{{trans('_.Payments')}}</strong></td>
                                <td>
                                    @if($tour->getPayments()->count() < 1)
                                    -
                                    @else
                                        <ul>
                                        @foreach($tour->getPayments() as $map)
                                            @if($map->payment)
                                            <li>{{$map->payment->name}}</li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    @endif
                                </td>
                            </tr>
                            @if($tour->price_type == 'person')
                            <tr>
		                        <td><strong>{{trans('_.Price')}}</strong></td>
                                <td>
                                    {{trans('_.Adult')}} {{number_format($tour->price_person_adult, 2)}} THB<br>
                                    {{trans('_.Child')}} {{number_format($tour->price_person_child, 2)}} THB
                                </td>
		                    </tr>
                            @endif
                            @if($tour->price_type == 'package')
                            <tr>
		                        <td><strong>{{trans('_.Price')}}</strong></td>
		                        <td>
                                    {{number_format($tour->price_package, 2)}} THB<br>
                                    {{trans('tour.Number of adult and child')}}: {{$tour->number_package_adult}}
									<span class="hidden">
										<br>
                                    	{{trans('_.Number of children')}} {{$tour->number_package_child}} {{trans_choice('_.PERSON_LOWERCASE', $tour->number_package_adult)}}
									</span>
                                </td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('tour.Extra visitors')}}</strong></td>
		                        <td>
                                    @if($tour->extras->count() > 0)
										<ul>
											@foreach($tour->extras as $extra)
											<li>+{{$extra->number}} (+{{number_format($extra->price, 2)}} THB)</li>
											@endforeach
										</ul>
									@else
										-
									@endif
                                </td>
		                    </tr>
                            @endif
                            <tr>
		                        <td><strong>{{trans('_.Detail')}}</strong></td>
		                        <td class="ui-detail">{!! nl2br($tour->getDetail($config['lang']['code'])) !!}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('tour.Closed day')}}</strong></td>
		                        <td>
									<?php
										$disabled = json_decode($tour->disabled_days_week);
										$days = [];

										foreach ($disabled as $disable){
											if ($disable == '0'){
												$days[] = trans('_.Sunday');
											}
											if ($disable == '1'){
												$days[] = trans('_.Monday');
											}
											if ($disable == '2'){
												$days[] = trans('_.Tuesday');
											}
											if ($disable == '3'){
												$days[] = trans('_.Wednesday');
											}
											if ($disable == '4'){
												$days[] = trans('_.Thursday');
											}
											if ($disable == '5'){
												$days[] = trans('_.Friday');
											}
											if ($disable == '6'){
												$days[] = trans('_.Saturday');
											}
										}
									?>
									@if(count($disabled) > 0)
										{{implode(', ', $days)}}
									@else
										-
									@endif
								</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('tour.Closed month')}}</strong></td>
		                        <td>
									<?php
										$disabled = json_decode($tour->disabled_days_month);
										$months = [];

										foreach ($disabled as $disable){
											if ($disable == '1'){
												$months[] = trans('_.January');
											}
											if ($disable == '2'){
												$months[] = trans('_.February');
											}
											if ($disable == '3'){
												$months[] = trans('_.March');
											}
											if ($disable == '4'){
												$months[] = trans('_.April');
											}
											if ($disable == '5'){
												$months[] = trans('_.May');
											}
											if ($disable == '6'){
												$months[] = trans('_.June');
											}
											if ($disable == '7'){
												$months[] = trans('_.July');
											}
											if ($disable == '8'){
												$months[] = trans('_.August');
											}
											if ($disable == '9'){
												$months[] = trans('_.September');
											}
											if ($disable == '10'){
												$months[] = trans('_.October');
											}
											if ($disable == '11'){
												$months[] = trans('_.November');
											}
											if ($disable == '12'){
												$months[] = trans('_.December');
											}
										}
									?>
									@if(count($disabled) > 0)
										{{implode(', ', $months)}}
									@else
										-
									@endif
								</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Time')}}</strong></td>
		                        <td>
                                    <?php
										$times = json_decode($tour->times);
									?>
									@if(count($times) > 0)
										@foreach($times as $index => $time)
											{{$time->start}}
											@if(!is_bool($time->end))
												- {{$time->end}}
											@endif
											@if($index+1 <= count($times)-1) , &nbsp; @endif
										@endforeach
									@else
										-
									@endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Map')}}</strong></td>
		                        <td>
                                    @if($tour->map_enabled == '1')
									<div class="map">
					                    <iframe
											class="map-frame"
											frameborder="0"
											width="100%"
											height="450px"
											src="{{$tour->map_src}}"
											allowfullscreen>
										</iframe>
					                </div>
									@else
									<span class="label label-danger"><em>{{trans('_.Not specified')}}</em></span>
									@endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Highlight')}}</strong></td>
                                <td>
                                    <?php
                                        $highlight_un   = unserialize($tour->getHighlight($config['lang']['code']));
                                        $highlight      = explode(',', $highlight_un);
                                    ?>
                                    @if(count($highlight) > 0 && $highlight_un != '')
                                    <ul>
                                        @foreach($highlight as $item)
                                        <li>{!! $item !!}</li>
                                        @endforeach
                                    </ul>
                                    @else
                                    -
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Note')}}</strong></td>
		                        <td>
                                    <?php $note = $tour->getNote($config['lang']['code']); ?>
                                    @if(trim($note) == '')
                                    -
                                    @else
										<?php $notes = explode("\n", $note); ?>
                                    	@foreach($notes as $line)
				                        <div class="note-line">
											<span>
												{{$line}}
											</span>
										</div>
										@endforeach
                                    @endif
                                </td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Keywords')}}</strong></td>
		                        <td>{!! $keywords !!}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans("tour.Show child's age")}}</strong></td>
								<td>
                                    @if($tour->show_child_age == '1')
									<span class="label label-default">{{trans('_.Yes')}}</span>
									@elseif($tour->show_child_age == '0')
									<span class="label label-danger"><em>{{trans('_.No')}}</em></span>
									@endif
                                </td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Created at')}}</strong></td>
		                        <td>{{$tour->created_at->format('d F Y H:i:s')}}</td>
		                    </tr>
							<tr>
		                        <td><strong>{{trans('_.Updated at')}}</strong></td>
		                        <td>{{$tour->updated_at->format('d F Y H:i:s')}}</td>
		                    </tr>
                            <tr>
		                        <td><strong>{{trans('_.Options')}}</strong></td>
		                        <td>
                                    <button type="button" class="btn btn-sm btn-danger" ng-disabled="deleting || deleted" ng-click="delete()">[[(deleting?'{{trans('_.Deleting...')}}':'{{trans('_.Delete')}}')]]</button>
                                </td>
		                    </tr>
		                </tbody>
		            </table>
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
app.controller('Item', function($scope, $http, $window){
    $scope.deleting = false;
    $scope.deleted  = false;

    $scope.delete = function(){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.deleting = true;

            $http.post('/ajax/dashboard/tours/{{$tour->tourid}}/delete')
            .success(function(resp){
                if (resp.status == 'ok'){
                    $scope.deleted = true;
                    $window.location.href = '/dashboard/tours';
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

function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

$(function(){
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
});
</script>
@endsection
