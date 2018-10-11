angular.module('myattendance',['calander']).
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
controller('myattendanceCtrl',['$scope','webservice',function($scope,webservice){
    $scope.attendance = [];
    
    var loadMyAttendance = function()
    {

        var response = webservice.get(BASE+'get-my-attendance');
        response.success(function(res){
            $scope.attendance= res;
        });

    }
    
     loadMyAttendance();
     
}]);