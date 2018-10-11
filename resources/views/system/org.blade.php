@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="orgApp" ng-controller="orgCtrl" ng-cloak>
	<ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	
	<div class="panel panel-default">
	    <div class="panel-heading">{{$page_title}}</div>
		<div class="panel-body">
	    <form class="form-horizontal" ng-submit="updateOrg()">
	        <div class="form-group">
	            <label class="control-label col-lg-3">Orgnization Name</label>
	            <div class="col-lg-6">
	                <input type="text" class="form-control" ng-model="org.title" name="title"/>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-lg-3">Orgnization Phone</label>
	            <div class="col-lg-6">
	                <input type="text" class="form-control" ng-model="org.phone" name="phone"/>
	            </div>
	        </div>
	        
	        <div class="form-group">
	            <label class="control-label col-lg-3">Orgnization Fax</label>
	            <div class="col-lg-6">
	                <input type="text" class="form-control" ng-model="org.fax" name="fax"/>
	            </div>
	        </div>
	        
	        <div class="form-group">
	            <label class="control-label col-lg-3">Contact E-mail</label>
	            <div class="col-lg-6">
	                <input type="text" class="form-control" ng-model="org.email" name="email"/>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-lg-3">Address</label>
	            <div class="col-lg-6">
	                <textarea class="form-control" name="address" ng-model="org.address"></textarea>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-lg-3">Country</label>
	            <div class="col-lg-6">
	                <input type="text" class="form-control" name="country" ng-model="org.country"/>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-lg-3">City</label>
	            <div class="col-lg-6">
	                <input type="text" class="form-control" name="city" ng-model="org.city"/>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-lg-3">State</label>
	            <div class="col-lg-6">
	                <input type="text" class="form-control" name="state" ng-model="org.state"/>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-lg-3">Postcode</label>
	            <div class="col-lg-6">
	                <input type="text" class="form-control" name="postcode" ng-model="org.postcode"/>
	            </div>
	        </div>
	        <div class="form-group">
	            <div class="col-lg-3 col-lg-offset-3">
	                <input type="submit" class="btn btn-success btn-sm" value="Update"/>
	            </div>
            </div>
            
	    </form>
	    </div>
	    
    </div>
</section>

@stop