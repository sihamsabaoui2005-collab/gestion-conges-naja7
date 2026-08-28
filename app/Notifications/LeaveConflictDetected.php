<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveConflictDetected extends Notification
{
    use Queueable;

    protected string $departement;
    protected int $nombreEmployes;

    public function __construct(string $departement, int $nombreEmployes)
    {
        $this->departement = $departement;
        $this->nombreEmployes = $nombreEmployes;
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
            'titre'   => 'Conflit de dates détecté',
            'message' => "{$this->nombreEmployes} employés du département {$this->departement} ont des demandes de congé qui se chevauchent.",
            'icone'   => 'triangle-alert',
            'couleur' => 'red',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Conflit de dates de congé détecté')
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line("{$this->nombreEmployes} employés du département {$this->departement} ont des demandes de congé qui se chevauchent.")
            ->action('Voir les demandes', route('conges.index'))
            ->line('Merci d’utiliser NAJA7 HOST.');
    }
}