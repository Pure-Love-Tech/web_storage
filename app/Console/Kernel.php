<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('disposable:update')->cron('0 0 */7 * *');
        $schedule->command('files:delete-chunks')->cron('0 0 * * *');
        $schedule->command('files:delete-inactive')->cron('0 0 * * *');

        if (licenseType(2)) {
            $schedule->command('transactions:delete-unpaid')->cron('0 0 * * *');
            if (mailTemplate('subscription_expire_notification')->status && settings('subscription')->expire_notification != 0) {
                $schedule->command('subscriptions:expire-notification')->cron('0 0 * * *');
            }
            if (settings('subscription')->delete_expired != 0) {
                $schedule->command('subscriptions:expired-delete')->cron('0 0 * * *');
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}