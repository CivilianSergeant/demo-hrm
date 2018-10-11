<!DOCTYPE html>
<html>
	<head>
		<title>Open Hrm</title>
		<link rel="stylesheet" href="{{url('public/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" type="text/css" />
		<link rel="stylesheet" href="{{url('public/css/style.css')}}" type="text/css" />
		
	</head>
	<body>
		<header>
		
			<nav class="navbar navbar-default navbar-fixed-top">
				<div class="collapse navbar-collapse">
					<div class="container-fluid">
						<div class="navbar-header">
							
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle Navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							
							<div class="navbar-brand">
								<a href="#">Open HRM</a>
							</div>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<div class="btn-group pull-right">
							
							
							<button type="button" class="btn btn-default navbar-btn dropdown-toogle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-user"></span> Username 
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu top-popup" role="menu">
							    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><span class="glyphicon glyphicon-lock"></span> Change Password</a></li>
							    <li role="presentation"><a role="menuitem" href="#" tabindex="-1"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
							    <li role="presentation" class="divider"></li>
							    <li role="presentation"><a role="menuitem" href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						    </ul>
						</div>
						</div>
					</div>
				</div>
			</nav>
		</header>
		
		
			<aside class="col-lg-2" id="sidebar"> 
				<ul class="nav nav-stacked">
					<li role="presentation" ><a  href="#">Dashboard</a></li>
					<li role="presentation" >
						<a class="selected hasChild" href="#">Organization <span class="pull-right right-caret"></span></a>
						<ul class="nav nav-sub">
							<li><a href="#">Create</a></li>
						</ul>
					</li>
		
				</ul>
			</aside>
			<section class="col-lg-10 content">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li><a href="#">Library</a></li>
				  <li class="active">Data</li>
				</ol>
				<div class="panel panel-default">
			      <div class="panel-heading">
			      	Panel Header
			      </div>
				  <div class="panel-body">
				    Panel content
				  </div>
				  <div class="panel-footer">Panel footer</div>
				</div>
			</section>
		
		
		<script type="text/javascript" src="{{url('public/bower_components/jquery/dist/jquery.min.js')}}"></script>
		<script type="text/javascript" src="{{url('public/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
		<script type="text/javascript" src="{{url('public/js/common.js')}}"></script>
	</body>
</html>