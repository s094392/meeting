<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $incrementing = false;
    
    public function attendees()
    {
        return $this->hasMany('App\Attendee', 'user_id', 'id');
    }

    public function meetings()
    {
        return $this->hasManyThrough('App\Meeting', 'App\Attendee', 'user_id', 'id', 'id', 'meeting_id');
    }
}
