{!!
	ControlGroup::generate(
		BSForm::label('role', 'Role'),
		BSForm::text('role', $role, ['placeholder' => 'Nama role', 'required', 'maxlength' => 255])
	)
!!}
{!! Button::primary('Simpan')->submit() !!}