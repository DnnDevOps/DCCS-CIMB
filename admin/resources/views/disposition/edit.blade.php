@extends('layouts.master')

@section('title', 'Edit Disposition')

@section('content')
	@if (isset($disposition))
		{!! Form::open(['method' => 'PUT', 'url' => '/disposition/' . $disposition->disposition]) !!}
			@include('disposition.fields', [
				'disposition' => $disposition->disposition,
				'skip_contact' => $disposition->skip_contact
			])
		{!! Form::close() !!}
	@endif
@endsection