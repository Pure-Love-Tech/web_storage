<?php

namespace App\Listeners\Admin;

use App\Events\TransactionCreated;
use App\Models\Backend\Admin;

class SendTransactionNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\TransactionCreated  $event
     * @return void
     */
    public function handle(TransactionCreated $event)
    {
        $transaction = $event->transaction;

        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->sendTransactionNotification($transaction);
        }

        $title = admin_trans('New Pending Transaction') . ' #' . $transaction->id;
        $image = asset('images/notifications/transaction.png');
        $link = route('admin.premium.transactions.edit', $transaction->id);

        adminNotify($title, $image, $link);
    }
}
