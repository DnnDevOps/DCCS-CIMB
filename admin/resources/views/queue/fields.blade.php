{!!
	ControlGroup::generate(
		BSForm::label('queue', 'Queue'),
		BSForm::text('queue', $queue, ['placeholder' => 'Nama queue inbound'])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('strategy', 'Strategy'),
		BSForm::select('strategy', $strategies, $strategy)
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('servicelevel', 'Service Level Seconds'),
		BSForm::number('servicelevel', $servicelevel, ['placeholder' => 'Berapa detik batas Service Level'])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('screen_pop_url', 'Screen Pop URL'),
		BSForm::text('screen_pop_url', $screen_pop_url, ['placeholder' => 'Contoh: http://SERVER_CRM/?queue=[QUEUE]&phone_number=[PHONE_NUMBER]&username=[USERNAME]'])
	)
!!}
{!! Button::primary('Simpan')->submit() !!}