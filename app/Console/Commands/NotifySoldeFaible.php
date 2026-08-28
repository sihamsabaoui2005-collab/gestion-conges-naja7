<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SoldeFaibleReminder;
use Illuminate\Console\Command;

class NotifySoldeFaible extends Command
{
    protected $signature = 'conges:notifier-solde-faible';
    protected $description = 'Notifie les employés dont le solde de congés est faible (moins de 5 jours), au maximum une fois tous les 30 jours';

    public function handle()
    {
        $seuil = 5;

        $employes = User::where('role', 'employe')
            ->where('notif_solde', true)
            ->where('solde_conges_annuel', '<', $seuil)
            ->get();

        $notifies = 0;

        foreach ($employes as $employe) {
            $dejaNotifie = $employe->notifications()
                ->where('type', SoldeFaibleReminder::class)
                ->where('created_at', '>=', now()->subDays(30))
                ->exists();

            if (! $dejaNotifie) {
                $employe->notify(new SoldeFaibleReminder($employe->solde_conges_annuel));
                $notifies++;
            }
        }

        $this->info($notifies.' employé(s) notifié(s) pour solde faible (sur '.$employes->count().' concerné(s)).');
    }
}