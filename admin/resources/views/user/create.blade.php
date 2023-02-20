@extends('layouts.master')

@section('title', 'Tambah User')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/user']) !!}
		@include('user.fields', [
			'username' => old('username'),
			'fullname' => old('fullname'),
			'level' => old('level'),
			'manual_dial' => old('manual_dial'),
			'active' => old('active')
		])
	{!! Form::close() !!}
@endsection