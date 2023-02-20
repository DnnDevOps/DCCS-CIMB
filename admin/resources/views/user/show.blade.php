@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Detail User')

@section('content')
	@include('dialogs.delete')

	@if (isset($user))
		<dl>
			<dt>Username</dt>
			<dd>{{ $user->username }}</dd>
		</dl>
		<dl>
			<dt>Full Name</dt>
			<dd>{{ $user->fullname }}</dd>
		</dl>
		<dl>
			<dt>Level</dt>
			<dd>{{ $user->level }}</dd>
		</dl>
		<dl>
			<dt>Panggilan Telepon Manual</dt>
			<dd>{{ $user->manual_dial ? 'Boleh' : 'Tidak Boleh' }}</dd>
		</dl>
		<dl>
			<dt>Status</dt>
			<dd>{{ $user->active ? 'Aktif' : 'Tidak Aktif' }}</dd>
		</dl>
		
		@can('edit-user')
			{!! Button::withValue('Rubah')->asLinkTo(url('/user/' . $user->username . '/edit')) !!}
		@endcan
		@can('delete-user')
			{!! Button::danger('Hapus')->submit()->addAttributes(['class' => 'delete', 'data-url' => url('/user/' . $user->username)]) !!}
		@endcan
	@endif
@endsection