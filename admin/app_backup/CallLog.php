<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    protected $table = 'call_log';
    public $timestamps = false;
    
    public function user()
    {
        $this->belongsTo('ObeliskAdmin\User', 'username');
    }
    
    public function scopeStartTime($query, $begin, $finish)
    {
        if (!empty($begin) && !empty($finish)) {
            return $query->whereBetween('start_time', ["$begin 00:00:00", "$finish 23:59:59"]);
        }
        
        return $query;
    }

    public function scopeCustomerId($query, $customerId)
    {
        if (!empty($customerId)) {
            return $query->where('customer_id', 'like', "%$customerId%");
        }

        return $query;
    }
    
    public function scopeCampaign($query, $campaign)
    {
        if (!empty($campaign)) {
            return $query->where('campaign', 'like', "%$campaign%");
        }

        return $query;
    }
    
    public function scopeSource($query, $source)
    {
        if (!empty($source)) {
            return $query->where('source', 'like', "%$source%");
        }
        
        return $query;
    }
    
    public function scopeDestination($query, $destination)
    {
        if (!empty($destination)) {
            return $query->where('destination', 'like', "%$destination%");
        }
        
        return $query;
    }
    
    public function scopeFavoriteNumber($query)
    {
        return $query->select(\DB::raw('MAX(username) AS username, destination, SUM(duration) AS duration, COUNT(destination) AS total_call'))
                     ->where('destination', '<>', 's')
                     ->groupBy('destination')
                     ->orderBy('total_call', 'desc');
        
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
