<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = ['meeting_id', 'user_id', 'status', 'delay_time', 'reason'];
    
    public function getRouteKey()
    {
        error_log($this->meeting_id . $this->user_id);
        return array($this->meeting_id, $this->user_id);
    }
}
