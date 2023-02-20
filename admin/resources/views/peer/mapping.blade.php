@extends('layouts.master')

@section('title', 'Edit Peer Mapping')

@section('content')
	@if (isset($peer))
		{!! Form::open(['method' => 'POST', 'url' => "/peer/$peer->category/mapping"]) !!}
			{!!
				ControlGroup::generate(
					BSForm::label('peer', 'Peer'),
					BSForm::text('peer', $peer->category, ['readonly' => true])
				)
			!!}
			{!!
				ControlGroup::generate(
					BSForm::label('address', 'IP Address'),
					BSForm::text('address', $address, ['placeholder' => 'Alamat IP yang hendak diasosiasikan dengan Peer'])
				)
			!!}
			{!! Button::primary('Simpan')->submit() !!}
		{!! Form::close() !!}
	@endif
@endsection