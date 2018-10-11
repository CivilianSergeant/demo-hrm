angular.module('payroll',['department','employee']).service('webservice',function($http){
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
}).controller('payrollCtrl',['$scope','webservice','department','employee',function($scope,webservice,department,employee){
    
   
    department.getAll().success(function(res){
        $scope.departments = res;
    });
        
    $scope.getEmployee = function(id)
    {
        employee.getByDepartment(id).success(function(res){
            $scope.employees = res;
        });
    }
    
   
}]);