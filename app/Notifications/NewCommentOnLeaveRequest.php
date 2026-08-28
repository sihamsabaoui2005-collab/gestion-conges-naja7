<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentOnLeaveRequest extends Notification
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
        return [
            'leave_request_id' => $this->leaveRequest->id,
            'titre'            => 'Nouveau commentaire RH',
            'message'          => "Le RH a laissé un commentaire sur ta demande du {$this->leaveRequest->date_debut->format('d M Y')} au {$this->leaveRequest->date_fin->format('d M Y')}.",
            'icone'            => 'message-circle',
            'couleur'          => 'blue',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau commentaire sur ta demande de congé')
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line("Le RH a laissé un commentaire sur ta demande du {$this->leaveRequest->date_debut->format('d M Y')} au {$this->leaveRequest->date_fin->format('d M Y')}.")
            ->action('Voir mes demandes', route('conges.mesDemandes'))
            ->line('Merci d’utiliser NAJA7 HOST.');
    }
}