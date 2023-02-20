@extends('layouts.master')

@section('title', 'Settings')

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => '/setting']) !!}
		{!!
			ControlGroup::generate(
				BSForm::label('OBELISK_CRM_URL', 'CRM URL'),
				BSForm::text('OBELISK_CRM_URL')
			)
		!!}
		{!!
			ControlGroup::generate(
				BSForm::label('OBELISK_CRM_LOGOUT_URL', 'CRM Logout URL'),
				BSForm::text('OBELISK_CRM_LOGOUT_URL')
			)
		!!}
		{!!
			ControlGroup::generate(
				BSForm::label('OBELISK_CRM_SCREEN_POP_URL', 'CRM Screen Pop URL'),
				BSForm::text('OBELISK_CRM_SCREEN_POP_URL')
			)
		!!}
		{!!
			ControlGroup::generate(
				BSForm::label('OBELISK_AUTODIALER_ENABLED', 'Enable Auto Dialer'),
				BSForm::text('OBELISK_AUTODIALER_ENABLED')
			)
		!!}
		{!!
			ControlGroup::generate(
				BSForm::label('OBELISK_AUTODIALER_WRAPUP_TIME', 'Wrap-Up Time Auto Dialer'),
				BSForm::number('OBELISK_AUTODIALER_WRAPUP_TIME')
			)
		!!}
		{!! Button::primary('Simpan')->submit() !!}
	{!! Form::close() !!}
@endsection