<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RestockAlert extends Notification
{
    use Queueable;

    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Alerte de réapprovisionnement')
                    ->line('Le produit ' . $this->product->name . ' nécessite un réapprovisionnement.')
                    ->action('Voir le produit', url('/products/' . $this->product->id));
    }
}
