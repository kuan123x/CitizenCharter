<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
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
            'title' => 'New Event Created',
            'description' => 'A new event titled "' . $this->event->title . '" has been created and is awaiting approval.',
            'dateTime' => now(),
        ];
    }
}
