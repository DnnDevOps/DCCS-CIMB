<?php

namespace ObeliskAdmin;

use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $table = 'disposition';
    protected $primaryKey = 'disposition';
    protected $fillable = ['disposition', 'skip_contact'];
    public $timestamps = false;
}
