@extends('layouts.master')

@section('scripts')
@parent

{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar User')

@section('content')
<?php
$allowEdit = Gate::allows('edit-user');
$allowDelete = Gate::allows('delete-user');
?>

@if($allowDelete)
@include('dialogs.delete')
@endif

<div>
	@can('add-user')
	{!! Button::withValue('Tambah User')->asLinkTo(url('/user/create')) !!}
	@endcan

	{!! $users->render() !!}
</div>

{!! Form::open(['method' => 'POST', 'url' => '/user/search']) !!}
@include('user.search', [
'username' => isset($username)?$username:null,
'fullname' => isset($fullname)?$fullname:null,
'status' => isset($status)?$status:''
])
{!! Form::close() !!}

<table class="table table-condensed">
	<thead>
		<tr>
			<th>Username</th>
			<th>Full Name</th>
			<th>Level</th>
			<th class="shrinked">Status</th>
			<th>
				@if($allowEdit || $allowDelete)
				Operasi
				@endif
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $user)
		<tr>
			<td>{!! link_to('/user/' . $user->username, $user->username) !!}</td>
			<td>{{ $user->fullname }}</td>
			<td>{{ $user->level }}</td>
			<td>
				@if ($user->active)
				{!! Label::success('Aktif') !!}
				@else
				{!! Label::normal('Tidak Aktif') !!}
				@endif
			</td>
			<td>
				@if($allowEdit)
				{!! Button::withValue('Rubah')->asLinkTo(url('/user/' . $user->username . '/edit'))->extraSmall() !!}
				@endif
				@if($allowDelete)
				<!-- {!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url('/user/' . $user->username)])->extraSmall() !!} -->
				{!! Button::withValue('Hapus')->addAttributes(['class' => 'delete', 'disabled'=>'disabled', 'data-url' => url('/user/' . $user->username)])->extraSmall() !!}
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

{!! $users->render() !!}
@endsection