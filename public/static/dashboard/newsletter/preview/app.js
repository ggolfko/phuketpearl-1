var preview = angular.module('preview', ['ngSanitize', 'nl2br'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

preview.controller('Preview', function($scope, $window, $timeout){
    $scope.parent = $window.parent.previewObject;
});
