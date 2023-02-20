@extends('layouts.master')

@section('scripts')
	@parent
	
	{!! Html::script('js/delete.js') !!}
@endsection

@section('title', "Detail Context <strong>$context->category</strong>")

@section('content')
	<?php
		$allowEditExten = Gate::allows('edit-extension');
		$allowDeleteExten = Gate::allows('delete-extension');
		$allowDeleteInclude = Gate::allows('delete-include');
	?>

	@if ($allowDeleteExten || $allowDeleteInclude)
		@include('dialogs.delete')
	@endif
	
    <ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#extensions" role="tab" data-toggle="tab">Extensions</a></li>
		<li><a href="#include-context" role="tab" data-toggle="tab">Include Context</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="extensions">
			@can('add-extension')
				{!! Button::withValue('Tambah Extension')->asLinkTo(url("/context/$context->category/extension")) !!}
			@endcan
			
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Extension</th>
						<th>Macro</th>
						<th>Parameter 1</th>
						<th>Parameter 2</th>
						<th>Parameter 3</th>
						<th>
							@if ($allowEditExten || $allowDeleteExten)
								Operasi
							@endif
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($context->extensions() as $extension)
						<tr>
							<td>{{ $extension->extension }}</td>
							<td>{{ $extension->macro }}</td>
							@for ($i = 0; $i < 3; $i++)
								<td>
									@if (count($extension->params) > $i)
										{{ $extension->params[$i] }}
									@endif
								</td> 
							@endfor
							<td>
								@if ($allowEditExten)
									{!! Button::withValue('Rubah')->asLinkTo(url("/context/$context->category/$extension->extension"))->extraSmall() !!}
								@endif
								@if ($allowDeleteExten)
									{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url("/context/$context->category/$extension->extension")])->extraSmall() !!}
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="include-context">
			@can('add-include')
				{!! Button::withValue('Tambah Context')->asLinkTo(url("/context/$context->category/include")) !!}
			@endcan
			
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Context</th>
						<th>
							@if ($allowDeleteInclude)
								Operasi
							@endif
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($context->include() as $includeContext)
						<tr>
							<td>{{ $includeContext }}</td>
							<td>
								@if ($allowDeleteInclude)
									{!! Button::danger('Hapus')->addAttributes(['class' => 'delete', 'data-url' => url("/context/$context->category/include/$includeContext")])->extraSmall() !!}
								@endif
							</td>
						</div>
					@endforeach
				<tbody>
			</table>
		</div>
	</div>
@endsection