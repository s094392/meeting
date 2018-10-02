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
    Route::post('meetings/start/{meeting_id}', 'MeetingsController@start');
    Route::post('meetings/end/{meeting_id}', 'MeetingsController@end');

    Route::apiResource('meetings', 'MeetingsController');
    
    Route::apiResource('attendees/meeting_id.user_id', 'AttendeesController')->except([
        'create', 'edit'
    ]);
    
    Route::get('tas', 'TAsController');
    
    Route::get('me', function (Request $request) {
        return json_encode($request->session()->get('user'));
    });
});


Route::get('/cssso/handle', 'SSOController');

Route::get('/login', 'LoginController')->name('login');

Route::post('/logout', function (Request $request) {
    $request->session()->flush();
    return;
});

Route::get('/{page}', function () {
    return view('vue');
})->where('page', '.*')->middleware('auth');
