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

Route::get('/cssso/handle', function (Request $request) {
    $url = $request->session()->get('redirect_url');
    if ($url) {
        $request->session()->forget('redirect_url');
        return redirect($url);
    }
    return redirect("/");
});

Route::get('/login', function () {
    if (session()->get('user')['id']) {
        return redirect("/");
    }
    return view('login');
});

Route::post('/logout', function (Request $request) {
    $request->session()->flush();
    return redirect("/login");
});

Route::get('/api/me', function (Request $request) {
    return json_encode($request->session()->get('user'));
});


Route::get('/{page}', function () {
    return view('vue');
})->where('page', '.*')->middleware('auth');
