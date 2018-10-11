@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="holiday" ng-controller="holidayCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default" ng-show="showFrm">
        <div class="panel-heading">@{{(form.id)? 'Edit': 'Create'}} Holiday
        <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveHoliday()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Holiday Name</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" ng-model="form.name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Holiday Date</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="holiday_date" ng-model="form.holiday_date" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Recurring</label>
                    <div class="col-lg-1">
                        <input type="checkbox" class="form-control"  ng-checked="recurring == true" ng-model="recurring" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Holiday"/>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
            <a ng-click="openFrm()" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Add Holiday</a>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label col-lg-2">Search By Year</label>
                <div class="col-lg-2">
                    <select ng-model="searchYear" class="form-control" ng-change="changeYear()">
                        <option ng-repeat="y in years" value="@{{y}}">@{{y}}</option>
                    </select>
                </div>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Hoiday Name</th>
                        <th>Holiday Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="h in holidays">
                        <td>@{{h.name}}</th>
                        <td ng-if="searchYear!=null">@{{h.holiday_date | selectedYear:searchYear}}</td>
                        <td ng-if="searchYear==null">@{{h.holiday_date}}</td>
                        <td>
                            <a ng-click="editHoliday(h)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-search"></i> View</a>
                            <a ng-click="deleteHoliday(h)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

@stop