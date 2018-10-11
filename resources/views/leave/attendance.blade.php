@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="attendance" ng-controller="attendanceCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    <div class="panel panel-default" ng-show="showFrm">
        
        <!-- Create Form -->
        
            <div class="panel-heading">Enter Attendance
                <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i> </a>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" ng-submit="saveAttendance()">
                    <div class="form-group">
                        <label class="control-label col-lg-3">Date</label>
                        <div class="col-lg-3">
                            <input type="text" name="date" ng-model="form.date" ng-change="dateChange()" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Employee</label>
                        <div class="col-lg-3">
                            
                            <select ng-model="form.employee_id" ng-change="getTodayShift()" class="form-control">
                                <option value="">--SELECT--</option>
                                <option ng-repeat="e in employees" value="@{{e.id}}">@{{e.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" ng-show="form.shift">
                        <label class="control-label col-lg-3">Workshift & Time</label>
                        <div class="col-lg-3">
                            @{{getTime(form.shift.work_shift.start_time) | date:'shortTime'}}-@{{getTime(form.shift.work_shift.end_time) |  date:'shortTime'}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Start Time</label>
                        <div class="col-lg-3">
                            <timepicker ng-model="form.start_time" hour-step="hstep" minute-step="mstep" show-meridian="!ismeridian"></timepicker>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">End Time</label>
                        <div class="col-lg-3">
                            <timepicker ng-model="form.end_time" hour-step="hstep" minute-step="mstep" show-meridian="!ismeridian"></timepicker>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-3 col-lg-offset-3">
                            <input type="submit" class="btn btn-success btn-sm" value="Save Attendance"/>
                        </div>
                    </div>
                </form>
            </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}} 
        @if(strtolower(Auth::user()->Role->name) == "admin")
        <a href="{{url('attendance/import')}}" class="btn btn-success btn-xs pull-right" style="margin-left:10px;"><i class="glyphicon glyphicon-upload"></i> Import Attendance</a>
        @endif
        <a ng-click="openFrm()" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Add Attendance</a>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee</th>
                        <th>Work Shift</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Working Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="attendance in attendances">
                        <td>@{{attendance.date}}</td>
                        <td>@{{attendance.employee.name}}</td>
                        <td>@{{attendance.work_shift.shift_name}}</td>
                        <td>@{{attendance.in_time | date:'shortTime'}}</td>
                        <td>@{{attendance.out_time | date:'shortTime'}}</td>
                        <td>@{{attendance.working_time}}</td>
                        <td>
                            <a ng-click="editAttendance(attendance)" class="btn btn-info btn-xs" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</section>

@stop