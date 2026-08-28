<?php

namespace App\Console\Commands;

use App\Models\LeaveRequest;
use App\Models\User;
use App\Notifications\LeaveConflictDetected;
use Illuminate\Console\Command;

class NotifyLeaveConflicts extends Command
{
    protected $signature = 'conges:notifier-conflits';
    protected $description = 'Notifie les RH quand plusieurs employés du même département ont des congés qui se chevauchent';

    public function handle()
    {
        $enAttente = LeaveRequest::where('statut', 'en_attente')->with('user')->get();
        $rhs = User::where('role', 'rh')->get();
        $totalConflits = 0;

        foreach ($enAttente->groupBy(fn ($d) => $d->user->departement ?? 'Sans département') as $dep => $groupe) {
            if ($groupe->count() < 2) continue;

            $employesEnConflit = collect();

            foreach ($groupe as $a) {
                foreach ($groupe as $b) {
                    if ($a->id !== $b->id && $a->date_debut->lte($b->date_fin) && $b->date_debut->lte($a->date_fin)) {
                        $employesEnConflit->push($a->user_id);
                        $employesEnConflit->push($b->user_id);
                    }
                }
            }

            $employesEnConflit = $employesEnConflit->unique();

            if ($employesEnConflit->isNotEmpty()) {
                foreach ($rhs as $rh) {
                    $dejaNotifie = $rh->notifications()
                        ->where('type', LeaveConflictDetected::class)
                        ->where('created_at', '>=', now()->subDay())
                        ->whereJsonContains('data->message', $dep)
                        ->exists();

                    if (! $dejaNotifie) {
                        $rh->notify(new LeaveConflictDetected($dep, $employesEnConflit->count()));
                    }
                }
                $totalConflits++;
            }
        }

        $this->info($totalConflits.' conflit(s) de département notifié(s).');
    }
}