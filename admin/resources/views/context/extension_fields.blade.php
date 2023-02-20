@section('scripts')
	@parent
	
	{!! Html::script('js/extension.js') !!}
@endsection

{!!
    ControlGroup::generate(
        BSForm::label('extension', 'Extension'),
        BSForm::text('extension', $extension, ['required', 'placeholder' => 'Alfanumerik, underscore(_) dan dash(-)'])
    )
!!}
{!!
    ControlGroup::generate(
        BSForm::label('macro', 'Macro'),
        BSForm::select('macro', [
            'dial-trunk' => 'dial-trunk',
            'dial-peer' => 'dial-peer',
            'enter-queue' => 'enter-queue'
        ], $macro)
    )
!!}
{!!
    ControlGroup::generate(
        BSForm::label('trunk', 'Trunk'),
        BSForm::select('trunk', $trunks, $trunk)
    )->withAttributes(['id' => 'trunk-field'])
!!}
{!!
    ControlGroup::generate(
        BSForm::label('peer', 'Peer'),
        BSForm::select('peer', $peers, $peer)
    )->withAttributes(['id' => 'peer-field', 'class' => 'hidden'])
!!}
{!!
    ControlGroup::generate(
        BSForm::label('queue', 'Queue'),
        BSForm::select('queue', $queues, $queue)
    )->withAttributes(['id' => 'queue-field', 'class' => 'hidden'])
!!}
{!!
    ControlGroup::generate(
        BSForm::label('destination', 'Nomor Tujuan'),
        BSForm::text('destination', empty($destination) ? '${EXTEN}' : $destination, ['required'])
    )->withAttributes(['id' => 'destination-field'])
!!}
<div id="record-field" class="checkbox">
	<label>
		{!! BSForm::checkbox('record', true, $record == 'RECORD') !!} Record Call
	</label>
</div>
{!! Button::primary('Simpan')->submit() !!}