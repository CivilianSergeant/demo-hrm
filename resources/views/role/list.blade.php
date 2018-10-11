@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="RoleApp" ng-controller="RoleController" ng-cloak>
	<ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default" ng-if="showForm">
		<div class="panel-heading">Add New Role</div>
		<div class="panel-body">
			<form class="form-horizontal" ng-submit="saveRole()" method="post" id="createRoleFrm">
				<div class="form-group">
					<label class="control-label col-lg-3">Role name</label>
					<div class="col-lg-9">
						<input type="text" ng-model="form.name" class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">Role Description</label>
					<div class="col-lg-9">
						<textarea type="text" maxlength="255" ng-model="form.description" class="form-control"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-3 col-lg-offset-3">
						<input type="submit" class="btn btn-success btn-sm" value="Save"/>
						<input type="button" ng-click="cancelFrm()" class="btn btn-warning btn-sm" value="Cancel"/>
					</div>

				</div>
			</form>
		</div>
	</div>
	<div class="panel panel-default">
      <div class="panel-heading">
      	{{$page_title}}
      	<span class="pull-right">
      		<a ng-click="showCreateRoleFrm()" ng-if="!showForm" class="btn btn-xs btn-primary">Add Role</a>
      	</span>
      </div>
	  <div class="panel-body">
	    	<table class="table table-striped">
	    		<thead>
	    			<tr>
	    				<th>Sl No.</th>
	    				<th>Role Name</th>
	    				<th>Description</th>
	    				<!--<th>Action</th>-->
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr ng-repeat="role in roles">
	    				<td>@{{($index+1)}}</td>
	    				<td>@{{role.display_name}}</td>
	    				<td>@{{role.description}}</td>
	    				<!--<td><a title="Settings" href="{{url('permissions')}}/@{{role.id}}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i></a></td>-->
	    			</tr>
	    		</tbody>
	    	</table>
	  </div>
	  <div class="panel-footer"></div>
	</div>
</section>
@stop