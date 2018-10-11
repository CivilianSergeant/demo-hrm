angular.module('workshift',['ui.bootstrap']).
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
controller('workshiftCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.showFrm = 0;
    $scope.startTime = new Date();
    var ed = new Date();
    ed.setHours(ed.getHours()+8);
    $scope.endTime = ed;
    $scope.workshifts = [];
    
    
    $scope.hstep = 1;
    $scope.mstep = 15;
    
    $scope.openFrm = function()
    {
        $scope.form = {shift_name:'',start_time:'',end_time:''};
        $scope.showFrm = 1;
        
    }
    
    $scope.closeFrm = function()
    {
        $scope.form = {shift_name:'',start_time:'',end_time:''};
        $scope.showFrm = 0;
        
    }
    
    var loadWorkshifts = function()
    {
        var response = webservice.get(BASE+'workshifts.json');
        response.success(function(res){
           $scope.workshifts = res; 
        });
        
    }
    
    $scope.saveWorkShift = function()
    {
        $scope.successes = $scope.errors = [];
        $scope.form.start_time = $scope.startTime.getTime();
        $scope.form.end_time = $scope.endTime.getTime();
        
        var response = webservice.post(BASE+'workshift/create',$scope.form);
    
        response.success(function(res){
           $scope.successes = res.message;
           $scope.closeFrm();
           loadWorkshifts();
           
        }).error(function(res){
            $scope.errors = res.shift_name;
        });
    }
    
    $scope.editShift = function(s)
    {
        $scope.form = s;
        var sD = new Date();
        sD.setTime(s.start_time);
        $scope.startTime = sD;
        var eD = new Date();
        eD.setTime(s.end_time);
        $scope.endTime = eD;
        $scope.showFrm = 1;
    }
    
    $scope.deleteShift = function(s)
    {
        bootbox.confirm('Are you sure to delete this item?',function(r){
            if(r)
            {
                var response = webservice.post(BASE+'workshift/remove',{id:s.id});
                response.success(function(res){
                     loadWorkshifts();
                });
            }
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadWorkshifts();
}]);