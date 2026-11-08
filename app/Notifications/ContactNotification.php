<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ContactNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $contact;
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

     public function toArray(object $notifiable): array
    {
        return [
            'contact_id'    => $this->contact->id,
            'user_name'   => $this->contact->name,
            'email' => $this->contact->email,
            'subject'      => $this->contact->subject,
            'message'      => 'You Recived new contact.',
            'created_at'  => now()->toDateTimeString(),
        ];
    }
    public function databaseType(object $notifiable): string
    {
        return 'ContactNotification';
    }


    // broadcast
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'contact_id'    => $this->contact->id,
            'user_name'   => $this->contact->name,
            'email' => $this->contact->email,
            'subject'      => $this->contact->subject,
            'message'      => 'You Recived new contact.',
            'created_at'  => now()->toDateTimeString(),
        ]);
    }
    public function broadcastType(): string
    {
        return 'ContactNotification';
    }
}