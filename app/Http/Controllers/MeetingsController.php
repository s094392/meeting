<?php

namespace App\Http\Controllers;

use Mail;
use App\Meeting;
use App\Attendee;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use View\UserController;

class MeetingsController extends Controller
{

    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Meeting  $meeting
     */
    public function sendMeetingUpdated(Meeting $meeting)
    {
        // $attendees = Attendee::where('meeting_id', $meeting->id)->get();
        // $taMap = app('App\Http\Controllers\TAsController')->map();
        // $users = array();
        // foreach ($attendees as $val) {
        //     $users[] = $taMap[$val['user_id']] . '@cs.nctu.edu.tw';
        // }
        // $url = url('/') . '/detail/' . $meeting->id . '/properties';
        // $meeting->owner = $taMap[$meeting->owner];
        // Mail::send('emails.create', ['meeting' => $meeting, 'url' => $url], function ($m) use ($meeting, $users) {
        //     $m->sender('mllee@cs.nctu.edu.tw');
        //     $m->subject('[Meeting] [異動通知] "' . $meeting->title . '" 會議異動');
        //     $m->bcc($users);
        // });
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
        $sortBy =  Input::get('sortBy');
        $desc = Input::get('desc');
        $attendees = Input::get('attendees');

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
        })->when($sortBy, function ($query, $sortBy) use ($desc) {
            return $query->when($desc, function ($query, $desc) use ($sortBy) {
                return $query->orderBy($sortBy, 'desc');
            }, function ($query) use ($sortBy) {
                return $query->orderBy($sortBy);
            });
        }, function ($query) {
            return $query->orderBy('scheduled_time', 'desc');
        })->with('owner')->when($attendees, function ($query, $attendees) {
            return $query->with('attendees');
        })->paginate(10);
        $meetings->data = $meetings->makeHidden('record');
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
        $data['owner_id'] = session('user')['user_id'];
        $meeting = Meeting::create($data);
        $meeting->attendees()->createMany($request['attendees']);
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
        return $meeting->load('owner')->load('attendees.user');
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
        if (isset($request['attendees'])) {
            foreach ($request['attendees'] as $val) {
                $meeting->attendees()->
                updateOrCreate(['user_id' => $val['user_id'], 'meeting_id' => $meeting['id']], $val);
            }
            $original_attendees_id = $meeting->attendees->pluck('user_id')->toArray();
            foreach ($original_attendees_id as $id) {
                if (!in_array($id, array_column($request['attendees'], 'user_id'))) {
                    $meeting->attendees()->where('user_id', $id)->delete();
                };
            }
        }
        $this->sendMeetingUpdated($meeting);
        return $meeting->load('attendees.user');
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
        return Meeting::where("id", $meetingId)->with(['owner', 'attendees.user'])->first();
    }

    public function end($meetingId)
    {
        $time = Carbon::now();
        Meeting::where("id", $meetingId)->update(['status' => 3, 'end_time' => $time]);
        return Meeting::where("id", $meetingId)->with(['owner', 'attendees.user'])->first();
    }
}