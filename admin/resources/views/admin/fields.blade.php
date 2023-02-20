{!!
	ControlGroup::generate(
		BSForm::label('username', 'Username'),
		BSForm::text('username', $username, ['placeholder' => 'Hanya alfanumerik saja(Teks dan Angka)', 'required', 'maxlength' => 255])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('password', 'Password'),
		BSForm::password('password')
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('fullname', 'Full Name'),
		BSForm::text('fullname', $fullname, ['maxlength' => 50])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('role_id', 'Role'),
		BSForm::select('role_id', $roles, $role_id)
	)
!!}
{!! Button::primary('Simpan')->submit() !!}