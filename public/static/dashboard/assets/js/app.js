'use strict';

var app = angular.module('app', ['ngAnimate', 'ngSanitize'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.config(['$sceProvider', function($sceProvider) {
    $sceProvider.enabled(true);
}]);

$(function(){
    $('input[data-plugin="icheck"]').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    });

    $('#main-content').removeClass('hidden');
});
