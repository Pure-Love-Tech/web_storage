<?php

namespace App\Console\Commands\Subscriptions;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send and email to the user to inform about subscription expire';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (mailTemplate('subscription_expire_notification')->status && settings('subscription')->expire_notification != 0) {
            $subscriptions = Subscription::where('expiry_at', '<', Carbon::now())->where('expire_notification', 0)->get();
            if ($subscriptions->count() > 0) {
                foreach ($subscriptions as $subscription) {
                    $subscription->sendSubscriptionExpireNotification();
                    $subscription->expire_notification = true;
                    $subscription->update();
                }
            }
        }
    }
}
