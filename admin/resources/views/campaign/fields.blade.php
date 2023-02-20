{!!
	ControlGroup::generate(
		BSForm::label('name', 'Nama Campaign'),
		BSForm::text('name', $name, ['placeholder' => 'Alfanumerik, underscore(_) dan dash(-)', 'required', 'maxlength' => 50])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('begin_time', 'Waktu Mulai'),
		BSForm::time('begin_time', $begin_time, ['required'])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('finish_time', 'Waktu Selesai'),
		BSForm::time('finish_time', $finish_time, ['required'])
	)
!!}
{!!
	ControlGroup::generate(
		BSForm::label('screen_pop_url', 'Screen Pop URL'),
		BSForm::text('screen_pop_url', $screen_pop_url, ['placeholder' => 'Contoh: http://SERVER_CRM/?customer_id=[CUSTOMER_ID]&campaign=[CAMPAIGN]&phone_number=[PHONE_NUMBER]'])
	)
!!}
{!! Button::primary('Simpan')->submit() !!}