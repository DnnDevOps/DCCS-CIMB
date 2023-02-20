@section('styles')
	@parent
	
	{!! Html::style('css/trunk.css') !!}
@endsection

@section('scripts')
	@parent
	
	{!! Html::script('js/trunk.js') !!}
@endsection

{!!
	ControlGroup::generate(
		BSForm::label('trunk', 'Nama Trunk'),
		BSForm::text('trunk', $trunk, ['placeholder' => 'Alfanumerik, underscore(_) dan dash(-)', 'required', 'maxlength' => 79])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('defaultuser', 'Username'),
		BSForm::text('defaultuser', $defaultuser, ['placeholder' => 'Alfanumerik, underscore(_) dan dash(-)', 'required'])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('secret', 'Password'),
		BSForm::password('secret')
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('host', 'Host'),
		BSForm::text('host', $host, ['required'])
	)
!!}
{!!
    ControlGroup::generate(
        BSForm::label('context', 'Context'),
        BSForm::select('context', $contexts, $context)
    )
!!}
{!!
    ControlGroup::generate(
        BSForm::label('custom', 'Custom Fields'),
        Table::withContents(isset($customFields) ? $customFields : [
			[
				'Field' => BSForm::text('field[]', ''),
				'Value' => BSForm::text('value[]', '')
			]
		])->withAttributes(['id' => 'custom-fields'])
    )
!!}
{!! Button::withValue('Tambah Field')->withAttributes(['id' => 'add-field']) !!}
{!! Button::primary('Simpan')->submit() !!}