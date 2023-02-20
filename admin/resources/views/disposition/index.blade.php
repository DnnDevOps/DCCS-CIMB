@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Disposition')

@section('content')
	<?php
		$allowEdit = Gate::allows('edit-disposition');
		$allowDelete = Gate::allows('delete-disposition');
	?>

	@if($allowDelete)
		@include('dialogs.delete')
	@endif

	<div>
		@can('add-disposition')
			{!! Button::withValue('Tambah Disposition')->asLinkTo(url('/disposition/create')) !!}
		@endcan

		{!! $dispositions->render() !!}
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Disposition</th>
				<th class="shrinked">Skip Contact</th>
				<th>
					@if ($allowEdit || $allowDelete)
						Operasi
					@endif
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($dispositions as $disposition)
				<tr>
					<td>{{ $disposition->disposition }}</td>
					<td>
						@if ($disposition->skip_contact)
							{!! Label::info('Skipped') !!}
						@endif
					</td>
					<td>
						@if ($disposition->disposition != 'WRAPUP_TIMEOUT')
							@if ($allowEdit)
								{!! Button::withValue('Rubah')->asLinkTo(url('/disposition/' . $disposition->disposition . '/edit'))->extraSmall() !!}
							@endif
							@if ($allowDelete)
								{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url('/disposition/' . $disposition->disposition)])->extraSmall() !!}
							@endif
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $dispositions->render() !!}
@endsection