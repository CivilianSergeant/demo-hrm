@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="myattendance" ng-controller="myattendanceCtrl"  ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}</div>
        <div class="panel-body">
            <calander attendance="attendance"></calander>
        </div>
    </div>
</section>
@stop