@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="candidate" ng-controller="candidateCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default" ng-show="showFrm">
        <div class="panel-heading">Create Candidate
        <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveCandidate()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Name</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" ng-model="form.name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">E-mail</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" ng-model="form.email"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Phone</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" ng-model="form.phone"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Select Vacancy</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.vacancy">
                            <option ng-repeat="v in vacancies" value="@{{v.id}}">@{{v.vacancy_name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Keyword</label>
                    <div class="col-lg-3">
                        <textarea ng-model="form.keyword" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Description</label>
                    <div class="col-lg-6">
                        <textarea ng-model="form.description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Select Source</label>
                    <div class="col-lg-3">
                        <select class="form-control" ng-model="form.source">
                            <option ng-repeat="s in sources" value="@{{s}}">@{{s}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" ng-show="form.id">
                    <label class="control-label col-lg-3">Status</label>
                    <div class="col-lg-3">
                        <span>@{{form.status}}</span>
                        <select class="form-control" ng-model="form.status">
                            <option ng-repeat="s in status" value="@{{s}}">@{{s}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Referer Name</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" ng-model="form.referer"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Candidate" />
                    </div>
                </div>
            </form>
            
            <div class="panel panel-default" ng-show="histories.length>0">
                <div class="panel-heading">
                    Candidate status history
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="h in histories">
                            <td>@{{h.status}}</td>
                            <td>@{{h.created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
            <a ng-click="openFrm()" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Add Candidate</a>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Vacancy</th>
                        <th>Candidate Name</th>
                        <th>Hiring Manager</th>
                        <th>Application Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="candidate in candidates">
                        <td>@{{candidate.vacancy.vacancy_name}}</td>
                        <td>@{{candidate.name}}</td>
                        <td>@{{candidate.vacancy.hiring_manager.name}}</td>
                        <td>@{{candidate.application_dt}}</td>
                        <td>@{{candidate.status}}</td>
                        <td>
                            <a ng-click="editCandidate(candidate)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a ng-click="deleteCandidate(candidate)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</section>

@stop