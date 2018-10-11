angular.module('head',[]).
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
controller('headCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.heads = [];
    $scope.form = {head_name:'',parent_head:'',head_type:'',job_type:''};
    $scope.showFrm = 0;
    $scope.job_type = ['Full Time','Part Time','Intern','Contactual'];
    $scope.head_type = ['Income','Expense'];
    
    $scope.openFrm = function()
    {
        $scope.showFrm = 1;
        $scope.form = {head_name:'',parent_head:'',head_type:'',job_type:''};
        var response = webservice.get(BASE+'parent-heads.json');
        response.success(function(res){
            $scope.parent_head = res; 
        });
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
        $scope.form = {head_name:'',parent_head:'',head_type:'',job_type:''};
    }
    
    var loadHeads = function()
    {
        var response = webservice.get(BASE + 'heads.json');
        response.success(function(res){
           $scope.heads = res; 
        });
    }
    
    $scope.saveHead = function()
    {
        var response = webservice.post(BASE+'head/save-head',$scope.form);
        response.success(function(res){
            loadHeads();
            $scope.closeFrm();
        });
    }
    
    
    
    $scope.editHead = function(head)
    {
        console.log(head)
        $scope.form.head_name   = head.head_name;
        $scope.form.parent_head = (head.parent_head != null) ? head.parent_head.id : '';
        $scope.form.job_type    = head.job_type;
        $scope.form.head_type   = head.head_type;
        var response = webservice.get(BASE+'parent-heads.json');
        response.success(function(res){
            $scope.parent_head = res; 
        });
        
        $scope.showFrm = 1;
    }
    
    $scope.deleteHead = function(head)
    {
        bootbox.confirm('Are you sure to delete this item? ',function(r){
           if(r){
                var response = webservice.post(BASE+'head/remove',head);
                response.success(function(res){
                    loadHeads();
                }); 
           } 
        });
        
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadHeads();
    
    
    
    
    /***** Sort ******/
    
    $scope.sortorder = "head_name";
    
    $scope.toggleSort = function(item)
    {
        switch(item)
        {
            case 'head_name':
                if($scope.sortorder == "head_name")
                    $scope.sortorder = "-head_name";
                else
                    $scope.sortorder = "head_name";
                break;
                
            case 'job_type':
                if($scope.sortorder == "job_type")
                    $scope.sortorder = "-job_type";
                else
                    $scope.sortorder = "job_type";
                break;
        }
        
    }
    
}]);