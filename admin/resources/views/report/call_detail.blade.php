@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Detail Telepon')

@section('content')
	@include('dialogs.delete')

	@if (isset($callLog))
		<div class="row">
			<div class="col-xs-2">
				<dl>
					<dt>Unique ID</dt>
					<dd>{{ $callLog->unique_id }}</dd>
				</dl>
			</div>
			<div class="col-xs-5">
				<dl>
					<dt>Account Code</dt>
					<dd>{{ $callLog->account_code }}</dd>
				</dl>
			</div>
			<div class="col-xs-5">
				<dl>
					<dt>AMA Flags</dt>
					<dd>{{ $callLog->ama_flags }}</dd>
				</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<dl>
					<dt>Caller ID</dt>
					<dd>{{ $callLog->caller_id }}</dd>
				</dl>
			</div>
			<div class="col-xs-4">
				<dl>
					<dt>Source</dt>
					<dd>{{ $callLog->source }}</dd>
				</dl>
			</div>
			<div class="col-xs-4">
				<dl>
					<dt>Destination</dt>
					<!--<dd>{{ $callLog->destination }}</dd>-->
					<dd>{{ substr($callLog->destination,0,5) .preg_replace("/[0-9]/","X",substr($callLog->destination,5,(strlen($callLog->destination)-5))) }}</dd>
				</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<dl>
					<dt>Channel</dt>
					<dd>{{ $callLog->channel }}</dd>
				</dl>
			</div>
			<div class="col-xs-6">
				<dl>
					<dt>Destination Channel</dt>
					<dd>{{ $callLog->destination_channel }}</dd>
				</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<dl>
					<dt>Last Application</dt>
					<dd>{{ $callLog->last_application }}</dd>
				</dl>
			</div>
			<div class="col-xs-6">
				<dl>
					<dt>Last Data</dt>
					<!--<dd>{{ $callLog->last_data }}</dd>-->
					<dd>
						<!--
						@if(substr($callLog->last_data,(strlen($callLog->last_data) - strlen($callLog->destination)),strlen($callLog->destination)) == $callLog->destination)
							{{ substr($callLog->last_data,0,(strlen($callLog->last_data) - strlen($callLog->destination))).substr($callLog->destination,0,5).preg_replace("/[0-9]/","X",substr($callLog->destination,5,(strlen($callLog->destination)-5))) }}
						@else
							{{ $callLog->last_data }}
						@endif
						-->
						{{ substr($callLog->last_data,0,(strlen($callLog->last_data) - strlen($callLog->destination))).substr($callLog->destination,0,5).preg_replace("/[0-9]/","X",substr($callLog->destination,5,(strlen($callLog->destination)-5))) }}
					</dd>
				</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<dl>
					<dt>Start Time</dt>
					<dd>{{ $callLog->start_time }}</dd>
				</dl>
			</div>
			<div class="col-xs-4">
				<dl>
					<dt>Answer Time</dt>
					<dd>{{ $callLog->answer_time }}</dd>
				</dl>
			</div>
			<div class="col-xs-4">
				<dl>
					<dt>End Time</dt>
					<dd>{{ $callLog->end_time }}</dd>
				</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2">
				<dl>
					<dt>Duration</dt>
					<dd>{{ $callLog->duration }}</dd>
				</dl>
			</div>
			<div class="col-xs-2">
				<dl>
					<dt>Billable Seconds</dt>
					<dd>{{ $callLog->billable_seconds }}</dd>
				</dl>
			</div>
			<div class="col-xs-6">
				<dl>
					<dt>Disposition</dt>
					<dd>{{ $callLog->disposition }}</dd>
				</dl>
			</div>
			<div class="col-xs-2">
				<dl>
					<dt>Hangup Cause</dt>
					<dd>{{ $callLog->hangup_cause }}</dd>
				</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<dl>
					<dt>Username</dt>
					<dd>{{ $callLog->username }}</dd>
				</dl>
			</div>
			<div class="col-xs-4">
				<dl>
					<dt>Customer ID</dt>
					<dd>{{ $callLog->customer_id }}</dd>
				</dl>
			</div>
			<div class="col-xs-4">
				<dl>
					<dt>Campaign</dt>
					<dd>{{ $callLog->campaign }}</dd>
				</dl>
			</div>
		</div>
		<dl>
			<dt>Recording</dt>
			<dd>
				@if (!empty($callLog->recording))
					<?php $recording = basename($callLog->recording, '.gsm'); ?>
					
					{{ mb_strimwidth($recording, 0, 100, '...') }}
					{!! Button::info('GSM')->asLinkTo(url('/recording/' . $callLog->recording))->extraSmall() !!}
					{!! Button::info('WAV')->asLinkTo(url('/recording/' . $recording . '.wav'))->extraSmall() !!}
				@endif
				@if (!empty($conference))
					{!! Button::info('IVR')->asLinkTo(url("/recording/ivr/$conference"))->extraSmall() !!}
				@endif
			</dd>
		</dl>
	@endif
@endsection