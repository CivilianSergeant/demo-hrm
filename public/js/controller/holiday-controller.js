angular.module('holiday',[]).
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
})
.filter('selectedYear',function(){
   return function(input,searchYear){
       return input.replace(/[0-9]{4}/g,searchYear);
   };
}).
controller('holidayCtrl',['$scope','webservice','$sce',function($scope,webservice,$sce){
    
    $scope.form = {name:'',holiday_date:'',recurring:''};
    $scope.showFrm = 0;
    $scope.recurring = '';
    $scope.years = [];
    
    var loadHoliday = function()
    {   
        var d = new Date();
        for(var i=(d.getFullYear()-5); i<=(d.getFullYear()+10); i++)
        {
            $scope.years.push(i);
        }
        var response = webservice.get(BASE+'holidays.json');
        response.success(function(res){
           $scope.holidays = res; 
           $scope.searchYear = null;
        });
        
        
    }
    
    $scope.changeYear = function()
    {
        $scope.holidays = [];
        var response = webservice.get(BASE+'holidays/'+$scope.searchYear);
        response.success(function(res){
           $scope.holidays = res; 
        });
    }
    
    $scope.openFrm = function()
    {
        $scope.form = {name:'',holiday_date:'',recurring:''};
        $scope.showFrm = 1;
        $scope.recurring = '';
    }
    
    $scope.closeFrm = function()
    {
        $scope.form = {name:'',holiday_date:'',recurring:''};
        $scope.showFrm = 0;
        $scope.recurring = '';
    }
    
    $scope.saveHoliday = function()
    {
        $scope.form.recurring = $scope.recurring;
      
        $scope.successes = $scope.errors = [];
        
        var response = webservice.post(BASE+'holiday/create',$scope.form);
        response.success(function(res){
            $scope.successes = res.message;
            $scope.showFrm = 0;
            loadHoliday();
        }).error(function(res){
            
        });
    }
    
    $scope.editHoliday = function(holiday)
    {
        $scope.form = holiday;
        $scope.showFrm = 1;
        $scope.recurring = (holiday.recurring == 1) ? true : false;
        $scope.form.recurring = $scope.recurring;
        console.log($scope.recurring);
    }
    
    $scope.deleteHoliday = function(holiday)
    {   $scope.successes = $scope.errors = [];
        var response = webservice.post(BASE+'holiday/delete',holiday);
        response.success(function(res){
            $scope.successes = res.message;
            loadHoliday();
        });
    }
    
    $scope.changeRecurring = function(recurring)
    {
        $scope.form.recurring = (!recurring);
        console.log($scope.form.recurring)
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadHoliday();
    
    angular.element('input[name="holiday_date"]').datepicker({
       dateFormat:'yy-mm-dd'
    });
    
}]);