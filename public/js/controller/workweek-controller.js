angular.module('workweek',[]).
service('webservice',function($http){
    
   return{
       get:function(url,data){
           return $http({
               method:"GET",
               url:url,
               data:data
           });
       },
       post:function(url,data)
       {
           return $http({
               method:"POST",
               url:url,
               data:data
           });
       }
   }; 
   
}).
controller('workweekCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.workweeks = [];
    $scope.form = {'Sunday':'','Monday':'','Tuesday':'','Wednessday':'','Thursday':'','Friday':'','Saturday':''};
    $scope.days = ['Sunday','Monday','Tuesday','Wednessday','Thursday','Friday','Saturday'];
    $scope.statuses = ['Working Day','Not Working Day'];
    var loadOrgInfo = function()
    {
        var response = webservice.get(BASE+'api/workweek.json');
        response.success(function(res){
            
            $scope.workweeks = res;
            
        });
        
       
        
        
    }
    
    $scope.saveWorkWeek = function()
    {
        $scope.successes = [];
        $scope.errors = [];
        var response = webservice.post(BASE+'workweek/create',$scope.form);
        response.success(function(res){
            loadOrgInfo();
            $scope.successes = res.message;
            
        }).error(function(res){
            
            $scope.errors = res.name;
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadOrgInfo();
    
}]);