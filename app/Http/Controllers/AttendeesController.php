<?php

namespace App\Http\Controllers;

use Mail;
use App\Meeting;
use App\Attendee;
use Illuminate\Http\Request;

class AttendeesController extends Controller
{
    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Attendee  $attendee
     */
    public function sendMeetingCreated(Attendee $attendee)
    {
        // $meeting = Meeting::where("id", $attendee->meeting_id)->first();
        // $taMap = app('App\Http\Controllers\TAsController')->map();
        // $user = $taMap[$attendee->user_id];
        // $meeting->owner = $taMap[$meeting->owner];
        // $url = url('/') . '/detail/' . $meeting->id . '/properties';
        // Mail::send('emails.create', ['meeting' => $meeting, 'url' => $url], function ($m) use ($meeting, $user) {
        //     $m->sender('mllee@cs.nctu.edu.tw');
        //     $m->to($user . "@cs.nctu.edu.tw", "help");
        //     $m->subject(
        //         '[Meeting] [新開會通知] '.$meeting->title.' 會議將在 '.$meeting->scheduled_time.' 舉行'
        //     );
        // });
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
        Attendee::where('meeting_id', $meeting_id)->where('user_id', $user_id)->first()->update($request->all());
        $attendee =  Attendee::where('meeting_id', $meeting_id)->with('user')
                    ->where('user_id', $user_id)->first();
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
        $attendee = Attendee::where('meeting_id', $meeting_id)->where('user_id', $user_id)->delete();
        return 204;
    }
}
