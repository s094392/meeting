<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['title', 'description', 'group', 'scheduled_time',
                        'owner', 'record', 'status'];

    public function attendees()
    {
        return $this->hasMany('App\Attendee');
    }
}
