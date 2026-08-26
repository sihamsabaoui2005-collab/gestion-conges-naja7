<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SoldeFaibleReminder extends Notification
{
    use Queueable;

    protected int $soldeRestant;

    public function __construct(int $soldeRestant)
    {
        $this->soldeRestant = $soldeRestant;
    }

    public function via(object $notifiable): array
    {
        $channels = ['database'];
        if ($notifiable->notif_email) {
            $channels[] = 'mail';
        }
        return $channels;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'titre'   => 'Solde de congés faible',
            'message' => "Il te reste seulement {$this->soldeRestant} jour(s) de congés cette année.",
            'icone'   => 'battery-warning',
            'couleur' => 'red',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ton solde de congés est faible')
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line("Il te reste seulement {$this->soldeRestant} jour(s) de congés annuels cette année.")
            ->action('Voir mon solde', route('conges.solde'))
            ->line('Pense à planifier tes prochains congés si besoin.');
    }
}