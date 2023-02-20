{!!
	ControlGroup::generate(
		BSForm::label('username', 'Username'),
		BSForm::text('username', $username, ['placeholder' => 'Hanya alfanumerik saja(Teks dan Angka)', 'required', 'maxlength' => 20])
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
		BSForm::text('fullname', $fullname, ['maxlength' => 100])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('level', 'Level'),
		BSForm::select('level', ['Agent' => 'Agent', 'Supervisor' => 'Supervisor', 'Manager' => 'Manager'], $level)
	)
!!}
<div class="checkbox">
	<label>
		{!! BSForm::checkbox('manual_dial', true, $manual_dial) !!} Boleh Melakukan Panggilan Telepon
	</label>
</div>
<div class="checkbox">
	<label>
		{!! BSForm::checkbox('active', true, $active) !!} Status Aktif
	</label>
</div>
{!! Button::primary('Simpan')->submit() !!}