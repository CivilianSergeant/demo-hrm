angular.module('permission',[]).
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
directive('scrollOnClick',function(){
    return {
        restrict: 'A',
        link: function(scope, $elm) {
          
          $elm.on('click', function() {
            $("html,body").animate({ scrollTop: "0px" });
          });
        }
     }
}).
controller('permissionCtrl',['$scope','webservice',function($scope,webservice){
    $scope.role_id = role_id;
    $scope.permissions = [];
    var permissions = [];
    var permission_role = [];
    $scope.form = [];
    $scope.permission_role = [];
    
    
    
    var loadInfo = function()
    {
        var response = webservice.get(BASE+'api/permissions.json');
        response.success(function(res){
            $scope.permissions = res;
            permissions = res;
        });
        
        var response = webservice.get(BASE+'api/'+$scope.role_id+'/permission_role.json');
        response.success(function(res){
            
            permission_role = res;    
            for(var i in res)
            {
                
                var paths = res[i].path;   
                $scope.permission_role[paths] = res[i];
                
                
                var permissionObj = {'path':'','name':'','display_name':''};
                
                permissionObj.name = res[i].name;
                permissionObj.display_name = res[i].display_name;
                permissionObj.path = paths;
                permissionObj.checked=true;
                ///$scope.form.push(permissionObj);
            }
            
            
            
        });
    }
    
    
    
    $scope.setPermission = function(index)
    {
            var obj;
            if(permission_role[index]!=undefined)
            {
               obj =  permission_role[index];
            }else{
               obj =  permissions[index];
            }
            
             
            var i = $scope.form.indexOf(obj);
            
            if(i == -1)
            {
                
                $scope.form.push(obj);
            }
            else{
                
                $scope.form.splice(i,1);
            }
                   
            
    }
    
    $scope.savePermission = function()
    {
        $scope.successes = [];
        $scope.errors = [];
        
        var response = webservice.post(BASE+'permission/create',{role_id:$scope.role_id,permissions:$scope.form});
    
        response.success(function(res){
            if(res.message != undefined)
                $scope.successes = res.message;
            if(res.error != undefined)
                $scope.errors = res.error;
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    
    loadInfo();
}]);