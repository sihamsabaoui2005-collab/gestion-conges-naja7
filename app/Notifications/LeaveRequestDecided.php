<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveRequestDecided extends Notification
{
    use Queueable;

    protected LeaveRequest $leaveRequest;

    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
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
        $approuve = $this->leaveRequest->statut === 'approuve';

        return [
            'leave_request_id' => $this->leaveRequest->id,
            'statut'           => $this->leaveRequest->statut,
            'titre'            => $approuve ? 'Demande approuvée' : 'Demande refusée',
            'message'          => $approuve
                ? "Ta demande du {$this->leaveRequest->date_debut->format('d M Y')} au {$this->leaveRequest->date_fin->format('d M Y')} a été approuvée."
                : "Ta demande du {$this->leaveRequest->date_debut->format('d M Y')} au {$this->leaveRequest->date_fin->format('d M Y')} a été refusée.",
            'icone'            => $approuve ? 'check-circle-2' : 'x-circle',
            'couleur'          => $approuve ? 'green' : 'red',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $approuve = $this->leaveRequest->statut === 'approuve';

        return (new MailMessage)
            ->subject($approuve ? 'Ta demande de congé a été approuvée' : 'Ta demande de congé a été refusée')
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line($approuve
                ? "Ta demande du {$this->leaveRequest->date_debut->format('d M Y')} au {$this->leaveRequest->date_fin->format('d M Y')} a été approuvée."
                : "Ta demande du {$this->leaveRequest->date_debut->format('d M Y')} au {$this->leaveRequest->date_fin->format('d M Y')} a été refusée.")
            ->action('Voir mes demandes', route('conges.mesDemandes'))
            ->line('Merci d’utiliser NAJA7 HOST.');
    }
}