@extends('layouts.page')

@section('title', 'Login')

@section('styles')
	<link href="css/login.css" rel="stylesheet">
@endsection

@section('layout')
	<div class="container">
		{!! Form::open(['method' => 'POST', 'url' => '/login', 'class' => 'form-signin']) !!}
			{!! csrf_field() !!}
			
			<h2 class="form-signin-heading"><strong>DCCS Admin</strong> {{ Config::get('constant.version') }}</h2>
			
			<label for="username" class="sr-only">Username</label>
			<input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
			
			<label for="password" class="sr-only">Password</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
			
			<div class="checkbox">
				<label>
					<input type="checkbox" name="remember"> Remember me
				</label>
			</div>
			
			<button class="btn btn-lg btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-log-in"></i>&nbsp; Login</button>
		{!! Form::close() !!}
	</div>
@endsection