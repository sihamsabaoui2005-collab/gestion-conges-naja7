<?php

namespace App\Exports;

use App\Models\SavedReport;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class RapportCongesExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    protected SavedReport $rapport;

    protected array $typeLabels = [
        'paye' => 'Congé annuel',
        'rtt' => 'RTT',
        'exceptionnel' => 'Exceptionnel',
        'maladie' => 'Maladie',
        'sans_solde' => 'Sans solde',
        'autre' => 'Autre',
    ];

    public function __construct(SavedReport $rapport)
    {
        $this->rapport = $rapport;
    }

    /**
     * Force une valeur numérique vide/nulle à 0 au lieu de laisser la cellule vide.
     */
    protected function num($valeur): int|float
    {
        return ($valeur === null || $valeur === '') ? 0 : $valeur;
    }

    /**
     * Force une valeur texte vide/nulle à un tiret au lieu de laisser la cellule vide.
     */
    protected function txt($valeur): string
    {
        return ($valeur === null || $valeur === '') ? '—' : (string) $valeur;
    }

    public function array(): array
    {
        $d = $this->rapport->donnees ?? [];
        $lignes = [];

        $lignes[] = ['Titre', $this->txt($this->rapport->titre)];
        $lignes[] = ['Période', $this->txt(($d['periode_debut'] ?? '') . ' — ' . ($d['periode_fin'] ?? ''))];
        if (!empty($this->rapport->resume_ia)) {
            $lignes[] = ['Résumé', $this->txt($this->rapport->resume_ia)];
        }
        $lignes[] = [];

        $lignes[] = ['Indicateur', 'Valeur'];
        $lignes[] = ['Demandes totales', (int) ($d['demandes_totales'] ?? 0)];
        $lignes[] = ['Approuvées', (int) ($d['approuvees'] ?? 0)];
        $lignes[] = ['En attente', (int) ($d['en_attente'] ?? 0)];
        $lignes[] = ['Refusées', (int) ($d['refusees'] ?? 0)];
        $lignes[] = ['Jours utilisés', (int) ($d['jours_utilises'] ?? 0)];
        $lignes[] = ["Taux d'approbation (%)", (int) ($d['taux_approbation'] ?? 0)];
        $lignes[] = ['Taux de refus (%)', (int) ($d['taux_refus'] ?? 0)];
        $lignes[] = ['Durée moyenne (jours)', (float) ($d['duree_moyenne'] ?? 0)];
        $lignes[] = ['Délai moyen de traitement (jours)', (float) ($d['delai_moyen_traitement'] ?? 0)];
        $lignes[] = ['Employés concernés', (int) ($d['nb_employes_concernes'] ?? 0)];
        $lignes[] = ['Départements analysés', (int) ($d['nb_departements'] ?? 0)];

        if (!empty($d['detail_par_type'])) {
            $lignes[] = [];
            $lignes[] = ['Détail par type de congé'];
            $lignes[] = ['Type', 'Demandes', 'Jours pris', "Taux d'approbation (%)"];
            foreach ($d['detail_par_type'] as $type => $info) {
                $lignes[] = [
                    $this->txt($this->typeLabels[$type] ?? $type),
                    $this->num($info['demandes'] ?? 0),
                    $this->num($info['jours'] ?? 0),
                    $this->num($info['taux_approbation'] ?? 0),
                ];
            }
        } elseif (!empty($d['repartition_par_type'])) {
            $lignes[] = [];
            $lignes[] = ['Répartition par type'];
            foreach ($d['repartition_par_type'] as $type => $valeur) {
                $lignes[] = [$this->txt($this->typeLabels[$type] ?? $type), $this->num($valeur)];
            }
        }

        if (!empty($d['departements_stats'])) {
            $lignes[] = [];
            $lignes[] = ['Classement des départements'];
            $lignes[] = ['Département', 'Effectif', 'Demandes', 'Jours pris', 'Jours moy./employé', "Taux d'approbation (%)"];
            foreach ($d['departements_stats'] as $dept => $info) {
                $lignes[] = [
                    $this->txt($dept),
                    $this->num($info['effectif'] ?? 0),
                    $this->num($info['demandes'] ?? 0),
                    $this->num($info['jours'] ?? 0),
                    $this->num($info['moyenne_par_employe'] ?? 0),
                    $this->num($info['taux_approbation'] ?? 0),
                ];
            }
        } elseif (!empty($d['repartition_par_departement'])) {
            $lignes[] = [];
            $lignes[] = ['Jours par département'];
            foreach ($d['repartition_par_departement'] as $dept => $valeur) {
                $lignes[] = [$this->txt($dept), $this->num($valeur)];
            }
        }

        if (!empty($d['top_departements_demandes'])) {
            $lignes[] = [];
            $lignes[] = ['Top départements (demandes)'];
            foreach ($d['top_departements_demandes'] as $dept => $valeur) {
                $lignes[] = [$this->txt($dept), $this->num($valeur)];
            }
        }

        if (!empty($d['comparaison_periodes'])) {
            $lignes[] = [];
            $lignes[] = ['Comparaison 1ère / 2e moitié de la période'];
            $lignes[] = ['Département', '1ère moitié', '2e moitié', 'Évolution (%)'];
            foreach ($d['comparaison_periodes'] as $dept => $info) {
                $lignes[] = [
                    $this->txt($dept),
                    $this->num($info['periode_1'] ?? 0),
                    $this->num($info['periode_2'] ?? 0),
                    $this->num($info['evolution'] ?? 0),
                ];
            }
        }

        if (!empty($d['top_employes_detail'])) {
            $lignes[] = [];
            $lignes[] = ['Top employés (détail)'];
            $lignes[] = ['Employé', 'Département', 'Jours pris', 'Demandes', 'Type dominant'];
            foreach ($d['top_employes_detail'] as $nom => $info) {
                $lignes[] = [
                    $this->txt($nom),
                    $this->txt($info['departement'] ?? ''),
                    $this->num($info['jours'] ?? 0),
                    $this->num($info['demandes'] ?? 0),
                    $this->txt($this->typeLabels[$info['type_dominant'] ?? ''] ?? ($info['type_dominant'] ?? '')),
                ];
            }
        } elseif (!empty($d['top_employes'])) {
            $lignes[] = [];
            $lignes[] = ['Top employés (jours utilisés)'];
            foreach ($d['top_employes'] as $nom => $valeur) {
                $lignes[] = [$this->txt($nom), $this->num($valeur)];
            }
        }

        if (!empty($d['tendance_mensuelle'])) {
            $lignes[] = [];
            $lignes[] = ['Tendance mensuelle'];
            foreach ($d['tendance_mensuelle'] as $mois => $valeur) {
                $libelleMois = Carbon::createFromFormat('Y-m', $mois)->translatedFormat('F Y');
                $lignes[] = [$this->txt($libelleMois), $this->num($valeur)];
            }
        }

        return $lignes;
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return substr($this->rapport->titre, 0, 31);
    }
}