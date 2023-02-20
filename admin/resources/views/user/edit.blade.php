@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
	@if (isset($user))
		{!! Form::open(['method' => 'PUT', 'url' => '/user/' . $user->username]) !!}
			@include('user.fields', [
				'username' => $user->username,
				'fullname' => $user->fullname,
				'level' => $user->level,
				'manual_dial' => $user->manual_dial,
				'active' => $user->active
			])
		{!! Form::close() !!}
	@endif
@endsection