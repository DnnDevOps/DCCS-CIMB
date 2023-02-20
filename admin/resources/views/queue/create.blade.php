@extends('layouts.master')

@section('title', 'Tambah Queue')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/queue']) !!}
		@include('queue.fields', [
			'queue' => old('queue'),
			'strategy' => old('strategy'),
			'strategies' => $strategies,
            'servicelevel' => old('servicelevel'),
			'screen_pop_url' => old('screen_pop_url')
		])
	{!! Form::close() !!}
@endsection