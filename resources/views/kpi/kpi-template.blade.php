@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="kpi" ng-controller="kpiTemplateCtrl" ng-cloak>
    
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
     
    <div class="panel panel-default" ng-show="showFrm">
        
        <div class="panel-heading">Create KPI Template</div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveTemplate()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Title</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" ng-model="form.title" />
                    </div>
                </div>
                <div class="form-group">
                   
                    <div class="col-lg-12">
                        <h4>Select Key</h4>
                        <table class="table">
                            <tbody>
                                <tr ng-repeat="k in kpi">
                                    <td><input type="checkbox" ng-checked="form.template.indexOf(k.id) != -1" ng-model="form.template[$index]" ng-true-value="@{{k.id}}" ng-false-value="null"/></td>
                                    <td>@{{k.question}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Template"/>
                        <input type="button" ng-click="cancelFrm()" class="btn btn-warning btn-sm" value="Cancel"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
   
    <div class="panel panel-default" ng-show="!showFrm">
        <div class="panel-heading">{{$page_title}}
            <a ng-click="openFrm()" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i> Add Template</a>
        </div>
        
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="t in templates">
                        <td>@{{t.title}}</td>
                        <td>
                            <a ng-click="editTemplate(t)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@stop