{!!
	ControlGroup::generate(
		BSForm::label('disposition', 'Disposition'),
		BSForm::text('disposition', $disposition, ['required', 'maxlength' => 45])
	)
!!}
<div class="checkbox">
	<label>
		{!! BSForm::checkbox('skip_contact', true, $skip_contact) !!} Skip Contact
	</label>
</div>
{!! Button::primary('Simpan')->submit() !!}