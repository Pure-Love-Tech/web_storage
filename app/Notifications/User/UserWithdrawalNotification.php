<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWithdrawalNotification extends Notification
{
    use Queueable;

    public $withdrawal;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($withdrawal)
    {
        $this->withdrawal = $withdrawal;
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
        $withdrawal = $this->withdrawal;
        return (new MailMessage)
            ->subject(mailTemplate('user_withdrawal_notification')->subject)
            ->markdown('emails.default', [
                'body' => mailTemplate('user_withdrawal_notification')->body,
                'short_codes' => [
                    '{{username}}' => $withdrawal->user->username,
                    '{{request_id}}' => $withdrawal->id,
                    '{{downloads_earnings}}' => earnings($withdrawal->downloads_earnings),
                    '{{referrals_earnings}}' => earnings($withdrawal->referrals_earnings),
                    '{{total_amount}}' => earnings($withdrawal->total),
                    '{{withdrawal_method}}' => $withdrawal->method,
                    '{{withdrawal_account}}' => $withdrawal->account,
                    '{{status}}' => $withdrawal->statusName(),
                    '{{date}}' => dateFormat($withdrawal->created_at),
                    '{{link}}' => route('user.withdrawals.index'),
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