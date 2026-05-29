<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CodeVerification extends Notification
{
    use Queueable;

    public $code;

    /**
     * Création d'une nouvelle instance de notification.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Définit les canaux d'envoi.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Représentation de l'e-mail.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre code de vérification AGesP')
            ->line('Bienvenue sur AGesP !')
            ->line('Votre code de vérification pour finaliser votre inscription est le :')
            ->line('CODE : ' . $this->code)
            ->line('Merci de saisir ce code dans le formulaire d\'inscription.')
            ->line('Merci de ne pas répondre à ce message.');
    }
}