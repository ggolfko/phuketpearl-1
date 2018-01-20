@extends('dashboard.layout')

@section('head')
<link href="/static/node_modules/angular-bootstrap-datetimepicker/src/css/datetimepicker.css?_t=1705201152" rel="stylesheet">
<link href="/static/dashboard/home/ga.css?_t=1705200938" rel="stylesheet">
<style type="text/css">
html, body {
	overflow-x: hidden;
}
.stat {
	display: block;
	width: 100%;
	max-width: 100%;
	color: rgba(42,53,66,.8);
	margin-bottom: 20px;
}
.stat:hover > .count {
	border-top-color: rgba(42,53,66,.85);
	border-left-color: rgba(42,53,66,.85);
	border-right-color: rgba(42,53,66,.85);
}
.stat > .count {
	text-align: center;
	padding: 11.5px 10px;
	font-size: 22px;
	color: #818181;
	overflow: hidden;
	text-overflow: ellipsis;
	background-color: #fff;
	border-top: 1px solid #fff;
	border-left: 1px solid #fff;
	border-right: 1px solid #fff;
	border-top-left-radius: 3.5px;
	border-top-right-radius: 3.5px;
}
.stat > .describe {
	text-align: center;
	padding: 10px 5px;
	color: #f4f4f4;
	background-color: rgba(42,53,66,.85);
	border: 1px solid rgba(42,53,66,.85);
	border-bottom-left-radius: 3.5px;
	border-bottom-right-radius: 3.5px;
}
.stat > .describe > span {
	margin-left: 3px;
}
.stat.has-new > .count {
	border-top-color: #FF6C60;
	border-left-color: #FF6C60;
	border-right-color: #FF6C60;
}

.table-responsive {
	overflow-y: hidden !important;
}
.__warning a {
	color: #8a6d3b;
	text-decoration: underline;
}
.__warning a:hover {
	color: #2a3542;
}
.__warning a.close {
	text-decoration: none !important;
}
.__error a {
	color: #a94442;
	text-decoration: underline;
}
.__error a:hover {
	color: #2a3542;
}
.__error a.close {
	text-decoration: none !important;
}

.audience-options {
	position: relative;
	float: left;
}
.audience-options .disabled {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(255, 255, 255, 0);
}

.audience-dimensions {
	position: relative;
	float: right;
}
.audience-dimensions .disabled {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(255, 255, 255, 0);
}

.audience-date {
	position: relative;
	float: right;
}
.audience-date ._right {
	right: 0 !important;
}
.audience-date._xs {
	float: left !important;
	margin-top: 10px;
}
.audience-date._xs ._wrap {
	position: relative;
	width: calc(100vw - 80px) !important;
	height: auto;
	overflow-x: scroll;
	overflow-y: hidden;
}
.audience-date._xs ._dates ._header {
	padding-right: 5px;
}
.audience-date._xs ._dates ._err {
	padding-right: 5px;
}
.audience-date .disabled {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(255, 255, 255, 0);
}
.audience-date ._wrap {
	position: relative;
}
.audience-date ._dates {
	position: relative;
	padding: 10px;
	width: 675px;
}
.audience-date ._dates ._header {
	position: relative;
	float: left;
	width: 100%;
	font-family: 'Open Sans', sans-serif;
	font-size: 13px;
	padding-bottom: 8px;
}
.audience-date ._dates ._header ._start_date {
	width: 332px;
	float: left;
	padding-left: 2px;
	padding-top: 4px;
}
.audience-date ._dates ._header ._end_date {
	float: left;
	padding-top: 4px;
}
.audience-date ._dates ._header ._apply {
	float: right;
}
.audience-date ._dates ._header ._apply input {
	font-weight: 400 !important;
}
.audience-date ._dates ._start {
	border-radius: 2px;
	position: relative;
	float: left;
}
.audience-date ._dates ._start._bordered {
	border: 1px solid #ccc;
}
.audience-date ._dates ._end {
	border-radius: 2px;
	position: relative;
	float: left;
}
.audience-date ._dates ._end._bordered {
	border: 1px solid #ccc;
}
.audience-date ._dates ._to {
	position: relative;
	float: left;
	padding: 5px;
}
.audience-date ._dates ._err {
	position: relative;
	float: left;
	width: 100%;
	font-family: 'Open Sans', sans-serif;
	font-size: 13px;
	padding-bottom: 8px;
}
.audience-date ._dates ._err .alert {
	margin-bottom: 1px !important;
	padding-top: 12px !important;
	padding-bottom: 12px !important;
}

._help {
	float: right;
	cursor: help;
	padding-top: 2px;
}
._help .fa {
	font-size: 17.5px;
}

.ga-chart1 {
	position: relative;
	min-height: 300px;
}
.ga-chart1 ._doing {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(255, 255, 255, 0.65);
}
.ga-chart1 ._doing ._placeholder {
	position: absolute;
	width: 180px;
	height: 180px;
	top: 50%;
	left: 50%;
	margin-top: -103px;
	margin-left: -90px;
}
.ga-chart1 ._doing ._placeholder img {
	display: inline-block;
	max-width: 100%;
	max-height: 100%;
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=10)";
	filter: alpha(opacity=10);
	opacity: 0.1;
}

.ga-chart {
	position: relative;
	min-height: 300px;
}
.ga-chart ._doing {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(255, 255, 255, 0.65);
}
.ga-chart ._doing ._placeholder {
	position: absolute;
	width: 180px;
	height: 180px;
	top: 50%;
	left: 50%;
	margin-top: -103px;
	margin-left: -90px;
}
.ga-chart ._doing ._placeholder img {
	display: inline-block;
	max-width: 100%;
	max-height: 100%;
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=10)";
	filter: alpha(opacity=10);
	opacity: 0.1;
}

.tooltip-inner {
	max-width: 210px;
    width: 210px;
}
</style>
@endsection

@section('content')

<!--main content start-->
<section id="main-content" class="hidden" ng-controller="index">
    <section class="wrapper" style="min-height: calc(100vh - 40px);">

        <!-- start: state-overview -->
        <div class="row state-overview">
			@if($user->role == 'a' || ($user->role == 'e' && $user->permission_enquiry == '1'))
            <div class="col-lg-2 col-md-4 col-sm-6">
                <a href="/dashboard/enquiry?only=unread" class="stat" ng-class="{'has-new': stat.enquiry > 0}">
					<div class="count">
						<span ng-counter stat="[[stat.enquiry]]"></span>
					</div>
					<div class="describe">
						<i class="fa fa-shopping-bag"></i>
						<span>{{trans('dashboard.New Enquiry')}}</span>
					</div>
				</a>
            </div>
			@endif
            @if($user->role == 'a' || ($user->role == 'e' && $user->permission_book == '1'))
			<div class="col-lg-2 col-md-4 col-sm-6">
                <a href="/dashboard/booking?only=unread" class="stat" ng-class="{'has-new': stat.book > 0}">
					<div class="count">
						<span ng-counter stat="[[stat.book]]"></span>
					</div>
					<div class="describe">
						<i class="fa fa-book"></i>
						<span>{{trans('dashboard.New Booking')}}</span>
					</div>
				</a>
            </div>
			@endif
            @if($user->role == 'a' || ($user->role == 'e' && $user->permission_product == '1'))
			<div class="col-lg-2 col-md-4 col-sm-6">
                <a href="/dashboard/products" class="stat">
					<div class="count">
						<span ng-counter stat="[[stat.jewels]]"></span>
					</div>
					<div class="describe">
						<i class="fa fa-diamond"></i>
						<span>{{trans('_.Pearl Jewels')}}</span>
					</div>
				</a>
            </div>
			@endif
			@if($user->role == 'a' || ($user->role == 'e' && $user->permission_tour == '1'))
			<div class="col-lg-2 col-md-4 col-sm-6">
                <a href="/dashboard/tours" class="stat">
					<div class="count">
						<span ng-counter stat="[[stat.tours]]"></span>
					</div>
					<div class="describe">
						<i class="fa fa-bus"></i>
						<span>{{trans('_.Package Tours')}}</span>
					</div>
				</a>
            </div>
			@endif
			@if($user->role == 'a' || ($user->role == 'e' && $user->permission_news == '1'))
			<div class="col-lg-2 col-md-4 col-sm-6">
                <a href="/dashboard/news" class="stat">
					<div class="count">
						<span ng-counter stat="[[stat.news]]"></span>
					</div>
					<div class="describe">
						<i class="fa fa-newspaper-o"></i>
						<span>{{trans('_.News')}}</span>
					</div>
				</a>
            </div>
			@endif
			@if($user->role == 'a' || ($user->role == 'e' && $user->permission_newsletter == '1'))
			<div class="col-lg-2 col-md-4 col-sm-6">
                <a href="/dashboard/newsletter/subscribers" class="stat">
					<div class="count">
						<span ng-counter stat="[[stat.subscribers]]"></span>
					</div>
					<div class="describe">
						<i class="fa fa-user"></i>
						<span>{{trans('dashboard.Subscribers')}}</span>
					</div>
				</a>
            </div>
			@endif
        </div>
        <!-- end: state-overview -->

		<!-- start: google analytics -->
        <div class="row">
			<div class="col-xs-12">
				<div class="alert alert-warning alert-dismissable __warning" id="warning" @if(!$warning) style="display: none;" @endif>
					<a href="#" class="close hidden" data-toggle="tooltip" title="{{trans('dashboard.Hide')}}" ng-click="hideWarning($event)" id="warningCloseBtn">×</a>
					<a href="#" class="close" id="warningCloseBtnFake">&nbsp;</a>
					<strong>{{trans('dashboard.Warning')}}!</strong> {!!trans('dashboard.WARNING')!!}
				</div>

				<div class="alert alert-danger alert-dismissable __error" id="error" style="display: none;">
					<strong>{{trans('dashboard.Error occurred')}}!</strong> {!!trans('dashboard.ERROR')!!}
				</div>

				<section class="panel" >
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span style="font-size: 15px;">
									Google Analytics &nbsp; &mdash; &nbsp; Audience Overview
								</span>

								<div class="pull-right" data-content="process">
									<img src="/static/dashboard/assets/img/process.gif" style="width: 17px;">
								</div>
								<div class="pull-right" id="warningBtn" style="display: none;">
									<a href="#" data-toggle="tooltip" title="{{trans('dashboard.Warning')}}" ng-click="showWarning($event)" style="color: rgba(42,53,66,.75); text-decoration: none;">
										<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
									</a>
								</div>
							</div>
						</div>
                    </header>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">

								<!-- start: audience options -->
								<div class="audience-options" click-outside="audienceOptionsClose()">
									<div class="_GAy" ng-class="{'active': audienceOptions}" ng-click="audienceOptionsSelect()">
										<div class="ID-buttonText _GAb-_GAci-_GAhi _GAPe">[[audience.text]]</div>
										<div class="_GADe _GAWh"></div>
									</div>
									<div ng-class="{'hidden': !audienceOptions}">
										<div class="_GAwk">
											<ul class="_GAWyb">
												<li class="_GAuf" ng-class="{'_GAQt': audience.value == 'sessions'}" ng-click="audienceOptionsSelected('sessions')">
													<span class="_GAEm"></span>Sessions
												</li>
												<li class="_GAuf" ng-class="{'_GAQt': audience.value == 'users'}" ng-click="audienceOptionsSelected('users')">
													<span class="_GAEm"></span>Users
												</li>
												<li class="_GAuf" ng-class="{'_GAQt': audience.value == 'bounce_rate'}" ng-click="audienceOptionsSelected('bounce_rate')">
													<span class="_GAEm"></span>Bounce Rate
												</li>
												<li class="_GAuf" ng-class="{'_GAQt': audience.value == 'pageviews'}" ng-click="audienceOptionsSelected('pageviews')">
													<span class="_GAEm"></span>Pageviews
												</li>
												<li class="_GAuf" ng-class="{'_GAQt': audience.value == 'pages_session'}" ng-click="audienceOptionsSelected('pages_session')">
													<span class="_GAEm"></span>Pages / Session
												</li>
												<li class="_GAuf" ng-class="{'_GAQt': audience.value == 'session_duration'}" ng-click="audienceOptionsSelected('session_duration')">
													<span class="_GAEm"></span>Avg. Session Duration
												</li>
												<li class="_GAuf" ng-class="{'_GAQt': audience.value == 'new_sessions'}" ng-click="audienceOptionsSelected('new_sessions')">
													<span class="_GAEm"></span>% New Sessions
												</li>
											</ul>
										</div>
									</div>
									<div class="disabled" ng-class="{'hidden': !doing}"></div>
								</div>
								<!-- end: audience options -->

							</div>
							<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">

								<!-- start: audience dimensions -->
								<div class="audience-dimensions hidden">
									<div class="_GApXb">
										<ul class="_GAHh">
											<li class="_GADd" ng-class="{'_GAo': dimension == 'hourly'}" ng-click="dimensionOptionsSelected('hourly')">Hourly</li>
											<li class="_GADd _GAgMb" ng-class="{'_GAo': dimension == 'day'}" ng-click="dimensionOptionsSelected('day')">Day</li>
											<li class="_GADd _GAgMb" ng-class="{'_GAo': dimension == 'week'}" ng-click="dimensionOptionsSelected('week')">Week</li>
											<li class="_GADd _GAgMb" ng-class="{'_GAo': dimension == 'month'}" ng-click="dimensionOptionsSelected('month')">Month</li>
										</ul>
									</div>
									<div class="disabled" ng-class="{'hidden': !doing}"></div>
								</div>
								<!-- end: audience dimensions -->

								<!-- start: audience date -->
								<div class="audience-date" ng-class="{'_xs': screen == 'xs'}" click-outside="datesOptionsClose()">
									<div class="_GAy" ng-class="{'active': datesOptions}" ng-click="datesOptionsSelect()">
										<div class="ID-buttonText _GAb-_GAci-_GAhi _GAPe">
											[[audienceConfigs.startDate | amDateFormat:'DD MMMM YYYY']] &nbsp;—&nbsp; [[audienceConfigs.endDate | amDateFormat:'DD MMMM YYYY']]
										</div>
										<div class="_GADe _GAWh"></div>
									</div>
									<div ng-class="{'hidden': !datesOptions}">
										<div class="_GAwk" ng-class="{'_right': screen != 'xs'}" style="display: none;" id="datesOptions">
											<div class="_wrap">
												<div class="_dates">
													<div class="_header">
														<div class="_start_date">{{trans('dashboard.Start Date')}}</div>
														<div class="_end_date">{{trans('dashboard.End Date')}}</div>

														<div class="_GAyh _apply">
															<input type="button" class="_GAih _GAdb" value="Apply" ng-click="datesOptionsSelectApply()">
														</div>
													</div>
													<div class="_err" ng-show="datesOptionsError">
														<div class="alert alert-danger alert-dismissable">
															{{trans('dashboard.End date must be more than start date at least 1 day.')}}
														</div>
													</div>
													<div class="_start" ng-class="{'_bordered': screen != 'xs'}">
														<datetimepicker data-ng-model="datesOptionsTemp.start" data-datetimepicker-config="{ startView:'day', minView:'day' }"></datetimepicker>
													</div>
													<div class="_to"></div>
													<div class="_end" ng-class="{'_bordered': screen != 'xs'}">
														<datetimepicker data-ng-model="datesOptionsTemp.end" data-datetimepicker-config="{ startView:'day', minView:'day' }"></datetimepicker>
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="disabled" ng-class="{'hidden': !doing}"></div>
								</div>
								<!-- end: audience date -->

							</div>
						</div>
					</div>
					<div ng-class="{'table-responsive': screen != 'lg'}">
						<div class="ga-chart1">
							<div id="ga-chart1"></div>
							<div class="_doing" ng-class="{'hidden': !doing}">
								<div class="_placeholder" ng-class="{'hidden': firstFetch}">
									<img src="/static/dashboard/home/chart-placeholder.png">
								</div>
							</div>
						</div>
					</div>
                </section>
			</div>
        </div>
        <!-- end: google analytics -->

		<!-- start: google analytics -->
        <div class="row">
			<div class="col-md-7">
				<section class="panel" >
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span style="font-size: 15px;">
									Top 10 Countries by Sessions
								</span>
								<div class="_help" title="{{$days30}} — {{$yesterday}}<br><span style='font-size: 11px;'>(</span><span style='font-size: 11.5px;'> Last 30 Days </span><span style='font-size: 11px;'>)</span>" data-toggle="tooltip" data-html="true" data-container="body">
									<i class="fa fa-question-circle" aria-hidden="true"></i>
								</div>
							</div>
						</div>
                    </header>
					<div class="table-responsive">
						<div class="ga-chart">
							<div id="ga-chart2"></div>
							<div class="_doing" ng-class="{'hidden': firstFetch}">
								<div class="_placeholder" ng-class="{'hidden': firstFetch}">
									<img src="/static/dashboard/home/chart-placeholder.png">
								</div>
							</div>
						</div>
					</div>
                </section>
			</div>

			<div class="col-md-5">
				<section class="panel" >
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span style="font-size: 15px;">
									Top 10 Countries by Users
								</span>
								<div class="_help" title="{{$days30}} — {{$yesterday}}<br><span style='font-size: 11px;'>(</span><span style='font-size: 11.5px;'> Last 30 Days </span><span style='font-size: 11px;'>)</span>" data-toggle="tooltip" data-html="true" data-container="body">
									<i class="fa fa-question-circle" aria-hidden="true"></i>
								</div>
							</div>
						</div>
                    </header>
					<div class="table-responsive">
						<div class="ga-chart">
							<div id="ga-chart4"></div>
							<div class="_doing" ng-class="{'hidden': firstFetch}">
								<div class="_placeholder" ng-class="{'hidden': firstFetch}">
									<img src="/static/dashboard/home/chart-placeholder.png">
								</div>
							</div>
						</div>
					</div>
                </section>
			</div>
        </div>
        <!-- end: google analytics -->

		<!-- start: google analytics -->
        <div class="row">
			<div class="col-md-4">
				<section class="panel" >
					<header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span style="font-size: 15px;">
									Sessions by Device Category
								</span>
								<div class="_help" title="{{$days30}} — {{$yesterday}}<br><span style='font-size: 11px;'>(</span><span style='font-size: 11.5px;'> Last 30 Days </span><span style='font-size: 11px;'>)</span>" data-toggle="tooltip" data-html="true" data-container="body">
									<i class="fa fa-question-circle" aria-hidden="true"></i>
								</div>
							</div>
						</div>
					</header>
					<div class="table-responsive">
						<div class="ga-chart">
							<div id="ga-chart6"></div>
							<div class="_doing" ng-class="{'hidden': firstFetch}">
								<div class="_placeholder" ng-class="{'hidden': firstFetch}">
									<img src="/static/dashboard/home/chart-placeholder.png">
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>

			<div class="col-md-8">
				<section class="panel" >
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span style="font-size: 15px;">
									Most Languages Usage
								</span>
								<div class="_help" title="{{$days30}} — {{$yesterday}}<br><span style='font-size: 11px;'>(</span><span style='font-size: 11.5px;'> Last 30 Days </span><span style='font-size: 11px;'>)</span>" data-toggle="tooltip" data-html="true" data-container="body">
									<i class="fa fa-question-circle" aria-hidden="true"></i>
								</div>
							</div>
						</div>
                    </header>
					<div class="table-responsive">
						<div class="ga-chart">
							<div id="ga-chart7"></div>
							<div class="_doing" ng-class="{'hidden': firstFetch}">
								<div class="_placeholder" ng-class="{'hidden': firstFetch}">
									<img src="/static/dashboard/home/chart-placeholder.png">
								</div>
							</div>
						</div>
					</div>
                </section>
			</div>
        </div>
        <!-- end: google analytics -->

		<!-- start: google analytics -->
        <div class="row">
			<div class="col-md-6">
				<section class="panel" >
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span style="font-size: 15px;">
									Top 10 Sessions by Mobile Device Info
								</span>
								<div class="_help" title="{{$days30}} — {{$yesterday}}<br><span style='font-size: 11px;'>(</span><span style='font-size: 11.5px;'> Last 30 Days </span><span style='font-size: 11px;'>)</span>" data-toggle="tooltip" data-html="true" data-container="body">
									<i class="fa fa-question-circle" aria-hidden="true"></i>
								</div>
							</div>
						</div>
                    </header>
					<div class="table-responsive">
						<div class="ga-chart">
							<div id="ga-chart5"></div>
							<div class="_doing" ng-class="{'hidden': firstFetch}">
								<div class="_placeholder" ng-class="{'hidden': firstFetch}">
									<img src="/static/dashboard/home/chart-placeholder.png">
								</div>
							</div>
						</div>
					</div>
                </section>
			</div>

			<div class="col-md-6">
				<section class="panel" >
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span style="font-size: 15px;">
									Most Browsers Usage
								</span>
								<div class="_help" title="{{$days30}} — {{$yesterday}}<br><span style='font-size: 11px;'>(</span><span style='font-size: 11.5px;'> Last 30 Days </span><span style='font-size: 11px;'>)</span>" data-toggle="tooltip" data-html="true" data-container="body">
									<i class="fa fa-question-circle" aria-hidden="true"></i>
								</div>
							</div>
						</div>
                    </header>
					<div class="table-responsive">
						<div class="ga-chart">
							<div id="ga-chart8"></div>
							<div class="_doing" ng-class="{'hidden': firstFetch}">
								<div class="_placeholder" ng-class="{'hidden': firstFetch}">
									<img src="/static/dashboard/home/chart-placeholder.png">
								</div>
							</div>
						</div>
					</div>
                </section>
			</div>
        </div>
        <!-- end: google analytics -->

		<!-- start: google analytics -->
        <div class="row">
			<div class="col-xs-12">
				<section class="panel" >
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span style="font-size: 15px;">
									Top 10 Countries Visited
								</span>
								<div class="_help" title="{{$days30}} — {{$yesterday}}<br><span style='font-size: 11px;'>(</span><span style='font-size: 11.5px;'> Last 30 Days </span><span style='font-size: 11px;'>)</span>" data-toggle="tooltip" data-html="true" data-container="body">
									<i class="fa fa-question-circle" aria-hidden="true"></i>
								</div>
							</div>
						</div>
                    </header>
					<div ng-class="{'table-responsive': screen != 'lg'}">
						<div class="ga-chart">
							<div id="ga-chart3"></div>
							<div class="_doing" ng-class="{'hidden': firstFetch}">
								<div class="_placeholder" ng-class="{'hidden': firstFetch}">
									<img src="/static/dashboard/home/chart-placeholder.png">
								</div>
							</div>
						</div>
					</div>
                </section>
			</div>
        </div>
        <!-- end: google analytics -->

		<!-- start: google analytics -->
        <div class="row">
			<div class="col-xs-12">
				<section class="panel" >
                    <header class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span style="font-size: 15px;">
									Top 10 Pages Visited
								</span>
								<div class="_help" title="{{$days30}} — {{$yesterday}}<br><span style='font-size: 11px;'>(</span><span style='font-size: 11.5px;'> Last 30 Days </span><span style='font-size: 11px;'>)</span>" data-toggle="tooltip" data-html="true" data-container="body">
									<i class="fa fa-question-circle" aria-hidden="true"></i>
								</div>
							</div>
						</div>
                    </header>
					<div ng-class="{'table-responsive': screen != 'lg'}">
						<div class="ga-chart">
							<div id="ga-chart9"></div>
							<div class="_doing" ng-class="{'hidden': firstFetch}">
								<div class="_placeholder" ng-class="{'hidden': firstFetch}">
									<img src="/static/dashboard/home/chart-placeholder.png">
								</div>
							</div>
						</div>
					</div>
                </section>
			</div>
        </div>
        <!-- end: google analytics -->

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/node_modules/moment/moment.js"></script>
<script src="/static/bower_components/angular-moment/angular-moment.js"></script>
<script type="text/javascript" src="/static/node_modules/angular-bootstrap-datetimepicker/src/js/datetimepicker.js"></script>
<script type="text/javascript" src="/static/node_modules/angular-bootstrap-datetimepicker/src/js/datetimepicker.templates.js"></script>
<script>
(function(w,d,s,g,js,fs){
	g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
	js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
	js.src='https://apis.google.com/js/platform.js';
	fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
	js.onerror=function(){
		$('#warning').slideDown(300, function(){
			$('#warningCloseBtn').removeClass('hidden');
			$('#warningCloseBtnFake').addClass('hidden');
			$('[data-content=process]').hide();
		});
	};
}(window,document,'script'));
</script>

<script>
app.requires.push('ui.bootstrap.datetimepicker');
app.requires.push('angularMoment');

app.controller('index', function($scope, $http, $window, $timeout){
	$scope.doing = true;
	$scope.audience = { value: 'sessions', text: 'Sessions' };
	$scope.dimension = 'day';
	$scope.datesOptionsTemp = {};

	$scope.audienceConfigs = {
		id: 'ga:148172183',
		startDate: '{{$startDate}}',
		endDate: '{{$endDate}}',
		metrics: 'ga:sessions',
		dimensions: 'ga:date'
	}

	$scope.datesOptionsSelectApply = function(){
		var start	= moment($scope.datesOptionsTemp.start);
		var end		= moment($scope.datesOptionsTemp.end);
		var diff	= end.diff(start, 'days');

		if (diff > 0)
		{
			$scope.datesOptionsClose();

			$scope.audienceConfigs.startDate	= start.format('YYYY-MM-DD');
			$scope.audienceConfigs.endDate		= end.format('YYYY-MM-DD');

			$scope.fetchChart1(true);
		}
		else {
			$scope.datesOptionsError = true;
		}
	}

	$scope.datesOptionsClose = function(){
		$('#datesOptions').hide();

		$scope.datesOptions = false;
		$scope.datesOptionsError = false;

		if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
			$scope.$apply();
		}
	}

	$scope.datesOptionsSelect = function(){
		$scope.datesOptions = !$scope.datesOptions;

		if ($scope.datesOptions){
			$scope.datesOptionsTemp.start	= moment($scope.audienceConfigs.startDate).toDate();
			$scope.datesOptionsTemp.end		= moment($scope.audienceConfigs.endDate).toDate();

			setTimeout(function(){
				$('#datesOptions').show();
			});
		}
		else {
			$('#datesOptions').hide();

			$scope.datesOptionsError = false;

			if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
				$scope.$apply();
			}
		}
	}

	$scope.audienceOptionsSelected = function(audience){
		if (audience == 'sessions'){
			$scope.audience = { value: 'sessions', text: 'Sessions' };
			$scope.audienceConfigs.metrics = 'ga:sessions';
			$scope.fetchChart1(true);
		}
		else if (audience == 'users'){
			$scope.audience = { value: 'users', text: 'Users' };
			$scope.audienceConfigs.metrics = 'ga:users';
			$scope.fetchChart1(true);
		}
		else if (audience == 'bounce_rate'){
			$scope.audience = { value: 'bounce_rate', text: 'Bounce Rate' };
			$scope.audienceConfigs.metrics = 'ga:bounceRate';
			$scope.fetchChart1(true);
		}
		else if (audience == 'pageviews'){
			$scope.audience = { value: 'pageviews', text: 'Pageviews' };
			$scope.audienceConfigs.metrics = 'ga:pageviews';
			$scope.fetchChart1(true);
		}
		else if (audience == 'pages_session'){
			$scope.audience = { value: 'pages_session', text: 'Pages / Session' };
			$scope.audienceConfigs.metrics = 'ga:pageviewsPerSession';
			$scope.fetchChart1(true);
		}
		else if (audience == 'session_duration'){
			$scope.audience = { value: 'session_duration', text: 'Avg. Session Duration' };
			$scope.audienceConfigs.metrics = 'ga:sessionDuration';
			$scope.fetchChart1(true);
		}
		else if (audience == 'new_sessions'){
			$scope.audience = { value: 'new_sessions', text: '% New Sessions' };
			$scope.audienceConfigs.metrics = 'ga:percentNewSessions';
			$scope.fetchChart1(true);
		}

		$scope.audienceOptions = false;
	}

	$scope.audienceOptionsClose = function(){
		$scope.audienceOptions = false;

		if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
			$scope.$apply();
		}
	}

	$scope.audienceOptionsSelect = function(){
		$scope.audienceOptions = !$scope.audienceOptions;
	}

	$scope.initGoogleAnalytics = function(token){
		gapi.analytics.ready(function(){
			gapi.analytics.auth.authorize({
				'serverAuth': {
					'access_token': token
				}
			});

			//chart 1
			$scope.fetchChart1 = function(updated){
				if (updated)
				{
					$scope.doing = true;

					if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
						$scope.$apply();
					}

					$('[data-content=process]').show();
					$('#warningCloseBtn').addClass('hidden');
					$('#warningCloseBtnFake').removeClass('hidden');
					$('#warningBtn').hide();
				}

				$scope.dataChart1 = new gapi.analytics.googleCharts.DataChart({
					query: {
						'ids': $scope.audienceConfigs.id,
						'start-date': $scope.audienceConfigs.startDate,
						'end-date': $scope.audienceConfigs.endDate,
						'metrics': $scope.audienceConfigs.metrics,
						'dimensions': $scope.audienceConfigs.dimensions
					},
					chart: {
						'container': 'ga-chart1',
						'type': 'LINE',
						'options': {
							'width': '100%',
							'legend': {
								'position': 'none'
							},
							'chartArea': {
								'top': '10%',
								'bottom': '15%'
							}
						}
					}
				});

				$scope.dataChart1.on('error', function(){
					$('#error').slideDown(300, function(){
						$('[data-content=process]').hide();
						$('#warningCloseBtn').removeClass('hidden');
						$('#warningCloseBtnFake').addClass('hidden');

						@if(!$warning)
						$('#warningBtn').show();
						@endif
					});
				});

				$scope.dataChart1.once('success', function(){
					$('[data-content=process]').hide();
					$('#warningCloseBtn').removeClass('hidden');
					$('#warningCloseBtnFake').addClass('hidden');

					@if(!$warning)
					$('#warningBtn').show();
					@endif

					$scope.doing = false;
					$scope.firstFetch = true;

					if ($scope.$root.$$phase != '$apply' && $scope.$root.$$phase != '$digest') {
						$scope.$apply();
					}
				});

				$scope.dataChart1.execute();
			}
			$scope.fetchChart1();

			//chart 2
			$scope.fetchChart2 = function(){
				$scope.dataChart2 = new gapi.analytics.googleCharts.DataChart({
					query: {
						'ids': $scope.audienceConfigs.id,
						'metrics': 'ga:sessions',
						'dimensions': 'ga:country',
						'start-date': '30daysAgo',
						'end-date': 'yesterday',
						'max-results': 10,
						'sort': '-ga:sessions'
					},
					chart: {
						'container': 'ga-chart2',
						'type': 'GEO',
						'options': {
							'width': '100%'
						}
					}
				});

				$scope.dataChart2.execute();
			}
			$scope.fetchChart2();

			//chart 3
			$scope.fetchChart3 = function(){
				$scope.dataChart3 = new gapi.analytics.googleCharts.DataChart({
					query: {
						'ids': $scope.audienceConfigs.id,
						'metrics': 'ga:sessions,ga:percentNewSessions,ga:bounceRate,ga:pageviews,ga:pageviewsPerSession',
						'dimensions': 'ga:country',
						'start-date': '30daysAgo',
						'end-date': 'yesterday',
						'max-results': 10,
						'sort': '-ga:sessions'
					},
					chart: {
						'container': 'ga-chart3',
						'type': 'TABLE',
						'options': {
							'width': '100%'
						}
					}
				});

				$scope.dataChart3.execute();
			}
			$scope.fetchChart3();

			//chart 4
			$scope.fetchChart4 = function(){
				$scope.dataChart4 = new gapi.analytics.googleCharts.DataChart({
					query: {
						'ids': $scope.audienceConfigs.id,
						'metrics': 'ga:users',
						'dimensions': 'ga:country',
						'start-date': '30daysAgo',
						'end-date': 'yesterday',
						'max-results': 10,
						'sort': '-ga:users'
					},
					chart: {
						'container': 'ga-chart4',
						'type': 'PIE',
						'options': {
							'width': '100%',
							'pieHole': 3/9,
							'chartArea': {
								'left': '5%',
								'right': '5%'
							}
						}
					}
				});

				$scope.dataChart4.execute();
			}
			$scope.fetchChart4();

			//chart 5
			$scope.fetchChart5 = function(){
				$scope.dataChart5 = new gapi.analytics.googleCharts.DataChart({
					query: {
						'ids': $scope.audienceConfigs.id,
						'metrics': 'ga:sessions',
						'dimensions': 'ga:mobileDeviceInfo',
						'start-date': '30daysAgo',
						'end-date': 'yesterday',
						'max-results': 10,
						'sort': '-ga:sessions'
					},
					chart: {
						'container': 'ga-chart5',
						'type': 'PIE',
						'options': {
							'width': '100%',
							'pieHole': 0,
							'is3D': true,
							'chartArea': {
								'left': '5%',
								'right': '10%'
							},
							'legend': {
								'position': 'right'
							}
						}
					}
				});

				$scope.dataChart5.execute();
			}
			$scope.fetchChart5();

			//chart 6
			$scope.fetchChart6 = function(){
				$scope.dataChart6 = new gapi.analytics.googleCharts.DataChart({
					query: {
						'ids': $scope.audienceConfigs.id,
						'metrics': 'ga:sessions',
						'dimensions': 'ga:deviceCategory',
						'start-date': '30daysAgo',
						'end-date': 'yesterday',
						'max-results': 10,
						'sort': '-ga:sessions'
					},
					chart: {
						'container': 'ga-chart6',
						'type': 'PIE',
						'options': {
							'width': '100%',
							'pieHole': 0,
							'is3D': true,
							'legend': {
								'alignment': 'center',
								'position': 'top'
							},
							'chartArea': {
								'left': '5%',
								'right': '5%'
							}
						}
					}
				});

				$scope.dataChart6.execute();
			}
			$scope.fetchChart6();

			//chart 7
			$scope.fetchChart7 = function(){
				$scope.dataChart7 = new gapi.analytics.googleCharts.DataChart({
					query: {
						'ids': $scope.audienceConfigs.id,
						'metrics': 'ga:sessions,ga:percentNewSessions,ga:users',
						'dimensions': 'ga:language',
						'start-date': '30daysAgo',
						'end-date': 'yesterday',
						'max-results': 5,
						'sort': '-ga:sessions'
					},
					chart: {
						'container': 'ga-chart7',
						'type': 'COLUMN',
						'options': {
							'width': '100%',
							'legend': {
								'alignment': 'center',
								'position': 'top'
							},
							'chartArea': {
								'left': '3%',
								'right': '3%'
							}
						}
					}
				});

				$scope.dataChart7.execute();
			}
			$scope.fetchChart7();

			//chart 8
			$scope.fetchChart8 = function(){
				$scope.dataChart8 = new gapi.analytics.googleCharts.DataChart({
					query: {
						'ids': $scope.audienceConfigs.id,
						'metrics': 'ga:sessions',
						'dimensions': 'ga:browser',
						'start-date': '30daysAgo',
						'end-date': 'yesterday',
						'max-results': 10,
						'sort': '-ga:sessions'
					},
					chart: {
						'container': 'ga-chart8',
						'type': 'PIE',
						'options': {
							'width': '100%',
							'pieHole': 0,
							'is3D': true,
							'legend': {
								'position': 'right'
							},
							'chartArea': {
								'left': '5%',
								'right': '8%'
							}
						}
					}
				});

				$scope.dataChart8.execute();
			}
			$scope.fetchChart8();

			//chart 9
			$scope.fetchChart9 = function(){
				$scope.dataChart9 = new gapi.analytics.googleCharts.DataChart({
					query: {
						'ids': $scope.audienceConfigs.id,
						'metrics': 'ga:sessions,ga:percentNewSessions,ga:users,ga:pageviews,ga:pageviewsPerSession',
						'dimensions': 'ga:pagePath',
						'start-date': '30daysAgo',
						'end-date': 'yesterday',
						'max-results': 10,
						'sort': '-ga:sessions'
					},
					chart: {
						'container': 'ga-chart9',
						'type': 'TABLE',
						'options': {
							'width': '100%'
						}
					}
				});

				$scope.dataChart9.execute();
			}
			$scope.fetchChart9();
		});
	}

	$scope.getToken = function(){
		$http.get('/ajax/dashboard/home/google-analytics')
		.success(function(data){
			if (data.status == 'ok'){
				$scope.initGoogleAnalytics(data.payload.token);
			}
			else {
				$('#error').slideDown(300, function(){
					$('[data-content=process]').hide();
					$('#warningCloseBtn').removeClass('hidden');
					$('#warningCloseBtnFake').addClass('hidden');

					@if(!$warning)
					$('#warningBtn').show();
					@endif
				});
			}
		})
		.error(function(){
			$('#error').slideDown(300, function(){
				$('[data-content=process]').hide();
				$('#warningCloseBtn').removeClass('hidden');
				$('#warningCloseBtnFake').addClass('hidden');

				@if(!$warning)
				$('#warningBtn').show();
				@endif
			});
		});
	}

	$scope.getToken();

	$scope.hideWarning = function($event){
		$('[data-toggle="tooltip"]').tooltip('hide');
		$('#warning').slideUp(300, function(){
			$('#warningBtn').show();
		});

		$http.post('/ajax/dashboard/home/warning', {
			set: 'hide'
		})
		.success(function(data){
			if (data.status != 'ok'){
				alert(data.message);
				$window.location.reload();
			}
		})
		.error(function(){
			alert('{{trans('error.general')}}');
			$window.location.reload();
		});

		$event.preventDefault();
	}

	$scope.showWarning = function($event){
		$('[data-toggle="tooltip"]').tooltip('hide');
		$('#warning').slideDown(300, function(){
			$('#warningBtn').hide();
		});

		$http.post('/ajax/dashboard/home/warning', {
			set: 'show'
		})
		.success(function(data){
			if (data.status != 'ok'){
				alert(data.message);
				$window.location.reload();
			}
		})
		.error(function(){
			alert('{{trans('error.general')}}');
			$window.location.reload();
		});

		$event.preventDefault();
	}

	//statistic
    $scope.stat = { enquiry: 0, book: 0, jewels: 0, tours: 0, news: 0, subscribers: 0 };

	$scope.getStat = function(){
		$http.get('/ajax/dashboard/home/stat')
		.success(function(data){
			if (data.status == 'ok'){
				$scope.stat = data.payload;

				$http.get('/ajax/dashboard/home/subscribers')
				.success(function(data){
					if (data.status == 'ok'){
						$scope.stat.subscribers = data.payload.subscribers;
					}
				});
			}
		});
	}

	$scope.clearData = function(){
		$http.post('/ajax/dashboard/home/clear');
	}

	$scope.getStat();
	$scope.clearData();
});

app.directive('ngCounter', ['$timeout', function($timeout) {
	return {
		restrict: 'A',
		template: '<span>[[count | number]]</span>',
		scope: {
            count: '@',
			stat: '@',
        },
		controller: function($scope) {
			$scope.stat = $scope.count = 0;
		},
		link: function(scope, element, attrs) {
			scope.update = function(){
				$timeout(function(){
					if (scope.count < scope.stat){
						scope.count++;
						scope.update();
					}
				}, 20);
			}

			attrs.$observe('stat', function(data) {
				scope.count = data;
			}, true);

			/*
			attrs.$observe('stat', function(data) {
				var n = parseInt(data);
				if (n > 0){
					scope.stat = n;
					scope.update();
				}
			}, true);
			*/
		}
	}
}]);

app.directive('clickOutside', function ($document) {
    return {
       restrict: 'A',
       scope: {
           clickOutside: '&'
       },
       link: function (scope, el, attr) {

           $document.on('click', function (e) {
               if (el !== e.target && !el[0].contains(e.target)) {
                    scope.$apply(function () {
                        scope.$eval(scope.clickOutside);
                    });
                }
           });
       }
    }

});

$(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection
