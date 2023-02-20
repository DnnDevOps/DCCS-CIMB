@extends('layouts.master')

@section('title', 'Edit Status')

@section('content')
	@if (isset($status))
		{!! Form::open(['method' => 'PUT', 'url' => '/status/' . $status->status]) !!}
			@include('status.fields', [
				'status' => $status->status
			])
		{!! Form::close() !!}
	@endif
@endsection