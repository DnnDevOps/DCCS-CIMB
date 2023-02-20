<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'status';
    protected $fillable = ['status'];
    public $timestamps = false;
    
    public function statusLog()
    {
        return $this->hasMany('ObeliskAdmin\StatusLog', 'status');
    }
}
