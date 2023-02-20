<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'session';
    protected $dates = ['logged_in', 'logged_out'];
    protected $dateFormat = 'Y-m-d H:i:s.u';
    public $timestamps = false;
    
    public function statusLog()
    {
        return $this->hasMany('ObeliskAdmin\StatusLog', 'session');
    }
    
    public function scopeLoggedIn($query, $begin, $finish)
    {
        if (!empty($begin) && !empty($finish)) {
            return $query->whereBetween('logged_in', ["$begin 00:00:00", "$finish 23:59:59"]);
        }
        
        return $query;
    }

    public function scopeUsername($query, $username)
    {
        if (!empty($username)) {
            return $query->where('username', $username);
        }
        
        return $query;
    }
}
