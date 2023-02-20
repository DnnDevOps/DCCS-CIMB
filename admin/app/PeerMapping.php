<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class PeerMapping extends Model
{
    protected $table = 'peer_mapping';
    protected $primaryKey = 'peer';
    protected $fillable = ['peer'];
    public $timestamps = false;
}
