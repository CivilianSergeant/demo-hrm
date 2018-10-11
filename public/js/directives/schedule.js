angular.module('schedule',[])
.directive('scheduleRoster',function(){
    return{
        restrict:"EA",
        scope:{
            title:'=',
            callback: '&mySaveCallback'
        },
        
        replace:true,
        templateUrl: BASE+'get-template/schedule',
        
        controller:function($scope,$http,$sce){
            var current_date_obj = new Date();
            $scope.cur_date = 1;
            $scope.days = ['Sunday','Monday','Tuesday','Wednessday','Thursday','Friday','Saturday'];
            $scope.months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            $scope.week = 4;
            var cur_date = 0;
            var thisYear = current_date_obj.getFullYear();
            var thisMonth = current_date_obj.getMonth();
            $scope.firstDateObj = new Date(thisYear,thisMonth,1);
            $scope.lastDateObj = new Date(thisYear, thisMonth+1,0);
            $scope.shifts = [];
            $scope.showFrm = 0;
            $scope.form = {employee:'',shift:'',shift_date:''};
            
            var getBlankField = function()
            {
                return blankCount = $scope.firstDateObj.getDay();

            }
            
            
            
            var drawRosterGrid = function()
            {   
                    
                    var trHtml = '';
                    var blankCount = getBlankField();
                    if(blankCount)
                    {
                        trHtml += '<tr><td><ul><li>&nbsp</li>';
                        for(var shift in $scope.shifts)
                        {
                            var shfit_name = $scope.shifts[shift].shift_name;
                            trHtml += '<li>'+shfit_name+'</li>';
                        }
                        trHtml += '</ul></td>';
                        for(var i=0; i<blankCount; i++)
                        {
                            trHtml += '<td><span></span></td>';
                             cur_date++;
                             
                        }
                    }
                    
                
                
                for(var idate = $scope.firstDateObj.getDate(); idate<=$scope.lastDateObj.getDate();idate++)
                {
                    
                    
                    /*if((cur_date+idate) == 7)
                    {
                        trHtml+'</tr>';
                    }*/
                    if(cur_date%7 == 0)
                    {   
                       if(blankCount)
                       {
                        trHtml +='</tr>';     
                       }
                        
                        
                        trHtml +='<tr><td><ul><li>&nbsp</li>';
                        
                        for(var shift in $scope.shifts)
                        {
                            var shfit_name = $scope.shifts[shift].shift_name;
                            trHtml += '<li>'+shfit_name+'</li>';
                        }
                        trHtml +='</ul></td>';
                    }
                    
                    trHtml += '<td><span>'+$scope.months[$scope.firstDateObj.getMonth()]+'-'+idate+'</span><ul>';
                    var m = ($scope.firstDateObj.getMonth()+1);
                    var month = (m.toString().length == 1)? '0'+m:m;
                    idate = (idate.toString().length == 1)? '0'+idate:idate;
                    var fullDate = $scope.firstDateObj.getFullYear()+'-'+month+'-'+idate;
                    for(var shift in $scope.shifts)
                    {
                        var shfit_name = $scope.shifts[shift].shift_name;
                        var shift_id = $scope.shifts[shift].id;
                        var workshifts = $scope.employee_workshifts[fullDate];//($scope.employee_workshifts[fullDate] != undefined) ? $scope.employee_workshifts[fullDate].employee : [];
                        
                        var shift_data  = (workshifts!=undefined)? workshifts[shift_id] : ''
                        var employees   = (shift_data != undefined)? shift_data.employees : [];
                        trHtml +='<li>';
                        var trHtmlEmp = '&nbsp;';
                        for(var emp in employees){
                            trHtmlEmp = ((employees[emp] != "")? '<a class="removeSchedule" emp_id="'+employees[emp].id+'" shift_id="'+shift_id+'" full_date="'+fullDate+'">'+employees[emp].name+'</a>' : '---');
                    
                        }  
                        trHtml += trHtmlEmp;
                        trHtml +='</li>';
                    }
                    trHtml +='</ul></td>';
                    cur_date++
                }
                trHtml += '</tr>';
                
                
                $scope.trHtml = $sce.trustAsHtml(trHtml);
            }
            
            $http({
               url: BASE+'workshifts.json',
            }).success(function(res){
                
               $scope.shifts=res;
               var month = ($scope.lastDateObj.getMonth()+1);
                $http({
                    url: BASE+'employee-workshifts/'+month+'/'+$scope.lastDateObj.getFullYear(),
                    
                }).success(function(res){
                    $scope.employee_workshifts = res;
                    drawRosterGrid();
                });
                
                
            });
            
            $scope.prevMonth = function()
            {
                cur_date = 0;
                thisMonth = $scope.firstDateObj.getMonth()-1;
                thisYear = $scope.firstDateObj.getFullYear();
                $scope.firstDateObj = new Date(thisYear,thisMonth,1);
               // drawRosterGrid();
                $http({
                    url: BASE+'employee-workshifts/'+(thisMonth+1)+'/'+$scope.lastDateObj.getFullYear(),
                    
                }).success(function(res){
                    $scope.employee_workshifts = res;
                    drawRosterGrid();
                });
            }
            
            $scope.nextMonth = function()
            {
                cur_date = 0;
                thisMonth = $scope.firstDateObj.getMonth()+1;
                
                thisYear = $scope.firstDateObj.getFullYear();
                $scope.firstDateObj = new Date(thisYear,thisMonth,1);
                //drawRosterGrid();
                $http({
                    url: BASE+'employee-workshifts/'+(thisMonth+1)+'/'+$scope.lastDateObj.getFullYear(),
                    
                }).success(function(res){
                    $scope.employee_workshifts = res;
                    drawRosterGrid();
                });
                
            }
            
            $scope.assignShift = function()
            {
                $http({
                   url: BASE+'departments.json' 
                }).success(function(res){
                    
                    $scope.departments = res;
                    $scope.showFrm = 1;
                    
                    angular.element('.datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        
                });
                
                
                $('html,body').animate({scorllTop:'0px'});   
            }
            
            $scope.getEmployeeByDepartment = function()
            {
                $http({
                    url:BASE+'employee/department/'+$scope.form.department
                }).success(function(res){
                    $scope.employees = res;
                });
            }
            
            $scope.saveAssignWorkShift = function()
            {
                $scope.successes = [];
                $http({
                   url : BASE+'employee/assign-work-shift',
                   data: $scope.form,
                   method:'post'
                }).success(function(res){
                    $scope.successes = res.message;
                    $scope.showFrm = 0;
                    window.location.reload();
                });
            }
             $(document).on('click','a.removeSchedule',function(){
              var obj = $(this); 
              bootbox.confirm('Are you sure to delete this?',function(response){
                  if(response)
                  {  $http({
                        url:BASE+'employee/remove-work-shift',
                        data:{emp_id:obj.attr("emp_id"),shift_id:obj.attr("shift_id"),full_date:obj.attr('full_date')},
                        method:"POST" 
                      }).success(function(res){
                          window.location.reload();
                      });
                  }
              });
            });
            
           
            $scope.closeFrm = function()
            {
                $scope.showFrm = 0;
                $scope.form = {employee:'',shift:'',shift_date:''};
            }
            
            
            
        }
    }
});