<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permission';
    protected $fillable = ['permission'];
}
