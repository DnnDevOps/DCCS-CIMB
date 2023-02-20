<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class IvrRecording extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ivr_recording';

    protected $primaryKey = 'conference';
}
