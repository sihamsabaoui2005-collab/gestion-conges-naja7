<div class="min-h-screen bg-[#0b0e1a] text-slate-200 p-6">

    {{-- ===== Barre du haut ===== --}}
    <div class="flex items-center justify-between mb-8">
        <div class="relative w-96">
            <input type="text" placeholder="Rechercher..."
                class="w-full bg-[#131728] border border-white/5 rounded-xl py-2.5 pl-4 pr-4 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="flex items-center gap-4">
            <button class="relative w-10 h-10 rounded-full bg-[#131728] flex items-center justify-center">
                🔔
                @if ($this->demandes_en_attente > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center">
                        {{ $this->demandes_en_attente }}
                    </span>
                @endif
            </button>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-500/30 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="text-sm">
                    <p class="font-medium text-white">{{ auth()->user()->name ?? 'Utilisateur' }}</p>
                    <p class="text-slate-500">{{ auth()->user()->poste ?? 'Employé(e)' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== En-tête ===== --}}
    <h1 class="text-3xl font-semibold text-white mb-1">Bonjour, {{ explode(' ', auth()->user()->name ?? 'Utilisateur')[0] }} 👋</h1>
    <p class="text-slate-500 mb-8">Voici un aperçu de vos congés et absences.</p>

    {{-- ===== Cartes statistiques ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

        {{-- Solde disponible --}}
        <div class="bg-[#131728] rounded-2xl p-5 border border-white/5">
            <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center mb-4">📅</div>
            <p class="text-slate-400 text-sm mb-1">Solde disponible</p>
            <p class="text-3xl font-semibold text-white">{{ $this->solde_disponible }} <span class="text-base font-normal text-slate-400">jours</span></p>
            <p class="text-slate-500 text-sm mt-1">de congés restants</p>
        </div>

        {{-- Demandes en attente --}}
        <div class="bg-[#131728] rounded-2xl p-5 border border-white/5">
            <div class="w-10 h-10 rounded-full bg-orange-500/20 flex items-center justify-center mb-4">⏳</div>
            <p class="text-slate-400 text-sm mb-1">Demandes en attente</p>
            <p class="text-3xl font-semibold text-white">{{ $this->demandes_en_attente }}</p>
            <p class="text-slate-500 text-sm mt-1">demandes en cours</p>
        </div>

        {{-- Congés approuvés --}}
        <div class="bg-[#131728] rounded-2xl p-5 border border-white/5">
            <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center mb-4">✅</div>
            <p class="text-slate-400 text-sm mb-1">Congés approuvés</p>
            <p class="text-3xl font-semibold text-white">{{ $this->conges_approuves }} <span class="text-base font-normal text-slate-400">jours</span></p>
            <p class="text-slate-500 text-sm mt-1">cette année</p>
        </div>

        {{-- Prochaine absence --}}
        <div class="bg-[#131728] rounded-2xl p-5 border border-white/5">
            <div class="w-10 h-10 rounded-full bg-purple-500/20 flex items-center justify-center mb-4">✈️</div>
            <p class="text-slate-400 text-sm mb-1">Prochaine absence</p>
            @if ($this->prochaine_absence)
                <p class="text-lg font-semibold text-white">
                    {{ $this->prochaine_absence->date_debut->format('d M') }} → {{ $this->prochaine_absence->date_fin->format('d M') }}
                </p>
                <p class="text-slate-500 text-sm mt-1">{{ $this->prochaine_absence->jours }} jours de congé</p>
            @else
                <p class="text-lg font-semibold text-white">Aucune</p>
                <p class="text-slate-500 text-sm mt-1">rien de prévu</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">

        {{-- ===== Demandes récentes ===== --}}
        <div class="lg:col-span-2 bg-[#131728] rounded-2xl p-5 border border-white/5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-white font-semibold">Mes demandes récentes</h2>
                <a href="{{ route('demandes.index') }}" class="text-indigo-400 text-sm">Voir tout →</a>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-slate-500 text-left border-b border-white/5">
                        <th class="pb-2 font-normal">Type</th>
                        <th class="pb-2 font-normal">Date</th>
                        <th class="pb-2 font-normal">Durée</th>
                        <th class="pb-2 font-normal">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->demandes_recentes as $demande)
                        <tr class="border-b border-white/5">
                            <td class="py-3 flex items-center gap-2">
                                <span>
                                    @switch($demande->type)
                                        @case('maladie') 🏥 @break
                                        @case('sans_solde') 📅 @break
                                        @default ✈️
                                    @endswitch
                                </span>
                                {{ $demande->type_label ?? ucfirst(str_replace('_', ' ', $demande->type)) }}
                            </td>
                            <td class="py-3 text-slate-400">
                                {{ $demande->date_debut->format('d M') }} - {{ $demande->date_fin->format('d M') }}
                            </td>
                            <td class="py-3 text-slate-400">{{ $demande->jours }} jours</td>
                            <td class="py-3">
                                @php
                                    $couleurs = [
                                        'approuve' => 'bg-emerald-500/15 text-emerald-400',
                                        'en_attente' => 'bg-orange-500/15 text-orange-400',
                                        'refuse' => 'bg-red-500/15 text-red-400',
                                    ];
                                    $libelles = [
                                        'approuve' => 'Approuvé',
                                        'en_attente' => 'En attente',
                                        'refuse' => 'Refusé',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs {{ $couleurs[$demande->statut] ?? '' }}">
                                    {{ $libelles[$demande->statut] ?? $demande->statut }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-500">Aucune demande pour l'instant.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ===== Mini calendrier ===== --}}
        <div class="bg-[#131728] rounded-2xl p-5 border border-white/5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-white font-semibold">Calendrier</h2>
                <div class="flex items-center gap-2">
                    <button wire:click="moisPrecedent" class="w-7 h-7 rounded-lg bg-white/5 hover:bg-white/10">‹</button>
                    <span class="text-sm text-slate-300 w-24 text-center">
                        {{ \Carbon\Carbon::parse($moisCalendrier.'-01')->translatedFormat('F Y') }}
                    </span>
                    <button wire:click="moisSuivant" class="w-7 h-7 rounded-lg bg-white/5 hover:bg-white/10">›</button>
                </div>
            </div>

            <button wire:click="aujourdHui" class="text-xs bg-indigo-500 text-white px-3 py-1 rounded-lg mb-4">Aujourd'hui</button>

            <div class="grid grid-cols-7 gap-1 text-center text-xs">
                @foreach (['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $jour)
                    <div class="text-slate-500 pb-2">{{ $jour }}</div>
                @endforeach

                @foreach ($this->jours_calendrier as $jour)
                    <div @class([
                            'py-1.5 rounded-lg',
                            'text-slate-600' => $jour['horsMois'],
                            'text-slate-300' => ! $jour['horsMois'] && ! $jour['aujourdHui'],
                            'bg-purple-500 text-white font-semibold' => $jour['aujourdHui'],
                            'bg-indigo-500/70 text-white' => ! $jour['aujourdHui'] && $jour['statut'] === 'approuve',
                            'bg-orange-500/70 text-white' => ! $jour['aujourdHui'] && $jour['statut'] === 'en_attente',
                        ])>
                        {{ $jour['date']->day }}
                    </div>
                @endforeach
            </div>

            <div class="flex flex-wrap gap-3 mt-4 text-xs text-slate-400">
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Congé approuvé</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-500"></span> En attente</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-purple-500"></span> Aujourd'hui</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ===== Donut : utilisation des congés ===== --}}
        <div class="bg-[#131728] rounded-2xl p-5 border border-white/5">
            <h2 class="text-white font-semibold mb-4">Utilisation de vos congés</h2>

            <div class="flex items-center gap-6">
                @php
                    $pourcentage = $this->pourcentage_utilise;
                    $circonference = 2 * pi() * 45;
                    $rempli = $circonference * ($pourcentage / 100);
                @endphp
                <svg viewBox="0 0 120 120" class="w-28 h-28 -rotate-90">
                    <circle cx="60" cy="60" r="45" fill="none" stroke="#1e2436" stroke-width="12" />
                    <circle cx="60" cy="60" r="45" fill="none" stroke="url(#degrade)" stroke-width="12"
                        stroke-linecap="round"
                        stroke-dasharray="{{ $rempli }} {{ $circonference }}" />
                    <defs>
                        <linearGradient id="degrade" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#6366f1" />
                            <stop offset="100%" stop-color="#22c55e" />
                        </linearGradient>
                    </defs>
                </svg>

                <div>
                    <p class="text-3xl font-semibold text-white mb-3">{{ $pourcentage }}%</p>
                    <ul class="text-sm space-y-1.5">
                        <li class="flex items-center gap-2 text-slate-300"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Utilisés — {{ $this->jours_utilises }} jours</li>
                        <li class="flex items-center gap-2 text-slate-300"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Restants — {{ $this->solde_disponible }} jours</li>
                        <li class="flex items-center gap-2 text-slate-300"><span class="w-2 h-2 rounded-full bg-slate-500"></span> Total annuel — {{ $this->solde_annuel }} jours</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ===== Courbe : congés utilisés par mois ===== --}}
        <div class="lg:col-span-2 bg-[#131728] rounded-2xl p-5 border border-white/5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-white font-semibold">Congés utilisés par mois</h2>
                <select wire:change="changerAnnee($event.target.value)" class="bg-[#1e2436] text-sm rounded-lg px-2 py-1 border border-white/5">
                    @foreach ([now()->year - 1, now()->year, now()->year + 1] as $annee)
                        <option value="{{ $annee }}" @selected($annee === $this->anneeGraphique)>{{ $annee }}</option>
                    @endforeach
                </select>
            </div>

            @php
                $valeurs = array_values($this->conges_par_mois);
                $max = max(max($valeurs), 1);
                $largeur = 700; $hauteur = 160; $pas = $largeur / 11;
                $points = collect($valeurs)->map(fn ($v, $i) => ($i * $pas).','.($hauteur - ($v / $max) * $hauteur))->implode(' ');
            @endphp

            <svg viewBox="0 0 {{ $largeur }} {{ $hauteur + 20 }}" class="w-full h-40">
                <polyline points="{{ $points }}" fill="none" stroke="#6366f1" stroke-width="3" />
                @foreach ($valeurs as $i => $v)
                    <circle cx="{{ $i * $pas }}" cy="{{ $hauteur - ($v / $max) * $hauteur }}" r="4"
                        fill="{{ now()->month - 1 === $i && $this->anneeGraphique === now()->year ? '#a855f7' : '#6366f1' }}" />
                @endforeach
            </svg>

            <div class="grid grid-cols-12 text-center text-[10px] text-slate-500 -mt-2">
                @foreach (['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'] as $mois)
                    <span>{{ $mois }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ===== Prochaines absences ===== --}}
    <div class="bg-[#131728] rounded-2xl p-5 border border-white/5 mt-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-white font-semibold">Prochaines absences</h2>
            <a href="{{ route('demandes.index') }}" class="text-indigo-400 text-sm">Voir tout</a>
        </div>

        <div class="space-y-3">
            @forelse ($this->prochaines_absences as $absence)
                <div class="flex items-center justify-between bg-[#1a1f34] rounded-xl px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-full bg-purple-500/20 flex items-center justify-center">
                            {{ $absence->type === 'maladie' ? '🏥' : '✈️' }}
                        </span>
                        <div>
                            <p class="text-white text-sm font-medium">{{ ucfirst(str_replace('_', ' ', $absence->type)) }}</p>
                            <p class="text-slate-500 text-xs">
                                {{ $absence->date_debut->format('d M') }} - {{ $absence->date_fin->format('d M') }} · {{ $absence->jours }} jours
                            </p>
                        </div>
                    </div>
                    <span class="text-xs bg-emerald-500/15 text-emerald-400 px-3 py-1 rounded-full">
                        Dans {{ now()->diffInDays($absence->date_debut) }} jours
                    </span>
                </div>
            @empty
                <p class="text-slate-500 text-sm">Aucune absence prévue.</p>
            @endforelse
        </div>
    </div>
</div>
