<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['title', 'description', 'team', 'scheduled_time', 'owner', 'record', 'status'];
}
