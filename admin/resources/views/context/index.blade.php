@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Context')

@section('content')
	<?php
		$allowEdit = Gate::allows('edit-context');
		$allowDelete = Gate::allows('delete-context');
	?>

	@if ($allowDelete)
		@include('dialogs.delete')
	@endif

	<div>
		@can('add-context')
			{!! Button::withValue('Tambah Context')->asLinkTo(url('/context/create')) !!}
		@endcan
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Context</th>
				<th>
					@if ($allowEdit || $allowDelete)
						Operasi
					@endif
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($contexts as $context)
				<tr>
					<td>{!! link_to("/context/$context->category", $context->category) !!}</td>
					<td>
						@if ($allowEdit)
							{!! Button::withValue('Rubah')->asLinkTo(url("/context/$context->category/edit"))->extraSmall() !!}
						@endif
						@if ($allowDelete)
							{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url("/context/$context->category")])->extraSmall() !!}
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection