{!!
	ControlGroup::generate(
		BSForm::label('context', 'Nama Context'),
		BSForm::text('context', $context, ['placeholder' => 'Alfanumerik, underscore(_) dan dash(-)', 'required'])
	)
!!}
{!! Button::primary('Simpan')->submit() !!}