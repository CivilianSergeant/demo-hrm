@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="department" ng-controller="departmentTrashCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
        <a href="{{url('department')}}" class="btn btn-primary btn-xs pull-right" ><i class="glyphicon glyphicon-list"></i> Active Items</a></div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr ng-repeat="d in lists">
                        <td>@{{d.name}}</td>
                        <td>
                            <a ng-click="retrive(d)" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-undo"></i> Undo</a>
                            <a ng-click="deletePermanently(d)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Delete Permanently</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@stop