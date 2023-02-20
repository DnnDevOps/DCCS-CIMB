@extends('layouts.page')

@section('styles')
	{!! Html::style('css/dashboard.css') !!}
@endsection

@section('scripts')
	{!! Html::script('js/main.js') !!}
@endsection

@section('layout')
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/admin">
					<strong>DCCS Admin</strong> <sup>{{ Config::get('constant.version') }}</sup>
				</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="{{ asset('manual.pdf') }}"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
					@can('manage-settings')
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-cog"></i> Settings <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{{ url('/admin') }}"><i class="glyphicon glyphicon-king"></i> Daftar Admin</a></li>
								<li><a href="{{ url('/role') }}"><i class="glyphicon glyphicon-flag"></i> Daftar Role</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="{{ url('/permission') }}"><i class="glyphicon glyphicon-th"></i> Matriks Hak Akses</a></li>
							</ul>
						</li>
					@endcan
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<p class="navbar-text">
							<strong>{{ \Auth::user()->fullname }}</strong>
						</p>
					</li>
					<li><a href="{{ url('/password') }}"><i class="glyphicon glyphicon-lock"></i> Ganti Password</a></li>
					<li><a href="{{ url('/logout') }}"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
				</ul>
				
			</div>
		</div>
	</nav>
	
    <div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<ul class="nav nav-sidebar">
					@can('show-users')
						<li><a href="{{ url('/user') }}"><i class="glyphicon glyphicon-user"></i> Daftar User</a></li>
					@endcan
					@can('upload-users')
						<li><a href="{{ url('/user/upload') }}"><i class="glyphicon glyphicon-import"></i> Upload Daftar User</a></li>
					@endcan
					@can('show-groups')
						<li><a href="{{ url('/group') }}"><i class="glyphicon glyphicon-user"></i> Daftar Group</a></li>
					@endcan
					@can('upload-groups')
						<li><a href="{{ url('/group/upload') }}"><i class="glyphicon glyphicon-import"></i> Upload Anggota Group</a></li>
					@endcan
				</ul>
				<ul class="nav nav-sidebar">
					@can('show-statuses')
						<li><a href="{{ url('/status') }}"><i class="glyphicon glyphicon-tags"></i> Daftar Status</a></li>
					@endcan
					@can('show-dispositions')
						<li><a href="{{ url('/disposition') }}"><i class="glyphicon glyphicon-check"></i> Daftar Disposition</a></li>
					@endcan
					@can('show-campaigns')
						<li><a href="{{ url('/campaign') }}"><i class="glyphicon glyphicon-briefcase"></i> Daftar Campaign</a></li>
					@endcan
				</ul>
				<ul class="nav nav-sidebar">
					@can('show-context')
						<li><a href="{{ url('/context') }}"><i class="glyphicon glyphicon-transfer"></i> Daftar Context</a></li>
					@endcan
					@can('show-trunk')
						<li><a href="{{ url('/trunk') }}"><i class="glyphicon glyphicon-earphone"></i> Daftar Trunk</a></li>
					@endcan
					@can('show-peer')
						<li><a href="{{ url('/peer') }}"><i class="glyphicon glyphicon-headphones"></i> Daftar Peer</a></li>
					@endcan
					@can('generate-peer')
						<li><a href="{{ url('/peer/generate') }}"><i class="glyphicon glyphicon-flash"></i> Generate Daftar Peer</a></li>
					@endcan
					@can('show-queue')
						<li><a href="{{ url('/queue') }}"><i class="glyphicon glyphicon-sort-by-order"></i> Daftar Queue</a></li>
					@endcan
				</ul>
				<ul class="nav nav-sidebar">
					@can('show-session-report')
						<li><a href="{{ url('/report/session') }}"><i class="glyphicon glyphicon-list"></i> Report Session</a></li>
					@endcan
					@can('show-status-report')
						<li><a href="{{ url('/report/status') }}"><i class="glyphicon glyphicon-list"></i> Report Status</a></li>
					@endcan
					@can('show-call-log')
						<li><a href="{{ url('/report/call') }}"><i class="glyphicon glyphicon-list"></i> Report Telepon</a></li>
					@endcan
					@can('show-favorite-report')
						<li><a href="{{ url('/report/favorite') }}"><i class="glyphicon glyphicon-list"></i> Report Favorite Number</a></li>
					@endcan
					@can('show-chat-log')
						<li><a href="{{ url('/report/chat') }}"><i class="glyphicon glyphicon-list"></i> Report Chat History</a></li>
					@endcan
				</ul>
			</div>
			
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				@section('title', 'DNN Call Center Suite Administration')

				<h3 class="page-header">@yield('title')</h3>
                
			    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
				@yield('content')
			</div>
		</div>
	</div>
@endsection