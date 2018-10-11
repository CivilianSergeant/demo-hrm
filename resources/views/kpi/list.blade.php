@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="kpi" ng-controller="kpiCtrl" ng-cloak>
    
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    <div class="panel panel-default">
        
        <div class="panel-heading">Create KPI</div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveQuestion()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Write Question</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" ng-model="form.question"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Key"/>
                        <input type="button" ng-click="cancel()" class="btn btn-warning btn-sm" value="Cancel"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="panel panel-default">
        <table class="table">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="k in kpi">
                    <td>@{{k.question}}</td>
                    <td>
                        <a ng-click="editQuestion(k)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a ng-click="deleteQuestion(k)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> 
    
</section>

@stop