<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CreateOrderNotification extends Notification
{
    use Queueable;


    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id'    => $this->order->id,
            'user_name'   => $this->order->user_name,
            'total_price' => $this->order->total_price,
            'status'      => $this->order->status,
            'message'     => 'New order has been paid successfully.',
            'created_at'  => now()->toDateTimeString(),
        ];
    }
    public function databaseType(object $notifiable): string
    {
        return 'CreateOrderNotification';
    }


    // broadcast
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'order_id'    => $this->order->id,
            'user_name'   => $this->order->user_name,
            'total_price' => $this->order->total_price,
            'status'      => $this->order->status,
            'message'     => 'New order has been paid successfully.',
            'created_at'  => now()->toDateTimeString(),
        ]);
    }
    public function broadcastType(): string
    {
        return 'CreateOrderNotification';
    }
}