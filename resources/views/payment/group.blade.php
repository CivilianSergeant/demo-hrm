@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="group" ng-controller="groupCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default" ng-show="showFrm">
        <div class="panel-heading">Create Payment Group
            <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveGroup()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Title</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" ng-model="form.title"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Job Type</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.job_type">
                            <option ng-repeat="j in job_type" value="@{{j}}">@{{j}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="button" ng-click="getHeadByJobType()" class="btn btn-info btn-sm" value="Get Heads"/>
                    </div>
                </div>
                <div class="form-group">
                    
                    <div class="col-lg-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Head</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="h in heads">
                                    <td ng-init="form.head[h.id]=h">@{{h.head_name}}</td>
                                    <td>@{{h.head_type}}</td>
                                    <td><input type="text" class="form-control" ng-model="form.template[h.id]"/></td>
                                    <td><a ng-click="deleteHead($index)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                <div class="form-group" ng-show="(heads.length > 0) || (form.template != '')">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Group"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
            <a ng-click="openFrm()" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Add Payment Group</a>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Job Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="g in groups">
                        <td>@{{g.title}}</td>
                        <td>@{{g.job_type}}</td>
                        <td>
                            <a ng-click="editGroup(g)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a ng-click="deleteGroup(g)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@stop