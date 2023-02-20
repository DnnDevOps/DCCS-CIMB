@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Status')

@section('content')
	<?php
		$allowEdit = Gate::allows('edit-status');
		$allowDelete = Gate::allows('delete-status');
	?>

	@if($allowDelete)
		@include('dialogs.delete')
	@endif

	<div>
		@can('add-status')
			{!! Button::withValue('Tambah Status')->asLinkTo(url('/status/create')) !!}
		@endcan

		{!! $statuses->render() !!}
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Status</th>
				<th>
					@if ($allowEdit || $allowDelete)
						Operasi
					@endif
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($statuses as $status)
				<tr>
					<td>{{ $status->status }}</td>
					<td>
						@if (!in_array($status->status, ['Not Ready', 'Ready']))
							@if ($allowEdit)
								{!! Button::withValue('Rubah')->asLinkTo(url('/status/' . $status->status . '/edit'))->extraSmall() !!}
							@endif
							@if ($allowDelete)
								{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url('/status/' . $status->status)])->extraSmall() !!}
							@endif
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $statuses->render() !!}
@endsection