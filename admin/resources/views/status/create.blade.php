@extends('layouts.master')

@section('title', 'Tambah Status')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/status']) !!}
		@include('status.fields', [
			'status' => old('status')
		])
	{!! Form::close() !!}
@endsection