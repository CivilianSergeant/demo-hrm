angular.module('department',[]).
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
controller('departmentCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.department = {id:'',name:'',parent_department:[]};
    
    $scope.cancelUpdate = function(){
        $scope.department = {id:'',name:'',parent_department:[]};
        $scope.parent_department = '';
        $scope.selectedItemId = '';
    }
    $scope.deleteDepartment = function()
    {
        $scope.successes = [];
        $scope.errors = [];
        
        if($scope.selectedItemId)
        {
            var deleteObj = {id:$scope.selectedItemId};
            var response = webservice.post(BASE+'department/remove',deleteObj);
            response.success(function(res){
                loadInfo();
                $scope.successes = res.message;
            }).error(function(res){
                
                $scope.errors = res.name;
            });
        }
    }
    
    var loadInfo = function()
    {
        var response = webservice.get(BASE+'api/departments.json');
        response.success(function(res){
            
            $scope.departments = res;
           
        });
        
        $scope.department = {name:'',parent_department:[]};
        $scope.parent_department = '';
        $scope.selectedItemId = '';
    }
    
    $scope.saveDepartment = function()
    {
        $scope.successes = [];
        $scope.errors = [];
        if($scope.parent_department)
        {
            $scope.department.parent_department.splice(0,1,$scope.parent_department);
            
            var response = webservice.post(BASE+'department/update',$scope.department);
        }else{
            var response = webservice.post(BASE+'department/create',$scope.department);
        }
        
        
        response.success(function(res){
            loadInfo();
            $scope.successes = res.message;
        }).error(function(res){
            
            $scope.errors = res.name;
        });
        
    }
    
    $scope.selectDepartment = function(department)
    {
       $scope.department.name = department.name;
       $scope.setParent(department);
       $scope.parent_department = department.parent_department;
       $scope.department.id = department.id;
       $scope.selectedItemId = department.id
    }
    
    $scope.setParent = function(department)
    { 
        var index = $scope.department.parent_department.indexOf(department.id);
        
        if(index == -1)
            $scope.department.parent_department.push(department.id);
        else
            $scope.department.parent_department.splice(index,1);
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadInfo();
    
}]).controller('departmentTrashCtrl',['$scope','webservice',function($scope,webservice){
    $scope.lists = [];
    
    var loadTrashItems = function()
    {
        var response = webservice.get(BASE+'department-trash.json');
        response.success(function(res){
           $scope.lists = res; 
        });
    }
    
    $scope.retrive = function(d)
    {
        bootbox.confirm('Are you sure to undo this item?',function(r){
            if(r)
            {
                var response = webservice.post(BASE+'department/undo',{id:d.id});
                response.success(function(res){
                    loadTrashItems();
                });
            }
        });
        
    }
    
    $scope.deletePermanently = function(d)
    {
        bootbox.confirm('Are you sure to delete item permanently? ',function(r){
            if(r)
            {
                var response = webservice.post(BASE+'department/delete-permanent',{id:d.id});
                response.success(function(res){
                    loadTrashItems();
                });
            }
        });
        
    }
    
    loadTrashItems();
}]);