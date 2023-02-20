@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Peer')

@section('content')
	<?php
		$allowEdit = Gate::allows('edit-peer');
		$allowDelete = Gate::allows('delete-peer');
	?>

	@if($allowDelete)
		@include('dialogs.delete')
	@endif

	<div>
		@can('add-peer')
			{!! Button::withValue('Tambah Peer')->asLinkTo(url('/peer/create')) !!}
		@endcan
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Peer</th>
				<th>Type</th>
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
			@foreach ($peers as $peer)
				<tr>
					<td>{{ $peer->category }}</td>
					<td>{{ $peer->type }}</td>
					<td>{{ $peer->host }}</td>
					<td>{{ $peer->context }}</td>
					<td>
						@if ($allowEdit)
							{!! Button::withValue('Mapping')->asLinkTo(url("/peer/$peer->category/mapping"))->extraSmall() !!}
							{!! Button::withValue('Rubah')->asLinkTo(url("/peer/$peer->category/edit"))->extraSmall() !!}
						@endif
						@if ($allowDelete)
							{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url("/peer/$peer->category")])->extraSmall() !!}
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection