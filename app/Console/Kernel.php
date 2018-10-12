<?php

namespace App\Console;

use App\Meeting;
use App\User;
use Mail;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $tas = app('App\Http\Controllers\TAsController')->__invoke()['cs-ta'];
            foreach ($tas as $val) {
                $user = User::where('id', $val['user_id'])->first();
                if (!$user) {
                    continue;
                }
                $this_day = Carbon::now()->subDay();
                $meetings = $user->meetings()->where('meetings.updated_at', '>=', $this_day)->get();
                if ($meetings->count()) {
                    Mail::send('emails.update', ['meetings' => $meetings], function ($m) use ($user) {
                        $m->sender('mllee@cs.nctu.edu.tw');
                        $m->subject('[Meeting] [本日會議異動]');
                        $m->to($user->username . "@cs.nctu.edu.tw");
                    });
                }
            }
        })->daily()->at('12:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
