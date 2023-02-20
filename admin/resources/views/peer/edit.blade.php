@extends('layouts.master')

@section('title', 'Edit Peer')

@section('content')
	@if (isset($peer))
		{!! Form::open(['method' => 'PUT', 'url' => "/peer/$peer->category"]) !!}
			@include('peer.fields', [
				'peer' => $peer->category,
				'contexts' => $contexts,
				'context' => $peer->context
			])
		{!! Form::close() !!}
	@endif
@endsection