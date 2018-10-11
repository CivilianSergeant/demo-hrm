angular.module('designation',[]).
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
controller('designationCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.designations = [];
    $scope.designationsTree = [];
    
    $scope.parent_department = [];
    $scope.parent_designation = [];
    $scope.form={id:'',title:'',quote:'',description:'',parent_department:[],parent_designation:[]};
    $scope.showForm = 0;
    var loadDepartments = function()
    {
        var response = webservice.get(BASE+'api/departments.json');
        response.success(function(res){
            
            $scope.departments = res;
           
        });
        
        $scope.parent_department = [];
        
       
    }
    
    var loadDesignations = function()
    {
        var response = webservice.get(BASE+'api/designations.json');
        response.success(function(res){
            $scope.designations = res;
            
           
        });
        
        $scope.parent_designation = [];
    }
    
    var loadDesignationsWithChild = function()
    {
        var response = webservice.get(BASE+'api/designations-with-child.json');
        response.success(function(res){
            $scope.designationstree = res;

        });
        
        $scope.parent_designation = [];
    }
    
    $scope.closeFrm = function()
    {
        $scope.form={id:'',title:'',quote:'',description:'',parent_department:[],parent_designation:[]};
        $scope.showForm = 0;
        $scope.parent_department = [];
        $scope.parent_designation = [];
    }
    
    $scope.openFrm = function()
    {
        $scope.form={id:'',title:'',quote:'',description:'',parent_department:[],parent_designation:[]};
        $scope.showForm = 1;
        $scope.parent_department = [];
        $scope.parent_designation = [];
    }
    
    $scope.setDepartment = function(department)
    {
        var index = $scope.parent_department.indexOf(department.id);
        $scope.parent_department = [];
        $scope.parent_department.push(department.id);
        
        /*if(index == -1)
        {
            $scope.parent_department.push(department.id);
        }else{
            $scope.parent_department.splice(index,1);
        }*/
    }
    
    $scope.setDesignation = function(designation)
    {
        var index = $scope.parent_designation.indexOf(designation.id);
        $scope.parent_designation = [];
        $scope.parent_designation.push(designation.id);
        
    }
    
    $scope.saveDesignation = function()
    {
        $scope.successes = [];
        $scope.errors = [];
        var response = null;
        
        if($scope.parent_department.length ==  0)
        {
            $scope.errors.push('Please select department');
            return false;
        }
        
        
        $scope.form.parent_department = $scope.parent_department;
        $scope.form.parent_designation = $scope.parent_designation;
        
        if($scope.form.id)
            response = webservice.post(BASE+'designation/update',$scope.form);
        else
            response = webservice.post(BASE+'designation/create',$scope.form);
            
        response.success(function(res){
            
            $scope.successes = res.message;
            $scope.form={id:'',title:'',quote:'',description:'',parent_department:[],parent_designation:[]};
            $scope.parent_department = [];
            $scope.parent_designation = [];
            $scope.showForm = 0;
            loadDesignations();
            loadDesignationsWithChild();
            
        }).
        error(function(res){
            
            for(i in res)
            {
                $scope.errors.push(res[i][0]);
            }
        });
    }
    
    $scope.editDesignation = function(designation)
    {
        $scope.parent_designation = [];
        $scope.parent_department = [];
        $scope.form.parent_department = [];
        $scope.form.parent_designation = [];
        $scope.form.id = designation.id;
        $scope.form.title = designation.title;
        
        $scope.form.description = designation.description;
        $scope.form.quota = designation.quota;
        $scope.form.parent_department.push(designation.department_id);
        $scope.form.parent_designation.push(designation.order);
        $scope.parent_department = $scope.form.parent_department;
        $scope.parent_designation = $scope.form.parent_designation;
        $scope.showForm = 1;
    }
    
    $scope.deleteDesignation = function(designation)
    {
        $scope.successes = [];
        var response = webservice.post(BASE+'designation/remove',designation);
        response.success(function(res){
            $scope.successes.push('Designation '+designation.title+' removed');
            loadDesignations();
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    loadDesignations();
    loadDesignationsWithChild();
    loadDepartments();
    
}]);