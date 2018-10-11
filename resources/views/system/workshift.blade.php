@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="workshift" ng-controller="workshiftCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default" ng-show="showFrm">
        <div class="panel-heading">@{{(form.id)? 'Edit':'Create'}} Work shift
        <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveWorkShift()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Shift Name</label>
                    <div class="col-lg-3">
                        <input type="text" ng-model="form.shift_name" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Start Time</label>
                    <div class="col-lg-2">
                        <timepicker ng-model="startTime" hour-step="hstep" minute-step="mstep" show-meridian="!ismeridian"></timepicker>
                        
                    </div>
                    <div class="col-lg-3">Shift Start Time @{{startTime | date:'shortTime' }}</div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">End Time</label>
                    <div class="col-lg-2">
                        <timepicker ng-model="endTime" hour-step="hstep" minute-step="mstep" show-meridian="!ismeridian"></timepicker>
                        
                    </div>
                    <div class="col-lg-3">Shift Start Time @{{endTime | date:'shortTime' }}</div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Work shift"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
            <a class="btn btn-primary btn-xs pull-right" ng-show="!showFrm" ng-click="openFrm()"><i class="glyphicon glyphicon-plus"></i> Add Work Shift</a>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Shift Name</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="shift in workshifts">
                        <td>@{{shift.shift_name}}</td>
                        <td>@{{shift.start_time | date:'shortTime'}}</td>
                        <td>@{{shift.end_time | date:'shortTime'}}</td>
                        <td>
                            <a ng-click="editShift(shift)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a ng-click="deleteShift(shift)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                            </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

@stop