<?php

namespace ObeliskAdmin;

use Redis;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaign';
    protected $primaryKey = 'name';
    protected $fillable = ['name', 'begin_time', 'finish_time', 'screen_pop_url'];
    public $timestamps = false;
    
    protected function convertToTime($value)
    {
        $parsed = date_parse($value);
        
        return ($parsed['hour'] ? $parsed['hour'] : '00') . ':' . ($parsed['minute'] ? $parsed['minute'] : '00');
    }
    
    public function setBeginTimeAttribute($value)
    {
        $this->attributes['begin_time'] = $this->convertToTime($value);
    }
    
    public function setFinishTimeAttribute($value)
    {
        $this->attributes['finish_time'] = $this->convertToTime($value);
    }
    
    public function contact()
    {
        return $this->hasMany('ObeliskAdmin\Contact', 'campaign');
    }
    
    public function started()
    {
        return Redis::hget($this->attributes['name'], 'started') != NULL;
    }
}
