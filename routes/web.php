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
    Route::post('meetings/start/{meeting_id}', 'MeetingController@start');
    Route::post('meetings/end/{meeting_id}', 'MeetingController@end');

    Route::apiResource('meetings', 'MeetingController');

    Route::apiResource('users', 'UserController')->only([
        'show', 'index'
    ]);
    
    Route::apiResource('attendees/meeting_id.user_id', 'AttendeeController');
    
    Route::get('tas', 'TAsController');
    
    Route::get('me', function (Request $request) {
        return json_encode($request->session()->get('user'));
    });
});

Route::get('/cssso/handle', 'SSOController');

Route::get('/login', function () {
    return view('login', ["APP_URL" => env("APP_URL", ""), "CSSSO_SERVER" => env("CSSSO_SERVER", "")]);
})->name('login');

Route::get('/logout', function (Request $request) {
    session()->flush();
    return;
});

Route::get('/report', 'ReportController');

Route::get('/save_route_before_redirect', function (Request $request) {
    session([ 'redirect_url' => $request->get('route') ]);
    return '';
});

Route::get('/{page}', function () {
    return view('vue');
})->where('page', '.*')->middleware('auth');
