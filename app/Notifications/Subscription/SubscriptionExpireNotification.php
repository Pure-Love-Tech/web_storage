<?php

namespace App\Notifications\Subscription;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpireNotification extends Notification
{
    use Queueable;

    /**
     * The subscription associated with this object.
     *
     * @var mixed
     */
    public $subscription;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(mailTemplate('subscription_expire_notification')->subject)
            ->markdown('emails.default', [
                'body' => mailTemplate('subscription_expire_notification')->body,
                'short_codes' => [
                    '{{username}}' => $this->subscription->user->username,
                    '{{expiry_date}}' => dateFormat($this->subscription->expiry_at),
                    '{{link}}' => route('user.settings.subscription'),
                    '{{website_name}}' => settings('general')->site_name,
                ],
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
