@extends('layouts.master')

@section('title', 'Edit Role')

@section('content')
	@if (isset($role))
		{!! Form::open(['method' => 'PUT', 'url' => '/role/' . $role->id]) !!}
			@include('role.fields', [
				'role' => $role->role
			])
		{!! Form::close() !!}
	@endif
@endsection