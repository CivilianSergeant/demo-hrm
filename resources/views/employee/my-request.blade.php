@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app=""  ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}</div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Requested By</th>
                        <th>Approver</th>
                        <th>Leave Start From</th>
                        <th>Leave End</th>
                        <th>Leave Count</th>
                        <th>Leave Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @if(count($leave_requests))
                        @foreach($leave_requests as $leave)
                            <tr>
                                <td>{{$leave->leave_type}}</td>
                                <td>{{$leave->Employee->name}}</td>
                                <td>{{$leave->LeaveVerifier->name}}</td>
                                <td>{{$leave->start_dt}}</td>
                                <td>{{$leave->end_dt}}</td>
                                <td>{{$leave->leave_count}}</td>
                                <td>{{$leave->leave_status}}</td>
                                
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section
@stop