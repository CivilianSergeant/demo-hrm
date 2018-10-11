@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="designation" ng-controller="designationCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	</div>
	<div class="panel panel-default" ng-show="showForm">
	    <div class="panel-heading">@{{(form.id)? 'Edit' : 'Create' }} Designation
	    <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i> </a>
	    </div>
	    <div class="panel-body">
	        <form class="form-horizontal" ng-submit="saveDesignation()">
	            <div class="col-lg-3">
	                <h4>Departments</h4>
	                <script type="text/ng-template" id="categoryTree">
                        <div class="clearfix">
                            <input class="pull-left list-inline" type="checkbox" ng-checked="parent_department.indexOf(depart.id) > -1"  ng-click="setDepartment(depart)" /> 
                            <a class="pull-left nopadding" >@{{depart.name}}</a>
                        </div>
                        <ul class="nav sub-level-1" ng-if="depart.child_department">
                            <li ng-repeat="depart in depart.child_department" ng-include="'categoryTree'">           
                            </li>
                        </ul>
                    </script>
                    <ul class="nav">
                        <li ng-repeat="depart in departments" ng-include="'categoryTree'"></li>
                    </ul>
                    <h4>Designation</h4>
                   
                    <script type="text/ng-template" id="designationTree">
                        <div class="clearfix">
                            <input class="pull-left list-inline" type="checkbox" ng-checked="parent_designation.indexOf(designation.id) > -1"  ng-click="setDesignation(designation)" /> 
                            <a class="pull-left nopadding" >@{{designation.title}}</a>
                        </div>
                        <ul class="nav sub-level-1" ng-if="designation.child_designation">
                            <li ng-repeat="designation in designation.child_designation" ng-include="'designationTree'">           
                            </li>
                        </ul>
                    </script>
                    <ul class="nav">
                        <li ng-repeat="designation in designationstree" ng-include="'designationTree'"></li>
                    </ul>
	            </div>
	            <div class="col-lg-9">
	            <div class="form-group">
	                <label class="control-label col-lg-3">Title</label>
	                <div class="col-lg-3">
	                    <input type="text" name="title" class="form-control" ng-model="form.title" />
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-lg-3">Quota</label>
	                <div class="col-lg-3">
	                    <input type="text" name="quota" class="form-control" ng-model="form.quota" />
                    </div>
	            </div>
	            <div class="form-group">
	                <label class="control-label col-lg-3">Description</label>
	                <div class="col-lg-6">
	                    <textarea rows="3" name="description" class="form-control" ng-model="form.description"></textarea>
                    </div>
	            </div>
	            <div class="form-group">
	                <div class="col-lg-3 col-lg-offset-3">
	                    <input type="submit" class="btn btn-success btn-sm" value="Save"/>
	                    <input type="button" ng-click="closeFrm()" class="btn btn-warning btn-sm" value="Cancel"/>
	                </div>
	            </div>
	            </div>
	        </form>
	    </div>
	</div>
	<div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
            <button class="btn btn-primary btn-xs pull-right" ng-show="!showForm" ng-click="openFrm()"><i class="glyphicon glyphicon-plus"></i> New Designation</button> 
            
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Quota</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="d in designations">
                        <td>@{{d.title}}</td>
                        <td>@{{d.department.name}}</td>
                        <td>@{{d.quota}}</td>
                        <td>
                            <button title="Edit" class="btn btn-info btn-xs" ng-click="editDesignation(d)"><i class="glyphicon glyphicon-pencil"></i></button>
                            <button title="Delete" class="btn btn-danger btn-xs" ng-click="deleteDesignation(d)"><i class="glyphicon glyphicon-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@stop