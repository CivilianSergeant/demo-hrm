angular.module('leave',[])
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
.filter('plural',function(){
    return function(input,noun){
      return (input >= 2) ? input + ' '+noun+'s' : input + ' '+noun;
    };
}).
controller('leaveCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.leaves = [];
    $scope.showFrm = 0;
    $scope.form = {id:'',leave_type:'',employee_id:'',leave_verifier_id:'',leave_reason:'',start_dt:'',end_dt:'',leave_status:'',leave_count:''}; 
    $scope.leave_types = ['General','Sick'];
    $scope.statuses = ['Approved','Rejected'];
    
    var loadLeaves = function()
    {
        var response = webservice.get(BASE + 'leaves.json');
        response.success(function(res){
            $scope.leaves = res;
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
    
    $scope.openFrm = function()
    {
        
        $scope.form = {id:'',leave_type:'',employee_id:'',leave_verifier_id:'',leave_reason:'',start_dt:'',end_dt:'',leave_status:'',leave_count:''}; 
        loadDepartments();
        
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
        $scope.form = {id:'',leave_type:'',employee_id:'',leave_verifier_id:'',leave_reason:'',start_dt:'',end_dt:'',leave_status:'',leave_count:''}; 
    }
    
    $scope.saveLeaveRequest = function()
    {
        $scope.successes = $scope.errors = [];
        var response = webservice.post(BASE+'leave/save-leave',$scope.form);
        response.success(function(res){
            $scope.closeFrm();
            $scope.successes = res.message;
            loadLeaves();
        });
    }
    
    $scope.editLeave = function(l)
    {
        loadDepartments();
        $scope.form.id = l.id;
        $scope.form.department = l.department_id;
        $scope.form.leave_type = l.leave_type;
        $scope.getAssignedEmployees();
        $scope.form.employee_id = l.employee_id;
        $scope.form.leave_verifier_id = l.leave_verifier_id;
        $scope.form.leave_reason = l.leave_reason;
        $scope.form.leave_status = l.leave_status;
        $scope.form.start_dt = l.start_dt;
        $scope.form.end_dt = l.end_dt;
        
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = $scope.errors = [];
    }
    
    $('input[name="start_dt"],input[name="end_dt"]').datepicker({dateFormat:'yy-mm-dd'});
    
    loadLeaves();
}]);