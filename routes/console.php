<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Vérifie chaque jour les demandes urgentes (date de début proche, encore en attente) et notifie les RH
Schedule::command('conges:notifier-urgences')->daily();

// Vérifie chaque jour les conflits de dates entre employés d'un même département et notifie les RH
Schedule::command('conges:notifier-conflits')->daily();

// Vérifie chaque jour les soldes de congés faibles et notifie les employés concernés
Schedule::command('conges:notifier-solde-faible')->daily();