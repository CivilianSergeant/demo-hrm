var RoleApp = angular.module('RoleApp',[]).

controller('RoleController',['$scope','$http',function($scope,$http){
    
    $http.get('api/roles.json').success(function(data){
        $scope.roles = data;
    })
    
    $scope.showForm = 0;
    
    $scope.showCreateRoleFrm = function()
    {
        $scope.showForm = 1;
        return false;
    }
    
    $scope.form = {name:'',description:''};
    $scope.saveRole = function()
    {
        
        $scope.errors = [];
        $scope.successes = [];
        $http({
            url: BASE + 'role/create',
            method: 'POST',
            data: $scope.form
        }).success(function(res){
            console.log(res);
            $scope.successes = res.message;
            resetFrm();
            $http.get('/api/roles.json').success(function(data){
                $scope.roles = data;
            });
        }).error(function(res){
            console.log(res);
            $scope.errors = res.name;
        });
        return false;
    }
    
    $scope.cancelFrm = function()
    {
        resetFrm()
    }
    
    var resetFrm = function(){
        $scope.form = {name:'',description:''};
        $scope.showForm = 0;
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
}]);