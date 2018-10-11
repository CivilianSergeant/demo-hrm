@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="vacancy" ng-controller="vacancyCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default" ng-show="showFrm">
        <div class="panel-heading">Create Vacancy
        <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveVacancy()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Select department</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.department" ng-change="getDesignations()">
                            <option ng-repeat="department in departments" value="@{{department.id}}">@{{department.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Select Designation</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.designation">
                            <option ng-repeat="designation in designations" value="@{{designation.id}}">@{{designation.title}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Vacancy Title</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" ng-model="form.title"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Hiriing Manager</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.hiring_manager">
                            <option ng-repeat="hm in hiring_managers" value="@{{hm.employee_id}}">@{{hm.employee.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Number of Position</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" ng-model="form.position" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Description</label>
                    <div class="col-lg-3">
                        <textarea ng-model="form.description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">publish on website</label>
                    <div class="col-lg-1">
                        <input type="checkbox" ng-model="form.publish" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Vacancy"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            {{$page_title}}
            <a ng-click="openFrm()" ng-show="!showFrm" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Add Vacancy</a>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Vacancy Title</th>
                        <th>Designation</th>
                        <th>Hiring Manager</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="vacancy in vacancies">
                        <td>@{{vacancy.vacancy_name}}</td>
                        <td>@{{vacancy.designation.title}}</td>
                        <td>@{{vacancy.hiring_manager.name}}</td>
                        <td>@{{(vacancy.vacancy_status==1)? 'Active' : 'Inactive'}}</td>
                        <td>
                            <a class="btn btn-info btn-xs" ng-click="editVacancy(vacancy)"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a class="btn btn-danger btn-xs" ng-click="removeVacancy(vacancy)"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            
        </div>
    </div>
    
   
</section>
@stop