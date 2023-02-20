@extends('layouts.master')

@section('title', 'Tambah Trunk')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/trunk']) !!}
		@include('trunk.fields', [
			'trunk' => old('trunk'),
            'defaultuser' => old('defaultuser'),
            'host' => old('host'),
			'contexts' => $contexts,
			'context' => old('context')
		])
	{!! Form::close() !!}
@endsection