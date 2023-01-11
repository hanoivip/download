<?php

namespace Hanoivip\Download\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class IosInstallReady extends Notification implements ShouldQueue
{
    use Queueable;
    
    public function via($notifiable)
    {
        return ['database', 'email'];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->line('The introduction to the notification.')
        ->action('Notification Action', url('/'))
        ->line('Thank you for using our application!');
    }
    
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
