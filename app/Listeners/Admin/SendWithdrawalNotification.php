<?php

namespace App\Listeners\Admin;

use App\Events\WithdrawalCreated;
use App\Models\Backend\Admin;

class SendWithdrawalNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\WithdrawalCreated  $event
     * @return void
     */
    public function handle(WithdrawalCreated $event)
    {
        $withdrawal = $event->withdrawal;

        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->sendWithdrawalNotification($withdrawal);
        }

        $title = admin_trans('New Withdrawal Request') . ' #' . $withdrawal->id;
        $image = asset('images/notifications/withdrawal.png');
        $link = route('admin.withdrawals.edit', $withdrawal->id);

        adminNotify($title, $image, $link);
    }
}
