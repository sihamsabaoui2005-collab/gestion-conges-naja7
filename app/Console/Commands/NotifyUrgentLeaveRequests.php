<?php

namespace App\Console\Commands;

use App\Models\LeaveRequest;
use App\Models\User;
use App\Notifications\UrgentLeaveRequestReminder;
use Illuminate\Console\Command;

class NotifyUrgentLeaveRequests extends Command
{
    protected $signature = 'conges:notifier-urgences';
    protected $description = 'Notifie les RH des demandes en attente dont la date de début arrive dans moins de 7 jours';

    public function handle()
    {
        $seuil = now()->addDays(7);

        $demandesUrgentes = LeaveRequest::where('statut', 'en_attente')
            ->where('date_debut', '<=', $seuil)
            ->with('user')
            ->get();

        if ($demandesUrgentes->isEmpty()) {
            $this->info('Aucune demande urgente.');
            return;
        }

        $rhs = User::where('role', 'rh')->get();

        foreach ($demandesUrgentes as $demande) {
            foreach ($rhs as $rh) {
                // Évite de renotifier si une notif identique existe déjà pour cette demande
                $dejaNotifie = $rh->notifications()
                    ->where('type', UrgentLeaveRequestReminder::class)
                    ->whereJsonContains('data->leave_request_id', $demande->id)
                    ->exists();

                if (! $dejaNotifie) {
                    $rh->notify(new UrgentLeaveRequestReminder($demande));
                }
            }
        }

        $this->info($demandesUrgentes->count().' demande(s) urgente(s) notifiée(s).');
    }
}