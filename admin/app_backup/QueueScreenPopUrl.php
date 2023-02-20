<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class QueueScreenPopUrl extends Model
{
    protected $table = 'queue_screen_pop_url';
    protected $primaryKey = 'queue';
    protected $fillable = ['queue', 'screen_pop_url'];
    public $timestamps = false;
}
