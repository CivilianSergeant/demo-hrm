angular.module('attendance',['ui.bootstrap'])
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
.controller('attendanceCtrl',['$scope','webservice',function($scope,webservice){
    $scope.hstep = 1;
    $scope.mstep = 15;
    $scope.form = {id:'',employee_id:'',start_time:'',end_time:'',date:'',shift:''};
    $scope.shift = '';
    $scope.showFrm = 0;
    $scope.attendances = [];
    
    var loadAttendances = function()
    {
        var response = webservice.get(BASE+'attendances.json');
        response.success(function(res){
           $scope.attendances = res; 
        });
    }
    
    $scope.openFrm = function()
    {
        $scope.showFrm = 1;
        $('input[name="date"]').datepicker({dateFormat:'yy-mm-dd'});
        var today = new Date();
        var m = (today.getMonth()+1 < 10)? '0'+(today.getMonth()+1) : today.getMonth()+1;
        var d = (today.getDate() <10)? '0'+today.getDate() : today.getDate();
        var t = today.getFullYear()+'-'+m+'-'+d;
        $scope.form = {id:'',employee_id:'',start_time:new Date(),end_time:new Date(),date:t,shift:''};
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
        $scope.form = {id:'',employee_id:'',start_time:new Date(),end_time:new Date(),date:'',shift:''};
        
    }
    
    $scope.getTodayShift = function()
    {
        
        var response = webservice.get(BASE+'employee/workshift/'+$scope.form.employee_id+'/'+$scope.form.date);
        response.success(function(res){
           $scope.form.shift = res; 
        });
    }
    
    $scope.dateChange = function()
    {
        loadAssignedEmployees();
    }
    
    var loadAssignedEmployees = function()
    {
        var response = webservice.get(BASE+'api/assigned-employees.json'); 
        response.success(function(res){
            $scope.employees = res;
        });
    }
    
    $scope.saveAttendance = function()
    {
        
        var start_time = $scope.form.start_time.getTime();
        var end_time = $scope.form.end_time.getTime();
        var timestamp = end_time - start_time;
        
        if(timestamp<0)
        {
            end_time = $scope.form.end_time.setDate($scope.form.end_time.getDate()+1);
            
        }
        
        $scope.successes = $scope.errors = [];
        if($scope.form.shift == "")
        {
            $scope.errors = ['Work Shift not available today.'];
        }else{
            $scope.form.start_time = start_time;
            $scope.form.end_time = end_time;
           
            if($scope.form.id)
                var response = webservice.post(BASE+'attendance/save-attendance',$scope.form);
            else
                var response = webservice.post(BASE+'attendance/update',$scope.form);
                
            response.success(function(res){
               
                $scope.successes = res.message;
                $scope.errors = res.error;
                $scope.closeFrm();
                loadAttendances();
                
            }).error(function(res){
                
            });
        }
    }
    
    $scope.editAttendance = function(a)
    {
        $scope.form.id = a.id;
        $scope.form.employee_id = a.employee_id;
        var response = webservice.get(BASE+'employee/workshift/'+$scope.form.employee_id);
        
        response.success(function(res){
           $scope.form.shift = res; 
        });
        
        var sD = new Date();
        sD.setTime(a.in_time);
        $scope.form.start_time = sD;
        var eD = new Date();
        eD.setTime(a.out_time);
        $scope.form.end_time = eD;
        $scope.form.date = a.date;
        $scope.showFrm = 1;
    }
    
    $scope.getTime = function(t)
    {
        var d = new Date();
        d.setTime(t);
        return d;
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = $scope.errors = [];
    }
    
    loadAttendances();
    
    loadAssignedEmployees();
    
}]);