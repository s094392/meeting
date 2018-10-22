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

class MeetingController extends Controller
{
    /**
     * Check expired meeting.
     *
     */
    private function checkMeetingCancel()
    {
        $meetings = Meeting::where('status', 1)->get();
        $time = Carbon::now();
        foreach ($meetings as $meeting) {
            if ($meeting->scheduled_time < $time->subMinutes(5)) {
                $meeting->update(['status' => Meeting::CANCEL]);
            }
        }
    }
    /**
     * Send an e-mail reminder to the user when created.
     *
     * @param  Meeting  $meeting
     */
    public function sendMeetingEmail(Meeting $meeting)
    {
        $attendees = $meeting->attendees();
        $users = [];
        foreach ($meeting->attendees as $attendee) {
            array_push($users, $attendee->user->username . "@cs.nctu.edu.tw");
        }
        Mail::send('emails.default', ['meeting' => $meeting], function ($m) use ($meeting, $users) {
            $m->sender('ccwwwapp@cs.nctu.edu.tw');
            $m->replyTo('wwwta@cs.nctu.edu.tw', 'wwwTa');
            if ($meeting->status==Meeting::CANCEL) {
                $m->subject('[Meeting] [會議取消通知] "' . $meeting->title);
            } elseif ($meeting->status==Meeting::COMPLETE) {
                $m->subject('[Meeting] [會議紀錄報告] "' . $meeting->title);
                $users[] = 'help@cs.nctu.edu.tw';
            } else {
                $m->subject('[Meeting] [會議更新通知] "' . $meeting->title);
            }
            $m->bcc($users);
        });
    }
    /**
     * Send an e-mail reminder to the user  when updated.
     *
     * @param  Meeting  $meeting
     */
    private function sendMeetingCreated(Meeting $meeting)
    {
        $recipients = [];
        foreach ($meeting->attendees as $attendee) {
            array_push($recipients, $attendee->user->username . "@cs.nctu.edu.tw");
        }
        $url = env('APP_URL') . "/detail/{$meeting->id}/properties";
        Mail::send('emails.default', ['meeting' => $meeting, 'url' => $url], function ($m) use ($meeting, $recipients) {
            $dt_start = Carbon::parse($meeting->scheduled_time)->format('Ymd\THis');
            $dt_stamp = Carbon::parse($meeting->created_at)->format('Ymd\THis');
            $description = str_replace("\n", "\n ", $meeting->description);
            $m->replyTo('wwwta@cs.nctu.edu.tw', 'wwwTa');
            $ics = array(
                "BEGIN:VCALENDAR",
                "PRODID:-//NCTU CSCC//Meeting",
                "VERSION:2.0",
                "CALSCALE:GREGORIAN",
                "METHOD:PUBLISH",
                "BEGIN:VTIMEZONE",
                "TZID:Asia/Taipei",
                "X-LIC-LOCATION:Asia/Taipei",
                "BEGIN:STANDARD",
                "TZOFFSETFROM:+0800",
                "TZOFFSETTO:+0800",
                "TZNAME:CST",
                "DTSTART:19700101T000000",
                "END:STANDARD",
                "END:VTIMEZONE",
                "BEGIN:VEVENT",
                "DTSTART:$dt_start",
                "DTSTAMP:$dt_stamp",
                "UID:{$meeting->id}",
                "ORGANIZER;CN={$meeting->owner_name}:mailto:{$meeting->owner_name}@cs.nctu.edu.tw",
                "DESCRIPTION:$description",
                "SEQUENCE:0",
                "STATUS:CONFIRMED",
                "SUMMARY:{$meeting->title}",
                "END:VEVENT",
                "END:VCALENDAR"
            );
            $ics = implode("\r\n", $ics);
            $m->attachData($ics, 'meeting.ics', ['mime' => "application/ics"]);
            $m->sender('ccwwwapp@cs.nctu.edu.tw');
            $m->subject("[Meeting] [新開會通知] {$meeting->title} 會議將在 {$meeting->scheduled_time} 舉行");
            $m->to($recipients);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->checkMeetingCancel();
        $per_page = Input::get('per_page');
        if (!$per_page) {
            $per_page = 10;
        }
        $meetings = Meeting::tap(Meeting::condition($request->all()))->with('owner')->paginate($per_page);
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
        $time = Carbon::now();
        if ($request->scheduled_time < $time) {
            return response(['message' => '不能開以前的會議喔'], 403);
        }
        $data['owner_id'] = session('user')['user_id'];
        $meeting = Meeting::create($data);
        $meeting->attendees()->createMany($request['attendees']);
        $this->sendMeetingCreated($meeting);
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
        $this->checkMeetingCancel();
        if (session('user')['user_id'] != $meeting->owner_id || $meeting->status == Meeting::CANCEL) {
            return response(['message' => '你沒權限'], 403);
        };
        if ($request->status - $meeting->status > 1) {
            return response(['message' => '你壞'], 403);
        }
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
        if (Input::Get('email') === 'true' || $meeting->status == Meeting::COMPLETE) {
            $this->sendMeetingEmail($meeting);
        }
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
        if (session('user')['user_id'] != $meeting->owner_id  || $meeting->status == Meeting::CANCEL) {
            return response(['message' => '你沒權限'], 403);
        };
        $meeting->update(['status' => Meeting::CANCEL]);
        $this->sendMeetingEmail($meeting);
        return $meeting;
    }

    public function start($meetingId)
    {
        $meeting = Meeting::where("id", $meetingId)->first();
        if (session('user')['user_id'] != $meeting->owner_id || $meeting->status != Meeting::INIT) {
            return response(['message' => '你壞或沒權限'], 403);
        };
        $time = Carbon::now();
        if ($time->subMinutes(5) > $meeting->scheduled_time) {
            return response(['message' => '超過時間囉'], 403);
        }
        Meeting::where("id", $meetingId)->update(['status' => Meeting::START, 'start_time' => $time]);
        return Meeting::where("id", $meetingId)->with(['owner', 'attendees.user'])->first();
    }

    public function end($meetingId)
    {
        $meeting = Meeting::where("id", $meetingId)->first();
        if (session('user')['user_id'] != $meeting->owner_id  || $meeting->status != Meeting::START) {
            return response(['message' => '你壞或沒權限'], 403);
        };
        $time = Carbon::now();
        Meeting::where("id", $meetingId)->update(['status' => Meeting::END, 'end_time' => $time]);
        return Meeting::where("id", $meetingId)->with(['owner', 'attendees.user'])->first();
    }
}
