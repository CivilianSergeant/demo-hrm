angular.module('dashboard',[]).

controller('dashboardCtrl',['$scope',function($scope){
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
}]);