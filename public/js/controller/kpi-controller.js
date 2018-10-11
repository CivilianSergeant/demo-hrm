angular.module('kpi',[])
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
.controller('kpiCtrl',['$scope','webservice',function($scope,webservice){
    $scope.kpi = [];
    $scope.form = {id:'', question:''};
    
    var loadKpi = function()
    {
        var response = webservice.get(BASE + 'kpi.json');
        response.success(function(res){
            $scope.kpi = res;
        });
    }
    
    $scope.saveQuestion = function()
    {
       $scope.successes = errors = [];
       if($scope.form.id)
            var response = webservice.post(BASE+'kpi/update',$scope.form)
        else
            var response = webservice.post(BASE+'kpi/save',$scope.form);
        
        response.success(function(res){
             $scope.successes = res.message;
             loadKpi();
        });
    }
    
    $scope.editQuestion = function(k)
    {
        $scope.form.id = k.id;
        $scope.form.question = k.question;
    }
    
    $scope.deleteQuestion = function(k)
    {
        bootbox.confirm('Are you sure to delete this item?',function(r){
            if(r)
            {
                var response = webservice.post(BASE+'kpi/remove',{id:k.id});
                response.success(function(res){
                    loadKpi();
                });
            }
        })
        
    }
    
    $scope.cancel = function()
    {
        $scope.form.question = '';
    } 
    
    $scope.resetAlert = function()
    {
        $scope.successes = errors = [];
        
    }
    loadKpi();
    
}]).controller('kpiTemplateCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.templates = [];
    $scope.form = {id:'',title:'',template:[]};
    $scope.showFrm = 0;
    $scope.kpi = [];
    
    var loadKpi = function()
    {
        var response = webservice.get(BASE + 'kpi.json');
        response.success(function(res){
            $scope.kpi = res;
        });
    }
    
    $scope.openFrm = function()
    {
        
        loadKpi(); 
        $scope.showFrm = 1;
    }
    
    var loadTemplates = function()
    {
        var response = webservice.get(BASE+'kpi-templates.json');
        response.success(function(res){
           $scope.templates = res; 
        });
    }
    
    $scope.saveTemplate = function()
    {
        if($scope.form.id)
            var response = webservice.post(BASE+'kpi/update-template',$scope.form);
        else    
            var response = webservice.post(BASE+'kpi/save-template',$scope.form);
        response.success(function(res){
            loadTemplates();
            $scope.showFrm = 0;
        });
    }
    
     $scope.editTemplate = function(tpl)
     {
         loadKpi();
         var response = webservice.get(BASE+'kpi-template/'+tpl.id);
         response.success(function(res){
             $scope.form.id = res.id;
             $scope.form.title = res.title;
             $scope.form.template = res.kpi_template;
             $scope.showFrm = 1;
         });
 
     }
 
     $scope.cancelFrm = function()
     {
         $scope.form = {id:'',tittle:'',template:[]};
         $scope.showFrm = 0;
     }
     
     $scope.changeSelection = function(tpl)
     {
        var index = $scope.form.template.indexOf(tpl);
        if(index == -1)
        {
            $scope.form.template.push(tpl);
        }else{
            $scope.form.template.splice(index,1);
        }
     }
     
     
     loadTemplates();
    
}]);