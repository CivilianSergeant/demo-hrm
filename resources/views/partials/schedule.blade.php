<div class="panel panel-default">
    
    <div class="panel-body">
        <a class="btn btn-info btn-xs" ng-click="prevMonth()"><i class="glyphicon glyphicon-triangle-left"></i> Prev Month</a> <a class="btn btn-info btn-xs" ng-click="nextMonth()"><i class="glyphicon glyphicon-triangle-right"></i> Next Month</a><h3>@{{months[firstDateObj.getMonth()]}},@{{firstDateObj.getFullYear()}}</h3>
        <a class="btn btn-primary btn-xs pull-right" ng-show="!showFrm" ng-click="assignShift()"><i class="glyphicon glyphicon-plus"></i> Assign Shift</a>
    <form id="assignShift" class="form-horizontal" ng-show="showFrm" ng-submit="saveAssignWorkShift()">
        <div class="form-group">
            <label class="control-label col-lg-3">Shift Name</label>
            <div class="col-lg-3">
                <select class="form-control" ng-model="form.shift">
                    <option ng-repeat="shift in shifts" value="@{{shift.id}}">@{{shift.shift_name}}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">Department</label>
            <div class="col-lg-3">
                <select class="form-control" ng-model="form.department" ng-change="getEmployeeByDepartment()">
                    <option ng-repeat="department in departments" value="@{{department.id}}">@{{department.name}}</option>
                </select>
                
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">Employees</label>
            <div class="col-lg-3">
                <select class="form-control" ng-model="form.employee"  multiple>
                    <option ng-repeat="employee in employees" value="@{{employee.employee.id}}">@{{employee.employee.name}}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">Date</label>
            <div class="col-lg-3">
                <input type="text" class="form-control datepicker" ng-model="form.shift_date"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-lg-offset-3">
                <input type="submit" class="btn btn-success" value="Save"/>
                <input type="button" class="btn btn-warning" ng-click="closeFrm()" value="Cancel"/>
            </div>
        </div>
    </form>
    </div>
    
    <div class="panel-body">
        <table class="table schedule-roster">
            <thead>
                <tr>
                    <th>Shift</th>
                    <th ng-repeat="day in days">@{{day}}</th>
                </tr>
            </thead>
            <tbody ng-bind-html="trHtml">
                
            </tbody>
        </table>
        
    </div>
    
</div>