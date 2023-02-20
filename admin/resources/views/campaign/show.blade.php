@extends('layouts.master')

@section('title', 'Daftar Data Campaign <strong>' . $name . '</strong>')

@section('content')
	<div>
		@can('upload-campaign')
			{!! Button::withValue('Upload Data')->asLinkTo(url('/campaign/' . $name . '/upload')) !!}
		@endcan
		@can('distribute-campaign')
			{!! Button::withValue('Distribusi Data')->asLinkTo(url('/campaign/' . $name . '/distribute')) !!}
		@endcan

		{!! $contacts->render() !!}
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Customer ID</th>
				<th>Home Number</th>
				<th>Office Number</th>
				<th>Mobile Number</th>
				<th>User</th>
				<th>Disposition</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($contacts as $contact)
				<tr>
					<td>{{ $contact->customer_id }}</td>
					<td>{{ $contact->home_number }}</td>
					<td>{{ $contact->office_number }}</td>
					<td>{{ $contact->mobile_number }}</td>
					<td>
						@if (isset($contact->username))
							{!! link_to('/user/' . $contact->username, $contact->username) !!}
						@endif
					</td>
					<td>{{ $contact->disposition }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $contacts->render() !!}
@endsection