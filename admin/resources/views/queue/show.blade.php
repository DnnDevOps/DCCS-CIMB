@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', "Anggota Queue <strong>$queue</strong>")

@section('content')
	<?php
		$allowDelete = Gate::allows('delete-queue-member');
	?>

	@if($allowDelete)
		@include('dialogs.delete')
	@endif

	<div>
		@can('add-queue-member')
			{!! Button::withValue('Tambah Anggota')->asLinkTo(url("/queue/$queue/member")) !!}
		@endif
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Username</th>
				<th>Penalty</th>
				<th>
					@if ($allowDelete)
						Operasi
					@endif
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($queueMembers as $member => $penalty)
				<tr>
					<td>{!! link_to("/user/$member", $member) !!}</td>
                    <td>{{ $penalty }}</td>
					<td>
						@if ($allowDelete)
							{!! Button::danger('Hapus Anggota')->addAttributes(['class' => 'delete', 'data-url' => url("/queue/$queue/$member/$penalty")])->extraSmall() !!}
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection