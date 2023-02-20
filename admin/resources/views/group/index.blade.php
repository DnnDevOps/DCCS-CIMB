@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Group')

@section('content')
	<?php
		$allowAdd = Gate::allows('add-member');
	?>

	{!! $leaders->render() !!}
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Supervisor</th>

				@if($allowAdd)
					<th>Operasi</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach ($leaders as $leader)
				<tr>
					<td>{!! link_to('/group/' . $leader->username, $leader->username) !!}</td>
					@if($allowAdd)
						<td>
							{!! link_to('/group/' . $leader->username . '/create', 'Tambah Anggota', ['class' => 'btn btn-default btn-xs']) !!}
						</td>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $leaders->render() !!}
@endsection