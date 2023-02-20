@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Anggota Group <strong>' . $leader . '</strong>')

@section('content')
	<?php
		$allowDelete = Gate::allows('delete-member');
	?>

	@if($allowDelete)
		@include('dialogs.delete')
	@endif

	<div>
		@can('add-member')
			{!! Button::withValue('Tambah Anggota')->asLinkTo(url("/group/$leader/create")) !!}
		@endcan

		{!! $members->render() !!}
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Username</th>
				<th>Full Name</th>

				@if($allowDelete)
					<th>Operasi</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach ($members as $member)
				<tr>
					<td>
						@can('show-users')
							{!! link_to('/user/' . $member->username, $member->username) !!}
						@else
							{{ $member->username }}
						@endcan
					</td>
					<td>{{ $member->fullname }}</td>
					@if($allowDelete)
						<td>
							{!! Button::danger('Hapus Anggota')->addAttributes(['class' => 'delete', 'data-url' => url('/group/' . $leader . '/' . $member->username)])->extraSmall() !!}
						</td>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $members->render() !!}
@endsection