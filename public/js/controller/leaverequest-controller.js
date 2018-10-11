angular.module('lrequest',[])
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
    
}).filter('plural',function(){
    return function(input,noun){
      return (input >= 2) ? input + ' '+noun+'s' : input + ' '+noun;
    };
}).controller('lrequestCtrl',['$scope','webservice',function($scope,webservice){
    $scope.leave_requests = [];
    $scope.form = {id:'',leave_type:'',employee:'',leave_verifier_id:'',leave_reason:'',start_dt:'',end_dt:'',leave_status:'',leave_count:''}; 
    
    var loadLeaveRequests = function()
    {
        var response = webservice.get(BASE+'api/get-leave-requests');
        response.success(function(res){
            $scope.leave_requests = res;
        });
    }
    
    var loadDepartments = function()
    {
        var response = webservice.get(BASE+'departments.json');
        response.success(function(res){
           $scope.departments = res; 
           $scope.showFrm = 1;
        });
    }
    
    $scope.getAssignedEmployees = function()
    {
        var response = webservice.get(BASE+'employee/department/'+$scope.form.department);
        response.success(function(res){
            $scope.employees = res;
        });
        var response = webservice.get(BASE+'api/get-hiring-manager/'+$scope.form.department);
        response.success(function(res) {
           $scope.approvers=res; 
        });
    }
    
    $scope.editLeave = function(l)
    {
        loadDepartments();
        $scope.form.id = l.id;
        $scope.form.department = l.department;
        $scope.form.leave_type = l.leave_type;
        $scope.getAssignedEmployees();
        $scope.form.employee = l.employee;
        $scope.form.leave_verifier_id = l.leave_verifier_id;
        $scope.form.leave_reason = l.leave_reason;
        $scope.form.leave_status = l.leave_status;
        $scope.form.leave_count = l.leave_count;
        $scope.form.start_dt = l.start_dt;
        $scope.form.end_dt = l.end_dt;
        
    }
    
    $scope.approve = function()
    {
        $scope.successes = [];
        var response = webservice.post(BASE+'approve-leave-request',$scope.form);
        response.success(function(res){
            $scope.successes = res.message;
            loadLeaveRequests();
            $scope.showFrm = 0;
        });
    }
    
    $scope.reject = function()
    {
        $scope.successes = [];
        var response = webservice.post(BASE+'reject-leave-request',$scope.form); 
        response.success(function(res){
            $scope.successes = res.message;
            loadLeaveRequests();
            $scope.showFrm = 0;
        });
    }
    
    loadLeaveRequests();
}]);