<?php

namespace App\Console\Commands\Subscriptions;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpiredDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expired-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired subscriptions and the account files and folders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (settings('subscription')->delete_expired != 0) {
            $subDaysDate = Carbon::now()->subDays(settings('subscription')->delete_expired);
            $subscriptions = Subscription::where('expiry_at', '<', $subDaysDate)->get();
            if ($subscriptions->count() > 0) {
                foreach ($subscriptions as $subscription) {
                    $user = $subscription->user;
                    if ($user->file_entries->count() > 0) {
                        foreach ($user->file_entries as $fileEntry) {
                            $fileEntry->deleteRecursive();
                        }
                    }
                    $subscription->sendSubscriptionDeletedNotification();
                    $subscription->delete();
                }
            }
        }
    }
}
