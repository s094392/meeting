<?php

namespace App\Http\Controllers;

use App\Meeting;
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
        $offset =  Input::get('offset');
        $sortby =  Input::get('sortby');
        $desc = Input::get('desc');
        
        return Meeting::when($status, function ($query, $status) {
            foreach ($status as $chosen) {
                $query->orWhere('status', $chosen);
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
        })->when($offset, function ($query, $offset) {
            return $query->skip($offset);
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
        })->get();
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
        return 204;
    }
}
