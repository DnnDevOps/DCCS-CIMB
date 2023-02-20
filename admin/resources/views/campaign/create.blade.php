@extends('layouts.master')

@section('title', 'Tambah Campaign')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/campaign']) !!}
		@include('campaign.fields', [
			'name' => old('name'),
			'begin_time' => old('begin_time'),
			'finish_time' => old('finish_time'),
			'screen_pop_url' => old('screen_pop_url')
		])
	{!! Form::close() !!}
@endsection