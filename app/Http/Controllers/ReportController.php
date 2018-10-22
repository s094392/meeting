<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meeting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class ReportController extends Controller
{
    /**
     * return the weekly report.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $meetings = Meeting::where('updated_at', '>', Carbon::now()->subWeek())->where('status', 4)->get();
        $report = "";
        foreach ($meetings as $meeting) {
            if ($meeting->request_money) {
                $duration = Carbon::parse($meeting->end_time)->diffInMinutes(Carbon::parse($meeting->start_time));
            } else {
                $duration = '1';
            }
            foreach ($meeting->attendees as $val) {
                if ($val->status == 2) {
                    $uniq_start = Carbon::parse($meeting->start_time);
                    if ($val->arrive_time) {
                        $uniq_start = Carbon::parse($val->arrive_time);
                    }
                    $uniq_end = Carbon::parse($meeting->end_time);
                    if ($val->leave_time) {
                        $uniq_end = Carbon::parse($val->leave_time);
                    }
                    $uniq_duration = $uniq_end->diffInMinutes($uniq_start);
                    $report .= "Meeting {$meeting->group}/$meeting->id $val->user_id {$uniq_duration}\n";
                } else {
                    $report .= "Meeting {$meeting->group}/{$meeting->id} {$val->user_id} {$duration}\n";
                }
            }
            if (Input::Get('archive')==1) {
                $meeting->update(array('status' => 5));
            }
        }
        return response($report, 200);
    }
}
