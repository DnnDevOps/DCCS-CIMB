<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class User extends Model
{
    protected $primaryKey = 'username';
    protected $fillable = ['username', 'password', 'fullname', 'level', 'manual_dial', 'active'];
    public $timestamps = false;

    public function setPasswordAttribute($value)
    {
        if (!empty($value))
            $this->attributes['password'] = hash('sha256', $value . $this->attributes['username']);
    }

    public function setManualDialAttribute($value)
    {
        $this->attributes['manual_dial'] = (bool) $value;
    }

    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = (bool) $value;
    }

    public function group()
    {
        return $this->belongsToMany('ObeliskAdmin\User', 'groups', 'member', 'leader');
    }

    public function groupMember()
    {
        if ($this->level == 'Supervisor')
            return $this->belongsToMany('ObeliskAdmin\User', 'groups', 'leader', 'member');
        else
            return new Collection;
    }

    public function session()
    {
        return $this->hasMany('ObeliskAdmin\Session', 'username');
    }

    public function callLog()
    {
        return $this->hasMany('ObeliskAdmin\CallLog', 'username');
    }

    public function callMonitorLog()
    {
        return $this->hasMany('ObeliskAdmin\CallMonitorLog', 'username');
    }

    public function contact()
    {
        return $this->hasMany('ObeliskAdmin\Contact', 'username');
    }

    public function scopeAgent($query)
    {
        return $this->where('level', 'Agent');
    }

    public function scopeSupervisor($query)
    {
        return $query->where('level', 'Supervisor');
    }

    public function scopeSearch($query)
    {
        return $this->orderBy('username');
    }

    public function scopeUsernameIs($query, $username)
    {
        if (!empty($username)) {
            return $query->where('username', 'ilike', "%$username%");
        }
        return $query;
    }

    public function scopeFullnameIs($query, $fullname)
    {
        if (!empty($fullname)) {
            return $query->where('fullname', 'ilike', "%$fullname%");
        }
        return $query;
    }

    public function scopeStatusIs($query, $status)
    {
        if (!empty($status)) {
            if ($status == 'Aktif') {
                return $query->where('active', true);
            } else {
                return $query->where('active', false);
            }
        }
        return $query;
    }

    public function scopeNotInGroup($query, $leader)
    {
        // return $query->join('groups', 'users.username', '=', 'groups.member')
        //              ->where('leader', '!=', $leader)
        //              ->orWhereNull('leader');
        return $query;
    }

    public function scopeNotInQueue($query, $queue)
    {
        return $query;
    }
}
