@extends('layouts.master')

@section('title', 'Tambah Admin')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/admin']) !!}
		@include('admin.fields', [
			'username' => old('username'),
			'fullname' => old('fullname'),
            'roles' => $roles,
			'role_id' => old('role_id')
		])
	{!! Form::close() !!}
@endsection