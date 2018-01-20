'use strict';

var app = angular.module('app', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

(function(){
	app.controller('root', function($scope, $http, $window, $timeout){
        $scope.navmenuTouch = false;
        $scope.isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return ($scope.isMobile.Android() || $scope.isMobile.BlackBerry() || $scope.isMobile.iOS() || $scope.isMobile.Opera() || $scope.isMobile.Windows());
            }
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
            $scope.navmenuTouch = ( ($scope.screen == 'xs') || (($scope.isMobile.any()) && ($scope.screen == 'sm' || $scope.screen == 'md' || $scope.screen == 'lg')) )? true: false;
        };
        $(window).bind('resize', function(e){
            $scope.initScreen();
            $scope.$apply();
        });
        $scope.initScreen();

		$scope.browserName = (platform && platform.name)? platform.name.toLowerCase(): '';

        $(function(){
            $("#page-container").addClass('in');
			$('#header-navbar').removeAttr("style");

            $(window).on('scroll load', function() {
                if ($('#header').attr('data-state-change') != 'disabled') {
                    var totalScroll = $(window).scrollTop();
                    var headerHeight = $('#header').height();
                    if (totalScroll >= headerHeight) {
                        $('#header').addClass('navbar-small');
                    }
                    else {
                        $('#header').removeClass('navbar-small');
                    }
                }
            });
        });

		$scope.lang = function($event, code){
			$http.post('/ajax/lang', {
				code: code
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
                alert($window.TRANS.ERROR.GENERAL);
                $window.location.reload();
			});
			$('.dropdown.open .dropdown-toggle').dropdown('toggle');
			$event.preventDefault();
		};
	});

    app.controller('subscribe', function($scope, $http, $window, $timeout){
        $scope.error = false;
        $scope.requesting = false;
        $scope.success = false;

        $scope.request = function($event){
            if (!$scope.requesting && !$scope.success)
            {
                $scope.error = false;
                if (!$scope.email || $scope.email.trim() == '' || !/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($scope.email)){
                    $scope.error = true;
                }
                else {
                    $scope.requesting = true;
                    var email = $scope.email.trim();
                    $scope.email = $('input[type=text]', '#ui-subscribe').attr('data-sending');

                    $http.post('/ajax/subscribe/add', {
                        email: email
                    })
                    .success(function(resp){
                        if (resp.status == 'ok'){
                            $scope.requesting = false;
                            $scope.success = true;
                            $scope.email = $('input[type=text]', '#ui-subscribe').attr('data-success');

                            $.toast({
                                heading: $('input[type=text]', '#ui-subscribe').attr('data-success'),
                                text: '<span>'+$('input[type=text]', '#ui-subscribe').attr('data-success-message')+'</span>',
                                loader: true,
                                loaderBg: '#a07936',
                                position: 'bottom-left',
                                hideAfter: 6000,
                                afterHidden: function () {
                                    $scope.success = false;
                                    $scope.email = null;
                                    $scope.$apply();
                                }
                            });
                        }
                        else {
                            alert(resp.message);
                            $scope.email = email;
                            $scope.requesting = false;
                        }
                    })
                    .error(function(){
                        alert($window.TRANS.ERROR.GENERAL);
                        $window.location.reload();
                    });
                }
            }

            $event.preventDefault();
        };
    });
})();
