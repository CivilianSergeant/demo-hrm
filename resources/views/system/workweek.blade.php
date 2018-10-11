@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="workweek" ng-controller="workweekCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}</div>
        <div class="panel-body">
            <form class="form-horzontal" ng-submit="saveWorkWeek()">
            <div class="form-group">
                <ul class="nav">
                    <li ng-repeat="day in days">
                        <label class="control-label col-lg-3">@{{day}}</label>
                        <div class="col-lg-3">
                            <select class="form-control" ng-model="form[day]">
                                    <option ng-if="workweeks[day] == status" selected="selected" ng-repeat="status in statuses" value="@{{status}}">@{{status}}</option>
                                    <option ng-if="workweeks[day] != status" ng-repeat="status in statuses" value="@{{status}}">@{{status}}</option>
                            </select>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="form-group">
                <div class="col-lg-3">
                    <input type="submit" class="btn btn-success btn-sm" value="Save"/>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>
@stop