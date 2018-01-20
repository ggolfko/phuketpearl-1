<!DOCTYPE html>
<html lang="{{$config['lang']['code']}}" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="_token" content="{{csrf_token()}}">
	<meta name="robots" content="noindex, nofollow">
	<title>{{$config['name']}}</title>
	@section('head_dependency')
	@show
	<link href="/static/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/static/bower_components/components-font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="/static/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/static/bower_components/iCheck/skins/flat/red.css" rel="stylesheet">
	<link href="/static/dashboard/assets/css/bootstrap-reset.css" rel="stylesheet">
	<link href="/static/dashboard/assets/css/style.css" rel="stylesheet">
	<link href="/static/dashboard/assets/css/style-responsive.css" rel="stylesheet">
	<link href="/static/dashboard/assets/css/ui.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="/static/dashboard/assets/js/html5shiv.js"></script>
	<script src="/static/dashboard/assets/js/respond.min.js"></script>
	<![endif]-->
	<script src="/static/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/static/bower_components/angular/angular.min.js"></script>
	<script src="/static/bower_components/angular-animate/angular-animate.min.js"></script>
	<script src="/static/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
	<script src="/static/bower_components/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
    <script src="/static/bower_components/iCheck/icheck.min.js"></script>
    <script src="/static/dashboard/assets/js/jquery.dcjqaccordion.2.7.min.js"></script>
    <script src="/static/dashboard/assets/js/app.js"></script>
	<script src="/static/dashboard/assets/js/core.js"></script>
	<script>
		app.controller('AppController', function($scope, $http, $window){
			$scope.lang = function(e,code){
                $http.post('/ajax/lang', {
                    code:code
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
    					$window.location.reload();
    				}
    				else{
    					alert(resp.message);
    				}
                })
                .error(function(){
                    alert('{{trans("error.general")}}');
                });

                e.preventDefault();
            };

            $scope.initScreen = function(){
                var screen = false;
                if ( $('#screen-lg').is(":visible") ){
                    screen = 'lg';
                }
                else if ( $('#screen-md').is(":visible") ){
                    screen = 'md';
                }
                else if ( $('#screen-sm').is(":visible") ){
                    screen = 'sm';
                }
                else if ( $('#screen-xs').is(":visible") ){
                    screen = 'xs';
                }
                $scope.screen = screen;
            };
            $(window).bind('resize', function(e){
                $scope.initScreen();
                $scope.$apply();
            });
            $scope.initScreen();
		});
	</script>
	@section('head')
	@show
</head>
<body ng-controller="AppController">
<section id="container" >
    <!--header start-->
    <header class="header white-bg">
		<div class="sidebar-toggle-box hidden-lg hidden-md hidden-sm">
            <div class="fa fa-bars"></div>
        </div>
        <a href="/dashboard" class="logo"><img src="/static/images/logo-200-100.png"></a>
        <div class="top-nav ">
            <ul class="nav pull-right top-menu">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="margin-top:4px">
                        <span class="username hidden-xs" style="margin-left:4px;">{{$user->firstname}} {{$user->lastname}}</span>
						 <span class="username hidden-sm hidden-md hidden-lg" style="margin-left:2px;"><i class="fa fa-user"></i></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
						<div class="log-arrow-up hidden-xs"></div>
						<li><a href="/" target="_blank"><i class="fa fa-desktop"></i>{{trans('_.Frontend')}}</a></li>
						<li><a href="/dashboard/auth/account"><i class=" fa fa-user"></i>{{trans('auth.Account')}}</a></li>
						<li><a href="/dashboard/auth/logout"><i class="fa fa-key"></i> {{trans('auth.Log Out')}}</a></li>
						<li class="last" style="font-size:12px;">
							{{trans("_.{$user->getRole()}")}}
							<span style="font-size:12px;">{{$user->email}}</span>
						</li>
                    </ul>
                </li>
				<li class="dropdown language">
                    <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img src="/static/dashboard/assets/img/flags/{{$config['lang']['code']}}.png" alt="{{$config['lang']['title']}}">
                        <span class="username">{{$config['lang']['code']}}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu" style="margin-top:11px;">
						<div class="log-arrow-up"></div>
                        @foreach($config['langs'] as $lang)
                        <li>
							<a href="#" ng-click="lang($event,'{{$lang['code']}}')">
								<img src="/static/dashboard/assets/img/flags/{{$lang['code']}}.png" alt="{{$lang['title']}}"> {{$lang['title']}}
							</a>
						 </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id="sidebar"  class="nav-collapse">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a href="/dashboard" @if(isset($menu) && $menu=='dashboard') class="active" @endif>
                        <span class="icon"><i class="fa fa-dashboard"></i></span>
                        <span>{{trans('_.Dashboard')}}</span>
                    </a>
                </li>
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_product == '1'))
                <li>
                    <a href="/dashboard/products" @if(isset($menu) && $menu=='products') class="active" @endif>
                        <span class="icon"><i class="fa fa-diamond"></i></span>
                        <span>{{trans('_.Pearl Jewels')}}</span>
                    </a>
                </li>
                @endif
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_enquiry == '1'))
                <li>
                    <a href="/dashboard/enquiry" @if(isset($menu) && $menu=='enquiry') class="active" @endif>
                        <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                        <span>{{trans('_.Jewel Enquiry')}}</span>
                    </a>
                </li>
                @endif
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_tour == '1'))
                <li>
                    <a href="/dashboard/tours" @if(isset($menu) && $menu=='tour') class="active" @endif>
                        <span class="icon"><i class="fa fa-bus"></i></span>
                        <span>{{trans('_.Package Tours')}}</span>
                    </a>
                </li>
                @endif
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_book == '1'))
                <li>
                    <a href="/dashboard/booking" @if(isset($menu) && $menu=='book') class="active" @endif>
                        <span class="icon"><i class="fa fa-book"></i></span>
                        <span>{{trans('_.Tour Booking')}}</span>
                    </a>
                </li>
                @endif
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_newsletter == '1'))
                <li>
                    <a href="/dashboard/newsletter" @if(isset($menu) && $menu=='newsletter') class="active" @endif>
                        <span class="icon"><i class="fa fa-envelope-o"></i></span>
                        <span>{{trans('_.Newsletter')}}</span>
                    </a>
                </li>
                @endif
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_news == '1'))
                <li>
                    <a href="/dashboard/news" @if(isset($menu) && $menu=='news') class="active" @endif>
                        <span class="icon"><i class="fa fa-newspaper-o"></i></span>
                        <span>{{trans('_.News')}}</span>
                    </a>
                </li>
                @endif
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_document == '1'))
                <li class="sub-menu @if(isset($menu) && $menu=='doc') active @endif">
                    <a href="javascript:;" class="link @if(isset($menu) && $menu=='doc') active @endif">
                        <span class="icon"><i class="fa fa-folder-open"></i></span>
                        <span>{{trans('_.Documents')}}</span>
                    </a>
                    <ul class="sub">
                        <li class="sub-menu @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'ourstory') active @endif">
                            <a href="javascript:;" class="link @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'ourstory') active @endif">{{trans('story.Our Story')}}</a>
                            <ul class="sub">
                                <li class="itemmenu @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'ourstory' && isset($itemmenu) && $itemmenu == 'article') active @endif">
                                    <a href="/dashboard/docs/ourstory/article">{{trans('story.Article')}}</a>
                                </li>
                                <li class="itemmenu @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'ourstory' && isset($itemmenu) && $itemmenu == 'images') active @endif">
                                    <a href="/dashboard/docs/ourstory/images">{{trans('_.Images')}}</a>
                                </li>
                            </ul>
                        </li>
                        <li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'timeline') class="active" @endif><a href="/dashboard/docs/timeline">{{trans('_.Timeline')}}</a></li>
                        <li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'award') class="active" @endif><a href="/dashboard/docs/award">{{trans('_.Awards')}}</a></li>
                        <li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'certificate') class="active" @endif><a href="/dashboard/docs/certificate">{{trans('_.Certificates')}}</a></li>
                        <li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'crown') class="active" @endif><a href="/dashboard/docs/crown">{{trans('_.Pearl Crowns')}}</a></li>
                        <li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'pearlcare') class="active" @endif><a href="/dashboard/docs/pearlcare">{{trans('_.Pearl Care')}}</a></li>
                        <li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'pearlquality') class="active" @endif><a href="/dashboard/docs/pearlquality">{{trans('_.Pearl Quality')}}</a></li>
                        <li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'pearltype') class="active" @endif><a href="/dashboard/docs/pearltype">{{trans('pearl.Type Of Pearl')}}</a></li>
                        <li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'pearlfarm') class="active" @endif><a href="/dashboard/docs/pearlfarm">{{trans('_.Phuket Pearl’s pearl farm')}}</a></li>
                        <li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'pearlfarming') class="active" @endif><a href="/dashboard/docs/pearlfarming">{{trans('pearl.Pearl Farming')}}</a></li>
						<li @if(isset($menu) && $menu=='doc' && isset($submenu) && $submenu == 'media-special-guests') class="active" @endif><a href="/dashboard/docs/media-special-guests">{{trans('_.Media & Special Guests')}}</a></li>
                    </ul>
                </li>
                @endif
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_gallery == '1'))
                <li>
                    <a href="/dashboard/gallery" @if(isset($menu) && $menu=='gallery') class="active" @endif>
                        <span class="icon"><i class="fa fa-picture-o"></i></span>
                        <span>{{trans('_.Gallery')}}</span>
                    </a>
                </li>
                @endif
                @if(false && $user->role == 'a' || ($user->role == 'e' && $user->permission_video == '1'))
                <li>
                    <a href="/dashboard/videos" @if(isset($menu) && $menu=='video') class="active" @endif>
                        <span class="icon"><i class="fa fa-video-camera"></i></span>
                        <span>{{trans('_.Videos')}}</span>
                    </a>
                </li>
                @endif
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_payment == '1'))
                <li>
                    <a href="/dashboard/payments" @if(isset($menu) && $menu=='payment') class="active" @endif>
                        <span class="icon"><i class="fa fa-credit-card"></i></span>
                        <span>{{trans('payment.Payments')}}</span>
                    </a>
                </li>
                @endif
				@if($user->role == 'a' || ($user->role == 'e' && $user->permission_employee == '1'))
                <li>
                    <a href="/dashboard/employees" @if(isset($menu) && $menu=='employee') class="active" @endif>
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <span>{{trans('_.Employees')}}</span>
                    </a>
                </li>
                @endif
                @if($user->role == 'a' || ($user->role == 'e' && $user->permission_setting == '1'))
                <li>
                    <a href="/dashboard/slides" @if(isset($menu) && $menu=='slide') class="active" @endif>
                        <span class="icon"><i class="fa fa-picture-o"></i></span>
                        <span>{{trans('_.Home Slides')}}</span>
                    </a>
                </li>
                @endif
				@if($user->role == 'a' || ($user->role == 'e' && $user->permission_setting == '1'))
                <li>
                    <a href="/dashboard/settings" @if(isset($menu) && $menu=='setting') class="active" @endif>
                        <span class="icon"><i class="fa fa-gear"></i></span>
                        <span>{{trans('_.Settings')}}</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </aside>
    <!--sidebar end-->

	@section('content')
	@show

</section>
<span class="visible-lg" id="screen-lg"></span>
<span class="visible-md" id="screen-md"></span>
<span class="visible-sm" id="screen-sm"></span>
<span class="visible-xs" id="screen-xs"></span>
@section('foot')
@show
<script>
$(function(){
	$("#sidebar").niceScroll({
		styler: "fb",
		cursorcolor:"#e8403f",
		cursorwidth: '3',
		cursorborderradius: '10px',
		background: '#404040',
		spacebarenabled: false,
		cursorborder: ''
	});
});
</script>
</body>
</html>
