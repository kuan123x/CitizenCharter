<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EventStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;
    protected $status;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Event  $event
     * @param  string  $status
     * @return void
     */
    public function __construct($event, $status)
    {
        $this->event = $event;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'title' => 'Event Status Update',
            'description' => "Your event titled '{$this->event->title}' has been {$this->status}.",
            'dateTime' => now(),
        ];
    }
}
