<?php

namespace App\Http\Controllers;

use App\Meeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MeetingController extends Controller
{
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
                foreach ($status as $chosen) {
                    $query->orWhere('status', $chosen);
                }
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
        return Meeting::create($data);
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
        return Meeting::where("id", $meetingId)->first();
    }

    public function end($meetingId)
    {
        $time = Carbon::now();
        Meeting::where("id", $meetingId)->update(['status' => 3, 'end_time' => $time]);
        return Meeting::where("id", $meetingId)->first();
    }
}
