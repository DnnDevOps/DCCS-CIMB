@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Queue')

@section('content')
	<?php
		$allowEdit = Gate::allows('edit-queue');
		$allowDelete = Gate::allows('delete-queue');
	?>

	@if($allowDelete)
		@include('dialogs.delete')
	@endif

	<div>
		@can('add-queue')
			{!! Button::withValue('Tambah Queue')->asLinkTo(url('/queue/create')) !!}
		@endcan
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Queue</th>
				<th>Strategy</th>
				<th>Operasi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($queues as $queue)
				<tr>
					<td>{!! link_to("/queue/$queue->category", $queue->category) !!}</td>
					<td>{{ $queue->strategy }}</td>
					<td>
						@if ($allowEdit)
							{!! Button::withValue('Rubah')->asLinkTo(url("/queue/$queue->category/edit"))->extraSmall() !!}
						@endif
						@if ($allowDelete)
							{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url("/queue/$queue->category")])->extraSmall() !!}
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection