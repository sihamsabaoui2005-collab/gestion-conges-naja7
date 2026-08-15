<?php

namespace App\Livewire\Conges;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class NouvelleDemande extends Component
{
    use WithFileUploads;

    // ===== 01. Type de congé =====
    // Clés alignées sur celles déjà utilisées ailleurs dans le projet (paye, maladie, sans_solde)
    // + 3 nouvelles clés pour matcher la maquette (exceptionnel, rtt, autre).
    public string $type = 'paye';

    public array $types = [
        'paye'         => ['label' => 'Congé annuel',        'icon' => 'calendar'],
        'maladie'      => ['label' => 'Congé maladie',       'icon' => 'heart-pulse'],
        'exceptionnel' => ['label' => 'Congé exceptionnel',  'icon' => 'star'],
        'rtt'          => ['label' => 'RTT / Récupération',  'icon' => 'clock'],
        'autre'        => ['label' => 'Autre congé',         'icon' => 'ellipsis'],
    ];

    // ===== 02. Période de congé =====
    public ?string $dateDebut = null;
    public ?string $dateFin = null;

    // ===== 03. Motif =====
    public string $motif = '';
    public int $motifMax = 300;

    // ===== 04. Justificatif =====
    public $justificatif = null;

    // ===== Calendrier (colonne droite) =====
    public string $moisAffiche;

    public function mount(): void
    {
        $this->moisAffiche = now()->format('Y-m');
    }

    // ===== Calculs dérivés =====
    public function getJoursOuvresProperty(): int
    {
        if (!$this->dateDebut || !$this->dateFin) {
            return 0;
        }

        try {
            $debut = Carbon::parse($this->dateDebut);
            $fin = Carbon::parse($this->dateFin);
        } catch (\Exception $e) {
            return 0;
        }

        if ($fin->lt($debut)) {
            return 0;
        }

        // NAJA7 HOST est ouvert du lundi au samedi ; seul le dimanche n'est pas travaillé.
        $jours = 0;
        $curseur = $debut->copy();
        while ($curseur->lte($fin)) {
            if ($curseur->dayOfWeekIso !== 7) { // 7 = dimanche
                $jours++;
            }
            $curseur->addDay();
        }

        return $jours;
    }

    public function getSoldeActuelProperty(): int
    {
        return (int) (auth()->user()->solde_conges_annuel ?? 0);
    }

    public function getJoursCalendrierProperty(): array
    {
        $mois = Carbon::createFromFormat('Y-m', $this->moisAffiche)->startOfMonth();
        $debutGrille = $mois->copy()->startOfWeek(Carbon::MONDAY);
        $finGrille = $mois->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $debutRange = $this->dateDebut ? Carbon::parse($this->dateDebut) : null;
        $finRange = $this->dateFin ? Carbon::parse($this->dateFin) : null;

        $semaines = [];
        $semaine = [];
        $curseur = $debutGrille->copy();

        while ($curseur->lte($finGrille)) {
            $dansMoisCourant = $curseur->month === $mois->month;
            $dansRange = $debutRange && $finRange
                && $curseur->betweenIncluded($debutRange->copy()->startOfDay(), $finRange->copy()->endOfDay());

            $semaine[] = [
                'jour' => $curseur->day,
                'date' => $curseur->format('Y-m-d'),
                'dansMoisCourant' => $dansMoisCourant,
                'dansRange' => $dansRange,
                'estDebut' => $debutRange && $curseur->isSameDay($debutRange),
                'estFin' => $finRange && $curseur->isSameDay($finRange),
                'estAujourdhui' => $curseur->isToday(),
            ];

            if ($curseur->dayOfWeekIso === 7) {
                $semaines[] = $semaine;
                $semaine = [];
            }

            $curseur->addDay();
        }

        return $semaines;
    }

    public function getLibelleMoisProperty(): string
    {
        return Carbon::createFromFormat('Y-m', $this->moisAffiche)->translatedFormat('F Y');
    }

    public function moisPrecedent(): void
    {
        $this->moisAffiche = Carbon::createFromFormat('Y-m', $this->moisAffiche)->subMonth()->format('Y-m');
    }

    public function moisSuivant(): void
    {
        $this->moisAffiche = Carbon::createFromFormat('Y-m', $this->moisAffiche)->addMonth()->format('Y-m');
    }

    public function selectionnerType(string $type): void
    {
        $this->type = $type;
    }

    protected function rules(): array
    {
        return [
            'type' => 'required|in:paye,maladie,exceptionnel,rtt,autre',
            'dateDebut' => 'required|date|after_or_equal:today',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'motif' => 'nullable|string|max:1000',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function soumettre(): void
    {
        $this->validate();

        if ($this->type === 'paye' && $this->joursOuvres > $this->soldeActuel) {
            $this->addError('dateFin', "Solde insuffisant. Tu demandes {$this->joursOuvres} jour(s) mais il te reste {$this->soldeActuel} jour(s).");
            return;
        }

        $cheminJustificatif = $this->justificatif
            ? $this->justificatif->store('justificatifs', 'public')
            : null;

        LeaveRequest::create([
            'user_id' => auth()->id(),
            'type' => $this->type,
            'date_debut' => $this->dateDebut,
            'date_fin' => $this->dateFin,
            'jours' => $this->joursOuvres,
            'motif' => $this->motif ?: null,
            'justificatif_path' => $cheminJustificatif,
            'statut' => 'en_attente',
        ]);

        session()->flash('success', 'Ta demande de congé a été envoyée. Elle est en attente de validation.');
        $this->redirectRoute('dashboard');
    }

    public function render()
    {
        return view('livewire.conges.nouvelle-demande');
    }
}