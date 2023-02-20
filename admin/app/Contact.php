<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;
    
    public function campaign()
    {
        return $this->belongsTo('ObeliskAdmin\Campaign', 'campaign');
    }
    
    public function user()
    {
        return $this->belongsTo('ObeliksAdmin\User', 'username');
    }
    
    public function scopeCampaignUsers($query, $campaign)
    {
        return $query->where('campaign', $campaign)->whereNotNull('username')->groupBy('username')->get(['username']);
    }
}
