<?php

namespace Hanoivip\Download\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class IosDevicePending extends Notification implements ShouldQueue
{
    use Queueable;
    
    private $udid;
    
    public function __construct($udid)
    {
        $this->udid = $udid;
    }
    
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->line('New iOS device pending!')
        ->action('Provisioning', url('/'))
        ->line('Go to Admin to provision them!');
    }
    
    public function toArray($notifiable)
    {
        return [
            'udid' => $this->udid,
        ];
    }
}
