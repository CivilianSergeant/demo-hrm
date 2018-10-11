@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="payroll" ng-controller="payrollCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
            
        </div>
        <div class="panel-body">
            <form novalidate class="form-horizontal" id="search">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Department</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="department_id" required>
                            <option ng-repeat="d in departments" ng-value="@{{d.id}}">@{{d.name}}</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-2">
                        <input type="submit" class="btn btn-success btn-sm" ng-click="getEmployee(department_id)" value="Load Employee"  />
                    </div>
                </div>
            </form>
            
            
               
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="e in employees">
                            <td>@{{e.employee.name}}</td>
                            <td>
                                <form action="{{url('payroll/view')}}" target="_blank" method="post">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                    <input type="hidden" name="employee" value="@{{e.employee_id}}"/>
                                    <input type="submit" class="btn btn-info btn-sm" value="View Payroll"/>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            
        </div>
    </div>
</section>
@stop