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

@section('title', 'Report Favorite Number')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/report/favorite']) !!}
		<div class="row">
			<div class="col-xs-6">
				{!!
					ControlGroup::generate(
						BSForm::label('start_date', 'Tanggal Mulai'),
						BSForm::text('start_date', isset($start_date) ? $start_date : null, ['placeholder' => 'Tanggal mulai telepon', 'readonly' => TRUE])
					)
				!!}
			</div>
			<div class="col-xs-6">
				{!!
					ControlGroup::generate(
						BSForm::label('username', 'Username'),
						BSForm::text('username', isset($username) ? $username : null, ['placeholder' => 'Username penelpon'])
					)
				!!}
			</div>
		</div>
		{!! Button::primary('Tampilkan')->withAttributes(['class' => 'action-button'])->submit() !!}
        {!! Button::success('Export CSV')->withAttributes(['class' => 'action-button', 'name' => 'export', 'value' => 'csv'])->submit() !!}
	{!! Form::close() !!}
	
	@if (!empty($favoriteNumbers))
		<div>
			{!! $favoriteNumbers->render() !!}
		</div>
		
		<table class="table table-condensed">
			<thead>
				<tr>
                    <th>Username</th>
					<th>Nomor Tujuan</th>
					<th>Jumlah</th>
					<th>Durasi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($favoriteNumbers as $favoriteNumber)
					<tr>
						<td>{{ $favoriteNumber->username }}</td>
						<td>{{ $favoriteNumber->destination }}</td>
						<td>{{ $favoriteNumber->total_call }}</td>
						<td>{{ $favoriteNumber->duration }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
		{!! $favoriteNumbers->render() !!}
	@endif
@endsection