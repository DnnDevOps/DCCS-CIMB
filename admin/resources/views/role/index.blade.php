@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Role')

@section('content')
	@include('dialogs.delete')

	<div>
		{!! Button::withValue('Tambah Role')->asLinkTo(url('/role/create')) !!}
		{!! $roles->render() !!}
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Role</th>
				<th>Operasi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($roles as $role)
				<tr>
					<td>{{ $role->role }}</td>
					<td>
						{!! Button::withValue('Rubah')->asLinkTo(url('/role/' . $role->id . '/edit'))->extraSmall() !!}
						{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url('/role/' . $role->id)])->extraSmall() !!}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $roles->render() !!}
@endsection