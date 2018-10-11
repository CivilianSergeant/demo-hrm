@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="department" ng-controller="departmentCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
        <a href="{{url('department/trash')}}" class="btn btn-danger btn-xs pull-right" ><i class="glyphicon glyphicon-list"></i> Deleted Items</a></div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveDepartment()">
                <div class="col-lg-2 vertical-seperator-right">
                    
                    <script type="text/ng-template" id="categoryTree">
                        <div class="clearfix">
                            <input class="pull-left list-inline" type="checkbox" ng-checked="parent_department == depart.id" ng-model="depart.parent_department" ng-change="setParent(depart)" /> 
                            <a class="pull-left nopadding" ng-click="selectDepartment(depart)" >@{{depart.name}}</a>
                        </div>
                        <ul class="nav sub-level-1" ng-if="depart.child_department">
                            <li ng-repeat="depart in depart.child_department" ng-include="'categoryTree'">           
                            </li>
                        </ul>
                    </script>
                    <ul class="nav">
                        <li ng-repeat="depart in departments" ng-include="'categoryTree'"></li>
                    </ul>
                </div>
                <div class="col-lg-10 ">
                    <input type="button" ng-click="deleteDepartment()" ng-show="selectedItemId" class="btn btn-danger btn-sm pull-right" value="Delete Department"/>
                    <div class="form-group">
                        
                        <label class="control-label col-lg-3">Department Name</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" ng-model="department.name" name="name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-lg-offset-3">
                            
                            <input type="submit" class="btn btn-success btn-sm" value="save"/>
                            <input type="button" ng-click="cancelUpdate()" ng-show="selectedItemId" class="btn btn-warning btn-sm" value="Cancel"/>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</section>

@stop