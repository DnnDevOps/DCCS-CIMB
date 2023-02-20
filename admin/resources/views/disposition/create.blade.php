@extends('layouts.master')

@section('title', 'Tambah Disposition')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/disposition']) !!}
		@include('disposition.fields', [
			'disposition' => old('disposition'),
			'skip_contact' => old('skip_contact')
		])
	{!! Form::close() !!}
@endsection