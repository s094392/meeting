<?php

namespace App\Http\Controllers;

use App\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Attendee::all();
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
        return Attendee::create($data);
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
        $attendee = Attendee::where('meeting_id', $meeting_id)->where('user_id', $user_id)->first();
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
        Attendee::where('meeting_id', $meeting_id)->where('user_id', $user_id)->update($request->all());
        $attendee =  Attendee::where('meeting_id', $meeting_id)->where('user_id', $user_id)->first();
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
