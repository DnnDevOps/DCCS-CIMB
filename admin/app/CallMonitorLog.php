<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class CallMonitorLog extends Model
{
    protected $table = 'call_monitor_log';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    
    public function user()
    {
        $this->belongsTo('ObeliskAdmin\User', 'username');
    }
}
