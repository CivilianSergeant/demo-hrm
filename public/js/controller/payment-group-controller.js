angular.module('group',[]).
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
controller('groupCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.showFrm = 0;
    $scope.job_type = ['Full Time','Part Time','Intern','Contactual'];
    $scope.form = {title:'',job_type:'',template:'',head:''};
    
    var loadGroups = function()
    {
        var response = webservice.get(BASE + 'groups.json');
        response.success(function(res){
           $scope.groups = res; 
        });
    }
    
    $scope.openFrm = function()
    {
        $scope.showFrm = 1;
        $scope.form = {id:'',title:'',job_type:'',template:'',head:''};
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
        $scope.form = {title:'',job_type:'',template:'',head:''};
    }
    
    $scope.getHeadByJobType = function()
    {
        var response = webservice.get(BASE+'head/'+$scope.form.job_type);
        response.success(function(res){
            $scope.heads = res;
        });
    }
    
    $scope.saveGroup = function()
    {
       if($scope.form.id)
            var response = webservice.post(BASE+'group/update',$scope.form);
       else
            var response = webservice.post(BASE+'group/save-group',$scope.form);
            
        response.success(function(res){
           loadGroups();
           $scope.showFrm = 0;
        });
    }
    
    $scope.editGroup = function(group)
    {
        $scope.form.template={};
        $scope.form.id = group.id;
        $scope.form.title  = group.title;
        $scope.form.job_type = group.job_type;
        
        $scope.heads =(angular.fromJson(group.template));
        for(var h in $scope.heads)
        {
            $scope.form.template[h] =($scope.heads[h].amount);
            
        }
        
        var response = webservice.get(BASE+'head/'+$scope.form.job_type);
        response.success(function(res){
            $scope.heads = res;
            $scope.showFrm = 1;
        });
        
        
    }
    
    $scope.deleteHead = function(i)
    {
        
        if($scope.heads[i] != undefined)
        {
            
            var h = $scope.heads[i];
            $scope.heads.splice(i,1);
            delete $scope.form.head[h.id];
            delete $scope.form.template[h.id];
            
           
        }
    }
    
    $scope.deleteGroup = function(group)
    {
        bootbox.confirm('Are you sure to delete this item? ',function(r){
           if(r){
                var response = webservice.post(BASE+'group/remove',group);
                response.success(function(res){
                    loadGroups();
                });
           }
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadGroups();
    
}]);