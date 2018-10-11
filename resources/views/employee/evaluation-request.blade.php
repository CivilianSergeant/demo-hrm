@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="evaluation" ng-controller="eval-req-ctrl"  ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    <div class="panel panel-default" ng-show="showFrm">
        <div class="panel-heading">Review
        <a ng-click="closeFrm()" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
        </div> 
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveReview()">
                <div class="form-group">
                    <label class="control-label col-lg-3">Name</label>
                    <div class="col-lg-3">
                        <span>@{{evalreq.employee.name}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Department</label>
                    <div class="col-lg-3">
                        <span>@{{evalreq.department.name}}</span>
                    </div>
                </div>
                <div class="form-group" ng-show="!evalreq.rating">
                    
                    <div class="col-lg-12">
                        <h4>Please Review Following questions</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="q in questions">
                                    <td>@{{q.question}}</td>
                                    <td>
                                        <select class="form-control" ng-model="form.remark[q.id]">
                                            @for($i=1; $i<=10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Rating</label>
                    <div class="col-lg-3">
                        <span>@{{evalreq.rating}}</span>
                    </div>
                </div>
                <div class="form-group" ng-show="!evalreq.rating">
                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save"/>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}</div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <tr ng-repeat="l in lists">
                        <td>@{{l.employee.name}}</td>
                        <td>@{{l.department.name}}</td>
                        <td>@{{l.template.title}}</td>
                        <td>@{{l.status}}</td>
                        <td>@{{l.rating}}</td>
                        <td>
                            <a ng-click="openReview(l)" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-stats"></i> Review</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@stop