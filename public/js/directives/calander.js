angular.module('calander',[])
.directive('calander',function(){
    return{
        restrict:"EA",
        scope:{
            title:'=',
            attendance:'=attendance'
        },
        
        replace:true,
        templateUrl: BASE+'get-template/calander',
        
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
            
            var drawCalanderGrid = function()
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
                    var date = ($scope.attendance[fullDate] != undefined)? $scope.attendance[fullDate]: '';
                    for(var shift in $scope.shifts)
                    {
                        var shfit_name = $scope.shifts[shift].shift_name;
                        var shift_id = $scope.shifts[shift].id;
                        var attendance = (date[shfit_name] != undefined)? date[shfit_name] : '';
                        trHtml +='<li>';
                        var int = out = trHtmlEmp = '';
                        if(attendance.in != undefined && attendance.out !=undefined)
                        {
                            var intime = new Date(attendance.in*1000);
                            var outtime = new Date(attendance.out*1000);
                            var ih = (intime.getHours() <10)? '0'+intime.getHours() : intime.getHours();
                            var im = (intime.getMinutes() <10)? '0'+intime.getMinutes() : intime.getMinutes();
                            
                            var oh = (outtime.getHours() <10)? '0'+outtime.getHours() : outtime.getHours();
                            var om = (outtime.getMinutes() <10)? '0'+outtime.getMinutes() : outtime.getMinutes();
                            
                            var int = ih + ':' + im;
                            var out = oh + ':' + om;
                            var trHtmlEmp = 'In: '+int+' Out: '+out;
                        }else
                            trHtmlEmp = '&nbsp;';
                        
                    
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
               drawCalanderGrid();
                
                
            });
            
            
            
            $scope.prevMonth = function()
            {
                cur_date = 0;
                thisMonth = $scope.firstDateObj.getMonth()-1;
                thisYear = $scope.firstDateObj.getFullYear();
                $scope.firstDateObj = new Date(thisYear,thisMonth,1);
                drawCalanderGrid();
                
            }
            
            $scope.nextMonth = function()
            {
                cur_date = 0;
                thisMonth = $scope.firstDateObj.getMonth()+1;
                thisYear = $scope.firstDateObj.getFullYear();
                $scope.firstDateObj = new Date(thisYear,thisMonth,1);
                drawCalanderGrid();
                
            }
            

            
        }
    }
});