@extends('layouts.master')

@section('title', "Edit Extension Context <strong>$context->category</strong>")

@section('content')
	@if (isset($extension))
		{!! Form::open(['method' => 'PUT', 'url' => "/context/$context->category/$extension->extension"]) !!}
            @include('context.extension_fields', [
                'extension' => $extension->extension,
                'macro' => $extension->macro,
                'trunks' => $trunks,
                'trunk' => $extension->trunk,
                'peers' => $peers,
                'peer' => $extension->peer,
                'queues' => $queues,
                'queue' => $extension->queue,
                'destination' => $destination,
                'record' => $record
            ])
		{!! Form::close() !!}
	@endif
@endsection