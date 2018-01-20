@extends('dashboard.layout')

@section('head')
<link rel="stylesheet" href="/static/bower_components/air-datepicker/dist/css/datepicker.min.css" type="text/css" media="screen" />
<style>
.datepicker {
    width: 350px;
    max-width: 100%;
    margin: 0 auto;
}
.datepicker--cell {
    height: 40px;
}
.datepicker--day-name {
    color: #333 !important;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Disabled">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-9">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
                        <div class="row">
							<div class="col-md-6">
								<a href="/dashboard/tours/{{$tour->tourid}}" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
								<span class="ui-head">{{trans('tour.Disabled Dates')}}</span>
							</div>
                            <div class="col-md-6">
                                <form class="form-inline pull-right pull-left-sm" role="form" method="post" action="{{$request->fullUrl()}}" ng-submit="save()">
                                    <button class="btn btn-danger btn-sm" type="submit" ng-disabled="disabled" ng-class="{'pull-right':(screen == 'md' || screen == 'lg')}">{{trans('_.Save changes')}}</button>
                                    <input type="hidden" name="dates" id="ui-dates">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </form>
							</div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 165px);">
                        @if(session()->has('eMessage'))
                        <div class="alert alert-danger fade in">
							<button data-dismiss="alert" class="close close-sm" type="button">
								<i class="fa fa-times"></i>
							</button>
							{{session('eMessage')}}
						</div>
                        @endif
                        <div class="row" style="margin-top: 30px;">
                            <div class="col-xs-12">
                                <div class="ui-input"></div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/moment/min/moment.min.js"></script>
<script src="/static/bower_components/air-datepicker/dist/js/datepicker.min.js"></script>
<script src="/static/bower_components/air-datepicker/dist/js/i18n/datepicker.en.js"></script>
<script>
app.controller('Disabled', function($scope, $http, $window, $log){
    $scope.dates = [];

    $scope.save = function(){
        $scope.disabled = true;
    };

    $(function(){
        $('.ui-input').datepicker({
            language: 'en',
            multipleDates: true,
            dateFormat: 'yyyy-mm-dd',
            onSelect: function(){
                $('#ui-dates').val( $('.ui-input').val() );
            }
        });

        @foreach(json_decode($tour->disabled) as $date)
        $('.ui-input').data('datepicker').selectDate(new Date( (moment('{{$date}}').format('YYYY')), (moment('{{$date}}').format('MM')-1), (moment('{{$date}}').format('DD'))));
        @endforeach
    });
});
</script>
@endsection
