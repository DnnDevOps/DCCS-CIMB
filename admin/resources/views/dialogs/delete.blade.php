{!!
	Modal::named('delete-dialog')
		->withTitle('Hapus Item')
		->withBody('Apakah anda yakin ingin menghapus item tersebut?')
		->withFooter(
			Form::open(['method' => 'DELETE', 'id' => 'delete-form']) .
				Button::primary('Hapus')->submit() .
				Button::withValue('Batal')->addAttributes(['data-dismiss' => 'modal']) .
			Form::close()
		);
!!}