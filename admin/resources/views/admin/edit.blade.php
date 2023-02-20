@extends('layouts.master')

@section('title', 'Edit Admin')

@section('content')
	@if (isset($admin))
		{!! Form::open(['method' => 'PUT', 'url' => '/admin/' . $admin->id]) !!}
			@include('admin.fields', [
				'username' => $admin->username,
				'fullname' => $admin->fullname,
                'roles' => $roles,
				'role_id' => $admin->role_id
			])
		{!! Form::close() !!}
	@endif
@endsection