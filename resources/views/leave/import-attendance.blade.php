@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    
    @if(!count($file_columns))
    <div class="panel panel-default">
        
        <div class="panel-heading">{{$page_title}}</div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{url('attendance/save-import-attendance')}}" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <div class="form-group">
                    <label class="control-label col-lg-3">Browse</label>
                    <div class="col-lg-3">
                        <input type="file" name="attendance"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Import"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="">
        <form class="form-horizontal" action="{{url('attendance/save-import-attendance')}}" mehtod="post">
            
            <div class="col-lg-5 panel panel-default">
                <table class="table">
                    <thead>
                        <tr>
                            <th>File Columns</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($file_columns))
                            @foreach($file_columns as $file_column)
                                <tr>
                                    <td>
                                        <select class="form-control">
                                            @foreach($file_columns as $file_column)
                                            <option value="{{$file_column}}">{{$file_column}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>                
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-5 panel panel-default">
                <table class="table">
                    <thead>
                        <tr>
                            <th>System Column</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($system_columns))
                            @foreach($file_columns as $file_column)
                            <tr>
                                <td>
                                    <select class="form-control">
                                        @foreach($system_columns as $col)
                                            @if(in_array($col,$system_col_filter))
                                                <option value="{{$col}}">{{$col}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="from-group">
                <input type="submit" class="btn btn-success btn-sm" value="Save"/>
            </div>
        </form>
    </div>
    @endif
</section>
@stop