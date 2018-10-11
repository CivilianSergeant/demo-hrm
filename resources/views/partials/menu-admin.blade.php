<aside class="col-lg-2" id="sidebar"> 
	<ul class="nav nav-stacked">
		<li role="presentation" ><a href="{{url('/')}}"><i class="glyphicon glyphicon-th-large"></i> Dashboard</a></li>
		<li role="presentation" >
			<a class="hasChild"><i class="glyphicon glyphicon-cog"></i>  System <span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub">
				<li><a href="{{url('org')}}">Organiztion</a></li>
				<li><a href="{{url('department')}}">Department</a></li>
				<li><a href="{{url('designation')}}">Designation</a></li>
				<li><a href="{{url('holiday')}}">Holiday</a></li>
				<li><a href="{{url('workweek')}}">Work Week</a></li>
				<li><a href="{{url('workshift')}}">Work Shift</a></li>
				<li><a href="{{url('settings')}}">Settings</a></li>
			</ul>
		</li>
		<li role="presentation" >
			<a class="hasChild"><i class="glyphicon glyphicon-user"></i> Users <span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub">
				<li><a href="{{url('role')}}">Role</a></li>
				<li><a href="{{url('users')}}">Users</a></li>
			</ul>
		</li>
		<li role="presentation">
			<a class="hasChild"><i class=" glyphicon glyphicon-check"></i> Employees<span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub">
				<li><a href="{{url('employee')}}">Employee</a></li>
				<li><a href="{{url('roster')}}">Schedule Roster</a></li>
			</ul>
		</li>
		<li role="presentation">
			<a class="hasChild"><i class="glyphicon glyphicon-new-window"></i> Leave <span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub"> 
				<li><a href="{{url('attendance')}}">Attendance</a></li>
				<li><a href="{{url('leave')}}">Leave</a></li>
			</ul>
		</li> 
		<li role="presentation">
			<a class="hasChild"><i class="glyphicon glyphicon-log-in"></i> Recruitment <span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub">
				<li><a href="{{url('candidate')}}">Candidate</a></li>
				<li><a href="{{url('vacancy')}}">Vacancy</a></li>
			</ul>
		</li>
		<li role="presentation">
			<a class="hasChild"><i class="glyphicon glyphicon-usd"></i> Payment <span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub">
				<li><a href="{{url('head')}}">Head</a></li>
				<li><a href="{{url('group')}}">Group</a></li>
				<li><a href="{{url('payroll')}}">Payroll</a></li>
			</ul>
		</li>
		<li role="presentation">
			<a class="hasChild"><i class="glyphicon glyphicon-stats"></i> Performance <span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub">
				<li><a href="{{url('kpi')}}">KPI</a></li>
				<li><a href="{{url('kpi-template')}}">Template</a></li>
				<li><a href="{{url('evaluation')}}">Evaluation</a></li>
			</ul>
		</li>
		<li role="presentation">
			<a class="hasChild"><i class="glyphicon glyphicon-paste"></i> Report <span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub">
				<li><a href="#">Attendance</a></li>
				<li><a href="#">Payment</a></li>
			</ul>
		</li>

	</ul>
</aside>