@extends('layouts.master')

@section('title', 'Tambah Peer')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/peer']) !!}
		@include('peer.fields', [
			'peer' => old('peer'),
			'contexts' => $contexts,
			'context' => old('context')
		])
	{!! Form::close() !!}
@endsection