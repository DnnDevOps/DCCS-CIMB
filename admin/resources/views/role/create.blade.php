@extends('layouts.master')

@section('title', 'Tambah Role')

@section('content')    
	{!! Form::open(['method' => 'POST', 'url' => '/role']) !!}
		@include('role.fields', [
			'role' => old('role')
		])
	{!! Form::close() !!}
@endsection