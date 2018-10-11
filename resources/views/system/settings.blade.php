@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="settings" ng-controller="settingsCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    
    <div class="panel panel-default">
        
        <div class="panel-heading">{{$page_title}}</div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li role="presentation" ng-class="{active:formTab.attendance}"><a ng-click="selectFormTab('attendance')">Attendance</a></li>
                <li role="presentation" ng-class="{active:formTab.leave}"><a ng-click="selectFormTab('leave')">Leave</a></li>
                
            </ul>
            <div style="margin-top:10px;">
                <form class="form-horizontal" ng-show="formTab.attendance" ng-submit="saveAttendanceSettings()">
                   <div class="form-group">
                        <label class="control-label col-lg-3">Late time count after</label>
                        <div class="col-lg-1">
                            <input type="text" ng-model="attendance.late_in" class="form-control"/> 
                        </div>
                        <span class="col-lg-1">Min</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Salary deduct after</label>
                        <div class="col-lg-1">
                            <input type="text" ng-model="attendance.absent" class="form-control"/> 
                        </div>
                        <span class="col-lg-3">consecutive days for late In</span>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-lg-offset-3">
                            <input type="submit" class="btn btn-success btn-sm" value="Save"/>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" ng-show="formTab.leave" ng-submit="saveLeaveSettings()">
                    <div class="form-group">
                        <label class="control-label col-lg-3">Deduct salary for extra leave</label>
                        <div class="col-lg-3">
                            <input type="checkbox" ng-model="leave.deduct_salary" ng-true-value="'1'" ng-false-value="'0'"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Leave Type</label>
                        <div class="col-lg-3" >
                            <textarea  ng-model="leave.leave_type"></textarea>
                        </div>
                        <small>Use (,) comma as seperator between values</small>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-lg-offset-3">
                            <input type="submit" class="btn btn-success btn-sm" value="Save"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop