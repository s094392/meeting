<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Attendee extends Model
{
    protected $fillable = ['status', 'delay_time', 'reason', 'absent_reason',
        'arrive_time', 'late_reason', 'leave_time', 'leave_early_reason', 'meeting_id', 'user_id'];
    protected $primaryKey = ['user_id', 'meeting_id'];
    public $incrementing = false;

    protected $hidden = ['user'];
    protected $appends = ['username'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getUsernameAttribute()
    {
        if ($this->user) {
            return $this->user->username;
        } else {
            return $this->user_id;
        }
    }

    public function getRouteKey()
    {
        return array($this->meeting_id, $this->user_id);
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
