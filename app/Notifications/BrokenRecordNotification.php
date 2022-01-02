<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class BrokenRecordNotification extends Notification
{
    use Queueable;

    /** @var string */
    private string $exercise;

    /** @var string */
    private string $champion;

    /** @var string */
    private string $record;

    public function __construct(string $exercise, string $champion, string $record)
    {
        $this->exercise = $exercise;
        $this->champion = $champion;
        $this->record = $record;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    /**
     * @param mixed $notifiable
     * @return \NotificationChannels\WebPush\WebPushMessage
     */
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage())
            ->icon('/static/favicon.ico')
            ->data(['url' => config('app.url')])
            ->title(trans('Your record has been broken!'))
            ->body(trans('Your record at :exercise has been broken by :user, who set a new personal record of :record.', [
                'exercise' => $this->exercise,
                'user' => $this->champion,
                'record' => $this->record,
            ]));
    }
}
