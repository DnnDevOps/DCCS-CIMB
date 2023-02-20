@extends('layouts.master')

@section('title', 'Edit Campaign')

@section('content')
	@if (isset($campaign))
		{!! Form::open(['method' => 'PUT', 'url' => '/campaign/' . $campaign->name]) !!}
			@include('campaign.fields', [
				'name' => $campaign->name,
				'begin_time' => $campaign->begin_time,
				'finish_time' => $campaign->finish_time,
				'screen_pop_url' => $campaign->screen_pop_url
			])
		{!! Form::close() !!}
	@endif
@endsection