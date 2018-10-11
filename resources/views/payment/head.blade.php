@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="head" ng-controller="headCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default" ng-show="showFrm">
        <div class="panel-heading">Create Payment Head
        <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveHead()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Head Name</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" ng-model="form.head_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Parent Head</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.parent_head">@{{form.parent_head}}
                            <option ng-repeat="h in parent_head" ng-selected="form.parent_head != null && h.id == form.parent_head" value="@{{h.id}}">@{{h.head_name}}-@{{h.job_type}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Job Type</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.job_type">
                            <option ng-repeat="j in job_type" ng-selected="j == form.job_type" value="@{{j}}">@{{j}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Head Type</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.head_type">
                            <option ng-repeat="h in head_type" ng-selected="h == form.head_type" value="@{{h}}">@{{h}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Head"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            {{$page_title}}  
            <a ng-click="openFrm()" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Add New Product</a>
        </div>
        <div class="panel-body">
            <div class="col-lg-3">
                <input type="text" placeholder="Search Here" class="form-control" ng-model="se"/>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th><a ng-click="toggleSort('head_name')">Head Name</a></th>
                        <th>Parent Head</th>
                        <th>Head Type</th>
                        <th><a ng-click="toggleSort('job_type')">Job Type</a></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="head in heads | filter:se | orderBy:sortorder">
                        <td>@{{head.head_name}}</td>
                        <td>@{{(head.parent_head.head_name != undefined)? head.parent_head.head_name : 'Parent'}}</td>
                        <td>@{{head.head_type}}</td>
                        <td>@{{head.job_type}}</td>
                        <td>
                            <a ng-click="editHead(head)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a ng-click="deleteHead(head)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@stop