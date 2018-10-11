angular.module('vacancy',[]).
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
controller('vacancyCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.showFrm = 0;
    $scope.form = {id:'',department:'',designation:'',title:'',hiring_manager:'',position:'',description:'',publish:''};
    $scope.openFrm = function()
    {
        $scope.showFrm = 1;
         $scope.form = {id:'',department:'',designation:'',title:'',hiring_manager:'',position:'',description:'',publish:''};
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
        $scope.form = {id:'',department:'',designation:'',title:'',hiring_manager:'',position:'',description:'',publish:''};
    }
    
    
    $scope.getDesignations = function()
    {
        var response = webservice.get(BASE+'designations/'+$scope.form.department);
        response.success(function(res){
           $scope.designations = res; 
        }).error(function(res){
            
        });
        
        var response = webservice.get(BASE+'api/get-hiring-manager/'+$scope.form.department);
        response.success(function(res){
           $scope.hiring_managers = res; 
        }).error(function(res){
            
        });
    
    }
    
    var loadDepartments = function()
    {
        var response  = webservice.get(BASE+'departments.json');
        response.success(function(res){
            $scope.departments = res;   
            
        });
    }
    
    var loadVacncies = function()
    {
        var response = webservice.get(BASE+'vacanicies.json');
        response.success(function(res){
           $scope.vacancies = res; 
        });
    }
    
    $scope.saveVacancy = function()
    {
        $scope.successes = $scope.errors = [];
        if($scope.form.id)
            var response = webservice.post(BASE+'vacancy/update',$scope.form);
        else
            var response = webservice.post(BASE+'vacancy/save-vacancy',$scope.form);
        response.success(function(res){
            $scope.successes = res.message;
            loadVacncies();
            $scope.closeFrm();
            
        });
    }
    
    $scope.editVacancy = function(vacancy)
    {
        $scope.form.id = vacancy.id;
        $scope.form.department = vacancy.department_id;
        $scope.form.designation = vacancy.designation_id;
        $scope.form.title = vacancy.vacancy_name;
        $scope.form.description = vacancy.vacancy_description;
        $scope.form.hiring_manager = vacancy.hiring_manager_id;
        $scope.form.publish = (vacancy.publish_feed_web==1) ? true : false;
        $scope.form.position = vacancy.number_of_post;
        $scope.showFrm = 1;
        $scope.getDesignations();
    }
    
    $scope.removeVacancy = function(vacancy)
    {
        bootbox.confirm('Are you sure to delete this item?',function(response){
           if(response)
           {
               var response = webservice.post('vacancy/remove',vacancy);
               response.success(function(res){
                   
                  loadVacncies();
               });
           }
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadDepartments();
    loadVacncies();
}]);