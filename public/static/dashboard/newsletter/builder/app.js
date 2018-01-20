var frame = angular.module('frame', ['ngSanitize', 'nl2br'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

frame.controller('Frame', function($scope, $window, $timeout, $sce){
    $scope.parent = $window.parent.angular.element($window.frameElement).scope();

    $scope.toggleBlock = function($event, position){
        $scope.parent.blocks[position] = !$scope.parent.blocks[position];
        $timeout(function(){
            $scope.parent.$apply();
        });
        $event.preventDefault();
    };
});

frame.controller('Block', function($scope, $window){
    $scope.mouseenter = function(){
        $scope.focus = true;
    };
    $scope.mouseleave = function(){
        $scope.focus = false;
    };
});

frame.controller('Object', function($scope){
    $scope.mouseenter = function(){
        $scope.objectFocus = true;
    };
    $scope.mouseleave = function(){
        $scope.objectFocus = false;
    };
    $scope.edit = function($event, type, section, index, text_type){
        if (type == 'image')
        {
            $scope.parent.editImage(section, index);
        }
        else if (type == 'button')
        {
            $scope.parent.editButton(section, index);
        }
        else if (type == 'text')
        {
            $scope.parent.editText(section, index, text_type);
        }
        $event.preventDefault();
    };
});
