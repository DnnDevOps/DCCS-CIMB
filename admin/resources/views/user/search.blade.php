<div class="row">
    <div class="col-xs-4">
        {!!
        ControlGroup::generate(
        BSForm::label('username', 'Username'),
        BSForm::text('username', isset($username) ? $username : null, ['placeholder' => 'Username yang dicari'])
        )
        !!}
    </div>
    <div class="col-xs-4">
        {!!
        ControlGroup::generate(
        BSForm::label('fullname', 'Full Name'),
        BSForm::text('fullname', isset($fullname) ? $fullname : null, ['placeholder' => 'Fullname yang dicari'])
        )
        !!}
    </div>
    <div class="col-xs-4">
        {!!
        ControlGroup::generate(
        BSForm::label('status', 'Status'),
        BSForm::select('status', ['' => '', 'Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif'],$status)
        )
        !!}
    </div>
</div>
{!! Button::primary('Cari')->withAttributes(['class' => 'action-button'])->submit() !!}