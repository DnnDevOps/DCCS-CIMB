@extends('layouts.master')

@section('styles')
	@parent
	
	{!! Html::style('css/upload.css') !!}
@endsection

@section('scripts')
	@parent
	
	{!! Html::script('js/upload.js') !!}
@endsection

@section('title', 'Upload Anggota Group')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/group/upload', 'enctype' => 'multipart/form-data']) !!}
		{!!
			ControlGroup::generate(
				BSForm::label('group_file', 'File Anggota Group'),
				InputGroup::withContents(
					BSForm::text('filename', NULL, [
						'placeholder' => 'Hanya file CSV dengan kolom: Username Supervisor, Username anggota Group', 'readonly' => true
					])
				)->appendButton(
					Button::primary()->withAttributes(['class' => 'btn-file'])->withValue(
						'Browse&hellip; ' . BSForm::file('group_file')
					)
				)
			)
		!!}
		{!! Button::primary('Upload')->submit() !!}
	{!! Form::close() !!}
@endsection