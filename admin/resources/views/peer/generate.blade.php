@extends('layouts.master')

@section('title', 'Generate Daftar Peer')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/peer/generate']) !!}
		{!!
			ControlGroup::generate(
				BSForm::label('count', 'Jumlah Peer'),
				BSForm::number('count')
			)
		!!}
		{!!
			ControlGroup::generate(
				BSForm::label('length', 'Panjang Nama Peer'),
				BSForm::number('length', 4)
			)
		!!}
		{!!
			ControlGroup::generate(
				BSForm::label('prefix', 'Prefix Nama Peer'),
				BSForm::number('prefix', 1)
			)
		!!}
		{!!
			ControlGroup::generate(
				BSForm::label('context', 'Context'),
				BSForm::select('context', $contexts, 'local-extension')
			)
		!!}
		{!! Button::primary('Simpan')->submit() !!}
	{!! Form::close() !!}
@endsection