@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="lrequest" ng-controller="lrequestCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    <div class="panel panel-default" ng-show="showFrm">

        <div class="panel-heading">Leave Request Application</div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-3">Leave Type</label>
                    <div class="col-lg-3">
                        <span>@{{form.leave_type}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Department</label>
                    <div class="col-lg-3">
                        <span>@{{form.department.name}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Requested By</label>
                    <div class="col-lg-3">
                        <span>@{{form.employee.name}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Reason</label>
                    <div class="col-lg-6">
                        <span>@{{form.leave_reason}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Leave Start From</label>
                    <div class="col-lg-3">
                        <span>@{{form.start_dt}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Leave End</label>
                    <div class="col-lg-3">
                        <span>@{{form.end_dt}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Total days of Leave</label>
                    <div class="col-lg-3">
                        <span>@{{form.leave_count | plural:'day'}} 
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="button" ng-click="approve()" class="btn btn-success btn-sm" value="Approve"/>
                        <input type="button" ng-click="reject()" class="btn btn-danger btn-sm" value="Rejected"/>
                    </div>
                </div>
            </form>
        </div>
       
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}</div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Requested By</th>
                        <th>Leave Start From</th>
                        <th>Leave End</th>
                        <th>Leave Count</th>
                        <th>Leave Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="leave in leave_requests">
                        <td>@{{leave.leave_type}}</td>
                        <td>@{{leave.employee.name}}</td>
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
</section
@stop