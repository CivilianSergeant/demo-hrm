angular.module('settings',[])
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
.controller('settingsCtrl',['$scope','webservice',function($scope,webservice){
    $scope.formTab = {attendance:1,leave:0};
    $scope.attendance = {absent:'',late_in:''};
    $scope.leave = {deduct_salary:'', leave_type:''};
    
    var loadSettings = function()
    {
        var response = webservice.get(BASE+'get-settings');
        response.success(function(res){
            for(a in res.attendance)
            {
                $scope.attendance[res.attendance[a].key] = res.attendance[a].value;
            
            }
            for(l in res.leave)
            {
                $scope.leave[res.leave[l].key] = res.leave[l].value;
            }
        });
    }
    
    $scope.selectFormTab = function(item)
    {
        $scope.formTab = {attendance:0,leave:0};
        $scope.formTab[item] = 1;
    }
    
    $scope.saveAttendanceSettings = function()
    {
        $scope.successes = [];
        var response = webservice.post(BASE+'settings/save-attendance',{attendance:$scope.attendance});
        response.success(function(){
            loadSettings();
             $scope.successes = ['Settings updated'];
        });
    }
    
    $scope.saveLeaveSettings = function()
    {
        $scope.successes = [];
        var response = webservice.post(BASE+'settings/save-leave',{leave:$scope.leave});
        response.success(function(){
            loadSettings();
            $scope.successes = ['Settings updated'];
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = $scope.errors = [];
    }
    
    
    
    loadSettings();
}]);