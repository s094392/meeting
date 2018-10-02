<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $incrementing = false;
    
    public function attendee()
    {
        return $this->hasMany('App\attendee');
    }

    public function meetings()
    {
        return $this->hasMany('App\Meeting');
    }
}
