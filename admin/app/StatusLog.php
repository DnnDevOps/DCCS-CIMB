<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    protected $table = 'status_log';
    protected $dates = ['started', 'finished'];
    protected $dateFormat = 'Y-m-d H:i:s.u';
    public $timestamps = false;
    
    public function session()
    {
        return $this->belongsTo('ObeliskAdmin\Session', 'session');
    }
    
    public function status()
    {
        return $this->belongsTo('ObeliskAdmin\Status', 'status');
    }

    public function scopeStarted($query, $begin, $finish)
    {
        if (!empty($begin) && !empty($finish)) {
            return $query->whereBetween('started', ["$begin 00:00:00", "$finish 23:59:59"]);
        }
        
        return $query;
    }

    public function scopeUsername($query, $username)
    {
        if (!empty($username)) {
            return $query->leftJoin('session', 'status_log.session', '=', 'session.id')->where('username', $username);
        }
        
        return $query;
    }
}
