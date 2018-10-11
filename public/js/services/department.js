angular.module('department',[]).service('department',function($http){
   
   this.getAll=function()
   {
      
     return $http.get(BASE+'departments.json');
      
   }
   
});