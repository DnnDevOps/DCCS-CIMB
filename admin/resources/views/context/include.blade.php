@extends('layouts.master')

@section('title', "Tambah Include Context <strong>$context->category</strong>")

@section('content')
	{!! Form::open(['method' => 'POST', 'url' => "/context/$context->category/include"]) !!}
        {!!
            ControlGroup::generate(
                BSForm::label('context', 'Context'),
                BSForm::select('context', $contexts, old('context'))
            )
        !!}
        {!! Button::primary('Simpan')->submit() !!}
	{!! Form::close() !!}
@endsection