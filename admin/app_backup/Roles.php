<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = ['role'];

    public function permissions()
    {
        $permissions = $this->belongsToMany('ObeliskAdmin\Permission', 'roles_permission', 'role_id')
                            ->get(['permission.id'])
                            ->pluck('id')
                            ->all();

        return $permissions;
    }

    public function permitted($permissionName)
    {
        $permission = $this->belongsToMany('ObeliskAdmin\Permission', 'roles_permission', 'role_id')
                           ->where('permission', $permissionName)
                           ->first();
        
        return $permission != null;
    }
}
