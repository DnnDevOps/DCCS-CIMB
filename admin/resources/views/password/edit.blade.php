@extends('layouts.master')

@section('title', 'Ganti Password')

@section('content')
	@if (isset($admin))
		{!! Form::open(['method' => 'PUT', 'url' => "/password"]) !!}
            {!!
                ControlGroup::generate(
                    BSForm::label('old_password', 'Password Lama'),
                    BSForm::password('old_password', ['required'])
                )
            !!}
            {!!
                ControlGroup::generate(
                    BSForm::label('new_password', 'Password Baru'),
                    BSForm::password('new_password', ['required'])
                )
            !!}
            {!!
                ControlGroup::generate(
                    BSForm::label('new_password_confirm', 'Password Baru (Ulangi)'),
                    BSForm::password('new_password_confirm', ['required'])
                )
            !!}
            {!! Button::primary('Simpan')->submit() !!}
		{!! Form::close() !!}
	@endif
@endsection