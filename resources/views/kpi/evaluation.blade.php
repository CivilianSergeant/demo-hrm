@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="evaluation" ng-controller="evaluationCtrl" ng-cloak>
    
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    <div class="panel panel-default" ng-show="showFrm">
        
        <div class="panel-heading">Create Evaluation Request</div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveRequest()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Department</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.department_id" ng-change="selectedDepartment()">
                            <option ng-repeat="department in departments" value="@{{department.id}}">@{{department.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Employee</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.employee_id" ng-change="selectedEmployee()">
                            <option ng-repeat="emp in employees" value="@{{emp.employee.id}}">@{{emp.employee.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Request To</label>
                    <div class="col-lg-3">
                        <select multiple="multiple"  class="form-control" ng-model="form.feedback_by">
                            <option ng-repeat="f in feedback_by" value="@{{f.employee.id}}">@{{f.employee.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Template</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.template">
                            <option ng-repeat="t in templates" value="@{{t.id}}">@{{t.title}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Year</label>
                    <div class="col-lg-3">
                        <select ng-model="year" class="form-control">
                            <option ng-repeat="y in years" value="@{{y}}">@{{y}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Send Request"/>
                        <input type="button" ng-click="closeFrm()" class="btn btn-warning btn-sm" value="Cancel"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default" ng-show="!showFrm">
        <div class="panel-heading">{{$page_title}}
            <a ng-click="openFrm()" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Create Request</a>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Requested To</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="l in lists">
                        <td>@{{l.employee.name}}</td>
                        <td>@{{l.department.name}}</td>
                        <td>@{{l.feedback_by.name}}</td>
                        <td>@{{l.status}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

@stop