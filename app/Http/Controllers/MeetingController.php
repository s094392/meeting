<?php

namespace App\Http\Controllers;

use Mail;
use App\Meeting;
use App\Attendee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use View\UserController;

class MeetingController extends Controller
{

    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Meeting  $meeting
     */
    public function sendMeetingUpdated(Meeting $meeting)
    {
        $attendees = Attendee::where('meeting_id', $meeting->id)->get();
        $taMap = app('App\Http\Controllers\TAsController')->map();
        $users = array();
        foreach ($attendees as $val) {
            $users[] = $taMap[$val['user_id']] . '@cs.nctu.edu.tw';
        }
        $url = url('/') . '/detail/' . $meeting->id . '/properties';
        $meeting->owner = $taMap[$meeting->owner];
        Mail::send('emails.create', ['meeting' => $meeting, 'url' => $url], function ($m) use ($meeting, $users) {
            $m->sender('mllee@cs.nctu.edu.tw');
            $m->subject('[Meeting] [異動通知] "' . $meeting->title . '" 會議異動');
            $m->bcc($users);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status =  Input::get('status');
        $limit =  Input::get('limit');
        $group =  Input::get('group');
        $owner =  Input::get('owner');
        $title =  Input::get('title');
        $startDate =  Input::get('startDate');
        $endDate =  Input::get('endDate');
        $sortby =  Input::get('sortby');
        $desc = Input::get('desc');
        $page = Input::get('page');
        
        $meetings = Meeting::when($status, function ($query, $status) {
            if (is_array($status)) {
                $query->whereIn('status', $status);
            } else {
                $query->where('status', $status);
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
        })->when($sortby, function ($query, $sortby) {
            return $query->when($desc, function ($query, $desc) {
                return $query->orderBy($sortby, 'desc');
            }, function ($query) {
                return $query->orderBy($sortby);
            });
        }, function ($query) {
            return $query->orderBy('scheduled_time', 'desc');
        });

        $meetings = $page ? $meetings->paginate(10) : $meetings->get();
        $taMap = app('App\Http\Controllers\TAsController')->map();
        ($page ? $meetings->getCollection() : $meetings)->transform(function ($val) use ($taMap) {
            $val['owner_name'] = $taMap[$val['owner']];
            return $val;
        });
        return $meetings;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['owner'] = session('user')['user_id'];
        $data['status'] = 1;
        $meeting = Meeting::create($data);
        return $meeting;
    }

        /**
        * Display the specified resource.
        *
        * @param  \App\Meeting  $meeting
        * @return \Illuminate\Http\Response
        */
    public function show(Meeting $meeting)
    {
        $taMap = app('App\Http\Controllers\TAsController')->map();
        $meeting['owner_name'] = $taMap[$meeting['owner']];
        return $meeting;
    }

        /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \App\Meeting  $meeting
        * @return \Illuminate\Http\Response
        */
    public function update(Request $request, Meeting $meeting)
    {
        $meeting->update($request->all());
        $taMap = app('App\Http\Controllers\TAsController')->map();
        $meeting['owner_name'] = $taMap[$meeting['owner']];
        $this->sendMeetingUpdated($meeting);
        return $meeting;
    }

        /**
        * Remove the specified resource from storage.
        *
        * @param  \App\Meeting  $meeting
        * @return \Illuminate\Http\Response
        */
    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return response('', 204);
    }

    public function start(Meeting $meeting, $meetingId)
    {
        $time = Carbon::now();
        Meeting::where("id", $meetingId)->update(['status' => 2, 'start_time' => $time]);
        $taMap = app('App\Http\Controllers\TAsController')->map();
        $meeting = Meeting::where("id", $meetingId)->first();
        $meeting['owner_name'] = $taMap[$meeting['owner']];
        return $meeting;
    }

    public function end($meetingId)
    {
        $time = Carbon::now();
        Meeting::where("id", $meetingId)->update(['status' => 3, 'end_time' => $time]);
        $taMap = app('App\Http\Controllers\TAsController')->map();
        $meeting = Meeting::where("id", $meetingId)->first();
        $meeting['owner_name'] = $taMap[$meeting['owner']];
        return $meeting;
    }
}
