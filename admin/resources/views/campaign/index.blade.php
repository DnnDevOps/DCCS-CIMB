@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', 'Daftar Campaign')

@section('content')
	<?php
		$allowEdit = Gate::allows('edit-campaign');
		$allowDelete = Gate::allows('delete-campaign');
		$allowUpload = Gate::allows('upload-campaign');
		$allowDistribute = Gate::allows('distribute-campaign');
		$allowStart = Gate::allows('start-campaign');
	?>

	@if($allowDelete)
		@include('dialogs.delete')
	@endif

	<div>
		@can('add-campaign')
			{!! Button::withValue('Tambah Campaign')->asLinkTo(url('/campaign/create')) !!}
		@endcan

		{!! $campaigns->render() !!}
	</div>
	
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Campaign Name</th>
				<th>Waktu Mulai</th>
				<th>Waktu Selesai</th>
				<th class="shrinked">Status</th>
				<th>
					@if($allowEdit || $allowDelete || $allowUpload || $allowDistribute || $allowStart)
						Operasi
					@endif
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($campaigns as $campaign)
				<?php
					$started = $campaign->started();
					$menuContents = [
						['url' => url("/campaign/$campaign->name/edit"), 'label' => 'Rubah'],
						['url' => url("/campaign/$campaign->name/upload"), 'label' => 'Upload Data'],
						['url' => url("/campaign/$campaign->name/distribute"), 'label' => 'Distribusi Data']
					];
					
					if ($started) {
						array_shift($menuContents);
					}
				?>
				<tr>
					<td>{!! link_to('/campaign/' . $campaign->name, $campaign->name) !!}</td>
					<td>{{ $campaign->begin_time }}</td>
					<td>{{ $campaign->finish_time }}</td>
					<td>
						@if ($started)
							{!! Label::success('Started') !!}
						@else
							{!! Label::normal('Stopped') !!}
						@endif
					</td>
					<td>
						@if ($allowUpload || $allowDistribute)
							{!! DropdownButton::normal('Menu')->withContents($menuContents)->extraSmall() !!}
						@endif
						@if ($allowDelete)
							{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url('/campaign/' . $campaign->name)])->extraSmall() !!}
						@endif
						@if ($allowStart)
							@if ($started)
								{!! Button::danger('Stop')->asLinkTo(url('/campaign/' . $campaign->name . '/stop'))->extraSmall() !!}
							@else
								{!! Button::primary('Start')->asLinkTo(url('/campaign/' . $campaign->name . '/start'))->extraSmall() !!}
							@endif
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $campaigns->render() !!}
@endsection