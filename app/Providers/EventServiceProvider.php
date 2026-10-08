<?php

namespace App\Providers;

use App\Events\Registered;
use App\Events\TransactionCreated;
use App\Events\WithdrawalCreated;
use App\Listeners\Admin\SendTransactionNotification;
use App\Listeners\Admin\SendWithdrawalNotification;
use App\Listeners\Auth\CreateReferral;
use App\Listeners\Auth\SendEmailVerificationNotification;
use App\Listeners\Files\CreateDefaultFolders;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            CreateDefaultFolders::class,
            CreateReferral::class,
        ],
        TransactionCreated::class => [
            SendTransactionNotification::class,
        ],
        WithdrawalCreated::class => [
            SendWithdrawalNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }
}