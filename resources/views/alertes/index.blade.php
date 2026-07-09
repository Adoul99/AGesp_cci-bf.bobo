<x-layouts::app :title="__('Alertes')">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --color-red: #E8384F; --color-red-dark: #C81E36;
    --color-green: #1F7A56; --color-gold: #FFD23F;
    --radius-lg: 22px; --radius-md: 12px;
}

.content-wrapper {
    font-family: 'Source Sans 3', sans-serif;
    min-height: 100vh;
    padding: 2.5rem;
    color: #FFFFFF;
    background:
        radial-gradient(circle at 15% 0%, rgba(255,255,255,0.06), transparent 35%),
        linear-gradient(180deg, #090C15 0%, #0C2A21 22%, #12503C 48%, #1B7256 75%, #1F8760 100%);
}

.al-eyebrow {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(0,0,0,0.32);
    padding: 0.5rem 1rem;
    border-radius: 999px;
    font-family: 'Nunito', sans-serif;
    font-weight: 800; font-size: 0.72rem; letter-spacing: 1.2px; text-transform: uppercase;
    color: var(--color-gold);
    border: 1px solid rgba(255,255,255,0.1);
    margin-bottom: 1.25rem;
}
.al-eyebrow::before { content:''; width:8px; height:8px; border-radius:50%; background: var(--color-red); }

.al-title {
    font-family: 'Nunito', sans-serif;
    font-size: 2.5rem; font-weight: 900; color: #FFFFFF;
    margin: 0 0 0.5rem 0;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
}
.al-subtitle { color: rgba(255,255,255,0.65); font-size: 1rem; margin-bottom: 2.5rem; }

.al-total-pill {
    background: rgba(255,255,255,0.14);
    color: #FFFFFF;
    padding: 0.5rem 1.25rem;
    border-radius: 999px;
    font-family: 'Nunito', sans-serif;
    font-weight: 800; font-size: 1rem;
    border: 1px solid rgba(255,255,255,0.16);
}

.al-empty-all {
    background: linear-gradient(160deg, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0.04) 100%);
    border: 1px solid rgba(255,255,255,0.16);
    border-radius: var(--radius-lg);
    padding: 3rem; text-align: center;
    box-shadow: 0 20px 45px rgba(0,0,0,0.25);
}

.al-section {
    background: linear-gradient(160deg, rgba(255,255,255,0.11) 0%, rgba(255,255,255,0.03) 100%);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: var(--radius-lg);
    box-shadow: 0 18px 40px rgba(0,0,0,0.22);
    padding: 1.75rem 2rem;
    margin-bottom: 1.75rem;
}

.al-head {
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    margin-bottom: 1.25rem;
}
.al-head-left { display: flex; align-items: center; gap: 1rem; }

.al-badge {
    flex-shrink: 0;
    width: 42px; height: 42px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%);
    color: white;
    font-family: 'Nunito', sans-serif;
    font-weight: 900; font-size: 1.1rem;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 14px rgba(232,56,79,0.4);
}

.al-section-title {
    font-family: 'Nunito', sans-serif;
    font-size: 1.05rem; font-weight: 800; color: #FFFFFF; margin: 0;
}

.al-count-pill {
    background: rgba(255,255,255,0.16);
    color: #FFFFFF;
    padding: 0.3rem 0.85rem;
    border-radius: 999px;
    font-family: 'Nunito', sans-serif;
    font-weight: 800; font-size: 0.85rem;
}

.al-empty { padding: 1.5rem; text-align: center; color: rgba(255,255,255,0.55); font-size: 0.9rem; }

.al-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
.al-table th {
    padding: 0.7rem 1rem; text-align: left;
    font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;
    color: rgba(255,255,255,0.5);
    border-bottom: 1px solid rgba(255,255,255,0.15);
}
.al-table td {
    padding: 0.85rem 1rem;
    color: rgba(255,255,255,0.92);
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
.al-table tr:last-child td { border-bottom: none; }
.al-table tr:hover td { background: rgba(255,255,255,0.05); }

.al-name { font-weight: 700; color: #FFFFFF; }
.al-dim { color: rgba(255,255,255,0.6); }
.al-status-pill {
    background: rgba(255,255,255,0.14);
    color: rgba(255,255,255,0.85);
    padding: 0.25rem 0.7rem;
    border-radius: 999px;
    font-size: 0.72rem; font-weight: 700;
}
</style>

<div class="content-wrapper">

    {{-- En-tête --}}
    <div class="al-eyebrow">CCI-BF — Bobo-Dioulasso</div>
    <h1 class="al-title">
        <span>🔔 Alertes &amp; Rappels</span>
        <span class="al-total-pill">{{ $totalAlertes }} alerte(s)</span>
    </h1>
    <p class="al-subtitle">Suivi en temps réel des candidats, sessions et évaluations à traiter.</p>

    @if($totalAlertes === 0)
    <div class="al-empty-all">
        <div style="font-size:3rem; margin-bottom:1rem;">✅</div>
        <div style="font-family:'Nunito',sans-serif; font-size:1.15rem; font-weight:800;">Tout est à jour !</div>
        <div style="color:rgba(255,255,255,0.6); font-size:0.9rem; margin-top:0.5rem;">Aucune alerte en attente pour le moment.</div>
    </div>
    @endif

    {{-- 1) Nouvelles inscriptions --}}
    <div class="al-section">
        <div class="al-head">
            <div class="al-head-left">
                <div class="al-badge">1</div>
                <h2 class="al-section-title">🆕 Nouvelles inscriptions (depuis -{{ \App\Http\Controllers\AlerteController::JOURS_NOUVELLE_INSCRIPTION }} jours)</h2>
            </div>
            <span class="al-count-pill">{{ $nouveauxCandidats->count() }}</span>
        </div>
        @if($nouveauxCandidats->isEmpty())
            <div class="al-empty">✅ Aucune nouvelle inscription récente.</div>
        @else
        <table class="al-table">
            <thead><tr><th>Candidat</th><th>Téléphone</th><th>Inscrit</th></tr></thead>
            <tbody>
                @foreach($nouveauxCandidats as $c)
                <tr>
                    <td class="al-name">🆕 {{ $c->nom }} {{ $c->prenom }}</td>
                    <td class="al-dim">{{ $c->telephone ?? '—' }}</td>
                    <td class="al-dim">{{ \Carbon\Carbon::parse($c->created_at)->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 2) Candidats sans évaluation --}}
    <div class="al-section">
        <div class="al-head">
            <div class="al-head-left">
                <div class="al-badge">2</div>
                <h2 class="al-section-title">⏰ Candidats sans évaluation depuis +{{ \App\Http\Controllers\AlerteController::JOURS_SANS_EVALUATION }} jours</h2>
            </div>
            <span class="al-count-pill">{{ $candidatsSansEvaluation->count() }}</span>
        </div>
        @if($candidatsSansEvaluation->isEmpty())
            <div class="al-empty">✅ Aucun candidat en attente d'évaluation depuis trop longtemps.</div>
        @else
        <table class="al-table">
            <thead><tr><th>Candidat</th><th>Inscrit depuis</th><th>Statut</th></tr></thead>
            <tbody>
                @foreach($candidatsSansEvaluation as $c)
                <tr>
                    <td class="al-name">👤 {{ $c->nom }} {{ $c->prenom }}</td>
                    <td class="al-dim">{{ \Carbon\Carbon::parse($c->created_at)->diffForHumans() }}</td>
                    <td><span class="al-status-pill">{{ $c->statut_label ?? $c->statut }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 3) Évaluation ancienne --}}
    <div class="al-section">
        <div class="al-head">
            <div class="al-head-left">
                <div class="al-badge">3</div>
                <h2 class="al-section-title">📋 Candidats sans nouvelle note depuis +{{ \App\Http\Controllers\AlerteController::JOURS_SANS_EVALUATION }} jours</h2>
            </div>
            <span class="al-count-pill">{{ $candidatsEvaluationAncienne->count() }}</span>
        </div>
        @if($candidatsEvaluationAncienne->isEmpty())
            <div class="al-empty">✅ Toutes les évaluations sont à jour.</div>
        @else
        <table class="al-table">
            <thead><tr><th>Candidat</th><th>Dernière évaluation</th><th>Statut</th></tr></thead>
            <tbody>
                @foreach($candidatsEvaluationAncienne as $c)
                @php $derniere = $c->evaluations->max('dateEvaluation'); @endphp
                <tr>
                    <td class="al-name">👤 {{ $c->nom }} {{ $c->prenom }}</td>
                    <td class="al-dim">{{ $derniere ? \Carbon\Carbon::parse($derniere)->format('d/m/Y') . ' (' . \Carbon\Carbon::parse($derniere)->diffForHumans() . ')' : '—' }}</td>
                    <td><span class="al-status-pill">{{ $c->statut }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 4) Sessions ouvertes depuis trop longtemps --}}
    <div class="al-section">
        <div class="al-head">
            <div class="al-head-left">
                <div class="al-badge">4</div>
                <h2 class="al-section-title">🔓 Sessions ouvertes depuis +{{ \App\Http\Controllers\AlerteController::JOURS_SESSION_OUVERTE }} jours (à clôturer)</h2>
            </div>
            <span class="al-count-pill">{{ $sessionsAOuvertesLongtemps->count() }}</span>
        </div>
        @if($sessionsAOuvertesLongtemps->isEmpty())
            <div class="al-empty">✅ Aucune session bloquée trop longtemps.</div>
        @else
        <table class="al-table">
            <thead><tr><th>Date ouverture</th><th>Groupe</th><th>Moniteur</th><th>Candidats</th></tr></thead>
            <tbody>
                @foreach($sessionsAOuvertesLongtemps as $s)
                <tr>
                    <td class="al-name">
                        📅 {{ \Carbon\Carbon::parse($s->dateDebut)->format('d/m/Y') }}
                        <div style="font-size:0.72rem; color:var(--color-gold); font-weight:600; margin-top:2px;">{{ \Carbon\Carbon::parse($s->dateDebut)->diffForHumans() }}</div>
                    </td>
                    <td class="al-dim">{{ $s->groupe->nomGroupe ?? '—' }}</td>
                    <td class="al-dim">{{ $s->moniteur ? $s->moniteur->nom.' '.$s->moniteur->prenom : '—' }}</td>
                    <td style="text-align:center; font-weight:700;">{{ $s->candidats->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 5) Candidats admis sans attestation --}}
    <div class="al-section">
        <div class="al-head">
            <div class="al-head-left">
                <div class="al-badge">5</div>
                <h2 class="al-section-title">🏆 Candidats admis sans attestation</h2>
            </div>
            <span class="al-count-pill">{{ $candidatsAdmisSansAttestation->count() }}</span>
        </div>
        @if($candidatsAdmisSansAttestation->isEmpty())
            <div class="al-empty">✅ Tous les candidats admis ont leur attestation.</div>
        @else
        <table class="al-table">
            <thead><tr><th>Candidat</th><th>Admis depuis</th></tr></thead>
            <tbody>
                @foreach($candidatsAdmisSansAttestation as $c)
                <tr>
                    <td class="al-name">🏆 {{ $c->nom }} {{ $c->prenom }}</td>
                    <td class="al-dim">{{ \Carbon\Carbon::parse($c->updated_at)->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 6) Candidats ajournés --}}
    <div class="al-section">
        <div class="al-head">
            <div class="al-head-left">
                <div class="al-badge">6</div>
                <h2 class="al-section-title">❌ Candidats ajournés (à replanifier)</h2>
            </div>
            <span class="al-count-pill">{{ $candidatsAjournes->count() }}</span>
        </div>
        @if($candidatsAjournes->isEmpty())
            <div class="al-empty">✅ Aucun candidat ajourné en attente.</div>
        @else
        <table class="al-table">
            <thead><tr><th>Candidat</th><th>Ajourné depuis</th></tr></thead>
            <tbody>
                @foreach($candidatsAjournes as $c)
                <tr>
                    <td class="al-name">❌ {{ $c->nom }} {{ $c->prenom }}</td>
                    <td class="al-dim">{{ \Carbon\Carbon::parse($c->updated_at)->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
</x-layouts::app>