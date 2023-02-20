@extends('layouts.master')

@section('styles')
	@parent
	
	{!! Html::style('css/select2.css') !!}
@endsection

@section('scripts')
	@parent
	
	{!! Html::script('js/select2.js') !!}
@endsection

@section('title', "Tambah Anggota Group <strong>$leader</strong>")

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => "/group/$leader"]) !!}
		{!!
			ControlGroup::generate(
				BSForm::label('members[]', 'Anggota Baru'),
				BSForm::select('members[]', $users, null, ['class' => 'select2', 'multiple'])
			)
		!!}
		{!! Button::primary('Simpan')->submit() !!}
	{!! Form::close() !!}
@endsection