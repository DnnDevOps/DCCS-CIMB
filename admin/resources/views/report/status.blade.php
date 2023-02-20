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

@section('title', 'Report Status')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/report/status']) !!}
		<div class="row">
			<div class="col-xs-6">
				{!!
					ControlGroup::generate(
						BSForm::label('start_date', 'Tanggal Mulai'),
						BSForm::text('start_date', isset($start_date) ? $start_date : null, ['placeholder' => 'Tanggal mulai status', 'readonly' => TRUE])
					)
				!!}
			</div>
			<div class="col-xs-6">
				{!!
					ControlGroup::generate(
						BSForm::label('username', 'Username'),
						BSForm::text('username', isset($username) ? $username : null, ['placeholder' => 'Username yang dicari'])
					)
				!!}
			</div>
		</div>
		{!! Button::primary('Tampilkan')->withAttributes(['class' => 'action-button'])->submit() !!}
        {!! Button::success('Export CSV')->withAttributes(['class' => 'action-button', 'name' => 'export', 'value' => 'csv'])->submit() !!}
	{!! Form::close() !!}
	
	@if (!empty($statusLogs))
		<div>
			{!! $statusLogs->render() !!}
		</div>
		
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Username</th>
					<th>Status</th>
					<th>Waktu Mulai</th>
					<th>Waktu Selesai</th>
					<th>Durasi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($statusLogs as $statusLog)
					<?php $session = $statusLog->session()->first(); ?>
					<tr>
						<td>{{ $session->username }}</td>
						<td>{{ $statusLog->status }}</td>
						<td>{{ $statusLog->started }}</td>
						<td>{{ $statusLog->finished }}</td>
						<td>
							@if ($statusLog->finished != null)
								{{ $statusLog->started->diff($statusLog->finished)->format('%H:%I:%S') }}
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
		{!! $statusLogs->render() !!}
	@endif
@endsection