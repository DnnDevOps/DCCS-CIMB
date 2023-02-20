<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class UserTextLog extends Model
{
    protected $table = 'user_text_log';
    public $timestamps = false;
    
    public function sender()
    {
        $this->belongsTo('ObeliskAdmin\User', 'username');
    }
    
    public function recipient()
    {
        $this->belongsTo('ObeliskAdmin\User', 'username');
    }
    
    public function scopeSentTime($query, $begin, $finish)
    {
        if (!empty($begin) && !empty($finish)) {
            return $this->whereBetween('sent', [$begin, $finish]);
        }
        
        return $this;
    }
    
    public function scopeSenderIs($query, $sender)
    {
        if (!empty($sender)) {
            return $query->where('sender', $sender);
        }
        
        return $query;
    }
    
    public function scopeRecipientIs($query, $recipient)
    {
        if (!empty($recipient)) {
            return $query->where('recipient', $recipient);
        }
        
        return $query;
    }
}
