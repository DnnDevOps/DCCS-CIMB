@extends('layouts.master')

@section('styles')
	@parent
	
	{!! Html::style('css/upload.css') !!}
@endsection

@section('scripts')
	@parent
	
	{!! Html::script('js/upload.js') !!}
@endsection

@section('title', 'Upload Daftar User')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/user/upload', 'enctype' => 'multipart/form-data']) !!}
		{!!
			ControlGroup::generate(
				BSForm::label('user_file', 'File Daftar User'),
				InputGroup::withContents(
					BSForm::text('filename', NULL, [
						'placeholder' => 'Hanya file CSV dengan kolom: Username, Password, Fullname dan Level(Agent, Supervisor, Manager)', 'readonly' => true
					])
				)->appendButton(
					Button::primary()->withAttributes(['class' => 'btn-file'])->withValue(
						'Browse&hellip; ' . BSForm::file('user_file')
					)
				)
			)
		!!}
		{!! Button::primary('Upload')->submit() !!}
	{!! Form::close() !!}
@endsection