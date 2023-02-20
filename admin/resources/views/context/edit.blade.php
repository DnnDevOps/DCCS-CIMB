@extends('layouts.master')

@section('title', 'Edit Context')

@section('content')
	@if (isset($context))
		{!! Form::open(['method' => 'PUT', 'url' => "/context/$context->category"]) !!}
			@include('context.fields', [
				'context' => $context->category
			])
		{!! Form::close() !!}
	@endif
@endsection