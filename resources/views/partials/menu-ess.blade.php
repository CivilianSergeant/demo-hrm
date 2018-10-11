<aside class="col-lg-2" id="sidebar"> 
	<ul class="nav nav-stacked">
		<li role="presentation" ><a href="{{url('/')}}"><i class="glyphicon glyphicon-th-large"></i> Dashboard</a></li>
		<li role="presentation"><a href="{{url('profile')}}"><i class="glyphicon glyphicon-user"></i> Profile</a></li>
		<li role="presentation">
			<a class="hasChild"><i class="glyphicon glyphicon-ok"></i> Attendance <span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub"> 
				<li><a href="{{url('attendance')}}"> Attendance</a></li>
				<li><a href="{{url('attendance/me')}}">My Attendance</a></li>
			</ul>
		</li> 
		<li role="presentation">
		    <a class="hasChild"><i class="glyphicon glyphicon-new-window"></i> Leave <span class="pull-right right-caret"></span></a>
		    <ul class="nav nav-sub">
		        <li><a href="{{url('leave')}}">Apply Leave Request</a></li>
				<li><a href="{{url('leave-request/me')}}">My Leave Request</a></li>
		    </ul>
		</li>
		
		<li role="presentation">
			<a class="hasChild"><i class="glyphicon glyphicon-usd"></i> Payment <span class="pull-right right-caret"></span></a>
			<ul class="nav nav-sub">
				<li><a href="{{url('payment/history')}}">Payment History</a></li>
			</ul>
		</li>
	</ul>
</aside>