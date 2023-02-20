{!!
	ControlGroup::generate(
		BSForm::label('status', 'Status'),
		BSForm::text('status', $status, ['required', 'maxlength' => 20])
	)
!!}
{!! Button::primary('Simpan')->submit() !!}