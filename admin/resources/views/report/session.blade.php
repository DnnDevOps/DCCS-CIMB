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

@section('title', 'Report Session')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/report/session']) !!}
		<div class="row">
			<div class="col-xs-6">
				{!!
					ControlGroup::generate(
						BSForm::label('start_date', 'Tanggal Login'),
						BSForm::text('start_date', isset($start_date) ? $start_date : null, ['placeholder' => 'Tanggal mulai login', 'readonly' => TRUE])
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
	
	@if (!empty($sessions))
		<div>
			{!! $sessions->render() !!}
		</div>
		
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Username</th>
					<th>Waktu Login</th>
					<th>Waktu Logout</th>
					<th>Durasi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($sessions as $session)
					<tr>
						<td>{{ $session->username }}</td>
						<td>{{ $session->logged_in }}</td>
						<td>{{ $session->logged_out }}</td>
						<td>
							@if ($session->logged_out != null)
								{{ $session->logged_in->diff($session->logged_out)->format('%H:%I:%S') }}
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
		{!! $sessions->render() !!}
	@endif
@endsection