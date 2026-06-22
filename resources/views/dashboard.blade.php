<x-layouts::app :title="__('Dashboard')">

<style>
.db-wrap { padding:14px 18px; font-family:'Source Sans 3',sans-serif; }

/* Stats grid — 5 colonnes alignées */
.db-stats {
    display              : grid;
    grid-template-columns: repeat(5, 1fr);
    gap                  : 10px;
    margin-bottom        : 14px;
}

.db-stat {
    border-radius: 10px;
    padding      : 12px 14px;
    color        : white;
    position     : relative;
    overflow     : hidden;
    box-shadow   : 0 3px 12px rgba(0,0,0,0.15);
}

.db-stat::after {
    content      : '';
    position     : absolute;
    bottom:-14px; right:-14px;
    width:60px; height:60px;
    border-radius: 50%;
    background   : rgba(255,255,255,0.1);
}

.db-stat-lbl {
    font-size     : 0.62rem;
    font-weight   : 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    opacity       : 0.88;
    margin-bottom : 4px;
}

.db-stat-val {
    font-family: 'Nunito',sans-serif;
    font-size  : 1.75rem;
    font-weight: 900;
    line-height: 1;
}

.db-stat-ico {
    position  : absolute;
    right     : 10px;
    top       : 50%;
    transform : translateY(-50%);
    font-size : 1.8rem;
    opacity   : 0.15;
}

.sv { background:linear-gradient(135deg,#1a6b3a,#22883f); }
.sr { background:linear-gradient(135deg,#c0281e,#e03328); }
.so { background:linear-gradient(135deg,#a07810,#d4a017); }
.sd { background:linear-gradient(135deg,#1a2520,#3a4a40); }

/* Tables grid — 2 colonnes */
.db-tables {
    display              : grid;
    grid-template-columns: 1fr 1fr;
    gap                  : 10px;
}

.db-card {
    background   : white;
    border-radius: 10px;
    box-shadow   : 0 2px 8px rgba(26,107,58,0.09);
    overflow     : hidden;
}

.db-card-head {
    display        : flex;
    justify-content: space-between;
    align-items    : center;
    padding        : 9px 12px;
    border-bottom  : 1px solid rgba(26,107,58,0.08);
    font-family    : 'Nunito',sans-serif;
    font-weight    : 700;
    font-size      : 0.82rem;
    color          : #1a2520;
}

.db-btn {
    background   : #1a6b3a;
    color        : white;
    border       : none;
    border-radius: 5px;
    padding      : 3px 10px;
    font-size    : 0.7rem;
    font-family  : 'Nunito',sans-serif;
    font-weight  : 600;
    cursor       : pointer;
    text-decoration: none;
}

.db-btn:hover { background:#22883f; color:white; }

table.db-table { width:100%; border-collapse:collapse; }

table.db-table thead th {
    background    : #e8f2ec;
    color         : #1a6b3a;
    font-family   : 'Nunito',sans-serif;
    font-weight   : 700;
    font-size     : 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding       : 7px 10px;
    border-bottom : 2px solid rgba(26,107,58,0.15);
}

table.db-table tbody tr { border-bottom:1px solid rgba(26,107,58,0.05); transition:background 0.15s; }
table.db-table tbody tr:hover { background:#e8f2ec; }
table.db-table tbody td { padding:6px 10px; font-size:0.78rem; color:#1a2520; vertical-align:middle; }

.badge-v { background:#e8f2ec; color:#1a6b3a; border-radius:20px; padding:2px 8px; font-size:0.65rem; font-weight:700; font-family:'Nunito',sans-serif; }
.badge-r { background:#fbeaea; color:#c0281e; border-radius:20px; padding:2px 8px; font-size:0.65rem; font-weight:700; font-family:'Nunito',sans-serif; }
.badge-o { background:#fdf8e1; color:#7a5800; border-radius:20px; padding:2px 8px; font-size:0.65rem; font-weight:700; font-family:'Nunito',sans-serif; }

.pay-row {
    display        : flex;
    justify-content: space-between;
    align-items    : center;
    padding        : 8px 12px;
    border-bottom  : 1px solid rgba(26,107,58,0.05);
}

.pay-row:hover { background:#e8f2ec; }

@media (max-width:768px) {
    .db-stats    { grid-template-columns: repeat(2, 1fr); }
    .db-modules  { grid-template-columns: 1fr; }
    .db-tables   { grid-template-columns: 1fr; }
}

.db-modules {
    display              : grid;
    grid-template-columns: repeat(4, 1fr);
    gap                  : 10px;
    margin-bottom        : 14px;
}

.db-module-card {
    background   : white;
    border-radius: 10px;
    border       : 1px solid rgba(26,107,58,0.12);
    padding      : 14px;
    display      : flex;
    justify-content: space-between;
    align-items  : center;
    gap          : 12px;
    box-shadow   : 0 2px 8px rgba(26,107,58,0.08);
    text-decoration: none;
    color        : inherit;
}

.db-module-info {
    display: grid;
    gap: 4px;
}

.db-module-title {
    font-weight: 700;
    color: #1a2520;
}

.db-module-sub {
    font-size: 0.78rem;
    color: #6b7a70;
}

.db-module-link {
    background   : #1a6b3a;
    color        : white;
    border       : none;
    border-radius: 8px;
    padding      : 8px 12px;
    font-size    : 0.78rem;
    font-weight  : 700;
    text-decoration: none;
}

.db-module-link:hover {
    background: #19612e;
}
</style>

<div class="db-wrap">

    {{-- ── En-tête ── --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <div>
            <div style="font-family:'Nunito',sans-serif;font-weight:800;font-size:1rem;color:#1a2520;display:flex;align-items:center;gap:7px;">
                <span style="width:4px;height:18px;background:linear-gradient(180deg,#c0281e,#d4a017 50%,#1a6b3a);border-radius:3px;display:inline-block;flex-shrink:0;"></span>
                Tableau de bord
            </div>
            <div style="font-size:0.68rem;color:#6b7a70;margin-top:1px;">AGesP</div>
        </div>
        <div style="font-size:0.68rem;color:#6b7a70;background:#f3f6f4;padding:3px 10px;border-radius:20px;border:1px solid rgba(26,107,58,0.12);">
            📅 {{ now()->locale('fr')->isoFormat('ddd D MMM YYYY') }}
        </div>
    </div>

    {{-- ── Répartition par étape de formation ── --}}
    <div style="font-family:'Nunito',sans-serif;font-weight:800;font-size:0.85rem;color:#1a2520;margin:18px 0 10px;display:flex;align-items:center;gap:7px;">
        <span style="width:4px;height:16px;background:linear-gradient(180deg,#c0281e,#d4a017 50%,#1a6b3a);border-radius:3px;display:inline-block;flex-shrink:0;"></span>
        Répartition par étape de formation
        <span style="font-family:'Source Sans 3',sans-serif;font-weight:700;font-size:0.78rem;color:#6b7a70;margin-left:auto;">Total : {{ $totalCandidats }} candidats</span>
    </div>
    <div class="db-stats">
        <div class="db-stat" style="background:linear-gradient(135deg,#4b5563,#6b7280);">
            <div class="db-stat-lbl">Inscrits</div>
            <div class="db-stat-val">{{ $candidatsInscrits }}</div>
            <span class="db-stat-ico">📋</span>
        </div>
        <div class="db-stat sr">
            <div class="db-stat-lbl">Code</div>
            <div class="db-stat-val">{{ $candidatsCode }}</div>
            <span class="db-stat-ico">🔴</span>
        </div>
        <div class="db-stat so">
            <div class="db-stat-lbl">Créneau</div>
            <div class="db-stat-val">{{ $candidatsCreneau }}</div>
            <span class="db-stat-ico">🟡</span>
        </div>
        <div class="db-stat sd">
            <div class="db-stat-lbl">Conduite en ville</div>
            <div class="db-stat-val">{{ $candidatsConduite }}</div>
            <span class="db-stat-ico">🚗</span>
        </div>
        <div class="db-stat sv">
            <div class="db-stat-lbl">Admis</div>
            <div class="db-stat-val">{{ $candidatsAdmis }}</div>
            <span class="db-stat-ico">🏆</span>
        </div>
    </div>

    {{-- ── Graphiques circulaires ── --}}
    <div style="font-family:'Nunito',sans-serif;font-weight:800;font-size:0.85rem;color:#1a2520;margin:18px 0 10px;display:flex;align-items:center;gap:7px;">
        <span style="width:4px;height:16px;background:linear-gradient(180deg,#c0281e,#d4a017 50%,#1a6b3a);border-radius:3px;display:inline-block;flex-shrink:0;"></span>
        Statistiques visuelles
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
        <div style="background:white;border-radius:10px;padding:18px;box-shadow:0 3px 12px rgba(0,0,0,0.08);">
            <div style="font-family:'Nunito',sans-serif;font-weight:700;font-size:0.78rem;color:#1a2520;margin-bottom:10px;text-align:center;">Répartition par étape</div>
            <div style="position: relative; height:240px;">
                <canvas id="etapeChart"></canvas>
            </div>
        </div>
        <div style="background:white;border-radius:10px;padding:18px;box-shadow:0 3px 12px rgba(0,0,0,0.08);">
            <div style="font-family:'Nunito',sans-serif;font-weight:700;font-size:0.78rem;color:#1a2520;margin-bottom:10px;text-align:center;">Répartition par catégorie de permis</div>
            <div style="position: relative; height:240px;">
                <canvas id="permisChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
    (function() {
        // ── Donut : répartition par étape de formation ──
        const ctxEtape = document.getElementById('etapeChart');
        if (ctxEtape) {
            new Chart(ctxEtape, {
                type: 'doughnut',
                data: {
                    labels: ['Inscrits', 'Code', 'Créneau', 'Conduite en ville', 'Admis'],
                    datasets: [{
                        data: [
                            {{ (int)$candidatsInscrits }},
                            {{ (int)$candidatsCode }},
                            {{ (int)$candidatsCreneau }},
                            {{ (int)$candidatsConduite }},
                            {{ (int)$candidatsAdmis }}
                        ],
                        // Couleurs calées sur la charte des blocs du haut
                        backgroundColor: ['#4b5563', '#c0281e', '#d4a017', '#1a2520', '#1a6b3a'],
                        borderWidth: 2,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 12 } }
                    }
                }
            });
        }

        // ── Donut : répartition par catégorie de permis ──
        const ctxPermis = document.getElementById('permisChart');
        if (ctxPermis) {
            const labels = @json($repartitionPermis->keys());
            const data   = @json($repartitionPermis->values());

            new Chart(ctxPermis, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#1a6b3a', '#d4a017', '#c0281e', '#3a4a40', '#22883f'],
                        borderWidth: 2,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 12 } }
                    }
                }
            });
        }
    })();
    </script>

    {{-- ── Modules rapides ── --}}
    <div class="db-modules">
        <a href="{{ route('candidats.index') }}" class="db-module-card">
            <div class="db-module-info">
                <div class="db-module-title">Candidats</div>
                <div class="db-module-sub">Gérer les candidats</div>
            </div>
            <span class="db-module-link">Ouvrir</span>
        </a>
        <a href="{{ route('inscriptions.index') }}" class="db-module-card">
            <div class="db-module-info">
                <div class="db-module-title">Inscriptions</div>
                <div class="db-module-sub">Suivre les inscriptions</div>
            </div>
            <span class="db-module-link">Ouvrir</span>
        </a>
        <a href="{{ route('formations.index') }}" class="db-module-card">
            <div class="db-module-info">
                <div class="db-module-title">Formations</div>
                <div class="db-module-sub">Planifier les formations</div>
            </div>
            <span class="db-module-link">Ouvrir</span>
        </a>
        <a href="{{ route('examens.index') }}" class="db-module-card">
            <div class="db-module-info">
                <div class="db-module-title">Examens</div>
                <div class="db-module-sub">Voir les examens</div>
            </div>
            <span class="db-module-link">Ouvrir</span>
        </a>
        <a href="{{ route('paiements.index') }}" class="db-module-card">
            <div class="db-module-info">
                <div class="db-module-title">Paiements</div>
                <div class="db-module-sub">Consulter les paiements</div>
            </div>
            <span class="db-module-link">Ouvrir</span>
        </a>
        <a href="{{ route('evaluations.index') }}" class="db-module-card">
            <div class="db-module-info">
                <div class="db-module-title">Évaluations</div>
                <div class="db-module-sub">Voir les évaluations</div>
            </div>
            <span class="db-module-link">Ouvrir</span>
        </a>
        <a href="{{ route('moniteurs.index') }}" class="db-module-card">
            <div class="db-module-info">
                <div class="db-module-title">Moniteurs</div>
                <div class="db-module-sub">Gestion des moniteurs</div>
            </div>
            <span class="db-module-link">Ouvrir</span>
        </a>
        <a href="{{ route('vehicules.index') }}" class="db-module-card">
            <div class="db-module-info">
                <div class="db-module-title">Véhicules</div>
                <div class="db-module-sub">Gérer le parc auto</div>
            </div>
            <span class="db-module-link">Ouvrir</span>
        </a>
    </div>

    {{-- ── 2 Tableaux côte à côte ── --}}
    <div class="db-tables">

        {{-- Candidats --}}
        <div class="db-card">
            <div class="db-card-head">
                <span>👥 Derniers candidats inscrits</span>
                <a href="{{ route('candidats.index') }}" class="db-btn">+ Nouveau</a>
            </div>
            <table class="db-table">
                <thead>
                    <tr>
                        <th class="ps-2">Nom complet</th>
                        <th>Catégorie</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($derniereInscriptions as $inscription)
                    <tr>
                        <td style="font-weight:600;">
                            {{ $inscription->candidat->nom ?? '' }}
                            {{ $inscription->candidat->prenom ?? '' }}
                        </td>
                        <td>Permis E</td>
                        <td>{{ \Carbon\Carbon::parse($inscription->dateInscription)->format('d/m/Y') }}</td>
                        <td>
                            @if($inscription->statutInscription == 'actif')
                                <span class="badge-v">Actif</span>
                            @elseif($inscription->statutInscription == 'abandon')
                                <span class="badge-r">Abandon</span>
                            @else
                                <span class="badge-o">{{ ucfirst($inscription->statutInscription) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:20px;color:#6b7a70;font-size:0.78rem;">
                            Aucune inscription
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paiements --}}
        <div class="db-card">
            <div class="db-card-head">
                <span>💳 Paiements récents</span>
                <a href="{{ route('paiements.index') }}" class="db-btn">Voir tout</a>
            </div>
            @forelse($paiementsRecents as $paiement)
            <div class="pay-row">
                <div>
                    <div style="font-weight:600;font-size:0.8rem;color:#1a2520;">
                        {{ $paiement->candidat->nom ?? '' }}
                        {{ $paiement->candidat->prenom ?? '' }}
                    </div>
                    <div style="font-size:0.65rem;color:#6b7a70;">
                        {{ \Carbon\Carbon::parse($paiement->datePaiement)->format('d/m/Y') }}
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="font-family:'Nunito',sans-serif;font-weight:800;font-size:0.85rem;color:#1a6b3a;">
                        {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                    </div>
                    <span class="badge-v">Payé</span>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:20px;color:#6b7a70;font-size:0.78rem;">
                Aucun paiement
            </div>
            @endforelse
        </div>

    </div>{{-- fin db-tables --}}
</div>{{-- fin db-wrap --}}

</x-layouts::app>