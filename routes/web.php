<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

Route::prefix('api/')->middleware('auth:api')->group(function () {
    Route::post('meeting/start/{meetingId}', 'MeetingController@start');
    Route::post('meeting/end/{meetingId}', 'MeetingController@end');

    Route::apiResource('meeting', 'MeetingController')->except([
        'create', 'edit'
    ]);
    
    Route::apiResource('attendee/meeting_id.user_id', 'AttendeeController')->except([
        'create', 'edit'
    ]);
    
    Route::prefix('tas/')->group(function () {
        Route::get('list', 'TAsController@list');
        Route::get('grouped', 'TAsController@grouped');
        Route::get('map', 'TAsController@map');
    });
    
    Route::get('me', function (Request $request) {
        return json_encode($request->session()->get('user'));
    });
});


Route::get('/cssso/handle', function (Request $request) {
    $user = $request->session()->get('user');
    $user["user_id"] = $user["id"];
    $user["username"] = $user["uid"];
    $request->session()->put('user', $user);
    $url = $request->session()->get('redirect_url');
    if ($url) {
        $request->session()->forget('redirect_url');
        return redirect($url);
    }
    return redirect("/");
});

Route::get('/login', function () {
    if (!Input::get("expired") && session()->get('user')['id']) {
        return redirect("/");
    }
    return view('login', ["APP_URL" => env("APP_URL", ""),
                            "expired"=> Input::get("expired")]);
})->name('login');

Route::post('/logout', function (Request $request) {
    $request->session()->flush();
    return redirect("/login");
});


Route::get('/{page}', function () {
    return view('vue');
})->where('page', '.*')->middleware('auth');
