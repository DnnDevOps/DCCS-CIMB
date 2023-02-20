@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Trunk')

@section('content')
	<?php
		$allowEdit = Gate::allows('edit-trunk');
		$allowDelete = Gate::allows('delete-trunk');
	?>

	@if($allowDelete)
		@include('dialogs.delete')
	@endif

	<div>
		@can('add-trunk')
			{!! Button::withValue('Tambah Trunk')->asLinkTo(url('/trunk/create')) !!}
		@endif
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Trunk</th>
				<th>Username</th>
				<th>Host</th>
				<th>Context</th>
				<th>
					@if ($allowEdit || $allowDelete)
						Operasi
					@endif
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($trunks as $trunk)
				<tr>
					<td>{{ $trunk->category }}</td>
					<td>{{ $trunk->defaultuser }}</td>
					<td>{{ $trunk->host }}</td>
					<td>{{ $trunk->context }}</td>
					<td>
						@if ($allowEdit)
							{!! Button::withValue('Rubah')->asLinkTo(url("/trunk/$trunk->category/edit"))->extraSmall() !!}
						@endif
						@if ($allowDelete)
							{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url("/trunk/$trunk->category")])->extraSmall() !!}
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection