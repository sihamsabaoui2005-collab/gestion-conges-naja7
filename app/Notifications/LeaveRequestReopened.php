<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LeaveRequestReopened extends Notification
{
    use Queueable;

    public function __construct(public LeaveRequest $leaveRequest)
    {
    }

    public function via($notifiable)
    {
        $channels = ['database'];

        if ($notifiable->notif_email) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toDatabase($notifiable)
    {
        return [
            'titre'            => 'Décision annulée',
            'message'          => 'Votre demande de congé a été remise en attente par le RH.',
            'icone'            => 'rotate-ccw',
            'couleur'          => 'blue',
            'leave_request_id' => $this->leaveRequest->id,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre demande de congé a été remise en attente')
            ->line('La décision précédente sur votre demande de congé a été annulée par le service RH.')
            ->line('Votre demande est de nouveau en attente de validation.')
            ->action('Voir ma demande', route('conges.mesDemandes'));
    }
}