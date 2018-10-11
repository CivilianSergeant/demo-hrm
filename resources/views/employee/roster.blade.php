@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="roster" ng-controller="rosterCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    <div class="panel panel-default">
        
        

            <div class="panel-heading">Schedule Roster</div>
            <div class="panel-body">
                <schedule-roster title="'Himel'" ></schedule-roster>
            </div>
        
    </div>
</section>
@stop