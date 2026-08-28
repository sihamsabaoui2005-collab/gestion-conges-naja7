<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UrgentLeaveRequestReminder extends Notification
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
        $nom = $this->leaveRequest->user->name ?? 'Un employé';

        return [
            'leave_request_id' => $this->leaveRequest->id,
            'titre'            => 'Demande urgente à traiter',
            'message'          => "La demande de {$nom} commence le {$this->leaveRequest->date_debut->format('d M Y')} et est encore en attente.",
            'icone'            => 'alarm-clock',
            'couleur'          => 'red',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $nom = $this->leaveRequest->user->name ?? 'Un employé';

        return (new MailMessage)
            ->subject('Demande de congé urgente à traiter')
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line("La demande de {$nom} commence le {$this->leaveRequest->date_debut->format('d M Y')} et est encore en attente de décision.")
            ->action('Traiter la demande', route('conges.show', $this->leaveRequest->id))
            ->line('Merci d’utiliser NAJA7 HOST.');
    }
}