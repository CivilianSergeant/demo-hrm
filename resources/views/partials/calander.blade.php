<div class="panel panel-default">
    
    <div class="panel-body">
        <a class="btn btn-info btn-xs" ng-click="prevMonth()"><i class="glyphicon glyphicon-triangle-left"></i> Prev Month</a> <a class="btn btn-info btn-xs" ng-click="nextMonth()"><i class="glyphicon glyphicon-triangle-right"></i> Next Month</a>
        <h3>@{{months[firstDateObj.getMonth()]}},@{{firstDateObj.getFullYear()}}</h3>
        
    
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