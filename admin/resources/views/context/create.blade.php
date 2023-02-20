@extends('layouts.master')

@section('title', 'Tambah Context')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/context']) !!}
		@include('context.fields', [
			'context' => old('context')
		])
	{!! Form::close() !!}
@endsection