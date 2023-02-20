@extends('layouts.master')

@section('styles')
    @parent

	{!! Html::style('css/daterangepicker.css') !!}
@endsection

@section('scripts')
	@parent
	
	{!! Html::script('js/moment.js') !!}
	{!! Html::script('js/daterangepicker.js') !!}
	{!! Html::script('js/report.js') !!}
@endsection

@section('title', 'Report Telepon')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/report/call']) !!}
		<div class="row">
			<div class="col-xs-4">
				{!!
					ControlGroup::generate(
						BSForm::label('start_date', 'Tanggal Telepon'),
						BSForm::text('start_date', isset($start_date) ? $start_date : null, ['placeholder' => 'Tanggal mulai telepon', 'readonly' => TRUE])
					)
				!!}
			</div>
			<div class="col-xs-4">
				{!!
					ControlGroup::generate(
						BSForm::label('customer_id', 'Customer ID'),
						BSForm::text('customer_id', isset($customer_id) ? $customer_id : null, ['placeholder' => 'Kode Customer ID'])
					)
				!!}
			</div>
			<div class="col-xs-4">
				{!!
					ControlGroup::generate(
						BSForm::label('source', 'Sumber'),
						BSForm::text('source', isset($source) ? $source : null, ['placeholder' => 'Nomor Penelpon'])
					)
				!!}
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				{!!
					ControlGroup::generate(
						BSForm::label('username', 'Username'),
						BSForm::text('username', isset($username) ? $username : null)
					)
				!!}
			</div>
			<div class="col-xs-4">
				{!!
					ControlGroup::generate(
						BSForm::label('campaign', 'Campaign'),
						BSForm::text('campaign', isset($campaign) ? $campaign : null, ['placeholder' => 'Kode Campaign'])
					)
				!!}
			</div>
			<div class="col-xs-4">
				{!!
					ControlGroup::generate(
						BSForm::label('destination', 'Tujuan'),
						BSForm::text('destination', isset($destination) ? $destination : null, ['placeholder' => 'Nomor Telepon Tujuan'])
					)
				!!}
			</div>
		</div>
		{!! Button::primary('Tampilkan')->withAttributes(['class' => 'action-button'])->submit() !!}
        {!! Button::success('Export CSV')->withAttributes(['class' => 'action-button', 'name' => 'export', 'value' => 'csv'])->submit() !!}
	{!! Form::close() !!}
	
	@if (!empty($callLogs))
		<div>
			{!! $callLogs->render() !!}
		</div>
		
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Unique ID</th>
					<th>Username</th>
					<th>Customer ID</th>
					<th>Sumber</th>
					<th>Tujuan</th>
					<th>Tanggal Telepon</th>
					<th>Durasi</th>
					<th>Recording</th>
					<th>IVR</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($callLogs as $callLog)
					<tr>
						<td>{!! link_to('/report/call/' . $callLog->id, $callLog->unique_id) !!}</td>
						<td>{{ $callLog->username }}</td>
						<td>{{ $callLog->customer_id }}</td>
						<td>{{ $callLog->source }}</td>
						<!--<td>{{ $callLog->destination }}</td>-->
						<td>{{ substr($callLog->destination,0,5) .preg_replace("/[0-9]/","X",substr($callLog->destination,5,(strlen($callLog->destination)-5))) }}</td>
						<td>{{ $callLog->start_time }}</td>
						<td>{{ gmdate('H:i:s', $callLog->duration) }}</td>
						<td>
							@if (!empty($callLog->recording))
								{!! Button::info('GSM')->asLinkTo(url('/recording/' . $callLog->recording))->extraSmall() !!}
								{!! Button::info('WAV')->asLinkTo(url('/recording/' . basename($callLog->recording, '.gsm') . '.wav'))->extraSmall() !!}
							@endif
						</td>
						<td>
							@if ($callLog->last_application == 'ConfBridge')
								{!! Label::success('Ada IVR') !!}
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
		{!! $callLogs->render() !!}
	@endif
@endsection