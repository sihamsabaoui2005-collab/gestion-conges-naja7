<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeaveRequestSubmitted extends Notification
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
            'titre'            => 'Nouvelle demande de congé',
            'message'          => "{$nom} a soumis une demande du {$this->leaveRequest->date_debut->format('d M Y')} au {$this->leaveRequest->date_fin->format('d M Y')}.",
            'icone'            => 'calendar-plus',
            'couleur'          => 'blue',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $nom = $this->leaveRequest->user->name ?? 'Un employé';

        return (new MailMessage)
            ->subject('Nouvelle demande de congé à traiter')
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line("{$nom} a soumis une demande de congé du {$this->leaveRequest->date_debut->format('d M Y')} au {$this->leaveRequest->date_fin->format('d M Y')}.")
            ->action('Voir la demande', route('conges.show', $this->leaveRequest->id))
            ->line('Merci d’utiliser NAJA7 HOST.');
    }
}