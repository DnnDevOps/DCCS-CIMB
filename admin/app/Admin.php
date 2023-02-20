<?php

namespace ObeliskAdmin;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use ObeliskAdmin\Roles;

class Admin extends Model implements AuthenticatableContract,
                                     AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'fullname', 'role_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    public function setPasswordAttribute($value)
    {
        if (!empty($value))
            $this->attributes['password'] = bcrypt($value);
    }

    public function role()
    {
        return $this->belongsTo('ObeliskAdmin\Roles', 'role_id');
    }
}
