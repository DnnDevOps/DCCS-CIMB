{!!
	ControlGroup::generate(
		BSForm::label('peer', 'Nama Peer'),
		BSForm::text('peer', $peer, ['placeholder' => 'Alfanumerik, underscore(_) dan dash(-)', 'required'])
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
        BSForm::label('context', 'Context'),
        BSForm::select('context', $contexts, $context)
    )
!!}
{!! Button::primary('Simpan')->submit() !!}