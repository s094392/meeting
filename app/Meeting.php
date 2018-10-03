<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['title', 'description', 'group', 'scheduled_time',
                        'owner_id', 'record', 'status', 'request_money'];

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

    public static function filter(Array $condition = [])
    {
    
        return function ($query) use ($condition) {
            $status    =  isset($condition['status'])    ? $condition['status']    : null;
            $limit     =  isset($condition['limit'])     ? $condition['limit']     : null;
            $group     =  isset($condition['group'])     ? $condition['group']     : null;
            $owner     =  isset($condition['owner'])     ? $condition['owner']     : null;
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
            })->when($owner, function ($query, $owner) {
                return $query->where('owner', $owner);
            })->when($group, function ($query, $group) {
                return $query->where('group', $group);
            })->when($title, function ($query, $title) {
                return $query->where('title', 'like', '%'.$title.'%');
            })->when($startDate, function ($query, $startDate) {
                return $query->where('scheduled_time', '>=', $startDate);
            })->when($endDate, function ($query, $endDate) {
                return $query->where('scheduled_time', '<=', $endDate);
            })->when($limit, function ($query, $limit) {
                return $query->take($limit);
            })->when($attendees, function ($query, $attendees) {
                return $query->with('attendees');
            })->when($sortBy, function ($query, $sortBy) use ($desc) {
                return $query->when($desc, function ($query, $desc) use ($sortBy) {
                    return $query->orderBy($sortBy, 'desc');
                }, function ($query) use ($sortBy) {
                    return $query->orderBy($sortBy);
                });
            }, function ($query) {
                return $query->orderBy('scheduled_time', 'desc');
            });
        };
    }
}
