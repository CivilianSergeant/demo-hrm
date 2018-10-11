angular.module('candidate',[]).
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
controller('candidateCtrl',['$scope','webservice',function($scope,webservice){
    $scope.showFrm = 0;
    $scope.form = {id:'',name:'',email:'',phone:'',vacancy:'',keyword:'',description:'',source:'',referer:'',status:''};
    $scope.sources = ['NEWS','ONLINE','PERSON','OTHERS'];
    $scope.status = ['Applied','Shortlist','Scheduled Interview','Mark Passed','Mark Failed','Hired','Rejected'];
    $scope.histories = [];
    
    var loadVacncies = function()
    {
        var response = webservice.get(BASE+'vacanicies.json');
        response.success(function(res){
           $scope.vacancies = res; 
        });
    }
    
    var loadCandidates = function()
    {
        var response = webservice.get(BASE+'candidates.json');
        response.success(function(res){
            $scope.candidates = res;
        });
    }
    
    $scope.openFrm = function()
    {
        loadVacncies();
        $scope.showFrm = 1;
        $scope.form = {id:'',name:'',email:'',phone:'',vacancy:'',keyword:'',description:'',source:'',referer:'',status:''};
    
        $scope.histories = [];
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
        $scope.form = {id:'',name:'',email:'',phone:'',vacancy:'',keyword:'',description:'',source:'',referer:'',status:''};
    
         $scope.histories = [];
    }
    
    $scope.saveCandidate = function()
    {
        $scope.successes = $scope.errors = [];
        if($scope.form.id)
            var response = webservice.post(BASE+'candidate/update',$scope.form);
        else
            var response = webservice.post(BASE+'candidate/save-candidate',$scope.form); 
        response.success(function(res){
            $scope.successes = res.message;
            loadCandidates();
            $scope.showFrm = 0;
            $scope.errors = res.vacancy;
        }).error(function(res){
            
            $scope.errors = res.vacancy;
        });
    }
    
    $scope.editCandidate = function(candidate)
    {
        
        $scope.form.id    = candidate.id;
        $scope.form.name  = candidate.name;
        $scope.form.email = candidate.email;
        $scope.form.phone = candidate.phone;
        $scope.form.vacancy = candidate.vacancy_id;
        $scope.form.keyword = candidate.keyword;
        $scope.form.description = candidate.description;
        $scope.form.source = candidate.application_source;
        $scope.form.referer = candidate.referer_name
        $scope.form.status = candidate.status;
        console.log(candidate.status)
      
        if(candidate.status == 'Applied')
        {
           
            $scope.status = ['Shortlist','Rejected'];
            
        }else if(candidate.status == 'Shortlist')
        {
            $scope.status = ['Scheduled Interview','Rejected'];
            
        }else if(candidate.status == 'Scheduled Interview')
        {
            $scope.status = ['Shortlist','Mark Passed','Mark Failed'];
            
        }else if(candidate.status == 'Mark Passed')
        {
            $scope.status = ['Hired','Shortlist'];
            
        }else if(candidate.status == 'Mark Failed')
        {
            $scope.status = ['Rejected','Shortlist'];
        }
        
        var response = webservice.get(BASE+'candidate/histories/'+candidate.id);
        response.success(function(res){
           $scope.histories = res; 
        });
        $scope.showFrm = 1;
    }
    
    $scope.deleteCandidate = function(candidate)
    {
        bootbox.confirm('Are you sure to delete this item?',function(response){
           if(response)
           {
                var response = webservice.post(BASE+'candidate/remove',{id:candidate.id});
                response.success(function(res){
                    loadCandidates();
                });
           }
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = $scope.errors = [];
    }
    
    loadCandidates();
}]);