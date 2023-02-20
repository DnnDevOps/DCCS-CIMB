@extends('layouts.master')

@section('title', "Tambah Extension Context <strong>$context->category</strong>")

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => "/context/$context->category/extension"]) !!}
		@include('context.extension_fields', [
			'extension' => old('extension'),
			'macro' => old('macro'),
            'trunks' => $trunks,
            'trunk' => old('trunk'),
            'peers' => $peers,
            'peer' => old('peer'),
            'queues' => $queues,
            'queue' => old('queue'),
            'destination' => old('destination'),
            'record' => old('record')
		])
	{!! Form::close() !!}
@endsection