<?php

namespace App\Http\Controllers;

use Mail;
use App\Meeting;
use App\Attendee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    /**
     * Send an e-mail reminder to the owner when updated.
     *
     * @param  Attendee  $attendee
     */
    public function sendUpdateEmail(Attendee $attendee)
    {
        $meeting = $attendee->meeting();
        Mail::send(
            'emails.attendee',
            ['meeting' => $meeting, 'attendee' => $attendee],
            function ($m) use ($meeting, $attendee) {
                $m->sender('ccwwwapp@cs.nctu.edu.tw');
                $m->replyTo('wwwta@cs.nctu.edu.tw', 'wwwTa');
                $m->subject("[Meeting] [會議參加者狀態更新] {$meeting->title} " .
                "{$attendee->getUsernameAttribute()} {$attendee->getStatus()}");
                $m->to($meeting->getOwnerNameAttribute() . '@cs.nctu.edu.tw');
            }
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @param  int $meeting_id
     * @return \Illuminate\Http\Response
     */
    public function index($meeting_id)
    {
        $attendees = Attendee::where('meeting_id', $meeting_id)->with('user')->get();
        return $attendees;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $meeting_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $meeting_id)
    {
        $meeting = Meeting::where('id', $meeting_id)->first();
        if ($meeting->status == 5) {
            return response(['message' => '你壞'], 403);
        }
        if ($meeting->owner_id != session('user')['user_id']) {
            return response(['message' => '你沒權限'], 403);
        }
        $data = $request->all();
        $data['meeting_id'] = $meeting_id;
        $attendee = Attendee::create($data);
        $this->sendMeetingCreated($attendee);
        return $attendee;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $meeting_id
     * @param  string $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($meeting_id, $user_id)
    {
        $attendee = Attendee::where('meeting_id', $meeting_id)->with('user')
                    ->where('user_id', $user_id)->first();
        return $attendee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $meeting_id
     * @param  string $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $meeting_id, $user_id)
    {
        $meeting = Meeting::where('id', $meeting_id)->first();
        if ($meeting->status == 5) {
            return response(['message' => '你壞'], 403);
        }
        $attendee = Attendee::where('meeting_id', $meeting_id)->with('user')
                    ->where('user_id', $user_id)->first();
        if ($meeting->owner_id != session('user')['user_id']) {
            if ($meeting->status != 1) {
                return response(['message' => '你沒權限'], 403);
            }
            if ($attendee->updated_at > Carbon::now()->subSecond(10)) {
                return response(['message' => '你不要狂按'], 403);
            }
        }
        if ($request->status == Attendee::NOTONTIME && ($request->arrive_time &&
                ($meeting->start_time > $request->arrive_time) ||
                $request->leave_time && ($meeting->end_time < $request->leave_time))) {
            return response(['message' => '你不要亂打時間'], 403);
        }
        Attendee::where('meeting_id', $meeting_id)->where('user_id', $user_id)->first()->update($request->all());
        $attendee =  Attendee::where('meeting_id', $meeting_id)->with('user')
                    ->where('user_id', $user_id)->first();
        $this->sendUpdateEmail($attendee);
        return $attendee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $meeting_id
     * @param  string $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($meeting_id, $user_id)
    {
        if ($meeting->status == 5) {
            return response(['message' => '你壞'], 403);
        }
        if ($meeting->owner_id != session('user')['user_id']) {
            return response(['message' => '你沒權限'], 403);
        }
        $attendee = Attendee::where('meeting_id', $meeting_id)->where('user_id', $user_id)->delete();
        return 204;
    }
}
