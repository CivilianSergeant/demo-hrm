angular.module('orgApp',[]).
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
controller('orgCtrl',['$scope','webservice',function($scope,webservice){
    $scope.org = {
        title:'',phone:'',fax:'',email:'',address:'',country:'',city:'',state:'',postcode:''
    };
    
    var loadOrgInfo = function()
    {
        var response = webservice.get(BASE+'api/org.json');
        response.success(function(res){
            console.log(res);
            if(res.title!=undefined)
                $scope.org = res;
            
        });
        
    }
    
   
    $scope.updateOrg = function(){
        $scope.successes = [];
        $scope.errors = [];
        var response = webservice.post(BASE+'org/create',$scope.org);
        response.success(function(res){
            
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