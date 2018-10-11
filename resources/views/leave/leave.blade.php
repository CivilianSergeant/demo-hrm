@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="leave" ng-controller="leaveCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    
    <div class="panel panel-default" ng-show="showFrm">
        
        <div class="panel-heading">Apply Leave
            <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
        <div class="panel-body">
            
            <form class="form-horizontal" ng-submit="saveLeaveRequest()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Leave Type</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.leave_type">
                            <option value=""></option>
                            <option ng-repeat="lt in leave_types" ng-selected="lt == form.leave_type" value="@{{lt}}">@{{lt}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Department</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.department" ng-change="getAssignedEmployees()">
                            <option value=""></option>
                            <option ng-repeat="d in departments" ng-selected="d.id == form.department" value="@{{d.id}}">@{{d.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Employee</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.employee_id">
                            <option ng-repeat="j in employees" ng-selected="j.employee.id == form.employee_id" value="@{{j.employee.id}}">@{{j.employee.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Approver</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.leave_verifier_id">
                            <option ng-repeat="approver in approvers" value="@{{approver.employee.id}}">@{{approver.employee.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Leave Reason</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" ng-model="form.leave_reason"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Leave Start Date</label>
                    <div class="col-lg-3">
                        <input type="text" name="start_dt" ng-model="form.start_dt" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Leave End Date</label>
                    <div class="col-lg-3">
                        <input type="text" name="end_dt" ng-model="form.end_dt" class="form-control"/>
                    </div>
                </div>
                <div class="form-group" ng-show="form.leave_status == 'Pending'">
                    <label class="control-label col-lg-3">Leave Status</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.leave_status">
                            <option ng-repeat="s in statuses" value="@{{s}}">@{{s}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Request"/>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
            <a ng-click="openFrm()" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Create Leave Request</a>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Requested By</th>
                        <th>Approver</th>
                        <th>Leave Start From</th>
                        <th>Leave End</th>
                        <th>Leave Count</th>
                        <th>Leave Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="leave in leaves">
                        <td>@{{leave.leave_type}}</td>
                        <td>@{{leave.employee.name}}</td>
                        <td>@{{leave.leave_verifier.name}}</td>
                        <td>@{{leave.start_dt}}</td>
                        <td>@{{leave.end_dt}}</td>
                        <td>@{{leave.leave_count | plural:'day'}}</td>
                        <td>@{{leave.leave_status}}</td>
                        <td>
                            <a ng-click="editLeave(leave)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</section>
@stop