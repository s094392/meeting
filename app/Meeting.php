<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    const INIT = 1;
    const START = 2;
    const END = 3;
    const COMPLETE = 4;
    const ARCHIVE = 5;
    const CANCEL = 6;
    
    protected $fillable = ['title', 'description', 'group', 'scheduled_time',
                        'owner_id', 'record', 'status', 'request_money'];

    protected $appends = ['owner_name'];
    protected $hidden = ['owner'];
    
    public function getOwnerNameAttribute()
    {
        if ($this->owner) {
            return $this->owner->username;
        } else {
            return $this->owner_id;
        }
    }

    public function attendees()
    {
        return $this->hasMany('App\Attendee');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id', 'id');
    }

    public static function condition(Array $condition = [])
    {
    
        return function ($query) use ($condition) {
            $status    =  isset($condition['status'])    ? $condition['status']    : null;
            $group     =  isset($condition['group'])     ? $condition['group']     : null;
            $owner_id  =  isset($condition['owner_id'])  ? $condition['owner_id']  : null;
            $title     =  isset($condition['title'])     ? $condition['title']     : null;
            $startDate =  isset($condition['startDate']) ? $condition['startDate'] : null;
            $endDate   =  isset($condition['endDate'])   ? $condition['endDate']   : null;
            $sortBy    =  isset($condition['sortBy'])    ? $condition['sortBy']    : null;
            $desc      =  isset($condition['desc'])      ? $condition['desc']      : null;
            $attendees =  isset($condition['attendees']) ? $condition['attendees'] : null;

            $query->when($status, function ($query, $status) {
                if (is_array($status)) {
                    $query->whereIn('meetings.status', $status);
                } else {
                    $query->where('meetings.status', $status);
                }
            })->when($owner_id, function ($query, $owner_id) {
                return $query->where('owner_id', $owner_id);
            })->when($group, function ($query, $group) {
                return $query->where('group', $group);
            })->when($title, function ($query, $title) {
                return $query->where('title', 'like', '%'.$title.'%');
            })->when($startDate, function ($query, $startDate) {
                return $query->where('scheduled_time', '>=', $startDate);
            })->when($endDate, function ($query, $endDate) {
                return $query->where('scheduled_time', '<=', $endDate);
            })->when($attendees, function ($query, $attendees) {
                return $query->with('attendees');
            })->when($sortBy, function ($query, $sortBy) use ($desc) {
                return $query->when($desc, function ($query, $desc) use ($sortBy) {
                    return $query->orderBy($sortBy, 'desc');
                }, function ($query) use ($sortBy) {
                    return $query->orderBy($sortBy, 'asc');
                });
            }, function ($query) {
                return $query->orderBy('scheduled_time', 'desc');
            });
        };
    }
}
