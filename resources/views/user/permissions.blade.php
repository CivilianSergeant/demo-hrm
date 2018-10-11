@extends('template')


@section('content')
<script type="text/javascript">
    var role_id = "{{$role->id}}";
</script>
<section class="col-lg-10 col-lg-offset-2 content" ng-app="permission" ng-controller="permissionCtrl" ng-cloak>
    <ol class="breadcrumb">
       {!!$breadcrumb!!}
    </ol>
    @include('partials.alertmessage')
    <div class="panel panel-default">
		<div class="panel-heading">
			Add Permisssions - [Access Level {{$role->display_name}}]
		</div>
	
		<div class="panel-body">
			<form class="form-horizontal" ng-submit="savePermission()">
			    <table class="table">
			        <thead>
			            <tr>
			                <th>Module</th>
			                <th>Select Permission</th>
			            </tr>
			        </thead>
			        <tbody>
			                <tr ng-repeat="route in permissions">
			                    <td>@{{route.display_name}}</td>
			                    <td><input type="checkbox" ng-model="permission_role[route.path].checked" ng-change="setPermission(route.path)" ng-checked="permission_role[route.path].checked" class="form-control" /></td>
			                </tr>
			        </tbody>
			    </table>
			    <input type="submit"  class="btn btn-success btn-sm" value="Save" scroll-on-click/>
		    </form>
	    </div>
    </div>
</section>
@stop