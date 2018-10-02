<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['title', 'description', 'group', 'scheduled_time',
                        'owner_id', 'record', 'status'];

    protected $appends = ['owner_name'];
    protected $hidden = ['owner'];
    
    public function getOwnerNameAttribute()
    {
        return $this->owner->username;
    }

    public function attendees()
    {
        return $this->hasMany('App\Attendee');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id', 'id');
    }
}
