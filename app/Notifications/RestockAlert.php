<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RestockAlert extends Notification
{
    use Queueable;

    protected $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['mail']; // Envoyer l'alerte par e-mail
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Alerte de réapprovisionnement : ' . $this->product->name)
            ->line('Le stock du produit ' . $this->product->name . ' est faible.')
            ->action('Voir le produit', url('/products/' . $this->product->id));
    }
}
