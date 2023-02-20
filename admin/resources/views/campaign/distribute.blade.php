@extends('layouts.master')

@section('styles')
	@parent
	
	{!! Html::style('css/select2.css') !!}
@endsection

@section('scripts')
	@parent
	
	{!! Html::script('js/select2.js') !!}
	{!! Html::script('js/distribute.js') !!}
@endsection

@section('title', "Distribusi Data Campaign <strong>$name</strong>")

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => "/campaign/$name/distribute"]) !!}
		<dl>
			<dt>Jumlah Data Tersedia</dt>
			<dd>{{ number_format($count, 0, ',', '.') }}</dd>
		</dl>
		{!!
			ControlGroup::generate(
				BSForm::label('users', 'Daftar User'),
				BSForm::select('users', $users, NULL, ['class' => 'select2', 'multiple'])
			)
		!!}
		{!!
			ControlGroup::generate(
				Button::success('Tambah')->withAttributes(['id' => 'add-users']),
				NULL
			)
		!!}
		<table class="table" id="users-quota">
			<thead>
				<tr>
					<th>User</th>
					<th class="shrinked">Jumlah Data</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
		{!! Button::primary('Simpan')->submit() !!}
	{!! Form::close() !!}
@endsection