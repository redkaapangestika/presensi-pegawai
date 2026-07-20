<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PegawaiActivityNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $tipe; // masuk, pulang, izin
    protected $url;

    public function __construct($title, $message, $tipe, $url = '#')
    {
        $this->title = $title;
        $this->message = $message;
        $this->tipe = $tipe;
        $this->url = $url;
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
            'tipe' => $this->tipe,
            'url' => $this->url
        ];
    }
}
