<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserAlert extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $icon;
    protected $color;

    public function __construct($title, $message, $icon = 'bell', $color = 'blue')
    {
        $this->title = $title;
        $this->message = $message;
        $this->icon = $icon;
        $this->color = $color;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'color' => $this->color,
        ];
    }
}
