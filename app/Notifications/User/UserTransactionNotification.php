<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserTransactionNotification extends Notification
{
    use Queueable;

    public $transaction;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
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
        $transaction = $this->transaction;
        return (new MailMessage)
            ->subject(mailTemplate('user_transaction_notification')->subject)
            ->markdown('emails.default', [
                'body' => mailTemplate('user_transaction_notification')->body,
                'short_codes' => [
                    '{{username}}' => $transaction->user->username,
                    '{{transaction_id}}' => $transaction->id,
                    '{{amount}}' => priceSymbol($transaction->price),
                    '{{status}}' => $transaction->statusName(),
                    '{{gateway}}' => $transaction->paymentGateway->name ?? '--',
                    '{{date}}' => dateFormat($transaction->created_at),
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