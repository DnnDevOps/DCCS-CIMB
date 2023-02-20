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

@section('title', 'Report Chat History')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/report/chat']) !!}
		<div class="row">
			<div class="col-xs-4">
				{!!
					ControlGroup::generate(
						BSForm::label('start_date', 'Tanggal Kirim'),
						BSForm::text('start_date', isset($start_date) ? $start_date : null, ['placeholder' => 'Tanggal chat dikirim', 'readonly' => TRUE])
					)
				!!}
			</div>
			<div class="col-xs-4">
				{!!
					ControlGroup::generate(
						BSForm::label('sender', 'Pengirim'),
						BSForm::text('sender', isset($sender) ? $sender : null, ['placeholder' => 'Username pengirim'])
					)
				!!}
			</div>
			<div class="col-xs-4">
				{!!
					ControlGroup::generate(
						BSForm::label('recipient', 'Penerima'),
						BSForm::text('recipient', isset($recipient) ? $recipient : null, ['placeholder' => 'Username penerima'])
					)
				!!}
			</div>
		</div>
		{!! Button::primary('Tampilkan')->withAttributes(['class' => 'action-button'])->submit() !!}
        {!! Button::success('Export CSV')->withAttributes(['class' => 'action-button', 'name' => 'export', 'value' => 'csv'])->submit() !!}
	{!! Form::close() !!}
	
	@if (!empty($userTextLogs))
		<div>
			{!! $userTextLogs->render() !!}
		</div>
		
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Pengirim</th>
					<th>Penerima</th>
					<th>Dikirim</th>
					<th>Pesan</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($userTextLogs as $userTextLog)
					<tr>
						<td>{{ $userTextLog->sender }}</td>
						<td>{{ $userTextLog->recipient }}</td>
						<td>{{ $userTextLog->sent }}</td>
						<td>{{ $userTextLog->text }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
		{!! $userTextLogs->render() !!}
	@endif
@endsection