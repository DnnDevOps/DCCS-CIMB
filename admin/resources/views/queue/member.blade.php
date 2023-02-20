@extends('layouts.master')

@section('styles')
	@parent
	
	{!! Html::style('css/select2.css') !!}
@endsection

@section('scripts')
	@parent
	
	{!! Html::script('js/select2.js') !!}
	{!! Html::script('js/member.js') !!}
@endsection

@section('title', "Tambah Anggota Queue <strong>$queue</strong>")

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => "/queue/$queue/member"]) !!}
		{!!
			ControlGroup::generate(
				BSForm::label('users', 'Daftar User'),
				BSForm::select('users', $users, null, ['class' => 'select2', 'multiple'])
			)
		!!}
		{!!
			ControlGroup::generate(
				Button::success('Tambah')->withAttributes(['id' => 'add-users']),
				NULL
			)
		!!}
		<table class="table" id="users-penalty">
			<thead>
				<tr>
					<th>Anggota</th>
					<th class="shrinked">Penalty</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
		{!! Button::primary('Simpan')->submit() !!}
	{!! Form::close() !!}
@endsection