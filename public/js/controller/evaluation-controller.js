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
}).controller('evaluationCtrl',['$scope','webservice',function($scope,webservice){
   
   $scope.lists = [];
   $scope.form = {id:'',employee_id:'',feedback_by:[],rating:'',template:'',year:''};
   $scope.showFrm = 0;
   $scope.departments = [];
   $scope.employees = [];
   $scope.feedback_by = []
   $scope.templates = [];
   $scope.years = [];
   var loadEvalRequests = function()
   {
       var response = webservice.get(BASE+'evaluations.json');
       response.success(function(res){
          $scope.lists = res; 
       });
   }
   
   var loadTemplates = function()
   {
       var response = webservice.get(BASE+'kpi-templates.json');
       response.success(function(res){
        $scope.templates = res;
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
   
   $scope.openFrm = function()
   {
        loadDepartments();
        loadTemplates();
        $scope.form = {id:'',employee_id:'',feedback_by:[],rating:'',template:''};
        $scope.showFrm = 1;
        
   }
    
   $scope.closeFrm = function()
   {
        $scope.form = {id:'',employee_id:'',feedback_by:[],rating:'',template:''};
        $scope.showFrm = 0;
   }
   
   $scope.resetAlert = function()
   {
       $scope.successes = errors = [];
   }
   
   $scope.selectedDepartment = function()
   {
       if($scope.form.department_id)
       {
           var response = webservice.get(BASE+'employee/department/'+$scope.form.department_id);
           response.success(function(res){
               $scope.employees = res;
           });
       }
   }
   
   $scope.selectedEmployee = function()
   {
       $scope.feedback_by = [];
       for(var emp in $scope.employees)
       {
           if($scope.employees[emp].employee_id != $scope.form.employee_id)
           {
                $scope.feedback_by.push($scope.employees[emp]);        
           }
       }
       
   }
   
   var d = new Date();
   for(i=(d.getFullYear()); i<=(d.getFullYear()+5); i++)
   {
       $scope.years.push(i);
   }
   
   $scope.saveRequest = function()
   {
       var response = webservice.post(BASE+'send-evaluation-request',$scope.form);
       response.success(function(res){
           
       });
   }
   
   
   loadEvalRequests();
   
   
}]);