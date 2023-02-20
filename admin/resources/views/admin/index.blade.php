@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Admin')

@section('content')
	@include('dialogs.delete')

	<div>
		{!! Button::withValue('Tambah Admin')->asLinkTo(url('/admin/create')) !!}
		{!! $admins->render() !!}
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Username</th>
				<th>Full Name</th>
				<th>Role</th>
				<th>Operasi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($admins as $admin)
				<tr>
					<td>{{ $admin->username }}</td>
					<td>{{ $admin->fullname }}</td>
					<td>{{ $admin->role->role }}</td>
					<td>
						{!! Button::withValue('Rubah')->asLinkTo(url('/admin/' . $admin->id . '/edit'))->extraSmall() !!}
						{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url('/admin/' . $admin->id)])->extraSmall() !!}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $admins->render() !!}
@endsection