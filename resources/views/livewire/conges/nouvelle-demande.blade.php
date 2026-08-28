<div class="layout">

    <!-- ===== FORMULAIRE (colonne principale) ===== -->
    <div class="panel form-panel">

        <!-- ===== Bannière ===== -->
        <div class="banniere">
            <img src="{{ asset('images/valise-conge.png') }}" alt="" class="banniere-img">
            <div class="banniere-texte">
                <span>Un moment pour vous,</span>
                <b>bien mérité !</b>
            </div>
            <div class="banniere-avantages">
                <div class="avantage">
                    <span class="ico"><i data-lucide="zap" style="width:16px;height:16px;"></i></span>
                    <div><b>Rapide</b><span>Remplissez en quelques clics</span></div>
                </div>
                <div class="avantage">
                    <span class="ico"><i data-lucide="shield-check" style="width:16px;height:16px;"></i></span>
                    <div><b>Sécurisé</b><span>Vos données sont protégées</span></div>
                </div>
                <div class="avantage">
                    <span class="ico"><i data-lucide="check" style="width:16px;height:16px;"></i></span>
                    <div><b>Simple</b><span>Suivez votre demande facilement</span></div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div style="margin-bottom:18px; padding:10px 14px; border-radius:10px; background:rgba(16,185,129,.15); color:var(--green); font-size:12.5px;">{{ session('success') }}</div>
        @endif

        <!-- ===== 01. Type de congé ===== -->
        <div class="section">
            <div class="section-title"><span class="num">01</span> Type de congé</div>

            <div class="type-grid">
                @foreach ($types as $cle => $infos)
                    <button type="button" wire:click="selectionnerType('{{ $cle }}')"
                            class="type-card {{ $type === $cle ? 'active' : '' }}">
                        @if ($type === $cle)
                            <span class="type-check"><i data-lucide="check" style="width:11px;height:11px;"></i></span>
                        @endif
                        <span class="type-ico"><i data-lucide="{{ $infos['icon'] }}" style="width:20px;height:20px;"></i></span>
                        <span class="type-label">{{ $infos['label'] }}</span>
                    </button>
                @endforeach
            </div>
            @error('type') <div class="err">{{ $message }}</div> @enderror
        </div>

        <!-- ===== 02. Période de congé ===== -->
        <div class="section">
            <div class="section-title"><span class="num">02</span> Période de congé</div>

            <div class="periode-grid">
                <div class="champ">
                    <label>Date de début</label>
                    <div class="champ-input">
                        <i data-lucide="calendar" style="width:15px;height:15px;"></i>
                        <input type="date" wire:model.live="dateDebut" min="{{ now()->format('Y-m-d') }}">
                    </div>
                    @error('dateDebut') <div class="err">{{ $message }}</div> @enderror
                </div>
                <div class="champ">
                    <label>Date de fin</label>
                    <div class="champ-input">
                        <i data-lucide="calendar" style="width:15px;height:15px;"></i>
                        <input type="date" wire:model.live="dateFin" min="{{ $dateDebut ?: now()->format('Y-m-d') }}">
                    </div>
                    @error('dateFin') <div class="err">{{ $message }}</div> @enderror
                </div>
                <div class="champ">
                    <label>Jours ouvrés</label>
                    <div class="champ-readonly">{{ $this->joursOuvres }} jour{{ $this->joursOuvres > 1 ? 's' : '' }}</div>
                </div>
            </div>

            <div class="info-bloc">
                <i data-lucide="info" style="width:14px;height:14px;"></i>
                Seul le dimanche n'est pas inclus dans le calcul (NAJA7 HOST travaille du lundi au samedi).
            </div>
        </div>

        <!-- ===== 03. Motif ===== -->
        <div class="section">
            <div class="section-title"><span class="num">03</span> Motif de la demande <span class="optionnel">(optionnel)</span></div>

            <div class="motif-wrap">
                <textarea wire:model.live="motif" maxlength="{{ $motifMax }}"
                          placeholder="Expliquez brièvement le motif de votre demande..."></textarea>
                <span class="motif-count">{{ strlen($motif) }}/{{ $motifMax }}</span>
            </div>
            @error('motif') <div class="err">{{ $message }}</div> @enderror
        </div>

        <!-- ===== 04. Justificatif ===== -->
        <div class="section">
            <div class="section-title"><span class="num">04</span> Justificatif <span class="optionnel">(optionnel)</span></div>

            {{-- Un seul mécanisme de clic : l'input recouvre déjà toute la zone
                 (.input-fichier-cache = position:absolute; inset:0;), donc pas besoin
                 d'Alpine.js par-dessus pour déclencher un second clic programmé. --}}
            <label class="dropzone" style="display:flex;">
                <i data-lucide="upload-cloud" style="width:20px;height:20px;"></i>
                <div>
                    <span>{{ $justificatif ? $justificatif->getClientOriginalName() : 'Glissez votre fichier ici ou cliquez pour parcourir' }}</span>
                    <small>PDF, JPG, PNG (max. 5Mo)</small>
                </div>
                <span class="btn-parcourir">Parcourir</span>
                <input type="file" wire:model="justificatif" class="input-fichier-cache" accept=".pdf,.jpg,.jpeg,.png">
            </label>
            <div wire:loading wire:target="justificatif" class="upload-loading">Envoi en cours...</div>
            @error('justificatif') <div class="err">{{ $message }}</div> @enderror
        </div>

        <!-- ===== Actions ===== -->
        <div class="form-actions">
            <a href="{{ route('dashboard') }}" class="btn-annuler">Annuler</a>
            <button type="button" wire:click="soumettre" class="btn-soumettre" wire:loading.attr="disabled" wire:target="soumettre">
                <i data-lucide="send" style="width:14px;height:14px;"></i> Soumettre la demande
            </button>
        </div>
    </div>

    <!-- ===== SIDEBAR DROITE ===== -->
    <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- Mon solde de congés -->
        <div class="panel side-panel">
            <h3>Mon solde de congés</h3>
            @php
                $solde = auth()->user()->solde_conges_annuel ?? 0;
                $pourcentage = min(100, max(0, ($solde / 21) * 100));
                $rayonSolde = 62;
                $circonfSolde = 2 * pi() * $rayonSolde;
            @endphp
            <div class="solde-wrap">
                <svg viewBox="0 0 150 150" style="position:absolute; inset:0;">
                    <circle cx="75" cy="75" r="{{ $rayonSolde }}" fill="none" stroke="rgba(255,255,255,.1)" stroke-width="12" />
                    <circle cx="75" cy="75" r="{{ $rayonSolde }}" fill="none" stroke="var(--orange)" stroke-width="12" stroke-linecap="round"
                        stroke-dasharray="{{ $circonfSolde }}"
                        stroke-dashoffset="{{ $circonfSolde * (1 - $pourcentage / 100) }}"
                        transform="rotate(-90 75 75)" />
                </svg>
                <div class="solde-center"><b>{{ $solde }}</b><span>jours restants</span></div>
            </div>
        </div>

        <!-- Aperçu de la période -->
        <div class="panel side-panel">
            <h3>Aperçu de la période</h3>
            <div class="calendrier-nav">
                <button wire:click="moisPrecedent" type="button"><i data-lucide="chevron-left" style="width:14px;height:14px;"></i></button>
                <b>{{ $this->libelleMois }}</b>
                <button wire:click="moisSuivant" type="button"><i data-lucide="chevron-right" style="width:14px;height:14px;"></i></button>
            </div>
            <div class="cal-grid">
                @foreach (['LUN','MAR','MER','JEU','VEN','SAM','DIM'] as $nomJour)
                    <div class="cal-jour-nom">{{ $nomJour }}</div>
                @endforeach
                @foreach ($this->joursCalendrier as $semaine)
                    @foreach ($semaine as $jour)
                        <div class="cal-jour
                            {{ !$jour['dansMoisCourant'] ? 'hors-mois' : '' }}
                            {{ $jour['estAujourdhui'] ? 'aujourdhui' : '' }}
                            {{ $jour['dansRange'] && !$jour['estDebut'] && !$jour['estFin'] ? 'dans-range' : '' }}
                            {{ $jour['estDebut'] || $jour['estFin'] ? 'debut' : '' }}">
                            {{ $jour['jour'] }}
                        </div>
                    @endforeach
                @endforeach
            </div>
            <div class="apercu-legende">
                <div class="item"><span><span class="puce" style="background:var(--orange);"></span>Début</span><span>{{ $dateDebut ? \Carbon\Carbon::parse($dateDebut)->format('d M') : '—' }}</span></div>
                <div class="item"><span><span class="puce" style="background:rgba(245,158,11,.4);"></span>Période sélectionnée</span><span>{{ $this->joursOuvres }} jours</span></div>
                <div class="item"><span><span class="puce" style="background:var(--orange);"></span>Fin</span><span>{{ $dateFin ? \Carbon\Carbon::parse($dateFin)->format('d M') : '—' }}</span></div>
            </div>
        </div>

        <!-- Bon à savoir -->
        <div class="panel side-panel">
            <h3>Bon à savoir</h3>
            <div class="bon-a-savoir">
                <span class="ico"><i data-lucide="lightbulb" style="width:16px;height:16px;"></i></span>
                <p>Votre demande sera soumise à l'approbation de votre responsable hiérarchique.</p>
            </div>
        </div>

    </div>
</div>