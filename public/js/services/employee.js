angular.module('employee',[]).service('employee',function($http){

    this.getByDepartment = function(id)
    {
        return $http.get(BASE+'employee/department/'+id);
    }
   
});
