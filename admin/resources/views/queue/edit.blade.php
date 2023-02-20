@extends('layouts.master')

@section('title', 'Edit Queue')

@section('content')
	@if (isset($queue))
		{!! Form::open(['method' => 'PUT', 'url' => "/queue/$queue->category"]) !!}
			@include('queue.fields', [
				'queue' => $queue->category,
				'strategy' => $queue->strategy,
				'strategies' => $strategies,
                'servicelevel' => $queue->servicelevel,
				'screen_pop_url' => $queue->screenPopUrl
			])
		{!! Form::close() !!}
	@endif
@endsection