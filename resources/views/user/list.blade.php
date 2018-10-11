@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="users" ng-controller="userCtrl" ng-cloak>
    <ol class="breadcrumb">
        {!!$breadcrumb!!}
    </ol>
    @include('partials.alertmessage')
    <div class="panel panel-default" ng-if="showForm">
		<div class="panel-heading" ng-show="!selectedUserId">
			Add New User
			<a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
		</div>
		<div class="panel-heading" ng-show="selectedUserId">
			Edit User
			<a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" ng-submit="saveUser()" id="createUserFrm">
				<div class="form-group">
					<label class="control-label col-lg-3">Name</label>
					<div class="col-lg-6">
						<input type="text" ng-model="userForm.name" class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-3">E-mail</label>
					<div class="col-lg-6">
						<input type="text" ng-model="userForm.email" class="form-control"/>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-lg-3">User Role</label>
					<div class="col-lg-3">
						<select name="role_id" class="form-control" ng-model="userForm.role_id">
							@if(count($roles))
								@foreach($roles as $role)
									<option value="{{$role->id}}">{{$role->display_name}}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="control-label col-lg-3">Password</label>
					<div class="col-lg-3">
						<input type="password" ng-model="userForm.password" class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-3 col-lg-offset-3">
						<input type="submit" ng-show="!selectedUserId" class="btn btn-success btn-sm" value="Save"/>
						<input type="submit" ng-show="selectedUserId" class="btn btn-success btn-sm" value="Update"/>
						<input type="button" ng-click="closeFrm()" class="btn btn-warning btn-sm" value="Cancel"/>
					</div>

				</div>
			</form>
		</div>
	</div>
    <div class="panel panel-default">
        <div class="panel-heading">
            {{$page_title}}
            <span class="pull-right"><a ng-click="showCreateUserFrm()" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-plus"></i> Add New User</a></span>
        </div>
        <div class="panel-body">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                        <th>E-mail</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="user in users">
                        <td><a title="Edit User @{{user.name}}" ng-click="editUser(user)">@{{user.name}}</a></td>
                        <td>@{{user.role.display_name}}</td>
                        <td>@{{user.email}}</td>
                        <td>
                        	<a title="Delete" ng-click="deleteUser(user)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                    	</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</section>

@stop