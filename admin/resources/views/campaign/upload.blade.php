@extends('layouts.master')

@section('styles')
	@parent
	
	{!! Html::style('css/upload.css') !!}
@endsection

@section('scripts')
	@parent
	
	{!! Html::script('js/upload.js') !!}
@endsection

@section('title', 'Upload Data Campaign <strong>' . $name . '</strong>')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/campaign/' . $name . '/upload', 'enctype' => 'multipart/form-data']) !!}
		{!!
			ControlGroup::generate(
				BSForm::label('contact_file', 'File Data Kontak'),
				InputGroup::withContents(
					BSForm::text('filename', NULL, [
						'placeholder' => 'Hanya file CSV dengan kolom: Customer ID, Home Number, Office Number, Mobile Number', 'readonly' => true
					])
				)->appendButton(
					Button::primary()->withAttributes(['class' => 'btn-file'])->withValue(
						'Browse&hellip; ' . BSForm::file('contact_file')
					)
				)
			)
		!!}
		{!! Button::primary('Upload')->submit() !!}
	{!! Form::close() !!}
@endsection