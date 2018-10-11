angular.module('evaluation',[])
.service('webservice',function($http){
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
})
.controller('eval-req-ctrl',['$scope','webservice',function($scope,webservice){
    $scope.lists = [];
    $scope.showFrm = 0;
    $scope.questions = [];
   
    $scope.form = {employee_id:'',feedback_by:'',department_id:'',remark:[]};
    var loadEvalRequests = function()
    {
        var response = webservice.get(BASE+'get-evaluation-requests');
        response.success(function(res){
            $scope.lists = res;
        })
    }
    
    $scope.openReview = function(l)
    {
        var response = webservice.get(BASE+'get-questions/'+l.template.id);
        response.success(function(res){
            $scope.questions = res;
            $scope.evalreq = l;
            $scope.showFrm = 1;
            $scope.form.department_id = l.department_id;
            $scope.form.employee_id = l.employee_id;
            $scope.form.feedback_by = l.feedback_by.id;
        });
        
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
    }
    
    $scope.saveReview = function()
    {
        
        var response = webservice.post(BASE+'performance/save-review',$scope.form);
        response.success(function(res){
            
        });
    }
    
    loadEvalRequests();
}]);