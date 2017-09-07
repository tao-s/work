<?php namespace App\Console;

use Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\Inspire',
        'App\Console\Commands\DeleteExpiredUpgradesCommand',
        'App\Console\Commands\RandomizeJobsTableCommand',
        'App\Console\Commands\CreateSitemapCommand',
        'App\Console\Commands\DailyMailJobCommand',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $yesterday = Carbon::yesterday()->format('Y-m-d');
//        $schedule->command("delete-expired-upgrades {$yesterday}")->dailyAt('01:00');
        $schedule->command("randomize-jobs-table")->dailyAt('01:05');
        $schedule->command("create-sitemap")->dailyAt('01:10');
        $schedule->command("daily-mail-job")->dailyAt('01:15');
    }

}
